<?php
namespace App\Http\Library;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\MY_controller;
use App\Http\Helpers\GeneralHelper;

class CustomValidator extends \Illuminate\Validation\Validator {

	
	function validateuseremailexist( $attribute, $value )
	{
		if ( \App\Admin::where("email", Input::only($attribute))->count() > 0)
		{
			return TRUE;
		}
		
		return FALSE;
		
	}
	
	function validateallarrayhavevalues( $attribute, $value, $format )
	{
		$is_PASS		= TRUE;
		
		foreach (Input::only($attribute)[$attribute] as $index => $value)
		{
			if ( $value == "" )
			{
				$is_PASS		= FALSE;
				break;	
			}
			
			
			if ( in_array("notnumeric", $format) )
			{
				if ( $value == "0" )
				{
					
					$is_PASS		= FALSE;
					break;	
				}
			}
		}
		
		return $is_PASS;
	}
	
	function validatedatecheck($attribute, $value, $format)
	{
		
		$format						= $format[0];
		$str						= $value;
		if ( !$format ) 
		{
			$format					= "dd-mm-yyyy";	
		}
		
		if ( $format == "dd-mm-yyyy" )
		{
			if (preg_match ("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $str, $parts))
			{
				//check weather the date is valid of not    
				
				$day			= $parts[1];
				$month			= $parts[2];
				$year			= $parts[3];
				
				/* 
				// for yyyy-mm-dd  
				$day       		= $parts[3];
				$month 			= $parts[2];
				$year        	= $parts[1];
				*/
				
				// checking 4 valid date
				
				if(checkdate($month,$day,$year))
				{
					return TRUE;	
				}
			}
		}
		else if ( $format == "yyyy-mm-dd" )
		{
			
			if (preg_match ("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str, $parts))
			{
				//check weather the date is valid of not    
				
	
				// for yyyy-mm-dd  
				$day       		= $parts[2];
				$month 			= $parts[1];
				$year        	= $parts[0];
				
				
				// checking 4 valid date
				if(checkdate($month,$day,$year))
				{
					return TRUE;	
				}
			}
		}
		
		#$this->form_validation->set_message('validate_date_check', "%s is not a valid date, use $format format");
		return FALSE;
	}  
	
	function validatedatetimecheck($attribute, $value, $format)
	{
		//Array Index:
		//1- What input you are given 
		//2- Seperator
		
		
		$EXPLODE_attributes					= $format[0];
		
		
		$TMP_return_text					= TRUE;
		switch ( $EXPLODE_attributes )
		{
			case "H:i:s":
					$TMP_return_text		= GeneralHelper::verify_time_format( $value );
				break;
				
			default:
				break;
		}
		
		if ( !$TMP_return_text )
		{
			return FALSE;
		}
		else
		{
			return TRUE;	
		}
		
	}  
	
	

    public function validatelogincredentialsifactive($attribute, $value, $parameters)
    {
		

        $input              = Input::all();
        $credentials        = array (	
										$parameters[0] 	=> $input[$parameters[0]],
                                        $parameters[1] 	=> $input[$parameters[1]],
                                        'status' 		=> 1,
                                    
									);
		

        if ( Auth::guard('admin')->validate( $credentials ))
        {
            return TRUE;
		}
		
		return FALSE;
    }

    public  function validatetrim($attribute, $value)
    {
        return trim( $value );
    }

    public function validateConfirmCurrentLoggedinPassword( $attribute, $value )
    {
        $credentials        = array("email"             => Auth::user()->email,
                                    "password"          => $value ) ;
        if ( Auth::validate( $credentials ) )
        {
            return TRUE;
        }

        return FALSE;
    }

	
}