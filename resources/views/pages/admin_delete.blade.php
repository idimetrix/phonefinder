@extends('layouts.default')
@section('content')
    <div class="col-lg-8">
        <!-- Search -->
        <div class="well">
            <h4>Search</h4>
            {{ Form::open(['action' => 'AdminController@showDelete', 'method' => 'GET', 'class' => 'form']) }}
            <div class="input-group">
                {{ Form::text('search', $search, ['class' => 'form-control',
                                'type'=>'number',
                                'placeholder' => 'Search for a phone...',
                                'minlength' => '7',
                                'maxlength' => '12',
                                'pattern' => '\d*'
                             ]) }}
                <div class="input-group-btn">
                    {{ Form::submit('Search', ['class' => 'btn btn-default']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
        <!-- // Search -->
        @include('components.last_number', ['data' =>$last_add_numbers,'search'=>$search])
    </div>
    <!-- Sidebar widgets -->
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
    </div>
    <!-- // Sidebar widgets -->
@stop