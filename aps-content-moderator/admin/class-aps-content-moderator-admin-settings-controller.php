<?php

if (!class_exists('APS_Content_Moderator_Admin_SettingsController')) {
    class APS_Content_Moderator_Admin_SettingsController
    {

        public function update()
        {

            // First, validate the nonce and verify the user as permission to save.
            if (!($this->has_valid_nonce() && current_user_can('manage_options'))) {
                die('Error');
            }

            // If the above are valid, sanitize and save the options.
            $accessKey = sanitize_text_field($_POST['aps-content-moderator-cm-settings-data_access_key']);
            update_option('aps-content-moderator-cm-settings-data_access_key', $accessKey);
            $accessUrl = sanitize_text_field($_POST['aps-content-moderator-cm-settings-data_access_url']);
            update_option('aps-content-moderator-cm-settings-data_access_url', $accessUrl);
            // classification category1 slider
            if (isset($_POST['aps-content-moderator-cm-settings_category1-value'])) {
                $category1 = sanitize_text_field($_POST['aps-content-moderator-cm-settings_category1-value']);
                update_option('aps-content-moderator-cm-settings_category1-value', $category1);
            }
            // classification category1 slider
            if (isset($_POST['aps-content-moderator-cm-settings_category2-value'])) {
                $category2 = sanitize_text_field($_POST['aps-content-moderator-cm-settings_category2-value']);
                update_option('aps-content-moderator-cm-settings_category2-value', $category2);
            }
            // classification category1 slider
            if (isset($_POST['aps-content-moderator-cm-settings_category3-value'])) {
                $category3 = sanitize_text_field($_POST['aps-content-moderator-cm-settings_category3-value']);
                update_option('aps-content-moderator-cm-settings_category3-value', $category3);
            }
            // ignore pii checkbox
            if (isset($_POST['aps-content-moderator-cm-settings_ignore-pii'])) {
                $ignorePii = sanitize_text_field($_POST['aps-content-moderator-cm-settings_ignore-pii']);
                if ($ignorePii == 'on') {
                    update_option('aps-content-moderator-cm-settings_ignore-pii', 1);
                }
            } else {
                update_option('aps-content-moderator-cm-settings_ignore-pii', 0);
            }
            // comment max length checkbox
            if (isset($_POST['aps-content-moderator-cm-settings_comment-threshold'])) {
                $commentThreshold = sanitize_text_field($_POST['aps-content-moderator-cm-settings_comment-threshold']);
                if ($commentThreshold == 'on') {
                    update_option('aps-content-moderator-cm-settings_comment-threshold', 1);
                }
            } else {
                update_option('aps-content-moderator-cm-settings_comment-threshold', 0);
            }
            // comment max length note checkbox
            if (isset($_POST['aps-content-moderator-cm-settings_comment-max-length-note'])) {
                $commentThreshold = sanitize_text_field($_POST['aps-content-moderator-cm-settings_comment-max-length-note']);
                if ($commentThreshold == 'on') {
                    update_option('aps-content-moderator-cm-settings_comment-max-length-note', 1);
                }
            } else {
                update_option('aps-content-moderator-cm-settings_comment-max-length-note', 0);
            }
            // comment field id
            if (isset($_POST['aps-content-moderator-cm-settings_comment-field-id'])) {
                $commentFieldId = sanitize_text_field($_POST['aps-content-moderator-cm-settings_comment-field-id']);
                update_option('aps-content-moderator-cm-settings_comment-field-id', $commentFieldId);
            }

            $this->redirect();
        }

        /**
         * Determines if the nonce variable associated with the options page is set
         * and is valid.
         *
         * @access private
         *
         * @return boolean False if the field isn't set or the nonce value is invalid;
         *                 otherwise, true.
         */
        private function has_valid_nonce()
        {

            // If the field isn't even in the $_POST, then it's invalid.
            if (!isset($_POST['aipwrd-settings-save_nonce'])) { // Input var okay.
                return false;
            }

            $field = wp_unslash($_POST['aipwrd-settings-save_nonce']);
            $action = 'aipwrd-settings-save';

            return wp_verify_nonce($field, $action);
        }

        /**
         * Redirect to the page from which we came (which should always be the
         * admin page. If the referred isn't set, then we redirect the user to
         * the login page.
         *
         * @access private
         */
        private function redirect()
        {
            // To make the Coding Standards happy, we have to initialize this.
            if (!isset($_POST['_wp_http_referer'])) { // Input var okay.
                $_POST['_wp_http_referer'] = wp_login_url();
            }

            // Sanitize the value of the $_POST collection for the Coding Standards.
            $url = sanitize_text_field(
                wp_unslash($_POST['_wp_http_referer']) // Input var okay.
            );

            // redirect back to the admin page.
            wp_safe_redirect(urldecode($url));
            exit;
        }
    }
}
