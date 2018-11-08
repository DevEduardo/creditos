<script data-cfasync="false" src="/cdn-cgi/scripts/d07b1474/cloudflare-static/email-decode.min.js"></script>

<script type="text/javascript">
    var base_url = 'https://spos.tecdiary.com/', assets = 'https://spos.tecdiary.com/themes/default/assets/';
    var dateformat = 'jS F Y', timeformat = 'h:i A';
        var Settings = {"logo":"logo1.png","site_name":"SimplePOS","tel":"0105292122","dateformat":"jS F Y","timeformat":"h:i A","language":"english","theme":"default","mmode":"0","captcha":"0","currency_prefix":"USD","default_customer":"1","default_tax_rate":"5%","rows_per_page":"10","total_rows":"30","header":null,"footer":null,"bsty":"3","display_kb":"0","default_category":"1","default_discount":"0","item_addition":"1","barcode_symbology":null,"pro_limit":"10","decimals":"2","thousands_sep":",","decimals_sep":".","focus_add_item":"ALT+F1","add_customer":"ALT+F2","toggle_category_slider":"ALT+F10","cancel_sale":"ALT+F5","suspend_sale":"ALT+F6","print_order":"ALT+F11","print_bill":"ALT+F12","finalize_sale":"ALT+F8","today_sale":"Ctrl+F1","open_hold_bills":"Ctrl+F2","close_register":"ALT+F7","java_applet":"0","receipt_printer":"","pos_printers":"","cash_drawer_codes":"","char_per_line":"42","rounding":"1","pin_code":"abdbeb4d8dbe30df8430a8394b7218ef","purchase_code":null,"envato_username":null,"theme_style":"blue-light","after_sale_page":"1","overselling":"1","multi_store":"1","qty_decimals":"2","symbol":"","sac":"0","display_symbol":"0","remote_printing":"1","printer":null,"order_printers":"null","auto_print":"0","local_printers":"0","rtl":"0","print_img":"0","selected_language":"english"};
    var sid = false, username = 'admin', spositems = {};
    $(window).load(function () {
        $('#mm_pos').addClass('active');
        $('#pos_index').addClass('active');
    });
    var pro_limit = 10, java_applet = 0, count = 1, total = 0, an = 1, p_page = 0, page = 0, cat_id = 1, tcp = 2;
    var gtotal = 0, order_discount = 0, order_tax = 0, protect_delete = 0;
    var order_data = {}, bill_data = {};
    var csrf_hash = 'dbdbfd7b3a7afeca031e32303d2de71a';
        var lang = new Array();
    lang['code_error'] = 'Code Error';
    lang['r_u_sure'] = '<strong>Are you sure?</strong>';
    lang['please_add_product'] = 'Please add product';
    lang['paid_less_than_amount'] = 'Paid amount is less than paying';
    lang['x_suspend'] = 'Sale can not be suspended';
    lang['discount_title'] = 'Discount (5 or 5%)';
    lang['update'] = 'Update';
    lang['tax_title'] = 'Tax (5 or 5%)';
    lang['leave_alert'] = 'You will loss the data, are you sure?';
    lang['close'] = 'Close';
    lang['delete'] = 'Delete';
    lang['no_match_found'] = 'No match found';
    lang['wrong_pin'] = 'Wrong Pin';
    lang['file_required_fields'] = 'Please fill required fields';
    lang['enter_pin_code'] = 'Enter Pin code';
    lang['incorrect_gift_card'] = 'Gift card number is wrong or card is already used.';
    lang['card_no'] = 'Card No';
    lang['value'] = 'Value';
    lang['balance'] = 'Balance';
    lang['unexpected_value'] = 'Unexpected Value Provided!';
    lang['inclusive'] = 'Inclusive';
    lang['exclusive'] = 'Exclusive';
    lang['total'] = 'Total';
    lang['total_items'] = 'Total Items';
    lang['order_tax'] = 'Order Tax';
    lang['order_discount'] = 'Order Discount';
    lang['total_payable'] = 'Total Payable';
    lang['rounding'] = 'Rounding';
    lang['grand_total'] = 'Grand Total';
    lang['register_open_alert'] = 'Register is open, are you sure to sign out?';
    lang['discount'] = 'Discount';
    lang['order'] = 'Order';
    lang['bill'] = 'Bill';
    lang['merchant_copy'] = 'Merchant Copy';
    
    $(document).ready(function() {
        
            if (get('rmspos')) {
                if (get('spositems')) { remove('spositems'); }
                if (get('spos_discount')) { remove('spos_discount'); }
                if (get('spos_tax')) { remove('spos_tax'); }
                if (get('spos_note')) { remove('spos_note'); }
                if (get('spos_customer')) { remove('spos_customer'); }
                if (get('amount')) { remove('amount'); }
                remove('rmspos');
            }
                                    if (! get('spos_discount')) {
                            store('spos_discount', '0');
                            $('#discount_val').val('0');
                        }
                        if (! get('spos_tax')) {
                            store('spos_tax', '5%');
                            $('#tax_val').val('5%');
                        }
                        
                        if (ots = get('spos_tax')) {
                            $('#tax_val').val(ots);
                        }
                        if (ods = get('spos_discount')) {
                            $('#discount_val').val(ods);
                        }
                        bootbox.addLocale('bl',{OK:'OK',CANCEL:'No',CONFIRM:'Yes'});
                        bootbox.setDefaults({closeButton:false,locale:"bl"});
                                                });
                    
</script>

<script type="text/javascript">
    var socket = null;
                            function printBill(bill) {
        if (Settings.remote_printing == 1) {
            Popup($('#bill_tbl').html());
        } else if (Settings.remote_printing == 2) {
            if (socket.readyState == 1) {
                var socket_data = {'printer': false, 'logo': '{{ asset('enlinea/logo.png') }}', 'text': bill};
                socket.send(JSON.stringify({
                    type: 'print-receipt',
                    data: socket_data
                }));
                return false;
            } else {
                bootbox.alert('Unable to connect to socket, please make sure that server is up and running fine.');
                return false;
            }
        }
    }
    var order_printers = [];
    function printOrder(order) {
        if (Settings.remote_printing == 1) {
            Popup($('#order_tbl').html());
        } else if (Settings.remote_printing == 2) {
            if (socket.readyState == 1) {
                if (order_printers == '') {
    
                    var socket_data = { 'printer': false, 'order': true,
                    'logo': '{{ asset('enliena/logo.png') }}',
                    'text': order };
                    socket.send(JSON.stringify({type: 'print-receipt', data: socket_data}));
    
                } else {
    
                    $.each(order_printers, function() {
                        var socket_data = {'printer': this, 'logo': '{{ asset('enliena/logo.png') }}', 'text': order};
                        socket.send(JSON.stringify({type: 'print-receipt', data: socket_data}));
                    });
    
                }
                return false;
            } else {
                bootbox.alert('Unable to connect to socket, please make sure that server is up and running fine.');
                return false;
            }
        }
    }
    
    function Popup(data) {
        var mywindow = window.open('', 'spos_print', 'height=500,width=300');
        mywindow.document.write('<html><head><title>Print</title>');
        mywindow.document.write('<link rel="stylesheet" href="{{ asset('enlinea/bootstrap.min.css') }}" type="text/css" />');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    }
</script>

<script src="{{ asset('enlinea/libraries.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('enlinea/scripts.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('enlinea/pos.min.js') }}" type="text/javascript"></script>