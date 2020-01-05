@extends('layouts.default')
@section('content')
<table class="table">
    <thead class="thead-inverse">
    <tr>
        <th>Name</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($files as $item)
    <tr>
        <td>{{$item}}</td>
        <td>{{ Html::link('admin/translation/' . substr($item, 0, -4), 'Edit')}}</td>
    </tr>
    @endforeach
    <td></td>
    </tbody>
</table>
@stop