<?php

class RecaptchaStorageHelper
{
    const RECAPTCHA_VALID_STATE = 'recaptcha-valid-state';

    public static function hasRecaptchaValidator() {
        return Yii::app()->user->hasState(self::RECAPTCHA_VALID_STATE);
    }

    public static function setRecaptchaValidator() {
        $key = uniqid();
        Yii::app()->user->setState(self::RECAPTCHA_VALID_STATE, $key);
        return $key;
    }

    public static function unsetRecaptchaValidator() {
        Yii::app()->user->setState(self::RECAPTCHA_VALID_STATE, null);
    }
}