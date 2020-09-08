const Form = ({ options, cakes, gallery, description }) => {
	// options.sort((a, b) => {
	// 	if (a.slug < b.slug) {
	// 		return false
	// 	}
	// 	return true
	// })

	return (
		<div className="order-form">
			{/* <div className="gallery">
				{gallery.map(img => (
					<img src={img.image} />
				))}
			</div> */}

			<div className="description main" dangerouslySetInnerHTML={{ __html: description }} />
			<div className="description pa_flavours"></div>
			<div className="description pa_themes"></div>

			<form className="cake-order" action="/shop/cake-large/" method="post">
				<fieldset className="cake-size">
					<div>
						<legend>Cake Size</legend>
						{cakes.map(opt => (
							<>
								<input
									name="cake_size"
									id={`cake-size_${opt.slug}`}
									value={opt.slug}
									type="radio"
									onClick={`changeCakeSize({id: this.value, price: ${opt.price}})`}
									data-name={opt.title.raw}
									data-price={opt.price}
									data-size={opt.acf.size}
								/>
								<label htmlFor={`cake-size_${opt.slug}`}>{opt.title.raw}</label></>
						))}
					</div>
				</fieldset>

				{/* <div className="options">
					{options.map(opt => (
						<fieldset className={opt.slug}>
							<div>
								<legend data-slug={opt.slug}>{opt.name}</legend>
								{opt.terms.map(term => (
									<>
										<input
											name={opt.slug}
											id={`${opt.slug}-${term.slug}`}
											value={term.slug}
											type="radio"
											onClick={`changeFlavour(this)`}
											data-name={term.name}
											data-variation_image={term.variation_image}
											data-image={term.image}
											data-description={term.description}
											data-gf={term.gluten_free}
										/>
										<label
											htmlFor={`${opt.slug}-${term.slug}`}
											style={{ backgroundImage: `url(${term.image})` }}
										>
											<span>{term.name}</span>
										</label>
									</>
								))}
							</div>
						</fieldset>
					))}
				</div> */}

				<fieldset class="message hidden">
					<label for="custom_theme_message">What message would you like on the cake?</label>
					<input type="text" id="custom_theme_message" name="custom_theme_message" />
				</fieldset>

				<fieldset class="gluten hidden">
					<div>
						<legend>Gluten Free?</legend>
						<input type="radio" id="custom_add_gluten_free_yes" value="yes" name="custom_add_gluten_free" />
						<label for="custom_add_gluten_free_yes">Yes</label>
						<input type="radio" id="custom_add_gluten_free_no" value="no" name="custom_add_gluten_free" checked />
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
					<dd>$<span className="product-price">Select a cake size to view the price</span></dd>
				</dl>

				<button type="submit" disabled>Order Cake</button>

			</form>
		</div>

	)
}

export default Form