const changeCakeSize = (e) => {
	document.querySelector('form.cake-order').setAttribute('action', `/shop/${e.id}`)

	document.querySelector('.product-price').innerHTML = e.price

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
		}
		else if (!gfField.classList.contains('hidden')) {
			gfField.classList.add('hidden')
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
		else if (document.querySelector('.description.flavour')) {
			document.querySelector('.description.flavour').innerHTML = `<h2>${e.getAttribute('data-name')}</h2><p>${e.getAttribute('data-description')}</p>`
		}


	}
}