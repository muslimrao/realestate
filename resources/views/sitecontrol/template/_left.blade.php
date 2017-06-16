<style>
    li.active > a.text-yellow{ font-weight:bold !important;} /*color:#ffca1e !important; */
</style>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar left-side sidebar-offcanvas" style="display:;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            	@if ( Session::get("loggedin_details.logo_image") != "" )
                <?php /*<img src="{!! \Magento::getMediaURL( "avatar/" ) . Session::get("loggedin_details.logo_image") !!}" class="img-circle" alt="User Image" /> */?>
                @endif
            </div>
            <div class="pull-left info">
                
                <p>Hello, {!! Session::get("loggedin_details.name") !!}</p>
                	
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form" onsubmit="return false;">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..." autocomplete="off" />
                <span class="input-group-btn">
                    <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            
            
            @if ( RoleManagement::if_Allowed( 'managecommissions' ) )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Commissions</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{!! URL::to('managecommissions/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage General Commissions</span>
                        </a>
                    </li>

                </ul>
            </li>
            @endif

            
            @if ( RoleManagement::if_Allowed( 'managecategory' ) )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Category</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{!! URL::to('managecategory/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Category</span>
                        </a>
                    </li>
                    
                    
                    <li>
                        <a href="{!! URL::to('managemuslim/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Muslim</span>
                        </a>
                    </li>
                    

                </ul>
            </li>
            @endif
            
            
            @if ( RoleManagement::if_Allowed( 'manageusers' ) )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{!! URL::to('manageusers/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Users</span>
                        </a>
                    </li>

                </ul>
            </li>
            @endif

            
            @if ( RoleManagement::if_Allowed( 'managevendors' )  || RoleManagement::if_Allowed( 'managemappingvendors' )  )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Vendors</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if ( RoleManagement::if_Allowed( 'managevendors' )  )
                    <li>
                        <a href="{!! URL::to('managevendors/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Vendors</span>
                        </a>
                    </li>
                    @endif

                    @if ( RoleManagement::if_Allowed( 'managemappingvendors' )  )
                    <li>
                        <a href="{!! URL::to('managemappingvendors/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Mapping Vendors</span>
                        </a>
                    </li>
                    @endif
                    
                    
                    @if ( RoleManagement::if_Allowed( 'managevendorcategoriescommissions' )  )
                    <li>
                        <a href="{!! URL::to('managevendorcategoriescommissions/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Vendor Categories / Commissions</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>
            @endif
            
            @if ( RoleManagement::if_Allowed( 'managewarehouse' ) || RoleManagement::if_Allowed( 'managewarehouselocation' )  )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Warehouse</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if ( RoleManagement::if_Allowed( 'managewarehouse' )  )
                    <li>
                        <a href="{!! URL::to('managewarehouse/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Warehouse</span>
                        </a>
                    </li>
                    @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managewarehouselocation' )  )
                    <li>
                        <a href="{!! URL::to('managewarehouselocation/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Warehouse Location</span>
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </li>
            @endif
            
            
            
            @if ( RoleManagement::if_Allowed( 'managevendorsproducts' ) || RoleManagement::if_Allowed( 'managerequestconsignmentpickup' ) || RoleManagement::if_Allowed( 'managepurchaseorders' )  || RoleManagement::if_Allowed( 'managecsvproducts' ) || RoleManagement::if_Allowed( 'managebaseproducts' ) )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Products</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if ( RoleManagement::if_Allowed( 'managebaseproducts' )  )
                    <li>
                        <a href="{!! URL::to('managebaseproducts/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Base Products</span>
                        </a>
                    </li>
                    @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managevendorsproducts' )  )
                    <li>
                        <a href="{!! URL::to('managevendorsproducts/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Vendor Products</span>
                        </a>
                    </li>
                    @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managerequestconsignmentpickup' )  )
                    <li>
                        <a href="{!! URL::to('managerequestconsignmentpickup/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Request Consignment Pickup</span>
                        </a>
                    </li>
                    @endif
                    
                    
                    @if ( RoleManagement::if_Allowed( 'managepurchaseorders' )  )
                    <li>
                        <a href="{!! URL::to('managepurchaseorders/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Purchase Orders</span>
                        </a>
                    </li>
                    @endif
                          
                          
					@if ( RoleManagement::if_Allowed( 'managebulkmapping' ) )
                    <li>
                        <a href="{!! URL::to('managebulkmapping/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Bulk Mapping</span>
                        </a>
                    </li>
                    @endif
                                  
                    
                    @if ( RoleManagement::if_Allowed( 'managecsvproducts' ) )
                    <li>
                        <a href="{!! URL::to('managecsvproducts/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>CSV Upload</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            
            
            
            @if ( RoleManagement::if_Allowed( 'manageinventory' ) || RoleManagement::if_Allowed( 'managewarehouselocationinventory' ) )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Inventory</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    @if ( RoleManagement::if_Allowed( 'manageinventory' )  )
                    <li>
                        <a href="{!! URL::to('manageinventory/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Inventory</span>
                        </a>
                    </li>
                    @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managewarehouselocationinventory' )  )
                    <li>
                        <a href="{!! URL::to('managewarehouselocationinventory/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Warehouse Location Inventory</span>
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </li>
            @endif
            
            
            
            @if ( RoleManagement::if_Allowed( 'manageorders' )  )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Orders</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    @if ( RoleManagement::if_Allowed( 'manageorders' )  )
                    <li>
                        <a href="{!! URL::to('manageorders/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Orders</span>
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </li>
            @endif
            
            @if ( RoleManagement::if_Allowed( 'managereportsales' ) )
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Reports</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                	@if ( RoleManagement::if_Allowed( 'managereportaccountstatement' ) )
                    <li>
                        <a href="{!! URL::to('managereportaccountstatement/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Reports - Account Statement</span>
                        </a>
                    </li>
		            @endif
                    
                    
                    @if ( RoleManagement::if_Allowed( 'managereportsales' ) )
                    <li>
                        <a href="{!! URL::to('managereportsales/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Reports - Sale Report</span>
                        </a>
                    </li>
		            @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managereportcustomers' ) )
                    <li>
                        <a href="{!! URL::to('managereportcustomers/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Reports - Customers</span>
                        </a>
                    </li>
		            @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managereportaccount' ) )
                    <li>
                        <a href="{!! URL::to('managereportaccount/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>                            
                            <span>Reports - Dispatched Orders</span>
                            <!--<span>Reports - Account Statement (Dispatched Orders)</span>-->
                        </a>
                    </li>
		            @endif
                    
                    <!--
                    <li>
                        <a href="{!! URL::to('managecyclecount/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>                            
                            <span>Cycle Count</span>
                        </a>
                    </li>
		            -->
                </ul>
            </li>
            @endif
            
            @if ( RoleManagement::if_Allowed( 'managerolesidentifier' ) || RoleManagement::if_Allowed( 'managerolespermissions' )  || RoleManagement::if_Allowed( 'manageconfigurationsettings')  || RoleManagement::if_Allowed( 'managemyaccount')  )            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Tools / Settings</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                
                	@if ( RoleManagement::if_Allowed( 'managesellercenterstatus' ) )
                    <li>
                        <a href="{!! URL::to('managesellercenterstatus/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage SellerCenter Status</span>
                        </a>
                    </li>   
                    @endif
                    
                    
                    @if ( RoleManagement::if_Allowed( 'managerolesidentifier') )
                    <li>
                        <a href="{!! URL::to('managerolesidentifier/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Roles Identifier</span>
                        </a>
                    </li>   
                    @endif
                    
                    @if ( RoleManagement::if_Allowed( 'managerolespermissions' )  )
                    <li>
                        <a href="{!! URL::to('managerolespermissions/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Roles Permissions</span>
                        </a>
                    </li>   
                    @endif
                    
                    
                    
                    @if ( RoleManagement::if_Allowed( 'manageconfigurationsettings' )  )
                    <li>
                        <a href="{!! URL::to('manageconfigurationsettings/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage Configuration Settings</span>
                        </a>
                    </li>
                    @endif

                    
                    @if ( RoleManagement::if_Allowed( 'managemyaccount' ) )
                    <li>
                        <a href="{!! URL::to('managemyaccount/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Manage My Account</span>
                        </a>
                    </li>
                    @endif
                    
                    
                    @if ( RoleManagement::if_Allowed( 'managedashboard' ) )
                    <li>
                        <a href="{!! URL::to('managedashboard/controls/view') !!}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a target="_blank" href="">
                            <i class="fa fa-angle-double-right"></i>
                            <span>view site</span>
                        </a>
                    </li>



                </ul>
            </li>
            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>