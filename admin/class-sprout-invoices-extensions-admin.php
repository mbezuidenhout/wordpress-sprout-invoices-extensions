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
			'joc_approval' => __( 'JOC Approval', 'sprout-invoices-extensions' ),
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
			case 'joc_approval':
				$columns['desc']['label'] = __( 'JOC Approval', 'sprout-invoices' );
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
	 * Add the client field to the meta box in the admin
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	public function client_fields( $fields = array() ) {
		$client_id = get_the_ID();
		if ( SI_Client::POST_TYPE !== get_post_type( $client_id ) ) {
			return $fields;
		}
		$client = SI_Client::get_instance( $client_id );
		$fields['vat_number'] = array(
			'weight' => 117,
			'label' => __( 'VAT Number', 'sprout-invoices-extensions' ),
			'type' => 'text',
			'required' => false,
			'default' => ( $client ) ? $client->get_post_meta( '_vat_number' ) : '',
			'placeholder' => '',
		);
		return $fields;
	}

	/**
	 * Save the custom fields
	 *
	 * @param array $data
	 * @param array $post
	 *
	 * @return array
	 */
	public function save_fields( $data = array(), $post = array() ) {
		if ( $post['post_type'] !== SI_Client::POST_TYPE ) {
			return $data;
		}
		$vat_number = '';
		if ( isset( $_POST['sa_metabox_vat_number'] ) ) {
			$vat_number = $_POST['sa_metabox_vat_number'];
		}
		$client = SI_Client::get_instance( $post['ID'] );
		if ( ! is_a( $client, 'SI_Client' ) ) {
			return $data;
		}
		$client->save_post_meta( array( '_vat_number' => $vat_number ) );
		return $data;
	}

	/**
	 * Change the translation for some strings.
	 *
	 * @param string $translations The translated string.
	 * @param string $text   The original string.
	 * @param string $domain The translation domain.
	 *
	 * @return string
	 */
	public function change_strings( $translations, $text, $domain ) {
		$locale = get_locale();
		if ( 'sprout-invoices' === $domain || 'sprout-invoices-extensions' === $domain && 0 === strpos( $locale, 'en' ) ) {
			switch( $text ) {
				case 'PO #':
				case 'PO Number':
					$translations = 'Date of Event';
					break;
				case 'Used to display the estimate po number.':
					$translations = 'Used to display the event date.';
					break;
				//case 'Invoice #': // TODO: Check that this only happens on the quotes page.
				//	$translations = 'Quote #';
				//	break;
			}
			$translations = str_replace( 'Estimate', 'Quote', $translations );
			$translations = str_replace( 'estimate', 'quote', $translations );
		}
		return $translations;
	}

	/**
	 * Change labels for the custom post type.
	 *
	 * @param array $args Array of arguments for the custom post type.
	 *
	 * @return array
	 */
	public function change_post_type_name_for_estimates( $args ) {
		$new_args = array(
			'label' => 'Quotes',
			'labels' => array(
				'name' => 'Quotes',
				'singular_name' => 'Quote',
				'search_items' => 'Search Quotes',
				'popular_items' => 'Popular Quotes',
				'all_items' => 'All Quotes',
				'parent_item' => 'Parent Quote',
				'parent_item_colon' => 'Parent Quote:',
				'edit_item' => 'Edit Quote',
				'update_item' => 'Update Quote',
				'add_new_item' => 'Add New Quote',
				'new_item_name' => 'New Quote Name',
				'menu_name' => 'Quotes',
			),
		);
		return array_merge( $args, $new_args );
	}

	/**
	 * Add built-in plugins to the tinymce editor.
	 *
	 * @param array $plugins An array of plugin names.
	 *
	 * @return array
	 */
	public function tiny_mce_plugins( $plugins ) {
		$plugins['template'] = plugin_dir_url( __FILE__ ) . 'js/tinymce/plugins/template/plugin.min.js';
		return $plugins;
	}

	/**
	 * Filters the list of buttons shown to the user.
	 *
	 * @param array  $mce_buttons An array of buttons
	 * @param string $editor_id   The tinymce editor id specified in the wp_editor call
	 *
	 * @return array
	 */
	public function tiny_mce_buttons( $mce_buttons, $editor_id ) {
		if ( 'estimate_terms' === $editor_id ) {
			$mce_buttons[] = 'template';
		}
		return $mce_buttons;
	}

	public function tiny_mce_settings( $settings, $editor_id ) {
		if ( 'estimate_terms' === $editor_id ) {
			$settings['templates'] = admin_url( 'admin-ajax.php?action=si_estimate_terms' );
		}
		return $settings;
	}

	/**
	 * Return an array of terms
	 */
	public function json_estimate_terms() {
		$args = array(
			'numberposts' => -1,
			'orderby'     => 'title',
			'order'       => 'ASC',
			'post_type'   => 'estimate_terms',
		);
		$estimate_terms = get_posts( $args );

		$terms = array();

		foreach ( $estimate_terms as $post ) {
			$terms[] = array(
				'title'   => $post->post_title,
				'content' => $post->post_content,
			);
		}
		wp_send_json( $terms );
	}

	/**
	 * Add submenu pages.
	 */
	public function register_menu_pages() {
		add_submenu_page(
			'edit.php?post_type=sa_estimate',
			__( 'Terms', 'sprout-invoices-extensions' ),
			__( 'Terms', 'sprout-invoices-extensions' ),
			'manage_options',
			'edit.php?post_type=estimate_terms'
		);
	}

	/**
	 * Display a page where the user change manage terms as shown on estimates.
	 */
	public function manage_estimate_terms_page() {

	}

	/**
	 * Add the custom fields to the template.
	 */
	public function add_custom_fields_to_docs() {
		$client_id = 0;
		$doc_id = get_the_id();
		if ( get_post_type( $doc_id ) == SI_Invoice::POST_TYPE ) {
			$client_id = si_get_invoice_client_id();
		}
		if ( get_post_type( $doc_id ) == SI_Estimate::POST_TYPE ) {
			$client_id = si_get_estimate_client_id();
		}
		if ( $client_id ) {
			$client = SI_Client::get_instance( $client_id );
			printf( __( '<dl class="client_addy"><dt><span class="dt_heading">VAT Number</span></dt><dd>%s</dd></dl>', 'sprout-invoices-extensions' ), $client->get_post_meta( '_vat_number' ) );
		}
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

	/**
	 * Change text displayed in the left footer column.
	 *
	 * @param string $text The text in the left footer.
	 *
	 * @return string
	 */
	public function admin_footer_text( $text ) {
		return '';
	}

	/**
	 * Add the estimate terms meta boxes.
	 *
	 * @param WP_Post $post The post object.
	 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
	 */
	public function add_meta_boxes( $post ) {
		add_meta_box( 'estimatetermsdiv', __( 'Terms', 'sprout-invoices-extensions' ), array( $this, 'meta_box_estimate_terms' ), 'estimate_terms', 'normal' );
	}

	/**
	 * Display the content of the terms meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function meta_box_estimate_terms( $post ) {
		wp_nonce_field( 'meta-box-estimate-terms', '_wpnonce_estimate_terms' );
		$settings = array(
			'media_buttons' => false,
			'textarea_rows' => 4,
			'theme_styles'  => false,
		);
		add_filter( 'mce_css', '__return_null' );
		wp_editor( $post->post_content, 'estimate-terms', $settings );
		remove_filter( 'mce_css', '__return_null' );
	}

	/**
	 * Saving of meta boxes for the custom post type quote.
	 *
	 * @param int     $post_ID Post ID.
	 * @param WP_Post $post    Post object.
	 * @param bool    $update  Whether this is an existing post being updated or not.
	 *
	 * @return int
	 */
	public function save_estimate_terms_content( $post_ID, $post, $update ) {
		if ( ! isset( $_REQUEST['_wpnonce_estimate_terms'] ) || ! wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce_estimate_terms'] ), 'meta-box-estimate-terms' ) ) {
			return $post_ID;
		}

		// check autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_ID;
		}

		if ( ! current_user_can( 'edit_post', $post_ID ) ) {
			return $post_ID;
		}

		if ( wp_unslash( $_REQUEST['estimate-terms']!== $post->post_content ) ) {
			$post->post_content = wp_unslash( $_REQUEST['estimate-terms'] );
			wp_update_post( $post );
		}

		return $post_ID;
	}

}
