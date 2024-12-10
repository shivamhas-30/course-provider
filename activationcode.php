<?php

function generateActivationKey() {
    $machineId = md5(uniqid());
    $activationKey = substr(md5(microtime() . $machineId), 0, 16);
    $productKey = rand(1000000000000000, 9999999999999999);
    $encryptedProductKey = md5($productKey);
    
    return array('activationKey' => $activationKey, 'machineId' => $machineId, 'productKey' => $productKey);
}

$activation = generateActivationKey();



?>