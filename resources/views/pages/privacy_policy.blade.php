@extends('layouts.default')
@section('title', trans('pages.links.privacy_policy'))
@section('content')
    {!! isset($privacy->value) ? $privacy->value:'' !!}
@stop