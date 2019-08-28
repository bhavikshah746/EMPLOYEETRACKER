<div class="popup_overlay">
    <div class="popup" id="responce_task">

        <!-- POPUP HEADER : STARTS -->
        <div class="popup_header">
            <h5 class="popup_title" id="popup_product_title">Response</h5>

            <button class="popup_close"></button>
        </div>
        <!-- POPUP HEADER : ENDS -->

        <!-- POPUP CONTENT : STARTS -->
        <div class="popup_content">
            
            <ul class="pd-20">
                <li>Sales Person: <span id="salesperson_name"></span></li>
                <li>Sales Person Response: <span id="salesperson_responce"></span></li>
                <li>Sales Person Note: <span id="salesperson_note"></span></li>
                <li>At: <span id="salesperson_responce_at"></span></li>
                <li>Next Visit: <span id="salesperson_next_visit"></span></li>
            </ul>
			<div id="admin_responce">
                <form method="POST" action="https://salesforce.admin.rocks/admin/tasks/36/approval" accept-charset="UTF-8" id="responce_form"><input name="_token" type="hidden" value="fDr5ZWsuFy0HPBMbsBS8tM8QylSCOM9e5C8b67cD">
					<ul class="ss_form">
						<li class="row">
							<div class="col-md-12">
								<label for="admin_comments">Comment</label>
								<textarea rows="2" name="admin_comments" cols="50" id="admin_comments" style="margin: 0px; width: 100%; height: 62px;"></textarea>
							</div>
						</li>
						<li class="row">
							<div class="col-md-12">
                                <input id="admin_responce" name="admin_responce" type="hidden" value="">
								<input id="admin_task_id" name="admin_responce" type="hidden" value="">
								<input class="btn btn-danger responce" id="0" type="submit" value="Rejected">
								<input class="btn btn-success responce" id="1" type="submit" value="Approved">
							</div>
						</li>
					</ul>
				</form>
			</div>
            <div id="admin_responce_show">
                <ul class="pd-20">
                    <li>Admin: <span id="admin_name"></span></li>
                    <li>Admin Response: <span id="admin_responce_status"></span></li>
                    <li>Admin Comments: <span id="admin_comments_show"></span></li>
                </ul>
            </div>
        </div>
        <!-- POPUP CONTENT : ENDS -->


        <!-- POPUP FOOTER : STARTS -->
        <div class="popup_footer">
			
        </div>
        <!-- POPUP FOOTER : ENDS -->

    </div>
</div>