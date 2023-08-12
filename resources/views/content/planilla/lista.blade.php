@extends('layouts.master')

@section('title')
    @lang('Pagos')
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
            Pagos
        @endslot
        @slot('title')
            Lista de pagos
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Institucion</th>
                                <th>Docente</th>
                                <th>Ciclo escolar</th>
                                <th>Descripcion</th>
                                <th>Mnt. Imponible</th>
                                <th>Mnt. Haberes</th>
                                <th>Mnt. Liquido</th>
                                <th>Fecha</th>
                                <th>Arch.</th>
                                <th>Observacion</th>
                                {{-- <th>Estado</th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($regiPlanillas as $key => $pago)
                                <tr id="tr[{{ $key }}]" class="tr-option" data-id="{{ $pago->id }}">
                                    <td>{{ $pago->docente->institucion->descripcion }}</td>
                                    <td>{{ $pago->docente->nombres .' ' .$pago->docente->apellidos }}</td>
                                    <td>{{ $pago->cicloEscolar->description }}</td>
                                    <td>{{ $pago->description }}</td>
                                    <td>{{ $pago->imponible }}</td>
                                    <td>{{ $pago->haberes }}</td>
                                    <td>{{ $pago->liquido }}</td>
                                    <td>{{ $pago->fecha }}</td>
                                    {{-- <td><a href="{{ Storage::url($pago->ruta) }}">Descargar archivo</a></td> --}}
                                    <td><a href="{{ url('/storage/' . $pago->ruta) }}">Descargar archivo</a></td>
                                    <td>{{ $pago->observacion }}</td>
                                    {{-- <td class="text-center">
                                        <span
                                            class="btn btn-sm btn-outline-{{ $pago->estado == 1 ? 'success' : 'danger' }}">{{ $pago->estado == 1 ? 'Activo' : 'Anulado' }}
                                        </span>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
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
        jQuery(function() {});
    </script>
@endsection
