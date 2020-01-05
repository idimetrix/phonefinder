@extends('layouts.default')

@section('top-element')


    <div class="top-image" style="background-image: url(/header_image.jpg)">
        <div class="text-center col-md-6 col-md-offset-3">
            <div class=" text-center text-primary">
                <h2 class="text-bold ">{{trans('home.reverse_lookup')}}</h2>
            </div>
            <div class="">
                {{--                <h4>{{trans('home.search')}}</h4>--}}
                {{ Form::open(['action' => 'PagesController@home', 'method' => 'GET', 'class' => 'form']) }}
                <div class="input-group">
                    {{ Form::text('search', $search, ['class' => 'form-control',
                                'type'=>'number',
                                'required' => 'required',
                                'placeholder' => trans('home.search_input'),
                                'minlength' => '8',
                                'maxlength' => '12',
                                'pattern' => '\d*'
                    ]) }}
                    <div class="input-group-btn">
                        {{ Form::submit(trans('home.search'), ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class=""><h3 class="text-center text-white text-bold about">{{trans('home.description.title')}}</h3>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="col-lg-8">
        <!-- Search -->
    {{--<div class="well">--}}
    {{--<h4>{{trans('home.search')}}</h4>--}}
    {{--{{ Form::open(['action' => 'PagesController@home', 'method' => 'GET', 'class' => 'form']) }}--}}
    {{--<div class="input-group">--}}
    {{--{{ Form::text('search', $search, ['class' => 'form-control',--}}
    {{--'type'=>'number',--}}
    {{--'placeholder' => trans('home.search_input'),--}}
    {{--'minlength' => '8',--}}
    {{--'maxlength' => '12',--}}
    {{--'pattern' => '\d*'--}}
    {{--]) }}--}}
    {{--<div class="input-group-btn">--}}
    {{--{{ Form::submit(trans('home.search'), ['class' => 'btn btn-default']) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--{{ Form::close() }}--}}
    {{--</div>--}}
    <!-- // Search -->

        <h3 class="text-center">{{trans('home.description.title')}}</h3>
        <hr>
        <p>{{trans('home.description.welcome')}}</p>
        <p>{{trans('home.description.helping')}}</p>
        <p>{{trans('home.description.duration')}}</p>
        @if($chart)
            <div class="well ">
                <div class="row">
                    <div class="col-md-12 charts">
                        <h3> {{trans('chart.title')}}</h3>
                        <div id="pop_div"></div>
                        <?= Lava::render('AreaChart', 'Population', 'pop_div') ?>
                    </div>
                </div>
            </div>
        @endif
        <div class="well  home-panel">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#1a" data-toggle="tab">{{trans('home.safe')}}</a>
                </li>
                <li><a href="#2a" data-toggle="tab">{{trans('home.unsafe')}}</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="1a">
                    <div class="panel panel-default">
                        <ul>
                            @foreach($last_safe as $item)
                                <li class="btn btn-{{$item->color}} m-b-sm">
                                    {{ Html::link('/phone/' . $item->short_number, $item->short_number)}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="2a">
                    <div class="panel panel-default">
                        <ul>
                            @foreach($last_unsafe as $item)
                                <li class="btn btn-{{$item->color}} m-b-sm">
                                    {{ Html::link('/phone/' . $item->short_number, $item->short_number)}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('components.lastComments', ['data' =>$last_comments])
        @include('components.home_random_numbers', ['data' =>$random_number])

    </div>

    <div class="col-md-4">

        <div class="row">
            <div class="col-md-12">
                {!! isset($google_review->value) ? $google_review->value : '' !!}
            </div>
        </div>
        @if (count($last_comments))
            @include('widgets.last_comments', ['data'=> $last_comments])
        @endif

        @if (count($last_add_numbers))
            @include('widgets.add_numbers', ['data'=>$last_add_numbers])
        @endif

        @if (count($last_visits))
            @include('widgets.last_numbers', ['data'=> $last_visits])
        @endif

        <div class="row">
            <div class="col-md-12">
                {!! isset($ads->value) ? $ads->value : '' !!}
            </div>
        </div>
        <div class="well"><h4>Tagged number </h4>
            <div class="row">
                <div class="col-lg-12">
                    <span class="label label-success">{!! isset($safe->value) ? $safe->value : '' !!}</span> {!! isset($safe_description->value) ? $safe_description->value : '' !!}
                    <br>
                    <span class="label label-danger">{!! isset($unsafe->value) ? $unsafe->value : '' !!}</span> {!! isset($unsafe_description->value) ? $unsafe_description->value : '' !!}
                </div>
            </div>
        </div>
    </div>
    <!-- // Sidebar widgets -->
@stop