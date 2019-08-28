<div class="popup_overlay">
    <div class="popup" id="create_task">

        <!-- POPUP HEADER : STARTS -->
        <div class="popup_header">
            <h5 class="popup_title" id="popup_product_title">Create Task</h5>

            <button class="popup_close"></button>
        </div>
        <!-- POPUP HEADER : ENDS -->

        <!-- POPUP CONTENT : STARTS -->
        <div class="popup_content">
            
            <ul class="ss_form">
                <li class="row">
                    <div class="col-md-12">
                        {!!Form::label('title','Title')!!}
                        {!!Form::text('title', old('title'), ['placeholder'=>'Title','id'=>'taskFormTitle'])!!}
                        <span class="ss_error" id="taskFormTitleError"></span>
                    </div>
                </li>
                <li class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!!Form::label('company_id','Client ID')!!}
                            {!!Form::select('company_id',[],old('company_id'),['placeholder'=>'Select Client','id'=>'companies_select','class'=>'select2'])!!}
                            <span class="ss_error" id="taskFormCompanyError"></span>
                        </div>
                    </div>
                </li>
                <li class="row">
                    <div class="col-md-12">
                        {!!Form::label('date_time','Date And Time')!!}
                        
                        {!!Form::text('date_time', old('date_time'), ['class'=>'date_time','id'=>'taskFormDate'])!!}
                        
                        <span class="ss_error" id="taskFormDateError"></span>
                    </div>
                </li>
                <li class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!!Form::label('disc','Description')!!}
                            {!!Form::textarea('disc', old('disc'), ['id'=>'taskFormDisc'])!!}
                        </div>
                    </div>
                </li>
                <li class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!!Form::checkbox('is_notification_send', '1',false, ['id'=>'is_notification_send'])!!}
                            {!!Form::label('is_notification_send','Notification Send')!!}
                        </div>
                    </div>
                </li>
                <li class="row">
                    <div class="col-md-12">
                        {!!Form::submit('Save',['class'=>'button','id'=>'taskFormSubmit'])!!}
                    </div>
                </li>
            </ul>
        </div>
        <!-- POPUP CONTENT : ENDS -->


        <!-- POPUP FOOTER : STARTS -->
        <div class="popup_footer">
			
        </div>
        <!-- POPUP FOOTER : ENDS -->

    </div>
</div>