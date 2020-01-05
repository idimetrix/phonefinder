@extends('layouts.default')
@section('content')
    <div class="col-lg-8">
        <div>
            {{ Html::link('/', trans('pages.links.home'))}}
            / {{ Html::link('/prefix/' . $phone->prefix . '/code/' . $phone->area_number, $phone->prefix . '-' . $phone->area_number . '-####')}}
            / {{$phone->short_number}}
        </div>
        <div class="page-header">
            <h1 class="text-center h2">{{trans('phone.title_find_number', array('phone' => $phone->short_number))}}</h1>
        </div>
        {!! isset($top_ads->value) ? $top_ads->value : '' !!}
        <div id="telephone">{{$phone->short_number}}</div>
        {{trans('phone.description', array('phone' => $phone->short_number))}}
        <p>{!! isset($ads_above_detailed->value) ? $ads_above_detailed->value : '' !!}</p>
        <form class="form-horizontal" role="form" method="get" action="{{'detailed/'. $phone->short_number }}">
            <div class="modal-footer-btn detail-phone">
                <input type="submit" class="btn-details btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true"
                       value="{{trans('phone.details_info', array('phone' => $phone->short_number))}}">
            </div>
        </form>
        <hr>
        @include('components.comments', [
            'comments' => $comments,
            'number' => $phone->short_number,
            'count' => $phone->comments_count,
            'rating' => $rating
        ])

        <div class="h3">{{trans('phone.similar_numbers')}}</div>
        @include('components.similar_numbers', ['data'=> $similar_number])
        <hr>
        {{trans('phone.similar_numbers')}} {{$phone->aliases}}
        <hr>
        <span class="lon">{{$lon}}</span>
        <span class="lat">{{$lat}}</span>
        <span class="lat city-exist">@if($key){{$key}}@elseif(isset($phone->city->location)){{$phone->city->location}} @else
                - @endif</span>
        <div class="col-xs-12" style="min-height: 250px">
            <div id="map" class="col-xs-12 col-md-6 map text-center"></div>
            <div class="col-xs-12 col-md-6 text-center">
                {!! isset($bottom_ads->value) ? $bottom_ads->value : '' !!}
            </div>
        </div>
        <div class="container-phone">
            <div class="row">
                <div class="col-md-12 charts">
                    <h3> {{trans('chart.title')}}</h3>
                    <div id="pop_div"></div>
                    <?= Lava::render('AreaChart', 'Population', 'pop_div') ?>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-xs-12">
                <div class="h4">
                    <div class="well well-sm col-sm-3 m-r-sm">{{trans('phone.prefix')}}: {{$phone->prefix}}</div>
                    <div class="well well-sm col-sm-3 m-r-sm">{{trans('phone.views')}}: {{$phone->views_count}}</div>
                    <div class="well well-sm col-sm-4 m-r-sm">{{trans('phone.reports')}}
                        : @if(isset($phone->reports_count)){{$phone->reports_count}}@else 0 @endif</div>
                    <div class="well well-sm col-sm-3 m-r-sm">{{trans('phone.comments')}}
                        : {{$phone->comments_count}}</div>
                    <div class="well well-sm col-sm-3 m-r-sm">{{trans('phone.search')}}: {{$phone->search_count}}</div>
                    <div class="well well-sm col-sm-4 m-r-sm"> {{trans('phone.city')}}
                        : @if(isset($phone->city->location)){{$phone->city->location}}@else - @endif</div>
                </div>
            </div>

        </div>
        <hr>
        <table class="table">
            <tr>
                <td>
                    {{trans('phone.ip_address')}}
                </td>
                <td>
                    {{trans('phone.activity')}}

                </td>
                <td>
                    {{trans('phone.time')}}

                </td>
            </tr>
            @foreach($last_likes as $item)
                <tr>
                    <td>
                        {{$item->ip.' '}}{{isset($item->time)?$item->time:'  '}}{{' '}}{{isset($item->agent)?$item->agent:''}}
                    </td>
                    <td>
                        @if ($item->value === 1)
                            <span class="label label-success">{{trans('phone.safe_caller')}}</span>
                        @else
                            <span class="label label-danger">{{trans('phone.unsafe_caller')}}</span>
                        @endif
                    </td>
                    <td>
                        {{$item->updated_at->diffForHumans()}}
                    </td>
                </tr>

            @endforeach
        </table>

        <div class="row">
            <div class="col-sm-12 h3">
                <x-likes positive="{{$like->positive}}" negative="{{$like->negative}}"
                         number="{{$phone->short_number}}" trans="{{json_encode(trans('vue.likes'))}}"></x-likes>
            </div>
        </div>
        <hr>

    </div>
    <div class="col-md-4">

        <div class="row">
            <div class="col-md-12">
                {!! isset($google_review->value) ? $google_review->value : '' !!}
            </div>
        </div>
        @if (count($last_comments))
            @include('widgets.comments', ['data'=> $last_comments])
        @endif
        @if (count($random_numbers))
            @include('widgets.random_numbers', ['data'=> $random_numbers])
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>{{trans('phone.modal.title')}}</h3>{{trans('phone.modal.description')}}</div>
                <div class="modal-body">
                            <x-likes positive="{{$like->positive}}" negative="{{$like->negative}}"
                                     neutral="{{$like->neutral}}"
                                     number="{{$phone->short_number}}"
                                     trans="{{json_encode(trans('vue.likes'))}}"></x-likes>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <a href="#form" class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">
                                {{trans('components.leave_a_comment')}}
                            </a>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">
                                {{trans('phone.modal.unknown')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
