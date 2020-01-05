<table class="table table-bordered table-condensed {{$class}}">
    <thead>
    <tr>
        @foreach($columns as $key => $column)
            <th>{{is_string($column) ? $column : $column['name']}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            @foreach($columns as $key => $column)
                <?php $value = isset($item->$key) ? $item->$key : null; ?>
                <td>{{is_array($column) && isset($column['renderer']) ? $column['renderer']($key, $value, $item, $column) : $value}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>