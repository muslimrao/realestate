function datatable_block_ui( mode )
{
	if ( mode == "show" )
	{
		$('.box.mainFrame').block({ 
			overlayCSS: {opacity:         0.2},
			message: '', //'<h1 class="25_perc_margin">Processing</h1>', 
			css: { border: '6px solid activecaption', } 
		}); 
	}
	else
	{
		$('.box.mainFrame').unblock(); 
	}
}


function ajax_delivery_receipts_view_records( select_elem )
{
	
	try
	{
		var table = $('#tbl_records_serverside');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	var _sellercenter_status			= select_elem.val();
	if ( _sellercenter_status == "" )
	{
		_sellercenter_status			= 0;
	}
	
	var this_site			= "manageinventory/controls/view/" + _sellercenter_status;
	var url 				= base_url + this_site;
	var template 			= Handlebars.compile($("#details-template").html());
	
	
	var table = $('#tbl_records_serverside').DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		processing: true,
		serverSide: true,
		"ajax": {
            "url": url,
            /*"data": function ( d ) {
                d.sellercenter_status = select_elem.val();
            }*/
        },
		
		
		columns: [
			{
				"className":      'details-control',
				"orderable":      false,
				"searchable":      false,
				"data":           null,
				"defaultContent": ''
			},
			{data: 'id', name: 'id'},
			{data: 'total_products', name: 'total_products'},
			{data: 'vendor_id', name: 'vendor_id'},
			{data: 'warehouse_id', name: 'warehouse_id'},
			{data: 'received_date', name: 'received_date'},
			{data: 'received_time', name: 'received_time'}
		],
		"fnDrawCallback": function (e) {
			render_icheckbox();
			render_icheckbox_events();
		},
		"initComplete": function( settings, json  ){
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside' );		
		}
	});
	
	$('#tbl_records_serverside tbody').off('click', 'td.details-control');
	
	// Add event listener for opening and closing details
	$('#tbl_records_serverside tbody').on('click', 'td.details-control', function () {
		console.log(1);
		
		var tr = $(this).closest('tr');

		var row = table.row(tr);

		var tableId = 'posts-' + row.data().id;

	

		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(template(row.data())).show();
			ajax_delivery_receipts_view_records_INITIALIZE_TABLE(tableId, row.data());
			tr.addClass('shown');
			tr.next().find('td').addClass('no-padding bg-gray');
		}
			
	});
	
}

function ajax_delivery_receipts_view_records_INITIALIZE_TABLE(tableId, data) 
{
	console.log(tableId);
	console.log(data);
	
	
	$('#' + tableId).DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_CHILD),
		dom: dataTableDOM_PARENT,
		processing: true,
		serverSide: true,
		ajax: data.details_url,
		columns: [
			{ data: 'products_checkbox', name: 'products_checkbox' },
			{ data: 'uid', name: 'uid' },
			{ data: 'qrcode', name: 'qrcode' },
			{ data: 'purchaseorder_id', name: 'purchaseorder_id'},
			{ data: 'categories_name', name: 'categories_name' },
			{ data: 'product_name', name: 'product_name' },
			{ data: 'warehouse_name', name: 'warehouse_name' },
			{ data: 'status', name: 'status' },
		],

		"fnDrawCallback": function (e) {
			

			render_icheckbox( "maincheckbox_" + $(this).attr("data-id"));
			render_icheckbox( "childcheckbox_" + $(this).attr("data-id"));
			
			render_icheckbox_events( "maincheckbox_" + $(this).attr("data-id"), "childcheckbox_" + $(this).attr("data-id"));
			
			selectize_inputs("selectize_categories_" + $(this).attr("data-id"), "readonly");
		},
		"initComplete": function( settings, json  ){
			
			
			disableSubmitForm_onDataTableSearch(  $('#' + tableId) );
			dataTableSearchOnEnterKey( 'serverside', tableId );	

			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
			
				
			
			
			
				if ( i == 0 || i == 2 )
				{
					
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
		
							column.search(val ? val : '', false, false).draw();
						}
					});	
				}
			});
			
			
	   }
	})
}

/////////// 	REPORTS RECORDS	START	///////////
function ajax_managereportaccountstatement_view_records( select_elem )
{
	
	try
	{
		var table = $('#tbl_records_reports');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	var _vendor_id			= select_elem.val();
	if ( _vendor_id == "" )
	{
		_vendor_id			= 0;
	}
		
	var this_site			= "managereportaccountstatement/controls/view/" + _vendor_id;
	var url 				= base_url + this_site;
	var template 			= Handlebars.compile($("#details-template").html());
	
	
	var table = $('#tbl_records_reports').DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		buttons: [
			'excelHtml5',
			'csvHtml5',
		],
		
		processing: true,
		serverSide: true,
		order: [[ 1, "desc" ]],
		"ajax": {
            "url": url,
			
        },
		
		
		
		/*
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		
		dom: 'Blfrtip',
		buttons: [
			'excelHtml5',
			'csvHtml5',
		],
		*/
		
		
		
		
		
		/*
		dom: 'Blfrtip',
		buttons: [{
			text: 'PDF',
			action: function(e, dt, button, config) 
			{
				dt.one('preXhr', function(e, s, data) 
				{
					data.length = -1;
				})
				.one('draw', function(e, settings, json, xhr) 
				{
					var csvButtonConfig = $.fn.DataTable.ext.buttons.csvHtml5;
					var addOptions = { exportOptions: { "columns" : ":visible" }};
					
					$.extend(true,csvButtonConfig,addOptions);
					csvButtonConfig.action(e, dt, button, csvButtonConfig);
					
				}).draw();
			}
		
		}],
		*/
		
		
		columns: [
			{
				"className":      'details-control',
				"orderable":      false,
				"searchable":      false,
				"data":           null,
				"defaultContent": ''
			},
			
			
			{data: 'mageuserid', 		name: 'mageuserid'},
			{data: 'fullname', 		name: 'fullname'},
			{data: 'email', 		name: 'email'},
			{data: 'partnerstatus', 	name: 'partnerstatus'},
			{data: 'commision', 	name: 'commision'},
			
			{data: 'totalsale', 	name: 'totalsale' },
			{data: 'amountrecived', 		name: 'amountrecived' },

			{data: 'amountremain', 		name: 'amountremain'},
			{data: 'amountpaid', 		name: 'amountpaid'},
			{data: 'created_at', 		name: 'created_at'},
			
		],
		"initComplete": function( settings, json  ){
			
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside', 'tbl_records_reports' );		
			
			
			var _self	 = this;			
			this.api().columns().every(function ( i, f ) {
			
				
				var column = this;
				
				
				if ( i == 0 )
				{
					
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
							
							
							$(column.footer()).closest("tr").find("input,select").removeClass("selectedSearch");
							$(input).addClass("selectedSearch");
							
							column.search(val ? val : '', false, false).draw();
						}
					});
				}
			
			});
		}
	});
	
	
	
	$('#tbl_records_reports tbody').off('click', 'td.details-control');
	
	// Add event listener for opening and closing details
	$('#tbl_records_reports tbody').on('click', 'td.details-control', function () {
		console.log(1);
		
		var tr = $(this).closest('tr');

		var row = table.row(tr);

		var tableId = 'posts-' + row.data().id;

	

		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(template(row.data())).show();
			ajax_managereportaccountstatement_view_records_INITIALIZE_TABLE(tableId, row.data());
			tr.addClass('shown');
			tr.next().find('td').addClass('no-padding bg-gray');
		}
			
	});
	
}


