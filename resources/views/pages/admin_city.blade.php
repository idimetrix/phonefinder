@extends('layouts.default')
@section('content')
    <div>
        <a href="/admin/area/create"><i class="glyphicon glyphicon-plus-sign"></i> New Area</a>
    </div>
    <div class="well">
        <h4>Search</h4>
        {{ Form::open(['action' => 'AreaController@index', 'method' => 'GET', 'class' => 'form']) }}
        <div class="input-group">
            {{ Form::text('search', '', ['class' => 'form-control',
                            'type'=>'number',
                            'placeholder' => 'Search for a prefix...',
                            'minlength' => '1',
                            'pattern' => '\d*'
                         ]) }}
            <div class="input-group-btn">
                {{ Form::submit('Search', ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <table class="table">
        <thead class="thead-inverse">
        <tr>
            <th>Prefix</th>
            <th>Location</th>
            <th>Dialing code</th>
            <th>Number format</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($city as $item)
            <tr>
                <td>{{ Html::link('admin/area/' . $item->id . '/edit', $item->prefix)}}</td>
                <td>{{$item->location}}</td>
                <td>{{$item->dialing_code}}</td>
                <td>{{$item->number_format}}</td>
                <td>{{ Form::open(['url' => '/admin/area/'. $item->id]) }}
                        <input name="_method" type="hidden" value="DELETE">
                        {{ Form::submit('Delete', ['class' => 'btn btn-delete']) }}
                    {{ Form::close() }}</td>
            </tr>
        @endforeach
        <td></td>
        </tbody>
    </table>
    <div class="pagination">{{$city->links()}}</div>
@stop