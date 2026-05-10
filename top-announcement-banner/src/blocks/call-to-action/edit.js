import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	URLInput,
} from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

/**
 * @param {Object}   props
 * @param {Object}   props.attributes
 * @param {Function} props.setAttributes
 */
export default function Edit( { attributes, setAttributes } ) {
	const { title, buttonText, buttonUrl } = attributes;
	const blockProps = useBlockProps( {
		className: 'wp-block-wp-ai-kit-call-to-action',
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button', 'top-announcement-banner' ) }>
					<PanelRow>
						<fieldset style={ { width: '100%' } }>
							<legend className="blocks-base-control__label">
								{ __( 'Button URL', 'top-announcement-banner' ) }
							</legend>
							<URLInput
								value={ buttonUrl }
								onChange={ ( url ) =>
									setAttributes( { buttonUrl: url } )
								}
							/>
						</fieldset>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<RichText
					tagName="h2"
					className="wp-block-wp-ai-kit-call-to-action__title"
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					placeholder={ __(
						'Call to action title…',
						'top-announcement-banner'
					) }
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
				/>

				<div className="wp-block-wp-ai-kit-call-to-action__button-wrap">
					<RichText
						tagName="span"
						className="wp-block-wp-ai-kit-call-to-action__button"
						value={ buttonText }
						onChange={ ( value ) =>
							setAttributes( { buttonText: value } )
						}
						placeholder={ __(
							'Button text…',
							'top-announcement-banner'
						) }
						allowedFormats={ [] }
					/>
				</div>
			</div>
		</>
	);
}
