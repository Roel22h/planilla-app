@extends('layouts.master')

@section('title')
    @lang('Docentes')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Docentes
        @endslot
        @slot('title')
            Lista de docentes
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-2 ml-auto">
            <span class="btn btn-primary" id="addDocente">+ Agregar docente</span>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Institucion</th>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Asignatura</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($docentes as $key => $docente)
                                <tr id="tr[{{ $key }}]" class="tr-option" data-id="{{ $docente->id }}">
                                    <td>{{ $docente->institucion->descripcion }}</td>
                                    <td>{{ $docente->dni }}</td>
                                    <td>{{ $docente->nombres }}</td>
                                    <td>{{ $docente->apellidos }}</td>
                                    <td>{{ $docente->direccion }}</td>
                                    <td>{{ $docente->telefono }}</td>
                                    <td>{{ $docente->asignatura }}</td>
                                    <td class="text-center">
                                        <span
                                            class="btn btn-sm btn-outline-{{ $docente->estado == 1 ? 'success' : 'danger' }}">{{ $docente->estado == 1 ? 'Activo' : 'Suspendido' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-2"></div>
    </div> <!-- end row -->

    <div class="modal fade modal-rol" tabindex="-1" role="dialog" aria-labelledby="usuarioModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInstitucionTittle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDocente">
                        <input type="text" class="form-control d-none" id="id">
                        <div class="row">
                            <div class="col-12">
                                <label for="intitucion_id">Institución</label>
                                <select name="institucion_id" id="institucion_id" class="form-select mb-3">
                                    @foreach ($instituciones as $institucion)
                                        <option value="{{ $institucion->id }}">{{ $institucion->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control" id="dni" placeholder="Ingrese DNI">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-8">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" id="nombres" placeholder="Ingrese NOMBRES">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="rol">
                            <div class="col-12 mb-3">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" placeholder="Ingrese APELLIDOS">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="direccion">Direccion</label>
                                <input type="text" class="form-control" id="direccion" placeholder="(Opcional)">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="telefono">Telefono</label>
                                <input type="text" class="form-control" id="telefono" placeholder="(Opcional)">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="asignatura">Asignatura</label>
                                <select name="asignatura" id="asignatura" class="form-select">
                                    <option value="Matematicas">Matemáticas</option>
                                    <option value="Comunicacion">Comunicación</option>
                                    <option value="Ciencias Naturales">Ciencias Naturales</option>
                                    <option value="Ciencias Sociales">Ciencias Sociales</option>
                                    <option value="Lenguaje">Lenguaje</option>
                                    <option value="Historia">Historia</option>
                                    <option value="Geografia">Geografía</option>
                                    <option value="Educacion Fisica">Educación Física</option>
                                    <option value="Artes Plasticas">Artes Plásticas</option>
                                    <option value="Musica">Música</option>
                                    <option value="Educacion Etica">Educación Ética</option>
                                    <option value="Educacion Religiosa">Educación Religiosa</option>
                                    <option value="Tecnologia">Tecnología</option>
                                    <option value="Informatica">Informática</option>
                                    <option value="Ingles">Inglés</option>
                                    <option value="Frances">Francés</option>
                                    <option value="Quimica">Química</option>
                                    <option value="Fisica">Física</option>
                                    <option value="Biologia">Biología</option>
                                    <option value="Economia">Economía</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="row edit d-none">
                                    <div class="col-12">
                                        <label for="estado">Estado</label>
                                        <select name="estado" id="estado" class="form-select">
                                            <option value="1">Activo</option>
                                            <option value="0">Suspendido</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-guardar">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}">
        hidden
    </script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/build/js/pages/datatables.init.js') }}"></script>

    <script>
        jQuery(function() {
            const addDocente = $('#addDocente');
            const trOption = $('.tr-option');

            const modalDocente = $('.modal-rol');
            const modalTittle = $('#modalInstitucionTittle');
            const formDocente = $('#formDocente');

            const btnGuardar = $('.btn-guardar');

            const id = $('#id');
            const institucion_id = $('#institucion_id');
            const dni = $('#dni');
            const nombres = $('#nombres');
            const apellidos = $('#apellidos');
            const direccion = $('#direccion');
            const telefono = $('#telefono');
            const asignatura = $('#asignatura');
            const estado = $('#estado');

            trOption.dblclick(function() {
                formDocente[0].reset();
                modalTittle.html('Editar docente');
                $('.edit').removeClass('d-none');
                const id = $(this).data('id');
                buscar(id);
                modalDocente.modal('show');
            });

            addDocente.on('click', function() {
                formDocente[0].reset();
                $('.edit').addClass('d-none');
                modalTittle.html('Agregar docente');
                modalDocente.modal('show');
            });

            btnGuardar.on('click', function() {
                if (!isValid()) {
                    return false;
                }

                if (id.val()) {
                    editar();
                } else {
                    insertar();
                }
            });

            dni.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            nombres.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            apellidos.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            asignatura.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            const isValid = () => {
                let valid = true;

                if (dni.val() == '') {
                    dni.addClass('is-invalid');
                    (dni.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (dni.val() != '' && ((dni.val()).length != 8)) {
                    dni.addClass('is-invalid');
                    (dni.next('.invalid-feedback')).text('Formato DNI incorrecto.');

                    valid = false;
                }


                if (nombres.val() == '') {
                    nombres.addClass('is-invalid');
                    (nombres.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (apellidos.val() == '') {
                    apellidos.addClass('is-invalid');
                    (apellidos.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (asignatura.val() == '') {
                    asignatura.addClass('is-invalid');
                    (asignatura.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                return valid;
            }

            const insertar = async () => {
                try {
                    const url = window.location.origin + '/docente-agregar';

                    const data = {
                        institucion_id: institucion_id.val(),
                        dni: dni.val(),
                        nombres: nombres.val(),
                        apellidos: apellidos.val(),
                        direccion: direccion.val(),
                        telefono: telefono.val(),
                        asignatura: asignatura.val()
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        toastr.success('Docente registrado correctamente.', 'Exito');

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        const errorResponse = await response.json();
                        throw new Error(errorResponse);
                    }
                } catch (error) {
                    toastr.error(error, 'Error');
                }
            }

            const buscar = async (id) => {
                try {
                    const url = window.location.origin + '/docente-buscar';

                    const data = {
                        id: id
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        const institucion = await response.json();
                        cargar(institucion);
                    } else {
                        const errorResponse = await response.json();
                        throw new Error(errorResponse);
                    }
                } catch (error) {
                    toastr.error(error, 'Error');
                }
            }

            const cargar = async (data) => {
                id.val(data.id);
                institucion_id.val(data.institucion_id);
                dni.val(data.dni);
                nombres.val(data.nombres);
                apellidos.val(data.apellidos);
                direccion.val(data.direccion);
                telefono.val(data.telefono);
                asignatura.val(data.asignatura);
                estado.val(data.estado);
            }

            const editar = async () => {
                try {
                    const url = window.location.origin + '/docente-editar';

                    let data = {
                        id: id.val(),
                        institucion_id: institucion_id.val(),
                        dni: dni.val(),
                        nombres: nombres.val(),
                        apellidos: apellidos.val(),
                        direccion: direccion.val(),
                        telefono: telefono.val(),
                        asignatura: asignatura.val(),
                        estado: estado.val()
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        toastr.success('Docente editado correctamente.', 'Exito');

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        const errorResponse = await response.json();
                        throw new Error(errorResponse);
                    }
                } catch (error) {
                    toastr.error(error, 'Error');
                }
            }
        });
    </script>
@endsection
