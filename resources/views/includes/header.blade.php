<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container container-header">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">{{trans('pages.toggle_navigation')}}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if($image !== '')
                <a href="/"><img src="/storage/images/{{$image}}" class="logo-image" alt="Logo"></a>
            @else
                {{ Html::link('/', env('NAME_SITE'), ['class' => 'navbar-brand'])}}
            @endif
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li>{{ Html::link('/', trans('pages.links.home'))}}</li>
                <li>{{ Html::link('/top-search', trans('pages.links.tor_search'))}}</li>
                <li>{{ Html::link('/top-safe', trans('pages.links.top_safe'))}}</li>
                <li>{{ Html::link('/top-unsafe', trans('pages.links.top_unsafe'))}}</li>
                <li><a href="/prefix" rel="nofollow">{{ trans('pages.links.prefix')}}</a></li>
                <li><a href="/report" rel="nofollow">{{ trans('pages.links.report')}}</a></li>
                <li>{{ Html::link('/blog', trans('pages.links.blog'))}}</li>
                {{--<li><div class="btn-group">--}}
                        {{--<button type="button" class="btn navbar-btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                            {{--{!! env('BASE_COUNTRY')!!} <span class="caret"></span>--}}
                        {{--</button>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li><a href="https://anycallit.com" class="list-group-item small">--}}
                                    {{--<img src="../../../flags/Italy.png" width="32" height="32" alt="Italy" title="Italy">--}}
                                    {{--{{trans('countries.it')}}--}}
                                {{--</a></li>--}}
                            {{--<li><a href="https://phonefindernl.com" class="list-group-item small">--}}
                                    {{--<img src="../../../flags/Netherlands.png" width="32" height="32" alt="Netherlands" title="Netherlands">--}}
                                    {{--{{trans('countries.nl')}}--}}
                                {{--</a></li>--}}
                            {{--<li><a href="https://anycallbe.com" class="list-group-item small">--}}
                                    {{--<img src="../../../flags/Belgium.png" width="32" height="32" alt="Belgium" title="Belgium">--}}
                                    {{--{{trans('countries.be')}}--}}
                                {{--</a></li>--}}
                            {{--<li><a href="https://anycallpt.com" class="list-group-item small">--}}
                                    {{--<img src="../../../flags/Portugal.png" width="32" height="32" alt="Portugal" title="Portugal">--}}
                                    {{--{{trans('countries.pt')}}--}}
                                {{--</a></li>--}}
                            {{--<li><a href="https://anycallau.com" class="list-group-item small">--}}
                                    {{--<img src="../../../flags/Australia.png" width="32" height="32" alt="Australia" title="Australia">--}}
                                    {{--{{trans('countries.au')}}--}}
                                {{--</a></li>--}}
                            {{--<li role="separator" class="divider"></li>--}}
                            {{--<li class="btn-language">{{ Html::link('/countries', trans('pages.links.countries'), ['class' => 'btn btn-primary '])}}</li>--}}
                        {{--</ul>--}}
                    {{--</div></li>--}}
                @if (!Auth::guest())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Admin({{ Auth::user()->name }}) <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('admin') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Admin Page</a></li>
                            <li><a href="{{ url('admin/report') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Report</a></li>
                            <li><a href="{{ url('admin/phone') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Add phone
                                </a></li>
                            <li><a href="{{ url('admin/area') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Add area
                                </a></li>
                            <li><a href="{{ url('admin/ips') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Add ip
                                </a></li>
                            <li><a href="{{ url('admin/delete') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Delete phone</a></li>
                            <li><a href="{{ url('admin/views') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Views Charts</a></li>
                            <li><a href="{{ url('admin/settings') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Settings</a></li>
                            <li><a href="{{ url('admin/translation') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Translation</a></li>
                            <li><a href="{{ url('/blog/create') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>New Post</a></li>
                            <li><a href="{{ url('/logout') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                @endif
            </ul>
        </div>
    </div>
</nav>
