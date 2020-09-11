<?php

// 1. Show custom input field above Add to Cart
 
add_action( 'woocommerce_before_add_to_cart_button', 'aimhigher_product_add_on', 9 );
 
function aimhigher_product_add_on() {
    // Flavours and Themes        
        global $product;
        $attributes = $product->get_attributes();
        $att_keys = array_keys($attributes);
        $custom_add_gluten_free_hidden = 'hidden';

        foreach ($att_keys as $att):
            $terms = get_terms( array(
                'taxonomy' => $att
            ) );
            $selected_option = str_replace("+", " ", $_POST[$att]);;
            $selected_field = isset( $_POST[$att]) ? 'filled' : '';

            echo '<fieldset class="' . $att . ' ' . $selected_field . '"><div><legend required>' . wc_attribute_label($att) . '</legend>';

            foreach ($terms as $term):
                $id = $att . '_' . $term->term_taxonomy_id;
                $term->image = get_field('image', $id);
                $term->variation_image = get_field('variation_image', $id);
                $term->gluten_free = get_field('gluten_free', $id) ? 'true' : 'false';
                $selected = '';

                if($term->name == $selected_option) {
                    $selected = 'checked';

                    if($att == 'pa_flavours' && $term->gluten_free == 'true') {
                        $custom_add_gluten_free_hidden = '';
                    }
                }
            ?>
                <input 
                    name="<?php echo $att ?>" 
                    id="<?php echo $id ?>" 
                    value="<?php echo $term->name; ?>" 
                    type="radio" 
                    onClick="changeFlavour(this)"
                    data-name="<?php echo $term->name; ?>" 
                    data-variation_image="<?php echo $term->variation_image['sizes']['medium_large']; ?>"
                    data-description="<?php echo $term->description; ?>"
                    data-gf="<?php echo $term->gluten_free; ?>"
                    <?php echo $selected; ?>
                />
                <label 
                    for="<?php echo $id ?>"
                    style="background-image: url(<?php echo $term->image['sizes']['thumbnail']; ?>)"
                >
                    <span><?php echo $term->name; ?></span>
                </label>
                    
            <?php endforeach;

            echo '</div></fieldset>';

        endforeach;

        

    // Message - custom_theme_message
        $custom_theme_message = isset( $_POST['custom_theme_message'] ) ? sanitize_text_field( $_POST['custom_theme_message'] ) : '';
        $custom_theme_message_set = isset( $_POST['custom_theme_message'] ) ? 'filled' : '';
        $custom_theme_message_hidden = $_POST['pa_decorations'] == 'Message' ? '' : 'hidden';
        $custom_theme_message_disabled = $custom_theme_message_hidden == 'hidden' ? 'disabled' : '';
        $custom_theme_message_required = $custom_theme_message_disabled == 'disabled' ? '' : 'required';
    ?>

        <fieldset class="message <?php echo $custom_theme_message_set . ' ' . $custom_theme_message_hidden; ?>">
            <label for="custom_theme_message" required>What message would you like on the cake?</label>
            <input 
                type="text" 
                id="custom_theme_message" 
                name="custom_theme_message" 
                value="<?php echo $custom_theme_message; ?>"
                <?php echo $custom_theme_message_disabled; ?>
                <?php echo $custom_theme_message_required; ?>
            />
        </fieldset>

    <?php

    // Gluten Free - custom_add_gluten_free
        $custom_add_gluten_free_yes = '';
        $custom_add_gluten_free_no = 'checked';
        $custom_add_gluten_free_set = '';
        $custom_add_gluten_free_disabled = $custom_add_gluten_free_hidden == 'hidden' ? 'disabled' : '';
        
        if(isset( $_POST['custom_add_gluten_free'])) {
            $custom_add_gluten_free_set = 'filled';

            if($_POST['custom_add_gluten_free'] == 'yes') {
                $custom_add_gluten_free_yes = 'checked';
                $custom_add_gluten_free_no = '';
            }
        }
    ?>
        <fieldset class="<?php echo $custom_add_gluten_free_set . ' ' . $custom_add_gluten_free_hidden; ?> gluten">
            <div>
                <legend>Gluten Free?</legend>
                <input 
                    type="radio" 
                    id="custom_add_gluten_free_yes" 
                    value="custom_add_gluten_free_yes" 
                    name="custom_add_gluten_free" 
                    <?php echo $custom_add_gluten_free_yes; ?> 
                    <?php echo $custom_add_gluten_free_disabled; ?>
                />
                <label for="custom_add_gluten_free_yes">Yes</label>
                <input 
                    type="radio" 
                    id="custom_add_gluten_free_no" 
                    value="custom_add_gluten_free_no" 
                    name="custom_add_gluten_free" 
                    <?php echo $custom_add_gluten_free_no; ?> 
                    <?php echo $custom_add_gluten_free_disabled; ?>
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
        $custom_add_occasion_set = isset( $_POST['custom_add_occasion'] ) ? 'filled' : '';
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
        $custom_add_colour_set = isset( $_POST['custom_add_colour'] ) ? 'filled' : '';
	?>
    
        <label for="custom_add_colour">Incorporate a favourite colour?</label>
        <input 
            type="text" 
            id="custom_add_colour" 
            name="custom_add_colour"
            value="<?php echo $custom_add_colour; ?> "
            class="<?php echo $custom_add_colour_set; ?>""
        />
    
    <?php

    // Message - custom_add_message
        $custom_add_message = isset( $_POST['custom_add_message'] ) ? sanitize_text_field( $_POST['custom_add_message'] ) : '';
        $custom_add_message_set = isset( $_POST['custom_add_message'] ) ? 'filled' : '';
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
 
add_filter( 'woocommerce_add_to_cart_validation', 'aimhigher_product_add_on_validation', 10, 3 );
 
function aimhigher_product_add_on_validation( $passed, $product_id, $qty ){
   if( isset( $_POST['pa_flavours'] ) == '' ) {
      wc_add_notice( 'You need to select what flavour of cake you want', 'error' );
      $passed = false;
   }
   if( isset( $_POST['pa_decorations'] ) == '' ) {
        wc_add_notice( 'You need to select what decorations you want on your cake', 'error' );
        $passed = false;
    }
    if($_POST['pa_decorations'] == 'Message'  && isset( $_POST['custom_theme_message']) == '') {
        wc_add_notice( 'You need to let us know what message you want on the cake ', 'error' );
        $passed = false;
    }
   return $passed;
}
 
// -----------------------------------------
// 3. Save custom input field value into cart item data
 
add_filter( 'woocommerce_add_cart_item_data', 'aimhigher_product_add_on_cart_item_data', 10, 2 );
 
function aimhigher_product_add_on_cart_item_data( $cart_item, $product_id ){
    // Flavour - pa_flavours
    if( isset( $_POST['pa_flavours'] ) ) {
        $cart_item['pa_flavours'] = $_POST['pa_flavours'];
    }
    
    // Theme - pa_decorations
    if( isset( $_POST['pa_decorations'] ) ) {
        $cart_item['pa_decorations'] = $_POST['pa_decorations'];
    }
    
    // Message - custom_theme_message
    if( isset( $_POST['custom_theme_message'] ) ) {
        $cart_item['custom_theme_message'] = sanitize_text_field( $_POST['custom_theme_message'] );
	}
    
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
    // Flavour - pa_flavours
    if ( isset( $cart_item['pa_flavours'] ) ){
        $data[] = array(
            'name' => 'Flavour',
            'value' => $cart_item['pa_flavours']
        );
    }
    
    // Theme - pa_decorations
    if ( isset( $cart_item['pa_decorations'] ) ){
        $data[] = array(
            'name' => 'Theme',
            'value' => $cart_item['pa_decorations']
        );
    }

    // Message - custom_theme_message
    if ( isset( $cart_item['custom_theme_message'] ) ){
        $data[] = array(
            'name' => 'Cake Message',
            'value' => sanitize_text_field( $cart_item['custom_theme_message'] )
        );
	}
    
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
            'name' => 'Card Message',
            'value' => sanitize_text_field( $cart_item['custom_add_message'] )
        );
	}


    return $data;
}
 
