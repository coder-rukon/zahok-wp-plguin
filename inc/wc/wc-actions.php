<?php
add_action( 'wp_ajax_zahok_customer_check', 'zahok_customer_check' );

function zahok_customer_check() {
    $order_id = $_POST['order_id'];
    $order = wc_get_order($order_id);
    $zahok_api_key = get_option('zahok_api_key');
    $zahok_api_secret = get_option('zahok_api_secret');
    $customer_phone = $order->get_billing_phone();
    $zahokResponse = wp_remote_post( ZAHOK_URL . '/api/public/check-customer',
        [
            'body'  => json_encode(  ['mobile_number' => $customer_phone ] ),
            'headers'   => array( 'Content-Type' => 'application/json','api_key' =>$zahok_api_key,'api_secret' => $zahok_api_secret)
        ]
    );
    $response_body = wp_remote_retrieve_body( $zahokResponse );
    $response_body = json_decode( $response_body, true );
    
    ?>
    <div class="zahok zahok_popup_contents">
        <?php
            if(is_wp_error( $zahokResponse ) ){
                echo '<div class="zahok_error">'.$zahokResponse->get_error_message().'</div>';
            }else{
               if( $response_body['type'] != true){
                echo '<h2 class="zahok_api_error">'.$response_body['message'].'</h2>';
               }else{
                ?>
                    <div class="zahok_order_counter">
                        <div class="zahok_order_counter_item">
                            <h2>Total Order</h2>
                            <strong><?php echo $response_body['data']['totalOrders']; ?></strong>
                        </div>
                        <div class="zahok_order_counter_item received">
                            <h2>Total Received</h2>
                            <strong><?php echo $response_body['data']['totalOrderReceived']; ?></strong>
                        </div>
                        <div class="zahok_order_counter_item return">
                            <h2>Total Return</h2>
                            <strong><?php echo $response_body['data']['totalOrders'] - $response_body['data']['totalOrderReceived']; ?></strong>
                        </div>
                    </div>
                <?php
                echo $response_body['data']['html']['delivery_report'];
               }
                
            }
        ?>
        
    </div>
    
    <?php
    wp_die();
}