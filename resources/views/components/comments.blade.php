<div class="row">
    <div class="col-sm-12">
        @if(session()->has('msg'))
            <div class="alert {{session()->get('type')}}">
                {{ session()->get('msg') }}
            </div>
        @endif
        @foreach($comments as $item)
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading">
                        {{$item->name}}
                        <small>{{$item->created_at}}</small>

                    </h4>
                    {{$item->message}}
                </div>
            </div>
        @endforeach
        <div class="pagination">{{$comments->links()}}</div>

        <div class="well" id="form">
            <h4>{{trans('components.leave_a_comment')}}:</h4>
            <label>{{trans('components.comment_label')}}</label>
            {{ Form::open(['action' => ['ActionsController@comment', $number], 'method' => 'POST', 'class' => 'form']) }}
            <div class="row">
                <div class="col-sm-10">
                    <div class="form-group">
                        {{ Form::textarea('message', null, ['size' => '30x3', 'class' => 'form-control', 'minlength' => '5', 'required' => 'required']) }}
                    </div>
                    <div>
                        <div class="form-group">
                            <label>{{trans('components.type.type')}}</label>
                            {{Form::select('type', array('' => trans('components.type.not_specified'),
                                '1' => trans('components.type.missed_call'),
                                '2' => trans('components.type.telemarketing'),
                                '8' => trans('components.type.debt_collector'),
                                '3' => trans('components.type.fake_id'),
                                '4' => trans('components.type.survey'),
                                '9' => trans('components.type.text'),
                                '0' => trans('components.type.possible_scam'),
                                '5' => trans('components.type.threats'),
                                '6' => trans('components.type.prank_call'),
                                '7' => trans('components.type.automatic_reminder')
                             ), null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{trans('components.name')}}</label>
                        {{ Form::text('name', '', ['class' => 'form-control', 'type'=>'text', 'placeholder' => 'Your name', 'minlength' => '4']) }}
                    </div>
                </div>

            </div>



            {{ Form::submit(trans('components.submit'), ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
