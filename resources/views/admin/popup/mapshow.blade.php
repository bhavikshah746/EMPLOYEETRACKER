<div class="popup_overlay">
    <div class="popup popup_wd" id="map_show_popup">

        <!-- POPUP HEADER : STARTS -->
        <div class="popup_header">
            <h5 class="popup_title" id="popup_product_title">Daily Map <span id="map_show_username"></span></h5>

            <button class="popup_close"></button>
        </div>
        <!-- POPUP HEADER : ENDS -->

        <!-- POPUP CONTENT : STARTS -->
        <div class="popup_content">
			<div class="form_wrap row">
				<div class="col-md-6">
					<h2 id="mapshow_user_name">Bhavin</h2>
				</div>
				<div class="col-md-6">
					{!!Form::text('',date('d-m-Y'),['class'=>'','id'=>'map_show_date'])!!}
				</div>
			</div>
			<div id="map" class="map_wd"></div>
            {!!Form::hidden('','',['id'=>'map_show_user_id'])!!}

        </div>
        <!-- POPUP CONTENT : ENDS -->


        <!-- POPUP FOOTER : STARTS -->
        <div class="popup_footer">
			
        </div>
        <!-- POPUP FOOTER : ENDS -->

    </div>
</div>