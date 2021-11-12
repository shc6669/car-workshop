@extends('layouts.app')

@section('page-title', 'Manage Orders')
@section('page-heading', 'Car Repair Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        Car Repair Management
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">

        @if(auth()->user()->hasRole('Admin'))
        <div class="row mb-3 pb-3 border-bottom-light">
			<div class="col-lg-12">
				<div class="float-right">
					<a href="{{ route('orders.create') }}" class="btn btn-primary btn-rounded float-right">
						<i class="fas fa-plus mr-2"></i>
						@lang('Add Order')
					</a>
				</div>
			</div>
		</div>
        @endif

        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover" id="orders-table-wrapper">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th class="min-width-80">@lang('Owners Name')</th>
                                <th class="min-width-80">@lang('Cars Name')</th>
                                <th class="min-width-80">@lang('Licence Plate')</th>
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
        DataTableElement = $('#orders-table-wrapper');
        TableColumns = [
            {data: "DT_RowIndex", orderable:false, filter: false, searchable: false},
            {data: "name", name:"name", orderable:false, filter: false},
            {data: "type", name:"type", orderable:false, filter: false},
            {data: "licence_plate", name:"licence_plate", orderable:false, filter: false},
            {data: "action", name: "action",orderable: false, searchable: false}
        ];

        var Datatable = {
            "init" : function(){
                dtcars = {
                    /*destroy: true,*/
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("get.orders") }}',
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
