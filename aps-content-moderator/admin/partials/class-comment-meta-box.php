<?php

abstract class APS_Content_Moderator_Admin_Partials_CommentMetaBox
{

    public static function add()
    {
        add_meta_box(
            APS_Content_Moderator::PLUGIN_NAME . '-comment-meta_box',
            __('APS Content Moderator Result', APS_Content_Moderator::PLUGIN_NAME),
            array('APS_Content_Moderator_Admin_Partials_CommentMetaBox', 'html'),
            'comment',
            'normal'
        );
    }

    public static function html($post)
    {
        $noDataText = __('No moderation data available.');

        if (is_null($post)) {
            echo $noDataText;

            return;
        }

        if (!$post->comment_ID) {
            echo $noDataText;

            return;
        }

        $post_meta = get_comment_meta($post->comment_ID, 'CmTextResult', true);

        if (!is_array($post_meta)) {
          echo $noDataText;

          return;
        }

        if (count($post_meta) == 0) {
          echo $noDataText;

          return;
        }

        include plugin_dir_path(dirname(__FILE__)) . 'views/comment-meta-box.php';

        return;
    }
}
