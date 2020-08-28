<?php

// 1. Show custom input field above Add to Cart
 
add_action( 'woocommerce_before_add_to_cart_button', 'aimhigher_product_add_on', 9 );
 
function aimhigher_product_add_on() {
    // Flavours and Themes        
        global $product;
        $attributes = $product->get_attributes();
        $att_keys = array_keys($attributes);

        foreach ($att_keys as $att):
            $terms = get_terms( array(
                'taxonomy' => $att
            ) );
            $selected_option = $_POST[$att];
            $selected_field = isset( $_POST[$att]) ? 'filled' : '';

            echo '<fieldset class="' . $att . ' ' . $selected_field . '"><div><legend>' . wc_attribute_label($att) . '</legend>';

            foreach ($terms as $term):
                $id = 'pa_flavours_' . $term->term_taxonomy_id;
                $term->image = get_field('image', $id);
                $term->variation_image = get_field('variation_image', $id);
                $selected = '';

                if($term->slug == $selected_option) {
                    $selected = 'checked';
                }

            ?>
                <input 
                    name="<?php echo $term->slug; ?>" 
                    id="pa_flavours-<?php echo $term->slug; ?>" 
                    value="<?php echo $term->slug; ?>" 
                    type="radio" 
                    <?php echo $selected; ?>
                />
                <label 
                    htmlFor="pa_flavours-<?php echo $term->slug; ?>"
                >
                    <?php echo $term->name; ?>
                </label>
                    
            <?php endforeach;

            echo '</div></fieldset>';

        endforeach;

        

        // var_dump($attributes);

    // Gluten Free - custom_add_gluten_free
        $custom_add_gluten_free_yes = '';
        $custom_add_gluten_free_no = 'checked';
        $custom_add_gluten_free_set = '';
        
        if(isset( $_POST['custom_add_gluten_free'])) {
            $custom_add_gluten_free_set = 'filled';

            if($_POST['custom_add_gluten_free'] == 'yes') {
                $custom_add_gluten_free_yes = 'checked';
                $custom_add_gluten_free_no = '';
            }
        }
    ?>
        <fieldset class="<?php echo $custom_add_gluten_free_set; ?>">
            <div>
                <legend>Gluten Free?</legend>
                <input 
                    type="radio" 
                    id="custom_add_gluten_free_yes" 
                    value="custom_add_gluten_free_yes" 
                    name="custom_add_gluten_free" 
                    <?php echo $custom_add_gluten_free_yes; ?> 
                />
                <label for="custom_add_gluten_free_yes">Yes</label>
                <input 
                    type="radio" 
                    id="custom_add_gluten_free_no" 
                    value="custom_add_gluten_free_no" 
                    name="custom_add_gluten_free" 
                    <?php echo $custom_add_gluten_free_no; ?> 
                />
                <label for="custom_add_gluten_free_yes">No</label>
            </div>
        </fieldset>

    <?php
    
    // Allergies - custom_add_allergies
        $custom_add_allergies = isset( $_POST['custom_add_allergies'] ) ? sanitize_text_field( $_POST['custom_add_allergies'] ) : '';
        $custom_add_allergies_set = isset( $_POST['custom_add_allergies'] ) ? 'filled' : '';
    ?>
    
        <label for="custom_add_allergies">Are there any allergies we need to be aware of?</label>
        <input 
            type="text" 
            id="custom_add_allergies" 
            name="custom_add_allergies" 
            value="<?php echo $custom_add_allergies; ?>"
            class="<?php echo $custom_add_allergies_set; ?>"
        />
    
    <?php
    
    // Occasion - custom_add_occasion
        $custom_add_occasion = isset( $_POST['custom_add_occasion'] ) ? sanitize_text_field( $_POST['custom_add_occasion'] ) : '';
        $custom_add_occasion_set = isset( $_POST['custom_add_allergies'] ) ? 'filled' : '';
    ?>
    
        <label for="custom_add_occasion">What's the Occasion?</label>
        <input 
            type="text" 
            id="custom_add_occasion" 
            name="custom_add_occasion" 
            placeholder="Birthday, Anniversary, Tuesday, etc"
            value="<?php echo $custom_add_occasion; ?> "
            class="<?php echo $custom_add_occasion_set; ?>"
        />
    
    <?php
    
    // Colour - custom_add_colour
        $custom_add_colour = isset( $_POST['custom_add_colour'] ) ? sanitize_text_field( $_POST['custom_add_colour'] ) : '';
        $custom_add_colour_set = isset( $_POST['custom_add_allergies'] ) ? 'filled' : '';
	?>
    
        <label for="custom_add_colour">Incorporate a favourite colour?</label>
        <input 
            type="text" 
            id="custom_add_colour" 
            name="custom_add_colour"
            value="<?php echo $custom_add_colour; ?> "
            filled"<?php echo $custom_add_colour_set; ?>"
        />
    
    <?php

    // Message - custom_add_message
        $custom_add_message = isset( $_POST['custom_add_message'] ) ? sanitize_text_field( $_POST['custom_add_message'] ) : '';
        $custom_add_message_set = isset( $_POST['custom_add_allergies'] ) ? 'filled' : '';
	?>
    
        <label for="custom_add_message">Message for gift tag</label>
        <textarea 
            id="custom_add_message" 
            name="custom_add_message"
            class="<?php echo $custom_add_message_set; ?>"
        ><?php echo $custom_add_message; ?>
        </textarea>

        <button type="button" onClick="changeOrderFields()">Change Order options</button>
    
    <?php
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
    // Gluten Free - custom_add_gluten_free
    if( isset( $_POST['custom_add_gluten_free'] ) ) {
        if($_POST['custom_add_gluten_free'] == 'custom_add_gluten_free_yes' || $_POST['custom_add_gluten_free'] == 'yes') {
            $cart_item['custom_add_gluten_free'] = 'Yes';
        }
    }

    // Allergies - custom_add_allergies
    if( isset( $_POST['custom_add_allergies'] ) ) {
        $cart_item['custom_add_allergies'] = sanitize_text_field( $_POST['custom_add_allergies'] );
	}
    
    // Occasion - custom_add_occasion
    if( isset( $_POST['custom_add_occasion'] ) ) {
        $cart_item['custom_add_occasion'] = sanitize_text_field( $_POST['custom_add_occasion'] );
	}
    
    // Colour - custom_add_colour
    if( isset( $_POST['custom_add_colour'] ) ) {
        $cart_item['custom_add_colour'] = sanitize_text_field( $_POST['custom_add_colour'] );
	}

    // Message - custom_add_message
    if( isset( $_POST['custom_add_message'] ) ) {
        $cart_item['custom_add_message'] = sanitize_text_field( $_POST['custom_add_message'] );
	}

    return $cart_item;
}
 
