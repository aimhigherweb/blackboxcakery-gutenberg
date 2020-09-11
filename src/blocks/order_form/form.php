<?php
	$attributes = get_object_taxonomies('product', 'object');

	$attributes = array_filter($attributes, function($att) {
		$name = $att->name;

		return preg_match("/^pa_/", $name);
	});

	$attributes = array_reverse($attributes);

	$description = '';
	$gallery = array();

	$cakes = wc_get_products(array());

	foreach($cakes as $cake) {
		if($cake->slug == 'cake-large') {
			$cake->short_description;
		}

		if(!in_array($cake->image_id, $gallery)) {
			array_push($gallery, $cake->image_id);
		}

		foreach($cake->gallery_image_ids as $img) {
			if(!in_array($img, $gallery)) {
				array_push($gallery, $img);
			}
		}
	}

	if($description == '') {
		$description = $cakes[0]->short_description;
	}		
?>

<div class="order-form">
	<div class="gallery">
		<?php
		
		foreach($gallery as $img) {
			echo '<img src="' . wp_get_attachment_image_src($img, 'cake_image')[0] . '" />';
		}
		
		?>
	</div>

	<div class="description main"><?php echo $description; ?></div>
	<div class="description pa_flavours"></div>
	<div class="description pa_decorations"></div>

	<form class="cake-order" action="/shop/cake-large/" method="post">
		<fieldset class="cake-size">
			<div>
				<legend required>Cake Size</legend>
				<?php
				foreach($cakes as $cake):
					$id = 'cake-size_' . $cake->slug;
					$size = get_field('size', $cake->id);
				?>

					<input
						name="cake_size"
						id="<?php echo $id ?>" 
						value="<?php echo $cake->slug ?>" 
						type="radio"
						onclick="changeCakeSize({id: this.value, price: <?php echo $cake->price; ?> })"
						data-name="<?php echo $cake->name ?>" 
					/>
					<label for="<?php echo $id ?>"><?php echo $cake->name; ?> <small class="size">(<?php echo $size ?>)</small></label>

				<? endforeach; ?>
			</div>
		</fieldset>

		<input type="hidden" name="flavour_description" disabled />

		<div class="options">
			<?php
			
			foreach ($attributes as $att):
				$slug = $att->name;
				$name = preg_replace("/Product /", "", $att->label);

				$terms = get_terms( array(
					'taxonomy' => $slug
				) );

			?>

				<fieldset class="<?php echo $slug;?>">
					<div>
						<legend required>Choose Your <?php echo $name;?></legend>
						<?php
							foreach ($terms as $term):
								$id = $slug . '_' . $term->term_taxonomy_id;
								$term->image = get_field('image', $id);
								$term->variation_image = get_field('variation_image', $id);
								$term->gluten_free = get_field('gluten_free', $id) ? 'true' : 'false';
				
							?>
								<input
									name="<?php echo $slug ?>" 
									id="<?php echo $id ?>" 
									value="<?php echo $term->name; ?>" 
									type="radio" 
									onclick="changeFlavour(this)"
									data-name="<?php echo $term->name; ?>" 
									data-variation_image="<?php echo $term->variation_image['sizes']['medium_large']; ?>"
									data-description="<?php echo $term->description; ?>"
									data-gf="<?php echo $term->gluten_free; ?>"
								/>
								<label 
									for="<?php echo $id ?>"
									style="background-image: url(<?php echo $term->image['sizes']['thumbnail']; ?>)"
								>
									<span><?php echo $term->name; ?></span>
								</label>
							<?php endforeach; ?>
					</div>
				</fieldset>
				
			<?php endforeach;
			
			?>
		</div>

		<fieldset class="message hidden">
			<div class="block">
				<label for="custom_theme_message" required>What message would you like on the cake?</label>
				<input type="text" id="custom_theme_message" name="custom_theme_message" disabled />
			</div>
		</fieldset>

		<fieldset class="gluten hidden">
			<div>
				<legend>Gluten Free?</legend>
				<input type="radio" id="custom_add_gluten_free_yes" value="yes" name="custom_add_gluten_free" disabled />
				<label for="custom_add_gluten_free_yes">Yes</label>
				<input type="radio" id="custom_add_gluten_free_no" value="no" name="custom_add_gluten_free" disabled checked />
				<label for="custom_add_gluten_free_yes">No</label>
			</div>
		</fieldset>

		<label htmlFor="custom_add_allergies">Are there any allergies we need to be aware of?</label>
		<input type="text" id="custom_add_allergies" name="custom_add_allergies" />

		<label htmlFor="custom_add_occasion">What's the Occasion?</label>
		<input type="text" placeholder="Birthday, Anniversay, Tuesday, etc" name="custom_add_occasion" />

		<label for="custom_add_colour">Incorporate a favourite colour?</label>
		<input type="text" id="custom_add_colour" name="custom_add_colour" />

		<label for="custom_add_message">Message for gift tag</label>
		<textarea id="custom_add_message" name="custom_add_message"></textarea>

		<dl>
			<dt>Price:</dt>
			<dd class="product-price">$<span>Select a cake size to view the price</span></dd>
		</dl>

		<button type="submit" disabled>Order Cake</button>

	</form>
</div>

<?