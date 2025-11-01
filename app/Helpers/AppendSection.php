<?php

namespace App\Helpers;

class AppendSection
{
    private $id;
    private $url;
    public $postData;

    public function __construct($id, $url, $postData = [])
    {
        $this->id = $id;
        $this->url = $url;
        $this->postData = $postData;
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'postData' => $this->postData
        ];
    }
}
