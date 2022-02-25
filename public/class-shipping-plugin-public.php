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
 * @author     shaon <shaonhossain615@gmail.com>
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shipping-plugin-public.js', array( 'jquery' ), $this->version, false );

		if ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
			wp_enqueue_script( 'woocommerce-postalcode', plugin_dir_url( __FILE__ ) . 'js/postcode-validation.js', array( 'jquery' ), '', true );
		}

		$ajax_nonce = wp_create_nonce( 'shipping_login_nonce' );
		wp_localize_script(
			'woocommerce-postalcode',
			'itechsin_obj',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'action'   => 'shipping_sin_callback',
				'security' => $ajax_nonce,
			)
		);

	}

	/**
	 * Action dispatch
	 *
	 * @param  [type] $addressbook [description]
	 * @return [type]              [description]
	 */
	public function dispatch_actions( $data ) {

		add_action('wp_head', array( $data, 'cart_page_validation' ) );
		
		//add_filter( 'woocommerce_add_to_cart_validation', array( $data, 'so_validate_add_cart_item' ), 10, 5 );

		add_action( 'wp_ajax_woocommerce_ajax_add_to_cart', array( $data,  'woocommerce_ajax_add_to_cart' ) );
		add_action( 'wp_ajax_nopriv_woocommerce_ajax_add_to_cart', array( $data, 'woocommerce_ajax_add_to_cart' ) );

		add_action( 'wp_ajax_shipping_sin_callback', array( $data, 'shipping_sin_callback' ) );
		add_action( 'wp_ajax_nopriv_shipping_sin_callback', array( $data, 'shipping_sin_callback' ) );

	}

}