function ajax_managereportaccountstatement_view_records_INITIALIZE_TABLE(tableId, data) 
{
	
	
	
	$('#' + tableId).DataTable({
		
		
		"lengthMenu": JSON.parse(dataTableLENGTH_CHILD),
		dom: dataTableDOM_CHILD,
		
		buttons: [
			'excelHtml5',
			'csvHtml5',
		],
		
		order: [[ 1, "desc" ]],
		
		processing: true,
		serverSide: true,
		ajax: data.details_url,
		columns: [
			{ data: 'products_checkbox', name: 'products_checkbox', searchable: false, orderable: false, visible: false, },
			{ data: 'magerealorderid', name: 'magerealorderid' },
			{ data: 'cleared_at', name: 'cleared_at' },
			{ data: 'mageproname', name: 'mageproname'},
			{ data: 'magequantity', name: 'magequantity' },
			
			{ data: 'totalamount_HIDE', name: 'totalamount_HIDE', visible: false, },
			{ data: 'totalamount', name: 'totalamount' },
			{ data: 'totaltax', name: 'totaltax' },
			{ data: 'totalshipping', name: 'totalshipping', searchable: false, orderable: false, },
			
			
			{ data: 'applied_coupon_amount', name: 'applied_coupon_amount' },
			{ data: 'actualparterprocost', name: 'actualparterprocost' },
			{ data: 'totalcommision', name: 'totalcommision' },
			{ data: 'status', name: 'status' },
			{ data: 'paidstatus', name: 'paidstatus' },
			
			
			{ data: 'view', name: 'view' , searchable: false, orderable: false,},
			{ data: 'payseller', name: 'payseller', searchable: false, orderable: false, },
			
			
		],
		
	
		"fnDrawCallback": function (e) {
			

			render_icheckbox( "maincheckbox_" + $(this).attr("data-id"));
			render_icheckbox( "childcheckbox_" + $(this).attr("data-id"));
			
			render_icheckbox_events( "maincheckbox_" + $(this).attr("data-id"), "childcheckbox_" + $(this).attr("data-id"));
			
			selectize_inputs("selectize_categories_" + $(this).attr("data-id"), "readonly");
		},
		
		"initComplete": function( settings, json  ){
			
			
			disableSubmitForm_onDataTableSearch(  $('#' + tableId) );
			dataTableSearchOnEnterKey( 'serverside', tableId );	

			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
			
			
			
			
				if ( i == 0 || i == 7 || i == 13 || i == 14 )
				{
					
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
		
							column.search(val ? val : '', false, false).draw();
						}
					});	
				}
			});
			
			
	   },
	   
		"createdRow": function ( row, data, index ) 
		{
			
			
			if ( data.payseller.substr(1, 6) == "button" ) 
			{
				$(row).addClass('selected');
			}
			
		},
		
	    "footerCallback": function ( row, data, start, end, display ) {
			
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
           
		   
		   
		   
			var _self				= this;
			var _th					= $(_self).find("tfoot tr").eq(1).find("th").eq(5);
			_th.attr("class", "box");
			_th.css("height", "100px");
			_th.html( '<div class="overlay"></div><div class="loading-img"></div>' );
			
			$.ajax({
				type: "POST",
				url: base_url + 'Ajaxmethods/ajax_getFormatted_Price',
				data: {price: total },
				success: function(response) {
					
					_th.css("height", "auto");
					_th.html( response );
				}
		
			});
			
			
		   //$(this).find("tfoot tr:eq(1)")[8].html( total );
		   
		   
		   
        
		}
	})
}






function ajax_manage_customers_view_records()
{
	
	try
	{
		var table = $('#tbl_records_reports');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
		
	var this_site			= "managereportcustomers/controls/view";
	var url 				= base_url + this_site;
	
	var table = $('#tbl_records_reports').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "asc" ]],
		"ajax": {
            "url": url,
			
        },
		
		
		
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		
		buttons: [
			'excelHtml5',
			'csvHtml5',
			/*'pdfHtml5'*/
		],
		
		/*
		dom: 'Blfrtip',
		buttons: [{
			text: 'PDF',
			action: function(e, dt, button, config) 
			{
				dt.one('preXhr', function(e, s, data) 
				{
					data.length = -1;
				})
				.one('draw', function(e, settings, json, xhr) 
				{
					var csvButtonConfig = $.fn.DataTable.ext.buttons.csvHtml5;
					var addOptions = { exportOptions: { "columns" : ":visible" }};
					
					$.extend(true,csvButtonConfig,addOptions);
					csvButtonConfig.action(e, dt, button, csvButtonConfig);
					
				}).draw();
			}
		
		}],
		*/
		
		
		columns: [
			
			{data: 'entity_id', 		name: 'entity_id'},
			{data: 'name', 	name: 'name'},
			{data: 'email', 	name: 'email'},
			
			{data: 'billing_telephone', 	name: 'billing_telephone', sorting: false,},
			{data: 'billing_region', 		name: 'billing_region', sorting: false,  },
			{data: 'created_at', 		name: 'created_at'},
			
		],
		"initComplete": function( settings, json  ){
			
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside', 'tbl_records_reports' );		
			
			
			var _self	 = this;			
			this.api().columns().every(function ( i, f ) {
				
				var column 	= this;
				var input 	= document.createElement('input');
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
					
					
			});
		}
	});
	
	
}



function ajax_manage_dispatched_orders_view_records( params )
{
	
	try
	{
		var table = $('#tbl_records_reports');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}

	var this_site			= "managereportaccount/controls/view/" + params;
	var url 				= base_url + this_site;
	
	var table = $('#tbl_records_reports').DataTable({
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		"ajax": {
            "url": url,
			
        },
		
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		
		
		buttons: [
			'excelHtml5',
			'csvHtml5',
			/*'pdfHtml5'*/
		],
		
		columns: [
			
			{data: 'order_number', name: 'order_number'},
			{data: 'purchased_on', name: 'purchased_on'},
			{data: 'gt_base', name: 'gt_base'}		
			
		],
		"initComplete": function( settings, json  ){
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside', 'tbl_records_reports' );		
			
			var _self	 = this;			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
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
					
					
			});
		}
	});
	
	
}

