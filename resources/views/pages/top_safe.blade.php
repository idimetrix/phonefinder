@extends('layouts.default')
@section('title', trans('pages.top_safe.title', ['page' => $top_safe->currentPage(), 'site' => trans('pages.domain_name')]))
@section('meta_description', trans('pages.top_safe.meta_description', ['page' => $top_safe->currentPage(), 'total' => $top_safe->total()]))
@section('content')

    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.top_safe')}}
    </div>

    <h3> {{trans('pages.top_safe.description')}} </h3>
    <hr>
    <ul>
        @foreach($top_safe as $item)
            <li class="btn btn-{{$item->color}} m-b-sm">
                {{ Html::link('/phone/' . $item->phone['short_number'], $item->phone['short_number'])}}
            </li>
        @endforeach
    </ul>
    <div class="pagination">{{$top_safe->links()}}</div>
@stop