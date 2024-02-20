<?php

namespace Xaver\components;

use Yii;

class RecaptchaStorageHelper
{
    const RECAPTCHA_VALID_STATE = 'recaptcha-valid-state';

    public static function hasRecaptchaValidator(): bool
    {
        return Yii::app()->user->hasState(self::RECAPTCHA_VALID_STATE);
    }

    public static function setRecaptchaValidator(): string
    {
        $key = uniqid();
        Yii::app()->user->setState(self::RECAPTCHA_VALID_STATE, $key);
        return $key;
    }

    public static function unsetRecaptchaValidator(): void
    {
        Yii::app()->user->setState(self::RECAPTCHA_VALID_STATE, null);
    }
}