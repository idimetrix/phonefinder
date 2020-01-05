<div class="col-lg-12">
    <ul class="list-unstyled">
        @foreach($data as $item)
            <li> {{ Html::link('/phone/' . $item->phone->short_number, $item->phone->short_number)}} </li>
        @endforeach
    </ul>
</div>
