(function () {
	'use strict';
	window.addEventListener('load', function () {
		var forms = document.getElementsByClassName('needs-validation');
		var validation = Array.prototype.filter.call(forms, function (form) {
			form.addEventListener('submit', function (event) {
				// event.preventDefault();
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				} else {
					signin();
				}
				form.classList.add('was-validated');
			}, false);
		});
	}, false);
})();


// parsley validation
$(document).ready(function () {
	$('.custom-validation').parsley();
});

const signin = () => {
	const user = $('#username').val();
	const pass = $('#password').val();

	console.log(user);
	console.log(pass);
}