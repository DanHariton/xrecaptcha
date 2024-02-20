<?php

namespace Xaver\components;

use CApplicationComponent;

class RecaptchaSettings extends CApplicationComponent
{
    public $threshold;
    public $serverKey;
    public $clientKey;

    public function setThreshold(string $threshold): void
    {
        $this->threshold = $threshold;
    }

    public function setServerKey(string $serverKey): void
    {
        $this->serverKey = $serverKey;
    }

    public function setClientKey(string $clientKey): void
    {
        $this->clientKey = $clientKey;
    }
}