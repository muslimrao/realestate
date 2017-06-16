<link href="{{ URL::asset("public/assets/admincms/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/jQueryUI/jquery-ui-1.10.3.custom.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/morris/morris.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/daterangepicker/daterangepicker-bs3.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/AdminLTE.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/iCheck/all.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/bootstrap-timepicker.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/datatables/new/datatables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset("/public/assets/admincms/css/datatables/new/buttons.dataTables.min.css") }}">
<link href="{{ URL::asset("/public/assets/admincms/css/colorpicker/bootstrap-colorpicker.min.css") }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ URL::asset("/public/assets/widgets/colorbox/example1/colorbox.css") }}" />
<link href="{{ URL::asset("/public/assets/admincms/css/bootstrap.dropup.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/custom_icheck.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset("/public/assets/admincms/css/style.css") }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset("/public/assets/widgets/jAlert-master/jAlert.css") }}" />
<link rel="stylesheet" href="{{ URL::asset("/public/assets/widgets/treelist/dist/themes/default/style.css") }}" />
<link href="{{ URL::asset("/public/assets/admincms/css/magento.css") }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset( "/public/assets/widgets/selectize.js-master/dist/css/selectize.default.css") }}">
<link rel="stylesheet" href="{{ URL::asset( "/public/assets/widgets/chosen/chosen.css") }}">




<script>
    var site_url								= '{!! URL::to('/') . "/" !!}';
    var controller								= '{!! $_directory !!}';
	var _format_price							= '{!! GeneralHelper::format_price(FALSE, TRUE) !!}'

    var base_url 								= '{!! URL::to('/') . "/" !!}';
    var lang_folder                             = "";
    var is_post 								= '{!! Request::isMethod("post") !!}';
	var redirect_after_5_seconds				= '{!! Request::session()->get('redirect_after_5_seconds') !!}';
	var redirect_url							= '{!! Request::session()->get('redirect_url')  !!}';
	var closeColorbox							= '{!! Request::session()->get('closeColorbox')  !!}';
	
	var dataTableDOM_PARENT						= '{!! $dataTableDOM_PARENT  !!}';
	var dataTableDOM_CHILD						= '{!! $dataTableDOM_CHILD  !!}';
	
	var dataTableLENGTH_PARENT					= '{!!  $dataTableLENGTH_PARENT  !!}';
	var dataTableLENGTH_CHILD					= '{!! $dataTableLENGTH_CHILD  !!}';

	
	
	
</script>


<script src="{{ URL::asset("/public/assets/widgets/jquery-ui-1.11.1.custom/external/jquery/jquery.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/widgets/jquery-ui-1.11.1.custom/jquery-ui.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!--<script src="{{ URL::asset("/public/assets/admincms/js/plugins/morris/morris.min.js")  }}" type="text/javascript"></script>-->
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/sparkline/jquery.sparkline.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/jqueryKnob/jquery.knob.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/daterangepicker/daterangepicker.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/iCheck/icheck.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/AdminLTE/app.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/AdminLTE/dashboard.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/AdminLTE/demo.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/bootstrap-timepicker.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/ckeditor/ckeditor.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/colorpicker/bootstrap-colorpicker.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/widgets/colorbox/jquery.colorbox.js") }}"></script>
<script src="{{ URL::asset("/public/assets/widgets/jquery_blockUI/jquery.blockUI.js") }}"></script>
<script src="{{ URL::asset( "/public/assets/widgets/selectize.js-master/dist/js/standalone/selectize.js") }}"></script>
<script src="{{ URL::asset( "/public/assets/widgets/selectize.js-master/dist/js/standalone/selectize_plugin.js") }}"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/jquery.dataTables.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/datatables.bootstrap.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/handlebars.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/dataTables.buttons.min.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/jszip.min.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/pdfmake.min.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/vfs_fonts.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ URL::asset("/public/assets/admincms/js/plugins/datatables/new/buttons.html5.min.js") }}"></script>
<script src="{{ URL::asset("/public/assets/widgets/jAlert-master/jAlert.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/widgets/jAlert-master/jAlert-functions.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/widgets/treelist/dist/jstree.js?t=1") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/flot/jquery.flot.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/flot/jquery.flot.resize.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/flot/jquery.flot.pie.min.js") }}" type="text/javascript"></script>      
<script src="{{ URL::asset("/public/assets/admincms/js/plugins/flot/jquery.flot.categories.min.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/widgets/chosen/chosen.jquery.js") }}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/site.js") }}?t={!! strtotime('now') !!}" type="text/javascript"></script>
<script src="{{ URL::asset("/public/assets/admincms/js/site2.js") }}?t={!! strtotime('now') !!}" type="text/javascript"></script>