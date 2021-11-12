@extends('layouts.app')

@section('page-title', 'Manage Job')
@section('page-heading', $job->order->car->licence_plate)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('orders.index') }}">@lang('Car Repair Management')</a>
    </li>
    <li class="breadcrumb-item active">
        Show Data for {{$job->order->car->licence_plate}}
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="card text-center">
    <div class="card-header">
        <h5>
            {{$job->order->car->name}} | {{$job->order->car->licence_plate}}
        </h5>
    </div>
    <div class="card-body">
        <div class="container pb-sm-6">
            <div class="row">
                <div class="col-6">
                    <strong>Car Owner </strong>:
                    <h5 class="card-title">
                        {{$job->order->car->user->first_name}} {{$job->order->car->user->last_name}}
                    </h5>
                </div>
                <div class="col-6">
                    <strong>Status </strong>:
                    <br>
                    @if($job->order->status == 1)
                        <span class="badge badge-pill badge-info">
                            <i class="fas fa-exclamation-triangle"></i> Processing
                        </span>
                    @else
                        <span class="badge badge-pill badge-success">
                            <i class="fas fa-check-square"></i> Completed
                        </span>
                    @endif
                </div>
            </div>
            @if($job->status == 1)
                <a id="change_status" class="btn btn-outline-primary btn-sm">Change Job Status</a>
                <br>
            @endif
            <br>
            <p class="card-text">
                Order Details
            </p>
            <br>
        </div>

        <div class="container pt-sm-9">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($order_details as $detail )
                                <tr>
                                    <th scope="row">{{ $no++ }}</th>
                                    <td>{{$detail->service->name}}</td>
                                    <td>{{$detail->qty}}</td>
                                    <td>{{$detail->notes}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        {{Carbon\Carbon::parse($job->order->start_at)->formatLocalized('%A, %d %B %Y')}}
    </div>
</div>

@stop

@section('scripts')
    <script>
        $("#change_status").on("click", function(){
            swal({
                title: "Are you sure?",
                text: "Please checked again all your job task. Once status has changed, you will not be able to recover this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log('this clicked');
                    $.ajax({
                        url: '{{route("change.status", $job->id)}}',
                        type: 'post',
                    }).done(function(response){
                        swal(response.message, {
                            icon: "success",
                        });
                        setTimeout(function(){
                            window.location.reload();
                        }, 3000)
                    });
                } else {
                    swal("You cancel the status");
                }
            });
        });
    </script>
@stop
