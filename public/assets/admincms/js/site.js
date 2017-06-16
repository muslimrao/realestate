// JavaScript Document
(function($) {

  	jQuery.fn.extend ({
	
		wordCountLimit: function(options) {
	
			var defaults = {
				maxlength : '250',
				divClassName: ""
			};
	
			var o = $.extend(defaults, options);
			$( "." + o.divClassName ).html( o.maxlength );
			
			
			var _elem_this		= this;
			this.on('keyup', function(event) {
				
				n 			= _elem_this.val().length;
				n			= o.maxlength - n;
				$(  "." + o.divClassName  ).html(n);
		
			});
			
			this.trigger("keyup");
		}
		
	});
	
	
	

})(jQuery);




// Date: 030916
function ajax_request_consignment_pickup( )
{
	var _checked_elems		= $("input[type='checkbox']:checked").not(  $("input[name='select_all']") );
	
	if ( _checked_elems.length > 0 )
	{
			//_runtimePopup( 'modalUrl_80perc', url )
			
			_waiting_screen( "show" );
			
			var _ids				= Array();
			_checked_elems.each(function(){
				_ids.push( $(this).val() );
			});
	
			var this_site			= "managevendorsproducts/controls/ajax_request_consignment_pickup";
			var url 				= base_url + this_site;
			var pars 				= '';
			var target 				= '.targetBox';	
			
			$.ajax({
				type: "POST",
				url: url,
				data: {product_ids: _ids, url: this_site },
				success: function(response) {
					
					
					submit_action( response, target );
					
				},
				error: function( err )
				{
					_waiting_screen("hide");
					_show_alert( '', 'error', err.statusText );
				}
		
			});
	}
	else
	{
		_show_alert( 'red', 'Invalid Product Selection.', 'Please select Product(s)');
	}
	
	
	
	
	
}


function ajax_approve_reject_delivery_receipt_products( _change_status_to )
{
	
	var _checked_elems		= $("input[type='checkbox']:checked").not(  $("input[name='select_all']") );
	
	if ( _checked_elems.length > 0 )
	{
			//_runtimePopup( 'modalUrl_80perc', url )
			
			_waiting_screen( "show" );
			
			var _ids				= Array();
			_checked_elems.each(function(){
				_ids.push( $(this).val() );
			});
	
			var this_site			= "manageinventory/controls/ajax_approve_reject_delivery_receipt_products"; //ajax_approve_reject_delivery_receipt_products
			var url 				= base_url + this_site;
			var pars 				= '';
			var target 				= '.targetBox';	
			
			$.ajax({
				type: "POST",
				url: url,
				data: {sellercenter_status: $("select[name='sellercenter_status']").val() ,delivery_product_ids: _ids, change_status_to: _change_status_to, url: this_site },
				success: function(response) {
					
					
					submit_action( response, target );
					
				},
				error: function( err )
				{
					_waiting_screen("hide");
					_show_alert( '', 'error', err.statusText );
				}
		
			});
	}
	else
	{
		_show_alert( 'red', 'Invalid Delivery Receipt (Product) Selection.', 'Please select Delivery Receipt Product(s)');
	}
	
	
	
	
	

}

function ajax_delivery_receipt_form( )
{
	var _checked_elems		= $("input[type='checkbox']:checked").not(  $("input[name='select_all']") );
	
	if ( _checked_elems.length > 0 )
	{
		//_runtimePopup( 'modalUrl_80perc', url )
		
		_waiting_screen( "show" );
		
		var _ids				= Array();
		_checked_elems.each(function(){
			_ids.push( $(this).val() );
		});

		var this_site			= "managepurchaseorders/controls/ajax_delivery_receipt_form";
		var url 				= base_url + this_site;
		var pars 				= '';
		var target 				= '.targetBox';	
		
		$.ajax({
			type: "POST",
			url: url,
			data: {purchase_order_ids: _ids, url: this_site },
			success: function(response) {
				
				
				submit_action( response, target );
				
			},
			error: function( err )
			{
				_waiting_screen("hide");
				_show_alert( '', 'error', err.statusText );
			}
	
		});
	}
	else
	{
		_show_alert( 'red', 'Invalid Purchase Order Selection.', 'Please select Purchase Order(s)');
	}
	
	
	
	
	
}

	
function ajax_create_purchase_order_form( )
{
	var _checked_elems		= $("input[type='checkbox']:checked").not(  $("input[name='select_all']") );
	
	if ( _checked_elems.length > 0 )
	{
			//_runtimePopup( 'modalUrl_80perc', url )
			
			_waiting_screen( "show" );
			
			var _ids				= Array();
			_checked_elems.each(function(){
				_ids.push( $(this).val() );
			});
			
			var _category_ids					= $(".load_category_treeview").jstree(true).get_selected();
			
			
			var _table_listed_product_ids		= Array();
			if ($("textarea[name='table_listed_product_ids']").length > 0 )
			{
				var _table_listed_product_ids		= $("textarea[name='table_listed_product_ids']").val().split(",");
			}
			
			
			var this_site			= "managepurchaseorders/controls/ajax_create_purchase_order_form_VALIDATE";
			var url 				= base_url + this_site;
			var pars 				= '';
			var target 				= '.ajax_PurchaseOrderForm';	
			
			$.ajax({
				type: "POST",
				url: url,
				data: {product_ids: _ids, category_ids: _category_ids, table_listed_product_ids: _table_listed_product_ids, url: this_site },
				success: function(response) {
					
					
					submit_action( response, target );
					
				},
				error: function( err )
				{
					_waiting_screen("hide");
					_show_alert( '', 'error', err.statusText );
				}
		
			});
	}
	else
	{
		_show_alert( 'red', 'Invalid Product(s) Selection.', 'Please select Product(s)');
	}
	
	
	
	
	
}

function ajax_load_products_by_vendor( elem )
{
	_waiting_screen( "show" );
	
	var this_site			= "Ajaxmethods/ajax_getProducts_byVendors";
	var url 				= base_url + this_site;
	var pars 				= '';
	var target 				= '.ajax_DataTable';	
	
	$.ajax({
		type: "POST",
		url: url,
		data: {vendor_id: elem.val(), url: this_site },
		success: function(response) {
			
			
			//console.log(response);
			submit_action( response, target );
			
		},
		error: function( err )
		{
			_waiting_screen("hide");
			_show_alert( '', 'error', err.statusText );
		}
	
	});
	
}

function ajax_getVendorProducts_ByVendorCategories( _directory, vendor_ids, category_ids )
{
	_waiting_screen("show");
	
	
	var this_site			= "Ajaxmethods/ajax_getVendorProducts_ByVendorCategories/1/" + vendor_ids + "/" + category_ids;
	var url 				= base_url + this_site;
	var pars 				= '';
	var target 				= '.ajax_ProductList';	
	
	
	$.ajax({
		type: "POST",
		url: url,
		data: "_directory=" + _directory,
		cache: false,
		success: function(response)
		{
			
			submit_action( response, target );			
		},
		error: function( err )
		{
			_waiting_screen("hide");
			_show_alert( '', 'error', err.statusText );
		}
	});
	
}

function ajax_render_warehouse_location( elem, mode, target, clear_select )
{
	parent._waiting_screen("show");
	
	$(clear_select).each (function(){
		$(this).find("select option:gt(0)").remove();
	});
	

	var this_site			= "Ajaxmethods/ajax_render_warehouse_location/1/" + mode;
	var url 				= base_url + this_site;
	var pars 				= '';
	//var target 				= '.ajax_DataTable';	
	
	var drp_id		= elem.closest("table").attr("data-drproductid");
	
	$.ajax({
		type: "POST",
		url: url,
		data: {drp_id: drp_id ,value: elem.val(), url: this_site },
		success: function(response) {
			
			//console.log(response);
			//console.log(target);
			
			//console.log(response);
			submit_action( response, target );
					
			
		},
		error: function( err )
		{
			parent._waiting_screen("hide");
			_show_alert( '', 'error', err.statusText );
		}
	
	});
}

function dataTableSearchOnEnterKey( mode, id_name, oTable )
{
	if ( oTable == null || oTable == "undefined" )
	{
		oTable 			= false;	
	}
	
	
	if ( mode == "serverside" )
	{
		if ( id_name == null || id_name == "undefined" )
		{
			id_name			= "tbl_records_serverside";
		}
		
		$('#'+ id_name +'_filter input').unbind();
		$('#'+ id_name +'_filter input').bind('keyup', function(e) {
					
			var table = $('#' + id_name).DataTable();
			if(e.keyCode == 13) 
			{
				
				table.search(this.value).draw();
			}
		});      
	}
	else
	{
		if ( id_name == null || id_name == "undefined" )
		{
			id_name			= "tbl_records";
		}
		
		
		$('#'+ id_name +'_filter input').unbind();
		$('#'+ id_name +'_filter input').bind('keyup', function(e) {
						
			
			
			if(e.keyCode == 13) 
			{
				oTable.fnFilter(this.value);   
			}
		});      	
	}
}

function escapeRegexDataTable( val )
{
	var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
	val.replace( _re_escape_regex, '\\$1' );	
	
	return val;
}

function disableSubmitForm_onDataTableSearch( elem )
{
	var _flag			= false;
	
	if ( elem == null || elem == "undefined" )
	{
		elem = false;	
	}
	
	if (  $("#tbl_records_serverside").length > 0 || $("#tbl_records").length > 0 )
	{
		_flag			= true;	
	}
	
	if ( elem )
	{
		if ( elem.length > 0 )
		{
			_flag		= true;
		}
	}
	
	
	
	if ( _flag )
	{
		//when press enter don't submit form - 
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});	
	}
}

