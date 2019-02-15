<?php
require __DIR__.'/../assets/inc/functions.php';
if (COMPOSER_AUTOLOAD) {
    require_once COMPOSER_AUTOLOAD;
}
require __DIR__.'/../assets/controllers/PinnedImage.php';

use xTags\xTags;
use Utils\Utils;
use raphievila\ImageTools\PinnedImage;

$x = new xTags();
$u = new Utils();
$params = array(
    'imageURL' => '../assets/img/test/test-image.png',
    'imageALT' => 'Screenshot of Windows 10 idea sumbitted last year',
    'containerRatio' => 219,
    'myCoords' => __DIR__.'/coords/coords.json',
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

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Pins Coordinates sent:');
                $u->echo_array($pi->test());
                echo '</div>';

                echo $x->h2('Sample Two (Left Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params2 = array(
                    'containerClass' => 'pinned-container-full',
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
                echo $x->h2('Parameters sent:');
                $u->echo_array($params2);
                echo '</div>';

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Pins Coordinates sent:');
                $u->echo_array($pi->test());
                echo '</div>';

                echo $x->h2('Sample Three (Right Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params2 = array(
                    'containerClass' => 'pinned-container-full',
                    'loadOrientation' => 'rightload',
                    'myCoords' => __DIR__.'/coords/rightload.json',
                );

                $pi->reload($params2);

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';

                echo $x->h2('Sample Four (Top Load)', 'class:col-md-12');
                echo $x->p('Resending different parameters by using '.$x->code('PinnedImage::reload').' method.', 'class:col-md-12');

                $params2 = array(
                    'containerClass' => 'pinned-container-full',
                    'loadOrientation' => 'topload',
                    'myCoords' => __DIR__.'/coords/topload.json',
                );

                $pi->reload($params2);

                try {
                    echo $x->div($pi->render(), 'class:col-md-12');
                } catch (Exception $e) {
                    echo $x->h2($e->getMessage(), 'class:bg-danger text-default p-3 col-md-12');
                }

                echo '<div class="col-md-12 p-5">';
                echo $x->h2('Loaded Parameters:');
                $u->echo_array($pi->check_loaded_parameters());
                echo '</div>';
            ?>
		</div>
	</div>
</body>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
<script src="../assets/scripts/pinned-image.js" type="text/javascript"></script>
</html>