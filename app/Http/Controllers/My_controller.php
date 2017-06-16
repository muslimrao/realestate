<?php namespace App\Http\Controllers;

use App\Http\Helpers\SessionHelper;
use App\Tmp_Images_Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use \App\Http\Library\RoleManagement;
use App\Http\Helpers\GeneralHelper;
use Mage_Catalog_Model_Category;
use Mage_Core_Model_File_Uploader;
use Exception;
use Mage;
use DB;


class MY_controller extends Controller
{


	
    public function __construct()
    {
		

        //$this->middleware('auth');
    }



    public function default_data()
    {
		$data["admin_path"]										= "sitecontrol/";
        $data["_pagetitle"]										= "";
        $data["_pageview"]                                      = "";
        $data['_messageBundle']									= $this->_messageBundle('', '');
		
		$data['dataTableDOM_PARENT']							= \App\Http\Library\CustomFunctions::getDataTableDOM	();
		$data['dataTableDOM_CHILD']								= \App\Http\Library\CustomFunctions::getDataTableDOM	();
		
		
		$data['dataTableLENGTH_PARENT']							= \App\Http\Library\CustomFunctions::getDataTableLENGTH	();
		$data['dataTableLENGTH_CHILD']							= \App\Http\Library\CustomFunctions::getDataTableLENGTH	();
        
        $data['_messageBundle_unauthorized']                     = $this->_messageBundle('danger' , trans("general_lang.not_authorized_message"), trans("general_lang.not_authorized_heading"));
        
		
		
		
        $this->default_data_extend( $data );

        return  $data;
    }

    public function _messageBundle(  $class = FALSE, $msg = FALSE, $heading = '', $jAlert = false, $inline_alert = false)
    {

        $data['_ALERT_mode']			= "";
        $data['_call_name']				= "";
        $data['_redirect_to']			= "";
		
		
		if ( $heading == "use_as_ajax_content" )
		{
			$msg								= $msg;
		}
		else
		{
			if ( is_object($msg) )
			{
				#$TMP_messages                   = "<ul>";
	
	
				foreach ($msg->all() as $a =>$message)
				{
	
					$TMP_messages               .= "<p>" . $message . "</p>";
				}
				#$TMP_messages                   .= "</ul>";
				$msg                            = $TMP_messages;
			}
			else if ( is_array( $msg ) )
			{
				foreach ($msg as $a =>$message)
				{
	
					$TMP_messages               .= "<p>" . $message . "</p>";
				}
				
				$msg                            = $TMP_messages;
			}
		}


        if ( $jAlert and !$inline_alert)
        {
            $data['_ALERT_mode']			= "inline";
            $data['_CSS_show_messages']		= $class;
            $data['_TEXT_show_messages']	= $msg;
            $data['_HEADING_show_messages']	= $heading;

            return $data;
        }
        else if ($inline_alert)
        {

            Session::flash('_flash_data_inline', TRUE);
            Session::flash('_flash_messages_type', $class);
            Session::flash('_flash_messages_content', $msg);
            Session::flash('_flash_messages_title', $heading);
        }
        else
        {

            $data['_CSS_show_messages']		= $class;
            $data['_TEXT_show_messages']	= $msg;
            $data['_HEADING_show_messages']	= $heading;

            return $data;
        }
    }


    public function default_data_extend( &$data )
    {
        return $data;
    }


    public function _auth_current_logged_in_ID( $compare_with, $guard = "" )
    {
		if ( \Auth::guard( $guard )->check() )
		{
			if ( $compare_with == Auth::guard( $guard )->ID() )
			{
				return TRUE;
			}	
		}
		

        return FALSE;
    }

    public function setAttributeNames(array $attributes)
    {
        $this->customAttributes = $attributes;

        return $this;
    }

