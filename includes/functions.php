<?php

function debug($variable, $exit = true, $dump = false)
{
    echo '<pre>';
    if ($dump) var_dump($variable);
    else print_r($variable);
    echo '</pre>';
    if ($exit) die();
};

function br_to_sys($data_br)
{
    $dt_parts = explode(' ', $data_br);
    $parts = explode('/', $dt_parts[0]);
    $new_date = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
    if(count($dt_parts) == 2) $new_date .= " {$dt_parts[1]}";
    return $new_date;
}