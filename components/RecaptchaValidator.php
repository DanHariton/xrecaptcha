<?php

class RecaptchaValidator extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if (Yii::app()->user->isGuest && !RecaptchaStorageHelper::hasRecaptchaValidator()) {
            $this->addError($object, $attribute, Yii::t('XformModule.module', 'Recaptcha validation failed.'));
        }
    }
}