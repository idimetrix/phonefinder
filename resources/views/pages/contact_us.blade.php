@extends('layouts.default')
@section('title', trans('pages.contact_us.title'))
@section('meta_description', trans('pages.contact_us.meta_description'))
@section('content')
    @if(session()->has('msg'))
        <div class="alert {{session()->get('type')}}">
            {{ session()->get('msg') }}
        </div>
    @endif
    <div>
        {{ Html::link('/', trans('pages.links.home'))}}
        / {{trans('pages.links.contact_us')}}
    </div>
    <h3>{!! isset($title->value) ? $title->value : '' !!}</h3>
    <hr>
    <p>{!! isset($description->value) ? $description->value:'' !!}</p>
    <p>{!! isset($contacts->value) ? $contacts->value: '' !!}</p>
    {{ Form::open(['action' => 'PagesController@admin_message', 'method' => 'POST', 'class' => 'form']) }}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Name</label>
                {{ Form::text('name', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Name','manlength'=>'2']) }}

                <label>Email</label>
                {{ Form::email('email', '', ['class' => 'form-control', 'type'=>'text', 'required' => 'required', 'placeholder' => 'Email']) }}
                <br>
                <label>Message</label>
                    {{ Form::textarea('text', null, ['size' => '30x3', 'class' => 'form-control', 'minlength' => '10', 'required' => 'required']) }}
                {{ Form::text('site_name', null, [ 'class' => 'opacity', 'minlength' => '3']) }}
            </div>
        </div>
    </div>

    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@stop