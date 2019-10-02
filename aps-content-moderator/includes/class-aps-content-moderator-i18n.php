<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    APS_Content_Moderator
 * @subpackage APS_Content_Moderator/includes
 * @author     Niko <hal@aipowered.solutions>
 */
if (!class_exists('APS_Content_Moderator_i18n')) {
	class APS_Content_Moderator_i18n {


		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since    1.0.0
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain(
				APS_Content_Moderator::PLUGIN_NAME,
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);

		}
	}
}
