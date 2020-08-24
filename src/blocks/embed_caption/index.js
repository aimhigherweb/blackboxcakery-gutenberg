import { registerBlockType } from '@wordpress/blocks';
import { RichText, InnerBlocks } from '@wordpress/block-editor';


const EmbedCaption = () => {
	registerBlockType('aimhigher/embed-caption', {
		title: 'Embed Caption',
		icon: 'format-video',
		category: 'common',
		attributes: {
			caption: {
				type: 'string',
				selector: 'figcaption',
				source: 'html'
			}
		},
		edit(props) {

			return (
				<div className="media-caption" id="block-editable-box">
					<InnerBlocks />
					<label>Caption</label>
					<RichText
						tagName="figcaption"
						multiline="p"
						value={props.attributes.caption}
						onChange={(text) => { props.setAttributes({ caption: text }) }}
					/>
				</div>
			);
		},

		save(props) {
			return (
				<figure>
					<InnerBlocks.Content />
					<RichText.Content tagName="figcaption" value={props.attributes.caption} />
				</figure>
			);

		},
	});
}

export default EmbedCaption