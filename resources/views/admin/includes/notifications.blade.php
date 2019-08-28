<div class="nt_menu auto_close notifications">
	<ul class="notification_list ul_reset">

		  @foreach($notification as $key=>$value)
			<li
			@if($value->is_read==0)
				class="unread"
			@endif
			><a href="{!!URL::route($value->route,'user_id='.$value->from.'&id='.$value->main_id.'&ref=noti&noti_id='.$value->id)!!}">{!!$value->body!!}</a></li>
		  @endforeach
	</ul>
	@if(count($notification)!=0)
		<div class="fx_show"><a href="{!!URL::route('admin.notifications.index')!!}">Show all</a></div>
	@else
		<div class="fx_show">No Notification</div>
	@endif
</div>
