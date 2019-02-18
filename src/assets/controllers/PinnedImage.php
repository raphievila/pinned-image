<?php

namespace raphievila\ImageTools;

/*
 * @author 	Rafael Vila <rvila@revolutionvisualarts.com>
 *
 * @version 1.0.1v
 *
 * Creates a new way of image mapping less complicated than the
 * traditional image mapping find with the old HTML method since
 * was invented years ago. The goal is to create a library that
 * add map app style pinning.
 */

use xTags\xTags;
use Utils\Utils;

class PinnedImage
{
    //Container Modifiers
    private static $containerID = 'PinnedImage';
    private static $containerRatio = false;
    private static $containerClass = 'pinned-container';
    private static $loadOrientation = false;
    //Image Modifiers
    private static $imageURL = '';
    private static $imageALT = 'PinnedImage &copy;2019 Revolution Visual Arts';
    //Data Modifiers
    private static $ignoreNoScript = false;
    private static $forceLegend = false;
    private static $myCoords = false;
    //Do not change
    private static $data;
    private static $u;
    private static $allowed = array(
        'containerClass',
        'containerID',
        'containerRatio',
        'forceLegend',
        'ignoreNoScript',
        'imageURL',
        'imageALT',
        'loadOrientation',
        'myCoords',
    );
    private static $noscriptSet = false;

    public function __construct($params = false)
    {
        self::$u = new Utils();

        //Loading Parameters
        if (self::$u->isMap($params)) {
            self::__load_parameters($params);
        }
    }

    private static function __load_parameters($params)
    {
        $defaults = array(
            'containerID' => 'PinnedImage',
            'containerRatio' => 169,
            'containerClass' => 'pinned-container',
            'forceLegend' => false,
            'ignoreNoScript' => false,
            'imageURL' => false,
            'imageALT' => 'PinnedImage &copy;2019 Revolution Visual Arts',
            'loadOrientation' => false,
            'myCoords' => false,
        );

        if (is_object($params)) {
            $params = (array) $params;
        }

        foreach ($defaults as $k => $v) {
            if (!isset($params[$k])) {
                self::${$k} = $v;
            } elseif (isset($params[$k]) && in_array($k, self::$allowed)) {
                self::${$k} = htmlspecialchars($params[$k]);
            }
        }

        //Getting data from configuration json
        self::$data = self::__loading_json();
    }

    public static function reload($params)
    {
        if (!self::$u->isMap($params)) {
            throw new \Exception('Parameters sent on a wrong format, Check documentation', 500);
        }

        self::__load_parameters($params);
    }

    private static function __loading_json()
    {
        $jsonlocation = (!self::$myCoords) ? __DIR__.'/../scripts/coords.json' : self::$myCoords;

        //Verifying file was not removed accidentally :S
        if (!file_exists($jsonlocation)) {
            throw new \Exception('Unable to find configuration data. Please create new JSON file under /src/assets/scripts/coords.json or make sure URL provided is correct', 500);
        }

        $json = file_get_contents($jsonlocation);
        $data = json_decode($json);

        return $data;
    }

    public static function test()
    {
        return self::$data;
    }

    public static function check_loaded_parameters()
    {
        $paramsLoaded = [];
        foreach (self::$allowed as $key) {
            $paramsLoaded[$key] = self::${$key};
        }

        return (object) $paramsLoaded;
    }

