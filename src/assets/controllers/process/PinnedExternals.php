<?php

namespace raphievila\process;

/*
 * @author 	Rafael Vila <rvila@revolutionvisualarts.com>
 *
 * @version 1.0.1v
 *
 * Processing external content for PinnedImage object.
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

class PinnedExternals
{
    public static function __prepare_external_curl($data)
    {
        $x = new xTags();
        $u = new Utils();
        $html = false;

        if (filter_var($data, FILTER_VALIDATE_URL)) {
            try {
                $html = $u->curl_session_integrity($data);
            } catch (\Exception $e) {
                $html = $x->comment($e->getMessage());
            }
        } else {
            $html = $x->comment('Not a valid URL received');
        }

        return $html;
    }

    public static function __prepare_external_html($data)
    {
        $x = new xTags();
        $u = new Utils();
        $html = false;

        if (!is_string($data)) {
            return $x->comment('HTML reference can only be a string');
        }

        $file = str_replace('[__DIR__]', __DIR__, $data);

        if (file_exists($file)) {
            $html = file_get_contents($file);
        }

        return '<div class="pinned-point-external-html">'.$html.'</div>';
    }

    public static function __prepare_external_list($data)
    {
        $x = new xTags();
        $u = new Utils();
        $list = [];

        if (!$u->isMap($data)) {
            return $x->comment('List has to be send as an array');
        }

        foreach ($data as $text) {
            $list[] = preg_replace('/(.*?)([\s]?on[\w]+=".*?"|[\s]?href="javascript\:.*?")+(.*?)/', '$1$3', strip_tags($text, '<a><h5><h6><div><section><article><button>'));
        }

        return (count($list) > 0) ? $x->ol($x->li(join("</li>\r<li>", $list)), ['class' => 'pinned-point-external-list']) : false;
    }
}
