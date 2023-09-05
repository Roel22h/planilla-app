@extends('layouts.master')

@section('title')
	@lang('Planillas')
@endsection

@section('css')
	<!-- DataTables -->
	<link href="{{ URL::asset('build/libs/jqwidgets-scripts/jqwidgets-script.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

	<!-- Responsive datatable examples -->
	<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	@component('components.breadcrumb')
		@slot('li_1')
			Planillas
		@endslot
		@slot('title')
			Obtener reporte planillas
		@endslot
	@endcomponent

	<div class="row">
		<div class="col-12">
			<button id="btnExportar" class="btn btn-outline-primary">Exportar</button>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div id="jqxtable"></div>
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
	<script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
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

	<script src="{{ URL::asset('build/libs/jqwidgets-scripts/jqwidgets-script.js') }}"></script>
	<script src="{{ URL::asset('build/js/planilla/jqxgrid.js') }}"></script>
	<script>
		jQuery(function() {
			const jqxTable = document.getElementById('jqxtable');
			const btnExportar = document.getElementById('btnExportar');
			initTable(jqxTable);

			btnExportar.addEventListener('click', async function() {
				prin_document(jqxTable, 'reporte planillas')
			});
		});
	</script>
@endsection
