<?php

require __DIR__.'/../inc/functions.php';
if (COMPOSER_AUTOLOAD) {
    require_once COMPOSER_AUTOLOAD;
}
require __DIR__.'/../controllers/PinnedImage.php';

/*
 * @author Rafael Vila <rvila@revolutionvisualarts.com>
 * @version 1.0.1v
 *
 * Processing HTML rendering to be send through an Ajax Request
 */

use raphievila\ImageTools\PinnedImage;

$pi = new PinnedImage($params);
