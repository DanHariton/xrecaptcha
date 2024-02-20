<?php

namespace Xaver\models;

use Exception;
use JsonSerializable;
use ReCaptcha\ReCaptcha;
use Xaver\components\RecaptchaSettings;
use Xaver\components\RecaptchaStorageHelper;
use Yii;

class RecaptchaResponse implements JsonSerializable
{
    private int $status;
    private bool $response;
    private ?string $message;

    const STATUS_SUCCESS = 200;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_METHOD_NOT_ALLOWED = 405;
    const STATUS_NOT_FOUND = 404;

    public function __construct()
    {
        $this->status = self::STATUS_NOT_FOUND;
        $this->response = false;
        $this->message = null;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getResponse(): bool
    {
        return $this->response;
    }

    public function setResponse(bool $response): void
    {
        $this->response = $response;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->getStatus(),
            'response' => $this->getResponse(),
            'message' => $this->getMessage()
        ];
    }

    public function save()
    {

    }

    public function validate($token)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->setStatus(self::STATUS_METHOD_NOT_ALLOWED);
            return;
        }

        if (!Yii::app()->user->isGuest) {
            $this->setStatus(self::STATUS_SUCCESS);
            $this->setResponse(true);
            return;
        }

        if ($token === null) {
            $this->setStatus(self::STATUS_BAD_REQUEST);
            return;
        }

        try {
            $recaptchaSettings = Yii::app()->getComponent(RecaptchaSettings::class);
            $serverKey = $recaptchaSettings->getServerKey();
            $threshold = $recaptchaSettings->getThreshold();
        } catch (Exception $e) {
            $this->setStatus(self::STATUS_NOT_FOUND);
            return;
        }

        $challenger = (new ReCaptcha($serverKey))
            ->setScoreThreshold($threshold)
            ->verify($token, Yii::app()->request->userHostAddress);

        if (!$challenger->isSuccess()) {
            $this->setStatus(self::STATUS_BAD_REQUEST);
            return;
        }

        RecaptchaStorageHelper::setRecaptchaValidator();

        $this->setStatus(self::STATUS_SUCCESS);
        $this->setResponse(true);
    }
}