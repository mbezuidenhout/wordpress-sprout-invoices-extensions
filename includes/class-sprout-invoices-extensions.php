<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/mbezuidenhout/
 * @since      1.0.0
 *
 * @package    Sprout_Invoices_Extensions
 * @subpackage Sprout_Invoices_Extensions/includes
 */

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
 * @package    Sprout_Invoices_Extensions
 * @subpackage Sprout_Invoices_Extensions/includes
 * @author     Marius Bezuidenhout <marius@blackhorse.co.za>
 */
class Sprout_Invoices_Extensions {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sprout_Invoices_Extensions_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	public function __construct() {
		if ( defined( 'SPROUT_INVOICES_EXTENSIONS_VERSION' ) ) {
			$this->version = SPROUT_INVOICES_EXTENSIONS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sprout-invoices-extensions';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sprout_Invoices_Extensions_Loader. Orchestrates the hooks of the plugin.
	 * - Sprout_Invoices_Extensions_i18n. Defines internationalization functionality.
	 * - Sprout_Invoices_Extensions_Admin. Defines all hooks for the admin area.
	 * - Sprout_Invoices_Extensions_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sprout-invoices-extensions-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sprout-invoices-extensions-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sprout-invoices-extensions-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sprout-invoices-extensions-public.php';

		$this->loader = new Sprout_Invoices_Extensions_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sprout_Invoices_Extensions_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sprout_Invoices_Extensions_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sprout_Invoices_Extensions_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_filter( 'si_line_item_types', $plugin_admin, 'add_line_items' );
		$this->loader->add_filter( 'si_line_item_columns', $plugin_admin, 'line_item_columns', 10, 6 );

		$this->loader->add_filter( 'load_view_args_admin/meta-boxes/invoices/information.php', $plugin_admin, 'information_meta_box_args' );
		$this->loader->add_filter( 'load_view_args_admin/meta-boxes/estimates/information.php', $plugin_admin, 'information_meta_box_args' );
		$this->loader->add_filter( 'sprout_state_options', $plugin_admin, 'state_options' );
		$this->loader->add_filter( 'si_admin_settings_input_field', $plugin_admin, 'settings_input_field', 10, 2 );
		$this->loader->add_filter( 'si_client_form_fields', $plugin_admin, 'client_fields' );
		$this->loader->add_filter( 'wp_insert_post_data', $plugin_admin, 'save_fields', 100, 2 );
		$this->loader->add_filter( 'gettext', $plugin_admin, 'change_strings', 10, 3 );
		$this->loader->add_filter( 'si_register_post_type_args-sa_estimate', $plugin_admin, 'change_post_type_name_for_estimates' );
		$this->loader->add_action( 'si_document_client_addy', $plugin_admin, 'add_custom_fields_to_docs' );
		$this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'admin_footer_text' );
		$this->loader->add_filter( 'mce_external_plugins', $plugin_admin, 'tiny_mce_plugins' );
		$this->loader->add_filter( 'mce_buttons_2', $plugin_admin, 'tiny_mce_buttons', 10, 2 );
		$this->loader->add_filter( 'tiny_mce_before_init', $plugin_admin, 'tiny_mce_settings', 10, 2 );
		$this->loader->add_action( 'wp_ajax_si_estimate_terms', $plugin_admin, 'json_estimate_terms' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_menu_pages' );
		$this->loader->add_filter( 'si_filter_zerod_decimals', $plugin_admin, 'si_filter_zerod_decimals' );

		$post_type = 'estimate_terms';
		$this->loader->add_action( "add_meta_boxes_{$post_type}", $plugin_admin, 'add_meta_boxes' );
		$this->loader->add_action( "save_post_{$post_type}", $plugin_admin, 'save_estimate_terms_content', 10, 3 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sprout_Invoices_Extensions_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'create_post_type_estimate_terms' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sprout_Invoices_Extensions_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
