@extends('layouts.default')
@section('title', trans('pages.top_unsafe.title', ['page' => $top_unsafe->currentPage(), 'site' => trans('pages.domain_name')]))
@section('meta_description', trans('pages.top_unsafe.meta_description', ['page' => $top_unsafe->currentPage(), 'total' => $top_unsafe->total()]))
@section('content')

    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.top_unsafe')}}
    </div>

    <h3> {{trans('pages.top_unsafe.description')}} </h3>
    <hr>
    <ul>
        @foreach($top_unsafe as $item)
            <li class="btn btn-{{$item->color}} m-b-sm">
                {{ Html::link('/phone/' . $item->phone['short_number'], $item->phone['short_number'])}}
            </li>
        @endforeach
    </ul>
    <div class="pagination">{{$top_unsafe->links()}}</div>
@stop