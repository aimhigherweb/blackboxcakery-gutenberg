import { registerBlockType } from '@wordpress/blocks';
import { Component } from '@wordpress/element';
import { RichText, MediaUpload, InspectorControls, BlockControls } from '@wordpress/block-editor';
import { Button, PanelBody, IconButton, TextControl, SelectControl } from '@wordpress/components';
import WooCommerceRestApi from '@woocommerce/woocommerce-rest-api'
import apiFetch from '@wordpress/api-fetch'

const OrderForm = () => {
	registerBlockType('aimhigher/order-form', {
		title: 'Order Form',
		icon: 'feedback',
		category: 'widget',
		attributes: {
			options: {
				type: 'array',
				default: [],
				source: 'query',
				selector: 'form .options fieldset',
				query: {
					name: {
						type: 'string',
						selector: 'legend',
						source: 'text'
					},
					slug: {
						type: 'string',
						selector: 'legend',
						source: 'attribute',
						attribute: 'data-slug'
					},
					terms: {
						type: 'string',
						default: [],
						source: 'query',
						selector: 'input',
						query: {
							name: {
								type: 'string',
								source: 'attribute',
								attribute: 'data-name'
							},
							slug: {
								type: 'string',
								source: 'attribute',
								attribute: 'value'
							},
							image: {
								type: 'string',
								source: 'attribute',
								attribute: 'data-image'
							},
							variation_image: {
								type: 'string',
								source: 'attribute',
								attribute: 'data-variation_image'
							},
							description: {
								type: 'string',
								source: 'attribute',
								attribute: 'data-description'
							}
						}
					},
				}
			},
			cakes: {
				type: 'array',
				default: [],
				source: 'query',
				selector: 'form fieldset.cake-size',
				query: {
					name: {
						type: 'string',
						selector: 'input',
						source: 'attribute',
						attribute: 'data-name'
					},
					slug: {
						type: 'string',
						selector: 'input',
						source: 'attribute',
						attribute: 'value'
					},
					price: {
						type: 'number',
						selector: 'input',
						source: 'attribute',
						attribute: 'data-price'
					},
					size: {
						type: 'string',
						selector: 'input',
						source: 'attribute',
						attribute: 'data-size'
					},
				}
			},
			description: {
				type: 'string',
				selector: '.description.main',
				source: 'html',
				multiline: 'p'
			},
			gallery: {
				type: 'array',
				selector: '.gallery',
				default: [],
				source: 'query',
				query: {
					image: {
						type: 'string',
						source: 'attribute',
						selector: 'img',
						attribute: 'src'
					}
				}
			}
		},
		edit: class extends Component {
			constructor(props) {
				super(...arguments)
				this.props = props
				this.state = {
					options: [],
					cakes: []
				}
			}

			componentDidMount() {
				const WooCommerce = new WooCommerceRestApi({
					url: process.env.WP_URL,
					consumerKey: process.env.WC_KEY,
					consumerSecret: process.env.WC_SECRET,
					version: 'wc/v3',
					queryStringAuth: true
				});

				WooCommerce.get('products').then(res => {
					let { cakes, gallery, description } = this.props.attributes

					console.log(res.data)

					res.data.forEach(opt => {
						cakes.push({
							...opt,
							size: opt.acf.size
						})

						opt.images.forEach(img => {
							let added = false

							gallery.some(galImg => {
								if (galImg.image == img.src) {
									added = true
									return true
								}
							})

							if (!added) {

								if (RegExp(/(\d)+x(\d)+.jpg$/).test(img.src)) {
									return
								}

								gallery.push({
									image: img.src
								})
							}
						})

						if (opt.slug == 'cake-large') {
							description = opt.short_description
						}
					})

					this.setState({
						cakes
					})

					this.props.setAttributes({
						cakes,
						description,
						gallery
					})
				})

				WooCommerce.get('products/attributes').then(res => {
					const options = this.props.attributes.options

					res.data.forEach(att => {
						apiFetch({ path: `/bbc/v1/attributes/${att.slug}` }).then(terms => {
							const termItems = []
							let optExists = false

							terms.forEach(term => {
								termItems.push({
									...term,
									image: term.image.sizes.shop_thumbnail,
									variation_image: term.variation_image.sizes.medium_large
								})
							})

							options.some(opt => {
								if (opt.slug == att.slug) {
									opt = { ...att, terms: termItems }
									optExists = true
									return true
								}
							})

							if (!optExists) {
								options.push({ ...att, terms: termItems })
							}
						})
					})

					this.setState({
						options
					})

					this.props.setAttributes({
						options
					})
				})
			}

			render() {
				console.log(this.props.attributes.gallery)
				return (
					<div className="order-form" id="block-editable-box">
						<h1>Order Form</h1>
						<ul>
							{this.state.options.map(opt => (
								<li>
									{opt.name}
									<ul>
										{opt.terms.map(term => (
											<li>
												{term.name}
												<img src={term.image} />
											</li>
										))}
									</ul>
								</li>

							))}
						</ul>
					</div>
				);
			}
		},
		save(props) {
			const { options, cakes, gallery, description } = props.attributes

			options.sort((a, b) => {
				if (a.slug < b.slug) {
					return false
				}
				return true
			})

			return (
				<div className="order-form">
					<div>
						<div className="gallery">
							{gallery.map(img => (
								<img src={img.image.replace('.jpg', '-600x375.jpg')} />
							))}
						</div>

						<div className="description main" dangerouslySetInnerHTML={{ __html: description }} />
						<div className="description pa_flavours"></div>
						<div className="description pa_themes"></div>

						<form className="cake-order" action="/shop/cake-large/" method="post">
							<fieldset className="cake-size">
								<div>
									<legend>Cake Size</legend>
									{cakes.map(opt => (
										<>
											<input
												name="cake_size"
												id={`cake-size_${opt.slug}`}
												value={opt.slug}
												type="radio"
												onClick={`changeCakeSize({id: this.value, price: ${opt.price}})`}
												data-name={opt.name}
												data-price={opt.price}
												data-size={opt.size}
											/>
											<label htmlFor={`cake-size_${opt.slug}`}>{opt.name}</label></>
									))}
								</div>
							</fieldset>

							<div className="options">
								{options.map(opt => (
									<fieldset className={opt.slug}>
										<div>
											<legend data-slug={opt.slug}>{opt.name}</legend>
											{opt.terms.map(term => (
												<>
													<input
														name={opt.slug}
														id={`${opt.slug}-${term.slug}`}
														value={term.slug}
														type="radio"
														data-name={term.name}
														data-variation_image={term.variation_image}
														data-image={term.image}
														data-description={term.description}
													/>
													<label
														htmlFor={`${opt.slug}-${term.slug}`}
														style={{ backgroundImage: `url(${term.image})` }}
													>
														<span>{term.name}</span>
													</label>
												</>
											))}
										</div>
									</fieldset>
								))}
							</div>

							<fieldset>
								<div>
									<legend>Gluten Free?</legend>
									<input type="radio" id="custom_add_gluten_free_yes" value="yes" name="custom_add_gluten_free" />
									<label for="custom_add_gluten_free_yes">Yes</label>
									<input type="radio" id="custom_add_gluten_free_no" value="no" name="custom_add_gluten_free" checked />
									<label for="custom_add_gluten_free_yes">No</label>
								</div>
							</fieldset>

							<label htmlFor="custom_add_allergies">Are there any allergies we need to be aware of?</label>
							<input type="text" id="custom_add_allergies" name="custom_add_allergies" />

							<label htmlFor="custom_add_occasion">What's the Occasion?</label>
							<input type="text" placeholder="Birthday, Anniversay, Tuesday, etc" name="custom_add_occasion" />

							<label for="custom_add_colour">Incorporate a favourite colour?</label>
							<input type="text" id="custom_add_colour" name="custom_add_colour" />

							<label for="custom_add_message">Message for gift tag</label>
							<textarea id="custom_add_message" name="custom_add_message"></textarea>

							<dl>
								<dt>Price:</dt>
								<dd>$<span className="product-price">Select a cake size to view the price</span></dd>
							</dl>

							<button type="submit">Order Cake</button>

						</form>



					</div>
				</div>
			);
		},
	});
}

export default OrderForm