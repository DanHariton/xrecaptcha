<?php

class RecaptchaAction extends CAction
{
    public function run()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            http_response_code(405);
            echo json_encode(['status' => 404, 'response' => false]);
            Yii::app()->end();
        }

        if (!Yii::app()->user->isGuest) {
            echo json_encode(['status' => 200, 'response' => true]);
            Yii::app()->end();
        }

        $token = Yii::app()->request->getPost('token');
        if ($token === null) {
            echo json_encode(['status' => 404, 'response' => false]);
            Yii::app()->end();
        }

        $recaptchaSettings = Yii::app()->getComponent('recaptchaSettings');
        $serverKey = $recaptchaSettings->getServerKey();
        $threshold = $recaptchaSettings->getThreshold();

        $challenger = (new ReCaptcha\ReCaptcha($serverKey))
            ->setScoreThreshold($threshold)
            ->verify($token, $_SERVER['REMOTE_ADDR']);

        if (!$challenger->isSuccess()) {
            Yii::log(json_encode($challenger));
            echo json_encode(['status' => 400, 'response' => false]);
            Yii::app()->end();
        }

        RecaptchaStorageHelper::setRecaptchaValidator();

        echo json_encode(['status' => 200, 'response' => true]);
        Yii::app()->end();
    }
}