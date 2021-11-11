@extends('layouts.app')

@section('page-title', 'Manage Master Data')
@section('page-heading', 'Car Owner')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        Car Owner
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">

        <div class="row mb-3 pb-3 border-bottom-light">
			<div class="col-lg-12">
				<div class="float-right">
					<a href="{{ route('cars.create') }}" class="btn btn-primary btn-rounded float-right">
						<i class="fas fa-plus mr-2"></i>
						@lang('Add Car')
					</a>
				</div>
			</div>
		</div>

        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover" id="cars-table-wrapper">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th class="min-width-80">@lang('Owners Name')</th>
                                <th class="min-width-80">@lang('Owners Email')</th>
                                <th class="min-width-90">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    <script type="text/javascript">
        DataTableElement = $('#cars-table-wrapper');
        TableColumns = [
            {data: "DT_RowIndex", orderable:false, filter: false, searchable: false},
            {data: "name", name:"name", orderable:false, filter: false},
            {data: "email", name:"email", orderable:false, filter: false},
            {data: "action", name: "action",orderable: false, searchable: false}
        ];

        var Datatable = {
            "init" : function(){
                dtcars = {
                    /*destroy: true,*/
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("get.cars") }}',
                    columns: TableColumns,
                    columnDefs: [{
                        targets: 0,
                        searchable: false,
                        className: 'dt-body-center'
                    }],
                    responsive:!0, lengthMenu:[[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],pageLength:15,
                }; DataTableElement.DataTable(dtcars);
            }
        };

        $(document).ready(function(){
            // ...
            Datatable.init();
        });
    </script>
@stop
