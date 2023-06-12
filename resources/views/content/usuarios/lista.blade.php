@extends('layouts.master')

@section('title')
    @lang('Usuarios')
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
            Usuarios
        @endslot
        @slot('title')
            Lista usuarios
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-2 ml-auto">
            <span class="btn btn-primary" id="addUsuario">+ Agregar usuario</span>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($usuarios as $key => $usuario)
                                <tr id="tr[{{ $key }}]" class="tr-option" data-id="{{ $usuario->id }}">
                                    <td>{{ $usuario->dni }}</td>
                                    <td>{{ $usuario->nombres }}</td>
                                    <td>{{ $usuario->apellidos }}</td>
                                    <td>{{ $usuario->direccion }}</td>
                                    <td>{{ $usuario->telefono }}</td>
                                    <td>{{ $usuario->usuario }}</td>
                                    <td>{{ $usuario->rol->descripcion }}</td>
                                    <td class="text-center">
                                        <span
                                            class="btn btn-sm btn-outline-{{ $usuario->estado == 1 ? 'success' : 'danger' }}">{{ $usuario->estado == 1 ? 'Activo' : 'Suspendido' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="modal fade modal-usuario" tabindex="-1" role="dialog" aria-labelledby="usuarioModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioTittle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="formUsuario">
                        <input type="text" class="form-control d-none" id="id">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control" id="dni" placeholder="Ingrese DNI">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="nombres">NOMBRES</label>
                                <input type="text" class="form-control" id="nombres" placeholder="Ingrese nombres">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="apellidos">APELLIDOS</label>
                                <input type="text" class="form-control" id="apellidos" placeholder="Ingrese apellidos">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="direccion">DIRECCION</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Ingrese direccion">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="telefono">TELEFONO</label>
                                <input type="text" class="form-control" id="telefono" placeholder="Ingrese telefono">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="rol">ROL</label>
                                <select name="rol" id="rol" class="form-select">
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="usuario">USUARIO</label>
                                <input type="text" class="form-control" id="usuario" placeholder="Ingrese usuario">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-6">
                                <label for="contrasenia">CONTRASEÑA</label>
                                <input type="password" class="form-control" id="contrasenia"
                                    placeholder="Ingrese contraseña">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row edit d-none">
                            <div class="col-12">
                                <label for="estado">estado</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="1">Activo</option>
                                    <option value="0">Suspendido</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
            const addUsuario = $('#addUsuario');
            const trOption = $('.tr-option');

            const modalTittle = $('#modalUsuarioTittle');
            const modalUsuario = $('.modal-usuario');
            const btnGuardar = $('.btn-guardar');

            const formUsuario = $('#formUsuario');

            const id = $('#id');
            const rol = $('#rol');
            const dni = $('#dni');
            const nombres = $('#nombres');
            const apellidos = $('#apellidos');
            const direccion = $('#direccion');
            const telefono = $('#telefono');
            const usuario = $('#usuario');
            const contrasenia = $('#contrasenia');
            const estado = $('#estado');

            trOption.dblclick(function() {
                formUsuario[0].reset();
                modalTittle.html('Editar usuario');
                $('.edit').removeClass('d-none');
                const id = $(this).data('id');
                buscar(id);
                modalUsuario.modal('show');
            });

            addUsuario.on('click', function() {
                formUsuario[0].reset();
                modalTittle.html('Agregar usuario');
                modalUsuario.modal('show');
            });

            btnGuardar.on('click', function() {
                if (!isValid()) {
                    return false;
                }
                debugger
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

            direccion.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            telefono.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            usuario.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            contrasenia.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            const isValid = () => {
                let valid = true;
                // DNI
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

                // Nombres
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

                if (direccion.val() == '') {
                    direccion.addClass('is-invalid');
                    (direccion.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (telefono.val() == '') {
                    telefono.addClass('is-invalid');
                    (telefono.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (telefono.val() != '' && isNaN(telefono.val())) {
                    telefono.addClass('is-invalid');
                    (telefono.next('.invalid-feedback')).text('Formato telefono incorrecto.');

                    valid = false;
                }

                if (usuario.val() == '') {
                    usuario.addClass('is-invalid');
                    (usuario.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (contrasenia.val() == '') {
                    contrasenia.addClass('is-invalid');
                    (contrasenia.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                return valid;
            }

            const insertar = async () => {
                try {
                    const url = window.location.origin + '/usuario-agregar';

                    const data = {
                        rol_id: rol.val(),
                        dni: dni.val(),
                        nombres: nombres.val(),
                        apellidos: apellidos.val(),
                        direccion: direccion.val(),
                        telefono: telefono.val(),
                        usuario: usuario.val(),
                        contrasenia: contrasenia.val()
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
                        toastr.success('Usuario registrado correctamente.', 'Exito');

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
                    const url = window.location.origin + '/usuario-buscar';

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
                        const usuario = await response.json();
                        cargar(usuario);
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
                rol.val(data.rol_id);
                dni.val(data.dni);
                nombres.val(data.nombres);
                apellidos.val(data.apellidos);
                direccion.val(data.direccion);
                telefono.val(data.telefono);
                usuario.val(data.usuario);
                contrasenia.val('****');
                estado.val(data.estado);
            }

            const editar = async () => {
                try {
                    const url = window.location.origin + '/usuario-editar';

                    let data = {
                        id: id.val(),
                        rol_id: rol.val(),
                        dni: dni.val(),
                        nombres: nombres.val(),
                        apellidos: apellidos.val(),
                        direccion: direccion.val(),
                        telefono: telefono.val(),
                        usuario: usuario.val(),
                        estado: estado.val()
                    }

                    const tsst = contrasenia.val();
                    if (contrasenia.val() != '****') {
                        data.contrasenia = contrasenia.val()
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
                        toastr.success('Usuario editado correctamente.', 'Exito');

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
