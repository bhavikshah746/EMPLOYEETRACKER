@extends('admin.layouts.default')

@section('title')
    Notifications
@stop

@section('content')
    <div class="content">
        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">

            <h2 class="p_title">Notifications</h2>

            <ul class="p_actions ul_reset clearfix">
                
            </ul>

        </div>
        <!-- PAGE HEADER : ENDS -->


        <div class="orders_wrap ss_datatable">
            <table id="users_table" class="orders_table display">
                <thead>
                <tr>
                    <th>Body</th>
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
        oTable = $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{URL::to('admin/ajax/notifications/data')}}',
                data: function (d) {
                }
            },
            columns: [
                {data: 'body',name: 'body'}
            ]
        });
        $(document).on('click', '.delete', function () {
            if(confirm('You Sure Want to delete This Company?')){
                $.ajax({
                    dataType: 'json',
                    type: 'post',
                    url: '{{URL::to('admin/ajax/companies/delete')}}',
                    data: 'company_id=' + $(this).attr('id'),
                    success: function (data) {
                        oTable.draw(false);
                        if(data['success']){
                            notification.create({
                                text:'Company doesn\'t Deleted Successfully',
                                type:'danger'
                            });
                        }else{
                            notification.create({
                                text:'Company Deleted Successfully',
                                type:'success'
                            });
                        }
                    }
                });
            }
        });
    </script>
@stop