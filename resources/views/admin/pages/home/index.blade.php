@extends('admin.layouts.default')

@section('title')
    Dashboard	
@stop

@section('content')
    <div class="content clearfix">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">
            
            <h2 class="p_title">Dashboard</h2>

        </div>
        <!-- PAGE HEADER : ENDS -->

        <!-- PAGE CONTENT : STARTS -->
        <div class="page_content">
        <!--
        	@if(count($attendence)==0)
        		{!!Form::open(['route'=>'admin.attendance.store'])!!}
	            <ul class="ss_form">
	                <li class="row">
	                    <div class="col-xs-6">
	                    	{!!Form::hidden('type','1')!!}
	                        {!!Form::submit('Start Day',['class'=>'button'])!!}
	                    </div>
	                </li>
	            </ul>
	            {!!Form::close()!!}
        	@elseif( count($attendence)==1 && $attendence->start_time!='00:00:00' && $attendence->end_time=='00:00:00' )
        		{!!Form::open(['route'=>'admin.attendance.store','id'=>'end_day_form'])!!}
	            <ul class="ss_form">
	            	<li class="row">
	            		<div class="col-xs-6">
	            			@if($attendence->draft=='1')
	            				{!!Form::textarea('note',$attendence->note,['rows'=>'2'])!!}
	            			@else
	            				{!!Form::textarea('note','',['rows'=>'2'])!!}
	            			@endif
	            		</div>
	            	</li>
	                <li class="row">
	                    <div class="col-xs-6">
	                    	{!!Form::hidden('type','2')!!}
	                    	{!!Form::hidden('draft','0',['id'=>'end_day_draft'])!!}
	                        {!!Form::submit('End Day',['class'=>'button'])!!}
	                        {!!Form::submit('Draft',['class'=>'button draft'])!!}
	                    </div>
	                </li>
	            </ul>
	            {!!Form::close()!!}
        	@else
	            <ul class="ss_form">
	                <li class="row">
	                    <div class="col-xs-6">
	                    	{!!Form::label('Your Day Is Ended')!!}
	                    </div>
	                </li>
	            </ul>
        	@endif-->

        	<div class="col-xs-4">
        		<h2 class="title_box">{!!Form::label('month','Select Salesperson')!!}</h2>
        		{!!Form::select('',$salespersons,'',['class'=>'select2','placeholder'=>"Select User",'id'=>'salesperson'])!!}	
        	</div>
        	<div class="col-xs-4">
        		<h2 class="title_box">{!!Form::label('month','Months')!!}</h2>
        		{!!Form::select('',$months,date('m'),['class'=>'select2','Placeholder'=>"Select Month",'id'=>'months'])!!}
        	</div>
        	<div class="col-xs-4">
        		<h2 class="title_box">{!!Form::label('month','Years')!!}</h2>
        		{!!Form::select('',$years,date('Y'),['class'=>'select2','Placeholder'=>"Select Year",'id'=>'year'])!!}	
        	</div>
        	<div id="info" style="margin-top: 15px;">
        		<div class="col-xs-12 md-20-2">

        			<div class="col-xs-4">
						<div class="chart_box">
							<h2 class="title_box">
								{!!Form::label('month','Tasks')!!}
							</h2>
							<div id="tasksChartDiv">
								<canvas id="tasksChart" width="400" height="400"></canvas>
							</div>
						</div>
        			</div>
        			<div class="col-xs-4">
						<div class="chart_box">
							<h2 class="title_box">	
								{!!Form::label('month','Orders')!!}
							</h2>
							<div id="ordersChartDiv">
								<canvas id="ordersChart" width="400" height="400"></canvas>
							</div>
						</div>
        			</div>
					<div class="col-xs-4">
						<div class="chart_box">
						<div class="col-xs-6">	
							<h2 class="title_box">	
								{!!Form::label('month','Expenses')!!}
							</h2>
						</div>
						<div id="expencesChartDiv">
								<canvas id="expencesChart" width="400" height="400"></canvas>
							</div>
						</div>
        			</div>
        		</div>
        		<div class="col-xs-12 md-20-2">  
					<div class="map_box">
						<div class="col-xs-2 md-10 pull-left">
						<h2 class="title_box"> 
							{!!Form::label('month','Tasks')!!}
						</h2>
						</div>
						
						<table id="tasks_table" class="orders_table display">
							<thead>
							<tr>
								<th>Title</th>
								<th>Title</th>
								<th>Client</th>
								<th>Date</th>
								<th>Description</th>
								<!-- <th>Action</th> -->
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
        		</div>
        		<div class="col-xs-12 md-20-2">
					<div class="map_box clearfix">
						<div class="col-xs-2 md-10 pull-left">
						<h2 class="title_box">
							{!!Form::label('month','Orders')!!}
						</h2>
						</div>
						<table id="orders_table" class="orders_table display">
							<thead>
							<tr>
								<th>Title</th>
								<th>Category Name</th>
								<th>Company</th>
								<th>Date And Time</th>
								<th>Status</th>
								<!-- <th>Action</th> -->
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
        		</div>
				<div class="col-xs-12 md-20-2">
					<div class="map_box">
						<div class="col-xs-6 md-10">
							<h2 class="title_box pd-1">
								{!!Form::label('month','Location')!!}
							</h2>	
						</div>
						<div class="col-xs-6 pull-right pd-none">
							<div class="col-xs-6">
								<h2 class="title_box pull-right pd-1">
									{!!Form::label('month','Date')!!}
								</h2>	
							</div>
							<div class="col-xs-6 pull-right pd-2 pd-none">	{!!Form::text('',date('d-m-Y'),['class'=>'datepicker','placeholder'=>'Select Date','id'=>'locationMapDate'])!!}
							</div>
						</div>
						<div id="locationMapDiv" style="height:300px;width:100%;">	
						</div>
					</div>
				</div>
        		
        	</div>

        </div>
        <!-- PAGE CONTENT : ENDS -->
    </div>