// -----------------------------------------
// 5. Save custom input field value into order item meta
 
add_action( 'woocommerce_add_order_item_meta', 'aimhigher_product_add_on_order_item_meta', 10, 2 );
 
function aimhigher_product_add_on_order_item_meta( $item_id, $values ) {
    // Flavour - pa_flavours
    if ( ! empty( $values['pa_flavours'] ) ) {
        wc_add_order_item_meta( $item_id, 'Flavour', $values['pa_flavours'], true );
    }
    
    // Theme - pa_decorations
    if ( ! empty( $values['pa_decorations'] ) ) {
        wc_add_order_item_meta( $item_id, 'Theme', $values['pa_decorations'], true );
    }

    // Message - custom_theme_message
    if ( ! empty( $values['custom_theme_message'] ) ) {
        wc_add_order_item_meta( $item_id, 'Cake Message', $values['custom_theme_message'], true );
	}

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
        wc_add_order_item_meta( $item_id, 'Card Message', $values['custom_add_message'], true );
	}
}
 
// -----------------------------------------
// 6. Display custom input field value into order table
 
add_filter( 'woocommerce_order_item_product', 'aimhigher_product_add_on_display_order', 10, 2 );
 
function aimhigher_product_add_on_display_order( $cart_item, $order_item ){
    // Flavour - pa_flavours
    if( isset( $order_item['pa_flavours'] ) ){
        $cart_item['pa_flavours'] = $order_item['pa_flavours'];
    }
    
    // Theme - pa_decorations
    if( isset( $order_item['pa_decorations'] ) ){
        $cart_item['pa_decorations'] = $order_item['pa_decorations'];
    }

    // Message - custom_theme_message
    if( isset( $order_item['custom_theme_message'] ) ){
        $cart_item['custom_theme_message'] = $order_item['custom_theme_message'];
	}

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
    // Flavour - pa_flavours
    $fields['pa_flavours'] = 'Flavour';
    
    // Theme - pa_decorations
    $fields['pa_decorations'] = 'Theme';

    // Message - custom_theme_message
    $fields['custom_theme_message'] = 'Cake Message';

    // Gluten Free - custom_add_gluten_free
    $fields['custom_add_gluten_free'] = 'Gluten Free';

    // Allergies - custom_add_allergies
    $fields['custom_add_allergies'] = 'Allergies';

    // Occasion - custom_add_occasion
    $fields['custom_add_occasion'] = 'Occasion';
    
    // Colour - custom_add_colour
    $fields['custom_add_colour'] = 'Colour';

    // Message - custom_add_message
    $fields['custom_add_message'] = 'Card Message';

    return $fields; 
}

?>