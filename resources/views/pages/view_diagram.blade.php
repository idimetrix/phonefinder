@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 charts">
                <h1> Views Charts</h1>
                <div id="pop_div"></div>
                <?= Lava::render('AreaChart', 'Population', 'pop_div') ?>
            </div>
        </div>
    </div>
@stop