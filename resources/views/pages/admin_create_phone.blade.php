@extends('layouts.default')
@section('content')
    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>New Phone:</h4>
        {{ Form::open(['action' => 'AdminController@store', 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Number</label>
                    <div style="display: flex">
                        <label for="#country" class="label-inline">+{{env('COUNTRY_CODE')}}</label>
                        {{ Form::text('number', '', ['id' => 'country', 'class' => 'form-control inline', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Number', 'minlength' => '4','maxlength'=>'16']) }}
                     </div>
                    <label>Prefix</label>
                    {{ Form::text('prefix', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Prefix','maxlength'=>'3']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
    </div>
@stop