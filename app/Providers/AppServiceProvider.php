<?php

namespace App\Providers;

use App\Classes\UploadedVideo;
use Illuminate\Http\UploadedFile;
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
        $this->validation_less_than_duration_of();       
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

    protected function validation_less_than_duration_of()
    {

        Validator::extend('less_than_duration_of', function($attribute, $value, $parameters, $validator) {

            $data = $validator->getData();
            $video_file_field = $parameters[0];

            $max_duration = floatval($data[$attribute]);
            $video_file = $data[$video_file_field] ?? null;
            
            if (!($video_file instanceof UploadedFile)){
               return false;
            }

            $video = new UploadedVideo($video_file);
            $real_duration = $video->getDuration();

            return $real_duration > $max_duration ;
        });  

        Validator::replacer('less_than_duration_of', function($message, $attribute, $rule, $parameters) {
            return str_replace(
                'validation.less_than_duration_of',
                $attribute . ' must be less than ' . $parameters[0] .' duration',
                $message
            );
        });
    }
}
