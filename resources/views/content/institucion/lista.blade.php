@extends('layouts.master')

@section('title')
    @lang('Instituciones')
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
            Intituciones
        @endslot
        @slot('title')
            Lista de instituciones
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-2 ml-auto">
            <span class="btn btn-primary" id="addInstitucion">+ Agregar intitucion</span>
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
                                <th>Codigo modular</th>
                                <th>Institución</th>
                                <th>Niveles</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($instituciones as $key => $institucion)
                                <tr id="tr[{{ $key }}]" class="tr-option" data-id="{{ $institucion->id }}">
                                    <td>{{ $institucion->codigo }}</td>
                                    <td>{{ $institucion->descripcion }}</td>
                                    <td>{{ $institucion->niveles }}</td>
                                    <td class="text-center">
                                        <span
                                            class="btn btn-sm btn-outline-{{ $institucion->estado == 1 ? 'success' : 'danger' }}">{{ $institucion->estado == 1 ? 'Activo' : 'Suspendido' }}
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
                    <form action="" id="formInstitucion">
                        <input type="text" class="form-control d-none" id="id">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="codigo">Codigo modular</label>
                                <input type="text" class="form-control" id="codigo"
                                    placeholder="Ingrese CODIGO MODULAR">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-8">
                                <label for="descripcion">Institucion</label>
                                <input type="text" class="form-control" id="descripcion"
                                    placeholder="Ingrese INSTITUCION">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="niveles">Niveles</label>
                                <div class="form-check">
                                    <input class="form-check-input chb-from" type="checkbox" value=""
                                        id="nivelInicial">
                                    <label class="form-check-label" for="nivelInicial">Inicial</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input chb-from" type="checkbox" value=""
                                        id="nivelPrimaria">
                                    <label class="form-check-label" for="nivelPrimaria">Primaria</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input chb-from" type="checkbox" value=""
                                        id="nivelSecundaria">
                                    <label class="form-check-label" for="nivelSecundaria">Secundaria</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input chb-from" type="checkbox" value=""
                                        id="nivelNocturno">
                                    <label class="form-check-label" for="nivelNocturno">Nocturno</label>
                                </div>

                                <div class="d-none text-danger" id="msgCheck"></div>
                            </div>
                            <div class="col-6 edit d-none">
                                <label for="estado">Estado</label>
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
            const addInstitucion = $('#addInstitucion');
            const trOption = $('.tr-option');

            const modalInstitucion = $('.modal-rol');
            const modalTittle = $('#modalInstitucionTittle');
            const formInstitucion = $('#formInstitucion');

            const btnGuardar = $('.btn-guardar');



            const id = $('#id');
            const codigo = $('#codigo');
            const descripcion = $('#descripcion');

            const nivelInicial = $('#nivelInicial');
            const nivelPrimaria = $('#nivelPrimaria');
            const nivelSecundaria = $('#nivelSecundaria');
            const nivelNocturno = $('#nivelNocturno');
            const msgCheck = $('#msgCheck');

            const estado = $('#estado');

            trOption.dblclick(function() {
                formInstitucion[0].reset();
                modalTittle.html('Editar institución');
                $('.edit').removeClass('d-none');
                const id = $(this).data('id');
                buscar(id);
                modalInstitucion.modal('show');
            });

            addInstitucion.on('click', function() {
                formInstitucion[0].reset();
                modalTittle.html('Agregar institución');
                modalInstitucion.modal('show');
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

            codigo.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            descripcion.on('input', function() {
                $(this).removeClass('is-invalid');
            });

            nivelInicial.change(function() {
                nivelInicial.removeClass('is-invalid');
                nivelPrimaria.removeClass('is-invalid');
                nivelSecundaria.removeClass('is-invalid');
                nivelNocturno.removeClass('is-invalid');
                msgCheck.addClass('d-none');
                msgCheck.html('');
            });

            nivelPrimaria.change(function() {
                nivelInicial.removeClass('is-invalid');
                nivelPrimaria.removeClass('is-invalid');
                nivelSecundaria.removeClass('is-invalid');
                nivelNocturno.removeClass('is-invalid');
                msgCheck.addClass('d-none');
                msgCheck.html('');
            });

            nivelSecundaria.change(function() {
                nivelInicial.removeClass('is-invalid');
                nivelPrimaria.removeClass('is-invalid');
                nivelSecundaria.removeClass('is-invalid');
                nivelNocturno.removeClass('is-invalid');
                msgCheck.addClass('d-none');
                msgCheck.html('');
            });

            nivelNocturno.change(function() {
                nivelInicial.removeClass('is-invalid');
                nivelPrimaria.removeClass('is-invalid');
                nivelSecundaria.removeClass('is-invalid');
                nivelNocturno.removeClass('is-invalid');
                msgCheck.addClass('d-none');
                msgCheck.html('');
            });

            const isValid = () => {
                let valid = true;

                const nivelInicialStatus = nivelInicial.is(":checked");
                const nivelPrimariaStatus = nivelPrimaria.is(":checked");
                const nivelSecundariaStatus = nivelSecundaria.is(":checked");
                const nivelNocturnoStatus = nivelNocturno.is(":checked");

                if (codigo.val() == '') {
                    codigo.addClass('is-invalid');
                    (codigo.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (descripcion.val() == '') {
                    descripcion.addClass('is-invalid');
                    (descripcion.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (!nivelInicialStatus && !nivelPrimariaStatus && !nivelSecundariaStatus && !
                    nivelNocturnoStatus) {

                    nivelInicial.addClass('is-invalid');
                    nivelPrimaria.addClass('is-invalid');
                    nivelSecundaria.addClass('is-invalid');
                    nivelNocturno.addClass('is-invalid');

                    msgCheck.removeClass('d-none');
                    msgCheck.html('Seleccione al menos un nivel.');

                    valid = false;
                }

                return valid;
            }

            const insertar = async () => {
                try {
                    const url = window.location.origin + '/institucion-agregar';

                    const checkboxes = document.querySelectorAll('.chb-from');
                    const seleccionados = [];

                    checkboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            seleccionados.push(checkbox.nextElementSibling.textContent);
                        }
                    });

                    const niveles = seleccionados.join(", ");

                    const data = {
                        codigo: codigo.val(),
                        descripcion: descripcion.val(),
                        niveles: niveles
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
                        toastr.success('Institucion registrada correctamente.', 'Exito');

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
                    const url = window.location.origin + '/institucion-buscar';

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
                const niveles = {};
                const substrings = (data.niveles).split(", ");

                substrings.forEach(function(substring) {
                    niveles[substring] = true;
                });

                for (const prop in niveles) {
                    if (niveles.hasOwnProperty(prop)) {
                        const checkbox = document.getElementById("nivel" + prop);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                }

                id.val(data.id);
                codigo.val(data.codigo);
                descripcion.val(data.descripcion);
                estado.val(data.estado);
            }

            const editar = async () => {
                try {
                    const url = window.location.origin + '/institucion-editar';

                    const checkboxes = document.querySelectorAll('.chb-from');
                    const seleccionados = [];

                    checkboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            seleccionados.push(checkbox.nextElementSibling.textContent);
                        }
                    });
                    const niveles = seleccionados.join(", ");

                    let data = {
                        id: id.val(),
                        codigo: codigo.val(),
                        descripcion: descripcion.val(),
                        niveles: niveles,
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
                        toastr.success('Institucion editada correctamente.', 'Exito');

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
