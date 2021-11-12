@extends('layouts.app')

@section('page-title', 'Manage Orders')
@section('page-heading', $order->car->licence_plate)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('orders.index') }}">@lang('Car Repair Management')</a>
    </li>
    <li class="breadcrumb-item active">
        Show Data for {{$order->car->licence_plate}}
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="card text-center">
    <div class="card-header">
        <h5>
            {{$order->car->name}} | {{$order->car->licence_plate}}
        </h5>
    </div>
    <div class="card-body">
        <div class="container pb-sm-6">
            <h5 class="card-title">
                {{$order->car->user->first_name}} {{$order->car->user->last_name}}
            </h5>
            <div>
                <strong>Status </strong>:
                @if($order->status == 1)
                    <span class="badge badge-pill badge-info">
                        <i class="fas fa-exclamation-triangle"></i> Processing
                    </span>
                @else
                    <span class="badge badge-pill badge-success">
                        <i class="fas fa-check-square"></i> Completed
                    </span>
                @endif
            </div>
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
        {{-- {{date('d-m-Y', strtotime($order->start_at));}} --}}
        {{Carbon\Carbon::parse($order->start_at)->formatLocalized('%A, %d %B %Y')}}
    </div>
</div>

@stop