// -----------------------------------------
// 4. Display custom input field value @ Cart
 
add_filter( 'woocommerce_get_item_data', 'aimhigher_product_add_on_display_cart', 10, 2 );
 
function aimhigher_product_add_on_display_cart( $data, $cart_item ) {
    // Gluten Free - custom_add_gluten_free
    if ( isset( $cart_item['custom_add_gluten_free'] ) ){
        $data[] = array(
            'name' => 'Gluten Free',
            'value' => $cart_item['custom_add_gluten_free']
        );
    }

    // Allergies - custom_add_allergies
    if ( isset( $cart_item['custom_add_allergies'] ) ){
        $data[] = array(
            'name' => 'Allergies',
            'value' => sanitize_text_field( $cart_item['custom_add_allergies'] )
        );
	}

    // Occasion - custom_add_occasion
    if ( isset( $cart_item['custom_add_occasion'] ) ){
        $data[] = array(
            'name' => 'Occasion',
            'value' => sanitize_text_field( $cart_item['custom_add_occasion'] )
        );
	}
    
    // Colour - custom_add_colour
    if ( isset( $cart_item['custom_add_colour'] ) ){
        $data[] = array(
            'name' => 'Colour',
            'value' => sanitize_text_field( $cart_item['custom_add_colour'] )
        );
	}

    // Message - custom_add_message
    if ( isset( $cart_item['custom_add_message'] ) ){
        $data[] = array(
            'name' => 'Message',
            'value' => sanitize_text_field( $cart_item['custom_add_message'] )
        );
	}


    return $data;
}
 