    private static function _render_pins_as_html()
    {
        $u = new Utils();
        $x = new xTags();
        $pinData = self::$data;
        $pin = array();
        $fullTemplate = preg_match('/\-full$/', self::$containerClass);

        if (!$u->isMap($pinData)) {
            throw new \Exception('Not proper data format. Check documentation.', 500);
        }

        foreach ($pinData as $id => $info) {
            //Setting Pin ID
            $setID = (isset($info->id)) ? htmlspecialchars($info->id) : 'pin'.abs($id);

            //Coordinate attributes
            $coords = ',data-x:'.htmlspecialchars($info->x).'%,data-y:'.htmlspecialchars($info->y).'%';

            //Setting up Pin Label
            $extraClass = (isset($info->class)) ? ' '.htmlspecialchars($info->class) : '';
            $setCoords = ($fullTemplate) ? $coords : '';
            $labelRel = ($fullTemplate) ? ',rel:'.$setID : '';
            $label = htmlspecialchars($info->label);
            $labelXML = $x->a($x->span($label), 'class:pinned-point-label'.$extraClass.$labelRel.$setCoords);

            //Setting Tip
            $tipText = (isset($info->tip)) ? htmlspecialchars($info->tip) : false;

            //required value have to be set, if not new to throw exception
            if (!$tipText) {
                throw new \Exception('Parameter <code>tip</code> not set on Pin List. Tip explanation have to be set, check the Parameters documentation.', 500);
            }

            $title = (isset($info->title)) ? $x->h3(htmlspecialchars($info->title), 'class:pinned-point-title') : '';
            $sticker = ($tipText) ? $x->p($tipText, 'class:pinned-point-banner') : '';
            $tipID = ($fullTemplate) ? ',id:'.$setID : '';
            $button = (isset($info->url) && filter_var($info->url, FILTER_VALIDATE_URL))
                ? $x->a(htmlspecialchars($info->url), 'class:pinned-point-button btn btn-primary')
                : '';
            $tip = $x->div($x->div($title.$sticker.$button, 'class:pinned-point-tip-sticker'), 'class:pinned-point-tip'.$tipID);

            $pin[] = (!$fullTemplate)
                ? $x->div($labelXML.$tip, 'class:pinned-point,id:'.$x->processText($setID).$coords)
                : $labelXML.$tip;

            self::$noscriptSet[$label] = $tipText;
        }

        return (count($pin) > 0) ? join("\r", $pin) : false;
    }

    public static function no_script_object()
    {
        return self::$noscriptSet;
    }

    private static function __process_noscript_legend($containerID)
    {
        $x = new xTags();
        $tipList = array();
        $noscriptItem = false;
        $list = self::$noscriptSet;

        if (!self::$u->isMap($list) || (self::$u->isMap($list) && count($list) === 0)) {
            throw new \Exception('List sent not properly formatted, make sure is a map or array', 500);
        }

        foreach ($list as $label => $tip) {
            //Setting up flex items
            $labelTag = $x->div($label, 'class:pinned-flex-item w5 text-center');
            $tipTag = $x->div($tip, 'class:pinned-flex-item w95');
            //Setting up flex row
            $tipList[] = $x->div($labelTag.$tipTag, 'class:pinned-flex-row,');
        }

        if (count($tipList) > 0) {
            $noscriptItem = $x->div(join("\r", $tipList), 'class:pinned-flex-column p-2,id:'.$containerID.'-legend,rel:'.$containerID);
        }

        self::$noscriptSet = array();

        return $noscriptItem;
    }

    public static function render()
    {
        $x = new xTags();
        $imageURL = self::$imageURL;
        $noScript = '';

        if (empty($imageURL) || (is_bool($imageURL))) {
            throw new \Exception('Requires image location, has to be a proper URL format', 500);
        }

        //CONTAINER CONFIGURATION VARIABLE
        $ratio = (is_numeric(self::$containerRatio)) ? ' r'.self::$containerRatio : '';
        $load = (is_string(self::$loadOrientation)) ? ',data-template:'.htmlspecialchars(self::$loadOrientation) : '';
        $img = $x->img(self::$imageURL, 'class:pinned-image,alt:'.$x->processText(self::$imageALT));

        //GET RENDERED PINS;
        $pins = self::_render_pins_as_html();

        if (!self::$ignoreNoScript) {
            $noScriptHTML = self::__process_noscript_legend(self::$containerID);
            $noScript = (!self::$forceLegend) ? $x->noscript($noScriptHTML) : $x->div($noScriptHTML, 'class:pinned-legend');
        }

        return $x->div($img.$pins, 'id:'.htmlspecialchars(self::$containerID).',class:'.htmlspecialchars(self::$containerClass).$ratio.$load).$noScript;
    }
}
