import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, MediaUpload } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

const GridContainer = () => {
	registerBlockType('aimhigher/grid-container', {
		title: 'Grid Container',
		icon: 'screenoptions',
		category: 'layout',
		edit(props) {
			return (
				<div className="grid-container">
					<InnerBlocks />
				</div>
			);
		},

		save(props) {
			return (
				<div className="grid-container">
					<InnerBlocks.Content />
				</div>
			);

		},
	});
}

export default GridContainer