function ajax_manage_sale_reports_view_records(  )
{
	
	try
	{
		var table = $('#tbl_records_reports');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	/*var _vendor_id			= select_elem.val();
	if ( _vendor_id == "" )
	{
		_vendor_id			= 0;
	}*/
	
	
	var this_site			= "managereportsales/controls/view";
	var url 				= base_url + this_site;
	
	var table = $('#tbl_records_reports').DataTable({
		
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		
		
		processing: true,
		serverSide: true,
		order: [[ 0, "desc" ]],
		
	
		"ajax": {
            "url": url,
			data: function (d) {
                d.categories_id = $("input[name='categories_id']").val();
                d.parent_category_ids = $("input[name='parent_category_ids']").val();
				d.vendor_id = $("select[name='vendor_id[]']").val().join(",");
				d.to_date = $("input[name='to_date']").val();
				d.from_date = $("input[name='from_date']").val();
            }
        },
		
		
		
			
	
		
		
		
		
		dom: dataTableDOM_PARENT,
		buttons: [
			'excelHtml5',
			'csvHtml5'
		],
		
		columns: [
			
			
			
			
			
			{ data: 'magerealorderid', name: 'magerealorderid' },
			{ data: 'cleared_at', name: 'cleared_at' },
			{ data: 'vendorname', name: 'vendorname'},
			{ data: 'categories', name: 'categories'},
			{ data: 'mageproname', name: 'mageproname'},
			{ data: 'magequantity', name: 'magequantity' },
			{ data: 'totalamount', name: 'totalamount' },
	

			{ data: 'status', name: 'status' },

			
			/*
			
			
			{data: 'increment_id', name: 'increment_id', searchable: false, orderable: false},
			{data: 'created_at', name: 'created_at'},
			{data: 'vendor_name', name: 'vendor_name', searchable: false, orderable: false},			
			{data: 'name', name: 'name', searchable: false, orderable: false},
			{data: 'quantity', name: 'quantity', searchable: false, orderable: false},
			{data: 'totalamount', name: 'totalamount', searchable: false, orderable: false},			
			{data: 'actualparterprocost', name: 'actualparterprocost', searchable: false, orderable: false},			
			{data: 'totalcommision', name: 'totalcommision', searchable: false, orderable: false},			
			{data: 'status', name: 'status'}	
			*/	
			
		],
		/*"fnDrawCallback": function (e) {
			render_icheckbox();
			render_icheckbox_events();
		},*/
		
		"fnDrawCallback": function (e) {
		
			render_icheckbox();
			render_icheckbox_events();
			
			selectize_inputs( 'selectize_readonly', 'readonly');
			
		},
		"initComplete": function( settings, json  ){
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside', 'tbl_records_reports' );		
			
			
			var _self	 = this;			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				if (0 )
				{
					
				}
				else
				{
					
				
				
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
				}
					
			});
		}
	});
	
	
	
	$('#submit-filters').click(function(){
        table.draw();
    });
	
	
}

/////////// 	REPORTS RECORDS	END		///////////


function ajax_manage_orders_view_records( select_elem )
{
	
	try
	{
		var table = $('#tbl_records_serverside');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	var _vendor_id			= select_elem.val();
	if ( _vendor_id == "" )
	{
		_vendor_id			= 0;
	}
	
	var this_site			= "manageorders/controls/view/" + _vendor_id;
	var url 				= base_url + this_site;
	var template 			= Handlebars.compile($("#details-template").html());
	
	
	



	var table = $('#tbl_records_serverside').DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,	
		//dom: "lf<'custominputs'><'clearboth'>pri",
		processing: true,
		serverSide: true,
		
		
		order: [[2, "desc" ]],
		"ajax": {
            "url": url,
			data: function (d) {
                d.from_date = $("input[name='created_at[from]']").val();
                d.to_date = $("input[name='created_at[to]']").val();
            }
			
            /*"data": function ( d ) {
                d.sellercenter_status = select_elem.val();
            }*/
        },
		
		/*
		databales-buttons
		dom: 'Blfrtip',
		buttons: [
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
		],*/
		
		columns: [
			{data: 'checkbox', name: 'checkbox', "orderable":      false, "searchable":      false},
			
			{
				"className":      'details-control',
				"orderable":      false,
				"searchable":      false,
				"data":           null,
				"defaultContent": ''
			},
			
			{data: 'increment_id', name: 'increment_id'},
			{data: 'created_at', name: 'created_at', "searchable":      false},
			{data: 'item_count', name: 'item_count', "orderable":      false, "searchable":      false},
			
			{data: 'billing_name', name: 'billing_name'},
			{data: 'bill_to_email', name: 'bill_to_email', "orderable":      false, "searchable":      false},
			{data: 'shipping_name', name: 'shipping_name'},
			
			{data: 'actual_base_grand_total', name: 'actual_base_grand_total', visible: false},
			{data: 'base_grand_total', name: 'base_grand_total'},
			{data: 'grand_total', name: 'grand_total'},
			
			{data: 'payment_mode', name: 'payment_mode', "orderable":      false, "searchable":      false},
			{data: 'status', name: 'status'},
			
		
			{data: 'action', name: 'action', "orderable":      false, "searchable":      false}
		],
		"fnDrawCallback": function (e) {
		
			render_icheckbox();
			render_icheckbox_events();
			
		},
		
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
           
		   
		   
		   
		   
			var _self				= this;
			var _th					= $(_self).find("tfoot tr").eq(1).find("th").eq(9);
			_th.attr("class", "box");
			_th.css("height", "100px");
			_th.html( '<div class="overlay"></div><div class="loading-img"></div>' );
			
			$.ajax({
				type: "POST",
				url: base_url + 'Ajaxmethods/ajax_getFormatted_Price',
				data: {price: total },
				success: function(response) {
					
					_th.css("height", "auto");
					_th.html( response );
				}
		
			});
			
		   //$(this).find("tfoot tr:eq(1)")[8].html( total );
		   
		   
		   
        },
		
		"initComplete": function( settings, json  ){
			
			
			
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside' );		
			
			
			var _self	 = this;
			
			
			this.api().columns().every(function ( i, f ) 
			{
				
				var column = this;
				
				
				
				if ( i == 0 || i == 1 || i == 3 || i == 4 || i == 6 || i == 10 || i == 12 )
				{
					
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					
					
					
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
		
							column.search(val ? val : '', false, false).draw();
						}
					});
				}
			});
		}
	});
	
	
	$('#submit-filters').click(function(){
        table.draw();
    });
	
	
	$(".custominputs").html('<input type="text" name="created_at[from]" />');
	
	$('#tbl_records_serverside tbody').off('click', 'td.details-control');
	
	// Add event listener for opening and closing details
	$('#tbl_records_serverside tbody').on('click', 'td.details-control', function () {
		
		var tr = $(this).closest('tr');

		var row = table.row(tr);

		var tableId = 'posts-' + row.data().id;

	

		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(template(row.data())).show();
			ajax_manage_orders_view_records_INITIALIZE_TABLE(tableId, row.data());
			tr.addClass('shown');
			tr.next().find('td').addClass('no-padding bg-gray');
		}
			
	});
	
}