// -----------------------------------------
// 5. Save custom input field value into order item meta
 
add_action( 'woocommerce_add_order_item_meta', 'aimhigher_product_add_on_order_item_meta', 10, 2 );
 
function aimhigher_product_add_on_order_item_meta( $item_id, $values ) {
    // Gluten Free - custom_add_gluten_free
    if ( ! empty( $values['custom_add_gluten_free'] ) ) {
        wc_add_order_item_meta( $item_id, 'Gluten Free', $values['custom_add_gluten_free'], true );
    }

    // Allergies - custom_add_allergies
    if ( ! empty( $values['custom_add_allergies'] ) ) {
        wc_add_order_item_meta( $item_id, 'Allergies', $values['custom_add_allergies'], true );
	}

    // Occasion - custom_add_occasion
    if ( ! empty( $values['custom_add_occasion'] ) ) {
        wc_add_order_item_meta( $item_id, 'Occasion', $values['custom_add_occasion'], true );
	}
    
    // Colour - custom_add_colour
    if ( ! empty( $values['custom_add_colour'] ) ) {
        wc_add_order_item_meta( $item_id, 'Colour', $values['custom_add_colour'], true );
	}

    // Message - custom_add_message
    if ( ! empty( $values['custom_add_message'] ) ) {
        wc_add_order_item_meta( $item_id, 'Message', $values['custom_add_message'], true );
	}
}
 
// -----------------------------------------
// 6. Display custom input field value into order table
 
add_filter( 'woocommerce_order_item_product', 'aimhigher_product_add_on_display_order', 10, 2 );
 
function aimhigher_product_add_on_display_order( $cart_item, $order_item ){
    // Gluten Free - custom_add_gluten_free
    if( isset( $order_item['custom_add_gluten_free'] ) ){
        $cart_item['custom_add_gluten_free'] = $order_item['custom_add_gluten_free'];
    }

    // Allergies - custom_add_allergies
    if( isset( $order_item['custom_add_allergies'] ) ){
        $cart_item['custom_add_allergies'] = $order_item['custom_add_allergies'];
	}

    // Occasion - custom_add_occasion
    if( isset( $order_item['custom_add_occasion'] ) ){
        $cart_item['custom_add_occasion'] = $order_item['custom_add_occasion'];
	}
    
    // Colour - custom_add_colour
    if( isset( $order_item['custom_add_colour'] ) ){
        $cart_item['custom_add_colour'] = $order_item['custom_add_colour'];
	}

    // Message - custom_add_message
    if( isset( $order_item['custom_add_message'] ) ){
        $cart_item['custom_add_message'] = $order_item['custom_add_message'];
	}
	

    return $cart_item;
}
 
// -----------------------------------------
// 7. Display custom input field value into order emails
 
add_filter( 'woocommerce_email_order_meta_fields', 'aimhigher_product_add_on_display_emails' );
 
function aimhigher_product_add_on_display_emails( $fields ) { 
    // Gluten Free - custom_add_gluten_free

    // Allergies - custom_add_allergies

    // Occasion - custom_add_occasion
    
    // Colour - custom_add_colour

    // Message - custom_add_message

	$fields['custom_add_occasion'] = 'Occasion';
	
	$fields['custom_add_gluten_free'] = 'Gluten Free';

    return $fields; 
}

?>