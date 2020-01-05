@extends('layouts.default')
@section('title', trans('area.prefix'))
@section('content')
    <div class="container">
        <div>
            {{ Html::link('/', trans('pages.links.home'))}}
            / {{trans('area.prefix')}}
            {{--/ {{ Html::link('/prefix', trans('area.prefix'))}}--}}
        </div>
        <h2>{{trans('area.search_area')}}</h2>
        <table class="table">
            <thead>
            <tr>
                <th>{{trans('area.area')}}</th>
                <th>{{trans('area.state')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prefix as $item)
                <tr>
                    <td>{{$item->prefix}}</td>
                    <td>{{ Html::link('/prefix/' . $item->prefix,trans('area.search') . $item->prefix)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop