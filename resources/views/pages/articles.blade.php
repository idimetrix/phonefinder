@extends('layouts.default')
@section('title', trans('pages.links.blog'))
@section('content')
    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.blog')}}
    </div>
    @if (!Auth::guest())
    <a href="/blog/create"><i class="glyphicon glyphicon-plus-sign"></i> New Post</a>
    @endif
    @foreach( $articles as $item )
    {{--<div class="well">--}}
    <div class="row">
        <div class="col-md-12">
            <div id="postlist">
                <div class="panel">
                    <div class="row">
                        <div class="col-sm-4 remove-padding">
                            <h4 class="pull-left">
                                {{trans('components.posted_by')}} <strong>{{$team->value}}</strong>
                            </h4>
                        </div>
                        <div class="col-sm-8 remove-padding">
                            <h4 class="pull-right">
                                <span class="label label-primary">{{trans('components.posted')}} {{$item->created_at}}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="panel-heading heading-post">
                        <div class="text-center">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="pull-left"><a href="/blog/{{$item->id}}">{{$item->title}}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(strlen($item->body) > 200)
                            {{substr($item->body, 0, 200)}}.... <a href="/blog/{{$item->id}}">{{trans('components.read_more')}}</a>
                        @else
                            {{$item->body}}
                        @endif
                    </div>
                    <div class="panel-footer">
                        @if (!Auth::guest())
                        <a href="/admin/blog/edit/{{$item->id}}"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <a data-toggle="modal" data-target="#createSubscriptionModal-{{ $item->id }}" href=""><i class="glyphicon glyphicon-remove alert-danger"></i> Delete</a>
                        @endif
                        <span class="pull-right"><a href="/blog/{{$item->id}}"><i class="glyphicon glyphicon-comment"></i> {{trans('components.comments')}} ({{$item->article_comments_count}})</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createSubscriptionModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-delete" role="document">
            <div class="modal-content ">
                <div class="delete-header">
                    <h3 class="modal-title">{{trans('components.modal_confirm')}}</h3>
                </div>
                {{ Form::open(['url' => '/blog/'. $item->id]) }}
                <div class="delete-footer">
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="button" class="btn btn-success no-delete" data-dismiss="modal">No</button>
                    {{ Form::submit('Delete', ['class' => 'btn btn-delete yes-delete','data-toggle'=>"modal",
                                       'data-target'=>"#createSubscriptionModal"]) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    {{--</div>--}}
    @endforeach
    <div class="pagination">{{$articles->links()}}</div>
@stop