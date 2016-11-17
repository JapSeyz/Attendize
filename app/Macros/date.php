<?php

function localize_date($date, $format = 'd-m-Y H:i:s')
{
    return Jenssegers\Date\Date::createFromFormat('d-m-Y H:i:s', $date->format('d-m-Y H:i:s'))->format($format);
}