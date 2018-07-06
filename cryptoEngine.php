<?php
    if (isset($_POST['message'], $_POST['key'], $_POST['enc'])) {
        if ($_POST['enc'] == 1) {
            encrypt($_POST['message'], $_POST['key']);
        }
        else{
            decrypt($_POST['message'], $_POST['key']);
        }
    }
    function encrypt($plaintxt, $key){
        $key = evaluateKey($key);
        $plaintxt = strrev($plaintxt);
        $plaintxt = str_split($plaintxt);
        $length = count($plaintxt);
        for ($i=0; $i < $length; $i++) { 
            $x = ord($plaintxt[$i]);
            $x -= $key;
            $plaintxt[$i] = chr($x);
        }
        $plaintxt = implode($plaintxt);
        echo $plaintxt;
    }

    function decrypt($cryptotxt, $key){
        $key = evaluateKey($key);
        $cryptotxt = strrev($cryptotxt);
        $cryptotxt = str_split($cryptotxt);
        $length = count($cryptotxt);
        for ($i=0; $i < $length; $i++) { 
            $x = ord($cryptotxt[$i]);
            $x += $key;
            $cryptotxt[$i] = chr($x);
        }
        $cryptotxt = implode($cryptotxt);
        echo $cryptotxt;
    }

    function evaluateKey($key){
        $keyVal = 0;
        if (strlen($key) == 1) {
            $keyVal += ord($key);
        } elseif (strlen($key) == 2) {
            $key = str_split($key);
            for ($i=0; $i < 2; $i++) { 
                $key[$i] = ord($key[$i]);
            }
            $keyVal += abs($key[0] + (2* $key[0] - $key[1]) - sqrt($key[0] * $key[1]));
        } else {
            $key = str_split($key, 2);
            $length = count($key);
            for ($i=0; $i < $length; $i++) { 
                $keyVal += evaluateKey($key[$i]);
            }
        }
        $keyVal = $keyVal * 1.265;
        $keyVal = $keyVal % 8;
        return $keyVal;
    }
?>