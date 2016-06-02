<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'vendor/autoload.php';

use UrbanAirship\Airship;
use UrbanAirship\AirshipException;
use UrbanAirship\UALog;
use UrbanAirship\Push as P;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

UALog::setLogHandlers(array(new StreamHandler("php://stdout", Logger::DEBUG)));

$airship = new Airship("<app key>", "<master secret>");

try {
    $response = $airship->push()
        ->setAudience(P\all)
        ->setNotification(P\notification("Hello from php"))
        ->setDeviceTypes(P\all)
        ->send();
} catch (AirshipException $e) {
    print_r($e);
}