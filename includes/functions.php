<?php

function redirect($page)
{
    header('Location: '.$page);
    die();
}

function format_date($date, $format = 'date')
{

    if(!is_numeric($date)) $date = strtotime($date);

    switch($format)
    {
        case 'datetime': return '';
        case 'mysql': return date('Y-m-j', $date);
        default: return date('F j, Y', $date);
    }

}

function difference_date($from, $to = false)
{

    if(!$to) $to = time();

    if(!is_numeric($from)) $from = strtotime($from);

    return $from - $to;

}
