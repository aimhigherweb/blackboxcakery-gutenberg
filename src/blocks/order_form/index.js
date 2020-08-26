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
			attributes: {
				type: 'array',
				default: []
			}
		},
		edit: class extends Component {
			constructor(props) {
				super(...arguments)
				this.props = props
				this.state = {
					options: []
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

				WooCommerce.get('products/attributes').then(res => {
					const options = this.state.options

					res.data.forEach(att => {
						apiFetch({ path: `/bbc/v1/attributes/${att.slug}` }).then(terms => {
							options.push({ ...att, terms })
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
						{/* <pre>{JSON.stringify(this.state.options)}</pre> */}
						<ul>
							{this.state.options.map(opt => (
								<li>
									{opt.name}
									<ul>
										{opt.terms.map(term => (
											<li>
												{term.name}
												<img src={term.image.sizes.thumbnail} />
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
			return (
				<div className="order-form">
					<div>
						<div>Gallery</div>

						<p className="price"><span><span>$</span>150</span></p>

						<div className="description">
							<p>Description</p>
							<div className="flavour description">
								<p>Flavour descriptions</p>
							</div>
						</div>


						<form className="cart" action="https://blackboxcakery.com.au/shop/cakes/" method="post" enctype="multipart/form-data">
							<legend>Flavours</legend>
							<fieldset>
								<input name="flavours" id="" value="choc-caramel" type="radio" />
								<label for="">Choc-Caramel</label>
							</fieldset>

							<legend>Flavours</legend>
							<fieldset>
								<input name="decorations" id="" value="confectionary" type="radio" />
								<label for="">Confectionary</label>
							</fieldset>

							<legend>Cake Size</legend>
							<fieldset>
								<input name="size" id="" value="small" type="radio" />
								<label for="">Small</label>
							</fieldset>

							<legend>Gluten Free</legend>
							<fieldset>
								<input name="gluten" id="" value="small" type="checkbox" />
								<label for="">Gluten Free</label>
							</fieldset>

							<label>Are there any allergies we need to be aware of?</label>
							<input type="text" />

							<label>What's the Occasion?</label>
							<input type="text" placeholder="Birthday, Anniversay, Tuesday, etc" />

							<label>Incorporate a favourite colour?</label>
							<input type="text" />

							<label>Message for Gift Tag</label>
							<input type="text" />

							<dl>
								<dt>Product Price:</dt>
								<dd>$<span>0.00</span></dd>
								<dt>Options Price:</dt>
								<dd>$<span>0.00</span></dd>
								<dt>Total:</dt>
								<dd>$<span>0.00</span></dd>
							</dl>

							<button type="submit" name="add-to-cart" value="49" className="single_add_to_cart_button button alt">Add to cart</button>

						</form>



					</div>
				</div>
			);
		},
	});
}

export default OrderForm