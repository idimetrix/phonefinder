@extends('layouts.default')
@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-inverse">
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Type</th>
                <th>Message</th>
                <th>Ratings</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $item)
                <tr>
                    <td>{{$item->phoneId}}</td>
                    <td>{{$item->name}}</td>
                    <?php $array = [
                        trans('components.type.not_specified') => '(Not specified)',
                        'Possible scam',
                        'Missed call',
                        'Telemarketing',
                        'Fake id',
                        'Survey',
                        'Threats',
                        'Prank call',
                        'Automatic reminder',
                        'Debt collector',
                        'Text',
                    ]?>
                    <td>{{$array[$item->type]}}</td>
                    <td>{{$item->message}}</td>
                    <td>{{$item->rating}}</td>
                    <td>{{ Form::open(['action' => ['AdminController@destroyReport', $item->id], 'method' => 'DELETE', 'class' => 'form']) }}
                        <button type="submit" class="btn btn-default">Delete</button>
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">{{$reports->links()}}</div>
    </div>
@stop