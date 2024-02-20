<?php

namespace Xaver\components;

use CValidator;
use Yii;

class RecaptchaValidator extends CValidator
{
    protected function validateAttribute($object, $attribute): void
    {
        if (Yii::app()->user->isGuest && !RecaptchaStorageHelper::hasRecaptchaValidator()) {
            $this->addError($object, $attribute, Yii::t('XformModule.module', 'Recaptcha validation failed.'));
        }
    }
}