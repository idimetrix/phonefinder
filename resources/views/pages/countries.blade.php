@extends('layouts.default')
@section('content')

    <h1 class="text-center">Select your country</h1>
    <div class="container">
        <div class="row list-group">
            <div class="col-xs-2 m-b-7">
                {{--<div class="m-b-7">--}}
                <a href="https://phonefinderuk.com" class="list-group-item small">
                    <img src="../../../flags/United-Kingdom.png" width="32" height="32" alt="United Kingdom" title="United Kingdom">
                    {{trans('countries.uk')}}
                </a>
                {{--</div>--}}
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://phonefindernl.com" class="list-group-item small">
                    <img src="../../../flags/Netherlands.png" width="32" height="32" alt="Netherlands" title="Netherlands">
                    {{trans('countries.nl')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallbe.com" class="list-group-item small">
                    <img src="../../../flags/Belgium.png" width="32" height="32" alt="Belgium" title="Belgium">
                    {{trans('countries.be')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallpt.com" class="list-group-item small">
                    <img src="../../../flags/Portugal.png" width="32" height="32" alt="Portugal" title="Portugal">
                    {{trans('countries.pt')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallau.com" class="list-group-item small">
                    <img src="../../../flags/Australia.png" width="32" height="32" alt="Australia" title="Australia">
                    {{trans('countries.au')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallit.com" class="list-group-item small">
                    <img src="../../../flags/Italy.png" width="32" height="32" alt="Italy" title="Italy">
                    {{trans('countries.it')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallae.com" class="list-group-item small">
                    <img src="../../../flags/United-Arab-Emirates.png" width="32" height="32" alt="United Arab Emirates" title="United Arab Emirates">
                    {{trans('countries.ae')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallse.com" class="list-group-item small">
                    <img src="../../../flags/Sweden.png" width="32" height="32" alt="Sweden" title="Sweden">
                    {{trans('countries.se')}}
                </a></div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallat.com" class="list-group-item small">
                    <img src="../../../flags/Austria.png" width="32" height="32" alt="Austria" title="Austria">
                    {{trans('countries.at')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallcz.com" class="list-group-item small">
                    <img src="../../../flags/Czech-Republic.png" width="32" height="32" alt="Czech Republic" title="Czech Republic">
                    {{trans('countries.cz')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallch.com" class="list-group-item small">
                    <img src="../../../flags/Switzerland.png" width="32" height="32" alt="Switzerland" title="Switzerland">
                    {{trans('countries.ch')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallde.com" class="list-group-item small">
                    <img src="../../../flags/Germany.png" width="32" height="32" alt="Germany" title="Germany">
                    {{trans('countries.de')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycalldk.com" class="list-group-item small">
                    <img src="../../../flags/Denmark.png" width="32" height="32" alt="Denmark" title="Denmark">
                    {{trans('countries.dk')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallth.com" class="list-group-item small">
                    <img src="../../../flags/Thailand.png" width="32" height="32" alt="Thailand" title="Thailand">
                    {{trans('countries.th')}}
                </a>
            </div>
            <div class="col-xs-2 m-b-7">
                <a href="https://anycallno.com" class="list-group-item small">
                    <img src="../../../flags/Norway.png" width="32" height="32" alt="Norway" title="Norway">
                    {{trans('countries.no')}}
                </a>
            </div>
            {{--<div class="col-xs-2 m-b-7">--}}
                {{--<a href="https://lyricsift.com" class="list-group-item small">--}}
                    {{--<img src="../../../flags/Canada.png" width="32" height="32" alt="Canada" title="Canada">--}}
                    {{--{{trans('countries.ca')}}--}}
                {{--</a>--}}
            {{--</div>--}}
            <div class="col-xs-2 m-b-7">
                <a href="https://incrudo.com" class="list-group-item small">
                    <img src="../../../flags/Turkey.png" width="32" height="32" alt="Turkey" title="Turkey">
                    {{trans('countries.tr')}}
                </a>
            </div>
            {{--<div class="col-xs-2 m-b-7">--}}
                {{--<a href="https://inkafterlife.com" class="list-group-item small">--}}
                    {{--<img src="../../../flags/Saudi-Arabia.png" width="32" height="32" alt="Saudi Arabia" title="Saudi Arabia">--}}
                    {{--{{trans('countries.sa')}}--}}
                {{--</a>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection