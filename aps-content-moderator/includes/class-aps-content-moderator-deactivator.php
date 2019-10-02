<?php

/**
 * Fired during plugin deactivation.
 *
 * @since      1.0.0
 * @package    APS_Content_Moderator
 * @subpackage APS_Content_Moderator/includes
 * @author     Your Name <hal@aipowered.solutions>
 */
if (!class_exists('APS_Content_Moderator_Deactivator')) {
	class APS_Content_Moderator_Deactivator {

		/**
		 * @since    1.0.0
		 */
		public static function deactivate() {
            // delete APS CM API key from Database for security reasons
            delete_option('aps-content-moderator-cm-settings-data_access_key');
		}

	}
}
