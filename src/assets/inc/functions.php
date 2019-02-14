<?php
/**
 * @author Rafael Vila <rvila@revolutionvisualarts.com>
 *
 * @version 1.0.1
 * @date    2019/02/12
 */
$configFile = parse_ini_file(__DIR__.'/../config/pi.ini', true);
$autoload = false;

if (isset($configFile['composer']['autoload'])) {
    $autoload = str_replace('[__DIR__]', __DIR__, $configFile['composer']['autoload']);
}

define('COMPOSER_AUTOLOAD', $autoload);