function ajax_manage_bulkmapping_view_records()
{
	try
	{
		var table = $('#tbl_records_serverside');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	var this_site			= "managebulkmapping/controls/view";
	var url 				= base_url + this_site;	
	var template 			= Handlebars.compile($("#details-template").html());
	
	var table = $('#tbl_records_serverside').DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
	   	dom: dataTableDOM_PARENT,
		processing: true,
		serverSide: true,
		order: [[ 2, "desc" ]],
		"ajax": {
            "url": url,
            "data": function ( d ) {
                d.vendor_id = $('select[name="vendor_id"]').val();
            }
        },
		//"bSortClasses": false,
		columns: [
			{data: 'checkbox', name: 'checkbox', "orderable":      false, "searchable":      false},
			
			{
				"className":      'details-control',
				"orderable":      false,
				"searchable":      false,
				"data":           null,
				"defaultContent": ''
			},
			
			{data: 'entity_id', name: 'entity_id'},
			{data: 'custom_name', name: 'custom_name'},
			{data: 'price', name: 'price'},
			
			{data: 'special_price', name: 'special_price'},
			{data: 'special_from_date', name: 'special_from_date'},
			{data: 'special_to_date', name: 'special_to_date'},
			
			{data: 'quantity', name: 'quantity', "orderable":      false, "searchable":      false},
			{data: 'type_id', name: 'type_id'},
			{data: 'categories', name: 'categories'},
			{data: 'status', name: 'status', "orderable":      false},
		],
		"fnDrawCallback": function (e) {
		
			render_icheckbox();
			//render_icheckbox_events();
			
			render_icheckbox_events( "mainCheckbox", "childCheckbox");
			
			
			
			$(".childCheckbox").on('ifChecked', function(event){
			  
				$(this).closest("tr").find("input[type='text'], input[type='number'], input[type='date']").attr("disabled", false);
			  
			});
			
			$(".childCheckbox").on('ifUnchecked', function(event){
			  
				$(this).closest("tr").find("input[type='text'], input[type='number'], input[type='date']").attr("disabled", true);
			  
			});
			
			
			
			
			
			
			
			
			
			
			
			selectize_inputs( 'selectize_readonly', 'readonly');
			
		},
		
		"createdRow": function (row, data, index) {
			
			if ( data.type_id == "simple" )
			{
				$(row).find("td").eq(1).removeClass("details-control");
				console.log($(row) );
			}
			
			startEndDatePicker( $(row).find("td").eq(6).find("input"), $(row).find("td").eq(7).find("input"));
			
		},
		
		"initComplete": function( settings, json  ){
		
		
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside' );		
			
			
			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) 
			{
				
				var column = this;
				
				
				if ( i == 0 || i == 1 || i == 8 )
				{
					
				}
				else if ( i == 11 )
				{
					 	
						
						var select = $('<select class="form-controll"><option value=""></option></select>')
							.appendTo( $(column.footer()).empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									
									
									$(this).val()
								);
		 
		 
		 						$(column.footer()).closest("tr").find("input,select").removeClass("selectedSearch");
								$(select).addClass("selectedSearch");
							
							
								column
									.search( val ? ''+val+'' : '', true, false )
									.draw();
							} );
		 				
						
						select.append( '<option value="Approved">Approved</option>' );
						select.append( '<option value="Not Approved">Not Approved</option>' );	
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
		
							column.search(val ? val : '', false, false).draw();
						}
					});
				}
			});
		}
	});
	
	
	$('select[name="vendor_id"]').on('change', function(e) {
		table.draw();
		e.preventDefault();
	});
	
	
	
	
	$('#tbl_records_serverside tbody').off('click', 'td.details-control');
	
	// Add event listener for opening and closing details
	$('#tbl_records_serverside tbody').on('click', 'td.details-control', function () {	
		
		var tr = $(this).closest('tr');
		var row = table.row(tr);
		var tableId = 'posts-' + row.data().id;	
		
		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(template(row.data())).show();
			ajax_manage_bulkmapping_view_records_INITIALIZE_TABLE(tableId, row.data());
			tr.addClass('shown');
			tr.next().find('td').addClass('no-padding bg-gray');
		}
			
	});
	
	
}

function ajax_manage_bulkmapping_view_records_INITIALIZE_TABLE(tableId, data)
{
	$('#' + tableId).DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_CHILD,
		processing: true,
		serverSide: true,
		ajax: data.details_url,
		columns: [
			{ data: 'products_checkbox', name: 'products_checkbox', searchable: false, orderable: false},
			{ data: 'product', name: 'product' },
			
			{ data: 'price', name: 'price'},
			{ data: 'quantity', name: 'quantity' },
			{ data: 'category', name: 'category' },
			//{ data: 'quantity', name: 'quantity' }
			
		],

		"fnDrawCallback": function (e) {
			
			var _DATA_ID			= $(this).attr("data-id");
			
			render_icheckbox( "maincheckbox_" + _DATA_ID);
			render_icheckbox( "childcheckbox_" + _DATA_ID);
			
			render_icheckbox_events( "maincheckbox_" + _DATA_ID, "childcheckbox_" + _DATA_ID);
			
			
			$(".childcheckbox_" + _DATA_ID).on('ifChecked', function(event){
			  
				$(this).closest("tr").find("input[type='text'], input[type='number'], input[type='date']").attr("disabled", false);
			  
			});
			
			$(".childcheckbox_" + _DATA_ID).on('ifUnchecked', function(event){
			  
				$(this).closest("tr").find("input[type='text'], input[type='number'], input[type='date']").attr("disabled", true);
			  
			});
			
			
			
			
			$( ".childcheckbox_" + _DATA_ID ).on('ifChecked', function(event){
			
				$(this).closest("table").closest("tr").prev().find(".childCheckbox").iCheck('check');

			});			
			
			$( ".childCheckbox" ).on('ifUnchecked', function(event){
			
				$(".childcheckbox_" + _DATA_ID).iCheck('uncheck');
				
			});		
			
			
			
			selectize_inputs("selectize_categories_" + _DATA_ID, "readonly");
		},
		"initComplete": function( settings, json  ){
			
			
			disableSubmitForm_onDataTableSearch(  $('#' + tableId) );
			dataTableSearchOnEnterKey( 'serverside', tableId );	

			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
				
				if ( i == 0 )
				{
					return;	
				}
			
			
				var input = document.createElement('input');
				$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
				$(input).addClass('form-control input-sm');
				
				$(input).appendTo($(column.footer()).empty())
				
				.on('keydown', function ( event ) {
					
					var keyCode = (event.keyCode ? event.keyCode : event.which);   
					
					if ( keyCode  == 13 )
					{
					
						//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
						//val.replace( _re_escape_regex, '\\$(this).val()' );


						//var val = escapeRegexDataTable($(this).val());
						
						var val = $.fn.dataTable.util.escapeRegex($(this).val());
	
						column.search(val ? val : '', false, false).draw();
					}
				});	
			
			});
			
			
	   }
	})

}





function ajax_manage_base_products_view_records()
{
	try
	{
		var table = $('#tbl_records_serverside');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	var this_site			= "managebaseproducts/controls/view";
	var url 				= base_url + this_site;	
	var template 			= Handlebars.compile($("#details-template").html());
	
	var table = $('#tbl_records_serverside').DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
	   	dom: dataTableDOM_PARENT,
		processing: true,
		serverSide: true,
		order: [[ 2, "desc" ]],
		"ajax": {
            "url": url,
            /*"data": function ( d ) {
                d.sellercenter_status = select_elem.val();
            }*/
        },
		//"bSortClasses": false,
		columns: [
			{data: 'checkbox', name: 'checkbox', "orderable":      false, "searchable":      false},
			
			{
				"className":      'details-control',
				"orderable":      false,
				"searchable":      false,
				"data":           null,
				"defaultContent": ''
			},
			
			{data: 'entity_id', name: 'entity_id'},
			{data: 'custom_name', name: 'custom_name'},
			{data: 'price', name: 'price', visible: false},			
			{data: 'type_id', name: 'type_id'},
			{data: 'categories', name: 'categories'},	
			{data: 'status', name: 'status', "orderable":      false},		
			{data: 'action', name: 'action', "orderable":      false, "searchable":      false}
		],
		"fnDrawCallback": function (e) {
		
			render_icheckbox();
			render_icheckbox_events();
			
			selectize_inputs( 'selectize_readonly', 'readonly');
			
		},
		
		"createdRow": function (row, data, index) {
			
			if ( data.type_id == "simple" )
			{
				$(row).find("td").eq(1).removeClass("details-control");
			}
			
			//$(row).find("td").eq(3).html( $(row).find("td").eq(3).find(".fullProductName").val() );
			
		},
		
		"initComplete": function( settings, json  ){
		
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside' );		
			
			
			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) 
			{
				
				var column = this;
				
				
				if ( i == 0 || i == 1 || i == 8 )
				{
					
				}
				else if ( i == 7 )
				{
					 	
						
						var select = $('<select class="form-control"><option value=""></option></select>')
							.appendTo( $(column.footer()).empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
		 
		 						$(column.footer()).closest("tr").find("input,select").removeClass("selectedSearch");
								$(select).addClass("selectedSearch");
							
							
								column
									.search( val ? ''+val+'' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );	
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
		
							column.search(val ? val : '', false, false).draw();
						}
					});
				}
			});
		}
	});
	
	$('#tbl_records_serverside tbody').off('click', 'td.details-control');
	
	// Add event listener for opening and closing details
	$('#tbl_records_serverside tbody').on('click', 'td.details-control', function () {	
		
		var tr = $(this).closest('tr');
		var row = table.row(tr);
		var tableId = 'posts-' + row.data().id;	
		
		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(template(row.data())).show();
			ajax_manage_base_products_view_records_INITIALIZE_TABLE(tableId, row.data());
			tr.addClass('shown');
			tr.next().find('td').addClass('no-padding bg-gray');
		}
			
	});
	
	
}

