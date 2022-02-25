<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/shaon-hossain45/
 * @since      1.0.0
 *
 * @package    Shipping_Plugin
 * @subpackage Shipping_Plugin/public/partials
 */
?>
<?php

class ShippingZone {

    /**
     * Add to cart hooks/filters
     *
     * @param array $cart_item_data
     * @param int   $product_id
     * @param int   $variation_id
     * @param int   $quantity
     * @return array
     */

    public function woocommerce_ajax_add_to_cart() {

      if ( ! isset( $_POST ) ) {
				wp_send_json_error( 'Invalid data / security token sent.' );
				wp_die();
			} else {
        if ( is_array( $_POST ) && isset( $_POST['values'] ) ) {

					// Data sanitize
			
        }

    //     $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id'] || $_POST['pid']));
    //     $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    //     $variation_id = absint($_POST['variation_id']);
    //     $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    //     $product_status = get_post_status($product_id);

    // if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

    //     do_action('woocommerce_ajax_added_to_cart', $product_id);

    //     // if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
    //     //     wc_add_to_cart_message(array($product_id => $quantity), true);
    //     // }

    //     //WC_AJAX :: get_refreshed_fragments();

    //     //$output_query = $this->itechpublic_query();

    //     wp_send_json_success( $return_success );

    // } else {
    //     $data = array(
    //         'error' => true,
    //         'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

    //     echo wp_send_json($data);
    // }
  }
    wp_die();
    }


    /**
		 * Adjust with WordPress query
		 *
		 * @return [type] [description]
		 */
		protected function itechpublic_query( $value ) {
			$output = '';
            $output .= 'ooo';
			return $output;
		}



  public function cart_page_validation() {
      if(is_cart()){
          echo '<div id="post-code-modal" class="modal" style="display: block;">
    <div class="modal-dialog" role="document">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header text-center">
          <div class="row">
            <div class="col-md-12">
              <h3 class="vertical-margin-small"><strong>Please enter your delivery postal code</strong></h3>
            </div>
            <div class="col-md-12">
              <div class="row vertical-margin-small" id="postal-code-button">
                <div class="col-md-3 col-sm-3 col-xs-1"></div>
                <div class="col-md-6 col-sm-6 col-xs-10">
                  <input id="postal-code-popup" type="text" name="postal_code" data-postal-code="" maxlength="6" rel="tooltip" data-placement="bottom" title="Please enter a valid postal code" aria-label="Please enter a valid postal code" data-content="Please enter a valid postal code" value="3000">
                  <button id="postal-code-confirm" class="btn-main" data-postal-code-submit="" >Confirm</button>
                  <h5>
                    <span class="error display-hidden" data-postal-code-error="">Please enter a valid post code</span>
                  </h5>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-1"></div>
              </div>
              <div class="row margin-top-large">
                <div class="col-md-12">
                  <small class="text-center"><em>Leons respects your privacy and will not share this information with anyone</em></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body vertical-margin-small">
          <div class="col-md-12 list-points text-left">
            <div class="row">
              <div class="col-md-12">
                <p class="no-ver-margin"><strong>Why do we ask for your postal code?</strong></p>
                <p>By providing your delivery postal code, youll allow us to:</p>
              </div>
            </div>
            <div class="row">

              <div class="col-md-12">
                <ul class="list-style-checkmark">
                  <li>Let you know immediately if we can service your area</li>
                  <li>Tailor our selection to make sure you see only items that can be delivered to you</li>
                  <li>Inform you if the item is currently in stock</li>
                  <li>Offer you special pricing that may only be available in some areas</li>
                  <li>Show you estimated delivery dates without having to checkout</li>
                </ul>
              </div>

            </div>
          </div>
        </div>
    </div>
    </div>
    <!-- Modal End-->
    </div>';
      }
  }


  public function itechpublic_sin_callback(){


    if ( ! isset( $_POST ) || ! isset( $_POST['security'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['security'] ) ), 'itech_login_nonce' ) ) {
      wp_send_json_error( 'Invalid data / security token sent.' );
      wp_die();
    } else {


      $datain = $_POST['value'];
      //var_dump($datain);

    if (class_exists('WC_Shipping_Zones')) {
      $zones = WC_Shipping_Zones::get_zones();

      //var_dump($zones);

      if (!empty($zones)) {
          foreach ($zones as $zone_id => $zone) {
            
            // echo '<pre>';
            // var_dump($zone);
            // echo '</pre>';
            
            //var_dump($zone['zone_locations']);

              if (!empty($zone['zone_locations'])) {
                echo $this->Postalcode_finder($datain, $zone['zone_locations']);
              }
          }
      } else {
          $zone = new WC_Shipping_Zone(0);
          $this->shipping_zone_methods = $zone->get_shipping_methods();
      }
    }



    $return_success = array(
      'exists' => "ok",
    );

    wp_send_json_success( $return_success );

    }


  }


  public function Postalcode_finder($id, $arrayzone) {
    foreach ($arrayzone as $key => $code) {
      //var_dump($key);
      var_dump($code->code);

      if( $code->code === $id ){
        return "No:". $key ."match";
      }
        //$this->code[] = $code;
        //var_dump($code);
    }
    return null;
  }


}