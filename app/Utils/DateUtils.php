<?php

namespace App\Utils;

use Date;
use DateTime;
use DateTimeZone;

class DateUtils
{   


    public static function dateToFrench($date, $format) 
    {
        $english_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $french_days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        $english_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $french_months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date))));
    }
    /**
     * Return a date in french format
     * @param string $date
     * @return string
     */
    public static function formatDateInFrench($date)
    {
        $date = new \DateTime($date);
        $date = $date->format('l j F Y');
        $french_date = self::dateToFrench($date, 'l j F Y');
        return $french_date;
    }



    /**
     * Return a date in french format
     * @param string $date
     * @return string
     */
    public static function formatDateTime($date)
    {
        $date = new \DateTime($date);
        $date = $date->format('d/m/Y');
        return $date;
    }

    /**
     * Return a date in french format
     * @param string $date
     * @return string
     */
    public static function compareDate($date2)
    {
    $date1 = date_create('now', new DateTimeZone('Europe/Paris'));
    $date2 = date_create($date2);

    $date1 = $date1->format('d-m-Y');
    $date2 = $date2->format('d-m-Y');
    $interval = date_diff(new DateTime($date1), new DateTime($date2));

        if ($date1 > $date2) { 
            return $interval->format('Publié il y a %a jours');
        }

        return $interval->format('Publié aujourd\'hui');
    }

    /**
     * Return a date in french format
     * @param string $date
     * @return string
     */
    public static function convertDateInValidDatePickerValue($full_string_date)
    {
        $data = explode(' ', $full_string_date);
        $dayNumber = $data[1];
        $month = $data[2];
        $year = $data[3];

        switch($month) {
            case 
            ('janvier'):
                $month = '1';
                break;
            case('février'):
                $month = '2';
                break;
            case('mars'):
                $month = '3';
                break;
            case('avril'):
                $month = '4';
                break;
            case('mai'):
                $month = '5';
                break;
            case('juin'):
                $month = '6';
                break;
            case('juillet'):
                $month = '7';
                break;
            case('août'):
                $month = '8';
                break;
            case('septembre'):
                $month = '9';
                break;
            case('octobre'):
                $month = '10';
                break;
            case('novembre'):
                $month = '11';
                break;
            case('décembre'):
                $month = '12';
                break;
        };

        $date = new DateTime($dayNumber.'-'.$month.'-'.$year);
        return $date = $date->format('Y-m-d');
    }
}