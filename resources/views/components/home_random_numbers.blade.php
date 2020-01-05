@foreach($data as $value)
    <div class="panel panel-default">
        <div class="panel-heading ">
            <div class="h4">
                {{Html::link('/phone/' . $value, $value)}}
            </div>
        </div>
        <div class="panel-body h4">
            {{trans('components.default_message_random')}} {{$value}}
            , {{Html::link('/phone/' . $value, trans('components.see_more'))}}
        </div>
    </div>
@endforeach