function ajax_manage_base_products_view_records_INITIALIZE_TABLE(tableId, data)
{
	$('#' + tableId).DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_CHILD,
		processing: true,
		serverSide: true,
		ajax: data.details_url,
		columns: [
		
			{ data: 'product', name: 'product' },
			{ data: 'price', name: 'price'},
			{ data: 'category', name: 'category' },
			//{ data: 'quantity', name: 'quantity' }
			
		],

		"fnDrawCallback": function (e) {
			

			render_icheckbox( "maincheckbox_" + $(this).attr("data-id"));
			render_icheckbox( "childcheckbox_" + $(this).attr("data-id"));
			
			render_icheckbox_events( "maincheckbox_" + $(this).attr("data-id"), "childcheckbox_" + $(this).attr("data-id"));
			
			selectize_inputs("selectize_categories_" + $(this).attr("data-id"), "readonly");
		},
		"initComplete": function( settings, json  ){
			
			
			disableSubmitForm_onDataTableSearch(  $('#' + tableId) );
			dataTableSearchOnEnterKey( 'serverside', tableId );	

			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
			
			
				var input = document.createElement('input');
				$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
				$(input).addClass('form-control input-sm');
				
				$(input).appendTo($(column.footer()).empty())
				
				.on('keydown', function ( event ) {
					
					var keyCode = (event.keyCode ? event.keyCode : event.which);   
					
					if ( keyCode  == 13 )
					{
					
						//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
						//val.replace( _re_escape_regex, '\\$(this).val()' );


						//var val = escapeRegexDataTable($(this).val());
						
						var val = $.fn.dataTable.util.escapeRegex($(this).val());
	
						column.search(val ? val : '', false, false).draw();
					}
				});	
			
			});
			
			
	   }
	})

}

function ajax_manage_vendor_products_view_records()
{
	try
	{
		var table = $('#tbl_records_serverside');
		table.DataTable().destroy();
		//table.empty();
	}
	catch (e)
	{
		
	}
	
	var this_site			= "managevendorsproducts/controls/view";
	var url 				= base_url + this_site;
	var template 			= Handlebars.compile($("#details-template").html());
	
	var table = $('#tbl_records_serverside').DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		processing: true,
		serverSide: true,
		       

		order: [[ 3, "desc" ]],
		"ajax": {
            "url": url,
            /*"data": function ( d ) {
                d.sellercenter_status = select_elem.val();
            }*/
        },
		//"bSortClasses": false,
		columns: [
			{data: 'checkbox', name: 'mageproductid', "orderable":      false},
			{
				"className":      'details-control',
				"orderable":      false,
				"searchable":     false,
				"data":           null,
				"defaultContent": ''
			},
			{data: 'fullnamewithprofileurl', name: 'fullnamewithprofileurl'},			
			{data: 'mageproductid', name: 'mageproductid'},
			{data: 'proname', name: 'proname'},
			{data: 'price', name: 'price',  "orderable":      false},
			{data: 'qty', name: 'qty',  "orderable":      false},
			{data: 'type_id', name: 'type_id',  "orderable":      false},
			{data: 'action', name: 'action', "orderable":      false, "searchable":      false}
		],
		"fnDrawCallback": function (e) {
		
			render_icheckbox();
			render_icheckbox_events();
			
			//selectize_inputs( 'selectize_readonly', 'readonly');
			
		},
		
		/*
		"rowCallback" : function( row, data, index ){
			if ( data[7] == "simple" ) {
			  $('td:eq(7)', row).html( '<b>simple</b>' );
			}
		},
		*/
		
		
		"createdRow": function (row, data, index) {
			
			if ( data.type_id == "simple" )
			{
				$(row).find("td").eq(1).removeClass("details-control");
			}
			
		},
		"initComplete": function( settings, json  ){
			
			
			
			disableSubmitForm_onDataTableSearch();
			dataTableSearchOnEnterKey( 'serverside' );		
			
			
			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) 
			{
				
				var column = this;
				
				if ( i == 0 || i == 1 || i == 8 )
				{
					
				}
				else if ( i == 7 )
				{
					 	
						
						var select = $('<select class="form-control"><option value=""></option></select>')
							.appendTo( $(column.footer()).empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
		 
		 						$(column.footer()).closest("tr").find("input,select").removeClass("selectedSearch");
								$(select).addClass("selectedSearch");
							
							
								column
									.search( val ? ''+val+'' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );	
				}
				else
				{
					var input = document.createElement('input');
					$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
					$(input).addClass('form-control input-sm');
					
					$(input).appendTo($(column.footer()).empty())
					
					.on('keydown', function ( event ) {
						
						var keyCode = (event.keyCode ? event.keyCode : event.which);   
						
						if ( keyCode  == 13 )
						{
						
							//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
							//val.replace( _re_escape_regex, '\\$(this).val()' );
	
	
							//var val = escapeRegexDataTable($(this).val());
							
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
							
							
							$(column.footer()).closest("tr").find("input,select").removeClass("selectedSearch");
							$(input).addClass("selectedSearch");
							
							column.search(val ? val : '', false, false).draw();
						}
					});
				}
			});
		}
	});
	
	$('#tbl_records_serverside tbody').off('click', 'td.details-control');
	
	// Add event listener for opening and closing details
	$('#tbl_records_serverside tbody').on('click', 'td.details-control', function () {	
		
		var tr = $(this).closest('tr');
		var row = table.row(tr);
		var tableId = 'posts-' + row.data().id;	
		
		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		} else {
			// Open this row
			row.child(template(row.data())).show();
			ajax_manage_vendor_products_view_records_INITIALIZE_TABLE(tableId, row.data());
			tr.addClass('shown');
			tr.next().find('td').addClass('no-padding bg-gray');
		}
			
	});
	
}

function ajax_manage_vendor_products_view_records_INITIALIZE_TABLE(tableId, data)
{
	$('#' + tableId).DataTable({
		"lengthMenu": JSON.parse(dataTableLENGTH_PARENT),
		dom: dataTableDOM_PARENT,
		processing: true,
		serverSide: true,
		ajax: data.details_url,
		columns: [
			{ data: 'products_checkbox', name: 'products_checkbox' },
			{ data: 'product', name: 'product' },
			{ data: 'price', name: 'price'},
			{ data: 'category', name: 'category' },
			{ data: 'quantity', name: 'quantity' }
			
		],

		"fnDrawCallback": function (e) {
			

			render_icheckbox( "maincheckbox_" + $(this).attr("data-id"));
			render_icheckbox( "childcheckbox_" + $(this).attr("data-id"));
			
			render_icheckbox_events( "maincheckbox_" + $(this).attr("data-id"), "childcheckbox_" + $(this).attr("data-id"));
			
			selectize_inputs("selectize_categories_" + $(this).attr("data-id"), "readonly");
		},
		"initComplete": function( settings, json  ){
			
			
			disableSubmitForm_onDataTableSearch(  $('#' + tableId) );
			dataTableSearchOnEnterKey( 'serverside', tableId );	

			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
			
				if ( i == 0 )
				{
					return;	
				}
			
				var input = document.createElement('input');
				$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
				$(input).addClass('form-control input-sm');
				
				$(input).appendTo($(column.footer()).empty())
				
				.on('keydown', function ( event ) {
					
					var keyCode = (event.keyCode ? event.keyCode : event.which);   
					
					if ( keyCode  == 13 )
					{
					
						//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
						//val.replace( _re_escape_regex, '\\$(this).val()' );


						//var val = escapeRegexDataTable($(this).val());
						
						var val = $.fn.dataTable.util.escapeRegex($(this).val());
	
						column.search(val ? val : '', false, false).draw();
					}
				});	
			
			});
			
			
	   }
	})

}


