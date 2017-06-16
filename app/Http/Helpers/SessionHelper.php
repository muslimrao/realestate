<?php

namespace App\Http\Helpers;


use App\Http\Helpers\Magento as MagentoHelper;
use App\Http\Models\Model_Site_Settings;
use Illuminate\Support\Facades\Session;


class SessionHelper extends MagentoHelper
{
    function __construct()
    {
        parent::__construct();
        $this->MMM = self::getInstance();
    }

    function site_settings_session()
    {
		
		

        //re-declare session parameters (muslim)
        if ( !Session::has("site_settings") )
        {


            $settings_master = Model_Site_Settings::first();
            if ($settings_master->count()) {


                #define SITE_SETTINGS CONSTANT
                $config = $settings_master->toArray();

                $TMP_alter_emails3 = GeneralHelper::generate_toccbcc_emails($config['email_to'], array("email_to", "email_bcc"));

                $config = GeneralHelper::merge_multi_arrays(array($config, $TMP_alter_emails3));


                $session_array = array_change_key_case($config, CASE_UPPER);

                Session::put("site_settings", $session_array);
            }
        }
    }


}