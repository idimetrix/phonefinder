@extends('layouts.default')
@section('content')
    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>New Ip:</h4>
        {{ Form::open(['action' => 'IpController@store', 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Value</label>
                    {{ Form::text('value', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Ip','minlength' => '1']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
@stop