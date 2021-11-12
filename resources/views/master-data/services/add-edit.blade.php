@extends('layouts.app')

@section('page-title', 'Manage Master Data')
@section('page-heading', $edit ? $service->name : 'Manage Master Data - Services')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('services.index') }}">@lang('Services')</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit Data' : 'Create Data' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if($edit)
    {!! Form::open(['route' => ['services.update', $service->id], 'method' => 'PUT', 'id' => 'service-form']) !!}
@else
    {!! Form::open(['route' => 'services.store', 'id' => 'service-form']) !!}
@endif

<input type="hidden" name="id" value="{{ $edit ? $service->id : null }}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title">
                    @lang('Services')
                </h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="Back" onclick="window.location.href='{{ route('services.index') }}'">
                    <span>
                        <i class="fa fa-arrow-left"></i> Back
                    </span>
                </button>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="name">@lang('Name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('Please input name')" value="{{ $edit ? $service->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="price">@lang('Price')</label>
                    <input type="number" class="form-control" id="price"
                           name="price" placeholder="@lang('Please input price')" value="{{ $edit ? $service->price : old('price') }}">
                </div>
            </div>
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
    {!! JsValidator::formRequest('Vanguard\Http\Requests\MasterData\ServicesCreatedUpdatedRequest', '#service-form') !!}
@stop
