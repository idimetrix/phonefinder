@extends('layouts.default')
@section('content')
    <div class="well">
        @if (substr($ads->key,0,5) !== 'image')
            @if(session()->has('msg'))
                <div class="alert {{session()->get('type')}}">
                    {{ session()->get('msg') }}
                </div>
            @endif
            <h4>Edit: {{$ads->key}}</h4>
            {{ Form::open(['action' => ['AdminController@updateSettings', $ads->id], 'method' => 'POST', 'class' => 'form']) }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input name="_method" type="hidden" value="PATCH">
                        <label>Value ads</label>
                        {{ Form::textarea('value', $ads->value, ['class' => 'form-control', 'type'=>'text']) }}
                    </div>
                </div>
            </div>

            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        @else
            <h4>Edit: {{$ads->key}}</h4>
            {{ Form::open(['action' => ['AdminController@updateSettings', $ads->id], 'method' => 'POST', 'class' => 'form', 'enctype' => 'multipart/form-data']) }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input name="_method" type="hidden" value="PATCH">
                        <label>Value ads</label>
                        {{Form::file('file'),['class' => 'form-control', 'type'=>'file']}}
{{--                        {{ Form::textarea('value', $ads->value, ['class' => 'form-control', 'type'=>'text']) }}--}}
                    </div>
                </div>
            </div>

            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        @endif
    </div>
@stop