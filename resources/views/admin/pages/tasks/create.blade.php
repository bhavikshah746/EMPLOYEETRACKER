@extends('admin.layouts.default')

@section('title')
    Tasks
@stop

@section('content')
    <div class="content page_tables">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">
            @if(isset($task))
                <h2 class="p_title">{!!ucwords($salesperson->first_name)!!}  Edit {{ucwords($task->name)}} Info</h2>
            @else
                <h2 class="p_title">Create {!!ucwords($salesperson->first_name)!!} Task</h2>
            @endif

            <ul class="p_actions ul_reset clearfix">
                <li>
                    <a class="button" type="button" href="{{URL::route('admin.tasks.index',$salesperson_id)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M21 11H6.83l3.58-3.59L9 6l-6 6 6 6 1.41-1.41L6.83 13H21z"/>
                        </svg>
                        Back To Tasks
                    </a>
                </li>
            </ul>

        </div>
        <!-- PAGE HEADER : ENDS -->

        <!-- PAGE CONTENT : STARTS -->
        <div class="page_content">
            @if(isset($task))
                {!!Form::model($task,['route'=>['admin.tasks.update',$task->id],'method'=>'PUT'])!!}
            @else
                {!!Form::open(['route'=>['admin.tasks.store',$salesperson_id]])!!}
            @endif
            <ul class="ss_form">
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('title','Title')!!}
                        {!!Form::text('title', old('title'), ['placeholder'=>'Title'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('title')}}</span>
                        @endif
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            {!!Form::label('company_id','Client ID')!!}
                            {!!Form::select('company_id',$companies,old('company_id'),['placeholder'=>'Select Client','class'=>'select2'])!!}
                            @if(count($errors)>0)
                                <span class="ss_error">{{$errors->first('company_id')}}</span>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('date_time','Date And Time')!!}
                        @if(isset($task))
                            {!!Form::text('date_time', date_format(date_create($task->date_time),'d-m-Y  H:i'), ['class'=>'date_time'])!!}
                        @else
                            {!!Form::text('date_time', old('date_time'), ['class'=>'date_time'])!!}
                        @endif
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('date_time')}}</span>
                        @endif
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            {!!Form::label('disc','Description')!!}
                            {!!Form::textarea('disc', old('disc'), [''])!!}
                            @if(count($errors)>0)
                                <span class="ss_error">{{$errors->first('disc')}}</span>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            @if(isset($task) && $task->is_notifiation_send=='1')
                                {!!Form::checkbox('is_notification_send', '1',true, ['id'=>'is_notification_send'])!!}
                            @else
                                {!!Form::checkbox('is_notification_send', '1',false, ['id'=>'is_notification_send'])!!}
                            @endif
                            {!!Form::label('is_notification_send','Notification Send')!!}
                        </div>
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::submit('Save',['class'=>'button'])!!}
                    </div>
                </li>
            </ul>
            {!!Form::close()!!}
        </div>
        <!-- PAGE CONTENT : ENDS -->
    </div>
@stop

@section('footer')
    <script type="text/javascript">
        $('.select2').select2();
        $('.date_time').datetimepicker({
            format:'D-M-YYYY  H:mm'
        });
    </script>
@stop