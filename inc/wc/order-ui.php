<?php
function zahok_order_admin_col($columns) {
    $new_columns = [];
    foreach ($columns as $key => $column) {
        $new_columns[$key] = $column;
        if ($key === 'order_status') {
            $new_columns['zahok'] = __('Zahok actions', 'zahok');
            //$new_columns['zahok_duplicate_order'] = __('Duplicate Orders', 'zahok');
        }
    }

    return $new_columns;
}
add_filter('manage_woocommerce_page_wc-orders_columns', 'zahok_order_admin_col');



function zahok_admin_col_view( $column_name, $order ){ // WC_Order object is available as $order variable here

	if( 'zahok' === $column_name ) {
		?>
        <div class="zahok_btn_group">
            <button type="button" data-order-id="<?php echo $order->get_id(); ?>" class="button btn_zahok_customer_check">Check Customer</button>
        </div>
        
        <?php
	}
}
add_action( 'manage_woocommerce_page_wc-orders_custom_column', 'zahok_admin_col_view', 25, 2 );


add_action('woocommerce_admin_order_data_after_billing_address', 'zahok_order_details_widget_in_admin', 10, 1);

function zahok_order_details_widget_in_admin($order) {
    // Ensure $order is a WC_Order object
    if (!$order instanceof WC_Order) {
        return;
    }
    ?>
        <div class="zahok_order_widget">
            <div class="zahok_btn_group">
                <button type="button" data-order-id="<?php echo $order->get_id(); ?>" class="button  button-primary btn_zahok_customer_check">Check Customer</button>
            </div>
        </div>
        
    <?php
    
}