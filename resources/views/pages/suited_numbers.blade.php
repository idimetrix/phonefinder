@extends('layouts.default')
@section('title', trans('pages.prefix_number_suited.title', [
    'prefix' => $prefix,
    'code' => $code,
    'site' => trans('pages.domain_name'),
    'page' => $numbers instanceof \Illuminate\Pagination\LengthAwarePaginator?$numbers->currentPage():1
]))
@section('meta_description', trans('pages.prefix_number_suited.meta_description', [
    'prefix' => $prefix,
    'code' => $code,
    'page' => $numbers instanceof \Illuminate\Pagination\LengthAwarePaginator?$numbers->currentPage():1
]))
@section('content')
    <div class="container">
        <div>
            {{ Html::link('/', trans('pages.links.home'))}}
            / {{ Html::link('/prefix', trans('area.prefix'))}}
            / {{ Html::link('/prefix/' . $prefix, $prefix)}}
            / {{$prefix . '-' . $code}}
            {{--            / {{ Html::link('/phone/' . $prefix . '/'. $code, $prefix . '-' . $code)}}--}}
        </div>
        <p>{{trans('area.phone_directory')}} {{$prefix}}-{{$code}}</p>
        <table class="table">
            <thead>
            <tr>
                <th>{{trans('area.phone')}}</th>
                <th>{{trans('area.prefix')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($numbers as $item)
                <tr>
                    <td>{{ Html::link('/phone/' . $item->short_number, $item->short_number)}}</td>
                    <td>{{$prefix}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">{{$numbers->links()}}</div>
    </div>
@stop