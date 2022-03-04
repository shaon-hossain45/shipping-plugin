<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/shaon-hossain45/
 * @since      1.0.0
 *
 * @package    Shipping_Plugin
 * @subpackage Shipping_Plugin/public
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shipping-plugin-public-display.php';

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Shipping_Plugin
 * @subpackage Shipping_Plugin/public
 * @author     Codingkart <shaonhossain615@gmail.com>
 */
class Shipping_Plugin_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		/**
		 * ShippingZone Hooks class
		 */
		$ShippingZone_obj = new ShippingZone();
		$this->dispatch_actions( $ShippingZone_obj );

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
		 * defined in Shipping_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shipping_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0', 'all' );

		wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css', array(), '1.13.1', 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shipping-plugin-public.css', array(), $this->version, 'all' );

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
		 * defined in Shipping_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shipping_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( function_exists( 'is_product' ) && is_product() ) {
			wp_enqueue_script( 'woocommerce-ajax-add-to-cart', plugin_dir_url( __FILE__ ) . 'js/ajax-add-to-cart.js', array( 'jquery' ), '', true );
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shipping-plugin-public.js', array( 'jquery' ), $this->version, true );

		if ( ( function_exists( 'is_cart' ) && is_cart() ) ) {
			wp_enqueue_script( 'woocommerce-postalcode', plugin_dir_url( __FILE__ ) . 'js/postcode-validation.js', array( 'jquery' ), '', true );
		}

		$ajax_nonceo = wp_create_nonce( 'shipping_login_nonce' );
		wp_localize_script(
			'woocommerce-postalcode',
			'itechsin_obj',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'action'   => 'shipping_sin_callback',
				'security' => $ajax_nonceo,
			)
		);

		wp_enqueue_script( 'woocommerce-postal-hvalid', plugin_dir_url( __FILE__ ) . 'js/postcode-head-validation.js', array( 'jquery' ), '', true );
		$ajax_noncelk = wp_create_nonce( 'ship_kkln_nonce' );
		wp_localize_script(
			'woocommerce-postal-hvalid',
			'itechka_obj',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'action'   => 'popppg_n_clback',
				'security' => $ajax_noncelk,
			)
		);

		wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.6.0.js', array( 'jquery' ), '3.6.0', false );
		wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.13.1/jquery-ui.js', array( 'jquery' ), '1.13.1', false );

		// if ( ( function_exists( 'is_cart' ) && is_cart() ) ) {
		// wp_enqueue_script( 'woocommerce-postalcodekey', plugin_dir_url( __FILE__ ) . 'js/postcode-validation-key.js', array( 'jquery' ), '', true );
		// }
		// $ajax_noncel = wp_create_nonce( 'ship_ln_nonce' );
		// wp_localize_script(
		// 'woocommerce-postalcodekey',
		// 'itechk_obj',
		// array(
		// 'ajax_url' => admin_url( 'admin-ajax.php' ),
		// 'action'   => 'shing_n_clback',
		// 'security' => $ajax_noncel,
		// )
		// );
	}

	/**
	 * Action dispatch
	 *
	 * @param  [type] $addressbook [description]
	 * @return [type]              [description]
	 */
	public function dispatch_actions( $data ) {

		add_action( 'wp_head', array( $data, 'zipcode_modal' ) );

		// add_filter( 'woocommerce_add_to_cart_validation', array( $data, 'so_validate_add_cart_item' ), 10, 5 );

		add_action( 'wp_ajax_woocommerce_ajax_add_to_cart', array( $data, 'woocommerce_ajax_add_to_cart' ) );
		add_action( 'wp_ajax_nopriv_woocommerce_ajax_add_to_cart', array( $data, 'woocommerce_ajax_add_to_cart' ) );

		add_action( 'wp_ajax_shipping_sin_callback', array( $data, 'shipping_sin_callback' ) );
		add_action( 'wp_ajax_nopriv_shipping_sin_callback', array( $data, 'shipping_sin_callback' ) );

		add_action( 'wp_ajax_popppg_n_clback', array( $data, 'popppg_n_clback' ) );
		add_action( 'wp_ajax_nopriv_popppg_n_clback', array( $data, 'popppg_n_clback' ) );

		// add_action( 'wp_ajax_shing_n_clback', array( $data, 'shing_n_clback' ) );
		// add_action( 'wp_ajax_nopriv_shing_n_clback', array( $data, 'shing_n_clback' ) );

		// add_filter( 'woocommerce_checkout_fields', array( $data, 'checkout_country_fields_disabled' ) );
		// add_filter( 'woocommerce_checkout_fields', array( $data, 'readdonly_country_select_field' ) );

		// add_filter( 'default_checkout_billing_country', array( $data, 'change_default_checkout_country' ) );
		// add_filter( 'default_checkout_billing_state', array( $data, 'change_default_checkout_state' ) );

		// add_filter( 'default_checkout_shipping_country', array( $data, 'change_default_checkout_country' ) );
		// add_filter( 'default_checkout_shipping_state', array( $data, 'change_default_checkout_state' ) );

		// add_filter( 'woocommerce_billing_fields', array( $data, 'ts_unrequire_wc_country_field') );
		// add_filter( 'woocommerce_default_address_fields' , array( $data, 'make_state_field_required'), 90, 1 );

		// add_filter( 'woocommerce_form_field_country', array( $data, 'filter_form_field_country' ), 10, 4 );

		// add_filter( 'woocommerce_process_checkout_field_billing_country', array( $data, 'fix_default_billing_country' ), 10, 1 );
		// add_filter('woocommerce_checkout_fields', array( $data, 'njengah_override_checkout_fields') );
		add_action( 'wp_head', array( $data, 'get_cookie_redirect' ) );

		add_action( 'wp_footer', array( $data, 'customer_zipcode_jquery' ) );

		add_action( 'wp_head', array( $data, 'zipcode_modal_update' ) );

		add_filter( 'woocommerce_checkout_fields', array( $data, 'bbloomer_change_address_input_type' ), 10, 1 );

		add_filter('woocommerce_billing_fields', array( $data, 'cus_woocommerce_billing_fields') );
		//add_action( 'woocommerce_proceed_to_checkout', array( $data, 'change_proceed_to_checkout' ), 15 );

		add_action('wp_footer', array( $data, 'customer_notes_jquery' ) );

	}

}
