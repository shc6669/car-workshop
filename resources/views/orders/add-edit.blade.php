@extends('layouts.app')

@section('page-title', 'Manage Orders')
@section('page-heading', $edit ? $order->car->licence_plate : 'Manage Orders')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('orders.index') }}">@lang('Car Repair Management')</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit Data' : 'Create Data' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if($edit)
    {!! Form::open(['route' => ['orders.update', $order->id], 'method' => 'PUT', 'id' => 'order-form']) !!}
@else
    {!! Form::open(['route' => 'orders.store', 'id' => 'order-form']) !!}
@endif

<input type="hidden" name="id" value="{{ $edit ? $order->id : null }}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title">
                    @lang('Car Repair Management')
                </h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="Back" onclick="window.location.href='{{ route('orders.index') }}'">
                    <span>
                        <i class="fa fa-arrow-left"></i> Back
                    </span>
                </button>
            </div>
            <div class="col-md-9">
                @if($edit)
                    <h5 class="card-title">
                        This work is handled by
                        <strong>
                            {{$jobs->mechanic->user->first_name}} {{$jobs->mechanic->user->last_name}}
                        </strong>
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
                @endif
                <div class="form-group">
                    <label for="car_id">@lang('Car')</label>
                    <select class="form-control input-solid" id="car_id" name="car_id">
                        <option></option>
                        @foreach($cars as $car)
                            <option value="{{$car->id}}" {{$edit && ($car->id == $order->car_id) ? 'selected': '' }}>{{$car->licence_plate}} | {{$car->name}} | {{$car->user->first_name}} {{$car->user->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                @if(!$edit)
                <div class="form-group">
                    <label for="mechanic_id">@lang('Mechanic')</label>
                    <select class="form-control input-solid" id="mechanic_id" name="mechanic_id">
                        <option></option>
                        @foreach($mechanics as $mechanic)
                            <option value="{{$mechanic->id}}">{{$mechanic->user->first_name}} {{$mechanic->user->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label for="start_at">@lang('Start Date')</label>
                    <div class="form-group">
                        <input type="text"
                               name="start_at"
                               id='start_at'
                               value="{{ $edit && $order->start_at ? $order->start_at : old('start_at') }}"
                               class="form-control input-solid" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes_order">@lang('Notes')</label>
                    <textarea name="notes_order"
                              id="notes_order"
                              rows="5"
                              class="form-control input-solid">{{ $edit ? $order->notes : old('notes') }}</textarea>
                </div>
            </div>
        </div>
        <div class="row pt-sm-4">
            <div class="col-md-3"></div>
            <div class="col-md-9 mb-2">
                <label id="btnAdd" class="btn btn-sm btn-outline-primary" onclick="addDetail()">
                    <span>
                        <i class="fas fa-plus"></i> Add Order Details
                    </span>
                </label>
            </div>
        </div>
        @if($edit)
            <input type="hidden" value="{{count($order_details)}}" name="details_sums">
            @foreach($order_details as $key => $detail)
                <div class="row removable">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="service_id{{$key}}">@lang('Service')</label>
                            <select class="form-control input-solid" id="service_id{{$key}}" name="service_id[{{$key}}]">
                                <option value=""></option>
                                @foreach($detail->serviceType as $k => $v)
                                    <option value="{{ $k }}" {{ $detail->service_id == $k ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="qty{{$key}}">@lang('Qty')</label>
                            <input type="number" value="{{$detail->qty}}" class="form-control input-solid" id="qty{{$key}}" name="qty[{{$key}}]">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="notes{{$key}}">@lang('Notes')</label>
                            <input type="text" value="{{$detail->notes}}" class="form-control input-solid" id="notes{{$key}}" name="notes[{{$key}}]">
                        </div>
                    </div>
                    <div class="col-md-1 pt-4">
                        <label class="btnRmv">
                            <span class="info-2">
                                <i class="fas fa-trash"></i>
                            </span>
                        </label>
                    </div>
                </div>
            @endforeach
        @endif
        <div id="order_details">
            {{-- Ajax --}}
        </div>
        <div class="row pt-sm-4">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <button type="submit" class="btn btn-outline-success">
                    {{ $edit ? 'Update data' : 'Submit data' }}
                </button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<br>
@stop

@section('scripts')
    @if($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Orders\UpdateRequest', '#order-form') !!}
        <script>
            let idx = parseFloat($("input[name='details_sums']").val()) - 1;
            function addDetail()
            {
                idx++;

                $.ajax({
                    url: '/orders/html/' + idx,
                    dataType: 'html',
                    beforeSend: function(){
                        console.log('waiting...');
                    }
                }).done(function(html){
                    console.clear();
                    $("#order_details").append(html);
                });
            }

            // Select2
            @foreach($order_details as $key => $detail)
                $("#service_id{{ $key }}").select2({"allowClear":true,"placeholder":{"id":"","text":"Please Select Option"}});
            @endforeach

            $(".btnRmv").on("click", function(){
                $(this).closest('div.removable').remove();
            });
        </script>
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Orders\CreateRequest', '#order-form') !!}
        <script>
            let idx = 0;
            function addDetail()
            {
                $.ajax({
                    url: '/orders/html/' + idx,
                    dataType: 'html',
                    beforeSend: function(){
                        console.log('waiting...');
                    }
                }).done(function(html){
                    console.clear();
                    $("#order_details").append(html);
                });

                idx++;
            }
        </script>
    @endif
    {!! HTML::script('assets/js/as/custom.js') !!}
@stop
