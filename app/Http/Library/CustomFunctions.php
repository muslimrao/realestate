<?php
namespace App\Http\Library;

use App\Http\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Input;
use Mage;
use DNS1D;
use DNS2D;
use PDF;

use App\Http\Helpers\DropdownHelper;

class CustomFunctions  {

	static function getDataTableLENGTH()
	{
		return 	json_encode( [[10, 25, 50, -1], [10, 25, 50, "All"]] );
	}
	
	
	static function getDataTableDOM( $custom_syntax = false, $other_syntax = false, $show_custom_datatable_loader = TRUE )
	{
		if ( $custom_syntax )
		{
			$MultiArray			= $custom_syntax;	
			
		
		}
		else
		{
			$MultiArray			= array	( 
											array	( 
														array(	"size"		=> 6,
																"value"		=> "l"),
																
														array(	"size"		=> 6,
																"value"		=> "f" )
													),
											
											
											array	( 
														array(	"size"		=> 6,
																"value"		=> "i"),
																
														array(	"size"		=> 6,
																"value"		=> "p" )
													),
													
											array	( 
														array(	"size"		=> 12,
																"value"		=> "t"),
																
														array(	"size"		=> 12,
																"value"		=> "r" )
													),
															
											array	( 
														array(	"size"		=> 6,
																"value"		=> "i"),
																
														array(	"size"		=> 6,
																"value"		=> "p" )
													),
													
											
									);
			
		}

		
		$syntax_code		= '';
		foreach ($MultiArray as $i => $v)
		{
			
			$syntax_code		.= '<"row"';
			foreach ( $v as $index => $value )
			{
				if ( $value['value'] == "r" and $show_custom_datatable_loader)
				{
					$syntax_code	.= '<"col-sm-'. $value['size'] .' datatTable_lock_loader"'.$value['value'].'>';
				}
				else
				{
					$syntax_code	.= '<"col-sm-'. $value['size'] .'"'.$value['value'].'>';	
				}
				
				
				
			}
			$syntax_code		.= ">";
		}

	}

		
	function generateQRcode($text=false)
	{
		$text = md5($text);
		return 'data:image/png;base64,' . DNS2D::getBarcodePNG($text, "QRCODE",5,5);
	}


 
 	public function redirect_after_save( $request, $redirect_to_default, $redirect_to_add, $redirect_to_edit)
	{
		if( $request->save_and_add_new )
		{
			$uri = $redirect_to_add;
			
		} else if ( $request->save_and_edit )
		{
			
			$uri = $redirect_to_edit;
		}
		else {
			
			$uri = $redirect_to_default;
		}
		
		return $uri;
		
	}	
	

}