    public function upload_image(UploadFileRequest $request, &$validator, $config_controls, $thumb_controls, $other_controls, $BOOL = FALSE)
    {
        $destinationPath                                = $config_controls['upload_path'];


        //in return 1 means Image uploaded: 2 means hdn_field upload: 3 means Error
        $_POST[$other_controls["input_field"]]          = $other_controls["input_field"];


        if (!array_key_exists('id', $other_controls))
        {
            $other_controls['id']				= strtotime("now");
        }

        if (!array_key_exists('thumb', $other_controls))
        {
            $other_controls['thumb']			= FALSE;
        }

        if (!array_key_exists('validate', $other_controls))
        {
            $other_controls['validate']			= FALSE;
        }

        if (!array_key_exists('db_field', $other_controls))
        {
            $other_controls['db_field']			= "";
        }

        if (!array_key_exists('hdn_field', $other_controls))
        {
            $other_controls['hdn_field']		= "";
        }

        if (!array_key_exists('input_nick', $other_controls))
        {
            $other_controls['input_nick']		= "";
        }
        
        if (!array_key_exists('only_validate', $other_controls))
        {
            $other_controls['only_validate']		= FALSE;
        }




        $upload_image_array						= array();
        $saveData['id']							= $other_controls['id'];
        $db_field								= $other_controls['db_field'];
        $input_field							= $other_controls['input_field'];


        $FILE_uploaded                                  = TRUE;

	
		if ( $other_controls['is_multiple'] and isset($_FILES[$other_controls["input_field"]]) ) 
		{
				
				// getting all of the post data
				$files 						= Input::file( $other_controls["input_field"] );
				// Making counting of uploaded images
				$file_count 				= count($files);
				
				// start count how many uploaded
				$errorCount 				= 0;
				
				$collect_HIDDEN_ARRAY		= array();
				if ( is_array( $request[$other_controls['hdn_field']]  ) )
				{
					foreach ( $request[$other_controls['hdn_field']]   as $key => $value)
					{

						if ( $value != "" )
						{
							$explode_value								= explode("/", $value);
							$collect_HIDDEN_ARRAY[]["file_name"]		= $explode_value[ count($explode_value) - 1 ];
						}
					}
				}
				
				
				if ( $errorCount == 0 and "validate_REQUIRED" )
				{
					foreach($files as $file) 
					{
						$rules 						= array($other_controls["hdn_field"] => 'trim' . $other_controls['validate']); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
						
						
						$image_validation 			= Validator::make(array($other_controls["hdn_field"] => $file), $rules);
						
						$input_labelName 			= array(
							$other_controls["hdn_field"]            => $other_controls['input_nick']
						);
		
					 
						$image_validation->setAttributeNames($input_labelName);
						
						if ($image_validation->fails() and count($collect_HIDDEN_ARRAY) <= 0)
						{
							$errorCount++;
							$upload_image_array             = array("error"             => 3,
																	"reason"            => "upload_error",
																	"msg"               => $image_validation->messages());
	
							$validator->after(function ($validator, $o, $i) use ($other_controls, $image_validation) {
								$validator->errors()->add($other_controls["hdn_field"], $image_validation->errors()->first($other_controls["hdn_field"]));
							});
							
							break;
						}
						
		
		
						/*
						if($image_validation->passes())
						{
							
							$destinationPath 		= 'uploads';
							$filename = $file->getClientOriginalName();
							$upload_success = $file->move($destinationPath, $filename);
							$uploadcount ++;
							
						}
						*/
					}
				}
				
				if ( $errorCount == 0 and "validate_MIME" )
				{
					foreach($files as $file) 
					{
						$rules 						= array($other_controls["hdn_field"] => 'trim' . '|mimes:' . $config_controls['allowed_types']); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
						$image_validation 			= Validator::make(array($other_controls["hdn_field"] => $file), $rules);
						
						$input_labelName 			= array(
							$other_controls["hdn_field"]            => $other_controls['input_nick']
						);
		
					 
						$image_validation->setAttributeNames($input_labelName);
						
						if ($image_validation->fails())
						{
							$errorCount++;
							$upload_image_array             = array("error"             => 3,
																	"reason"            => "upload_error",
																	"msg"               => $image_validation->messages());
	
							$validator->after(function ($validator, $o, $i) use ($other_controls, $image_validation) {
								$validator->errors()->add($other_controls["hdn_field"], $image_validation->errors()->first($other_controls["hdn_field"]));
							});
							
							break;
						}
						
		
		
						/*
						if($image_validation->passes())
						{
							
							$destinationPath 		= 'uploads';
							$filename = $file->getClientOriginalName();
							$upload_success = $file->move($destinationPath, $filename);
							$uploadcount ++;
							
						}
						*/
					}
				}
				
				
				
				if ( $errorCount  == 0)
				{
                    if ( $other_controls['only_validate'] )
                    {
                        $upload_image_array     = array("error"             => 1,
                                                        "reason"            => "pass",
                                                        "hdn_array"         => "Only Validate");
                    }
                    // checking file is valid.
                    else if (  $errorCount == 0 )
                    {
						$uploadcount = 0;
						$imgData	= array();
						
						foreach($files as $file) 
						{
							
							if ( $file )
							{
								$extension              = $file->getClientOriginalExtension(); // getting image extension
								$fileName               = rand(0, 9999999999999999) . '.' . $extension; // renameing image
		
		
								$TMP_input              = $file->move($destinationPath, $fileName); // uploading file to given path
		
								$imgData[]                = array("file_name" => $TMP_input->getBasename());
																
								$uploadcount ++;
							}
						}
					
						
						$imgData				= array_merge( $imgData, $collect_HIDDEN_ARRAY);
						
						
					
						
						$upload_image_array     = array("error"             => 1,
														"reason"            => "pass",
														"hdn_array"         => $imgData);
	
                       
                    }
                    else
                    {
                        $upload_image_array     = array("error"             => 3,
                                                        "reason"            => "upload_error",
                                                        "msg"               => $other_controls["input_nick"] . " is not Valid");


                        $validator->after(function ($validator, $o, $i) use ($other_controls, $image_validation, $upload_image_array) {
                            $validator->errors()->add($other_controls["hdn_field"], $upload_image_array["msg"]);
                        });
                    }
                	
				}
			

		}
				
        else if (  !$other_controls['is_multiple'] and isset($_FILES[$other_controls["input_field"]]) )
        {
			
            if ($_FILES[$other_controls["input_field"]]["name"] != "" )
            {

                $file       = array($other_controls["hdn_field"] => Input::file($other_controls["input_field"]));
                $rules      = array($other_controls["hdn_field"] => 'trim' . $other_controls['validate'] . '|mimes:' . $config_controls['allowed_types']); //mimes:jpeg,bmp,png and for max size max:10000


                // doing the validation, passing post data, rules and the messages
                $image_validation = Validator::make($file, $rules);


                $input_labelName = array(
                    $other_controls["hdn_field"]            => $other_controls['input_nick']
                );

             
                $image_validation->setAttributeNames($input_labelName);
                
                if ($image_validation->fails())
                {
                    $upload_image_array             = array("error"             => 3,
                                                            "reason"            => "upload_error",
                                                            "msg"               => $validator->messages());


                    $validator->after(function ($validator, $o, $i) use ($other_controls, $image_validation) {
                        $validator->errors()->add($other_controls["hdn_field"], $image_validation->errors()->first($other_controls["hdn_field"]));
                    });

                }
                else
                {
                    if ( $other_controls['only_validate'] )
                    {
                        $upload_image_array     = array("error"             => 1,
                                                        "reason"            => "pass",
                                                        "hdn_array"         => "Only Validate");
                    }
                    // checking file is valid.
                    else if (Input::file($other_controls["input_field"])->isValid() )
                    {
                        $extension              = Input::file($other_controls["input_field"])->getClientOriginalExtension(); // getting image extension
                        $fileName               = rand(0, 9999999999999999) . '.' . $extension; // renameing image


                        $TMP_input              = Input::file($other_controls["input_field"])->move($destinationPath, $fileName); // uploading file to given path

                        $imgData                = array($other_controls["db_field"] => $TMP_input->getBasename());

                        $upload_image_array     = array("error"             => 1,
                                                        "reason"            => "pass",
                                                        "hdn_array"         => $imgData);
                    }
                    else
                    {
                        $upload_image_array     = array("error"             => 3,
                                                        "reason"            => "upload_error",
                                                        "msg"               => $other_controls["input_nick"] . " is not Valid");


                        $validator->after(function ($validator, $o, $i) use ($other_controls, $image_validation, $upload_image_array) {
                            $validator->errors()->add($other_controls["hdn_field"], $upload_image_array["msg"]);
                        });
                    }
                }
            }
            else
            {
                $FILE_uploaded                          = FALSE;
            }
        }

        if ( ! $FILE_uploaded )
        {
		
            if ($request[$other_controls['hdn_field']] != '')
            {
                $imgData	= array($db_field => $request[$other_controls['hdn_field']], 'id'	=> @$saveData['id']);


                $upload_image_array			= array("error"		    =>	2,
                                                    "reason"	    => "hidden",
                                                    "hdn_array"	    =>	$imgData);
            }
            else if ($other_controls['validate'])
            {
				
                $upload_image_array			= array("error"	        =>	3,
                                                    "reason"	    => "upload_error",
                                                    "msg"	        =>	"The " . $other_controls["input_nick"] . " field is required");

                $validator->after(function ($validator, $o, $i) use ($other_controls, $image_validation, $upload_image_array) {
                    $validator->errors()->add($other_controls["hdn_field"], $upload_image_array["msg"]);
                });

            }
            else
            {
                $upload_image_array			= array("error"	        =>	0,
                                                    "reason"	    => "none",
                                                    "msg"	        =>	'');

            }


        }

        $upload_image_array["upload_path"]				= $config_controls['upload_path'];
        $upload_image_array["hdn_field"]				= $other_controls['hdn_field'];
        $upload_image_array["db_field"]					= $other_controls['db_field'];
        $upload_image_array["tmp_table_field"]			= $other_controls['tmp_table_field'];
        //$upload_image_array["validator"]                = $validator;

        return $upload_image_array;
    }
    
