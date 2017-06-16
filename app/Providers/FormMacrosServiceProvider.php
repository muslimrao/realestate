<?php
namespace App\Providers;

use App\Http\Helpers\GeneralHelper;
use Form;
use HTML;
use Route;
use \App\Http\Library\RoleManagement;
use Illuminate\Support\ServiceProvider;

class FormMacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::macro('unique_formid', function () {
            return Form::hidden('unique_formid', GeneralHelper::set_value("unique_formid", str_random(40)) );
        });
		
	Form::macro('options', function ( $optionsValue ) {
            return Form::hidden('options', $optionsValue );
        });
        
        Form::macro('add', function ( $url, $_directory ) {
            
            
            if ( RoleManagement::if_Allowed( $_directory, 'add' ) )
            {            
                return  '<a href="'. $url. '">'
                        . '<input data-operation="add" type="button" class="btn btn-warning btn-flat submit_btn_form" value="' . trans('general_lang.txt_add') . '"  />'
                        . '</a>';
            }
            return '';
            
        });
        
        Form::macro('delete', function ($_directory) {
            
            if ( RoleManagement::if_Allowed( $_directory, 'delete' ) )
            {
                return  '<input data-operation="delete" type="button" class="btn btn-danger btn-flat submit_btn_form" value="'. trans('general_lang.txt_delete') . '" />';
            }
            
            return '';
            
        });
        
        Form::macro('save', function ($_directory, $second_attr = array()) {
            

            if ( RoleManagement::if_Allowed( $_directory, 'save' ) )
            {
				$first_attr			= array('class' => 'btn btn-warning btn-flat');
				$attr				= array_merge($first_attr, $second_attr);
				
                return  Form::submit('Save', $attr);
            }
            
            return '';
            
        });
        
		Form::macro('save_e', function ($_directory, $second_attr = array()) {
            
            //if ( RoleManagement::if_Allowed( $_directory, 'save' ) )
            //{
				$first_attr			= array('class' => 'btn btn-warning btn-flat', 'name' => 'save_and_edit');
				$attr				= array_merge($first_attr, $second_attr);
				
                return  Form::submit('Save &amp; Edit', $attr);
            //}
            
            //return '';
            
        });
		
		Form::macro('save_a', function ($_directory, $second_attr = array()) {
            
            //if ( RoleManagement::if_Allowed( $_directory, 'save' ) )
            //{
				$first_attr			= array('class' => 'btn btn-warning btn-flat', 'name' => 'save_and_add_new');
				$attr				= array_merge($first_attr, $second_attr);
				
                return  Form::submit('Save &amp; Add New', $attr);
            //}
            
            //return '';
            
        });
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}