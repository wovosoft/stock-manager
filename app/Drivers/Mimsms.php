<?php

/**
 * Developed by : Narayan Adhikary <narayanadhikary24@gmail.com>, Founder at WovoSoft
 * Laravel Class to implement https://esms.mimsms.com/Developers
 */

namespace App\Drivers;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class Mimsms
 * @package App\Drivers
 */
class Mimsms
{
    private string $apiUrl;
    private string $apiMiscUrl;
    private string $apiKey;
    private string $senderId;
    private array $contacts;
    private string $msg;
    private string $type;
    private Response $response;


    /**
     * Mimsms constructor.
     * Fields are Optional. If not set, need to set using methods.
     * @param array $options [string api_url, string api_key, string sender_id, string type=text/unicode, string msg, string|array contacts]
     */
    public function __construct(array $options = [])
    {
        if (isset($options['api_url']) && $options['api_url']) {
            $this->setApiUrl($options['api_url']);
        } elseif (env("MIMSMS_APIURL") && env("MIMSMS_APIURL")) {
            $this->setApiUrl(env("MIMSMS_APIURL"));
        } else {
            $this->setApiUrl("https://esms.mimsms.com/smsapi");
        }

        if (isset($options['api_key']) && $options['api_key']) {
            $this->setApiKey($options['api_key']);
        } elseif (env("MIMSMS_APIKEY")) {
            $this->setApiKey(env("MIMSMS_APIKEY"));
        }

        if (isset($options['sender_id']) && $options['sender_id']) {
            $this->setSenderId($options['sender_id']);
        } elseif (env("MIMSMS_SENDERID")) {
            $this->setSenderId(env("MIMSMS_SENDERID"));
        }
        if (isset($options['type']) && $options['type']) {
            $this->setType($options['type']);
        } elseif (env('MIMSMS_TYPE')) {
            $this->setType(env('MIMSMS_TYPE'));
        } else {
            $this->setType("text");
        }
        if (isset($options['msg']) && $options['msg']) {
            $this->setMsg($options['msg']);
        }
        if (isset($options['contacts']) && $options['contacts']) {
            $this->setContacts($options['contacts']);
        }
        if (isset($options['api_balance_url']) && $options['api_balance_url']) {
            $this->setApiMiscUrl($options['api_balance_url']);
        } else {
            $this->setApiMiscUrl("https://esms.mimsms.com/miscapi");
        }
    }

    /**
     * Optional Call, if not set the constructor set's this url automatically. Only use it when api is changed.
     * @param string $api_url
     * @return $this
     */
    public function setApiUrl(string $api_url = "https://esms.mimsms.com/smsapi")
    {
        $this->apiUrl = $api_url;
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setApiMiscUrl(string $url)
    {
        $this->apiMiscUrl = $url;
        return $this;
    }

    /**
     * Required field. It is necessary to setup the api_key. If not set either via constructor or method, need to setup in .env file with MIMSMS_APIKEY.
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Required field. It is necessary to setup the sender_id. If not set either via constructor or method, need to setup in .env file with MIMSMS_SENDERID.
     * @param string $senderId
     * @return $this
     */
    public function setSenderId(string $senderId)
    {
        $this->senderId = $senderId;
        return $this;
    }

    /**
     * Optional field. Can be set either via constructor or method or in .env file with MIMSMS_TYPE.
     * @param string $type
     * @return $this
     */
    public function setType(string $type = "text")
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Required field. It is necessary to setup the contacts. Need to setup either via constructor or method.
     * @param $contacts array|string
     * @return $this
     */
    public function setContacts($contacts)
    {
        if (is_array($contacts)) {
            $this->contacts = array_merge(isset($this->contacts) ? $this->contacts : [], $contacts);
        } elseif (is_string($contacts)) {
            $this->contacts[] = $contacts;
        }
        return $this;
    }

    /**
     * Required field. It is necessary to setup the message. Need to setup either via constructor or method.
     * @param string $message
     * @return $this
     */
    public function setMsg(string $message)
    {
        $this->msg = $message;
        return $this;
    }

    /**
     * Call this method only after initialising every properties properly.
     */
    public function send()
    {
        try {
            if (!(isset($this->apiUrl) && $this->apiUrl)) {
                throw new \Exception("Api Url not Available");
            }
            if (!(isset($this->apiKey) && $this->apiKey)) {
                throw new \Exception("Api Key is not Available");
            }
            if (!(isset($this->type) && $this->type && in_array($this->type, ["text", "unicode"]))) {
                throw new \Exception("Invalid Message Type");
            }

            if (!(isset($this->contacts) && is_array($this->contacts) && count($this->contacts))) {
                throw new \Exception("No valid receiver numbers");
            }

            if (!(isset($this->senderId) && $this->senderId)) {
                throw new \Exception("Sender ID is not available");
            }
            if (!(isset($this->msg) && $this->msg)) {
                throw new \Exception("Message required");
            }
            $this->response = Http::post($this->apiUrl, [
                "api_key" => $this->apiKey,
                "type" => $this->type,
                "contacts" => join("+", $this->contacts),
                "senderid" => $this->senderId,
                "msg" => $this->msg,
            ]);
            return $this;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * Get Balance
     * @return $this
     */
    public function getBalance()
    {
        $this->response = Http::get($this->apiMiscUrl . "/" . $this->apiKey . "/getBalance");
        return $this;
    }

    public function getDeliveryReport(string $sms_id = null)
    {
        if ($sms_id) {
            $this->response = Http::get($this->apiMiscUrl . "/" . $this->apiKey . "/getDLR/" . $sms_id);
        } else {
            $this->response = Http::get($this->apiMiscUrl . "/" . $this->apiKey . "/getDLR/getAll");
        }
        return $this;
    }

    public function retrieveApiKey(string $username, string $password)
    {
        $this->response = Http::get("https://esms.mimsms.com/getkey/$username/$password");
        return $this;
    }

    /**
     * You should call this method to get the api response after making calls like getBalance, send etc. to MIMSMS.
     * This returns Illuminate\Http\Client\Response object. All the available methods can be used here to check
     * if the api call is successful or not, you can get headers, body, status etc.
     * More details here https://laravel.com/docs/8.x/http-client
     * @return Response
     */
    public function response()
    {
        return $this->response;
    }

    public function output()
    {
        if (in_array(trim($this->response->body()), [1002, 1003, 1004, 1005, 1006, 1007, 1008, 1009, 1010, 1011])) {
            return [
                "1002" => "Sender Id/Masking Not Found",
                "1003" => "API Not Found",
                "1004" => "SPAM Detected",
                "1005" => "Internal Error",
                "1006" => "Internal Error",
                "1007" => "Balance Insufficient",
                "1008" => "Message is empty",
                "1009" => "Message Type Not Set (text/unicode)",
                "1010" => "Invalid User & Password",
                "1011" => "Invalid User Id",
            ][trim($this->response->body())];
        }
        return $this->response->body();
    }

    public function hasError()
    {
        return in_array(trim($this->response->body()), [1002, 1003, 1004, 1005, 1006, 1007, 1008, 1009, 1010, 1011]);
    }

    public function getSmsId()
    {
        if (!(isset($this->response) && $this->response)) {
            return null;
        }

        return trim(str_replace("SMS SUBMITTED: ID - ", "", $this->response->body()));
    }
}