    public function upload_image_magento( UploadFileRequest $request, $other_controls = false )
    {
   
        try
        {
            if ( $other_controls['custom_array']['error'] == '1' )
            {
                $img1               = rand(1,99999) . $request -> file( $other_controls["input_field"] )->getClientOriginalName();

                $target             = Mage::getBaseDir(). $other_controls['upload_path'];

                $uploader           = new Mage_Core_Model_File_Uploader( $other_controls["input_field"] );


                $uploader->setAllowedExtensions( explode( ",", $other_controls['allowed_types'] ) );
                $uploader->setAllowCreateFolders(true);
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $saved              = $uploader->save($target,$img1);
            
            }
            else
            {
                
                $HIDDEN_field       = explode(".", $other_controls['custom_array']['hdn_field']);
                if ( count($HIDDEN_field) > 1 )
                {
                    $_1 = $HIDDEN_field[0];
                    $_2 = $HIDDEN_field[1];
                    
                    $img1       = $request->input($_1)[ $_2 ];
                }
                else
                {
                    $img1       = $request->$other_controls['custom_array']['hdn_field'];
                }
        
                
            }
            
            $TMP_return        = array("return"     => TRUE,
                                        "message"   => $img1);
        } 
        catch (Exception $e) 
        {
           
            $TMP_return         = array("return"        => FALSE,
                                        "message"       => $e->getMessage() );
            
        }
        
        return $TMP_return;
        
    }

