<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    APS_Content_Moderator
 * @subpackage APS_Content_Moderator/includes
 */
if (!class_exists('APS_Content_Moderator')) {
	class APS_Content_Moderator {

    const PLUGIN_NAME = 'aps-content-moderator';
    const PLUGIN_VERSION = '1.0.1';

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      APS_Content_Moderator_Loader    $loader    Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $version    The current version of the plugin.
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
        public function __construct()
        {
			if ( defined( 'APS_CONTENT_MODERATOR_VERSION' ) ) {
				$this->version = APS_CONTENT_MODERATOR_VERSION;
			} else {
				$this->version = '1.0.0';
			}
			
			if ( defined( 'APS_CONTENT_MODERATOR_PLUGIN_NAME' ) ) {
				$this->plugin_name = APS_CONTENT_MODERATOR_PLUGIN_NAME;
			} else {
				$this->plugin_name = 'aps-content-moderator';
            }

			$this->load_dependencies();
			$this->set_locale();
			$this->admin_hooks();
			$this->public_hooks();
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
		 * - Plugin_Name_i18n. Defines internationalization functionality.
		 * - Plugin_Name_Admin. Defines all hooks for the admin area.
		 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
        private function load_dependencies()
        {
			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aps-content-moderator-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aps-content-moderator-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-aps-content-moderator-admin.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-aps-content-moderator-public.php';

			$this->loader = new APS_Content_Moderator_Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the APS_Content_Moderator_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
        private function set_locale()
        {
			$plugin_i18n = new APS_Content_Moderator_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
        private function admin_hooks()
        {
			$plugin_admin = new APS_Content_Moderator_Admin( $this->get_aps_content_moderator(), $this->get_version() );

			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
            #$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
            $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
        private function public_hooks()
        {

			$plugin_public = new APS_Content_Moderator_Public( $this->get_aps_content_moderator(), $this->get_version() );

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			$this->loader->add_filter( 'pre_comment_content', $plugin_public, 'filter_pre_comment_content', 10, 1);
            $this->loader->add_filter( 'pre_comment_approved', $plugin_public, 'filter_pre_comment_approved', 10, 2);
            $this->loader->add_filter( 'preprocess_comment', $plugin_public, 'preprocess_comment', 10, 1);
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
        public function run()
        {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since     1.0.0
		 * @return    string    The name of the plugin.
		 */
        public function get_aps_content_moderator()
        {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since     1.0.0
		 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
		 */
        public function get_loader()
        {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The version number of the plugin.
		 */
        public function get_version()
        {
			return $this->version;
		}

	}
}
