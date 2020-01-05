@extends('layouts.default')
@section('content')

    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>Edit: {{$ip->value}}</h4>
        {{ Form::open(['action' => ['IpController@update', $ip->id], 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <input name="_method" type="hidden" value="PATCH">
                    <label>Prefix</label>
                    {{ Form::text('value', $ip->value, ['class' => 'form-control', 'type'=>'text', 'minlength' => '1']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
@stop