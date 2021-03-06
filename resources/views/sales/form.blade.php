
		<div class="wrapper rtl rtl-inv">
		    <div class="content-wrapper" style="margin: 0;">
		        <div class="col-lg-12 alerts"></div>
		        <table style="width:100%;" class="layout-table">
		            <tr>
		                <td style="width: 460px;">
		                    <div id="pos">
		                        <form action="https://spos.tecdiary.com/pos" id="pos-sale-form" method="post" accept-charset="utf-8">
		                            <input type="hidden" name="spos_token" value="dbdbfd7b3a7afeca031e32303d2de71a" />
		                            <div class="well well-sm" id="leftdiv">
		                                <div id="lefttop" style="margin-bottom:5px;">
		                                    <div class="form-group" style="margin-bottom:5px;">
		                                        <div class="input-group">
		                                            <select name="customer_id" id="spos_customer" data-placeholder="Select Customer" required="required" class="form-control select2" style="width:100%;position:absolute;">
		                                                <option value="1" selected="selected">Walk-in Client</option>
		                                            </select>
		                                            <div class="input-group-addon no-print" style="padding: 2px 5px;">
		                                                <a href="#" id="add-customer" class="external" data-toggle="modal" data-target="#myModal"><i class="fa fa-2x fa-plus-circle" id="addIcon"></i></a>
		                                            </div>
		                                        </div>
		                                        <div style="clear:both;"></div>
		                                    </div>
		                                    <div class="form-group" style="margin-bottom:5px;">
		                                        <input type="text" name="code" id="add_item" class="form-control" placeholder="Search product by code or name, you can scan barcode too" />
		                                    </div>
		                                    <div class="form-group" style="margin-bottom:5px;">
		                                        <input type="text" name="hold_ref" value="" id="hold_ref" class="form-control kb-text" placeholder="Price">
		                                    </div>
		                                    <div class="form-group" style="margin-bottom:5px;">
		                                        <input type="text" name="hold_ref" value="" id="hold_ref" class="form-control kb-text" placeholder="Cantidad">
		                                    </div>
		                                    <div class="form-group" style="margin-bottom:5px;">
		                                        <input type="text" name="hold_ref" value="" id="hold_ref" class="form-control kb-text" placeholder="Descuento">
		                                    </div>
		                                </div>
		                                <div id="printhead" class="print">
		                                    <p>Date: 6th March 2018</p>
		                                </div>
		                                <div id="print" class="fixed-table-container">
		                                    <div id="list-table-div">
		                                        <div class="fixed-table-header">
		                                            <table class="table table-striped table-condensed table-hover list-table" style="margin:0;">
		                                                <thead>
		                                                    <tr class="success">
		                                                        <th>Product</th>
		                                                        <th style="width: 15%;text-align:center;">Price</th>
		                                                        <th style="width: 15%;text-align:center;">Qty</th>
		                                                        <th style="width: 20%;text-align:center;">Subtotal</th>
		                                                        <th style="width: 20px;" class="satu"><i class="fa fa-trash-o"></i></th>
		                                                    </tr>
		                                                </thead>
		                                            </table>
		                                        </div>
		                                        <table id="posTable" class="table table-striped table-condensed table-hover list-table" style="margin:0px;" data-height="100">
		                                            <thead>
		                                                <tr class="success">
		                                                    <th>Product</th>
		                                                    <th style="width: 15%;text-align:center;">Price</th>
		                                                    <th style="width: 15%;text-align:center;">Qty</th>
		                                                    <th style="width: 20%;text-align:center;">Subtotal</th>
		                                                    <th style="width: 20px;" class="satu"><i class="fa fa-trash-o"></i></th>
		                                                </tr>
		                                            </thead>
		                                            <tbody></tbody>
		                                        </table>
		                                    </div>
		                                    <div style="clear:both;"></div>
		                                    <div id="totaldiv">
		                                        <table id="totaltbl" class="table table-condensed totals" style="margin-bottom:10px;">
		                                            <tbody>
		                                                <tr class="info">
		                                                    <td width="25%">Total Items</td>
		                                                    <td class="text-right" style="padding-right:10px;"><span id="count">0</span></td>
		                                                    <td width="25%">Total</td>
		                                                    <td class="text-right" colspan="2"><span id="total">0</span></td>
		                                                </tr>
		                                                <tr class="info">
		                                                    <td width="25%"><a href="#" id="add_discount">Discount</a></td>
		                                                    <td class="text-right" style="padding-right:10px;"><span id="ds_con">0</span></td>
		                                                    <td width="25%"><a href="#" id="add_tax">Order Tax</a></td>
		                                                    <td class="text-right"><span id="ts_con">0</span></td>
		                                                </tr>
		                                                <tr class="success">
		                                                    <td colspan="2" style="font-weight:bold;">
		                                                        Total Payable <a role="button" data-toggle="modal" data-target="#noteModal">
		                                                        <i class="fa fa-comment"></i>
		                                                        </a>
		                                                    </td>
		                                                    <td class="text-right" colspan="2" style="font-weight:bold;"><span id="total-payable">0</span></td>
		                                                </tr>
		                                            </tbody>
		                                        </table>
		                                    </div>
		                                </div>
		                                <div id="botbuttons" class="col-xs-12 text-center">
		                                    <div class="row">
		                                        <div class="col-xs-4" style="padding: 0;">
		                                            <div class="btn-group-vertical btn-block">
		                                                <button type="button" class="btn btn-warning btn-block btn-flat" id="suspend">Hold</button>
		                                                <button type="button" class="btn btn-danger btn-block btn-flat" id="reset">Cancel</button>
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-4" style="padding: 0 5px;">
		                                            <div class="btn-group-vertical btn-block">
		                                                <button type="button" class="btn bg-purple btn-block btn-flat" id="print_order">Print Order</button>
		                                                <button type="button" class="btn bg-navy btn-block btn-flat" id="print_bill">Print Bill</button>
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-4" style="padding: 0;">
		                                            <button type="button" class="btn btn-success btn-block btn-flat" id="payment" style="height:67px;">Payment</button>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="clearfix"></div>
		                                <span id="hidesuspend"></span>
		                                <input type="hidden" name="spos_note" value="" id="spos_note">
		                                <div id="payment-con">
		                                    <input type="hidden" name="amount" id="amount_val" value="" />
		                                    <input type="hidden" name="balance_amount" id="balance_val" value="" />
		                                    <input type="hidden" name="paid_by" id="paid_by_val" value="cash" />
		                                    <input type="hidden" name="cc_no" id="cc_no_val" value="" />
		                                    <input type="hidden" name="paying_gift_card_no" id="paying_gift_card_no_val" value="" />
		                                    <input type="hidden" name="cc_holder" id="cc_holder_val" value="" />
		                                    <input type="hidden" name="cheque_no" id="cheque_no_val" value="" />
		                                    <input type="hidden" name="cc_month" id="cc_month_val" value="" />
		                                    <input type="hidden" name="cc_year" id="cc_year_val" value="" />
		                                    <input type="hidden" name="cc_type" id="cc_type_val" value="" />
		                                    <input type="hidden" name="cc_cvv2" id="cc_cvv2_val" value="" />
		                                    <input type="hidden" name="balance" id="balance_val" value="" />
		                                    <input type="hidden" name="payment_note" id="payment_note_val" value="" />
		                                </div>
		                                <input type="hidden" name="customer" id="customer" value="1" />
		                                <input type="hidden" name="order_tax" id="tax_val" value="" />
		                                <input type="hidden" name="order_discount" id="discount_val" value="" />
		                                <input type="hidden" name="count" id="total_item" value="" />
		                                <input type="hidden" name="did" id="is_delete" value="0" />
		                                <input type="hidden" name="eid" id="is_delete" value="0" />
		                                <input type="hidden" name="total_items" id="total_items" value="0" />
		                                <input type="hidden" name="total_quantity" id="total_quantity" value="0" />
		                                <input type="submit" id="submit" value="Submit Sale" style="display: none;" />
		                            </div>
		                        </form>
		                    </div>
		                </td>
		                <td></td>
		            </tr>
		        </table>
		    </div>
		</div>

		