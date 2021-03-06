<div class="modal" data-easein="flipYIn" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="myModalLabel">Sell Gift Card</h4>
		            </div>
		            <div class="modal-body">
		                <p>Please fill in the information below</p>
		                <div class="alert alert-danger gcerror-con" style="display: none;">
		                    <button data-dismiss="alert" class="close" type="button">×</button>
		                    <span id="gcerror"></span>
		                </div>
		                <div class="form-group">
		                    <label for="gccard_no">Card No</label> *
		                    <div class="input-group">
		                        <input type="text" name="gccard_no" value="" class="form-control" id="gccard_no" />
		                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#" id="genNo"><i class="fa fa-cogs"></i></a></div>
		                    </div>
		                </div>
		                <input type="hidden" name="gcname" value="Gift Card" id="gcname" />
		                <div class="form-group">
		                    <label for="gcvalue">Value</label> *
		                    <input type="text" name="gcvalue" value="" class="form-control" id="gcvalue" />
		                </div>
		                <div class="form-group">
		                    <label for="gcprice">Price</label> *
		                    <input type="text" name="gcprice" value="" class="form-control" id="gcprice" />
		                </div>
		                <div class="form-group">
		                    <label for="gcexpiry">Expiry Date</label> <input type="text" name="gcexpiry" value="" class="form-control" id="gcexpiry" />
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		                <button type="button" id="addGiftCard" class="btn btn-primary">Sell Gift Card</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-sm">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="dsModalLabel">Discount (5 or 5%)</h4>
		            </div>
		            <div class="modal-body">
		                <input type='text' class='form-control input-sm kb-pad' id='get_ds' onClick='this.select();' value=''>
		                <label class="checkbox" for="apply_to_order">
		                <input type="radio" name="apply_to" value="order" id="apply_to_order" checked="checked" />
		                Apply to order total </label>
		                <label class="checkbox" for="apply_to_products">
		                <input type="radio" name="apply_to" value="products" id="apply_to_products" />
		                Apply to all order items </label>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
		                <button type="button" id="updateDiscount" class="btn btn-primary btn-sm">Update</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="tsModal" tabindex="-1" role="dialog" aria-labelledby="tsModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-sm">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="tsModalLabel">Tax (5 or 5%)</h4>
		            </div>
		            <div class="modal-body">
		                <input type='text' class='form-control input-sm kb-pad' id='get_ts' onClick='this.select();' value=''>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
		                <button type="button" id="updateTax" class="btn btn-primary btn-sm">Update</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-sm">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="noteModalLabel">Note</h4>
		            </div>
		            <div class="modal-body">
		                <textarea name="snote" id="snote" class="pa form-control kb-text"></textarea>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
		                <button type="button" id="update-note" class="btn btn-primary btn-sm">Update</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="proModal" tabindex="-1" role="dialog" aria-labelledby="proModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header modal-primary">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="proModalLabel">
		                    Payment 
		                </h4>
		            </div>
		            <div class="modal-body">
		                <table class="table table-bordered table-striped">
		                    <tr>
		                        <th style="width:25%;">Net Price</th>
		                        <th style="width:25%;"><span id="net_price"></span></th>
		                        <th style="width:25%;">Product Tax</th>
		                        <th style="width:25%;"><span id="pro_tax"></span> <span id="pro_tax_method"></span></th>
		                    </tr>
		                </table>
		                <input type="hidden" id="row_id" />
		                <input type="hidden" id="item_id" />
		                <div class="row">
		                    <div class="col-sm-6">
		                        <div class="form-group">
		                            <label for="nPrice">Unit Price</label> <input type="text" class="form-control input-sm kb-pad" id="nPrice" onClick="this.select();" placeholder="New Price">
		                        </div>
		                        <div class="form-group">
		                            <label for="nDiscount">Discount</label> <input type="text" class="form-control input-sm kb-pad" id="nDiscount" onClick="this.select();" placeholder="Discount">
		                        </div>
		                    </div>
		                    <div class="col-sm-6">
		                        <div class="form-group">
		                            <label for="nQuantity">Quantity</label> <input type="text" class="form-control input-sm kb-pad" id="nQuantity" onClick="this.select();" placeholder="Current Quantity">
		                        </div>
		                    </div>
		                </div>
		                <div class="row">
		                    <div class="col-sm-12">
		                        <div class="form-group">
		                            <label for="nComment">Comment</label> <textarea class="form-control kb-text" id="nComment"></textarea>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		                <button class="btn btn-success" id="editItem">Update</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="susModal" tabindex="-1" role="dialog" aria-labelledby="susModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="susModalLabel">Suspend Sale</h4>
		            </div>
		            <div class="modal-body">
		                <p>Type Reference Note</p>
		                <div class="form-group">
		                    <label for="reference_note">Reference Note</label> <input type="text" name="reference_note" value="" class="form-control kb-text" id="reference_note" />
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> Close </button>
		                <button type="button" id="suspend_sale" class="btn btn-primary">Submit</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" aria-hidden="true"></div>
		
		<div class="modal" data-easein="flipYIn" id="opModal" tabindex="-1" role="dialog" aria-labelledby="opModalLabel" aria-hidden="true"></div>

		<div class="modal" data-easein="flipYIn" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-success">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="payModalLabel">
		                    Payment 
		                </h4>
		            </div>
		            <div class="modal-body">
		                <div class="row">
		                    <div class="col-xs-9">
		                        <div class="font16">
		                            <table class="table table-bordered table-condensed" style="margin-bottom: 0;">
		                                <tbody>
		                                    <tr>
		                                        <td width="25%" style="border-right-color: #FFF !important;">Total Items</td>
		                                        <td width="25%" class="text-right"><span id="item_count">0.00</span></td>
		                                        <td width="25%" style="border-right-color: #FFF !important;">Total Payable</td>
		                                        <td width="25%" class="text-right"><span id="twt">0.00</span></td>
		                                    </tr>
		                                    <tr>
		                                        <td style="border-right-color: #FFF !important;">Total Paying</td>
		                                        <td class="text-right"><span id="total_paying">0.00</span></td>
		                                        <td style="border-right-color: #FFF !important;">Balance</td>
		                                        <td class="text-right"><span id="balance">0.00</span></td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                            <div class="clearfix"></div>
		                        </div>
		                        <div class="row">
		                            <div class="col-xs-12">
		                                <div class="form-group">
		                                    <label for="note">Note</label> <textarea name="note" id="note" class="pa form-control kb-text"></textarea>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="row">
		                            <div class="col-xs-6">
		                                <div class="form-group">
		                                    <label for="amount">Amount</label> <input name="amount" type="text" id="amount" class="pa form-control kb-pad amount" />
		                                </div>
		                            </div>
		                            <div class="col-xs-6">
		                                <div class="form-group">
		                                    <label for="paid_by">Paying by</label> 
		                                    <select id="paid_by" class="form-control paid_by select2" style="width:100%;">
		                                        <option value="cash">Cash</option>
		                                        <option value="CC">Credit Card</option>
		                                        <option value="cheque">Cheque</option>
		                                        <option value="gift_card">Gift Card</option>
		                                        <option value="stripe">Stripe</option>
		                                        <option value="other">Other</option>
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="row">
		                            <div class="col-xs-12">
		                                <div class="form-group gc" style="display: none;">
		                                    <label for="gift_card_no">Gift Card No</label> <input type="text" id="gift_card_no" class="pa form-control kb-pad gift_card_no gift_card_input" />
		                                    <div id="gc_details"></div>
		                                </div>
		                                <div class="pcc" style="display:none;">
		                                    <div class="form-group">
		                                        <input type="text" id="swipe" class="form-control swipe swipe_input" placeholder="Swipe card here then write security code manually" />
		                                    </div>
		                                    <div class="row">
		                                        <div class="col-xs-6">
		                                            <div class="form-group">
		                                                <input type="text" id="pcc_no" class="form-control kb-pad" placeholder="Credit Card No" />
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-6">
		                                            <div class="form-group">
		                                                <input type="text" id="pcc_holder" class="form-control kb-text" placeholder="Holder Name" />
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-3">
		                                            <div class="form-group">
		                                                <select id="pcc_type" class="form-control pcc_type select2" placeholder="Card Type">
		                                                    <option value="Visa">Visa</option>
		                                                    <option value="MasterCard">MasterCard</option>
		                                                    <option value="Amex">Amex</option>
		                                                    <option value="Discover">Discover</option>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-3">
		                                            <div class="form-group">
		                                                <input type="text" id="pcc_month" class="form-control kb-pad" placeholder="Month" />
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-3">
		                                            <div class="form-group">
		                                                <input type="text" id="pcc_year" class="form-control kb-pad" placeholder="Year" />
		                                            </div>
		                                        </div>
		                                        <div class="col-xs-3">
		                                            <div class="form-group">
		                                                <input type="text" id="pcc_cvv2" class="form-control kb-pad" placeholder="CVV2" />
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="pcheque" style="display:none;">
		                                    <div class="form-group"><label for="cheque_no">Cheque No</label> <input type="text" id="cheque_no" class="form-control cheque_no kb-text" /></div>
		                                </div>
		                                <div class="pcash">
		                                    <div class="form-group"><label for="payment_note">Payment Note</label> <input type="text" id="payment_note" class="form-control payment_note kb-text" /></div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-xs-3 text-center">
		                        <div class="btn-group btn-group-vertical" style="width:100%;">
		                            <button type="button" class="btn btn-info btn-block quick-cash" id="quick-payable">0.00
		                            </button>
		                            <button type="button" class="btn btn-block btn-warning quick-cash">10</button><button type="button" class="btn btn-block btn-warning quick-cash">20</button><button type="button" class="btn btn-block btn-warning quick-cash">50</button><button type="button" class="btn btn-block btn-warning quick-cash">100</button><button type="button" class="btn btn-block btn-warning quick-cash">500</button> <button type="button" class="btn btn-block btn-danger" id="clear-cash-notes">Clear</button>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> Close </button>
		                <button class="btn btn-primary" id="submit-sale">Submit</button>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="cModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header modal-primary">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
		                <h4 class="modal-title" id="cModalLabel">
		                    Add Customer 
		                </h4>
		            </div>
		            <form action="https://spos.tecdiary.com/pos/add_customer" id="customer-form" method="post" accept-charset="utf-8">
		                <input type="hidden" name="spos_token" value="dbdbfd7b3a7afeca031e32303d2de71a" />
		                <div class="modal-body">
		                    <div id="c-alert" class="alert alert-danger" style="display:none;"></div>
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="form-group">
		                                <label class="control-label" for="code">
		                                Name </label>
		                                <input type="text" name="name" value="" class="form-control input-sm kb-text" id="cname" />
		                            </div>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-xs-6">
		                            <div class="form-group">
		                                <label class="control-label" for="cemail">
		                                Email Address </label>
		                                <input type="text" name="email" value="" class="form-control input-sm kb-text" id="cemail" />
		                            </div>
		                        </div>
		                        <div class="col-xs-6">
		                            <div class="form-group">
		                                <label class="control-label" for="phone">
		                                Phone </label>
		                                <input type="text" name="phone" value="" class="form-control input-sm kb-pad" id="cphone" />
		                            </div>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-xs-6">
		                            <div class="form-group">
		                                <label class="control-label" for="cf1">
		                                Custom Field 1 </label>
		                                <input type="text" name="cf1" value="" class="form-control input-sm kb-text" id="cf1" />
		                            </div>
		                        </div>
		                        <div class="col-xs-6">
		                            <div class="form-group">
		                                <label class="control-label" for="cf2">
		                                Custom Field 2 </label>
		                                <input type="text" name="cf2" value="" class="form-control input-sm kb-text" id="cf2" />
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="modal-footer" style="margin-top:0;">
		                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> Close </button>
		                    <button type="submit" class="btn btn-primary" id="add_customer"> Add Customer </button>
		                </div>
		            </form>
		        </div>
		    </div>
		</div>

		<div class="modal" data-easein="flipYIn" id="posModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

		<div class="modal" data-easein="flipYIn" id="posModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>