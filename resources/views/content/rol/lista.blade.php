@extends('layouts.master')

@section('title')
    @lang('Roles')
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
            Roles
        @endslot
        @slot('title')
            Lista de roles
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-2 ml-auto">
            <span class="btn btn-primary" id="addRol">+ Agregar rol</span>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($roles as $key => $rol)
                                <tr id="tr[{{ $key }}]" class="tr-option" data-id="{{ $rol->id }}">
                                    <td>{{ $rol->descripcion }}</td>
                                    <td class="text-center">
                                        <span
                                            class="btn btn-sm btn-outline-{{ $rol->estado == 1 ? 'success' : 'danger' }}">{{ $rol->estado == 1 ? 'Activo' : 'Suspendido' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-3"></div>
    </div> <!-- end row -->

    <div class="modal fade modal-rol" tabindex="-1" role="dialog" aria-labelledby="usuarioModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioTittle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="formRol">
                        <input type="text" class="form-control d-none" id="id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="descripcion">ROL</label>
                                <input type="text" class="form-control" id="descripcion" placeholder="Ingrese ROL">
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
            const addRol = $('#addRol');
            const trOption = $('.tr-option');

            const modalRol = $('.modal-rol');
            const modalTittle = $('#modalUsuarioTittle');
            const formRol = $('#formRol');

            const btnGuardar = $('.btn-guardar');



            const id = $('#id');
            const descripcion = $('#descripcion');
            const estado = $('#estado');

            trOption.dblclick(function() {
                formRol[0].reset();
                modalTittle.html('Editar rol');
                $('.edit').removeClass('d-none');
                const id = $(this).data('id');
                buscar(id);
                modalRol.modal('show');
            });

            addRol.on('click', function() {
                formRol[0].reset();
                modalTittle.html('Agregar rol');
                modalRol.modal('show');
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

            descripcion.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            const isValid = () => {
                let valid = true;

                if (descripcion.val() == '') {
                    descripcion.addClass('is-invalid');
                    (descripcion.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                return valid;
            }

            const insertar = async () => {
                try {
                    const url = window.location.origin + '/rol-agregar';

                    const data = {
                        descripcion: descripcion.val()
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
                        toastr.success('Rol registrado correctamente.', 'Exito');

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
                    const url = window.location.origin + '/rol-buscar';

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
                        const rol = await response.json();
                        cargar(rol);
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
                descripcion.val(data.descripcion);
                estado.val(data.estado);
            }

            const editar = async () => {
                try {
                    const url = window.location.origin + '/rol-editar';

                    let data = {
                        id: id.val(),
                        descripcion: descripcion.val(),
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
                        toastr.success('Rol editado correctamente.', 'Exito');

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
