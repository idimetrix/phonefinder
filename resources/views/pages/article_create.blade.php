@extends('layouts.default')
@section('title', trans('pages.links.blog'))
@section('content')

    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        {{ Form::open(['action' => 'ArticleController@store', 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Title</label>
                    {{ Form::text('title', '', ['class' => 'form-control', 'type'=>'text']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Body</label>
                    {{ Form::textarea('body', '', ['class' => 'form-control', 'type'=>'text']) }}
                </div>
            </div>
        </div>

        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
@stop