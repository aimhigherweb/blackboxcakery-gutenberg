import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, MediaUpload } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

const ImageContainer = () => {
	registerBlockType('aimhigher/image-container', {
		title: 'Image Container',
		icon: 'align-center',
		category: 'layout',
		attributes: {
			background: {
				type: 'string',
				default: false
			},
		},
		edit(props) {
			let background = props.attributes.background,
				styles = {}

			if (background) {
				styles = { '--backgroundImage': `url(${background})` }
			}


			return (
				<div className="image-container" style={styles}>
					<div className="container">
						<label>Background Image</label>
						<MediaUpload
							onSelect={(newBackground) => { props.setAttributes({ background: newBackground.url }) }}
							allowedTypes="image"
							value={!background ? 'Select Image' : background}
							render={({ open }) => (
								<Button onClick={open}>
									{!background ? 'Upload Image' : 'Change Image'}
								</Button>
							)}
						/>
						<InnerBlocks />
					</div>
				</div>
			);
		},

		save(props) {
			let background = props.attributes.background,
				styles = {}

			if (background) {
				styles = { '--backgroundImage': `url(${background})` }
			}

			return (
				<div className="image-container" style={styles}>
					<div className="container">
						<InnerBlocks.Content />
					</div>
				</div>
			);

		},
	});
}

export default ImageContainer