function render_numericonly()
{
	$(".numericonly").keydown(function (e) {
											
			evt = e || window.event;
			if (!evt.ctrlKey && !evt.metaKey && !evt.altKey) {
				var charCode = (typeof evt.which == "undefined") ? evt.keyCode : evt.which;
				
				if (charCode && !/\d/.test(String.fromCharCode(charCode))) {
					
					
					
										// Allow: backspace, delete, tab, escape, enter and .
										if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
											 // Allow: Ctrl+A
											(e.keyCode == 65 && e.ctrlKey === true) || 
											 // Allow: home, end, left, right
											(e.keyCode >= 35 && e.keyCode <= 39)) {
												 // let it happen, don't do anything
												 return;
										}
										// Ensure that it is a number and stop the keypress
										if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
											e.preventDefault();
										}
					
					
					
				}
			}
				
				
			
		});	
}



function startEndDatePicker( start, end )
{
	if ( start == null || start == "undefined" )
	{
		start			= $("input[data-datemode='start']");	
	}
	
	if ( end == null || end == "undefined" )
	{
		end				= $("input[data-datemode='end']");	
	}
	
	
	if ( start.length > 0 && end.length > 0 )
	{
		start.datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				
				end.datepicker( "option", "minDate", selectedDate );
			}
		});
		
		
		end.datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				start.datepicker( "option", "maxDate", selectedDate );
			}
		});
	}
}



function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function _show_alert( _theme, _title, _content, _event, _callback )
{
	if ( _event == null )
	{
		_event				= "";	
	}
	
	if ( _callback  == null )
	{
		_callback			= function(){}	
	}
	
	
	if ( _theme == "danger" )
	{
		_theme				= "red";	
	}
	
	if ( _theme == "" )
	{
		if ( _title == "error" )
		{
			_theme			= "red";
		}
		else if ( _title == "success" )
		{
			_theme			= "blue";
		}
	}
	
	if ( _theme == "" )
	{
		_theme				= "gray";
	}
	
	
	if ( _theme == "error" )
	{
		_theme			= "red";	
	}
	else if ( _theme == "success" )
	{
		_theme			= "blue";	
	}
	
	
	_title		= ucwords( _title );
	
	
	
	var _callback_CLOSE			= function(){};
	var _callback_OPEN			= function(){};
	var _callback_AJAXFAIL		= function(){};
	
	try
	{
		eval("var _callback = " + _callback);
	}
	catch (e)
	{
		_callback				= function(){};	
	}
	
	
	
	if ( _event == "close" )
	{
		_callback_CLOSE			= _callback;
	}
	
	else if ( _event == "open" )
	{
		_callback_OPEN			= _callback;
	}
	
	else if ( _event == "ajaxfail" )
	{
		_callback_AJAXFAIL			= _callback;
	}
	
	
	$.jAlert({
		'title': _title,
		'content': _content,
		'theme': _theme,
		'showAnimation': 'bounceIn',
		'hideAnimation': 'fadeOut',
		'closeOnClick': true,
		'onClose': _callback_CLOSE,
		'onOpen': _callback_OPEN,
		'onAjaxFail': _callback_AJAXFAIL,
		
	});		
}

function loop_lagao( edit_id_array )
{
	if ( edit_id_array.length == 5 )
	{
		$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[0], function(e, data) 
		{
		  $('.load_category_treeview').jstree('open_node', '#' + edit_id_array[1], function(e, data){
		   
					$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[2], function(e, data){
					
						$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[3], function(e, data){
					
					
						//set_commissions_value_ONLOAD( edit_id_array[4] );
						
						$('.load_category_treeview').jstree('select_node', '#' + edit_id_array[4]) ;
						
					
					}, true);
					
				
				}, true);
		   
		  }, true);
		  
		}, true);

	}
	else if ( edit_id_array.length == 4 )
	{
		$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[0], function(e, data) 
		{
		  $('.load_category_treeview').jstree('open_node', '#' + edit_id_array[1], function(e, data){
		   
				$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[2], function(e, data){
					
					
					//set_commissions_value_ONLOAD( edit_id_array[3] );
					
					$('.load_category_treeview').jstree('select_node', '#' + edit_id_array[3]) ;
					
				
				}, true);
		   
		  }, true);
		  
		}, true);

	}
	else if ( edit_id_array.length == 3 )
	{
		
		
		$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[0], function(e, data) 
		{
			$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[1], function(e, data){
				
				//set_commissions_value_ONLOAD( edit_id_array[2] );
				
				$('.load_category_treeview').jstree('select_node', '#' + edit_id_array[2] ) ;
				
				
			
			}, true);
		
		}, true);
	}
	else if ( edit_id_array.length == 2 )
	{
		$('.load_category_treeview').jstree('open_node', '#' + edit_id_array[0], function(e, data) 
		{
			
			//set_commissions_value_ONLOAD( edit_id_array[1] );
		   $('.load_category_treeview').jstree('select_node', '#' + edit_id_array[1]) ;
		 
		  
		}, true);

	}
	else if ( edit_id_array.length == 1 )
	{
		
		//set_commissions_value_ONLOAD( edit_id_array[0] );
		$('.load_category_treeview').jstree('select_node', '#' + edit_id_array[0]) ;
	}	
}

function set_commissions_value_KEYPRESS()
{
	var _categories_id				= $("input[name='categories_id']").val().split(",");
	var _value						= new Array();

	if ($("input[name='categories_id']").val() != "" )
	{
		for ( var x = 0; x < _categories_id.length; x++ )
		{
			var _comm_value			 = $("#" +  _categories_id[x] + "_custom_textbox");
				
			
			
			//_value					= _categories_id[x] + "," + _comm_value.val() + "|";
			
			_value.push(  _categories_id[x] + "," + _comm_value.val() );
		}
		
		_value						= _value.join("|");
	}
	else
	{
		
		_value						= "";
	}
	console.log(_value);
	
	$("input[name='category_commission']").val( _value  );
}
function set_commissions_value_ONLOAD( cat_id )
{
	if ( $("input[name='category_commission']").attr("data-pageloadvalues") )
	{
		if (  $("input[name='category_commission']").attr("data-pageloadvalues") != "" )
		{
			
			var _get_loaded_comm_values		=  $("input[name='category_commission']").attr("data-pageloadvalues").split("|");
			console.log("-0---");
			console.log(_get_loaded_comm_values);
			var _values						= "";
			for ( var x = 0; x < _get_loaded_comm_values.length; x++ )
			{
				var _get_single_value		= _get_loaded_comm_values[x].split(",");
				
				//data-pageloadvalues
				//2,511|56,45|55,20|
				
				$("#" + _get_single_value[0] + "_custom_textbox").val( _get_single_value[1] );	
				
				
			}	
		}
	}
}




