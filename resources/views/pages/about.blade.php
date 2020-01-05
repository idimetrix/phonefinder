@extends('layouts.default')
@section('title', trans('pages.about_us.title'))
@section('meta_description', trans('pages.about_us.meta_description'))
@section('content')

    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.about')}}
    </div>

    <h3>{{trans('pages.about.1_line')}}</h3>
    <hr>

    <p>{{trans('pages.about.2_line')}}</p>
    <p>{{trans('pages.about.3_line')}}</p>
@stop