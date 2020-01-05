@extends('layouts.default')
@section('title', trans('pages.links.report'))
@section('content')


    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.report')}}
    </div>


    <x-report number="{{$number}}" trans="{{json_encode(trans('vue.report'))}}" env="{{json_encode(env('COUNTRY_CODE'))}}"
              types="{{json_encode(trans('components.type'))}}"></x-report>

@stop