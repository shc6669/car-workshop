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

@if ($edit)
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
                    <i class="fa fa-arrow-left"></i> Back
                </button>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="name">@lang('Name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('Please input name')" value="{{ $edit ? $mechanic->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">@lang('Email')</label>
                    <input type="email" class="form-control" id="email"
                           name="email" placeholder="@lang('Please input email')" value="{{ $edit ? $mechanic->email : old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">{{ $edit ? __("New Password") : __('Password') }}</label>
                    <input type="password"
                           class="form-control input-solid"
                           id="password"
                           name="password"
                           @if($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ $edit ? __("Confirm New Password") : __('Confirm Password') }}</label>
                    <input type="password"
                           class="form-control input-solid"
                           id="password_confirmation"
                           name="password_confirmation"
                           @if($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
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
    @if($edit)
    {!! JsValidator::formRequest('Vanguard\Http\Requests\MasterData\MechanicsUpdatedRequest', '#mechanic-form') !!}
    @else
    {!! JsValidator::formRequest('Vanguard\Http\Requests\MasterData\MechanicsCreatedRequest', '#mechanic-form') !!}
    @endif
@stop
