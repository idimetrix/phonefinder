@extends('layouts.default')
@section('title', trans('pages.links.blog'))
@section('content')

    <div class="well">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        <h4>Edit: {{$article->title}}</h4>
            {{ Form::open(['action' => ['ArticleController@update', $article->id], 'method' => 'POST', 'class' => 'form']) }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input name="_method" type="hidden" value="PATCH">
                        <label>Title</label>
                        {{ Form::text('title', $article->title, ['class' => 'form-control', 'type'=>'text']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Body</label>
                        {{ Form::textarea('body', $article->body, ['class' => 'form-control', 'type'=>'text']) }}
                    </div>
                </div>
            </div>

            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
    </div>
@stop