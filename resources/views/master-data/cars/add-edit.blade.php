@extends('layouts.app')

@section('page-title', 'Manage Master Data')
@section('page-heading', $edit ? $car->name : 'Manage Master Data - Car Owner')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('cars.index') }}">@lang('Car Owner')</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit Data' : 'Create Data' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if($edit)
    {!! Form::open(['route' => ['cars.update', $car->id], 'method' => 'PUT', 'id' => 'car-form']) !!}
@else
    {!! Form::open(['route' => 'cars.store', 'id' => 'car-form']) !!}
@endif

<input type="hidden" name="id" value="{{ $edit ? $car->id : null }}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title">
                    @lang('Cars Owner')
                </h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="Back" onclick="window.location.href='{{ route('cars.index') }}'">
                    <i class="fa fa-arrow-left"></i> Back
                </button>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="name">@lang('Car Name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('Please input car name')" value="{{ $edit ? $car->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="licence_plate">@lang('Licence Plate')</label>
                    <input type="text" class="form-control" id="licence_plate"
                           name="licence_plate" placeholder="@lang('Please input licence plate')" value="{{ $edit ? $car->licence_plate : old('licence_plate') }}">
                </div>
                <div class="form-group">
                    <label for="user_id">@lang('Name')</label>
                    <select class="form-control input-solid" id="user_id" name="user_id">
                        <option></option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{$edit && ($user->id == $car->user_id) ? 'selected': '' }}>{{$user->first_name}} {{$user->last_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row pt-sm-4">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <button type="submit" class="btn btn-outline-primary">
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
    {!! JsValidator::formRequest('Vanguard\Http\Requests\MasterData\CarsCreatedUpdatedRequest', '#car-form') !!}
    {!! HTML::script('assets/js/as/custom.js') !!}
@stop
