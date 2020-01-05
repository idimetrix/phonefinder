@extends('layouts.default')
@section('content')
    <div>
        <a href="/admin/ips/create"><i class="glyphicon glyphicon-plus-sign"></i> New ip</a>
    </div>
    @if ($setting_for_fake_safe == 0)
    <div>
        <a href="/admin/safe-unsafe"><i class=""></i> Generate fake safe/unsafe</a>
    </div>
    @endif
    <table class="table">
        <thead class="thead-inverse">
        <tr>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ips as $item)
            <tr>
                <td>{{ Html::link('admin/ips/' . $item->id . '/edit', $item->value)}}</td>
                <td>{{ Form::open(['url' => '/admin/ips/'. $item->id]) }}
                    <input name="_method" type="hidden" value="DELETE">
                    {{ Form::submit('Delete', ['class' => 'btn btn-delete']) }}
                    {{ Form::close() }}</td>
            </tr>
        @endforeach
        <td></td>
        </tbody>
    </table>
    <div class="pagination">{{$ips->links()}}</div>
@stop