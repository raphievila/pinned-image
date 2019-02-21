<?php
require __DIR__.'/../assets/inc/functions.php';
require COMPOSER_AUTOLOAD;
require __DIR__.'/../assets/controllers/PinnedImage.php';

use xTags\xTags;
use Utils\Utils;
use raphievila\PinnedImage;

$x = new xTags();
$u = new Utils();
$params = array(
    'containerID' => 'PinnedDefault',
    'imageURL' => '../assets/img/test/test-image.png',
    'imageBlur' => '../assets/img/test/test-image-blur.png',
    'imageALT' => 'Screenshot of Windows 10 idea sumbitted last year',
    'containerRatio' => 219,
    'myCoords' => __DIR__.'/coords/coords.json',
    'forceLegend' => true,
);
$pi = new PinnedImage($params);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Pinned Sample PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/styles/css/pinned-image.css" />
</head>
<body>
	<div class="container-fluid">
		<div class="row p-5">
			<?php
                //first example
                echo $x->h1('Pinned Image using PHP', 'class:col-md-12');
                echo $x->h2('Sample One', 'class:col-md-12');
                echo $x->p('In this example we are loading required libraries through Composer, but adding PinnedImage object directly in the code.', 'class:col-md-12');

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Parameters sent:');
                $u->echo_array($params);
                echo '</div>';

                echo $x->blockquote('Notice the '.$x->code('forceLegend').' parameter has been set to -true- even though is showing a number 1, which is its normal behaviour, is still a boolean. When this parameter is set, the legend only shown when JavaScript is inactive will be force to display by removing the content from the '.$x->code('&lt;noscript/&gt;').' tag and placing in its own container with class '.$x->code('.pinned-legend').'.', array('class' => 'testing-array'));

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Pins Coordinates sent:');
                $u->echo_array($pi->test());
                echo '</div>';

                //Sample 2
                echo $x->h2('Sample Two (Full Left Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params2 = array(
                    'containerID' => 'PinnedLeft',
                    'containerClass' => 'pinned-container-full',
                    'containerRatio' => 219,
                    'imageURL' => '../assets/img/test/test-image.png',
                    'imageBlur' => '../assets/img/test/test-image-blur.png',
                    'imageALT' => 'Screenshot of Windows 10 idea sumbitted last year',
                    'loadOrientation' => 'leftload',
                    'myCoords' => __DIR__.'/coords/leftload.json',
                );

                $pi->reload($params2);

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h3('Parameters sent:');
                $u->echo_array($params2);
                echo '</div>';

                echo '<div class="col-md-12 p-5">';
                echo $x->h3('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';

                echo '<div class="col-md-12 p-5">';
                echo $x->h3('Pins Coordinates sent:');
                $u->echo_array($pi->test());
                echo '</div>';

                //Sample 3
                echo $x->h2('Sample Three (full Right Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params3 = array(
                    'containerID' => 'PinnedRight',
                    'containerClass' => 'pinned-container-full',
                    'containerRatio' => 219,
                    'imageURL' => '../assets/img/test/test-image.png',
                    'imageALT' => 'Screenshot of Windows 10 idea sumbitted last year',
                    'loadOrientation' => 'rightload',
                    'myCoords' => __DIR__.'/coords/rightload.json',
                );

                $pi->reload($params3);

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h3('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';

                //Sample 4
                echo $x->h2('Sample Four (Top Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params4 = array(
                    'containerID' => 'PinnedTop',
                    'containerClass' => 'pinned-container-full',
                    'containerRatio' => 219,
                    'imageURL' => '../assets/img/test/test-image.png',
                    'imageALT' => 'Screenshot of Windows 10 idea sumbitted last year',
                    'loadOrientation' => 'topload',
                    'myCoords' => __DIR__.'/coords/topload.json',
                );

                $pi->reload($params4);

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h3('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';

                //Sample 5
                echo $x->h2('Sample Four (Full Default -- Bottom Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params5 = array(
                    'containerID' => 'PinnedFullDefault',
                    'containerClass' => 'pinned-container-full',
                    'containerRatio' => 219,
                    'imageURL' => '../assets/img/test/test-image.png',
                    'imageALT' => 'Screenshot of Windows 10 idea sumbitted last year',
                    'myCoords' => __DIR__.'/coords/fulldefault.json',
                );

                $pi->reload($params5);

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h3('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';
            ?>
		</div>
	</div>
</body>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
<script type="text/javascript">
    'use strict';
    var AUTOLOAD = false,
        MYCOORDS = 'coords/coords.json';
</script>
<script src="../assets/scripts/pinned-image.js" type="text/javascript"></script>
</html>