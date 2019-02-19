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
/*global jQuery,document,window,screen,$,AUTOLOAD,MYCOORDS */
'use strict;'
var coords,
    contract,
    loadCoords,
    setPoints,
    setListener,
    setListenerFull,
    defaultSet,
    fullSet;

contract = function (e) {
    var me = jQuery(e),
        closing = me.parent(),
        container = closing.parent('.pinned-container,.pinned-container-full');

    closing.removeClass('expanded').removeClass('pinned-focus');
    container.find('.pinned-image-blur').removeClass('show');
}

loadCoords = function () {
    var config = (MYCOORDS !== undefined) ? MYCOORDS : 'coords.json';
    $.ajax({
        url: config,
        type: 'json',
        success: function (data) {
            console.log(data);
        },
        error: function (data) {
            console.log(config);
            console.log(data.responseText);
        }
    });
}

setListener = function (me) {
    var pin = me,
        label = pin.children('.pinned-point-label'),
        tip = pin.children('.pinned-point-tip')
        myParent = me.parent('.pinned-container,.pinned-container-full');

    label.on('click', function () {
        myParent.find('.pinned-point-tip').not(tip).removeClass('expanded');
        myParent.find('.pinned-point').not(me).removeClass('pinned-focus');
        me.toggleClass('pinned-focus');
        tip.toggleClass('expanded');

        if (me.hasClass('pinned-focus')) {
            myParent.find('.pinned-image-blur').addClass('show');
        } else {
            myParent.find('.pinned-image-blur').removeClass('show');
        }
    });
}

setListenerFull = function (label) {
    var id = label.attr('rel'),
        tip = jQuery('#' + id),
        myParent = tip.parent('.pinned-container,.pinned-container-full');

    tip.append('<a class="closeBtn" onclick="contract(this);"><span class="closeOne"></span><span class="closeTwo"></span></a>');

    label.on('click', function () {
        jQuery('.pinned-point-tip').not(tip).removeClass('expanded').removeClass('pinned-focus');
        tip.toggleClass('pinned-focus').toggleClass('expanded');

        if (tip.hasClass('pinned-focus')) {
            myParent.find('.pinned-image-blur').addClass('show');
        } else {
            myParent.find('.pinned-image-blur').removeClass('show');
        }
    });
}

defaultSet = function (me) {
    me.children('.pinned-point').each(function () {
        var pin = jQuery(this),
            x = jQuery(this).attr('data-x'),
            y = jQuery(this).attr('data-y');

        if (x !== undefined) {
            pin.css({ 'margin-left': x });
        }

        if (y !== undefined) {
            pin.css({ 'margin-top': y });
        }

        setListener(pin);
    });
}

fullSet = function (me) {
    me.children('.pinned-point-label').each(function () {
        var pin = jQuery(this),
            x = pin.attr('data-x'),
            y = pin.attr('data-y');

        if (x !== undefined) {
            pin.css({ 'margin-left': x });
        }

        if (y !== undefined) {
            pin.css({ 'margin-top': y });
        }

        setListenerFull(pin);
    });
}

setPoints = function () {
    var template = false;

    jQuery('.pinned-container').each(function () {
        defaultSet(jQuery(this));
    });

    jQuery('.pinned-container-full').each(function () {
        fullSet(jQuery(this));
    });
}

jQuery(document).ready(function () {
    setPoints();

    if (AUTOLOAD !== undefined && AUTOLOAD) {
        loadCoords();
    }
});