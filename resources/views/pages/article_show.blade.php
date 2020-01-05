@extends('layouts.default')
@section('title', trans('pages.links.blog'))s
@section('content')
    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{ Html::link('/blog', trans('pages.links.blog'))}}
        / {{$article->title}}
        {{--/ {{ Html::link('/prefix/' . $prefix, $prefix)}}--}}
    </div>
    <div class="well">
        <h1 class="mg-top-10">{{$article->title}}</h1>
        <p class="lead"><i class="glyphicon glyphicon-user"></i> {{trans('components.by')}}
            {{--<a href="">--}}
            <strong>{!! isset($team->value) ? $team->value:'' !!}</strong>
            {{--</a>--}}
        </p>
        <p><i class="glyphicon glyphicon-time"></i> {{trans('components.posted_on')}} {{$article->created_at}}</p>
        <p>{{$article->body}}</p>
    </div>

    <div class="well" id="form">
        <h4>{{trans('components.leave_a_comment')}}:</h4>
        {{ Form::open(['action' => ['ArticleController@storeComment', $article->id], 'method' => 'POST', 'class' => 'form']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>{{trans('components.name')}}</label>
                    {{ Form::text('name', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Your name', 'minlength' => '4']) }}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>{{trans('components.email')}}</label>
                    {{ Form::email('email', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Your email', 'minlength' => '4']) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            {{ Form::textarea('message', null, ['size' => '30x3', 'class' => 'form-control', 'minlength' => '5', 'required' => 'required']) }}
        </div>

        {{ Form::submit(trans('components.submit'), ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>

    @foreach($comments as $item)
        <div class="media">
            <img class="pull-left media-object" src="https://placehold.it/48x48" alt="">
            <div class="media-body">
                <h4 class="media-heading">
                    {{$item->name}}
                    <small>{{$item->created_at}}</small>

                </h4>
                {{$item->message}}
            </div>
        </div>
    @endforeach
    <div class="pagination">{{$comments->links()}}</div>
@stop