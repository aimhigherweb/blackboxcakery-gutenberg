const changeCakeSize = (e) => {
	document.querySelector('form.cake-order').setAttribute('action', `/shop/${e.id}`)

	document.querySelector('.product-price span').innerHTML = e.price

	document.querySelector('form button[type="submit"]').disabled = false
}

const changeOrderFields = () => {
	document.querySelectorAll('form.cart .filled').forEach(input => {
		input.classList.remove('filled')
	})
}

const changeFlavour = (e) => {
	if (e.name == 'pa_flavours') {
		// Show/hide Gluten Free field
		const gfField = document.querySelector('fieldset.gluten')
		if (e.getAttribute('data-gf') == 'true') {
			gfField.classList.remove('hidden')

			gfField.querySelectorAll('input').forEach(input => {
				input.disabled = false
			})
		}
		else if (!gfField.classList.contains('hidden')) {
			gfField.classList.add('hidden')

			gfField.querySelectorAll('input').forEach(input => {
				input.disabled = true
			})
		}

		// Change Featured Gallery image to selected flavour
		let gallery = false

		if (document.querySelector('.gallery')) {
			gallery = document.querySelector('.gallery')
		}
		else if (document.querySelector('.woocommerce-product-gallery__wrapper')) {
			gallery = document.querySelector('.woocommerce-product-gallery__wrapper')
		}

		if (gallery) {
			if (gallery.querySelector('img.featured')) {
				gallery.querySelector('img.featured').src = e.getAttribute('data-variation_image')
			}
			else {
				const featuredImage = document.createElement('img')

				featuredImage.classList.add('featured')
				featuredImage.src = e.getAttribute('data-variation_image')
				gallery.prepend(featuredImage)
			}
		}

		// Change/set flavour description
		if (document.querySelector('.description.pa_flavours')) {
			document.querySelector('.description.pa_flavours').innerHTML = `<h2>${e.getAttribute('data-name')}</h2><p>${e.getAttribute('data-description')}</p>`
		}
	}
	else if (e.name == 'pa_decorations') {
		const messageField = document.querySelector('fieldset.message')

		if (e.value == 'message') {
			messageField.classList.remove('hidden')

			messageField.querySelectorAll('input').forEach(input => {
				input.disabled = false
			})
		}
		else if (!messageField.classList.contains('hidden')) {
			messageField.classList.add('hidden')

			messageField.querySelectorAll('input').forEach(input => {
				input.disabled = true
			})
		}
	}
}