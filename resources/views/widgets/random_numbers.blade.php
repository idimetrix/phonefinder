<div class="well">
    <h4>{{trans('components.random_numbers')}}</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                @foreach($data as $item)
                    <li> {{ Html::link('/phone/' . $item, $item)}} </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>