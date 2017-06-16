<?php

namespace App\Http\Controllers\Sitecontrol\Auth;


use App\Http\Controllers\My_controller;
use App\Http\Library\CustomHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Auth;
use \App\Http\Helpers\DropdownHelper;
use \Illuminate\Support\Facades\Session;
use Config;


#require_once 'Zend/Validate/Interface.php';

class LoginController extends MY_controller
{


	
    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
        parent::__construct();


		
        $this->data                               = $this->default_data();
        $this->data['_pagepath']                  = $this->data["admin_path"] . "auth/login";
        $this->data['_pagetitle']                 = "Please Login - ";
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function getLogin()
    {
        return view($this->data['_pagepath'], $this->data);
    }

    
    
    public function postLogin( Request $request )
    {
    
		/*$flight = new \App\Admin;

        $flight->email	= "fairsit.m@gmail.com";
		$flight->password = \Hash::make( "admin123" );
		$flight->username = "muslimrao";
		$flight->status = 1;

        $flight->save();
		*/
	
		
        $validator = Validator::make($request->all(), [
            "email"     => "required|email|useremailexist:email|logincredentialsifactive:email,password,is_active",
            "password"  => "required"
        ]);
        
        if ($validator->fails())
        {
            return view($this->data['_pagepath'], $this->data)->with("errors", $validator->messages());
        }
        else
        {
			
			


            $credentials        = array("email"     => $request->input("email"), "password" => $request["password"] ) ;

            if ( Auth::guard( Config::get('constants.GUARD_SUPERADMIN') )->attempt ( $credentials ) )
            {
                return redirect('sitecontrol/managemyaccount/controls/edit/' . Auth::guard(Config::get('constants.GUARD_SUPERADMIN'))->ID());
            }
            else
            { 
                return redirect()->back();
            }


        }        
    
	
	

    }
	
	
	public function getLogout( Request $request )
	{

		Auth::logout(); // logs out the user 	
		Auth::guard('customer')->logout(); // logs out the user 	
		
		$request->session()->flush();



		return redirect( '/' );
	}



	public function postForgotPassword( Request $request )
    {
        $this->data['_pagepath']                  = "sitecontrol/forgotpassword";
        $this->data['_pagetitle']                 = "Forgot Password - ";

        
		if ( $request->isMethod('post') )
		{
			
     
			if ( $request->is_vendor )
			{
				$request->request->add(['is_active' => 1]);
				
				$validator = Validator::make($request->all(), [
					"email"     => "required|email|customerisvendor:is_active,$this->mage_defaultWebsiteId",
				]);
	
				$input_labelName = array(
					'email'     => "Email"
				);
	
				$validator->setAttributeNames($input_labelName);
				
				if ($validator->fails())
				{
					#$this->data['_messageBundle']			= $this->_messageBundle('danger' , $validator->messages(), 'Error!', TRUE, TRUE);
					#return redirect('/') ->withErrors($validator->messages())->withInput();
	
					return view($this->data['_pagepath'], $this->data)->with("errors", $validator->messages());
				}
				else
				{
	
	
					$customer = Mage::getModel("customer/customer"); 
					$customer->setWebsiteId( $this->mage_defaultWebsiteId ); 
					$customer->loadByEmail( $request["email"] ); //load customer by email id 
				 
					
					$_new_password      = str_random(10);
					$customer->setPassword( $_new_password );
					$customer->save();
			  
	
	
	
					#to_user / bcc_admin
					$request->request->add(['login_link' => url("login") ]);
					$request->request->add(['password' => $_new_password ]);
					$email_template				= array("email_to"				=> $request["email"],
														"email_heading"			=> 'Forgot Password',
														"email_file"			=> "email/sellercenter/forgot_password",
														"email_subject"			=> 'Forgot Password',
														"default_subject"		=> TRUE,
														"email_post"			=> Input::all());
	
					$is_email_sent				= $this->_send_email( $email_template );
					#to_user / bcc_admin
	
	
	
					$this->_messageBundle('success' , array(trans("email/forgot_password.text_forgotpassword_thankyou")), trans("email/forgot_password.text_forgotpassword"), false, true);
	
					return redirect ( "/" );
	
				}
				
				
			}
			else
			{
				$validator = Validator::make($request->all(), [
					"email"     => "required|email|useremailexist",
				]);
	
				$input_labelName = array(
					'email'     => "Email"
				);
	
				$validator->setAttributeNames($input_labelName);
	
	
	
	
				if ($validator->fails())
				{
					#$this->data['_messageBundle']			= $this->_messageBundle('danger' , $validator->messages(), 'Error!', TRUE, TRUE);
					#return redirect('/') ->withErrors($validator->messages())->withInput();
	
					return view($this->data['_pagepath'], $this->data)->with("errors", $validator->messages());
				}
				else
				{
	
	
	
	
					//$TMP_user->getData()[0]["user_id"]
	
					$TMP_user           = $this->Mage->getModel('admin/user')->getCollection()->addFieldToFilter('email', $request["email"] )->addFieldToFilter('is_active', 1);
	
	
	
					$_new_password      = str_random(10);
					$updateData			= array("user_id"               => $TMP_user->getData()[0]["user_id"],
												"password"				=> $_new_password,
												"email"					=> $request["email"] );
	
	
	
	
					$saveData           = $this->Mage->getModel('admin/user')->load( $TMP_user->getData()[0]["user_id"] );
					$saveData->addData( $updateData );
					$saveData->save();
	
	
	
	
	
					#to_user / bcc_admin
					$request->request->add(['login_link' => url("login") ]);
					$request->request->add(['password' => $_new_password ]);
					$email_template				= array("email_to"				=> $request["email"],
														"email_heading"			=> 'Forgot Password',
														"email_file"			=> "email/sellercenter/forgot_password",
														"email_subject"			=> 'Forgot Password',
														"default_subject"		=> TRUE,
														"email_post"			=> Input::all());
	
					$is_email_sent				= $this->_send_email( $email_template );
					#to_user / bcc_admin
	
	
	
					$this->_messageBundle('success' , array(trans("email/forgot_password.text_forgotpassword_thankyou")), trans("email/forgot_password.text_forgotpassword"), false, true);
	
					return redirect ( "/" );
	
				}
			}
			
		}
		else
		{
			return view($this->data['_pagepath'], $this->data); #->with("errors", $validator->messages());	
		}
        
 
    }


}
