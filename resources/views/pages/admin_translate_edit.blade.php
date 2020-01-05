@extends('layouts.default')
@section('content')
    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>Edit: {{$name . '.php'}}</h4>
        {{ Form::open(['action' => ['AdminController@updateTranslate', $name], 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <input name="_method" type="hidden" value="PATCH">
                    <label>Value translate file</label>
                    {{ Form::textarea('value', $value, ['class' => 'form-control', 'type'=>'text']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
    </div>
@stop