function load_treeview( _elem, _get_url, _move_url, _send_id_to_this_elem, edit_id_array, is_multiple, show_textbox, is_move, direct_open_node_on_load )
{	
	
	var _is_DRAW			= true;
	
	if (is_move == null || is_move == "undefined" )
	{
		is_move				= false;	
	}
	
	if ( direct_open_node_on_load == null || direct_open_node_on_load == "undefined" )
	{
		direct_open_node_on_load		= false;	
	}
	
	
	
	if ( _elem.attr("data-drawtreeview") )
	{
		if ( _elem.attr("data-drawtreeview") == "0" )
		{
			_is_DRAW		= false;
		}
	}
	
	if ( !_is_DRAW )
	{
		return false;
	}
	
	
	try
	{
		_elem.jstree('destroy');
	}
	catch (e)
	{
		
	}
	
	/*******************************************/


	if ( is_multiple == null || is_multiple == undefined )
	{
		is_multiple			= false;
	}
	
	if ( show_textbox == null || show_textbox == undefined )
	{
		show_textbox		= false;
	}
	
	var _PLUGINS			= ["wholerow", "checkbox",  "types"];
	if ( show_textbox )
	{
		_PLUGINS.push("inp");
	}
	
	if ( is_move )
	{
		_PLUGINS.push("dnd");
	}
	
	//["dnd", "wholerow", "checkbox",  "types", "inp"]
	
	
	
	
	_waiting_screen("show");
	
	
	
	var inp = document.createElement('INPUT');
	inp.className = "jstree-inp cat_comm";
	inp.style.width = '40px';
	inp.setAttribute('type','text');
	inp.setAttribute('value', 'ABC');
	
    $.jstree.plugins.inp = function (options, parent) {

        this.bind = function () {
            parent.bind.call(this);
			/*
			this.element.on('changed.jstree', function (e, data) {
				
				//console.log('==============');
				//console.log(e);
				//console.log(data);
			})
	*/
			
          
		  	 this.element.on("keypress.jstree", ".jstree-inp", $.proxy(function (e) {
                    // do something with $(e.target).val()
						
						//console.log('-x--x-x-x-x-x');
						//console.log(e);
						//console.log( $(e) );
						//console.log( $(this) );
						
						
					$(".category_commission").val(  );
						
            }, this));
			
			
        };
        this.teardown = function () {alert("2");
            if(this.settings.questionmark) {
                this.element.find(".jstree-inp").remove();
            }
            parent.teardown.call(this);
        };
        this.redraw_node = function(obj, deep, callback) {
			
			
            obj = parent.redraw_node.call(this, obj, deep, callback);
			
			
			
			
            if(obj) {
			
				var this_category_id			= $(obj).attr("id");
                var tmp = inp.cloneNode(true);
				tmp.setAttribute('id',this_category_id + "_custom_textbox");

				
				//show_textbox - set input name + set default commission rate + set onkeyup function (everytime when any key pressed it will call KEYPRESS
				if ( show_textbox )
				{
					if ( controller == "managevendorcategoriescommissions/" )
					{
						$(tmp).attr("name", "category_commission["+ $(obj).attr("id") +"]");
						var _Cat_Comm = $(obj).find("#" + $(obj).attr("id") + "_default_commission");
						tmp.setAttribute('value', _Cat_Comm.val());
						
						tmp.onkeyup = function(e){
							set_commissions_value_KEYPRESS();
						};
					}
				}


			
				//$(obj).prepend(tmp);
				
                obj.insertBefore(tmp, obj.childNodes[1]);
				
				
            }
            return obj;
        };
    };
	
	// By ahmed
	var vendor_id 			= false;
	if( controller == "managevendorsproducts/" && $('input[name="vendor_id"]').length > 0 )
	{
		vendor_id			= $('input[name="vendor_id"]').val();
	}
	/*
	vendor cats v_cats
	else if( controller == "managebaseproducts/" && $('input[name="vendor_id"]').length > 0 )
	{
		vendor_id			= $('input[name="vendor_id"]').val();
	}
	*/
	else if( controller == "managepurchaseorders/"  )
	{
		vendor_id			= $('select[name="vendor_id"]').val();
		if ( vendor_id == "" )
		{
			vendor_id		= 0;	
		}
	}
	else if( controller == "managereportsales/"  )
	{
		vendor_id			=  $("select[name='vendor_id[]']").val();
		if ( vendor_id == "" )
		{
			vendor_id		= 0;	
		}
	}
	else if ( controller == "managebaseproducts/" && _global_VENDOR_ID )
	{
		vendor_id			= _global_VENDOR_ID;
	}
	
	_elem.jstree({
		"core" : {
			"multiple" : is_multiple,
			"animated" : true,
			
			"check_callback": true,


			
			'themes' : {
				'name': 'default',
				'responsive' : true,
				'stripes' : true
			},
				
			'data' : {
				'url' : function (node)  {
					return _get_url;
				},
				
				'data' : function (node) {
					
					return { 'id' : node.id , 'vendor_id': vendor_id };
				},
				"dataType" : "json",
				error: function(e,b,d){
				console.log(e);
					_show_alert( 'red', e.status, e.statusText);
					_waiting_screen( "hide" );
				}
			}
		},
		
		'checkbox': {
			three_state: false,
			whole_node : true,  // to avoid checking the box just clicking the node 
			
		},
		


		
		"types" : {
 
			"active" : {
				"icon" : "fa fa-plus fa-1 text-green"
			},
			"not-active" : {
				"icon" : "fa fa-times fa-1 text-danger"
			}
		},
		
		"plugins" : _PLUGINS
	})
	
	.on("select_node.jstree", function (e, data, event) {

		//console.log("select_node");
		//console.log(e, data);
		
		try
		{
			_send_id_to_this_elem.val( data.selected.join(",") );
		}
		catch (e)
		{
			
		}
		
		
		
		//show_textbox - when select node, check if data-pageloadvalues  have values or not. if Yes than call ONLOAD function else KEYPRESS
		if ( show_textbox )
		{
			if ( ! is_multiple )
			{
				$("li.jstree-node > .jstree-inp.cat_comm").hide();	
			}
			
			$("li#" + data.node.id + ".jstree-node > .jstree-inp.cat_comm").show();
			
			if ( controller == "managevendorcategoriescommissions/" )
			{
				if ( !is_post )
				{
				
					if (  $("input[name='category_commission']").attr("data-pageloadvalues") == "" || !$("input[name='category_commission']").attr("data-pageloadvalues"))
					{	
						
						console.log("NA");
						set_commissions_value_KEYPRESS();
					}
					
					
					set_commissions_value_ONLOAD( data.node.id );
				}
				else if (  $("input[name='category_commission']").attr("data-pageloadvalues") == "" )
				{
					set_commissions_value_KEYPRESS();
				}
				else
				{
					set_commissions_value_ONLOAD( data.node.id );	
				}
				//console.log(data.node.id);
				
			}
		}
		
	})
	.on("deselect_node.jstree", function (e, data, event) {

		console.log("UN-selected");
		console.log(e, data);
		
		try
		{
			_send_id_to_this_elem.val( data.selected.join(",") );
		}
		catch (e)
		{
			
		}
		
		
		//show_textbox - when de-select it will reset the commission textbox with selected checkbox values.
		if ( show_textbox )
		{
			$("li#" + data.node.id + ".jstree-node > .jstree-inp.cat_comm").hide();
			
			if ( controller == "managevendorcategoriescommissions/" )
			{
				set_commissions_value_KEYPRESS();
			}
		}
	})
	.on("open_node.jstree", function (e, data, event) {
		
		//console.log("open_node--------------------------");
		//console.log(data.node.state.selected);
		//console.log(e, data, event);
		
		if ( show_textbox )
		{
			if ( controller == "managevendorcategoriescommissions/" )
			{
				//show_textbox - when open node, jstree refreshed the custom_textbox. so have taken a category_commission value to refill custom_textbox when open-node
				var _get_loaded_comm_values		= $("input[name='category_commission']").val().split("|");
				for ( var x = 0; x < _get_loaded_comm_values.length; x++ )
				{
					var _get_single_value		= _get_loaded_comm_values[x].split(",");
					if ( data.node.id == _get_single_value[0] )
					{
						$("#" + data.node.id + "_custom_textbox").val( _get_single_value[1] );
					}
				}
				
			
				//when pageload it will refill the custom_textbox again n again till all nodes are open.
				set_commissions_value_ONLOAD( data.node.id );
			}
		}
		
	})
	.on("after_open.jstree", function (e, data, event) {
		
		//console.log("after_open");
		//console.log( data.node.text );
		if (data.node.state.selected)
		{
			$("li#" + data.node.id + ".jstree-node > .jstree-inp.cat_comm").show();
		}
		//console.log(e, data, event);
		
	})
	.on("open_node.jstree", function (e, data, event) {
		
		//console.log("open_node");
		if (data.node.state.selected)
		{
			$("li#" + data.node.id + ".jstree-node > .jstree-inp.cat_comm").show();
		}
		//console.log(e, data, event);
		
	})
	.on("move_node.jstree", function (e, data) {
	
	
		
		
		_waiting_screen("show");
		
		
		
		/*
		//item being moved                      
		var moveitemID = $('#' + data.node.id).find('a')[0].id;            
		
		//console.log(moveitemID);
		
		//new parent
		var newParentID = $('#' + data.parent).find('a')[0].id;
		//console.log(newParentID);
		//old parent
		var oldParentID = $('#' + data.old_parent).find('a')[0].id;
		//console.log(oldParentID);
		//position index point in group
		//old position
		var oldPostionIndex = data.old_position;
		//console.log(oldPostionIndex);
		*/
		//new position
		var newPostionIndex = data.position - 1;
		
	
		
		$.get(_move_url, { 'id' : data.node.id, 'parent' : data.parent, 'position' : newPostionIndex })
		.done(function (d) {
			
			_show_alert( '', d._messageBundle._CSS_show_messages, d._messageBundle._TEXT_show_messages );
			
			_waiting_screen("hide");
			
			//data.instance.load_node(data.parent);
			data.instance.refresh();
		})
		.fail(function () {
			
			_show_alert( '', 'error', "Failed to Update" );
			
				
			_waiting_screen("hide");
				
			//alert("fa");
			data.instance.refresh();
		});
							
	})
	.on('changed.jstree', function (e, data) {		
		
		
		
		/*
		try
		{
			if ( data.action == "select_node" )
			{
				$("li#" + data.node.id + ".jstree-node").prepend('<input class="cat_comm" name="category_commission['+ data.node.id +']"  value="" style="margin-left: 20px; height: 20px; z-index: 999999; right: 1px; position:absolute;" size="5">');
			}
			else
			{
				
				$("li#" + data.node.id + ".jstree-node").find("> div.jstree-wholerow input[class='cat_comm']").remove();
			}
		}
		catch (e)
		{
			
		}
		*/

	
		
		//alert('Selected: ' + data.node.id );

	})
	.bind('loaded.jstree', function(e, data) {
		// invoked after jstree has loaded
		
		if ( direct_open_node_on_load )
		{
			loop_lagao( direct_open_node_on_load.split(",") );
		}
		
		
		
		
		var loaded_tree 			= _elem.jstree();
		var loaded_tree_li_type 	= loaded_tree.get_node("li:first")['type'];
		if( loaded_tree_li_type == "default")
		{
			_elem.jstree('destroy');
			_elem.html("<div class='jstree_nocategoriesassigned'>No categories assigned.</div>");
			
		}
		
		console.log(_send_id_to_this_elem.val());
		console.log(edit_id_array + "---");
		
		var _ids		= _send_id_to_this_elem.val().split(",");
		if ( edit_id_array )
		{
			edit_id_array_FIRST				= edit_id_array.split("|");
			
			
			for ( var m = 0; m < edit_id_array_FIRST.length; m++ )
			{
				edit_id_array				= edit_id_array_FIRST[ m ].split(",");
				loop_lagao( edit_id_array );
				
				
			}
			

			
			var _leave		= setInterval(function(){
			
				if ( $(".blockUI.blockMsg").css("display") != "block") 
				{
					_waiting_screen("show");	
				}
				
				var _count		= 0;
				for ( var n = 0; n < _ids.length; n++ )
				{
					if ( $.inArray( _ids[n] , $(".load_category_treeview").jstree("get_selected") ) >= 0 )
					{
						_count++;	
					}
				}
				
				
				console.log("Count: " + _count);
				console.log("Ids Length: " + _ids.length);
				
				if ( _count == _ids.length )
				{
					
					clearInterval( _leave );
					//console.log(_ids);
					
					
		
					//at last - when all nodes are open and selected - clear the pageloadvalues.
					if ( show_textbox )
					{
						if ( controller == "managevendorcategoriescommissions/" )
						{
							$("input[name='category_commission']").attr("data-pageloadvalues", "");
						}
					}
					
					_waiting_screen("hide");	
				}
				
			}, 1000);
			
				
		}
		else
		{
			_waiting_screen("hide");	
		}
		
		
	});
	
	
	
	

	
}


