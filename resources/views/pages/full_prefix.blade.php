@extends('layouts.default')
@section('title', (isset($city->location) && strlen($city->location)?$city->location.' - ':(isset($city->carrier)?$city->carrier.' - ':'')).trans('pages.prefix_number.title', [
    'prefix' => $prefix,
    'site' => trans('pages.domain_name'),
    'page' => $full_prefix instanceof \Illuminate\Pagination\LengthAwarePaginator ?$full_prefix->currentPage():1
]))
@section('meta_description', trans('pages.prefix_number.meta_description', [
    'prefix' => $prefix,
    'page' => $full_prefix instanceof \Illuminate\Pagination\LengthAwarePaginator ?$full_prefix->currentPage():1
]))
@section('content')
    <div class="container">
        <div>
            {{ Html::link('/', trans('pages.links.home'))}}
            / {{ Html::link('/prefix', trans('area.prefix'))}}
            / {{$prefix}}
            {{--/ {{ Html::link('/prefix/' . $prefix, $prefix)}}--}}
        </div>
        <h2>{{trans('area.area')}} {{$prefix}}  {{trans('area.city')}}
            : @if(isset($city->location)){{$city->location}}@else  @endif</h2>
        <table class="table">
            <thead>
            <tr>
                <th>{{trans('area.prefix')}}</th>
                <th>{{trans('area.link')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($full_prefix as $item)
                <tr>
                    <td>{{$item->value}}</td>
                    <td>{{ Html::link('/prefix/' . $item->prefix . '/code/' . $item->value,trans('area.browse') . $item->prefix . '-' . $item->value . '-ABCD')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-lg-12">{{$full_prefix->links()}}</div>
    </div>
@stop