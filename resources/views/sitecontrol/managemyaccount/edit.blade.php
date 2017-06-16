{!! Form::open( array("url" => $_directory . "controls/save", "method"		=> "post", "enctype"		=> "multipart/form-data") ) !!}
{!! Form::unique_formid(  ) !!}
<table class="table table_form">

   


    <tr>
        <td class="td_bg fieldKey">Username {!! GeneralHelper::required_field() !!}</td>
        <td class="td_bg fieldValue">
            <div class="input-group col-xs-5">
                {!! Form::text ('username', GeneralHelper::set_value("username", $username), ["class"=> "form-control"] ) !!}
            </div>
        </td>
    </tr>


   

    <tr>
        <td class="td_bg fieldKey">Email {!! GeneralHelper::required_field() !!}</td>
        <td class="td_bg fieldValue">
            <div class="input-group col-xs-5">
                {!! Form::text ('email', GeneralHelper::set_value("email", $email), ["class"=> "form-control"] ) !!}
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg fieldKey">Current Password</td>
        <td class="td_bg fieldValue">
            <div class="input-group col-xs-5">
                {!! Form::input('password', 'current_password', GeneralHelper::set_value("current_password", $current_password), ["class"=> "form-control"]) !!}
            </div>
        </td>
    </tr>



    <tr>
        <td class="td_bg fieldKey">Enter New Password</td>
        <td class="td_bg fieldValue">
            <div class="input-group col-xs-5">
                {!! Form::input('password', 'new_password', GeneralHelper::set_value("new_password", $new_password), ["class"=> "form-control"]) !!}
            </div>
        </td>
    </tr>


    <tr>
        <td class="td_bg fieldKey">Confirm New Password</td>
        <td class="td_bg fieldValue">
            <div class="input-group col-xs-5">
                {!! Form::input('password', 'new_confirm_password', GeneralHelper::set_value("new_confirm_password", $new_confirm_password), ["class"=> "form-control"]) !!}
            </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg">Profile Image</td>
        <td class="td_bg">
            <div class="input-group col-xs-12">
                {!! Form::file('file_user_image', ["class" => "btn btn-default"]) !!}
                <input type="hidden" value="{!! GeneralHelper::set_value("user_image", $user_image) !!}" name="user_image" />
                <?php /*{!! GeneralHelper::image_link("user_image", $user_image, FALSE, FALSE, TRUE, \Magento::getMediaURL( "avatar/" ) ) !!} */ ?>
            </div>
        </td>
    </tr>


</table>

<input type="hidden" name="id" value="{!! GeneralHelper::set_value("id", $id) !!}" />
<input type="hidden" name="options" value="{!! GeneralHelper::set_value("options", $options) !!}" />

<div class="crud_controls">
    {!! Form::save( $_directory ) !!}
</div>

{!!   Form::close() !!}