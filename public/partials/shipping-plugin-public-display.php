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

  public $cookie_name = 'postal-code-confirmed';

    /**
     * Add to cart hooks/filters
     *
     * @param array $cart_item_data
     * @param int   $product_id
     * @param int   $variation_id
     * @param int   $quantity
     * @return array
     */

    function woocommerce_ajax_add_to_cart() {

      $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
      $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
      $variation_id = absint($_POST['variation_id']);
      $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
      $product_status = get_post_status($product_id);

      if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

          do_action('woocommerce_ajax_added_to_cart', $product_id);

          // if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
          //     wc_add_to_cart_message(array($product_id => $quantity), true);
          // }

          //WC_AJAX :: get_refreshed_fragments();



          $return_success = array(
            'outputHtml' => '<div id="add-to-cart-modal" class="modal" style="display: block;">
            <div class="modal-dialog" role="document">
              <!-- Modal content -->
              <div class="modal-content" role="modal">
                <a class="pull-right" href="javascript:void(null)" id="close-add-to-cart" tabindex="0" aria-label="close window">
                   <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <div class="modal-header text-center">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="vertical-margin-small"><strong>Great Choice!</strong></h3>
                      <p>Your item has been added to the cart </p>
                      <div class="row">
                           <img id="cart-image" width="280px" height="auto" alt="Julian Sofa - Teal" src="//cdn.shopify.com/s/files/1/2660/5106/products/lnp7vkxqnfy6jthnnvln_9cf8c7c0-2600-48ca-b81e-37d551f06aef_large.jpg?v=1611258035">
                           <div id="cart-item-title"><p><strong>Julian Sofa - Teal</strong></p></div><div id="free-local-del-bal" style="display: block;"><hr class="lineseperator-top" style="width: 75%" ;=""><img width="78px" alt="leons-truck" src="//cdn.shopify.com/s/files/1/0003/9252/7936/files/leons_truck_logo.png?18062638485242518589"><div class="alert  custom-alert-cart-popup text-center margin-left-large margin-right-large" role="alert"><strong style="color: #008a00;"><span class="free-local-del-text" style=" color: #008a00;"><i class="far fa-thumbs-up thumbs-up"></i>&nbsp;Congratulations!&nbsp;</span><span class="free-local-del-text" style="color: #008a00;">Your order qualifies for</span> <span class="free-local-del-text">Free Local Delivery<sup>*</sup>.</span></strong><p class="disclaimer"> <sup>*</sup>Conditions may change in cart</p></div></div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row vertical-margin-small">
                          <div class="col-xs-12">
                              <a class="btn bg-green proceed" href="http://localhost/wordpresswoo/cart/">Proceed to Cart<span class="fa fa-chevron-right" aria-hidden="true"></span></a>
                          </div>
                      </div>
                      <div class="row vertical-margin-small">
                          <div class="col-xs-12" id="continue-shopping">
                              <a role="button" class="continue-shopping" href="javascript:void(null)"><span class="fa fa-chevron-left"></span>Continue Shopping</a>
                          </div>
                      </div>
                      <div class="row margin-top-large">
                        <div class="col-md-12">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal End-->
                </div>
                </div>',
        );

        wp_send_json_success( $return_success );



      } else {

          $data = array(
              'error' => true,
              'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

          echo wp_send_json($data);
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
                  <input id="postal-code-popup" type="text" name="postal_code" data-postal-code="" maxlength="6" rel="tooltip" data-placement="bottom" title="Please enter a valid postal code" aria-label="Please enter a valid postal code" data-content="Please enter a valid postal code" value="N8W1C3">
                  <button id="postal-code-confirm" class="btn-main" data-postal-code-submit="">Confirm</button>
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


  public function shipping_sin_callback(){


    if ( ! isset( $_POST ) || ! isset( $_POST['security'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['security'] ) ), 'shipping_login_nonce' ) ) {
      wp_send_json_error( 'Invalid data / security token sent.' );
      wp_die();
    } else {


      $datain = substr($_POST['value'],0,3);
      //var_dump($datain);

      $response = array();

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

                

                foreach ($zone['zone_locations'] as $key => $code) {
                  $act_id = null;
                  //var_dump($key);
                  //var_dump($code->code);

            $subtval = substr($code->code,0,3);
//var_dump($subtval);
                  if( $datain == $subtval ){
                    $act_id = $subtval;
                    if($act_id === $datain ){
                      $response['insert'] = "done";
                      $set_cookie = setcookie( $this->cookie_name, 'true', time() + ( 60 * 60 * 24 * 30 ), '/', COOKIE_DOMAIN, is_ssl(), false );
                    }else{
                      $response['insert'] = "no";
                    };
                    break;
                  }
                    //$this->code[] = $code;
                    //var_dump($code);
                }
              }
          }
      } else {
          $zone = new WC_Shipping_Zone(0);
          $this->shipping_zone_methods = $zone->get_shipping_methods();
      }
    }

    }
    $return_success = array(
      'exists' => $response,
    );
    wp_send_json_success( $return_success );
    wp_die();
  }


}