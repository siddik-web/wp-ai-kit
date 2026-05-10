import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * @param {Object} props
 * @param {Object} props.attributes
 */
export default function Save( { attributes } ) {
	const { title, buttonText, buttonUrl } = attributes;
	const blockProps = useBlockProps.save( {
		className: 'wp-block-wp-ai-kit-call-to-action',
	} );

	return (
		<div { ...blockProps }>
			<RichText.Content
				tagName="h2"
				className="wp-block-wp-ai-kit-call-to-action__title"
				value={ title }
			/>

			{ buttonText && (
				<div className="wp-block-wp-ai-kit-call-to-action__button-wrap">
					<a
						href={ buttonUrl || '#' }
						className="wp-block-wp-ai-kit-call-to-action__button"
					>
						<RichText.Content value={ buttonText } />
					</a>
				</div>
			) }
		</div>
	);
}
