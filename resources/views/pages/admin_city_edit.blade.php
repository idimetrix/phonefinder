@extends('layouts.default')
@section('content')

    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>Edit: {{$city->prefix}}</h4>
        {{ Form::open(['action' => ['AreaController@update', $city->id], 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <input name="_method" type="hidden" value="PATCH">
                    <label>Prefix</label>
                    {{ Form::text('prefix', $city->prefix, ['class' => 'form-control', 'type'=>'text', 'minlength' => '1']) }}
                    <label>Location</label>
                    {{ Form::text('location', $city->location, ['class' => 'form-control', 'type'=>'text', 'minlength' => '1']) }}
                    <label>Dialing code</label>
                    {{ Form::text('dialing_code', $city->dialing_code, ['class' => 'form-control', 'type'=>'text', 'minlength' => '1']) }}
                    <label>Number format</label>
                    {{ Form::text('number_format', $city->number_format, ['class' => 'form-control', 'type'=>'text', 'minlength' => '1']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
@stop