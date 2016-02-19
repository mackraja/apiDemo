<?php

// Configuration file
// echo $var = $security->encode("");
// echo "</br>";
// echo $security->decode($var);
// Below data must be in encrypted form
$config = array(
    // These are the settings for development mode
    'dev' => array(
        'db' => array(
            'host' => 'localhost',
            'dbname' => 'Wl8t7ZzWOkGMIlxBMsgg5f0QorTe3-N6WNar7VmU7YU',
            'username' => 'PwCduydCknTC-B_MINywCM769T2-QZoz2E5qwcJw3Qo',
            'password' => 'cSLFemcMeG7-Sibf9O013CojhjVHsliCGPBa9cUmhzk',
            ),
        ),
    // These are the settings for production mode
    'pro' => array(
        'db' => array(
            'host' => '',
            'dbname' => '',
            'username' => '',
            'password' => '',
            ),
        ),
    );

$actions = array(
        'login' => 'login',
        'customer_register' => 'customerRegister',
        'customer_search' => 'customerSearch'
    );
