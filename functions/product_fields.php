<?php

// 1. Show custom input field above Add to Cart
 
add_action( 'woocommerce_before_add_to_cart_button', 'aimhigher_product_add_on', 9 );
 
function aimhigher_product_add_on() {
	// Occasion
    $custom_add_occasion = isset( $_POST['custom_add_occasion'] ) ? sanitize_text_field( $_POST['custom_add_occasion'] ) : '';
	echo '<label for="custom_add_occasion">What\'s the Occasion?</label>';
	echo '<input type="text" id="custom_add_occasion" name="custom_add_occasion" value="' . $custom_add_occasion . '"/>';

	// Gluten Free
	$custom_add_gluten_free = isset( $_POST['custom_add_gluten_free'] ) ? 'checked'  : '';
	echo '<label for="custom_add_gluten_free">Gluten Free?</label>';
	echo '<input type="checkbox" id="custom_add_gluten_free" name="custom_add_gluten_free" ' . $custom_add_gluten_free . ' />';
}
 
// -----------------------------------------
// 2. Throw error if custom input field empty
 
// add_filter( 'woocommerce_add_to_cart_validation', 'aimhigher_product_add_on_validation', 10, 3 );
 
// function aimhigher_product_add_on_validation( $passed, $product_id, $qty ){
//    if( isset( $_POST['custom_add_occasion'] ) && sanitize_text_field( $_POST['custom_add_occasion'] ) == '' ) {
//       wc_add_notice( 'Custom Text Add-On is a required field', 'error' );
//       $passed = false;
//    }
//    return $passed;
// }
 
// -----------------------------------------
// 3. Save custom input field value into cart item data
 
add_filter( 'woocommerce_add_cart_item_data', 'aimhigher_product_add_on_cart_item_data', 10, 2 );
 
function aimhigher_product_add_on_cart_item_data( $cart_item, $product_id ){
    if( isset( $_POST['custom_add_occasion'] ) ) {
        $cart_item['custom_add_occasion'] = sanitize_text_field( $_POST['custom_add_occasion'] );
	}
	
	if( isset( $_POST['custom_add_gluten_free'] ) ) {
        $cart_item['custom_add_gluten_free'] = sanitize_text_field( $_POST['custom_add_gluten_free'] );
    }

    return $cart_item;
}
 
// -----------------------------------------
// 4. Display custom input field value @ Cart
 
add_filter( 'woocommerce_get_item_data', 'aimhigher_product_add_on_display_cart', 10, 2 );
 
function aimhigher_product_add_on_display_cart( $data, $cart_item ) {
    if ( isset( $cart_item['custom_add_occasion'] ) ){
        $data[] = array(
            'name' => 'Occasion',
            'value' => sanitize_text_field( $cart_item['custom_add_occasion'] )
        );
	}
	
	if ( isset( $cart_item['custom_add_gluten_free'] ) ){
        $data[] = array(
            'name' => 'Gluten Free',
            'value' => sanitize_text_field( $cart_item['custom_add_gluten_free'] )
        );
    }

    return $data;
}
 
// -----------------------------------------
// 5. Save custom input field value into order item meta
 
add_action( 'woocommerce_add_order_item_meta', 'aimhigher_product_add_on_order_item_meta', 10, 2 );
 
function aimhigher_product_add_on_order_item_meta( $item_id, $values ) {
    if ( ! empty( $values['custom_add_occasion'] ) ) {
        wc_add_order_item_meta( $item_id, 'Occasion', $values['custom_add_occasion'], true );
	}
	
	if ( ! empty( $values['custom_add_gluten_free'] ) ) {
        wc_add_order_item_meta( $item_id, 'Gluten Free', $values['custom_add_gluten_free'], true );
    }
}
 
// -----------------------------------------
// 6. Display custom input field value into order table
 
add_filter( 'woocommerce_order_item_product', 'aimhigher_product_add_on_display_order', 10, 2 );
 
function aimhigher_product_add_on_display_order( $cart_item, $order_item ){
    if( isset( $order_item['custom_add_occasion'] ) ){
        $cart_item['custom_add_occasion'] = $order_item['custom_add_occasion'];
	}
	
	if( isset( $order_item['custom_add_gluten_free'] ) ){
        $cart_item['custom_add_gluten_free'] = $order_item['custom_add_gluten_free'];
    }

    return $cart_item;
}
 
// -----------------------------------------
// 7. Display custom input field value into order emails
 
add_filter( 'woocommerce_email_order_meta_fields', 'aimhigher_product_add_on_display_emails' );
 
function aimhigher_product_add_on_display_emails( $fields ) { 
	$fields['custom_add_occasion'] = 'Occasion';
	
	$fields['custom_add_gluten_free'] = 'Gluten Free';

    return $fields; 
}

?>