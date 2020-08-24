import { registerBlockType } from '@wordpress/blocks';
import { RichText, MediaUpload, InspectorControls, BlockControls } from '@wordpress/block-editor';
import { Button, PanelBody, IconButton, TextControl, SelectControl } from '@wordpress/components';


const Banner = () => {
	registerBlockType('aimhigher/banner', {
		title: 'Banner',
		icon: 'align-center',
		category: 'common',
		attributes: {
			text: {
				type: 'string',
				selector: '.banner blockquote',
				source: 'text'
			},
			cta_text: {
				type: 'string',
				selector: '.cta',
				source: 'text'
			},
			cta_url: {
				type: 'string',
				selector: '.cta',
				source: 'attribute',
				attribute: 'href'
			},
			image: {
				type: 'string',
			},
		},
		edit(props) {
			let banner = props.attributes.image,
				styles = {}

			if (banner) {
				styles = { '--bannerImage': `url(${banner})` }
			}

			return (
				<div className="banner" id="block-editable-box" style={styles}>
					<label>Banner Text</label>
					<TextControl
						value={props.attributes.text}
						onChange={(text) => { props.setAttributes({ text: text }) }}
					/>
					<label>Image</label>
					<MediaUpload
						onSelect={(newBanner) => { props.setAttributes({ image: newBanner.url }) }}
						allowedTypes="image"
						value={banner == undefined ? 'Select Image' : banner}
						render={({ open }) => (
							<Button onClick={open}>
								{banner == undefined ? 'Upload Image' : <img src={banner} />}
							</Button>
						)}
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
			let banner = props.attributes.image,
				styles = {}

			if (banner) {
				styles = { '--bannerImage': `url(${banner})` }
			}

			console.log(props.attributes)

			return (
				<div className="banner" style={styles}>
					{props.attributes.text && <blockquote>{props.attributes.text}</blockquote>}
					{props.attributes.cta_text && <a href={props.attributes.cta_url} className="btn cta">{props.attributes.cta_text}</a>}
				</div>
			);

		},
	});
}

export default Banner