function toggle_hide_show_checkbox( )
{
	$('.is_show').not( $('.is_show:checked')).closest('tr').find("input[type='checkbox']").not(  $('.is_show') ).iCheck('disable'); 
	
	
	
	$('.is_show').on('ifChecked', function(event){	
		$(this).closest('tr').find("input[type='checkbox']").not(  $(this) ).iCheck('enable'); 
	});
	
	$('.is_show').on('ifUnchecked', function(event){	
		$(this).closest('tr').find("input[type='checkbox']").not(  $(this) ).iCheck('disable'); 
	});
	
	
	$(".is_show:checked").each (function(){
		
		$(this).closest('tr').find("input[type='checkbox']").not(  $(this) ).iCheck('enable'); 
		
	});
	
}

function loadvendorcategories( listvendors ){

	if( listvendors == 'undefined' )
	{
		listvendors = false;	
	}
	
	if( listvendors )
	{
		var vendor_id 			= $(listvendors).val();	
		
		$('input[name="vendor_id"]').val(vendor_id);
		$('.load_category_treeview').attr('data-drawtreeview', 1);
		$('.container_categories').show();
		
		load_treeview_categories_by_vendor();
		
		// empty, if showing any data 
		$('#search_products').html('');
       	$('#product_form').html('');
	}
}



function load_treeview_categories_by_vendor( elem )
{
	try
	{
		$(".load_category_treeview").attr("data-drawtreeview", "1");
		
		if ( elem == null || elem == "undefined" )
		{
			elem				= false;	
		}
		
		if ( elem )
		{
			if ( elem.val() == "" )
			{
				$("input[name='categories_id']").val("");
				$("input[name='parent_category_ids']").val("");
				
				$(".load_category_treeview").attr("data-drawtreeview", "0");
				
				var table = $('#tbl_records_serverside');
				table.DataTable().destroy();
				table.empty();
			}
		}
	}
	catch(e)
	{
		
	}
	
	

	load_treeview	( 			$(".load_category_treeview"), 
								base_url + "managecategory/controls/Treeview_get_category/vendor_cats",
								base_url + "managecategory/controls/Treeview_move_category",
								$("input[name='categories_id']"),
								$("input[name='parent_category_ids']").val(),
								true
					);	
}

function createProductForm(productid){
	if(productid) {   
		var dataProductType			= $("select[name='product_type'").val();
		_waiting_screen("show");
		$.ajax({
			type: "POST",
			url: "createproductform/0",
			data: "parent_product_id="+productid+"&product_type="+dataProductType,
			cache: false,
			success: function(result){
				_waiting_screen("hide");
				$('#product_form').html(result);
				startEndDatePicker();
				
				render_icheckbox();
				render_icheckbox_events();
				
				$("html, body").animate({ scrollTop: $(document).height()-$(window).height() }); // scroll to bottom
				
			},
			error: function( err )
			{
				_waiting_screen("hide");
				_show_alert( '', 'error', err.statusText );
				console.log(err);
			}
		});
	}
	return false;
}

function check_stock_items(){
    if ($('input.cs_stock').is(':checked')) 
    {
        $("input.quantity_cs").prop('disabled', false);
    } 
    else{
		$("input.quantity_cs").prop('disabled', true);
    }

    if ($('input.cd_stock').is(':checked')) 
    {
       $("input.quantity_cd").prop('disabled', false);
    } 
    else{            
        $("input.quantity_cd").prop('disabled', true);
    }
}

function selectize_inputs( input_class, type, element )
{
	try
	{
		if ( type == null || type == "undefined" )
		{
			type						= false;	
		}
		
		if ( input_class == null || input_class == "undefined" )
		{
			input_class			= false;	
		}
		
		if ( element == null || element == "undefined" )
		{
			element				= false;	
		}
		
	}
	catch (e)
	{
		type 			= false;
		input_class		= false;	
	}
	
	
	if ( input_class || element )
	{
		if ( type == "readonly" )
		{
			if ( input_class != "" )
			{
				if ( $('.' + input_class).length > 0 )
				{
					$('.' + input_class).selectize({
						delimiter: ',',
						create: false,
					});
					
					$('.'+ input_class +' .selectize-input input').attr('readonly','readonly');
					$('.'+ input_class +' .selectize-input').css('border', 'none');
				}	
			}
			else
			{
				if (element.length > 0 )
				{
					element.selectize({
						delimiter: ',',
						create: false,
					});
					
					element.find('.selectize-input input').attr('readonly','readonly');
					element.find('.selectize-input').css('border', 'none');
				}	
			}
		}
		else
		{
			if ( input_class != "" )
			{
				if ( $('.' + input_class).length > 0 )
				{
					$('.' + input_class).selectize({
						persist: false,
						createOnBlur: true,
						create: true
					});
				}
			}
			else
			{
				if ( element.length > 0 )
				{
					element.selectize({
						persist: false,
						createOnBlur: true,
						create: true
					});
				}	
			}
		}
	}
	else
	{
		if ( $('.selectize').length > 0 )
		{
			var if_cleared			= "";
			var TMP_select			= $('.selectize').selectize({
				persist: false,
				createOnBlur: true,

			});
			
		}
		
		if ( $('.selectize_readonly').length > 0 )
		{
			var _se	= $('.selectize_readonly').selectize({
				delimiter: ',',
				
			});
			
			//var selectize = _se[0].selectize;
			//selectize.disable();

			$('.selectize_readonly .selectize-input input').attr('readonly','readonly');
			$('.selectize_readonly .selectize-input').css('border', 'none');
		}	
	}
}

function removeRow()
{
	if ( $("div.removeRow").length > 0 )
	{
		$("div.removeRow").click(function(){
			$(this).closest("tr").remove();
			
			if ( controller == "managepurchaseorders/" )
			{
				collect_product_ids_PURCHASEORDER();
			}
			
		});
	}	
}

function collect_product_ids_PURCHASEORDER()
{
	
	var _TR			= $("table.addremoveOptionTable tr");
	var _TR_ID		= Array();
	_TR.each (function(){
		
		if ( $(this).attr("data-productid") )
		{
			if ( $(this).attr("data-productid") != "")
			{
				_TR_ID.push( $(this).attr("data-productid") );
			}
		}
						
	});	
	
	$("textarea[name='table_listed_product_ids']").val( _TR_ID.join(",") );
}

