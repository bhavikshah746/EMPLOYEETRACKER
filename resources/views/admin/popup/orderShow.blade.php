<div class="popup_overlay">
    <div class="popup" id="order_show">

        <!-- POPUP HEADER : STARTS -->
        <div class="popup_header">
            <h5 class="popup_title" id="popup_Order_title">Responce</h5>

            <button class="popup_close"></button>
        </div>
        <!-- POPUP HEADER : ENDS -->

        <!-- POPUP CONTENT : STARTS -->
        <div class="popup_content">

            <ul class="pd-20">
                <li><b>Client: </b> <span id="order_client_name"></span></li>
                <li><b>SalesPerson: </b> <span id="order_salesperson_name"></span></li>
                <li><b>Order Date: </b> <span id="order_date"></span></li>
                {{--<li>Punched At: <span id="order_created"></span></li>--}}
                {{--<li class="order_eta">ETA(Estimated Time Of Arrival): <span id="order_ETA"></span></li>--}}
                {{--<li>Category: <span id="order_category_name"></span></li>--}}
                {{--<li>Finsish: <span id="order_paper_name"></span></li>--}}
                {{--<!-- Paper:<li>Finsish: <span id="order_finsish_name"></span></li> -->--}}
                {{--<li class="order_lam">Quantity: <span id="order_quantity"></span></li>--}}
                {{--<li class="order_mdf">Particulars: <span id="order_particular"></span></li>--}}
                {{--<li class="order_mdf">Thikness: <span id="order_thikness"></span></li>--}}
                {{--<li class="order_mdf">Size: <span id="order_size"></span></li>--}}
                {{--<li class="order_mdf">Shade Number: <span id="order_shade_number"></span></li>--}}
                {{--<li class="order_mdf">No Of Sheets: <span id="order_no_of_sheets"></span></li>--}}
                {{--<li class="order_mdf">Grade: <span id="order_grade"></span></li>--}}
                {{--<li class="order_mdf">Remark: <span id="order_remark"></span></li>--}}
            </ul>
            <h3>Product List</h3>
            <div id="order_list">


            </div>
            <div id="final_record">
                <div class="row">
                    <div class="col-md-6" id="total_qty">0.0</div>
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-8">CGST:</div>
                            <div class="col-md-4" id="total_cgst">0.0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">SGST:</div>
                            <div class="col-md-4" id="total_sgst">0.0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">IGST:</div>
                            <div class="col-md-4" id="total_igst">0.0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">Total GST:</div>
                            <div class="col-md-4" id="total_gst">22.0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">Total Amount:</div>
                            <div class="col-md-4" id="total_amount">423.0</div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="order_eta_null" style="position: relative;">
                <form>
                    {!!Form::text('',date('d-m-Y H:i'),['class'=>'date_time_picker','id'=>'order_ETA_date_picker'])!!}
                    {!!Form::hidden('','',['id'=>"order_order_id"])!!}
                    {!!Form::submit('Submit',['class'=>'button','id'=>'order_ETA_submit','style'=>'margin-top:10px;'])!!}
                </form>
            </div>
        </div>
        <!-- POPUP CONTENT : ENDS -->


        <!-- POPUP FOOTER : STARTS -->
        <div class="popup_footer">

        </div>
        <!-- POPUP FOOTER : ENDS -->

    </div>
</div>