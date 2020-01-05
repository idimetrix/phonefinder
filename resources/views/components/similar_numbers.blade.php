<table class="table">
    <tr>
        <td>{{trans('phone.number')}}</td>
        {{--<td>{{trans('phone.prefix')}}</td>--}}
        <td>{{trans('phone.similar_numbers')}}</td>
    </tr>
    @foreach($data as $item)
        <tr>
            <td>
                {{ $item->short_number }}
            </td>
            {{--<td>--}}
                {{--{{$item->prefix}}--}}
            {{--</td>--}}
            <td>
                {{Html::link('/phone/' . $item->short_number, trans('phone.similar_description', ['phone' => $item->short_number]))}}
            </td>
        </tr>
    @endforeach
</table>