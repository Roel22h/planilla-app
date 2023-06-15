@extends('layouts.master')

@section('title')
    @lang('Ciclos escolares')
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
            Ciclo escolar
        @endslot
        @slot('title')
            Lista de ciclos escolares
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ciclos as $key => $ciclo)
                                <tr id="tr[{{ $key }}]" class="tr-option" data-id="{{ $ciclo->id }}">
                                    <td>{{ $ciclo->description }}</td>
                                    <td>{{ $ciclo->inicio }}</td>
                                    <td>{{ $ciclo->fin }}</td>
                                    <td class="text-center">
                                        <span data-id="{{ $ciclo->id }}"
                                            class="btn btn-sm btn-outline-{{ $ciclo->estado == 1 ? 'success' : 'danger' }} changeStatus">{{ $ciclo->estado == 1 ? 'Activo' : 'Finalizado' }}
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

    <div class="modal fade cicloModal" tabindex="-1" role="dialog" aria-labelledby="cicloModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInstitucionTittle">Ciclo Escolar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Finalizar ciclo escolar?</p>
                    <input type="hidden" id="idCiclo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning btn-guardar">Finzalizar</button>
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
            const cicloModal = $('.cicloModal');
            const btnFinzalizar = $('.changeStatus');
            const btnGuardar = $('.btn-guardar');
            const idCiclo = $('#idCiclo');

            btnFinzalizar.on('click', function() {
                const id = $(this).data('id');
                idCiclo.val(id);
                cicloModal.modal('show');
            });


            btnGuardar.on('click', async function() {
                try {
                    const url = window.location.origin + '/ciclo-finalizar';

                    const data = {
                        id: idCiclo.val(),
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
                        toastr.success('Ciclo finalizado correctamente.', 'Exito');
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
            })
        });
    </script>
@endsection
