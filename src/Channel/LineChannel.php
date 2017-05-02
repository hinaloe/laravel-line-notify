<?php

namespace Hinaloe\LineNotify\Channel;

use GuzzleHttp\Client as HttpClient;
use Hinaloe\LineNotify\Message\LineMessage;
use Illuminate\Notifications\Notification;

class LineChannel
{
    /**
     * Http client instance
     *
     * @var HttpClient
     */
    protected $http;

    /**
     * API Endpoint
     *
     * @var string
     */
    protected $endpoint = 'https://notify-api.line.me/api/notify';

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function send($notifable, Notification $notification)
    {
        if (!$token = $notifable->routeNotificationFor('line')) {
            return;
        }
        $this->http->post($this->endpoint, $this->buildRequest(
            $notification->toLine($notifable),
            $token
        ));
    }

    /**
     * @param LineMessage $message
     * @param string $token
     * @return array
     */
    protected function buildRequest(LineMessage $message, string $token)
    {
        $optionalFields = array_filter([
            'imageThumbnail' => data_get($message, 'imageThumbnail'),
            'imageFullsize' => data_get($message, 'imageFullsize'),
            'stickerPackageId' => data_get($message, 'stickerPackageId'),
            'stickerId' => data_get($message, 'stickerId'),
        ]);

        return array_merge($this->hasUploadFile($message) ? [
            'multipart' => array_merge([
                [
                    'name' => 'message',
                    'contents' => $message->message,
                ],
                [
                    'name' => 'imageFile',
                    'contents' => fopen($message->imageFile, 'r'),
                ],
            ], $this->convertFormToMultipart($optionalFields))
        ] : [
            'form_params' => array_merge([
                'message' => $message->message,
            ], $optionalFields)
        ], [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ], $message->http);
    }

    /**
     * @param LineMessage $message
     * @return bool
     */
    protected function hasUploadFile(LineMessage $message)
    {
        return ($path = data_get($message, 'imageFile')) && file_exists($path);
    }

    protected function convertFormToMultipart(array $data)
    {
        $multipart = [];
        foreach ($data as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }
        return $multipart;
    }
}