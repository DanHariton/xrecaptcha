<?php

class RecaptchaSettings extends CApplicationComponent
{
    public $threshold;
    public $serverKey;
    public $clientKey;

    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;
    }

    public function setServerKey($serverKey)
    {
        $this->serverKey = $serverKey;
    }

    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;
    }
}