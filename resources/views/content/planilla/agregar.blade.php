@extends('layouts.master')

@section('title')
	@lang('Planilla')
@endsection

@section('css')
	<!-- DataTables -->
	<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

	<!-- Responsive datatable examples -->
	<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	@component('components.breadcrumb')
		@slot('li_1')
			Pago planilla
		@endslot
		@slot('title')
			Agregar
		@endslot
	@endcomponent

	<div class="row">
		<div class="col-3"></div>
		<div class="col-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12 mb-3">
							<label for="docente_id">Docente</label>
							<select name="docente_id" id="docente_id" class="form-select">
								@foreach ($docentes as $docente)
									<option value="{{ $docente->id }}">{{ $docente->nombres . ' ' . $docente->apellidos }}
									</option>
								@endforeach
							</select>
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-6 mb-3">
							<label for="ciclo_escolar_id">Ciclo escolar</label>
							<select name="ciclo_escolar_id" id="ciclo_escolar_id" class="form-select">
								<option value="" style="display: none"></option>
								@foreach ($ciclos_escolares as $ciclo_escolar)
									<option value="{{ $ciclo_escolar->id }}" data-estado="{{ $ciclo_escolar->estado }}" data-inicio="{{ $ciclo_escolar->inicio }}" data-fin="{{ $ciclo_escolar->fin }}">
										{{ $ciclo_escolar->description }}</option>
								@endforeach
							</select>
							<div class="invalid-feedback"></div>
						</div>
						<div class="col-6">
							<label for="archivo">Archivo</label>
							<input class="form-control" type="file" accept=".pdf,.jpg,.png" id="inparchivo" required>
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-6 mb-3">
							<label for="imponible">Mnt. Imponible</label>
							<input class="form-control" type="number" min="1" id="imponible" name="imponible">
							<div class="invalid-feedback"></div>
						</div>
						<div class="col-6 mb-3">
							<label for="haberes">Mnt. Haberes</label>
							<input class="form-control" type="number" min="1" id="haberes" name="haberes">
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<label for="liquido">Mnt. Liquido</label>
							<input class="form-control" type="number" min="1" id="liquido" name="liquido">
							<div class="invalid-feedback"></div>
						</div>
						<div class="col-6">
							<label for="fecha">Mes</label>
							<select name="fecha" id="fecha" class="form-select"></select>
							<div class="invalid-feedback"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-6 mb-3">
							<label for="description">Descripcion pago</label>
							<textarea name="observacion" id="description" cols="30" rows="4" class="form-control"></textarea>
							<div class="invalid-feedback"></div>
						</div>
						<div class="col-6 mb-3">
							<label for="observacion">Observacion</label>
							<textarea name="observacion" id="observacion" cols="30" rows="4" class="form-control" placeholder="(Opcional)"></textarea>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" id="guardar">Guardar</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script>
		jQuery(function() {
			const docente = $('#docente_id');
			const ciclo = $('#ciclo_escolar_id');
			const inpArchivo = $('#inparchivo');
			const imponible = $('#imponible');
			const haberes = $('#haberes');
			const liquido = $('#liquido');
			const fecha = $('#fecha');
			const description = $('#description');
			const observacion = $('#observacion');
			const btnguardar = $('#guardar');

			inpArchivo.on('change', function() {
				$(this).removeClass('is-invalid');
			});

			imponible.on('input', function() {
				$(this).removeClass('is-invalid');
			});

			haberes.on('input', function() {
				$(this).removeClass('is-invalid');
			});

			liquido.on('input', function() {
				$(this).removeClass('is-invalid');
			});

			description.on('input', function() {
				$(this).removeClass('is-invalid');
			});

			ciclo.on('input', function() {
				$(this).removeClass('is-invalid');

				const fechaInicio = $(this).find('option:selected').data('inicio');
				const fechaFIn = $(this).find('option:selected').data('fin');

				const meses = obtenerMesesEntreFechas(fechaInicio, fechaFIn)
				fecha.empty();
				const anioActual = new Date().getFullYear();
				$.each(meses, function(index, mes) {
					const opcion = $('<option></option>').text(mes + ' ' + anioActual).val(mes +
						' ' + anioActual);
					fecha.append(opcion);
				});
			});

			btnguardar.on('click', function() {
				if (!isValid()) {
					return;
				}
				insertar();
			});

			function isValid() {
				let valid = true;

				if (description.val() == '') {
					description.addClass('is-invalid');
					(description.next('.invalid-feedback')).text('Este campo es requerido.');

					valid = false;
				}

				if (ciclo.val() == '') {
					ciclo.addClass('is-invalid');
					(ciclo.next('.invalid-feedback')).text('Este campo es requerido.');

					valid = false;
				}

				if (imponible.val() == '') {
					imponible.addClass('is-invalid');
					(imponible.next('.invalid-feedback')).text('Este campo es requerido.');

					valid = false;
				}

				if (haberes.val() == '') {
					haberes.addClass('is-invalid');
					(haberes.next('.invalid-feedback')).text('Este campo es requerido.');

					valid = false;
				}

				if (liquido.val() == '') {
					liquido.addClass('is-invalid');
					(liquido.next('.invalid-feedback')).text('Este campo es requerido.');

					valid = false;
				}

				if (inpArchivo.val() == '') {
					inpArchivo.addClass('is-invalid');
					(inpArchivo.next('.invalid-feedback')).text('Este campo es requerido.');

					valid = false;
				}

				const archivoInput = inpArchivo[0];
				const archivo = archivoInput.files[0];
				const maxSizeBytes = 5 * 1024 * 1024; // 5MB

				if (inpArchivo.val() != '' && archivo.size > maxSizeBytes) {
					inpArchivo.addClass('is-invalid');
					(inpArchivo.next('.invalid-feedback')).text(
						'El archivo seleccionado es demasiado grande. El tamaño máximo permitido es 5MB.');
				}

				return valid;
			}

			const insertar = async () => {
				try {
					const url = window.location.origin + '/planilla-insertar';

					const archivoInput = inpArchivo[0];
					const archivo = archivoInput.files[0];

					const formData = new FormData();
					formData.append('docente_id', docente.val());
					formData.append('ciclo_escolar_id', ciclo.val());
					formData.append('description', description.val());
                    formData.append('imponible', imponible.val());
					formData.append('haberes', haberes.val());
					formData.append('liquido', liquido.val());
					formData.append('fecha', fecha.val());
					formData.append('archivo', archivo);
					formData.append('observacion', observacion.val());

					const response = await sendData(url, formData);
					toastr.success(response, 'Error');
					setTimeout(() => {
						location.reload();
					}, 1000);
				} catch (error) {
					toastr.error(error, 'Error');
				}
			}

			function obtenerMesesEntreFechas(fechaInicio, fechaFin) {
				fechaInicio = new Date(fechaInicio);
				fechaFin = new Date(fechaFin);

				const meses = [];

				const iterDate = new Date(fechaInicio);
				iterDate.setDate(1);

				while (iterDate <= fechaFin) {
					const mes = iterDate.toLocaleString('default', {
						month: 'long'
					});
					meses.push(mes);

					iterDate.setMonth(iterDate.getMonth() + 1);
				}

				return meses;
			}

			function sendData(url, formData) {
				return new Promise(function(resolve, reject) {
					$.ajax({
						url: url,
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						success: function(response) {
							resolve(response);
						},
						error: function(error) {
							reject(error);
						}
					});
				});
			}
		});
	</script>
@endsection
