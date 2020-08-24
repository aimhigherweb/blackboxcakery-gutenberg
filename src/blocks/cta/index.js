import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { ColorPalette, TextControl } from '@wordpress/components';


const CTA = () => {
	registerBlockType('aimhigher/cta', {
		title: 'Call to Action',
		icon: 'megaphone',
		category: 'common',
		attributes: {
			text: {
				type: 'string',
				selector: '.cta span',
				source: 'text'
			},
			cta_text: {
				type: 'string',
				selector: '.cta a',
				source: 'text'
			},
			cta_url: {
				type: 'string',
				selector: '.cta a',
				source: 'attribute',
				attribute: 'href'
			},
			backgroundColour: {
				type: 'string',
				default: '#10bdc8'
			},
			textColour: {
				type: 'string',
				default: '#ffffff'
			},
		},
		edit(props) {
			const colours = [
				{
					name: 'Aqua',
					slug: 'aqua',
					color: '#10bdc8',
				},
				{
					name: 'Purple',
					slug: 'purple',
					color: '#92278f',
				},
				{
					name: 'Grey',
					slug: 'grey',
					color: '#58595c'
				},
				{
					name: 'Black',
					slug: 'black',
					color: '#000000',
				},
				{
					name: 'White',
					slug: 'white',
					color: '#ffffff',
				},
			];

			let backgroundColour = props.attributes.backgroundColour,
				textColour = props.attributes.textColour,
				styles = {
					'--backgroundColour': backgroundColour || '#10bdc8',
					'--textColour': textColour || '#ffffff'
				}

			return (
				<div className="cta" id="block-editable-box" style={styles}>
					{
						<InspectorControls>
							<h2>Colour settings</h2>
							<h3>Background Colour</h3>
							<ColorPalette
								colors={colours}
								value={backgroundColour}
								disableCustomColors='true'
								onChange={(e) => {
									props.setAttributes({ backgroundColour: e })
								}}
							/>
							<h3>Text Colour</h3>
							<ColorPalette
								colors={colours}
								value={textColour}
								disableCustomColors='true'
								onChange={(e) => {
									props.setAttributes({ textColour: e })
								}}
							/>
						</InspectorControls>
					}
					<div className="sample">
						Text <a href="#">Button</a>
					</div>
					<label>Text</label>
					<TextControl
						value={props.attributes.text}
						onChange={(text) => { props.setAttributes({ text: text }) }}
					/>
					<label>CTA Text</label>
					<TextControl
						value={props.attributes.cta_text}
						onChange={(cta_text) => { props.setAttributes({ cta_text: cta_text }) }}
					/>
					<label>CTA Url</label>
					<TextControl
						value={props.attributes.cta_url}
						onChange={(cta_url) => { props.setAttributes({ cta_url: cta_url }) }}
					/>
				</div>
			);
		},

		save(props) {
			let backgroundColour = props.attributes.backgroundColour,
				textColour = props.attributes.textColour,
				styles = {
					'--backgroundColour': backgroundColour || '#10bdc8',
					'--textColour': textColour || '#ffffff'
				}

			return (
				<div className="cta" style={styles}>
					<p>
						<span>{props.attributes.text}</span>
						<a href={props.attributes.cta_url}>{props.attributes.cta_text}</a>
					</p>
				</div>
			);

		},
	});
}

export default CTA