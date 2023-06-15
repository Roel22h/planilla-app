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
            Ciclo escoclar
        @endslot
        @slot('title')
            Agregar ciclo escolar
        @endslot
    @endcomponent

    <div class="row">
        <div class="col">
            @if ($cicloActivo)
                <p>Ciclo escolar activo: <strong>{{ $cicloActivo->description }}</strong>. No es posible agregar otro ciclo
                    escoclar mientras haya alguno activo.</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="description">Descripcion</label>
                            <input type="text" class="form-control" id="description"
                                placeholder="Descripcion del ciclo escolar" readonly>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="inicio">Fecha inicio</label>
                            <input type="date" class="form-control" id="inicio">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label for="inicio">Fecha final</label>
                            <input type="date" class="form-control" id="fin" readonly>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" id="guardar" {{ $cicloActivo ? 'disabled' : '' }}>Iniciar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        jQuery(function() {
            const descripcion = $('#description');
            const inicio = $('#inicio');
            const fin = $('#fin');

            const btnEnviar = $('#guardar');

            const fechaActual = new Date();
            const formatoFechaActual = fechaActual.toISOString().split('T')[0];

            inicio.attr('min', formatoFechaActual);
            fin.attr('min', formatoFechaActual);
            let desc = '';

            inicio.on('change', function() {
                $(this).removeClass('is-invalid');
                descripcion.removeClass('is-invalid');
                if (inicio.val() == '') {
                    desc = '';
                    fin.attr('readonly');
                } else {
                    desc = `Ciclo escolar ${inicio.val()}`;
                    fin.removeAttr('readonly');
                    fin.attr('min', inicio.val());
                    fin.val('');
                }

                descripcion.val(desc);
            });

            fin.on('change', function() {
                $(this).removeClass('is-invalid');
                descripcion.removeClass('is-invalid');
                desc += ` al ${fin.val()}.`;
                descripcion.val(desc);
            });


            btnEnviar.on('click', function() {
                if (!isVal()) {
                    return;
                }
                insertar();
            });

            const isVal = () => {
                let valid = true;

                if (descripcion.val() == '') {
                    descripcion.addClass('is-invalid');
                    (descripcion.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (inicio.val() == '') {
                    inicio.addClass('is-invalid');
                    (inicio.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }
                if (inicio.val() == '') {
                    inicio.addClass('is-invalid');
                    (inicio.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }

                if (fin.val() == '') {
                    fin.addClass('is-invalid');
                    (fin.next('.invalid-feedback')).text('Este campo es requerido.');

                    valid = false;
                }
                return valid;
            }

            const insertar = async () => {
                try {
                    const url = window.location.origin + '/ciclo-insertar';

                    const data = {
                        description: descripcion.val(),
                        inicio: inicio.val(),
                        fin: fin.val()
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
                        toastr.success('Ciclo registrado correctamente.', 'Exito');

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
