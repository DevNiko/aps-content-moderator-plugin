<?php
if (!class_exists('APS_Content_Moderator_Admin_CommentController')) {
    class APS_Content_Moderator_Admin_CommentController
    {

        public function edit()
        {
            $comment_id = absint($_GET['c']);

            if (is_null($comment_id)) {
                return;
            }

            $comment = get_comment($comment_id);
            if (!$comment) {
                return;
            }

            $comment = get_comment_to_edit($comment_id);
            $this->comment_meta = get_comment_meta($comment_id, 'CmTextResult', true);
            if (!$this->comment_meta) {
                return;
            }

            $this->comment_meta['comment_id'] = $comment_id;

            wp_enqueue_script(
                APS_Content_Moderator::PLUGIN_NAME . '-mark.js',
                plugin_dir_url(__FILE__) . 'js/aps-content-moderator-admin-mark.js',
                array(APS_Content_Moderator::PLUGIN_NAME),
                null, false);

            wp_enqueue_script(
                APS_Content_Moderator::PLUGIN_NAME . '-commentedit',
                plugin_dir_url(__FILE__) . 'js/aps-content-moderator-admin-commentedit.js',
                array(APS_Content_Moderator::PLUGIN_NAME),
                APS_Content_Moderator::PLUGIN_VERSION, false);

            wp_localize_script(APS_Content_Moderator::PLUGIN_NAME . '-commentedit', 'aps_comment_meta_data',
                $this->comment_meta);

            $wp_scripts = wp_scripts();
            wp_enqueue_style(
                'jquery-ui-theme-smoothness',
                plugin_dir_url(__FILE__) . 'css/aipwr-solutions-admin-jqueryui.css',
                false,
                APS_Content_Moderator::PLUGIN_VERSION
            );

            wp_enqueue_script('jquery-ui-accordion');

            add_action('add_meta_boxes', array('APS_Content_Moderator_Admin_Partials_CommentMetaBox', 'add'), 10, 0);
        }
    }
}