@stop

@section('footer')
	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7R1Pde5zRBq1P5ehBACbnigXOLVs1zDE&callback=initMap">
    </script>
    <script type="text/javascript">
    	$('.draft').click(function(e){
    		e.preventDefault();
    		$('#end_day_draft').val('1');
    		$('#end_day_form').submit();
    	});
    	$('#info').hide();
    	$('.select2').select2();
    	$('.datepicker').datepicker({
    		format: 'dd-mm-yyyy'
    	});

    	//Table
    	function createOrderDatatable(){
            oTable = $('#orders_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{URL::to('admin/ajax/orders/data')}}',
                    data:{
                        salesperson_id:$('#salesperson').val(),
                        // status:$('#task_completion').val(),
                        year:$('#year').val(),
    					month:$('#months').val(),
                    }
                },
                columns: [
                    {data:'id', searchable: false,visible:false},
                    {data: 'category_name', name: 'categories.name'},
                    {data: 'company_name', name: 'companies.name'},
                    {data: 'date', name: 'users.last_name', orderable: false, searchable: false},
                    {data: 'status', name: 'users.last_name', orderable: false, searchable: false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order:[[00,'desc']],
                bFilter: false
            });
        }
		createOrderDatatable();


		function createTasksDatatable(){
            tTable = $('#tasks_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{URL::to('admin/ajax/tasks/data')}}',
                    data:{
                        salesperson_id:$('#salesperson').val(),
                        year:$('#year').val(),
    					month:$('#months').val(),
                    }
                },
                columns: [
                    {data:'id', searchable: false,visible:false},
                    {data: 'title', name: 'tasks.title'},
                    {data: 'company_name', name: 'companies.name'},
                    {data: 'date_time', name: 'tasks.disc'},
                    {data: 'disc', name: 'tasks.disc', orderable: false, searchable: false},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order:[[0,'desc']],
                bFilter: false
            });
        }
        createTasksDatatable();


    	// map
    	var flightPlanCoordinates=[];
        var centerP=[];
        function initMap(flightPlanCoordinates,centerP) {
            var map = new google.maps.Map(document.getElementById('locationMapDiv'), {
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
            markers=flightPlanCoordinates;

            for( i = 0; i < markers.length; i++ ) {
                labelIndex=labelIndex+1;
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
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(markers[i]['time']);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }
        }




    	//chart
    	function tasksChartGenerate(id,data){
    		var month=[];
    		var data_local=[];
    		for (var i = 1; i <= 31; i++) {
    			if(data[i]!=undefined){
    				month.push(i);
    				data_local.push(data[i]);
    			}
    		}
    		$('#'+id+'Div').html('<canvas id="'+id+'" width="400" height="400"></canvas>');
			var ctx = document.getElementById(id);
			var myChart = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			        labels: month,
			        datasets: [{
			            label: '# of Votes',
			            data: data_local,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)',
			                'rgba(255, 100, 132, 0.2)',
			                'rgba(54, 170, 235, 0.2)',
			                'rgba(255, 236, 86, 0.2)',
			                'rgba(75, 123, 192, 0.2)',
			                'rgba(153, 111, 255, 0.2)',
			                'rgba(255, 222, 64, 0.2)',
			                'rgba(255, 99, 132, 0.1)',
			                'rgba(54, 162, 235, 0.1)',
			                'rgba(255, 206, 86, 0.1)',
			                'rgba(75, 192, 192, 0.1)',
			                'rgba(153, 102, 255, 0.1)',
			                'rgba(255, 159, 64, 0.1)',
			                'rgba(255, 100, 132, 0.1)',
			                'rgba(54, 170, 235, 0.1)',
			                'rgba(255, 236, 86, 0.1)',
			                'rgba(75, 123, 192, 0.1)',
			                'rgba(153, 111, 255, 0.1)',
			                'rgba(255, 222, 64, 0.1)',
			                'rgba(255, 159, 64, 0.3)',
			                'rgba(255, 100, 132, 0.3)',
			                'rgba(54, 170, 235, 0.3)',
			                'rgba(255, 236, 86, 0.3)',
			                'rgba(75, 123, 192, 0.3)',
			                'rgba(153, 111, 255, 0.3)',
			                'rgba(255, 222, 64, 0.3)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)',
			                'rgba(255,100,132,1)',
			                'rgba(54, 163, 235, 1)',
			                'rgba(255, 208, 86, 1)',
			                'rgba(75, 199, 192, 1)',
			                'rgba(153, 106, 255, 1)',
			                'rgba(255, 166, 64, 1)',
			                'rgba(255,99,132,2)',
			                'rgba(54, 162, 235, 2)',
			                'rgba(255, 206, 86, 2)',
			                'rgba(75, 192, 192, 2)',
			                'rgba(153, 102, 255, 2)',
			                'rgba(255, 159, 64, 2)',
			                'rgba(255,100,132,2)',
			                'rgba(54, 163, 235, 2)',
			                'rgba(255, 208, 86, 2)',
			                'rgba(75, 199, 192, 2)',
			                'rgba(153, 106, 255, 2)',
			                'rgba(255, 166, 64, 2)',
			                'rgba(255, 159, 64, 3)',
			                'rgba(255,100,132,3)',
			                'rgba(54, 163, 235, 3)',
			                'rgba(255, 208, 86, 3)',
			                'rgba(75, 199, 192, 3)',
			                'rgba(153, 106, 255, 3)',
			                'rgba(255, 166, 64, 3)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			    }
			});
		}
		function expencesChartGenerate(id,data){
    		var subjects={!!json_encode(config('site.expance'))!!};
    		var subject=[];
    		var data_local=[];
    		for (var i = 1; i <= 6; i++) {
    			if(data[i]!=undefined){
    				subject.push(subjects[i]);
    				data_local.push(data[i]);
    			}
    		}
    		$('#'+id+'Div').html('<canvas id="'+id+'" width="400" height="400"></canvas>');
			var ctx = document.getElementById(id);
			var myChart = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			        labels: subject,
			        datasets: [{
			            label: '# of Votes',
			            data: data_local,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)',
			                'rgba(255, 100, 132, 0.2)',
			                'rgba(54, 170, 235, 0.2)',
			                'rgba(255, 236, 86, 0.2)',
			                'rgba(75, 123, 192, 0.2)',
			                'rgba(153, 111, 255, 0.2)',
			                'rgba(255, 222, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)',
			                'rgba(255,100,132,1)',
			                'rgba(54, 163, 235, 1)',
			                'rgba(255, 208, 86, 1)',
			                'rgba(75, 199, 192, 1)',
			                'rgba(153, 106, 255, 1)',
			                'rgba(255, 166, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			    }
			});
		}
		function getData(){
			oTable.destroy();
            createOrderDatatable();
            tTable.destroy();
            createTasksDatatable();
    		$.ajax({
    			dataType:'json',
    			method:'get',
    			url:'{!!URL::to('admin/ajax/users')!!}',
    			data:{
    				user_id:$('#salesperson').val(),
    				year:$('#year').val(),
    				month:$('#months').val(),
    			},
    			success:function(data){
    				tasksChartGenerate("tasksChart",data['tasks']);
    				tasksChartGenerate("ordersChart",data['orders']);
    				expencesChartGenerate("expencesChart",data['expances']);
    			}
    		});
    		$.ajax({
                dataType:'json',
                method:'get',
                url:'{!!URL::to('admin/ajax/map')!!}',
                data:{
                    user_id:$('#salesperson').val(),
                    date:$('#locationMapDate').val()
                },
                success:function(data){
                    initMap(data['map'],data['map'][0]);
                }
            });
    	}
    	$(document).on('change','.select2',function(){
    		$('#info').show();
    		getData();
    	});
    	$(document).on('change','.datepicker',function(){
    		getData();
    	});
    </script>
@stop