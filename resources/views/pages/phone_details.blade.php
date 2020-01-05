@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 details">
                <h1>{{trans('details.title_info', ['phone' => $phone->short_number,'name' => $site_name])}}</h1>
                <div>
                    {{trans('details.title_description', ['phone' => $phone->short_number])}}
                    <ul>
                        @if($link_one->value)
                            <li>
                                <a onclick="_gaq.push(['_trackEvent', {!! isset($link_one->value) ? $link_one->value:'' !!}, 'Click', {!! isset($link_one->value) ? $link_one->value:'' !!}]);"
                                   target="_blank"
                                   href="{!! isset($link_one_path->value) ? $link_one_path->value:'' !!}">{!! isset($link_one->value) ? $link_one->value:'' !!}</a>
                                {!! isset($one->value) ? $one->value:'' !!}
                            </li>
                        @endif
                        @if($link_two->value)
                            <li>
                                <a onclick="_gaq.push(['_trackEvent', '{!! isset($link_two->value) ? $link_two->value:'' !!}', 'Click', '{!! isset($link_two->value) ? $link_two->value:'' !!}']);"
                                   target="_blank"
                                   href="{!! isset($link_two_path->value) ? $link_two_path->value:'' !!}">{!! isset($link_two->value) ? $link_two->value:'' !!}</a>
                                {!! isset($two->value) ? $two->value:'' !!}
                            </li>
                        @endif
                        @if($link_three->value)
                            <li>
                                <a onclick="_gaq.push(['_trackEvent', '{!! isset($link_three->value) ? $link_three->value:'' !!}', 'Click', '{!! isset($link_three->value) ? $link_three->value:'' !!}']);"
                                   target="_blank"
                                   href="{!! isset($link_three_path->value) ? $link_three_path->value:'' !!}">{!! isset($link_three->value) ? $link_three->value:'' !!}</a>
                                - {!! isset($three->value) ? $three->value:'' !!}
                            </li>
                        @endif
                        @if($link_four->value)
                            <li> {!! isset($extra->value) ? $extra->value:'' !!} <a
                                        onclick="_gaq.push(['_trackEvent', '{!! isset($link_four->value) ? $link_four->value:'' !!}', 'Click', '{!! isset($link_four->value) ? $link_four->value:'' !!}']);"
                                        target="_blank"
                                        href="{!! isset($link_four_path->value) ? $link_four_path->value:'' !!}">{!! isset($link_four->value) ? $link_four->value:'' !!}</a> {!! isset($four->value) ? $four->value:'' !!}
                        @endif
                    </ul>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@stop
