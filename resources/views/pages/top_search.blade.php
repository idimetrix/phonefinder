@extends('layouts.default')
@section('title', trans('pages.top_search.title'))
@section('meta_description', trans('pages.top_search.meta_description'))
@section('content')

    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.tor_search')}}
    </div>

    <h3> {{trans('pages.top_search.description')}} </h3>
    <hr>
    <ul>
        @foreach($top_search as $item)
            <li class="btn btn-{{$item->color}} m-b-sm">
                {{ Html::link('/phone/' . $item->phone['short_number'], $item->phone['short_number'])}}
            </li>
        @endforeach
    </ul>

@stop