@extends('admin.layouts.default')

@section('title')
    Responce
@stop

@section('content')
    <div class="content">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">

            <h2 class="p_title">Responce</h2>

            <ul class="p_actions ul_reset clearfix">
                <li>
                    <a href="{{URL::route('admin.tasks.index',$salesperson_id)}}" class="button confirm_demo">
                        Back to Sales Persons Tasks
                    </a>
                </li>
            </ul>

        </div>

        <div>
            <ul>
                <li>SalesPerson:{!!ucwords($salesperson->first_name)!!} {!!ucwords($salesperson->last_name)!!}</li>
                <li>SalesPerson Responce:{!!config('site.responces.tasks_salesperson_responce')[$task->responce_status]!!}</li>
                <li>Salesperson Note:{!!$task->responce_note!!}</li>
                <li>At:{!!date_format(date_create($task->responce_at),'d-M-Y H:i:S')!!}</li>
                <li>Next Visit:{!!date_format(date_create($task->next_visit),'d-M-Y H:i:S')!!}</li>
            </ul>
        </div>
        @if($task->admin_responce!=null)
            <div>
                <ul>
                    <li>Admin: {!!ucwords($user->first_name.' '.$user->last_name)!!}</li>
                    <li>Admin Responce:{!!config('site.responces.tasks_salesperson_responce')[$task->admin_responce]!!}</li>
                    <li>Admin Comments: {!!$task->admin_comments!!}</li>
                </ul>
            </div>
        @else
            <div>
                {!!Form::open(['route'=>['admin.tasks.approval',$task->id],'id'=>'responce_form'])!!}
                <ul class="ss_form">
                    <li class="row">
                        <div class="col-xs-6">
                            {!!Form::label('admin_comments','Comment')!!}
                            {!!Form::textarea('admin_comments','',['rows'=>'2'])!!}
                        </div>
                    </li>
                    <li class="row">
                        <div class="col-xs-6">
                            {!!Form::hidden('admin_responce','',['id'=>'admin_responce'])!!}
                            {!!Form::hidden('admin_id',$user->id)!!}
                            {!!Form::submit('Rejected',['class'=>'btn btn-danger responce','id'=>'0'])!!}
                            {!!Form::submit('Approve',['class'=>'btn btn-success responce','id'=>'1'])!!}
                        </div>
                    </li>
                </ul>
            </div>
        @endif

    </div>
@stop

@section('footer')
    <script type="text/javascript">
        $('.responce').click(function(e){
            e.preventDefault();
            $('#admin_responce').val($(this).attr('id'));
            $('#responce_form').submit();
        });
    </script>
@stop