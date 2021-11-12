@extends('layouts.app')

@section('page-title', 'Manage Master Data')
@section('page-heading', $edit ? $mechanic->name : 'Manage Master Data - Mechanics')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('mechanics.index') }}">@lang('Mechanics')</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $edit ? 'Edit Data' : 'Create Data' }}
    </li>
@stop

@section('content')

@include('partials.messages')

@if($edit)
    {!! Form::open(['route' => ['mechanics.update', $mechanic->id], 'method' => 'PUT', 'id' => 'mechanic-form']) !!}
@else
    {!! Form::open(['route' => 'mechanics.store', 'id' => 'mechanic-form']) !!}
@endif

<input type="hidden" name="id" value="{{ $edit ? $mechanic->id : null }}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title">
                    @lang('Mechanics')
                </h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="Back" onclick="window.location.href='{{ route('mechanics.index') }}'">
                    <span>
                        <i class="fa fa-arrow-left"></i> Back
                    </span>
                </button>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="user_id">@lang('Name')</label>
                    <select class="form-control input-solid" id="user_id" name="user_id">
                        <option></option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{$edit && ($user->id == $mechanic->user_id) ? 'selected': '' }}>{{$user->first_name}} {{$user->last_name}}</option>
                        @endforeach
                    </select>
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
    {!! JsValidator::formRequest('Vanguard\Http\Requests\MasterData\MechanicsCreatedUpdatedRequest', '#mechanic-form') !!}
    {!! HTML::script('assets/js/as/custom.js') !!}
@stop
