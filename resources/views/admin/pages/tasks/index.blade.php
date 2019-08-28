@extends('admin.layouts.default')

@section('title')
    Tasks
@stop

@section('content')
    <div class="content">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">
            @if(isset($users))
                <h2 class="p_title">Tasks</h2>
            @else
                <h2 class="p_title">{!!ucwords($salesperson->first_name)!!} Tasks</h2>
            @endif


            <ul class="p_actions ul_reset clearfix">
                {{--<li>--}}
                {{--<button class="button opener" data-open="filter_wrap" type="button">--}}
                {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">--}}
                {{--<path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>--}}
                {{--</svg>--}}
                {{--Filter--}}
                {{--</button>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<button class="button confirm_demo" type="button">--}}
                {{--Confirm Demo--}}
                {{--</button>--}}
                {{--</li>--}}
                @if(in_array('tasks',$logged_in_user->permissions))
                    @if(isset($admin_mode) && $admin_mode==true)
                        <li>
                            {!!Form::checkbox('','1',true,['id'=>'admin_mode'])!!}{!!Form::label('admin_mode','Admin Mode')!!}
                        </li>
                    @else
                        <li>
                            {!!Form::checkbox('','1',false,['id'=>'admin_mode'])!!}{!!Form::label('admin_mode','Admin Mode')!!}
                        </li>
                    @endif
                @endif
                @if(!isset($users))
                    <li>
                        <a href="{{URL::route('admin.tasks.create',$salesperson_id)}}" class="button confirm_demo">
                            Create New Task
                        </a>
                    </li>
                @endif
            </ul>

        </div>
        <!-- PAGE HEADER : ENDS -->

        {{--<div class="filter_wrap">--}}
        {{--<h4 class="fw_title">Filter Orders</h4>--}}
        {{--<div class="fw_container container_fluid">--}}

        {{--<ul class="ss_form">--}}
        {{--<li class="row">--}}
        {{--<div class="col-xs-3">--}}
        {{--<label>Textbox</label>--}}
        {{--<input type="text" class="datedropper"/>--}}
        {{--</div>--}}
        {{--<div class="col-xs-3">--}}
        {{--<label>Dropdown</label>--}}
        {{--<select>--}}
        {{--<option>Demo 1</option>--}}
        {{--<option>Demo 2</option>--}}
        {{--<option>Demo 3</option>--}}
        {{--</select>--}}
        {{--<span class="ss_error">This field is required</span>--}}
        {{--</div>--}}
        {{--<div class="col-xs-3">--}}
        {{--<label>Checkboxes</label>--}}
        {{--<input id="checkbox1" type="checkbox" class="ss_checkbox input_height"/>--}}
        {{--<label for="checkbox1">Option 1</label>--}}
        {{--<input id="checkbox2" type="checkbox" class="ss_checkbox input_height"/>--}}
        {{--<label for="checkbox2">Option 2</label>--}}
        {{--</div>--}}
        {{--<div class="col-xs-3">--}}
        {{--<label>Radio Buttons</label>--}}
        {{--<input id="radio1" type="radio" class="ss_radio input_height"/>--}}
        {{--<label for="radio1">Option 1</label>--}}
        {{--<input id="radio2" type="radio" class="ss_radio input_height"/>--}}
        {{--<label for="radio2">Option 2</label>--}}
        {{--</div>--}}
        {{--</li>--}}

        {{--<li class="row">--}}
        {{--<div class="col-xs-4">--}}
        {{--<label>Textbox</label>--}}
        {{--<input type="text"/>--}}
        {{--<span class="ss_error">This field is required</span>--}}
        {{--</div>--}}
        {{--<div class="col-xs-4">--}}
        {{--<label>Textbox</label>--}}
        {{--<input type="text"/>--}}
        {{--</div>--}}
        {{--<div class="col-xs-4">--}}
        {{--<label>Textbox</label>--}}
        {{--<input type="text"/>--}}
        {{--</div>--}}
        {{--</li>--}}


        {{--</ul>--}}

        {{--</div>--}}
        {{--</div>--}}

        

        <div class="orders_wrap ss_datatable">

            <button type="button" class="btn btn-primary">Add Task</button>
            &nbsp; &nbsp;
            <table id="users_table" class="orders_table display">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Title</th>
                    <th>Salesperson</th>
                    <th>Salesperson</th>
                    <th>Client</th>
                    <th>Date Time</th>
                    <th>Task Description</th>
                    <th>Task Operation</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('footer')
    <script type="text/javascript">
        $('.select2').select2();
        $('.datepicker').datepicker({
            format:'dd-mm-yyyy'
        });
        $('#admin_mode').change(function(e){
            if($('#admin_mode:checked').val()==1){
                window.location.href = "{!!URL::route('admin.tasks.datatable','admin_mode=true')!!}";
            }else{
                window.location.href = "{!!URL::route('admin.tasks.datatable')!!}";
            }
        });
        function createDatatable(){
            oTable = $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{URL::to('admin/ajax/tasks/data')}}',
                    data:{
                        @if(isset($salesperson_id))
                            salesperson_id:'{!! $salesperson_id !!}',
                        @endif
                        @if(isset($users))
                            salesperson_id:$('#salesperson').val(),
                            status:$('#task_completion').val(),
                            start_date:$('#start_date').val(),
                            end_date:$('#end_date').val(),
                        @endif
                        @if(isset($task_id))
                            task_id:{!!$task_id!!},
                        @endif
                        @if(in_array('tasks',$logged_in_user->permissions))
                            @if(isset($admin_mode) && $admin_mode==true)
                                admin_mode:true
                            @endif
                        @endif
                    }
                },
                columns: [
                    {data:'id', searchable: false,visible:false},
                    {data: 'title', name: 'tasks.title'},
                    {data: 'salesperson_id', name: 'users.first_name'},
                    {data: 'salesperson_id', name: 'users.last_name',visible:false},
                    {data: 'company_name', name: 'companies.name'},
                    {data: 'date_time', name: 'tasks.date_time'},
                    {data: 'disc', name: 'tasks.disc'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order:[[0,'desc']]
            });
        }

        createDatatable();
        $('.select2').change(function(e){
            oTable.destroy();
            createDatatable();
        });
        $('.datepicker').change(function(e){
            oTable.destroy();
            createDatatable();
        });
        $(document).on('click','.responce',function(e){
            e.preventDefault();
            $.ajax({
                dataType:'json',
                method:'post',
                url:'{!!URL::to('admin/ajax/tasks')!!}',
                data:{
                    admin_responce:$(this).attr('id'),
                    admin_comments:$('#admin_comments').val(),
                    admin_id:'{!!$user->id!!}',
                    task_id:$('#admin_task_id').val()
                },
                success:function(data){
                    $('#admin_comments').val('');
                    if(data['success']){
                        notification.create({
                            text:'Something Went Wrong',
                            type:'danger'
                        });
                    }else{
                        notification.create({
                            text:'Successfully Submitted',
                            type:'success'
                        });
                    }
                    popup.close('responce_task');
                }
            });
        });

        @if(isset($task_id))
            loader.on();
            $.ajax({
                dataType:'json',
                method:'get',
                url:'{!!URL::to('admin/ajax/tasks')!!}',
                data:{
                    task_id:{!!$task_id!!}
                },
                success:function(data){
                    var task=data['task'];
                    console.log(task);
                    var user=data['salesperson'];
                    var admin_user=data['admin_user'];
                    $('#salesperson_name').text(user['first_name']+' '+user['last_name']);
                    $('#salesperson_responce').text(task['responce_status']);
                    $('#salesperson_note').text(task['responce_note']);
                    $('#salesperson_responce_at').text(task['responce_at']);
                    $('#salesperson_next_visit').text(task['next_visit']);
                    if(task['admin_responce']!=null){
                        $('#admin_responce').hide();
                        $('#admin_responce_show').show();
                        $('#admin_name').text(admin_user);
                        $('#admin_responce_status').text(task['admin_responce']);
                        $('#admin_comments_show').text(task['admin_comments']);
                    }else{
                        $('#admin_responce').show();
                        $('#admin_responce_show').hide();
                    }
                    popup.open('responce_task');
                    loader.off();

                }
            });
        @endif

        $(document).on('click','.showTaskResponce',function(e){
            e.preventDefault();
            loader.on();
            $('#admin_task_id').val($(this).attr('id'));
            $.ajax({
                dataType:'json',
                method:'get',
                url:'{!!URL::to('admin/ajax/tasks')!!}',
                data:{
                    task_id:$(this).attr('id')
                },
                success:function(data){
                    var task=data['task'];
                    console.log(task);
                    var user=data['salesperson'];
                    var admin_user=data['admin_user'];
                    $('#salesperson_name').text(user['first_name']+' '+user['last_name']);
                    $('#salesperson_responce').text(task['responce_status']);
                    $('#salesperson_note').text(task['responce_note']);
                    $('#salesperson_responce_at').text(task['responce_at']);
                    $('#salesperson_next_visit').text(task['next_visit']);
                    if(task['admin_responce']!=null){
                        $('#admin_responce').hide();
                        $('#admin_responce_show').show();
                        $('#admin_name').text(admin_user);
                        $('#admin_responce_status').text(task['admin_responce']);
                        $('#admin_comments_show').text(task['admin_comments']);
                    }else{
                        $('#admin_responce').show();
                        $('#admin_responce_show').hide();
                    }
                    popup.open('responce_task');
                    loader.off();
                }
            });
        });

        $(document).on('click', '.delete', function () {
            if(confirm('You Sure Want to delete This Task?')){
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: '{{URL::to('admin/ajax/tasks/delete')}}',
                    data: 'tasks_id=' + $(this).attr('id'),
                    success: function (data) {
                        oTable.draw(false);
                        if(data['success']){
                            notification.create({
                                text:'Task doesn\'t Deleted Successfully',
                                type:'danger'
                            });
                        }else{
                            notification.create({
                                text:'Task Deleted Successfully',
                                type:'success'
                            });
                        }
                    }
                });
            }
        });

    </script>
@stop
