<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/mbezuidenhout/
 * @since      1.0.0
 *
 * @package    Sprout_Invoices_Extensions
 * @subpackage Sprout_Invoices_Extensions/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sprout_Invoices_Extensions
 * @subpackage Sprout_Invoices_Extensions/admin
 * @author     Marius Bezuidenhout <marius@blackhorse.co.za>
 */
class Sprout_Invoices_Extensions_Admin {

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
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sprout-invoices-extensions-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sprout-invoices-extensions-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add extra line item types for use in estimates.
	 *
	 * @since    1.0.0
	 */
	public function add_line_items( $line_items ) {
		$new_line_items = array(
			'venue'        => __( 'Venue', 'sprout-invoices-extensions' ),
			'catering'     => __( 'Catering', 'sprout-invoices-extensions' ),
			'staff'        => __( 'Staff', 'sprout-invoices-extensions' ),
			'technical'    => __( 'Technical', 'sprout-invoices-extensions' ),
			'toc_approval' => __( 'TOC Approval', 'sprout-invoices-extensions' ),
			'security'     => __( 'Security', 'sprout-invoices-extensions' ),
			'paramedics'   => __( 'Paramedics', 'sprout-invoices-extensions' ),
			'bar'          => __( 'Bar', 'sprout-invoices-extensions' ),
			'consumables'  => __( 'Consumables', 'sprout-invoices-extensions' ),
			'hiring'       => __( 'Hiring', 'sprout-invoices-extensions' ),
		);

		return array_merge( $line_items, $new_line_items );
	}

	/**
	 * Add naming for custom line items.
	 *
	 * @param array $columns An array of columns with parameters.
	 * @param string $type The column type string
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function line_item_columns( $columns, $type ) {
		if ( in_array( $type, array(
			'venue',
			'catering',
			'staff',
			'technical',
			'toc_approval',
			'security',
			'paramedics',
			'bar',
			'consumables',
			'hiring'
		) ) ) {
			$columns = array(
				'desc'  => array(
					'label'          => __( 'Product', 'sprout-invoices' ),
					'type'           => 'textarea',
					'calc'           => false,
					'hide_if_parent' => false,
					'weight'         => 1,
				),
				'sku'   => array(
					'label'          => __( 'SKU', 'sprout-invoices' ),
					'type'           => 'input',
					'calc'           => false,
					'numeric'        => false,
					'hide_if_parent' => true,
					'weight'         => 5,
				),
				'rate'  => array(
					'label'          => __( 'Price', 'sprout-invoices' ),
					'type'           => 'small-input',
					'calc'           => false,
					'hide_if_parent' => true,
					'weight'         => 10,
				),
				'qty'   => array(
					'label'          => __( 'Qty', 'sprout-invoices' ),
					'type'           => 'small-input',
					'calc'           => true,
					'hide_if_parent' => true,
					'weight'         => 15,
				),
				'tax'   => array(
					'label'          => sprintf( '&#37; <span class="helptip" title="%s"></span>', __( 'A percentage adjustment per line item, i.e. tax or discount', 'sprout-invoices' ) ),
					'type'           => 'small-input',
					'calc'           => false,
					'hide_if_parent' => true,
					'weight'         => 20,
				),
				'total' => array(
					'label'          => __( 'Amount', 'sprout-invoices' ),
					'type'           => 'total',
					'placeholder'    => sa_get_formatted_money( 0 ),
					'calc'           => true,
					'hide_if_parent' => false,
					'weight'         => 50,
				),
			);
		}
		switch ( $type ) {
			case 'venue':
				$columns['desc']['label'] = __( 'Venue', 'sprout-invoices' );
				break;
			case 'catering':
				$columns['desc']['label'] = __( 'Catering', 'sprout-invoices' );
				break;
			case 'staff':
				$columns['desc']['label'] = __( 'Staff', 'sprout-invoices' );
				break;
			case 'technical':
				$columns['desc']['label'] = __( 'Technical', 'sprout-invoices' );
				break;
			case 'toc_approval':
				$columns['desc']['label'] = __( 'TOC Approval', 'sprout-invoices' );
				break;
			case 'security':
				$columns['desc']['label'] = __( 'Security', 'sprout-invoices' );
				break;
			case 'paramedics':
				$columns['desc']['label'] = __( 'Paramedics', 'sprout-invoices' );
				break;
			case 'bar':
				$columns['desc']['label'] = __( 'Bar', 'sprout-invoices' );
				break;
			case 'consumables':
				$columns['desc']['label'] = __( 'Consumables', 'sprout-invoices' );
				break;
			case 'hiring':
				$columns['desc']['label'] = __( 'Hiring', 'sprout-invoices' );
				break;
		}

		return $columns;
	}

	/**
	 * Add the South African provinces in the array.
	 *
	 * @param array $states List of states grouped by country.
	 *
	 * @return array
	 */
	public function state_options( $states ) {
		$states['South Africa'] = array(
			'EC'  => 'Eastern Cape',
			'FS'  => 'Free State',
			'GP'  => 'Gauteng',
			'KZN' => 'KwaZulu-Natal',
			'LP'  => 'Limpopo',
			'MP'  => 'Mpumalanga',
			'NC'  => 'Northern Cape',
			'NW'  => 'North West',
			'WC'  => 'Western Cape',
		);
		return $states;
	}

	/**
	 * Alters the settings fields.
	 *
	 * @param string $html HTML string defining the form field.
	 * @param array $field An associative array of settings.
	 *
	 * @return string
	 */
	public function settings_input_field( $html, $field ) {
		if ( 'State' === $field['label'] ) {
			$html = str_replace( '>State</label>', '>State/Province</label>', $html );
		}
		if ( 'ZIP Code' === $field['label'] ) {
			$html = str_replace( '>ZIP Code</label>', '>Zip/Postal Code</label>', $html );
		}
		return $html;
	}

	/**
	 * Change meta box defaults.
	 *
	 * @param array $args An array of meta box parameters.
	 *
	 * @return   array
	 * @since    1.0.0
	 */
	public function information_meta_box_args( $args ) {
		if ( 'auto-draft' == $args['post']->post_status ) { // only adjust drafts
			$args['tax'] = 15;
		}
		return $args;
	}

}