function ajax_manage_orders_view_records_INITIALIZE_TABLE(tableId, data) 
{
	
	$('#' + tableId).DataTable({
		
		"lengthMenu": JSON.parse(dataTableLENGTH_CHILD),
		dom: dataTableDOM_CHILD,
		
		processing: true,
		serverSide: true,
		ajax: data.details_url,
		columns: [
		
			{ data: 'vendor_name', name: 'vendor_name' },
			{ data: 'vendor_managers', name: 'vendor_managers' },
			{ data: 'category', name: 'category' },
			{ data: 'product', name: 'product' },
			{ data: 'quantity', name: 'quantity' },
			{ data: 'price', name: 'price'}
		],

		"fnDrawCallback": function (e) {
			

			render_icheckbox( "maincheckbox_" + $(this).attr("data-id"));
			render_icheckbox( "childcheckbox_" + $(this).attr("data-id"));
			
			render_icheckbox_events( "maincheckbox_" + $(this).attr("data-id"), "childcheckbox_" + $(this).attr("data-id"));
			
			selectize_inputs("selectize_categories_" + $(this).attr("data-id"), "readonly");
		},
		"initComplete": function( settings, json  ){
			
			
			disableSubmitForm_onDataTableSearch(  $('#' + tableId) );
			dataTableSearchOnEnterKey( 'serverside', tableId );	

			var _self	 = this;
			
			this.api().columns().every(function ( i, f ) {
				
				var column = this;
				
			
			
				var input = document.createElement('input');
				$(input).attr('placeholder', 'Search ' + $(_self).find('thead th').eq(i).html());
				$(input).addClass('form-control input-sm');
				
				$(input).appendTo($(column.footer()).empty())
				
				.on('keydown', function ( event ) {
					
					var keyCode = (event.keyCode ? event.keyCode : event.which);   
					
					if ( keyCode  == 13 )
					{
					
						//var _re_escape_regex = new RegExp( '(\\' + [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^', '-' ].join('|\\') + ')', 'g' );
						//val.replace( _re_escape_regex, '\\$(this).val()' );


						//var val = escapeRegexDataTable($(this).val());
						
						var val = $.fn.dataTable.util.escapeRegex($(this).val());
	
						column.search(val ? val : '', false, false).draw();
					}
				});	
			
			});
			
			
	   }
	})
}

function ajax_order_outbound_pickup_list( elem, only_view )
{
	
	if ( only_view == null || only_view == "undefined" )
	{
		only_view			= null;	
	}
	
	
	if ( elem.find("option:checked").length <= 0 && only_view == null)
	{
		_show_alert( 'red', 'Invalid Warehouse Selection.', 'Please select Warehouse(s)');
	}
	else
	{
		
		if ( only_view )
		{
			var option_all	= elem.attr( only_view );		

		}
		else
		{
			var option_all = elem.find("option:selected").map(function () {
				return $(this).val();
			}).get().join(',');
		}
		
		
		_waiting_screen( "show" );
		
		var this_site			= "manageorders/controls/ajax_order_outbound_pickup_list";
		var url 				= base_url + this_site;
		var pars 				= '';
		var target 				= '.targetBox';	
		
		$.ajax({
			type: "POST",
			url: url,
			data: {order_id: elem.attr("data-orderid"), product_id: elem.attr("data-productid"), quantity: elem.attr("data-quantity"), warehouse_id: option_all, url: this_site },
			success: function(response) {
				
				
				submit_action( response, target );
				
			}
		
		});
	}
	
	//_show_alert( 'red', 'Invalid Purchase Order Selection.', 'Please select Purchase Order(s)');
}


function ajax_submit_order_comment( _elem )
{
	if ( $("select[name='history[status]']").val() == "" )
	{
		_show_alert( 'red', 'Error', 'Please select comment status' );		
	}
	else
	{
	
		_waiting_screen( "show" );
		
	
		var this_site			= "Ajaxmethods/ajax_submit_order_comment/1/" + $("input[name='id']").val();
		var url 				= base_url + this_site;
		var pars 				= '';
		var target 				= '#order_history_block';	
		
		$.ajax({
			type: "POST",
			url: url,
			data: $("textarea[name='history[comment]'], input[name='history[is_customer_notified]'], input[name='history[is_visible_on_front]'], select[name='history[status]']").serializeArray(),
			success: function(response) {
				
				submit_action( response, target );
				
			}
	
		});
	}
}


function ajax_ship_order( _elem )
{
	
	_waiting_screen( "show" );
		

	var this_site			= "manageorders/controls/ajax_ship_order";
	var url 				= base_url + this_site;
	var pars 				= '';
	var target 				= '#...';	
	var _order_id			= _elem.attr("data-orderid");
	
	
	$.ajax({
		type: "POST",
		url: url,
		data: { order_id:  _order_id, url: this_site},
		success: function(response) {
			
			submit_action( response, target );
			
		},
		error: function (xhr, textStatus, error)
		{
			
			
			//console.log( e.status);
			_show_alert( 'red', textStatus, error);
		
		
		
			_waiting_screen( "hide" );
		}

	});
	
}


function ajax_invoice_order( _elem )
{
	
	_waiting_screen( "show" );
		

	var this_site			= "manageorders/controls/ajax_invoice_order";
	var url 				= base_url + this_site;
	var pars 				= '';
	var target 				= '#...';	
	var _order_id			= _elem.attr("data-orderid");
	
	
	$.ajax({
		type: "POST",
		url: url,
		data: { order_id:  _order_id, url: this_site},
		success: function(response) {
			
			submit_action( response, target );
			
		},
		error: function (xhr, textStatus, error)
		{
			//console.log( e.status);
			_show_alert( 'red', textStatus, error);
			_waiting_screen( "hide" );
		}

	});
	
}

function ajax_hold_order( _elem )
{
	
	_waiting_screen( "show" );
		

	var this_site			= "manageorders/controls/ajax_hold_order";
	var url 				= base_url + this_site;
	var pars 				= '';
	var target 				= '#...';	
	var _order_id			= _elem.attr("data-orderid");
	
	
	$.ajax({
		type: "POST",
		url: url,
		data: { order_id:  _order_id, url: this_site},
		success: function(response) {
			
			submit_action( response, target );
			
		},
		error: function (xhr, textStatus, error)
		{
			//console.log( e.status);
			_show_alert( 'red', textStatus, error);
			_waiting_screen( "hide" );
		}

	});
	
}


function ajax_creditmemo_order( _elem )
{
	
	_waiting_screen( "show" );
		

	var this_site			= "manageorders/controls/ajax_creditmemo_order";
	var url 				= base_url + this_site;
	var pars 				= '';
	var target 				= '#...';	
	var _order_id			= _elem.attr("data-orderid");
	
	
	$.ajax({
		type: "POST",
		url: url,
		data: { order_id:  _order_id, url: this_site},
		success: function(response) {
			
			submit_action( response, target );
			
		},
		error: function (xhr, textStatus, error)
		{
			//console.log( e.status);
			_show_alert( 'red', textStatus, error);
			_waiting_screen( "hide" );
		}

	});
	
}



