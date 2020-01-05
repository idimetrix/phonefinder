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
        @foreach($ads as $item)
            <tr>
                <td>{{ Html::link('admin/settings/edit/' . $item->id, $item->key)}}</td>
                <td>{{$item->value}}</td>
            </tr>
        @endforeach
        <td></td>
        </tbody>
    </table>
@stop