<?php

namespace App\Traits;

use App\Helpers\AppendSection;
use App\Helpers\ReloadSection;

trait ResponseHelper
{

    private static $DEFAULT_SUCCESS_MESSAGE = "Processing was successful";
    private static $DEFAULT_ERROR_MESSAGE = "Failed to process";
    private static $APPEND_SEPARATOR = ", ";
    private static $STATUS_KEY = "status";
    private static $REDIRECT_KEY = "redirecturl";
    private static $MESSAGE_KEY = "message";
    private static $DISPLAY_MESSAGE = "displayMessage";
    private static $DISPLAY_ERROR_DETAIL_MODAL = "displayErrorDetailModal";
    private static $FILE_DOWNLOAD = "fileDownload";

    private $fileDownload = false;
    private $displayMessage = true;
    private $showErrorDetailModal = false;
    private $statusMessage;
    private $status;
    private $response = [];

    public function setDisplayMessage($displayMessage)
    {
        $this->displayMessage = $displayMessage;
    }

    public function setFileDownload($fileDownload)
    {
        $this->fileDownload = $fileDownload;
    }

    public function setShowErrorDetailModal($showErrorDetailModal)
    {
        $this->showErrorDetailModal = $showErrorDetailModal;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setStatusMessage($message)
    {
        $this->statusMessage = $message;
    }

    public function setRedirectUrl($url)
    {
        $this->response[self::$REDIRECT_KEY] = $url;
    }

    public function setReloadSectionIdWithUrl($elementId, $url)
    {
        $this->response["reloadelementid"] = $elementId;
        $this->response["reloadurl"] = $url;
    }

    public function setSecondReloadSectionIdWithUrl($elementId, $url)
    {
        $this->response["secondreloadelementid"] = $elementId;
        $this->response["secondreloadurl"] = $url;
    }

    public function setThirdReloadSectionIdWithUrl($elementId, $url)
    {
        $this->response["thirdreloadelementid"] = $elementId;
        $this->response["thirdreloadurl"] = $url;
    }

    public function setAppendSection(array $appendSections)
    {
        // Ensure each ReloadSection is converted to an array
        $appendSectionsArray = array_map(function ($section) {
            if ($section instanceof AppendSection) {
                return $section->toArray();
            }
            return null; // handle invalid entries
        }, $appendSections);

        // Add the valid reload sections to the response
        $this->response["appendsections"] = array_filter($appendSectionsArray);
    }

    public function setReloadSections(array $reloadSections)
    {
        // Ensure each ReloadSection is converted to an array
        $reloadSectionsArray = array_map(function ($section) {
            if ($section instanceof ReloadSection) {
                return $section->toArray();
            }
            return null; // handle invalid entries
        }, $reloadSections);

        // Add the valid reload sections to the response
        $this->response["reloadsections"] = array_filter($reloadSectionsArray);
    }

    public function setErrorDetailsList(array $list)
    {
        $this->response["errorDetails"] = $list;
    }

    public function setTriggerModalUrl($modalId, $url)
    {
        $this->response["modalid"] = $modalId;
        $this->response["triggermodalurl"] = $url;
    }

    public function setSuccessStatusAndMessage($message = null)
    {
        $this->status = "SUCCESS";
        if (empty($message)) {
            $message = self::$DEFAULT_SUCCESS_MESSAGE;
        }
        $this->statusMessage = $message;
    }

    public function setErrorStatusAndMessage($message = null)
    {
        $this->status = "ERROR";
        if (empty($message)) {
            $message = self::$DEFAULT_ERROR_MESSAGE;
        }
        $this->statusMessage = $message;
    }

    public function setWarningStatusAndMessage($message)
    {
        $this->status = "WARNING";
        $this->statusMessage = $message;
    }

    public function setInfoStatusAndMessage($message)
    {
        $this->status = "INFO";
        $this->statusMessage = $message;
    }

    public function addDataToResponse($key, $value)
    {
        if (!isset($this->response[$key])) {
            $this->response[$key] = $value;
        } else {
            $this->response[$key] .= self::$APPEND_SEPARATOR . $value;
        }
    }

    public function addDataToResponseWithObject($key, $value)
    {
        $this->response[$key] = $value;
    }

    public function getResponse()
    {
        if (empty($this->status)) {
            return [];
        }
        if (empty($this->statusMessage)) {
            switch (strtoupper($this->status)) {
                case "SUCCESS":
                    $this->statusMessage = self::$DEFAULT_SUCCESS_MESSAGE;
                    break;
                case "ERROR":
                    $this->statusMessage = self::$DEFAULT_ERROR_MESSAGE;
                    break;
                default:
                    break;
            }
        }

        $this->response[self::$STATUS_KEY] = strtoupper($this->status);
        $this->response[self::$MESSAGE_KEY] = $this->statusMessage;
        $this->response[self::$DISPLAY_MESSAGE] = $this->displayMessage;
        $this->response[self::$DISPLAY_ERROR_DETAIL_MODAL] = $this->showErrorDetailModal;
        $this->response[self::$FILE_DOWNLOAD] = $this->fileDownload;

        return $this->response;
    }
}
