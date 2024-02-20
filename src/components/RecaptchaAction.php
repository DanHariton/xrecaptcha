<?php

namespace Xaver\components;

use CAction;
use Xaver\models\RecaptchaResponse;
use Yii;

class RecaptchaAction extends CAction
{
    public function run()
    {
        $response = new RecaptchaResponse();
        $response->validate(Yii::app()->request->getPost('token'));
        $this->sendResponse($response);
    }

    protected function sendResponse(RecaptchaResponse $response)
    {
        http_response_code($response->getStatus());
        echo json_encode($response);
        Yii::app()->end();
    }
}