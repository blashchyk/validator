<?php
namespace Blashchyk\StandartPasswordValidate;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class StandartPasswordValidate extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom( __DIR__ . '/config/ignore_standard_passwords.php', 'ignore_standard_passwords' );
        $this->loadTranslationsFrom( __DIR__ . '/lang', 'standart_password_validate' );
        $this->publishes( [
            __DIR__ . '/lang' => resource_path( 'lang/vendor/standart_password_validate' ),
        ], 'lang' );
        Validator::extend('ignore_standard_passwords', function ($attribute, $value, $parameters) {
            $ditionary = file(Config::get($parameters[0], 'passwords.txt'));
            $ditionary = array_map('trim', $ditionary);
            return !in_array($value, $ditionary);
        }, trans( 'standart_password_validate::validation.ignore_standard_passwords' ));
    }
    public function register()
    {
        //
    }
}