    public function tmp_record_uploads_in_db( Request $request, $linked_with_path, $tmp_upload_image_1 = array(), $is_multiple = FALSE )
    {

        #$linked_with_path			= FALSE;
        if ( $is_multiple )
        {
			
			
            $tmp_record				= Tmp_Images_Upload::where("unique_formid", $request["unique_formid"]);
			
            $images_array			= array();



            if ( $tmp_upload_image_1["error"] == "1" and $tmp_upload_image_1["reason"] == "pass" )
            {
				
                foreach ( $tmp_upload_image_1["hdn_array"] as $key => $value )
                {

                    $i						= $value["file_name"];
                    if ( $linked_with_path  )
                    {
                        $i					= $tmp_upload_image_1["upload_path"] . $value["file_name"];
                    }

                    $images_array[]			= $i;

                }
				
				 $request->request->add([$tmp_upload_image_1["hdn_field"] => $images_array]);
            }
            else if ( $tmp_upload_image_1["error"] == "2" and $tmp_upload_image_1["reason"] == "hidden" )
            {
				die("fafa");


                foreach ( $tmp_upload_image_1["hdn_array"][ $tmp_upload_image_1["db_field"] ] as $key => $value )
                {

                    if ( $value != "" )
                    {
                        $i						= $value;


                        $images_array[]			= $i;
                    }

                }


                $_POST[ $tmp_upload_image_1["hdn_field"] ]					= $images_array;

            }



        }
        else
        {


            if ( $tmp_upload_image_1["error"] == "1" and $tmp_upload_image_1["reason"] == "pass" )
            {



                #$tmp_record		= $this->db->query( "SELECT * FROM tb_tmp_images_upload WHERE unique_formid = '". $this->input->post("unique_formid") ."'" );
                $tmp_record     = Tmp_Images_Upload::where("unique_formid", $request["unique_formid"]);


                $i						= $tmp_upload_image_1["hdn_array"][ $tmp_upload_image_1["db_field"] ];
                if ( $linked_with_path  )
                {
                    $i					= $tmp_upload_image_1["upload_path"] . $tmp_upload_image_1["hdn_array"][  $tmp_upload_image_1["db_field"]  ];
                }





                #if ( $tmp_record -> num_rows() > 0 )
                if ( $tmp_record->count() > 0)
                {
                    print_r($tmp_record->getId());
                    die;
                    $insert_id				= $tmp_record->row("id");



                    $insert_upload_file		= array($tmp_upload_image_1[ "tmp_table_field" ]					=> $i,
                        "unique_formid"												=> $this->input->post("unique_formid"),
                        "id"														=> $insert_id);



                    $this->queries->SaveDeleteTables($insert_upload_file, 'e', "tb_tmp_images_upload", 'id');
                    $_POST[ $tmp_upload_image_1["hdn_field"] ]				= $i;
                }
                else
                {

                    $insert_upload_file		= array($tmp_upload_image_1[ "tmp_table_field" ]			=> $i,
                                                    "unique_formid"										=> $request["unique_formid"]);

                    $TT = new Tmp_Images_Upload();
                    $TT->save($insert_upload_file);

                    $request->request->add([$tmp_upload_image_1["hdn_field"] => $i]);

                    $_POST[ $tmp_upload_image_1["hdn_field"] ]				= $i;

                }

            }
        }
    }


