<?php

require __DIR__.'/../controllers/PinnedImage.php';
/*
 * @author  Rafael Vila <rvila@revolutionvisualarts.com>
 * @version 1.0.1v
 *
 * PinnedImage Views controller
 */

use raphievila\ImageTools\PinnedImage;
use Utils\Utils;

$pi = new PinnedImage();
$u = new Utils();

$coords = $pi->test();

header('HTTP/1.0 200 OK');
header('Content-type: application/json; charset="UTF-8"');

json_encode($coords);
