@extends('layouts.app')

@section('page-title', 'Manage Jobs')
@section('page-heading', 'Jobs Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        Jobs Management
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">

        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover" id="jobs-table-wrapper">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th class="min-width-80">@lang('Owners Name')</th>
                                <th class="min-width-80">@lang('Cars Name')</th>
                                <th class="min-width-80">@lang('Licence Plate')</th>
                                <th class="min-width-80">@lang('Mechanic Handled By')</th>
                                <th class="min-width-80">@lang('Status')</th>
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
        DataTableElement = $('#jobs-table-wrapper');
        TableColumns = [
            {data: "DT_RowIndex", orderable:false, filter: false, searchable: false},
            {data: "car_owner", name:"car_owner", orderable:false, filter: false},
            {data: "car_name", name:"car_name", orderable:false, filter: false},
            {data: "licence_plate", name:"licence_plate", orderable:false, filter: false},
            {data: "handled_by", name:"handled_by", orderable:false, filter: false},
            {data: "status", name:"status", orderable:false, filter: false},
            {data: "action", name: "action",orderable: false, searchable: false}
        ];

        var Datatable = {
            "init" : function(){
                dtcars = {
                    /*destroy: true,*/
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("get.jobs") }}',
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
