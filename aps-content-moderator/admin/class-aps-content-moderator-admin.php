<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The submenut page class
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-aps-content-moderator-admin-settings-page.php';

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-aps-content-moderator-admin-init-controller.php';

/**
 * The admin options serializer class
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-aps-content-moderator-admin-settings-controller.php';

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-aps-content-moderator-admin-comment-controller.php';

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-comment-meta-box.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    APS_Content_Moderator
 * @subpackage APS_Content_Moderator/admin
 * @author     Niko <hal@aipowered.solutions>
 */
if (!class_exists('APS_Content_Moderator_Admin')) {
    class APS_Content_Moderator_Admin
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
         * @param string $plugin_name The name of this plugin.
         * @param string $version The version of this plugin.
         * @since    1.0.0
         */
        public function __construct($plugin_name, $version)
        {

            $this->plugin_name = $plugin_name;
            $this->version = $version;

            $initController = new APS_Content_Moderator_Admin_InitController();
            add_action('admin_init', array($initController, 'init'));

            $settingsController = new APS_Content_Moderator_Admin_SettingsController();
            add_action('admin_post_update', array($settingsController, 'update'));

            $commentController = new APS_Content_Moderator_Admin_CommentController();
            add_action('admin_action_editcomment', array($commentController, 'edit'));
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles()
        {
            wp_enqueue_style(
                $this->plugin_name . 'aps-admin-style ',
                plugin_dir_url(__FILE__) . 'css/aps-content-moderator-admin.css',
                array(),
                $this->version, 'all'
            );

            wp_enqueue_style(
                $this->plugin_name . '-jqueryui-style',
                plugin_dir_url(__FILE__) . 'css/aps-content-moderator-admin-jqueryui.css',
                array(),
                $this->version, 'all'
            );
        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts()
        {
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/aps-content-moderator-admin.js',
                array('jquery'), $this->version, false);

            wp_enqueue_script( 'jquery-ui-slider');
        }

        /**
         * Creates the submenu item and calls on the Submenu Page object to render
         * the actual contents of the page.
         */
        public function add_options_page()
        {
            $settingsPage = new APS_Content_Moderator_Admin_Settings_Page();
            add_options_page(
                'APS CM',
                'APS Content Moderator',
                'manage_options',
                'aps-content-moderator-cm-admin-page',
                array($settingsPage, 'render')
            );
        }
    }
}
