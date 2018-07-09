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
        $plaintxt = str_split($plaintxt);
        $length = count($plaintxt);
        for ($i=0; $i < $length; $i++) { 
            $x = ord($plaintxt[$i]);
            $x -= $key;
            if ($x < 65) {
                $v = 65 - $x;
                $v = mt_rand($v, $v+25);
                $x += $v;
                $plaintxt[$i] = chr($x)."0$v";
            } elseif ($x > 122) {
                $v = $x - 122;
                $v = mt_rand($v, $v+25);
                $x -= $v;
                $plaintxt[$i] = chr($x)."2$v";
            } elseif ($x > 90 && $x < 97) {
                $v = 97 - $x;
                $v = mt_rand($v, $v+25);
                $x += $v;
                $plaintxt[$i] = chr($x)."1$v";
            } else {
                $plaintxt[$i] = chr($x);
            }
        }
        $plaintxt = implode($plaintxt);
        echo $plaintxt;
    }

    function decrypt($cryptotxt, $key){
        $key = evaluateKey($key);
        $newMessage = "";
        $cryptotxt = str_split($cryptotxt);
        $length = count($cryptotxt);
        for ($i=0; $i < $length; $i++) { 
            if (preg_match("/[a-zA-Z]$/", $cryptotxt[$i])) {
                $temp = "";
                for ($j=$i+1; $j < $length; $j++) { 
                    if (preg_match("/[a-zA-Z]$/", $cryptotxt[$j])) {
                        break;
                    }
                    $temp .= $cryptotxt[$j];
                }
                $temp = str_split($temp);
                $x = ord($cryptotxt[$i]);

                if (!empty($temp)) {
                    switch ($temp[0]) {
                        case '0':
                            array_splice($temp, 0, 1);
                            $temp = implode($temp);
                            $x -= $temp;
                            break;
                        case '1':
                            array_splice($temp, 0, 1);
                            $temp = implode($temp);
                            $x -= $temp;
                            break;
                        case '2':
                            array_splice($temp, 0, 1);
                            $temp = implode($temp);
                            $x += $temp;
                            break;
                        default:
                            break;
                    }
                }
                $x += $key;
                $newMessage .= chr($x);
            }
        }
        echo $newMessage;
    }

    function evaluateKey($key){
        $keyVal = 0;
        $length = strlen($key);
        str_split($key);

        for ($i=0; $i < $length; $i++) { 
            $keyVal += ($i + 1) * ord($key[$i]);
        }
        
        $keyVal = $keyVal * 1.265;
        $keyVal = $keyVal % 8;
        return $keyVal+1;
    }
?>