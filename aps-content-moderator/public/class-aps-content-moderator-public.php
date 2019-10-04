<?php

/**
 *
 * @since      1.0.0
 *
 * @package    APS_Content_Moderator
 * @subpackage APS_Content_Moderator/public
 */
if (!class_exists('APS_Content_Moderator_Public')) {
    class APS_Content_Moderator_Public
    {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $plugin_name The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @param string $plugin_name The name of the plugin.
         * @param string $version The version of this plugin.
         * @since    1.0.0
         */
        public function __construct($plugin_name, $version)
        {
            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function enqueue_styles()
        {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/aps-content-moderator-public.css',
                array(),
                $this->version, 'all');
        }

        /**
         * Register the JavaScript for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts()
        {
            global $wp_query;

            $config = array(
                'site_lang' => $this->get_site_lang(),
                'base_url' => get_site_url(),
                'comment_counter_text' => __('1024 of a maximum of 1024 characters left', APS_Content_Moderator::PLUGIN_NAME),
                'js_validation_enabled' => get_option('aps-content-moderator-cm-settings_comment-threshold', 1)
            );

            // only on post pages
            if ($wp_query->get_queried_object_id()) {
                wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/aps-content-moderator-public.js',
                array('jquery'), $this->version, false);
                wp_localize_script($this->plugin_name, 'aps_config', $config);
            }
        }

        public function filter_pre_comment_content($comment_content)
        {
            $commentText = $this->sanitize_comment($comment_content);
            if (strlen($commentText) > 1024 && get_option('aps-content-moderator-cm-settings_comment-threshold', '') == '1') {
                wp_die(__('Comment is too long. Please keep your comment under 1024 characters.<br/><a href="javascript:window.history.back();">back</a>', APS_Content_Moderator::PLUGIN_NAME));
            }

            return $commentText;
        }

        /**
         * @param int $approved
         * @param array $commentdata
         * @return int
         */
        public function filter_pre_comment_approved($approved, $commentData)
        {
            // Check WP Setting: "Comment must be manually approved"
            $manuallApprove = get_option('comment_moderation', '0');
            if ($manuallApprove === '1') {
                return 0;
            }

            if (isset($commentData['comment_meta'])) {

                if (!isset($commentData['comment_meta']['CmTextResult'])) {
                    // something went wrong during the api request, return 0 to be sure.
                    return 0;
                }

                $moderationResult = $commentData['comment_meta']['CmTextResult'];

                $classificationResult = false;
                if ($moderationResult['classification']) {

                    $category1MinValueFits = false;
                    $category2MinValueFits = false;
                    $category3MinValueFits = false;

                    foreach($moderationResult['classification'] as $categoryKey => $data) {
                        if (!isset($data['score'])) {
                            continue;
                        }
                        $score = round($data['score'], 2);
                        if ($categoryKey === 'category1') {
                            $category1DefinedMinValue = get_option('aps-content-moderator-cm-settings_category1-value', 0.00);
                            if ($score >= $category1DefinedMinValue) {
                                $category1MinValueFits = true;
                            }
                        }

                        if ($categoryKey === 'category2') {
                            $category2DefinedMinValue = get_option('aps-content-moderator-cm-settings_category2-value', 0.00);
                            if ($score >= $category2DefinedMinValue) {
                                $category2MinValueFits = true;
                            }
                        }

                        if ($categoryKey === 'category3') {
                            $category3DefinedMinValue = get_option('aps-content-moderator-cm-settings_category3-value', 0.00);
                            if ($score >= $category3DefinedMinValue) {
                                $category3MinValueFits = true;
                            }
                        }
                    }

                    if ($category1MinValueFits === true
                        || $category2MinValueFits === true
                        || $category3MinValueFits === true) {

                        $classificationResult = true;
                    }
                }

                $piiCheck = get_option('aps-content-moderator-cm-settings_ignore-pii', "1");
                if ($piiCheck === "1") {
                    // PII Check is disabled
                    return $classificationResult === true ? 0 : $approved;
                }

                if ($classificationResult === true || $moderationResult['personal_information'] !== 'None') {
                    return 0;
                }

            }

            return $approved;
        }

        /**
         * Extracts all html tags out of the comment text
         * @param string $text
         * @return string
         */
        private function sanitize_comment($text)
        {
            $fullCommentText = wp_html_split($text);
            $clearCommentText = '';

            if (is_array($fullCommentText) && count($fullCommentText) > 0) {
                foreach ($fullCommentText as $textElement) {
                    $htmlRegex = get_html_split_regex();
                    if (!preg_match($htmlRegex, $textElement)) {
                        $clearCommentText .= $textElement;
                    }
                }
            }

            return sanitize_text_field($clearCommentText);
        }

        /**
         * @param array $commentdata
         * @return array
         */
        public function preprocess_comment($commentdata)
        {

            if (!isset($commentdata['comment_content'])) {
                return $commentdata;
            }

            $comment = $this->sanitize_comment($commentdata['comment_content']);
            $commentdata['comment_content'] = $comment;

            $moderateResult = $this->moderate_text_content(
                $comment,
                array(
                    'access_key' => defined('APS_CM_RAPIDAPI_KEY') ? APS_CM_RAPIDAPI_KEY : get_option('aps-content-moderator-cm-settings-data_access_key', false),
                    'access_url' => get_option('aps-content-moderator-cm-settings-data_access_url', false),
                    'site_lang' => $this->get_site_lang()
                )
            );

            $commentdata['comment_meta'] = $moderateResult;

            return $commentdata;
        }

        /**
         * Request the APS Content moderator API and check if there is some unwanted content
         * @param string $comment
         * @param array $settings
         * @return array
         */
        private function moderate_text_content($comment, $settings)
        {
            if (empty($settings)) {
                return array();
            }

            if (!isset($settings['access_key'])) {
                return array();
            }

            if (!isset($settings['access_url'])) {
                return array();
            }

            if (strlen($comment) == 0) {
                return array();
            }

            if (strlen($comment) > 1024) {
                $comment = substr($comment, 0, 1023);
            }

            $requestArgs = array(
                'timeout' => 3,
                'method' => 'POST',
                'headers' => array(
                    'x-rapidapi-host' => $this->get_rapid_api_host(),
                    'x-rapidapi-key' => $settings['access_key'],
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json'
                ),
                'body' => array(
                    'text' => $comment,
                    'translate' => isset($settings['site_lang']) ? $settings['site_lang'] : ''
                )
            );

            $httpRequest = new WP_Http();
            $requestResult = $httpRequest->request($settings['access_url'], $requestArgs);

            if ($requestResult instanceof WP_Error) {
                return array();
            }

            if (!isset($requestResult['response'])) {
                return array();
            }

            if (!isset($requestResult['response']['code'])) {
                return array();
            }

            if (!$requestResult['response']['code'] == 200) {
                return array();
            }

            if (!isset($requestResult['body'])) {
                return array();
            }

            $response = $requestResult['body'];
            $data = json_decode($response, true);

            if (!is_array($data)) {
                return array();
            }

            if (count($data) == 0) {
                return array();
            }

            if (!isset($data['CmTextResult'])) {
                return array();
            }

            return $data;
        }

        private function get_rapid_api_host()
        {
            $host = 'ai-powered-content-moderator.p.rapidapi.com';
            $api_accesss_url = get_option('aps-content-moderator-cm-settings-data_access_url', false);
            $api_accesss_url_parts = explode($api_accesss_url, '/');

            if (is_array($api_accesss_url_parts) && count($api_accesss_url_parts)) {
                if (isset($api_accesss_url_parts[2])) {
                    return $api_accesss_url_parts[2];
                }
            }

            return $host;
        }

        /**
         * Use the site language to create an ISO-639-1 language code
         * @return string
         */
        private function get_site_lang()
        {
            $default = 'de';
            $language = get_site_option('WPLANG');

            if (!$language) {
                return $default;
            }

            $language = explode('_', $language);
            if (is_array($language) && count($language) > 1) {
                return $language[0];
            }

            if (strlen($language) == 2) {
                return $language;
            }

            return $default;
        }
    }
}
