$(document).ready(function () {
	setTimeout(function () {
		$('#container').addClass('sign-in');
	}, 200);

	window.toggle = function () {
		$('#container').toggleClass('sign-in');
		$('#container').toggleClass('sign-up');
	};

	// REGISTRO
	$('.sign-up button').click(function (e) {
		e.preventDefault();
		const username = $('.sign-up input[placeholder="Nombre de usuario"]').val();
		const email = $('.sign-up input[placeholder="Correo electrónico"]').val();
		const password = $('.sign-up input[placeholder="Contraseña"]').val();
		const confirm = $('.sign-up input[placeholder="Confirmar contraseña"]').val();

		if (password !== confirm) {
			alert('Las contraseñas no coinciden');
			return;
		}

		$.post('register.php', {
			username: username,
			email: email,
			password: password
		}, function (response) {
			if (response === "success") {
				alert("Registro exitoso");
				toggle();
			} else {
				alert("Error al registrar (posiblemente usuario ya existe)");
			}
		});
	});

	// LOGIN
	$('.sign-in button').click(function (e) {
		e.preventDefault();
		const username = $('.sign-in input[placeholder="Nombre de usuario"]').val();
		const password = $('.sign-in input[placeholder="Contraseña"]').val();

		$.post('login.php', {
			username: username,
			password: password
		}, function (response) {
			if (response === "success") {
				window.location.href = "welcome.php";
			} else {
				alert("Credenciales incorrectas");
			}
		});
	});
});