function ajax_create_dashboard_graph( _elem )
{
	
	//_waiting_screen( "show" );
	
	$(".overlay").show();
	$(".loading-img").show();
		
	var graph_array				= ['tab_orders', 'tab_amounts', 'totals'];
	
	for ( var i = 0; i < graph_array.length; i++ )
	{
		var this_site			= "managedashboard/controls/ajax_create_dashboard_graph/" + graph_array[i];
		var url 				= base_url + this_site;
		var pars 				= '';
		var target 				= '#' + graph_array[i];	
		var _order_id			= _elem.attr("data-orderid");
		
		
		$.ajax({
			type: "POST",
			url: url,
			async: false,
			data: { order_id:  _order_id, url: this_site, period: _elem.val()},
			success: function(response) {
				
				submit_action( response, target, graph_array, graph_array[i] );
				
			},
			error: function (xhr, textStatus, error)
			{
				//console.log( e.status);
				_show_alert( 'red', textStatus, error);
				_waiting_screen( "hide" );
			}
	
		});
		
	}
}

function vendor_order_product_confirmation( elem, item_id )
{
	if ( elem.val() == "0" )
	{
		$("tr.crossdock_new_quantity_" + item_id).hide();
	}
	else
	{
		$("tr.crossdock_new_quantity_" + item_id).show();
	}
}

function limit_checkbox_values( limit_value )
{
	$("input[type='checkbox']").on('ifChecked', function(event){
		
		if ( $("input[type='checkbox']:checked").length >= limit_value )
		{
			$("input[type='checkbox']").not( $("input[type='checkbox']:checked") ).iCheck('disable');
		}
		
	});	
	
	
	$("input[type='checkbox']").on('ifUnchecked', function(event){
	  
	  	if ( $("input[type='checkbox']:checked").length < limit_value )
		{
			$("input[type='checkbox']").not( $("input[type='checkbox']:checked") ).iCheck('enable');
		}
		
	});
}


function confirmSubmit( submit_btn )
{
	$.jAlert({
		'title': 'Confirmation',
		'content': '<p style="font-size: 15px; text-align: center;">Are you sure want to reset UID(s)?</p>',
		'theme': 'blue',
		'showAnimation': 'bounceIn',
		'hideAnimation': 'fadeOut',
		'closeOnClick': true,
		'btns': [
			{'text':'Yes', 'theme': 'green', 'closeOnClick': false, 'onClick': function(){  submit_btn.closest('form').submit(); } },
			{'text':'No', 'theme': 'black', 'closeOnClick': true }
		],
		'onOpen': function(alert)
		{
		
		}
	});	
}

function popWin(url,win,para) {
    var win = window.open(url,win,para);
    win.focus();
}

function confirm_submit( submit_btn, title, message )
{
	
	$.jAlert({
		'title': title,
		'content': '<p style="font-size: 15px; text-align: center;">'+ message +'</p>',
		'theme': 'blue',
		'showAnimation': 'bounceIn',
		'hideAnimation': 'fadeOut',
		'closeOnClick': true,
		'btns': [
			{'text':'Yes', 'theme': 'green', 'closeOnClick': false, 'onClick': function(){  
				
				submit_btn.attr("onclick", "");
				submit_btn.attr("type", "submit");
				submit_btn.click(); 
				
			}},
			{'text':'No', 'theme': 'black', 'closeOnClick': true }
		],
		'onOpen': function(alert)
		{
		
		}
	});	
}


function disableOtherInputs( elem )
{
	$("#my-orders-table select, #my-orders-table input, #my-orders-table textarea").not( elem.closest("tbody").find("input, select, textarea") ).attr("disabled", true);
	elem.attr("onclick", "" );
	elem.attr("type", "submit");
	elem.click();
}

function random_char( length )
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < length; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function progress_dialog( show_or_hide, progress, progress_report, other_text )
{
	if ( show_or_hide == null || show_or_hide == "undefined" )
	{
		show_or_hide			= false;	
	}
	
	if ( progress == null || progress == "undefined" )
	{
		progress			= false;	
	}
	
	if ( progress_report == null || progress_report == "undefined" )
	{
		progress_report			= false;	
	}
	
	if ( other_text == null || other_text == "undefined" )
	{
		other_text				= false;	
	}
	
	
	if ( progress )
	{
		$('#pleaseWaitDialog .modal-header h3').html( progress + "% Complete" );
		$('#pleaseWaitDialog .modal-body .progress .progress-bar').css("width", progress + "%");
	}
	if ( progress_report )
	{
		$('#pleaseWaitDialog .modal-header small.progressReport').show();
		$('#pleaseWaitDialog .modal-header small.progressReport a').attr("href", progress_report);
	}
	if ( other_text )
	{
		$('#pleaseWaitDialog .modal-header div.otherText').show();
		$('#pleaseWaitDialog .modal-header div.otherText').html( other_text );
	}
	
	
	if ( show_or_hide )
	{
		if ( show_or_hide == "show")
		{
			$('#pleaseWaitDialog').modal({  
				backdrop: 'static',  
				keyboard: true
			});		
			
		}
		else
		{
			$('#pleaseWaitDialog').modal('hide');	
		}
	}
	else
	{
		
	}
	
	
}

function ajax_associate_product_with_vendor( )
{
	_waiting_screen("hide");
			
	if ( $(".box-body.table-responsive form")[0].checkValidity() )
	{
	
		var _checked_elems				= $("input.childCheckbox[type='checkbox']:checked").not(  $("input[name='select_all']") );
		var _file_name					= random_char(5) + ".txt";
		
		if ( _checked_elems.length > 100 )
		{
			var _each_iteration_progress	= _checked_elems.length / 100;
		}
		else
		{
			var _each_iteration_progress	= 100 / _checked_elems.length;
		}
		//var _each_iteration_progress	= _checked_elems.length / 100;
	
		if ( _checked_elems.length > 0 )
		{
			
			progress_dialog("show");
			
			//_waiting_screen( "show" );
			
			var _ids				= Array();
			_checked_elems.each(function(){
				_ids.push( $(this).val() );
			});
	
			var this_site			= "managebulkmapping/controls/ajax_associate_product_with_vendor";
			var url 				= base_url + this_site;
			var pars 				= '';
			var target 				= '.targetBox';	
			var _errors				= "";
			for ( var i = 0; i < _ids.length; i++ )
			{
				
				var _this_PID		= _ids[i];
				var _params			= $(".box-body.table-responsive form").serialize() + '&product_ids='+_ids+'&this_PID='+_this_PID+'&url'+this_site + "&filename=" + _file_name;
				var _current_index	= i;
				$.ajax({
					type: "POST",
					async: false,
					url: url,
					data:  _params,
					success: function(response) {
						
						var __form			= document.createElement("form");
						$(__form).append( response );
						
						
						
						$.ajax({
							type: "POST",
							async: false,
							url: url + "/1",
							data:  _params + "&" + $(__form).serialize(),
							success: function(response) {
								
								
								progress_dialog(false, (_current_index + 1) * _each_iteration_progress);
								
								//submit_action( response, '' );
								
							},
							error: function (xhr, textStatus, error)
							{
								_errors		+=  "There are some errors on sending request for Item# " + _this_PID + " ...("+ textStatus+") - ("+ error +") <br>";
								//console.log( e.status);
								//_show_alert( 'red', textStatus, error);
								//progress_dialog(false, false, base_url + "public/files/ajax_associate_product_with_vendor/" + _file_name, "There are some errors on sending request...("+ textStatus+") - ("+ error +") <br><a href='"+ base_url + 'managebulkmapping/controls/view' +"'>Click here to refresh page<a>" );
							}
					
						});	
						
						
					},
					
					error: function (xhr, textStatus, error)
					{
						_errors		+=  "There are some errors on sending request for Item# " + _this_PID + " ...("+ textStatus+") - ("+ error +") <br>";
						//console.log( e.status);
						//_show_alert( 'red', textStatus, error);
						//progress_dialog(false, false, base_url + "public/files/ajax_associate_product_with_vendor/" + _file_name, "There are some errors on sending request...("+ textStatus+") - ("+ error +") <br><a href='"+ base_url + 'managebulkmapping/controls/view' +"'>Click here to refresh page<a>" );
					}
			
				});	
				
				
			}
			
			
			progress_dialog(false, false, base_url + "public/files/ajax_associate_product_with_vendor/" + _file_name, _errors + "<a href='"+ base_url + 'managebulkmapping/controls/view' +"'>Click here to refresh page<a>" );
		}
		else
		{
			_show_alert( 'red', 'Invalid Product Selection.', 'Please select Product(s)');
		}
	}
	return false;
}


