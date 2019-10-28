<?php

/**
 * Fired during plugin activation.
 *
 * @since      1.0.0
 * @package    APS_Content_Moderator
 * @subpackage APS_Content_Moderator/includes
 * @author     Niko <hal@aipowered.solutions>
 */
if (!class_exists('APS_Content_Moderator_Activator')) {
	class APS_Content_Moderator_Activator {

		/**
		 *
		 * @since    1.0.0
		 */
		public static function activate() {
            // set some default settings
            update_option('aps-content-moderator-cm-settings-data_access_url',
                'https://ai-powered-content-moderator.p.rapidapi.com/text');
            update_option('aps-content-moderator-cm-settings_category1-value', '0.25');
            update_option('aps-content-moderator-cm-settings_category2-value', '0.25');
            update_option('aps-content-moderator-cm-settings_category3-value', '0.25');
            update_option('aps-content-moderator-cm-settings_comment-threshold', 1);
            update_option('aps-content-moderator-cm-settings_comment-max-length-note', 1);
            update_option('aps-content-moderator-cm-settings_comment-field-id', '#commentform #comment');
		}

	}
}
