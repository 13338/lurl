@extends('app')

@section('title', __('link.title'))

@section('content')
<form class="form-signin" action="{{ route('store') }}" method="POST" id="create-link-form">
    <h1>{{ __('link.header') }}</h1>
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="link" placeholder="{{ __('link.input') }}" autofocus="autofocus" name="link" value="https://gitlab.com/13338/lurl">
        <div class="input-group-append">
            <button class="btn btn-dark" id="submit" type="button">{{ __('link.create') }}</button>
        </div>
    </div>
    <div class="invalid-feedback text-left mb-3" id="errors">
        Error
    </div>
    <div class="form-group text-left">
        <button class="btn btn-default dropdown-toggle" type="button" id="show-expired-input">{{ __('link.expired') }}</button>
        <button class="btn btn-default dropdown-toggle float-right" type="button" id="show-short-input">{{ __('link.short') }}</button>
    </div>
    <div class="form-group text-left" id="expired-input" style="display: none">
        <div class="btn-group btn-group-sm btn-group-toggle d-flex mb-1" data-toggle="buttons">
            <label class="btn btn-secondary w-100 change-datetime" data-value="{{ date('Y-m-d\TH:i', strtotime(date('Y-m-d\TH:i') . " +1 day")) }}">
                <input type="radio" class="change-datetime" autocomplete="off">1 {{ __('link.day') }}
            </label>
            <label class="btn btn-secondary active w-100 change-datetime" data-value="{{ date('Y-m-d\TH:i', strtotime(date('Y-m-d\TH:i') . " +1 week")) }}">
                <input type="radio" class="" autocomplete="off" checked>1 {{ __('link.week') }}
            </label>
            <label class="btn btn-secondary w-100 change-datetime" data-value="{{ date('Y-m-d\TH:i', strtotime(date('Y-m-d\TH:i') . " +1 month")) }}">
                <input type="radio" autocomplete="off">1 {{ __('link.month') }}
            </label>
        </div>
        <div>
            <input type="datetime-local" class="form-control" id="datetime" value="{{ date('Y-m-d\TH:i', strtotime(date('Y-m-d\TH:i') . " +1 week")) }}" max="2038-01-19T03:14:07" name="expired_at" disabled>
        </div>
    </div>
    <div class="form-group" id="short-input" style="display: none">
         <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">{{ Request::root() }}/</span>
            </div>
            <input type="text" class="form-control" id="short" name="short" placeholder="myShortLink" disabled>
        </div>
    </div>
    <hr>
    <div id="prepend"></div>
</form>
@endsection