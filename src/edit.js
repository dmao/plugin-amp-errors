/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Internal block libraries.
 */
/**
 * Destructure ServerSideRender.
 */
const { ServerSideRender } = wp.editor;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, PanelRow, FormToggle } = wp.components;

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @param {Object} [props]           Properties passed from the editor.
 * @param {string} [props.className] Class name generated for the block.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( props ) {
	const { attributes: { ampMode }, setAttributes } = props;
	const toggleAmpMode = () => setAttributes( { ampMode: ! ampMode } );

	return (
		<div>
			<InspectorControls>
				<PanelBody
					title={ __( 'Additional Statistics', 'create-block' ) }
					initialOpen={true}
				>
					<PanelRow>
					 	<FormToggle
							id="display-amp-mode-toggle"
							label={ __( 'Display AMP template mode', 'create-block' ) }
							checked={ ampMode }
							onChange={ toggleAmpMode }
						/>
            <label
              htmlFor="display-amp-mode-toggle"
            >
							{ __( 'Display AMP template mode', 'create-block' ) }
						</label>
					</PanelRow>
				</PanelBody>
			</InspectorControls>,
			<div className={ props.className }>
				<ServerSideRender
					block="create-block/amp-validation-statistics"
					attributes= { props.attributes }
				/>
			</div>
		</div>
	);
}
