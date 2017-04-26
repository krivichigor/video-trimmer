<?php

namespace App\Providers;

use App\Classes\UploadedVideo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->validation_greater_than_field();
        $this->validation_duration_less_than_field();       
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


    protected function validation_greater_than_field()
    {
        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value > $min_value;
        });   

        Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(
                'validation.greater_than_field',
                $attribute . ' must be more than ' . $parameters[0],
                $message
            );
        });
    }

    protected function validation_duration_less_than_field()
    {

        Validator::extend('duration_less_than_field', function($attribute, $value, $parameters, $validator) {
            
            $max_field = $parameters[0];
            $data = $validator->getData();
            $video_file = $data[$attribute];
            $max_duration = floatval($data[$max_field]);

            $video = new UploadedVideo($video_file);
            $real_duration = $video->getDuration();

            return $real_duration > $max_duration ;
        });  

        Validator::replacer('duration_less_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(
                'validation.duration_less_than_field',
                $parameters[0] . ' must be less than ' . $attribute .' duration',
                $message
            );
        });
    }
}
