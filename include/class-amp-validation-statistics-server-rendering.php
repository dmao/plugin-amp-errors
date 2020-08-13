<?php
/**
 * Check for Existing Implementations
 *
 * @package         Amp_Validation_Statistics
 */

if ( ! class_exists( 'Amp_Validation_Statistics_Server_Rendering' ) ) {
	/**
	 * Text Domain:     amp-validation-stats
	 *
	 * @package         Amp_Validation_Statistics
	 */
	class Amp_Validation_Statistics_Server_Rendering {
		/**
		 * Get the count of url validated by AMP plugin.
		 *
		 * @package         Amp_Validation_Statistics
		 * @var             Display amp mode usage.
		 */
		public $amp_mode;
		private $url_count;

		/**
		 * Get the count of url validated by AMP plugin.
		 *
		 * @package         Amp_Validation_Statistics
		 */
		public static function get_url_count() {
			$url_count = wp_count_posts( 'amp_validated_url' )->publish;
			return $url_count;
		}

		/**
		 * Get the count of errors found by AMP plugin.
		 *
		 * @package         Amp_Validation_Statistics
		 */
		public static function get_error_count() {
			$args        = array( 'taxonomy' => 'amp_validation_error' );
			$terms       = get_terms( 'amp_validation_error', $args );
			$error_count = count( $terms );
			return $error_count;
		}

		/**
		 * Get the count of errors found by AMP plugin.
		 *
		 * @package         Amp_Validation_Statistics
		 */
		public static function get_template_mode() {
			if ( class_exists( 'AMP_Theme_Support' ) ) {
				return AMP_Theme_Support::get_support_mode();
				// if ( AMP_Theme_Support::TRANSITIONAL_MODE_SLUG ) {
				// 	$template_mode = 'transititional';
				// 	return $template_mode;
				// } elseif ( AMP_Theme_Support::STANDARD_MODE_SLUG ) {
				// 	$template_mode = 'standard';
				// 	return $template_mode;
				// }
			}
		}
	}
}
