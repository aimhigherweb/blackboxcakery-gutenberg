import { registerBlockType } from '@wordpress/blocks';
import { RichText, MediaUpload, InspectorControls, BlockControls } from '@wordpress/block-editor';
import { Button, PanelBody, IconButton, TextControl, SelectControl } from '@wordpress/components';


const ImageHeader = () => {
	registerBlockType('aimhigher/image-header', {
		title: 'Image Header',
		icon: 'align-center',
		category: 'common',
		attributes: {
			title: {
				type: 'string',
				selector: '.headings .title',
				source: 'text'
			},
			subtitle: {
				type: 'string',
				selector: '.headings .subtitle',
				source: 'text'
			},
			other_sub: {
				type: 'string',
				selector: '.headings .sub',
				source: 'text'
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
					<label>Header</label>
					<TextControl
						value={props.attributes.title}
						onChange={(text) => { props.setAttributes({ title: text }) }}
					/>
					<label>Subtitle</label>
					<TextControl
						value={props.attributes.subtitle}
						onChange={(text) => { props.setAttributes({ subtitle: text }) }}
					/>
					<label>Other Text</label>
					<TextControl
						value={props.attributes.other_sub}
						onChange={(text) => { props.setAttributes({ other_sub: text }) }}
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
				</div>
			);
		},

		save(props) {
			let banner = props.attributes.image,
				styles = {}

			if (banner) {
				styles = { '--bannerImage': `url(${banner})` }
			}

			return (
				<div className="headings" style={styles}>
					<p className="title">{props.attributes.title}</p>
					<p className="subtitle">{props.attributes.subtitle}</p>
					<p className="sub">{props.attributes.other_sub}</p>
				</div>
			)
		},
	});
}

export default ImageHeader