$(function() {
	
	$(document).ready(function(){
		
		
		
		
		selectize_inputs();
		removeRow();
		
		
		
		
		
		
		
		
		if ( $(".dont-click").length > 0 )
		{
			$(".dont-click").click(function( e ){
				e.preventDefault();
			})
		}
		
		
		showremove_button();
		
		
		if ( $('.timepicker_range').length > 0 )
		{
			$('.timepicker_range').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});
		}
		
		$('.timepicker').timepicker();
		
		$( ".ilinks_sortable" ).sortable({ revert: true });
					 
		 
		 
		//image popup (admincms)
		$(".modelImage").colorbox({});
		
		
		
		
		
		
		
		loadvendorcategories();
		
		if ( controller == "admincms/managewhatwedo/" )
		{
			$("textarea[name='short_desc']").wordCountLimit({
			
				maxlength: "100",
				"divClassName": "count_short_desc",
			
			});
		}
		
		if ( controller == "admincms/manageconferencepresenters/" )
		{
			//manageconferencepresenters_conferencetopicsselection( "view" );
			//manageconferencepresenters_conferencetopicsselection( "edit" );
			
			if ( $('#topics') . length > 0 )
			{
				$('#topics').selectize({
					persist: false,
					createOnBlur: true,
					create: true
				});
			}
			
		}
		
		
		if ( controller == "admincms/manageconference/" )
		{
			$("select[name='countryid']").change(function(){
													   
				ajax_sightseeing_with_country( $("select[name='countryid']") );
				
			});
		}
		
		
		if ( controller == "admincms/manageconferenceprices/" )
		{
			
			
			var radio_inputs		= $("tr.members input[type='text'], tr.others input[type='text']");
			radio_inputs.attr("disabled", true);
			
			
			$('input[type="radio"]').on('ifChecked', function(event){
												
				toggle_confpricetypes(radio_inputs, $(this) );		
				
			});
			
			if ( is_post )
			{
				
				toggle_confpricetypes(radio_inputs, $("input[name='paymenttype_key']:checked") );	
			}
			
			$("select[name='conferenceid']").change(function(){
													   
				ajax_whoattend_by_conferenceid( $("select[name='conferenceid']") );
				
			});
		}
		
		
		if ( controller == "admincms/managecmscontent/" )
		{
			$("select[name='menuid']").change(function(){
													   
				ajax_cmstype_with_cmsmenu( $("select[name='menuid']") );
				
			});
		}
		
		
		if ( controller == "admincms/managesitebanners/" )
		{
			$("select[name='typeid']").change(function(){
													   
				ajax_cmstype_with_typeid( $("select[name='typeid']") );
				
			});
		}
		
		
		if ( controller == "admincms/managecmsmenus/" )
		{
			
			$("select[name='positionid']").change(function(){
													   
				ajax_cmsmenu_with_position( $("select[name='positionid']") );
				
			});
		}
		
		
		
		
		if ( controller == "admincms/manageconferencecontent/" )
		{
			$("select[name='menuid']").change(function(){
													   
				ajax_conferencetype_with_conferencemenu( $("select[name='menuid']") );
				
			});
		}
		
		
		if ( controller == "admincms/manageabstractsubmissionforms/" )
		{
			if ( $("input[name='TMP_assignedto_ids']").length > 0 )
			{
				var data = $("input[name='TMP_assignedto_ids']").val();
				
				var _result			=  JSON.parse(data) ;
				for(var i=0; i < _result.length; i++)
				{
					
					var _sel_elem		= $("select[name='assignedto[]'] option[value='"+ _result[i] +"']");
					_sel_elem.text( _sel_elem.text() + " - (already assigned)" );
					_sel_elem.attr("disabled", true);
				}
				
			}
		}
		
		
		
		render_numericonly();
		
		
		
		
		//EDIT
		if ( controller == "managecategory/" && $("input[name='parent_category_ids']").length > 0 )
		{
			
			load_treeview	( 	$(".load_category_treeview"), 
								base_url + "managecategory/controls/Treeview_get_category",
								base_url + "managecategory/controls/Treeview_move_category",
								$("input[name='general[parent_id]']"),
								$("input[name='parent_category_ids']").val(),
								false,
								false,
								false
							);
		}
		
		//VIEW
		if ( controller == "managecategory/" && $("input[name='open_node_treeview']").length > 0 )
		{
			var _empty_input		= $ ( document.createElement("input") );
			
			load_treeview	( 	$(".load_category_treeview"), 
								base_url + "managecategory/controls/Treeview_get_category",
								base_url + "managecategory/controls/Treeview_move_category",
								_empty_input,
								_empty_input.val(),
								false,
								false,
								true,
								$("input[name='open_node_treeview']").val()
							);
		}
		
		
		
		
		//if ( controller == "managevendorsproducts/" && $("input[name='parent_category_ids']").length > 0 )
		if ( controller == "managevendorsproducts/" && ($("input[name='vendor_id']").length > 0 && $("input[name='vendor_id']").val()  != '') )
		{
			load_treeview_categories_by_vendor();
		}
		
		if ( controller == "managevendorcategoriescommissions/" && $("input[name='parent_category_ids']").length > 0 )
		{
			load_treeview	( 	$(".load_category_treeview"), 
								base_url + "managecategory/controls/Treeview_get_category/default_commission",
								base_url + "managecategory/controls/Treeview_move_category",
								$("input[name='categories_id']"),
								$("input[name='parent_category_ids']").val(),
								true,
								true
							);
		}
		
		if ( controller == "managebaseproducts/" && $("input[name='parent_category_ids']").length > 0 )
		{
			var _URL			= base_url + "managecategory/controls/Treeview_get_category";
			if ( _global_VENDOR_ID )
			{
				_URL			+= "/vendor_cats";
			}
			
			//load_treeview_categories_by_vendor(); vendor cats v_cats
			load_treeview	( 	$(".load_category_treeview"), 
								_URL,
								base_url + "managecategory/controls/Treeview_move_category",
								$("input[name='categories_id']"),
								$("input[name='parent_category_ids']").val(),
								true
							);
		}
		
		if ( controller == "managereportsales/" && $("input[name='parent_category_ids']").length > 0 )
		{
			
			
			load_treeview	( 	$(".load_category_treeview"), 
								base_url + "managecategory/controls/Treeview_get_category/vendor_cats",
								base_url + "managecategory/controls/Treeview_move_category",
								$("input[name='categories_id']"),
								$("input[name='parent_category_ids']").val(),
								true
							);
		}
		
		if ( controller == "managerolespermissions/" && $(".is_show").length > 0  )
		{
			toggle_hide_show_checkbox();	
		}
		
		if ( controller == "managevendorsproducts/" )
		{
				
			if( $("select[name='select_vendor_id'").length > 0 )
			{
				//loadvendorcategories($("select[name='select_vendor_id'"));
				$("select[name='select_vendor_id'").change(function(){
					loadvendorcategories(this);
				});
			}
			
			
			if( $("#search_by_cats").length > 0 )
			{
				$("#search_by_cats").click(function()
				{            
					var dataCategories			= $("input[name='categories_id'").val().split(",");
					var dataProductType			= $("select[name='product_type'").val();
					var dataVendorId			= $("input[name='vendor_id'").val();
																				  
					_waiting_screen("show");
					$.ajax({
						type: "POST",
						url: site_url + "managevendorsproducts/controls/searchproducts",
						data: "categories_id=" + dataCategories + "&product_type=" + dataProductType + "&vendor_id=" + dataVendorId,
						cache: false,
						success: function(result){
							_waiting_screen("hide");
							$('#search_products').html(result);
							$('#tbl_records_products').dataTable();
							$('#product_form').html('');
						},
						error: function( err )
						{
							_waiting_screen("hide");
							_show_alert( '', 'error', err.statusText );
							console.log(err);
						}
					});
				});
			}
		
		}	
		
		if( controller == "managevendorsproducts/" || controller == "managebaseproducts/" )
		{
			if( $("#quick_create_simple").length > 0 )
			{
				$("#quick_create_simple").click(function()
				{            
					$('input[name="is_quick_create_simple"]').val(1);
					$(".box-body.table-responsive form:first").submit();
					
				});
			}	
		}
		
		if ( controller == "managepurchaseorders/"  )
		{
			$("input[name='jQuery_load_products_by_categories']").click(function(){
				
				var dataCategories			= $("input[name='categories_id'").val().split(",");
				dataCategories.push( 0 );
				
				var VendorElem				= $("select[name='vendor_id']").find("option:selected"); //$("select[name='vendor_id'").val().split(",");
				var dataVendorIds			= Array();
				VendorElem.each (function(){
					dataVendorIds.push( $(this).val() );
				});
				dataVendorIds.push( 0 );
				
				console.log(dataVendorIds);
				ajax_getVendorProducts_ByVendorCategories( controller, dataVendorIds, dataCategories );
				
			});
			
			//means ADD new PO and SAVE (validation occurs) -> than create this TREELIST
			if ( (is_post && $("input[name='id']").val() == "") || ( $("input[name='options']").val() == "edit" ) )
			{
				load_treeview_categories_by_vendor( $("select[name='vendor_id']") );
			}
			
			
			if ( $(".btn_cancel_PO_AJAX").length > 0 )
			{
				$(".btn_cancel_PO_AJAX").show();
				$(".btn_cancel_PO").hide();
			}
			else
			{
				$(".btn_cancel_PO").show();
				$(".btn_cancel_PO_AJAX").hide();
			}
		
		}
		
		



		
		if ( redirect_after_5_seconds != "" )
		{
			var a = setTimeout(function(){
				parent.window.location = redirect_after_5_seconds;
				clearTimeout(a);
			}, 5000);
		}
		
		if ( redirect_url != "" )
		{
			parent._waiting_screen("show");
			parent.window.location = redirect_url;
		}
		
	
		if ( closeColorbox )
		{	
			parent.$.colorbox.close();	
		}
	

	});
	
	
	//set navigation class active on current page
	if ( $("aside section.content-header h1").length > 0 )
	{
		var c1_text			= $("aside section.content-header h1").html().trim();
		
		if ( $("ul.sidebar-menu li:contains('"+ c1_text +"')").length > 0 )
		{
			$("ul.sidebar-menu li").attr("class", "");
			$("ul.sidebar-menu li:contains('"+ c1_text +"')").each (function(){
			

				if ( $(this).find(" > a span").html().trim() == c1_text )
				{
					$(this).attr("class", "active");
					
					
					if ( $(this).parent().attr("class") == "treeview-menu" )
					{
						$(this).parent().prev().click();
						
						//$(this).parent().parent().attr("class", "active");
						//$(this).parent().slideDown("slow");
					}
					
				}
				
			
			});
		}
	}



	if ( $("div.testi_bottom_area ul.ulstyleone").length > 0 )
	{
		var c1_text			= $("div.right_area > h1.h1Style2").html().trim();
		
		if ( $("div.testi_bottom_area ul.ulstyleone li:contains('"+ c1_text +"')").length > 0 )
		{
			$("div.testi_bottom_area ul.ulstyleone li").attr("class", "");
			$("div.testi_bottom_area ul.ulstyleone li:contains('"+ c1_text +"')").each (function(){
			

				if ( $(this).find(" > a").html().trim() == c1_text )
				{
					$(this).find(" > a").attr("class", "active");
					
					
					if ( $(this).parent().attr("class") == "treeview-menu" )
					{
						$(this).parent().parent().attr("class", "active");
						$(this).parent().slideDown("slow");
					}
					
				}
				
			
			});
		}
	}
	
	
	
	

				
				
	$(document).on("click", ".submit_btn_form", function(){
		
	
		var operation			= $(this).attr("data-operation");
		
		if ( operation == "delete" )
		{
			$("input[name='options']").val( operation );
			
			if ( controller == "managecategory/" || controller == "managebulkproductsdelete/" )
			{
				if ( $(".load_category_treeview").jstree(true).get_selected().length > 0 )
				{
					var checkbox_options		= $(document.createElement("input"));
					checkbox_options.attr("name", "checkbox_options[]");
					checkbox_options.attr("value",  $(".load_category_treeview").jstree(true).get_selected());
					checkbox_options.css("display", "none");
					
					$(".box-body.table-responsive form:first").append( checkbox_options );
					
					$.jAlert({
						'title': 'Confirmation',
						'content': '<p style="font-size: 15px; text-align: center;">Are you sure want to delete?</p>',
						'theme': 'blue',
						'showAnimation': 'bounceIn',
						'hideAnimation': 'fadeOut',
						'closeOnClick': true,
						'btns': [
							{'text':'Yes', 'theme': 'green', 'closeOnClick': false, 'onClick': function(){  $(".box-body.table-responsive form:first").submit(); } },
							{'text':'No', 'theme': 'black', 'closeOnClick': true }
						],
						'onOpen': function(alert)
						{
						
						}
					});
				}
			}
			else
			{
				if ( $("input[name='checkbox_options[]']").length > 0 )
				{
					$.jAlert({
						'title': 'Confirmation',
						'content': '<p style="font-size: 15px; text-align: center;">Are you sure want to delete?</p>',
						'theme': 'blue',
						'showAnimation': 'bounceIn',
						'hideAnimation': 'fadeOut',
						'closeOnClick': true,
						'btns': [
							{'text':'Yes', 'theme': 'green', 'closeOnClick': false, 'onClick': function(){  $(".box-body.table-responsive form:first").submit(); } },
							{'text':'No', 'theme': 'black', 'closeOnClick': true }
						],
						'onOpen': function(alert)
						{
						
						}
					});
				}
			}
		}
		else if ( operation == "jQuery_edit_with_jstree" )
		{
			if ( $(".load_category_treeview").jstree(true).get_selected().length > 0 )
			{
				window.location = $(this).attr("data-href") + "/" + $(".load_category_treeview").jstree(true).get_selected();
			}
			else
			{
				_show_alert( 'red', 'Invalid Category Selection.', 'Please select Category');	
			}
		}
		
		else if ( operation == "jQuery_create_frontend_navigation" )
		{
			$("input[name='options']").val( operation );
			$(".box-body.table-responsive form:first").submit();
			return true;
		}
		
		else if ( operation == "ajax_create_frontend_navigation" || operation == "jQuery_approve_product"  || operation == "jQuery_generate_barcode" ||  operation == "jQuery_create_purchase_order" )
		{
			$("input[name='options']").val( operation );
			
			if ( operation == "jQuery_create_purchase_order" )
			{
				var _checked_elems		= $("input[type='checkbox']:checked").not(  $("input[name='select_all']") );	
				if ( _checked_elems.length <= 0 )
				{
					_show_alert( 'red', 'Invalid RCP Selection.', 'Please select Request Consignment Pickup');	
				}
				else
				{
					$(".box-body.table-responsive form:first").submit();
					return true;	
				}
			}
			else
			{
				
				$(".box-body.table-responsive form:first").submit();
				return true;
			}
		}
		
		else if ( operation == 'jQuery_send_creditmemo_email_to_customer' )
		{
			var _THIS		= $(this);
			
			
			$.jAlert({
				'title': 'Confirmation',
				'content': '<p style="font-size: 15px; text-align: center;">Are you sure you want to send Creditmemo email to customer?</p>',
				'theme': 'blue',
				'showAnimation': 'bounceIn',
				'hideAnimation': 'fadeOut',
				'closeOnClick': true,
				'btns': [
					{'text':'Yes', 'theme': 'green', 'closeOnClick': false, 'onClick': function() 	{  
																										_THIS.attr("type", "submit");
																										_THIS.removeClass("submit_btn_form");
																										_THIS.click(); 
																									} 
					},
					{'text':'No', 'theme': 'black', 'closeOnClick': true }
				],
				'onOpen': function(alert)
				{
				
				}
			});
		}
		
		else if ( operation == "jQuery_inventory_status_change")
		{
			var _change_status_to			= $(this).data("statuschangeto");
			
			ajax_approve_reject_delivery_receipt_products( _change_status_to );
		}
		
		else if ( operation == "jQuery_create_purchase_order_form" )
		{			
			ajax_create_purchase_order_form();
		}
		
		else if ( operation == "jQuery_request_consignment_pickup_form" )
		{
			ajax_request_consignment_pickup();
		}
		
		else if ( operation == "jQuery_delivery_receipt_form" )
		{
			ajax_delivery_receipt_form();
		}
		
		else if ( operation == "copy" )
		{
			$("input[name='options']").val( operation );
			
			var copy_id		= $(this).parent().parent().find('input[type="checkbox"]').val();
			var input		= $( document.createElement('input') );	
			input.css('display', 'none');
			input.attr("name", "copy_id");
			input.val( copy_id );
			
			var copy_content_input = $( document.createElement('input') );
			copy_content_input.attr("type", "hidden");
			copy_content_input.attr("name", "copy_content");
			copy_content_input.val( "0" );
			
			var conf_id_input = $( document.createElement('input') );
			conf_id_input.attr("type", "hidden");
			conf_id_input.attr("name", "conf_id");
			conf_id_input.val( "0" );
			
			// confirm content copy
			if ( !$( this ).hasClass( "con" ) ) {
				
				$( "#dialog-confirm-yes-no" ).dialog({
					resizable: false,
					modal: true,
					buttons: {
						"Yes": function() {
							
							$( this ).dialog( "close" );
							
							// select conference
							$( "#dialog-select-conference" ).dialog({
								resizable: false,
								modal: true,
								buttons: {
									"Confirm": function() {

										conf_id_input.val( $('select[name="dialogconfid"]').val() );
										$( this ).dialog( "close" );
										
										// confirm content copy
										$( "#dialog-confirm-content-copy" ).dialog({
											resizable: false,
											modal: true,
											buttons: {
												"Yes": function() {
													
													copy_content_input.val( "1" );
													$( this ).dialog( "close" );
													
													$(".box-body.table-responsive form").append( input );
													$(".box-body.table-responsive form").append( copy_content_input );
													$(".box-body.table-responsive form").append( conf_id_input );
													
													$(".box-body.table-responsive form").submit();
													
													
												},
												"No": function() {
													
													copy_content_input.val( "0" );
													$( this ).dialog( "close" );
													
													$(".box-body.table-responsive form").append( input );
													$(".box-body.table-responsive form").append( copy_content_input );
													$(".box-body.table-responsive form").append( conf_id_input );
													
													$(".box-body.table-responsive form").submit();
													
												}
											},
											close: function() {
												$( this ).dialog( "close" );
											}
										});
										
									}
								}
							});
						},
						"No": function() {
							$( this ).dialog( "close" );
						}
					}
				});
				
			} else {
			
				$(".box-body.table-responsive form").append( input );
				$(".box-body.table-responsive form").append( copy_content_input );
				$(".box-body.table-responsive form").append( conf_id_input );
				
				$(".box-body.table-responsive form").submit();
				
			}
		}
		else if ( operation == "ajax_save_record" )
		{
			$("input[name='options']").val( operation );
	
			$("textarea[name='update_textboxes']").val( $("textarea[name='update_textboxes']").val().substr(1) );
			
			$("table#tbl_records_serverside textarea").not(  $( $( "textarea[name='update_textboxes']" ).val() )  ).prop("disabled", true);
			
			$("textarea[name='update_textboxes']").prop("disabled", false);
			
			
			$(".box-body.table-responsive form").submit();
		}
		else if ( operation == "ajax_update_sorting" )
		{
			$("input[name='options']").val( operation );
			
			$(".box-body.table-responsive form").submit();
		}
		else if ( operation == "ajax_download_csv" )
		{
			$("input[name='options']").val( operation );
			
			$(".box-body.table-responsive form").submit();
		}
		
	});
	

	if ( $("#tbl_records_serverside").length > 0 )
	{
		/*
		var ajax_url			= site_url + controller + "controls/view/ajax";
		
		var TMP_order_to		= 0;
		var TMP_order_by		= "desc";
		
		
		var oTable = $('#tbl_records_serverside').dataTable( {
			"processing": true,
			"serverSide": true,
			"searchDelay": 2000,
			"fnDrawCallback": function (e) {
				
				
			},
			'sPaginationType': 'full_numbers',
			
			
			"order": [[ TMP_order_to, TMP_order_by ]],
			
		
		
			"ajax": $.fn.dataTable.pipeline( {
				url		: ajax_url,
				pages	: 5, // number of pages to cache
				"type"	: "POST",
				"columns": [
					{data: 'CHECKBOX', name: 'created_by_role_id'},
					{data: 'created_by_role_id', name: 'PO #'},
					{data: 'created_by_role_id', name: 'Vendor'},
					{data: 'created_by_role_id', name: 'Requested Created By'},
					{data: 'created_by_role_id', name: 'OPTIONS'},
					
				],
				"data"	: 	{
								"_token" : $("input[name='_token']").val()
							}
			} )
		} );
		*/
		
		
		
		dataTableSearchOnEnterKey( 'serverside' );		
		
	}
	
	
	if ( $(".simpleDataTable").length > 0  )
	{
		var tble				= $(".simpleDataTable");
		var bFilter				= true;
		var bLengthChange		= true;
		var bPaginate			= true;
		
		
		
		
		var TMP_order_to		= 0;
		var TMP_order_by		= "desc";
		if ( controller == "admincms/manageconferenceregistration/" || controller == "account/manageconferenceregistration/" )
		{
			TMP_order_to		= 2;
			TMP_order_by		= "desc";
		}
		
		
		if ( tble.hasClass("bFilter") )
		{
			bFilter				= false;
		}
		if ( tble.hasClass("bLengthChange") )
		{
			bLengthChange		= false;
		}
		if ( tble.hasClass("bPaginate") )
		{
			bPaginate			= false;
		}
		
		 var oTable = tble.dataTable({
			dom: dataTableDOM_PARENT,
			"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
			
			'bProcessing': true,
           	"order": [[ TMP_order_to, TMP_order_by ]],
			
			"pageLength": 50,
			"bFilter" : bFilter,               
			"bLengthChange": bLengthChange,
			"bPaginate": bPaginate,
			
			
			"initComplete": function( settings, json  ){
			
			
			var _self	 = this;			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
				if ( controller == "managemappingvendors/" )
				{
					if ( i == 0 || i == 3 )
					{
						return;
					}
				}
				else if ( controller == "managevendorcategoriescommissions/" )
				{
					if ( i == 0 || i == 2 )
					{
						return;
					}
				}
				else if ( controller == "managerequestconsignmentpickup/" )
				{
					if ( i == 0 || i == 5 )
					{
						return;
					}	
				}
				else if ( controller == "managewarehouse/" )
				{
					if ( i == 0 || i == 5 )
					{
						return;
					}	
				}
				else if ( controller == "managewarehouselocation/" )
				{
					if ( i == 0 || i == 3 )
					{
						return;
					}	
				}
				else if ( controller == "managerequestconsignmentpickup/" )
				{
					if ( i == 0 || i == 3 )
					{
						return;
					}	
				}
				else if ( controller == "managepurchaseorders/" )
				{
					if ( i == 0 || i == 9 )
					{
						return;
					}	
				}
				
				var input = document.createElement('input');
				$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
				$(input).addClass('form-control input-sm');
				
				$(input).appendTo($(column.footer()).empty())
				
				.on('keydown', function ( event ) {
					
					var keyCode = (event.keyCode ? event.keyCode : event.which);   
					
					if ( keyCode  == 13 )
					{
						var val = $.fn.dataTable.util.escapeRegex($(this).val());		
						column.search(val ? val : '', false, false).draw();
					}
				});
						
						
				if (0 )
				{
					
				}
				else
				{
					
				
				
					
				}
					
			});
		},

            'sPaginationType': 'full_numbers',
			/*"aoColumnDefs":	[
							  { 'bSortable': false, 'aTargets': [ 0 ] }
							]*/
				  
		});
		
		dataTableSearchOnEnterKey( 'clientside', null, oTable );		
		
		
		
		   
	}
	
	
	disableSubmitForm_onDataTableSearch();
	
	
	
	
	
	//admincms/manageresorts
	if ( $( 'input[name="registration_from"]' ) && ( 'input[name="registration_to"]' ) )
	{
		$( "#registration_from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
			$( "#registration_to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		
		$( "#registration_to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
			$( "#registration_from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	}
	
	if ( $( 'input[name="duration_from"]' ) && ( 'input[name="duration_to"]' ) )
	{
		$( "#last_minute_start" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
			$( "#last_minute_end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		
		$( "#last_minute_end" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
			$( "#last_minute_start" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	}
	
	
	
	/*
	2 types of datepicker
	- .datepicker (only shows datepicker)
	- .data-datemode (shows with start-end date)
	*/
	
	
	
	if ( $(".datepicker").length > 0 )
	{
		$(".datepicker").datepicker(  { dateFormat: "dd-mm-yy" } );
	}
	

	if ( $( 'input[name="registration_from"]' ) && ( 'input[name="registration_to"]' ) )
	{
		$( "#registration_from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
			$( "#registration_to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		
		$( "#registration_to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
			$( "#registration_from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	}
	
	
	
	
	
	//when click on calendar icon - show datepicker
	$("i.fa-calendar").click(function(){
	
		$(this).parent().parent().find("input").datepicker("show");
	
	});
	

	
	
	startEndDatePicker();
	
	
	if ( $("input[data-datemode='start_1']").length > 0 && $("input[data-datemode='end_1']").length > 0 )
	{
		$("input[data-datemode='start_1']").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
			$("input[data-datemode='end_1']").datepicker( "option", "minDate", selectedDate );
			}
		});
		
		
		$("input[data-datemode='end_1']").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: "dd-mm-yy",
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
			$("input[data-datemode='start_1']").datepicker( "option", "maxDate", selectedDate );
			}
		});
	}
	
	
	
	// admin left menu search
	
	// extend jquery for 'containsi' (case insensitive)
	$.extend($.expr[':'], {
	  'containsi': function(elem, i, match, array)
	  {
		return (elem.textContent || elem.innerText || '').toLowerCase()
		.indexOf((match[3] || "").toLowerCase()) >= 0;
	  }
	});
	
	$('input[name="q"]').bind("keyup", function() {
		
		var tval = $(this).val();
		
		if ( $("ul.sidebar-menu li").hide().filter(":containsi('"+tval+"')").find('li').andSelf().show() ) 
		{
	
			$("ul.sidebar-menu li ul.treeview-menu li").hide().filter(":containsi('"+tval+"')").find('li').andSelf().show();
			
		}
		
		if ($('li[style="display: list-item;"]').find('ul.treeview-menu').find('li[style="display: list-item;"]').length == 0)
		{
			$('li[style="display: list-item;"]').find('ul.treeview-menu').find('li').css('display', 'list-item');
		}
		
	});
	
	
	
	
	
	
	
});


function _waiting_screen( mode1, mode2 )
{
	if (mode2 == null)
	{
	
	}
	
	if ( (mode1 == "show") || (mode1 == "in") )
	{
		$.blockUI({ 
			css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} 
		});	
	}
	else if (mode1 == "hide")
	{
		$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 
		$('.blockOverlay').click();
		
	}
	
}

function _runtimePopup( mode, url, _result )
{
	if ( _result == null || _result == "undefined" )
	{
		_result = false;		
	}

	if ( (mode == "!!") )
	{
		$.colorbox({href: url, iframe:true, width:"40%", height:"50%"});	
		return;
	}
	else if ( (mode == "modalUrl") )
	{
		
		$.colorbox({href: url, iframe:true, width:"50%", height:"100%"});	
		return;
	}
	else if ( (mode == "modalUrl_refreshonclose") )
	{
		
		$.colorbox({href: url, 
					iframe:true, 
					width:"80%", 
					height:"100%", 
					onCleanup:function(){ 
						_waiting_screen("show");
						window.location = _result._onclose_redirect_to;
					}		
		});	
		return;
	}	
	else if ( (mode == "modalUrl_80perc") )
	{
		
		$.colorbox({href: url, iframe:true, width:"80%", height:"100%"});	
		return;
	}	
	else if ( (mode == "modalImage") )
	{
		
		$.colorbox({href: url, photo:true});
		return;
	}
	else if ( (mode == "modalVideo") )
	{
		
		$.colorbox({href: url, iframe:true, innerWidth:640, innerHeight:390});
		return;
	}
	else if ( (mode == "modalDesc") )
	{
		$.colorbox({href: url, iframe:true, width:"45%", height:"75%"});
		return;
	}
	
}



function remImage( remove_id )
{
	var tmp				= $("input[id='"+ remove_id +"']").val('');
	tmp . parent() . remove();
}

function render_textarea( elem  )
{
	
	if ( elem == null )
	{
		elem		= $("textarea[class='ckeditor1']");
	}
	else
	{
		if ( elem.length > 0 )
		{
			var editor 	= CKEDITOR.instances[elem.attr("name")];
			
			if (editor) { editor.destroy(true); }
		}
		else
		{
			return false;	
		}
	}
	
	

	elem.each(function(){
												   
		CKEDITOR.replace( $(this).attr("name"),
		{
			filebrowserBrowseUrl : base_url + "assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Connector=" + base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php" ,
			filebrowserImageBrowseUrl : base_url + "assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=" + base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php" ,
			filebrowserFlashBrowseUrl : base_url + "assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=" + base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php" ,
			filebrowserUploadUrl  : base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=File",
			filebrowserImageUploadUrl : base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image",
			filebrowserFlashUploadUrl : base_url + "assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash"
		});
		
	});

}

function operation_menus_boxes(mode, elem)
{
	if ( elem == null )
	{
		
	}
	
	if ( mode == "add" )
	{
		var tr			= $(".add_menus_boxes:last");
		
		var _clone		= tr.clone();
		
		
		_clone.attr("class", "add_menus_boxes " + $(".add_menus_boxes").length);
		_clone.find("input").val("");

		
		$(".add_menus_boxes:last").after( _clone );

		
		
		
	}
	else if ( mode == "remove" )
	{
		elem.parent().parent().parent().parent().parent().parent().remove();
	}
}

var _index_count			= 0;
function delete_clone( elem )
{
	elem.closest("tr").remove();
}
function add_new_as_clone(copy_this_id, copy_to_this_table)
{
	var tr			= $( copy_this_id );
	
	var _clone		= tr.clone();
	
	/*
	if ( tr.attr("data-INCR_ID") )
	{
		var _next_ID	= tr.attr("data-INCR_ID") + 1;
	}
	else
	{
		var _next_ID	= tr.nextAll("tr").length + 1;
	}
	*/
	
	_next_ID			= _index_count++;
	 
	
	_clone.find("input,select").each (function(){
		
		var _name			= $(this).attr("name");
		
		if ( $(this).is("select") )
		{
			$(this)[0].selectedIndex		= 0;
		}
		else
		{
			$(this).val('');	
		}
		
		
		_name				= _name.replace("__index__", _next_ID);
		$(this).attr("name", _name);
		$(this).attr("disabled", false);
		
	});
	
	
	_clone.attr("id", "");
	_clone.attr("name", "");
	_clone.attr("class", "");
	_clone.css("display", "");
	
	$(copy_to_this_table).after( _clone );
}



function showremove_button()
{
	$(".columndelete").parent().find("td").parent().not(":first").find(".columndelete span").addClass("display-block");
}

function operation_menus_boxes_for_conference_program(mode, elem)
{
	if ( elem == null )
	{
		
	}
	
	if ( mode == "add" )
	{
		
		
		var tr			= elem.parent().parent().parent().parent().find(".add_menus_boxes:last");
		tr.find("input.selectize").each (function(){
			$(this)[0].selectize.destroy();	
		});
		
	
		var _clone		= tr.clone();
		
		
		selectize_inputs("", "", tr.find("input.selectize"));
		console.log(tr.find("input.selectize").find('.selectize-input'));
		tr.find("input.selectize").find('.selectize-input').css('border', 'none');
					
		
		console.log( tr.find("input.selectize") );
		
		_clone.attr("class", "add_menus_boxes " + elem.parent().parent().parent().parent().find(".add_menus_boxes").length);
		_clone.find("input").val("");
		_clone.find('.timepicker').timepicker();
		

		selectize_inputs("", "", _clone.find("input.selectize"));
		_clone.find("input.selectize").find('.selectize-input input').attr('readonly','readonly');
		_clone.find("input.selectize").find('.selectize-input').css('border', 'none');
		
		
		
		tr.after( _clone );
		
		
		
		
		
		render_numericonly();
		showremove_button();
		
		/*elem.parent().parent().parent().parent().find(".columndelete span").addClass("display-block");
		elem.parent().parent().parent().parent().find(".columndelete:first span").removeClass("display-block");*/

		
		
		
	}
	else if ( mode == "remove" )
	{
		elem.parent().parent().parent().remove();
	}
}


function submit_action( data, target, param1, param2 )
{
	if ( param1 == null || param1 == "undefined" )
	{
		param1	= false;	
	}

	var _result			=  JSON.parse(data) ;
	console.log(_result);
	
	if ( _result._redirect_to == "" )
	{
		

		
		if ( _result._call_name  == "request_consignment_pickup" || _result._call_name  == "approve_reject_delivery_receipt_products" || _result._call_name  == "delivery_receipt_form" )
		{
			_waiting_screen( "hide" );
			
			if( _result._CSS_show_messages == "success" )
			{
				_runtimePopup( 'modalUrl_refreshonclose', _result._TEXT_show_messages, _result);
			}
			else
			{
				_show_alert( _result._CSS_show_messages, _result._HEADING_show_messages, _result._TEXT_show_messages, _result._js_jAlert_EVENT, _result._js_jAlert_CALLBACK );	
			}			
		}
		else if ( _result._call_name == 'create_purchase_order_form' )
		{
			_waiting_screen( "hide" );
			
			if( _result._CSS_show_messages == "error" )
			{
				_show_alert( 'red', _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
			else
			{
				
				if ( $("textarea[name='table_listed_product_ids']").length > 0 )
				{
					//console.log(_result._TEXT_show_messages);
					$( target ).find("table.addremoveOptionTable").append( _result._TEXT_show_messages );
				}
				else
				{
					$( target ).html( _result._TEXT_show_messages );
				}
				
				
				
				
				
				collect_product_ids_PURCHASEORDER();
				removeRow();
				
				$( target ).find("table.addremoveOptionTable tr .selectize_readonly").each (function(){
					
					try{
					$(this)[0].selectize.destroy();
					}catch(e)
					{ }
				});
				
				selectize_inputs('selectize_readonly', 'readonly');
				
				
				
				if ( $(".btn_cancel_PO_AJAX").length > 0 )
				{
					$(".btn_cancel_PO_AJAX").show();
					$(".btn_cancel_PO").hide();
				}
				else
				{
					$(".btn_cancel_PO").show();
					$(".btn_cancel_PO_AJAX").hide();
				}
			
			
				//_runtimePopup( 'modalUrl_80perc', _result._TEXT_show_messages );	
			}
		}
		
		else if ( _result._call_name == 'ajax_create_frontend_navigation' ||  _result._call_name == "order_outbound_pickup_list" || _result._call_name == "ship_order" || _result._call_name == "invoice_order" || _result._call_name == "creditmemo_order"  )
		{
			_waiting_screen( "hide" );
			
			if( _result._CSS_show_messages == "btn_Ajax_Request" )
			{
				if ( _result._HEADING_show_messages == "POST" )
				{
					try
					{
						param2.closest("form").submit();
					}
					catch (e)
					{
						
					}
				}
				else if ( _result._HEADING_show_messages == "SHOW_CONTENT" )
				{
					
					$(param1).html( _result._TEXT_show_messages );
				}
			}
			else if( _result._CSS_show_messages == "open_runtime_popup" )
			{
				_runtimePopup( 'modalUrl_refreshonclose', _result._TEXT_show_messages, _result);
			}
			else
			{
				_show_alert( _result._CSS_show_messages, _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
		}
		
		else if ( _result._call_name  == "ajax_create_dashboard_graph")
		{
			if ( param1[ param1.length -1 ] == param2 )
			{
				$(".overlay").hide();
				$(".loading-img").hide();
				//_waiting_screen("hide");
			}
			
			if( _result._CSS_show_messages == "error" )
			{
				_show_alert( 'red', _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
			else
			{
				$( target ).html( _result._TEXT_show_messages );
			}			
		}
		
		
		
		else if ( _result._call_name  == "getVendorProducts_ByVendorCategories")
		{
			_waiting_screen("hide");
			
			if( _result._CSS_show_messages == "error" )
			{
				_show_alert( 'red', _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
			else
			{
				$( target ).html( _result._TEXT_show_messages );
			}			
		}
		else if ( _result._call_name  == "submit_order_comment")
		{
			_waiting_screen("hide");
			
			if( _result._CSS_show_messages == "error" )
			{
				_show_alert( 'red', _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
			else
			{
				$( target ).html( _result._TEXT_show_messages );
				$( target ).find(".slimScroll").slimScroll({
					height: '250px'
				});
				render_icheckbox();
				
				$("span#order_status").html( _result._HEADING_show_messages );
			}			
		}
		
		else if ( _result._call_name  == "render_warehouse_location")
		{
			parent._waiting_screen("hide");
			
			if( _result._CSS_show_messages == "error" )
			{
				_show_alert( 'red', _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
			else
			{
				//$("select[name='warehouse_location_id'").parent().html( _result._TEXT_show_messages );
				$( target ).html( _result._TEXT_show_messages );
			}			
		}
		
		else if ( _result._call_name  == "getProducts_byVendors")
		{
			
			
			if( _result._CSS_show_messages == "error" )
			{
				_show_alert( 'red', _result._HEADING_show_messages, _result._TEXT_show_messages );	
			}
			else
			{
				$( target ).html( _result._TEXT_show_messages );
			}
			
			//$( target ).html( _result._TEXT_show_messages );
			//render_textarea( $("textarea[name='content']") );
			
		}
		
		
		else if ( ( _result._call_name  == 'cmstype_with_cmsmenu' )  ||  ( _result._call_name  == 'cmstype_with_typeid' ) )
		{
			
			$( target ).html( _result._TEXT_show_messages );
			render_textarea( $("textarea[name='content']") );
			
			_waiting_screen( "hide" );
			
		}
		
		
		
		else if ( _result._call_name  == 'cmsmenu_with_position')
		{


			$( target ).html( _result._TEXT_show_messages );
			//render_textarea( $("textarea[name='content']") );
			
			_waiting_screen( "hide" );
			
		}
		
		
		else if ( _result._call_name  == 'conferencetype_with_conferencemenu')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			render_textarea( $("textarea[name='content']") );
			
			_waiting_screen( "hide" );
			
		}
		
		
		else if ( _result._call_name  == 'sightseeing_with_country')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			render_icheckbox();
			_waiting_screen( "hide" );
			
		}
		
		
		else if ( _result._call_name  == 'whoattend_by_conferenceid')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			_waiting_screen( "hide" );
			
			
		}
		
		else if ( _result._call_name  == 'conference_program_table_by_conferenceid')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			$('.timepicker').timepicker();
			render_icheckbox();
			render_numericonly();
			_waiting_screen( "hide" );
			
			
		}
		
		else if ( _result._call_name  == 'conferencetopics_by_conferenceid')
		{
			
			$( target ).html( _result._TEXT_show_messages );
			render_icheckbox();
			
			$( ".ilinks_sortable" ).sortable({ revert: true });
			
			_waiting_screen( "hide" );
			
		}
		
		
		
	}
}