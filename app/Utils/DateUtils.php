<?php

namespace App\Utils;

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
        $date = $date->format('d/m/Y H:i');
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

}