<?php
/**
 * Created by PhpStorm.
 * User: haroldas
 * Date: 18.4.16
 * Time: 01.16
 */

namespace App\Validation;


use DateTime;

class ValidationService
{
    public function validate($day)
    {
        if (DateTime::createFromFormat('Y-m-d', $day) !== FALSE) {
            if (strtotime($day) >= strtotime(date('Y-m-d'))) {
                if(strtotime($day) <= strtotime(date('Y-m-d', strtotime('+2 month')))) {
                    return false;
                } else {
                    return "Neturime duomenų apie orus tolimesnius nei 2 mėnesiai";
                }
            } else {
                return "Tai praeities data";
            }
        } else {
            return  "Prašome patikrinti datos formatą. Reikalaujamas: yyyy-mm-dd";
        }
    }
}