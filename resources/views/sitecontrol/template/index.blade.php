@include("sitecontrol.template._head")
<body class="skin-blue">
@include("sitecontrol.template._header")


    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                	<h1>Processing...</h1>
                    <h3>0% Complete</h3>
                    <small style="display:none;" class="progressReport"><a target="_blank" href="javascript:;">Progress Report</a></small>
                    <div class="otherText" style="display:none;"></div>
                </div>
                
                <div class="modal-body">
                    <div class="progress  progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <span class="sr-only">0% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="wrapper row-offcanvas row-offcanvas-left">
        @include("sitecontrol.template._left")
        <aside class="right-side">
            <section class="content-header">
                <h1> {{ $_heading }} </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box mainFrame">
                            <div class="box-header">
                            </div>
    
                            <div class="box-body table-responsive">
                                @include("sitecontrol.template._show_messages")
                                @include($_pageview)
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
    </div>

	<script type="text/javascript">
        $("textarea.ckeditor1").each(function(){
            CKEDITOR.replace( $(this).attr("name"),
                    {
                        filebrowserBrowseUrl :'{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Connector=") !!}{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php") !!}',
                        filebrowserImageBrowseUrl : '{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=") !!}{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php") !!}',
                        filebrowserFlashBrowseUrl :'{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=") !!}{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php")!!}',
                        filebrowserUploadUrl  :'{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=File") !!}',
                        filebrowserImageUploadUrl : '{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image") !!}',
                        filebrowserFlashUploadUrl : '{!! URL::to("public/assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash") !!}'
                    });
        });
    </script>
@yield('scripts')


</body>



</html>