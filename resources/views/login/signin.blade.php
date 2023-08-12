@extends('layouts.master-without-nav')

@section('title')
	@lang('Login')
@endsection

@section('body')

	<body>
	@endsection

	@section('content')
		<div class="account-pages my-5 pt-sm-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8 col-lg-6 col-xl-5">
						<div class="card overflow-hidden">
							<div class="bg-primary bg-soft">
								<div class="row">
									<div class="col-7">
										<div class="text-primary p-4">
											<h5 class="text-primary">Sistema planilla</h5>
											<p>Ingrese sus datos para acceder</p>
										</div>
									</div>
									<div class="col-5 align-self-end">
										<img src="{{ URL::asset('/build/images/profile-img.png') }}" alt="" class="img-fluid">
									</div>
								</div>
							</div>
							<div class="card-body pt-0">
								<div class="auth-logo">
									<a href="javascript:void(0);" class="auth-logo-light">
										<div class="avatar-md profile-user-wid mb-4">
											<span class="avatar-title rounded-circle bg-light">
												<img src="{{ URL::asset('/build/images/logo-light.svg') }}" alt="" class="rounded-circle" height="34">
											</span>
										</div>
									</a>

									<a href="javascript:void(0);" class="auth-logo-dark">
										<div class="avatar-md profile-user-wid mb-4">
											<span class="avatar-title rounded-circle bg-light">
												<img src="{{ URL::asset('/build/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
											</span>
										</div>
									</a>
								</div>
								<div class="p-2">
									<form class="form-horizontal needs-validation" novalidate>
										<div class="mb-3">
											<label for="username" class="form-label">Usuario</label>
											<input type="text" class="form-control" id="username" placeholder="Ingrese usuario" required>
											<div class="invalid-feedback">
												Ingrese un usuario
											</div>
										</div>

										<div class="mb-3">
											<label class="form-label">Contraseña</label>
											<div class="input-group auth-pass-inputgroup">
												<input type="password" id="password" class="form-control" placeholder="Ingrese contraseña" aria-label="Password" aria-describedby="password-addon" required>
												<button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
												<div class="invalid-feedback">
													Ingrese una contraseña
												</div>
											</div>
										</div>

										<div class="mt-3 d-grid">
											<button class="btn btn-primary waves-effect waves-light" type="button" id="signin">Acceder</button>
										</div>
										<br>
										<br>
										<div class="alert alert-success d-none text-center" role="alert" id="alerValid">
										</div>
										<div class="alert alert-danger d-none text-center" role="alert" id="alertInvalid">
										</div>
									</form>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end account-pages -->
	@endsection

	<script type="text/javascript">
		window.addEventListener('load', function() {

			const $btn = $('#signin');
			const $username = $('#username');
			const $password = $('#password');

			const alertSuccess = $('#alerValid');
			const alertError = $('#alertInvalid');

			$btn.on('click', function() {
				if (valid()) {
					alertError.addClass('d-none');
					login();
				}
			});

			const valid = () => {
				const username = $username.val();
				const password = $password.val();

				if (username == '' || password == '') {
					alertError.removeClass('d-none');
					alertError.html('Ingrese todos los campos.')

					return false;
				}

				return true;
			}

			const login = async () => {
				const url = window.location.origin + '/login';
				const data = {
					username: $username.val(),
					password: $password.val()
				};

				try {
					const response = await fetch(url, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

						},
						body: JSON.stringify(data)
					});

					if (response.ok) {
						alertSuccess.removeClass('d-none');
						alertSuccess.html('Accedo correcto...');
						window.location.href = "/index";
					} else {
						const errorResponse = await response.json();
						throw new Error(errorResponse);
					}
				} catch (error) {
					alertError.removeClass('d-none');
					alertError.html(error)
				}
			}


			$password.keypress(function(event) {
				if (event.which === 13) {
					if (valid()) {
						alertError.addClass('d-none');
						login();
					}
				}
			});

			$username.keypress(function(event) {
				if (event.which === 13) {
					if (valid()) {
						alertError.addClass('d-none');
						login();
					}
				}
			});

		});
	</script>