$(document).ready(function(){	
	
	
	
	

	if ( $('.chosen-select-deselect').length > 0 )
	{
		var chosenConfig			= {'.chosen-select-deselect'  : {allow_single_deselect:true}}
		for (var selector in chosenConfig) 
		{
			$(selector).chosen(chosenConfig[selector]);
		}
		
		/*
		$('.chosen-select-deselect').chosen().change(function() {
			
			if ( controller == "managebulkmapping/" )
			{
				console.log($(this).val());
			}
			
			
			//$('#' + $(this).val()).show();
		});
		*/
	}
	
	$("a[data-toggle='tab']").click(function(){
		
		if( $("input[name='_a_href_tab_address']").length > 0 )
		{
			$("input[name='_a_href_tab_address']").val( $(this).attr("href") );	
		}
		
	});
	
	
	var _URL_HASH			= window.location.hash;
	
	if ( $("input[name='_a_href_tab_address']").length > 0 )
	{
		if ( $("input[name='_a_href_tab_address']").val().length > 1 )
		{
			_URL_HASH		= $("input[name='_a_href_tab_address']").val();
		}
	}
	
	if ( _URL_HASH != "" )
	{
		if ( _URL_HASH.substr(0,5) == "#tab_" )
		{
			$("a[href='"+ _URL_HASH +"'").click();
		}
	}

	
	$("td").removeClass("label");
	
	$("input[type='submit'], button[type='submit']").click(function(){
		$(this)[0].disable	= true;
	});
	
	if ( $('.slimScroll').length > 0 )
	{
		$('.slimScroll').slimScroll({
			height: '250px'
		});	
	}
	
	$("input[type='submit'], button[type='submit']").click(function(){
		
		//$(this).addClass("disabled");
		_waiting_screen("show");
		
	});
	
	$(".jQuery_cancel_order").click(function(){
		
		
	});
	
	
	$("body").on("click", ".btn_Ajax_Request", (function( e ){
		
		e.preventDefault();
		
		
		
		_waiting_screen( "show" );
		
		var _form				= $(this).closest("form");
		var this_site			= _form.attr("action");
		var url 				= this_site;
		var pars 				= '';
		var target 				= '#...';	
		var _ajax_request_btn	= $(this);
		
		
		$.ajax({
			type: "POST",
			url: url,
			data: _form.serialize() + "&" + $(this).attr("name") + "=1",
			success: function(response) {
				
				submit_action( response, target, '.targetDIV', _ajax_request_btn );
				
			}
	
		});
		
		
		return false;
		
	}) );
	



	if ( controller == "manageinventory/" && $("select[name='sellercenter_status']").length > 0 ) 
	{
		if ( $("select[name='sellercenter_status']").val() != "" )
		{
			ajax_delivery_receipts_view_records( $("select[name='sellercenter_status']") );	
		}
		
		
	}
	
	
	//VIEW
	if ( controller == "managebulkproductsdelete/" && $("input[name='open_node_treeview']").length > 0 )
	{
		var _empty_input		= $ ( document.createElement("input") );
		
		load_treeview	( 	$(".load_category_treeview"), 
							base_url + "managecategory/controls/Treeview_get_category/baseproduct_vendorproducts_count",
							base_url + "managecategory/controls/Treeview_move_category",
							_empty_input,
							_empty_input.val(),
							true,
							false,
							true,
							$("input[name='open_node_treeview']").val()
						);
	}
	
	
	
	if ( controller == "manageorders/" && $("input[name='vendor_id']").length > 0 )
	{		
		ajax_manage_orders_view_records( $("input[name='vendor_id']") );
	}
	
	
	if ( controller == "manageorders/" && $("table#my-orders-table").length > 0 )
	{		
		$("#my-orders-table tr[data-productid]").each(function(){
	
			var _select			= $("select[name='vendor_order_product["+ $(this).attr("data-productid") +"][ready_to_ship]']");
			
			vendor_order_product_confirmation( _select, $(this).attr("data-productid")  );
		
		});
	}
	
	
	if( controller == "managebulkmapping/"  && $("table#tbl_records_serverside").length > 0 )
	{

		ajax_manage_bulkmapping_view_records();
		
		$(".submit_btn").click(function( e ){
			
			ajax_associate_product_with_vendor();
			e.preventDefault();
			
		});
		
		
		
	}
	
	
	
	if( controller == "managebaseproducts/"  && $("table#tbl_records_serverside").length > 0 )
	{
		ajax_manage_base_products_view_records();
	}
	
	if( controller == "managevendorsproducts/"  && $("table#tbl_records_serverside").length > 0 )
	{
		ajax_manage_vendor_products_view_records();
	}
	

	
	
	
	
	
	//*** Init Reports Grid ***/
	if ( controller == "managereportsales/" )
	{	
		ajax_manage_sale_reports_view_records();
	}

	if ( controller == "managereportcustomers/" )
	{	
		ajax_manage_customers_view_records();
	}
	
	if ( controller == "managereportaccountstatement/" )
	{	
		ajax_managereportaccountstatement_view_records( $("select[name='vendor_id']") );
	}

	if ( controller == "managereportaccount/" )
	{	
		var params, vendor_id, categories_id, date_from, date_to;		
		
		if( $('select[name="vendor_id"]').length > 0 ){
			vendor_id			= $('select[name="vendor_id"]').val();
		}
		
		if( $("input[name='vendor_id']").length > 0 ){
			vendor_id			= $("input[name='vendor_id']").val();
		}
		
		params 		= "params=1?vendor_id="+vendor_id;
		ajax_manage_dispatched_orders_view_records(params);
	}
	
	
});



function unblockSubmit(id) 
{
	$(id).on('focus', function(event) {
		if ($('button[class="scalable update-button disabled"]').size() > 0) 
		{
			enableElements('#submit-button');
		}
	});
}

function enableElement(elem) 
{
    $(elem)[0].disabled = false;
    $(elem).removeClass('disabled');
}

function disableElements(search)
{
    $('.' + search).each( function(){
	
		disableElement( this );
		
	});
}

function disableElement(elem) 
{
    $(elem)[0].disabled = true;
    $(elem).addClass('disabled');
}



function enableElements(search){
    $('.' + search).each(function(){
	
		enableElement( this );
		
	});
}


	