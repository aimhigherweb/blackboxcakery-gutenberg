<?php
	// Create Shortcode
  function bbc_order_form() {
	ob_start();

	include( plugin_dir_path( __FILE__ ) . '../src/blocks/order_form/form.php');

	$content = ob_get_clean();

	return $content;
  }

  add_shortcode('order_form', 'bbc_order_form');
?>