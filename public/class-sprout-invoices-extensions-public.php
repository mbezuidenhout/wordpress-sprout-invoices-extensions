<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/mbezuidenhout/
 * @since      1.0.0
 *
 * @package    Sprout_Invoices_Extensions
 * @subpackage Sprout_Invoices_Extensions/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sprout_Invoices_Extensions
 * @subpackage Sprout_Invoices_Extensions/public
 * @author     Marius Bezuidenhout <marius@blackhorse.co.za>
 */
class Sprout_Invoices_Extensions_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sprout_Invoices_Extensions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sprout_Invoices_Extensions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sprout-invoices-extensions-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sprout_Invoices_Extensions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sprout_Invoices_Extensions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sprout-invoices-extensions-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create 
	 */
	public function create_post_type_estimate_terms() {
		register_post_type(
			'estimate_terms',
			apply_filters(
				'si_extensions_post_type_estimate_terms',
				array(
					'description'        => __( 'Estimate terms.', 'sprout-invoices-extensions' ),
					'menu_icon'          => 'dashicons-media-document',
					'labels'             => array(
						'name'                     => __( 'Estimate Terms', 'sprout-invoices-extensions' ),
						'singular_name'            => __( 'Estimate Terms', 'sprout-invoices-extensions' ),
						'add_new_item'             => __( 'Add New Estimate Terms', 'sprout-invoices-extensions' ),
						'edit_item'                => __( 'Edit Estimate Terms', 'sprout-invoices-extensions' ),
						'new_item'                 => __( 'New Estimate Terms', 'sprout-invoices-extensions' ),
						'view_item'                => __( 'View Estimate Terms', 'sprout-invoices-extensions' ),
						'view_items'               => __( 'View Estimate Terms', 'sprout-invoices-extensions' ),
						'search_items'             => __( 'Search Estimate Terms', 'sprout-invoices-extensions' ),
						'not_found'                => __( 'No estimate terms found.', 'sprout-invoices-extensions' ),
						'not_found_in_trash'       => __( 'No estimate terms found in Trash.', 'sprout-invoices-extensions' ),
						'parent_item_colon'        => __( 'Parent Estimate Terms:', 'sprout-invoices-extensions' ),
						'all_items'                => __( 'All Estimate Terms', 'sprout-invoices-extensions' ),
						'archived'                 => __( 'Estimate Terms Archives', 'sprout-invoices-extensions' ),
						'attributes'               => __( 'Estimate Terms Attributes', 'sprout-invoices-extensions' ),
						'insert_into_item'         => __( 'Insert into estimate terms', 'sprout-invoices-extensions' ),
						'uploaded_to_this_item'    => __( 'Uploaded to this estimate terms', 'sprout-invoices-extensions' ),
						'filter_items_list'        => __( 'Filter estimate terms list', 'sprout-invoices-extensions' ),
						'items_list_navigation'    => __( 'Estimate terms list navigation', 'sprout-invoices-extensions' ),
						'items_list'               => __( 'Estimate terms list', 'sprout-invoices-extensions' ),
						'item_published'           => __( 'Estimate terms published.', 'sprout-invoices-extensions' ),
						'item_published_privately' => __( 'Estimate terms published privately.', 'sprout-invoices-extensions' ),
						'item_reverted_to_draft'   => __( 'Estimate terms reverted to draft.', 'sprout-invoices-extensions' ),
						'item_scheduled'           => __( 'Estimate terms scheduled.', 'sprout-invoices-extensions' ),
						'item_updated'             => __( 'Estimate terms updated.', 'sprout-invoices-extensions' ),
					),
					'public'             => false,
					'show_ui'            => true,
					'show_in_menu'       => false,
					'show_in_rest'       => false,
					'show_in_admin_bar'  => false,
					'publicly_queryable' => false,
					'show_in_nav_menus'  => false,
					'hierarchical'       => false,
					'supports'           => array(
						'title',
					),
					'has_archive'        => true,
					'delete_with_user'   => true,
				)
			)
		);

	}
	
}
