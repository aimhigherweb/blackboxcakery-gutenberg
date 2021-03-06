<?php

function custom_attributes_route($data) {
	$attributes = get_terms( array(
		'taxonomy' => $data['id']
	) );

	if(empty($attributes)) {
		return null;
	}

	$acf = [];

	foreach ($attributes as $att) {		
		$id = $data['id'] . '_' . $att->term_taxonomy_id;
		$att->image = get_field('image', $id);
		$att->variation_image = get_field('variation_image', $id);
		$att->gluten_free = get_field('gluten_free', $id);

		array_push($acf, $att);
	};

	return $acf;
}

add_action('rest_api_init', function () {
	register_rest_route('bbc/v1', 'attributes/(?P<id>(\w|\d|_)+)', array(
		'methods' => 'GET',
		'callback' => 'custom_attributes_route'
	));
});

?>