<?php

namespace raphievila;

require 'process/PinnedExternals.php';

/*
 * @author 	Rafael Vila <rvila@revolutionvisualarts.com>
 *
 * @version 1.0.1v
 *
 * Creates a new way of image mapping less complicated than the
 * traditional image mapping find with the old HTML method since
 * was invented years ago. The goal is to create a library that
 * add map app style pinning.
 *
 * MIT License
 * Copyright (c) 2019 Rafael Vila <Revolution Visual Arts>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use xTags\xTags;
use Utils\Utils;
use raphievila\process\PinnedExternals;

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
    private static $imageBlur = false;
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
        'imageBlur',
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
            'imageBlur' => false,
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
        $paramsLoaded = array();
        foreach (self::$allowed as $key) {
            $paramsLoaded[$key] = self::${$key};
        }

        return (object) $paramsLoaded;
    }

    private static function _generate_label($info, $setID, $coords, $icon, $fullTemplate)
    {
        $x = new xTags();

        //Preparing Icon Attribute
        $iconAttr = ($icon) ? ',style:background-image..url(\''.$x->processText(htmlspecialchars($icon)).'\');' : '';

        //Setting up Pin Label
        $extraClass = (isset($info->class)) ? ' '.htmlspecialchars($info->class) : '';
        $setCoords = ($fullTemplate) ? $coords : '';
        $labelRel = ($fullTemplate) ? ',rel:'.$setID : '';
        $label = htmlspecialchars($info->label);
        $labelXML = $x->a($x->span($label), 'class:pinned-point-label'.$extraClass.$labelRel.$setCoords.$iconAttr);

        return (object) ['label' => $label, 'html' => $labelXML];
    }

    private static function __process_external_content($dataset)
    {
        if (!self::$u->isMap($dataset)) {
            throw new \Exception('The external set has to be an object', 500);
        }

        $x = new xTags();
        $pe = new PinnedExternals();
        $set = array();

        foreach ($dataset as $type => $data) {
            switch ($type) {
                case 'list':
                    $set[] = $pe::__prepare_external_list($data);
                    break;
                case 'curl':
                    $set[] = $pe::__prepare_external_curl($data);
                    // no break
                default:
                    //HTML FILE HAS TO BE LOCAL
                    $set[] = $pe::__prepare_external_html($data);
            }
        }

        return (count($set) > 0) ? $x->div(join("\r", $set), 'class:pinned-point-external') : false;
    }

    private static function _finalizing_pin($info, $tipText, $setID, $coords, $labelXML, $fullTemplate)
    {
        $x = new xTags();

        //filtering title
        $title = (isset($info->title)) ? $x->h3(htmlspecialchars($info->title), 'class:pinned-point-title') : '';

        //Entering external html content by setting "external": {"html": "HTML content url"}
        $externalContent = (isset($info->external)) ? self::__process_external_content($info->external) : '';

        //Setting .pinned-point-banner and it's content
        $sticker = ($tipText) ? $x->p($tipText, 'class:pinned-point-banner') : '';

        //Set ID
        $tipID = ($fullTemplate) ? ',id:'.$setID : '';

        //Create Button
        $button = (isset($info->url) && filter_var($info->url, FILTER_VALIDATE_URL))
            ? $x->a(htmlspecialchars($info->url), 'class:pinned-point-button btn btn-primary')
            : '';

        //Creating content for .pinned-point-sticker
        $tip = $x->div($x->div($title.$sticker.$button, 'class:pinned-point-tip-sticker'), 'class:pinned-point-tip'.$tipID);

        return (!$fullTemplate)
            ? $x->div($labelXML.$tip, 'class:pinned-point,id:'.$x->processText($setID).$coords)
            : $labelXML.$tip;
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

            //Setting up Icon
            $icon = (isset($info->iconUrl)) ? $info->iconUrl : null;

            //Setting up Pin Label
            $labelSet = self::_generate_label($info, $setID, $coords, $icon, $fullTemplate);
            $label = $labelSet->label;
            $labelXML = $labelSet->html;

            //Setting Tip
            $tipText = (isset($info->tip)) ? htmlspecialchars($info->tip) : false;

            //required value have to be set, if not throw exception
            if (!$tipText) {
                throw new \Exception('Parameter <code>tip</code> not set on Pin List. Tip explanation have to be set, check the Parameters documentation.', 500);
            }

            //Generating final pin HTML
            $pin[] = self::_finalizing_pin($info, $tipText, $setID, $coords, $labelXML, $fullTemplate);

            self::$noscriptSet[$label] = (object) array('text' => $tipText, 'icon' => $icon);
        }

        return (count($pin) > 0) ? join("\r", $pin) : false;
    }

    public static function no_script_object()
    {
        return self::$noscriptSet;
    }

    private static function _get_file_name($iconURL)
    {
        return preg_replace('/(.*?/)?([\w\d\-_]+\.\w{3,4})', '$2', $iconURL);
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

        foreach ($list as $label => $items) {
            //Check if icon has been set
            $icon = (isset($items->icon)) ? ': '.$x->img($items->icon, ['class' => 'pinned-legend-icon', 'alt' => self::_get_file_name($items->icon)]) : '';
            //Setting up flex items
            $labelTag = $x->div($label.$icon, 'class:pinned-flex-item w5 text-center');
            $tipTag = $x->div($items->text, 'class:pinned-flex-item w95');
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
        $img .= (self::$imageBlur) ? $x->img(self::$imageBlur, 'class:pinned-image-blur,alt:'.$x->processText(self::$imageALT)) : '';

        //GET RENDERED PINS;
        $pins = self::_render_pins_as_html();

        if (!self::$ignoreNoScript) {
            $noScriptHTML = self::__process_noscript_legend(self::$containerID);
            $noScript = (!self::$forceLegend) ? $x->noscript($noScriptHTML) : $x->div($noScriptHTML, 'class:pinned-legend');
        }

        return $x->div($img.$pins, 'id:'.htmlspecialchars(self::$containerID).',class:'.htmlspecialchars(self::$containerClass).$ratio.$load).$noScript;
    }
}
