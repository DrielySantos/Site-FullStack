<?php

$c = array(
    'sitename' => 'Blue Sky',
    'siteslogan' => 'Just a blue sky',
    'sitelogo' => '<i class="fa-solid fa-laptop-code fa-fw"></i>',
    'sitefavicon' => '/img/favicon.jpg',
    'titlesep' => '&middot;&middot;&middot;'
);

$s = array(
    array(
        'name' => 'Facebook',
        'link' => 'https://facebook.com/Blue.Sky',
        'icon' => 'fa-square-facebook'
    ),
    array(
        'name' => 'Youtube',
        'link' => 'https://youtube.com/Blue.Sky',
        'icon' => 'fa-square-youtube'
    ),
    array(
        'name' => 'GitHub',
        'link' => 'https://github.com/Blue.Sky',
        'icon' => 'fa-square-github'
    )
);

$page_title = $page_content = $page_css = $page_js = '';
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'bluesky';

header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set('America/Sao_Paulo');

$conn = new mysqli($hostname, $username, $password, $database);

$conn->query("SET NAMES 'utf8'");
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');
$conn->query('SET GLOBAL lc_time_names = pt_BR');
$conn->query('SET lc_time_names = pt_BR');

require('functions.php');