@foreach ($data as $value)
    <div class="panel panel-default">
        <div class="panel-heading ">
            <div class="h4">
                {{Html::link('/phone/' . $value->short_number, $value->short_number)}}
            </div>
        </div>
        <div class="panel-body no-padding">
            <div class="padding-none">Found is the caller information for {{$value->short_number}}
                    , {{Html::link('/phone/' . $value->short_number, trans('components.see_more'))}}</div>
            <div class="delete_aliases">Aliases: {{$value->aliases}} , Prefix {{$value->prefix}}</div>
            <div class="count_page">
                <div>Comments {{$value->comments_count}}</div>
                <div>Count views {{$value->views_count}}</div>
                <div>Number of voters {{$value->likes_count}}</div>
            </div>

            <div class="btn-delete-number">
                <button class="btn btn-delete" type="button" data-toggle="modal"
                        data-target="#createSubscriptionModal">Delete
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createSubscriptionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-delete" role="document">
            <div class="modal-content ">
                <div class="delete-header">
                    <h3 class="modal-title">Are you sure?</h3>
                </div>
                {{ Form::open(['url' => '/admin/delete/'. $value->id]) }}
                <div class="delete-footer">
                    <button type="button" class="btn btn-success no-delete" data-dismiss="modal">No</button>
                    {{ Form::submit('Delete', ['class' => 'btn btn-delete yes-delete','data-toggle'=>"modal",
                                       'data-target'=>"#createSubscriptionModal"]) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endforeach


