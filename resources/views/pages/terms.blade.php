@extends('layouts.default')
@section('title', trans('pages.links.terms_of_use'))
@section('content')

    {!! isset($terms->value) ? $terms->value:'' !!}

@stop