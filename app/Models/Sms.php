<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Drivers\Mimsms;

class Sms extends BaseModel
{
    use HasFactory, HistoryTrait;


    public function setContactsAttribute($value)
    {
        $this->attributes['contacts'] = json_encode($value);
    }

    public function getContactsAttribute($value)
    {
        return json_decode($value);
    }

    public function send()
    {
        $sms = new Mimsms();
        $sms->setContacts($this->contacts)
            ->setType($this->type)
            ->setMsg($this->message)
            ->send();
        if (!$sms->hasError()) {
            $this->sms_id = $sms->getSmsId();
            $this->delivery = "processed";
            $this->saveOrFail();
            return $sms->output();
        }
        return false;
    }
}
