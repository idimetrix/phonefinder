@foreach($data as $value)
    <div class="panel panel-default">
        <div class="panel-heading ">
            <div class="h4">
                {{Html::link('/phone/' . $value->short_number, $value->short_number)}}
            </div>
        </div>
        <div class="panel-body h4">
            <span class="label label-{{$value->color}}">{{$value->comment_count}}</span>
            {{$value->message}}
        </div>
    </div>
@endforeach