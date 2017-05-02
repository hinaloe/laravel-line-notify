<?php

namespace Hinaloe\LineNotify\Message;

/**
 * Class LineMessage
 * @package App\Notifications\Message
 * @see en: https://notify-bot.line.me/doc/en/
 * @see ja: https://notify-bot.line.me/doc/ja/
 */
class LineMessage
{
    /**
     * Message content
     *
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $imageThumbnail;

    /**
     * @var string
     */
    public $imageFullsize;

    /**
     * @var string filename
     */
    public $imageFile;

    /**
     * @var int
     */
    public $stickerPackageId;

    /**
     * @var int
     */
    public $stickerId;

    /**
     * Additional request options for the Guzzle HTTP client.
     *
     * @var array
     */
    public $http = [];

    /**
     * @param string $message
     * @return LineMessage
     */
    public function message(string $message): LineMessage
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Image file url (You can use only jpeg)
     *
     * @param string $full
     * @param string|null $thumb
     * @return LineMessage
     */
    public function imageUrl(string $full, string $thumb = null): LineMessage
    {
        $this->imageFullsize = $full;
        $this->imageThumbnail = $thumb ?: $full;
        return $this;
    }

    /**
     * Path to image which you will upload (jpeg, png, gif)
     *
     * @param string $imageFile path to file
     * @return LineMessage
     */
    public function imageFile(string $imageFile): LineMessage
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function sticker(int $packageId, int $stickerId)
    {
        $this->stickerPackageId = $packageId;
        $this->stickerId = $stickerId;
        return $this;
    }

    /**
     * @param int $stickerPackageId
     * @return LineMessage
     *
     * @deprecated please use sticker() instead
     */
    public function stickerPackageId(int $stickerPackageId): LineMessage
    {
        $this->stickerPackageId = $stickerPackageId;
        return $this;
    }

    /**
     * @param int $stickerId
     * @return LineMessage
     *
     * @deprecated please use sticker() instead
     */
    public function stickerId(int $stickerId): LineMessage
    {
        $this->stickerId = $stickerId;
        return $this;
    }

    /**
     * @param array $http
     * @return LineMessage
     */
    public function http(array $http): LineMessage
    {
        $this->http = $http;
        return $this;
    }
}