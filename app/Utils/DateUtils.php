<?php

namespace App\Utils;

use DateTime;
use DateTimeZone;

class DateUtils
{   
    /**
     * Return a date in french format
     * @param string $date
     * @return string
     */
    public function formatDate($date)
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
    public function formatDateTime($date)
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
    public function compareDate($date2)
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