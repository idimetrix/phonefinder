@extends('layouts.default')
@section('content')
    <div>
        <h4>Get</h4>
        {{ Form::open(['action' => ['AdminController@index'], 'method' => 'GET', 'class' => 'form']) }}
        <div class="input-group">
            {{Form::select('type', [
                '0' => 'Today',
                '1' => 'Day',
                '2' => 'Month',
                '3' => 'Year',
             ], null ?: $select, ['class' => 'form-control', 'required', 'aria-required' => 'true'])}}
            <div class="input-group-btn">
                {{ Form::submit('Get', ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <h2 class="sub-header">Visitors</h2>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-inverse">
                <tr>
                    <th>Date</th>
                    <th>Unique Visitor</th>
                    <th>Visitors</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visitors as $item)
                    <tr>
                        <td>{{$item->time}}</td>
                        <td>{{$item->total}}</td>
                        <td>{{$item->sum_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{$visitors->appends(['type' => $select])->links()}}</div>
            <h2 class="sub-header">GoogleBots</h2>
            <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>Date</th>
                    <th>GoogleBots</th>
                </tr>
                </thead>
                <tbody>
                @foreach($google_bots as $item)
                    <tr>
                        <td>{{$item->time}}</td>
                        <td>{{$item->sum_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{$google_bots->appends(['type' => $select])->links()}}</div>
            <h2 class="sub-header">Safe</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Date</th>
                        <th>Safe</th>
                        <th>Unsafe</th>
                        <th>CountVoites</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($safe as $item )
                        <tr>
                            <td>{{$item->time}}</td>
                            <td>{{$item->safe}}</td>
                            <td>{{$item->unsafe}}</td>
                            <td>{{$item->total}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination">{{$ratings->appends(['type' => $select])->links() }}</div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <h2 class="sub-header">Comments</h2>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-inverse">
                <tr>
                    <th>Date</th>
                    <th>Comments</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $item)
                    <tr>
                        <td>{{$item->time}}</td>
                        <td>{{$item->total}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{$comments->appends(['type' => $select])->links()}}</div>
            <h2 class="sub-header">Ratings</h2>
            <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>Date</th>
                    <th>Ratings</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ratings as $item)
                    <tr>
                        <td>{{$item->time}}</td>
                        <td>{{$item->total}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">{{$ratings->appends(['type' => $select])->links() }}</div>
            <h2 class="sub-header">Phone for all time</h2>
            <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>Count</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$count}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@stop