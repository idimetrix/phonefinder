@extends('layouts.default')
@section('content')
    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>New Area:</h4>
        {{ Form::open(['action' => 'AreaController@store', 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Prefix</label>
                    {{ Form::text('prefix', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Prefix','minlength' => '1']) }}
                    <label>Location</label>>
                    {{ Form::text('location', '', ['class' => 'form-control inline', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Location', 'minlength' => '1']) }}
                    <label>Dialing code</label>
                    {{ Form::text('dialing_code', '+'. env('COUNTRY_CODE'), ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Dialing code','minlength' => '1']) }}
                    <label>Number format</label>
                    {{ Form::text('number_format', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Number format','minlength' => '1']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
    </div>
@stop