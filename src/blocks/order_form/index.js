import { registerBlockType } from '@wordpress/blocks';
import { Component } from '@wordpress/element';
import { RichText, MediaUpload, InspectorControls, BlockControls } from '@wordpress/block-editor';
import { Button, PanelBody, IconButton, TextControl, SelectControl } from '@wordpress/components';
import WooCommerceRestApi from '@woocommerce/woocommerce-rest-api'
import apiFetch from '@wordpress/api-fetch'
import Form from './form'

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
							},
							gluten_free: {
								type: 'boolean',
								source: 'attribute',
								attribute: 'data-gf'
							}
						}
					},
				}
			},
			cakes: {
				type: 'array',
				default: [],
				source: 'query',
				selector: 'form fieldset.cake-size input',
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
					price: {
						type: 'number',
						source: 'attribute',
						attribute: 'data-price'
					},
					size: {
						type: 'string',
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
				selector: '.gallery img',
				default: [],
				source: 'query',
				query: {
					image: {
						type: 'string',
						source: 'attribute',
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


					res.data.forEach(opt => {
						let optExists = false

						cakes.some((cake, index) => {
							if (opt.slug == cake.slug) {
								cakes[index] = {
									...opt,
									size: opt.acf.size
								}
								optExists = true
								return true
							}
						})

						if (!optExists) {
							cakes.push({
								...opt,
								size: opt.acf.size
							})
						}

						opt.images.forEach(img => {
							let added = false

							gallery.some(galImg => {
								if (galImg.image == img.src.replace('.jpg', '-600x375.jpg')) {
									added = true
									return true
								}
							})

							if (!added) {

								if (RegExp(/(\d)+x(\d)+.jpg$/).test(img.src)) {
									return
								}

								gallery.push({
									image: img.src.replace('.jpg', '-600x375.jpg')
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
			return <Form {...props.attributes} />
		},
	});
}

export default OrderForm