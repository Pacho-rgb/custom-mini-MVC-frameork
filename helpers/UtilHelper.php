<?php

namespace app\helpers;

class UtilHelper
{
    public function randomString($length = 8): string
    {
        $characters = '0986754321QWERTYUIOPasdghjklMNBVCZXqwertyuiopLKJHGFDSAzxcvbnm';
        $str = '';
        for ($i=0; $i < $length; $i++) { 
            $rand_index = rand(0, strlen($characters) - 1);
            $str .= $characters[$rand_index];
        }
        return $str;
    }
}