    public function email( $e )
    {

		#return TRUE;
	
        require_once('./public/assets/widgets/phpmailer/class.phpmailer.php');
        if ( Session::get("site_settings.EMAIL_MODE") == "smtp" )
        {

            try
            {

                $mail 							= new \PHPMailer();
                $mail->IsSMTP(); 				// telling the class to use SMTP
                $mail->IsHTML(true);


                if ( 1==1 )
                {
                    $mail->Host						= "smtp.1and1.com"; // SMTP server
                    $mail->Username					= "muslim.raza@genetechsolutions.com"; // SMTP account username
                    $mail->Password   				= "admin123";    // SMTP account password
                    $mail->From						= 'muslim.raza@genetechsolutions.com';
                    $mail->Port						= 25;
                    $mail->FromName					= $e['from_name'];
                }



                $mail->CharSet					= "UTF-8"; // <-- Put right encoding here
                $mail->SMTPAuth					= true;            // enable SMTP authentication




                $mail->Subject					= $e['subject'];

                if ($e['email_attachment'] != "" )
                {
                    $mail->AddAttachment( $e['email_attachment'] );
                }

                $mail->MsgHTML($e['message']);



                if ( is_array($e['to']))
                {
                    if ( count( $e['to'] ) > 0 )
                    {
                        foreach ($e['to'] as $to_email )
                        {
                            if ( $to_email != '')
                            {
                                $mail->AddAddress( trim( $to_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->AddAddress($e['to']);
                }




                if ( is_array($e['bcc']))
                {
                    if ( count( $e['bcc'] ) > 0 )
                    {
                        foreach ($e['bcc'] as $bcc_email )
                        {
                            if ( $bcc_email != '')
                            {
                                $mail->AddBCC( trim( $bcc_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->AddBCC($e['bcc']);
                }

                #$mail->AddBCC("muslim.raza@genetechsolutions.com", '');
                $mail->AddBCC("fairsit.m@gmail.com", '');


                $a = $mail->Send();
			
                return TRUE;
            }
            catch (phpmailerException $e)
            {

                /*
                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->errorMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');

                return false;
                */
            }
            catch (Exception $e)
            {
                /*

                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->getMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');
                */
                return false;
            }


        }
        else
        {
            $mail = new \PHPMailer(true);

            try
            {
                #$mail->AddAddress($e['to']);
                $mail->FromName		= $e['from_name'];//'MissionTree';
                $mail->From			= $e['from'];//'qateam786@gmail.com';
                $mail->CharSet		= "UTF-8"; // <-- Put right encoding here
                $mail->Subject		= $e['subject'];




                if ( is_array($e['to']))
                {
                    if ( count( $e['to'] ) > 0 )
                    {
                        foreach ($e['to'] as $to_email )
                        {
                            if ( $to_email != '')
                            {
                                $mail->AddAddress( trim( $to_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->AddAddress($e['to']);
                }




                if ( is_array($e['bcc']))
                {
                    if ( count( $e['bcc'] ) > 0 )
                    {
                        foreach ($e['bcc'] as $bcc_email )
                        {
                            if ( $bcc_email != '')
                            {
                                $mail->AddBCC( trim( $bcc_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->AddBCC($e['bcc']);
                }



                #$mail->AddBCC("muslim.raza@genetechsolutions.com", '');
                $mail->AddBCC("fairsit.m@gmail.com", '');


                $mail->IsHTML(true);
                $mail->MsgHTML($e['message']);
                $mail->Send();
                return true;
            }
            catch (phpmailerException $e)
            {
                /*
                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->errorMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');
                */
            }
            catch (Exception $e)
            {
                /*
                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->getMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');
                */


                return false;
            }
        }
    }

    #array( "email_file", "email_subject", "email_heading", "email_to", "email_from", "email_from_name", "email_post", "email_attachment", "default_subject" )
    public function _send_email( $email_template )
    {


        if ( !isset( $email_template["email_heading"] ) )
        {
            $email_template["email_heading"]		= "";
        }

        if ( !isset( $email_template["email_to"] ) )
        {
            $email_template["email_to"]				= Session::get("site_settings.EMAIL_TO");
        }

        if ( !isset( $email_template["email_from"] ) )
        {
            $email_template["email_from"]			= Session::get("site_settings.EMAIL_FROM");
        }

        if ( !isset( $email_template["email_from_name"] ) )
        {
            $email_template["email_from_name"]		= Session::get("site_settings.EMAIL_FROM_NAME");
        }

        if ( !isset( $email_template["email_post"] ) )
        {
            $email_template["email_post"]			= Input::all();
        }

        if ( !isset( $email_template["email_attachment"] ) )
        {
            $email_template["email_attachment"]		= "";
        }

        if ( !isset( $email_template["email_bcc"] ) )
        {
            $email_template["email_bcc"]			= Session::get("site_settings.EMAIL_BCC");
        }


        if ( !isset( $email_template["default_subject"] ) )
        {
            $email_template["default_subject"]		= "";
        }
        else
        {
            $email_template["default_subject"]		= Session::get("site_settings.EMAIL_SUBJECT")  . " - ";
        }


		if ( isset( $email_template["email_file_HTML"] ) )
        {
            $email_body								= $email_template["email_file_HTML"];
        }
		else
		{		
        	$email_body									= view("email/template/index", $email_template);
		}



        $email_array		= array("from"					=> $email_template["email_from"],
                                    "from_name"			    => $email_template["email_from_name"],
                                    "to"					=> $email_template["email_to"],
                                    "cc"					=> "",
                                    "bcc"					=> $email_template["email_bcc"],
                                    "subject"				=> $email_template["default_subject"] . $email_template["email_subject"],
                                    "email_attachment"		=> $email_template["email_attachment"],
                                    "message"				=> ( $email_body  ) );



        if ( isset( $email_template["debug"] ) )
        {
            echo $email_body;
            dd($email_array	);die;
        }

        return $this->email($email_array);


    }
    
    
    function _left_pages()
    {
        $LEFT_PAGES                 =   GeneralHelper::role_permissions_left_pages();
        
        return $LEFT_PAGES;
    }
	
	
	public function remove_file($imageName, $dir = "")
	{
		$tmp				= $imageName;
		if ( $dir != "" )
		{
			$tmp			= $dir . $imageName;
		}
		
		if (@file_exists( $tmp ))
		{
			if ( @unlink( $tmp ) )
			{
				
			}
		}
	}
}
