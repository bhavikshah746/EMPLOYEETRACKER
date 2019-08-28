@extends('admin.layouts.default')

@section('title')
    Designs
@stop

@section('content')
    <div class="content">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">

            <h2 class="p_title">Designs</h2>

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
                @if(Sentinel::getUser()->role==1 || in_array('products',$logged_in_user->permissions))
                    @if(Sentinel::getUser()->role==2)
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
                    @if((isset($admin_mode) && $admin_mode==true) || Sentinel::getUser()->role==1)
                        <li>
                            <a href="{!!URL::route('admin.designs.excel')!!}" class="button confirm_demo">
                                Create Designs From Excel
                            </a>
                            <a href="{{URL::route('admin.designs.create')}}" class="button confirm_demo">
                                Create New Designs
                            </a>
                        </li>
                    @endif
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
            <table id="users_table" class="orders_table display">
                <thead>
                <tr>
                    <th>Name</th>
                    @if(Sentinel::getUser()->role==1 ||in_array('products',$logged_in_user->permissions))
                        @if(Sentinel::getUser()->role==1 ||(isset($admin_mode) && $admin_mode==true))
                            <th>Action</th>
                        @endif
                    @endif
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
        $('#admin_mode').change(function(e){
            if($('#admin_mode:checked').val()==1){
                window.location.href = "{!!URL::route('admin.designs.index','admin_mode=true')!!}";
            }else{
                window.location.href = "{!!URL::route('admin.designs.index')!!}";
            }
        });
        oTable = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{URL::to('admin/ajax/designs/data')}}',
                data: function (d) {
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                @if(Sentinel::getUser()->role==1 || in_array('products',$logged_in_user->permissions))
                    @if(Sentinel::getUser()->role==1 || (isset($admin_mode) && $admin_mode==true))
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    @endif
                @endif
            ]
        });
        $(document).on('click', '.delete', function () {
            if(confirm('You Sure Want to delete This Finish?')){
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: '{{URL::to('admin/ajax/designs/delete')}}',
                    data: 'design_id=' + $(this).attr('id'),
                    success: function (data) {
                        oTable.draw(false);
                        if(data['success']){
                            notification.create({
                                text:'Finish doesn\'t Deleted Successfully',
                                type:'danger'
                            });
                        }else{
                            notification.create({
                                text:'Finish Deleted Successfully',
                                type:'success'
                            });
                        }
                    }
                });
            }
        });
    </script>
@stop