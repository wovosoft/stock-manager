<?php

use App\Models\Sms;

$item = new Sms();
$item->provider = "MIMSMS";
$item->sms_id = null;
$item->type = "text";
$item->sender = env("MIMSMS_SENDERID");
$item->contacts = ['8801764954227'];
$item->message = "Test message from software";
$item->delivery = "created";
$item->saveOrFail();


