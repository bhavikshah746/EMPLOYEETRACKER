<?php
    use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
?>
<aside class="sidebar auto_close">
	<div class="s_logo">
		<a href="{!!URL::to('/')!!}">
			<!--<img src="{{URL::to('/')}}/img/admin/emplogo.png"> -->
		</a>
	</div>
    <nav class="s_nav">
        <ul class="s_nav_list ul_reset s_nav_tools">
            <li><a href="{!! URL::route('home') !!}">Dashboard</a></li>
            <li><a href="{!! URL::route('admin.users.index') !!}">Users</a></li>
            <li><a href="{!! URL::route('admin.tasks.datatable') !!}">Tasks</a></li>
            <li><a href="{!! URL::route('admin.tasks.datatable') !!}">Logout</a></li>
        </ul>
    </nav>
    <div class="side_footer">

		<!--<a href="https://vytechenterprise.com/"><h3>Developed By Student of JCUB for ICT Project</h3></a>-->
    </div>
</aside>
