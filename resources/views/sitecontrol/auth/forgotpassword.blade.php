@extends("sitecontrol.template_login.master")

@section('_pageview')


    <div id="login-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!!  Form::open(array('url' => route("post.forgotpassword"))) !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} form-row-cutom">
                            <span class="login_icon_wrap"> {!! HTML::image('public/assets/admincms/img/email_icon.png', 'Email Icon', ["style"=>"margin-top:6px;"]) !!}</span>
                            {!! Form::text ('email', GeneralHelper::set_value("email"), ["class"=> "form-control", "placeholder" => "Email Address"] ) !!}
                            {!! GeneralHelper::form_error($errors, 'email') !!}
                        </div>

                     <div class="checkbox">
                        <label>
                        {!! Form::checkbox ('is_vendor', 1 , GeneralHelper::set_value("is_vendor") , ["class"=> ""] ) !!}
                        <h4>Are You Vendor?</h4></label>
                    </div>
                
                    
                        <button type="submit" class="btn btn-primary login-btn">
                            Send Password Reset Link
                        </button>
                    {!!  Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
