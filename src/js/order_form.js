const changeCakeSize = (e) => {
	document.querySelector('form.cake-order').setAttribute('action', `/shop/${e.id}`)

	document.querySelector('.product-price').innerHTML = e.price
}

const changeOrderFields = () => {
	document.querySelectorAll('form.cart .filled').forEach(input => {
		input.classList.remove('filled')
	})
}