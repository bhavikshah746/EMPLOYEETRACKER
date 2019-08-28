@extends('admin.layouts.default')

@section('title')
    Users
@stop

@section('content')
    <div class="content">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">

            <h2 class="p_title">Users</h2>

            <ul class="p_actions ul_reset clearfix">
                <li>
                    <a href="{{URL::route('admin.users.create')}}" class="button confirm_demo">
                        Create New User
                    </a>
                </li>
            </ul>

        </div>
        <!-- PAGE HEADER : ENDS -->

        <div class="orders_wrap ss_datatable">
            <table id="users_table" class="orders_table display">
                <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Employee ID</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('footer')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7R1Pde5zRBq1P5ehBACbnigXOLVs1zDE&callback=initMap">
    </script>
    <script type="text/javascript">

        $('#admin_mode').change(function (e) {
            if ($('#admin_mode:checked').val() == 1) {
                window.location.href = "{!!URL::route('admin.users.index','admin_mode=true')!!}";
            } else {
                window.location.href = "{!!URL::route('admin.users.index')!!}";
            }
        });
        oTable = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{URL::to('admin/ajax/users/data')}}',
                data: {
                    @if(in_array('users',$logged_in_user->permissions))
                            @if(isset($admin_mode) && $admin_mode==true)
                    admin_mode: true
                    @endif
                    @endif
                }
            },
            columns: [
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: 'username', name: 'username'},
                {data: 'role', name: 'role'},
                {data: 'employ_id', name: 'employ_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $(document).on('click', '.delete', function () {
            if (confirm('You Sure Want to delete This User?')) {
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: '{{URL::to('admin/ajax/users/delete')}}',
                    data: 'user_id=' + $(this).attr('id'),
                    success: function (data) {
                        oTable.draw(false);
                        if (data['success']) {
                            notification.create({
                                text: 'User doesn\'t Deleted Successfully',
                                type: 'danger'
                            });
                        } else {
                            notification.create({
                                text: 'User Deleted Successfully',
                                type: 'success'
                            });
                        }
                    }
                });
            }
        });
        $('.date_time').datetimepicker({
            format: 'D-M-YYYY  H:mm'
        });
        $('#companies_select').select2();
        var user_id = '';
        $(document).on('click', '.taskCreate', function (e) {
            e.preventDefault();
            user_id = $(this).attr('id');
            loader.on();
            $.ajax({
                dataType: 'json',
                method: 'post',
                url: "{!!URL::to('admin/ajax/users/companies')!!}",
                data: {
                    user_id: $(this).attr('id')
                },
                success: function (data) {
                    $('#companies_select').text('');
                    $('#companies_select').append($('<option>',
                        {
                            value: '',
                            text: 'Select Client'
                        }));
                    for (var i = 0; i < data['companies'].length; i++) {
                        data['companies'][i]['name'] = data['companies'][i]['name'].toLowerCase().replace(/\b[a-z]/g, function (letter) {
                            return letter.toUpperCase();
                        });
                        $('#companies_select').append($('<option>',
                            {
                                value: data['companies'][i]['id'],
                                text: data['companies'][i]['name']
                            }));
                    }
                    $('#companies_select').trigger('select2:update');
                    popup.open('create_task');
                    loader.off();
                }
            });
        });
        $(document).on('click', '#taskFormSubmit', function (e) {
            e.preventDefault();
            if ($('#taskFormTitle').val() != '' && $('#companies_select').val() != '' && $('#taskFormDate').val() != '') {
                $.ajax({
                    dataType: 'json',
                    method: 'post',
                    url: '{!!URL::to('admin/ajax/tasks/store')!!}',
                    data: {
                        title: $('#taskFormTitle').val(),
                        company_id: $('#companies_select').val(),
                        date_time: $('#taskFormDate').val(),
                        disc: $('#taskFormDisc').val(),
                        salesperson_id: user_id,
                        is_notification_send: $('#is_notification_send:checked').val()
                    },
                    success: function (data) {
                        if (data['status']) {
                            $('#taskFormTitle').val('');
                            $('#companies_select').val('');
                            $('#taskFormDate').val('');
                            $('#taskFormDisc').val('');
                            popup.close('create_task');
                            notification.create(
                                {
                                    text: 'Task Submitted Successfully',
                                    type: 'success'
                                }
                            );
                        } else {
                            notification.create({
                                text: data['errors'],
                                type: 'danger'
                            });
                        }
                    }
                });
            } else {
                if ($('#taskFormTitle').val() == '') {
                    $('#taskFormTitleError').text('Title Is Required.');
                }
                if ($('#companies_select').val() == '') {
                    $('#taskFormCompanyError').text('Client Is Required.');
                }
                if ($('#taskFormDate').val() == '') {
                    $('#taskFormDateError').text('Date And Time Is Required.');
                }
            }
        });

        var flightPlanCoordinates = [];
        var centerP = [];


        function initMap(flightPlanCoordinates, centerP) {

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: centerP,
                mapTypeId: 'terrain'
            });

            var bounds = new google.maps.LatLngBounds();

            var flightPath = new google.maps.Polyline({
                path: flightPlanCoordinates,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 5
            });

            flightPath.setMap(map);
            var labelIndex = 0;
            markers = flightPlanCoordinates;


            for (i = 0; i < markers.length; i++) {
                labelIndex = labelIndex + 1;
                var position = new google.maps.LatLng(markers[i]['lat'], markers[i]['lng']);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    label: labelIndex.toString(),
                    title: markers[i][0]
                });

                var infowindow = new google.maps.InfoWindow();

                // Allow each marker to have an info window    
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(markers[i]['time']);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }
        }

        function map_show() {
            $.ajax({
                dataType: 'json',
                method: 'get',
                url: '{!!URL::to('admin/ajax/map')!!}',
                data: {
                    user_id: $('#map_show_user_id').val(),
                    date: $('#map_show_date').val()
                },
                success: function (data) {
                    $('#mapshow_user_name').text(data['user']['first_name'] + ' ' + data['user']['last_name']);
                    $('#map_show_username').text(data['user']['first_name'] + ' ' + data['user']['last_name']);
                    initMap(data['map'], data['map'][0]);
                    popup.open('map_show_popup');
                    loader.off();
                }
            });
        }

        $(document).on('click', '.map_show', function (e) {
            e.preventDefault();
            $('#map_show_user_id').val($(this).attr('id'));
            loader.on();
            map_show();
        });
        $('#map_show_date').datepicker({
            format: 'dd-mm-yyyy'
        });
        $(document).on('change', '#map_show_date', function (e) {
            loader.on();
            map_show();
        });
    </script>
@stop