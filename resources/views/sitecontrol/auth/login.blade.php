@extends("sitecontrol/template_login.master")

@section('_pageview')


<div class="form-box" id="login-box">
  <div class="header bg-blue">Sign In</div>
  
  
    {!!  Form::open(array('url' => route("post.login"))) !!}

        <div class="body bg-gray">
            <div class="form-group">
            	{!! Form::text ('email', GeneralHelper::set_value("email"), ["class"=> "form-control", "placeholder" => "Email Address"] ) !!}
                {!! GeneralHelper::form_error($errors, 'email') !!}
            </div>
            
            <div class="form-group">
            	{!! Form::password ('password', ["class"=> "form-control", "placeholder" => "Password"] ) !!}
			    {!! GeneralHelper::form_error($errors, 'password') !!}
            </div>
            
      
        </div>
        
        
        <div class="footer">
            <button type="submit" class="btn bg-blue  btn-block">Sign me in</button>
            <button type="button" class="btn bg-black  btn-block">Forgot Your Password</button>
            <!--<p><a href="#">I forgot my password</a></p>
            <a href="register.html" class="text-center">Register a new membership</a> --> 
        </div>


    {!!  Form::close() !!}
    

</div>
@endsection
