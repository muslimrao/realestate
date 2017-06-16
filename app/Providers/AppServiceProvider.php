<?php

namespace App\Providers;

use App\Http\Library\CustomValidator;
use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		Schema::defaultStringLength(191);


		$this->app->validator->resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
		
		Validator::extend('greater_than_zero', function($attribute, $value)
		{
			$other 			= 0;
		
			if ( $value <= $other)
			{
				return FALSE;	
			}
			return TRUE;
			#return isset($other) and intval($value) > intval($other);
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
