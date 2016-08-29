var server = "https://safe-shelf-6136.herokuapp.com",
    api = "/book/discount/week/",
    source = [
        "taaze",
        "bookscom",
        "sanmin",
        "iread"
    ],
    index = 0,
    unserialize = require('locutus/php/var/unserialize'),
    phpUnserialize = require('phpUnserialize/phpUnserialize');

var task = (function() {
    return {
        getData: function(storename, store_length) {
            var service = server.concat(api.concat(storename));

            $.ajax({
                url: service,
                method: "GET",
                dataType: "json",
                xhrFields: {
                    withCredentials: true
                },
                success: function(rawData) {
                    if (storename == "iread") {
                        var clearData = phpUnserialize(decodeURIComponent(rawData.data));
                    } else {
                        var clearData = unserialize(decodeURIComponent(rawData.data));
                    }
                    console.log(clearData);
                    $.each(clearData, function(index, value) {
                        var htmlContent = "<li class=\"col-lg-3 col-sm-6\">\
                                <figure>\
                                    <img src=\"" + value.img + "\" width=\"240\" height=\"360\">\
                                    <figcaption>\
                                        <h3>" + value.date + "</h3>\
                                        <span>" + value.bookName + "<br>\
                                        特價: " + value.price + " 元<br>\
                                        折數: " + value.discount + " 折<br>\
                                        </span>\
                                        <a href=\"" + value.link + "\" target=\"_blank\">Go</a>\
                                    </figcaption>\
                                </figure>\
                            </li>";

                        $("ul.grid.cs-style-1").append(htmlContent);
                    });
                },
                error: function() {
                    var failed = [
                        status => "failed",
                        message => "Cant' fetch the data at " . service,
                    ];
                    console.log(failed);
                },
                complete: function() {
                    index++;
                    if (index == store_length) {
                        touch(window);
                    }
                }
            });
        }
    }
})();

/** Used Only For Touch Devices **/
var touch = function( window ) {
    // for touch devices: add class cs-hover to the figures when touching the items
    if( Modernizr.touch ) {

        // classie.js https://github.com/desandro/classie/blob/master/classie.js
        // class helper functions from bonzo https://github.com/ded/bonzo

        function classReg( className ) {
            return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
        }

        // classList support for class management
        // altho to be fair, the api sucks because it won't accept multiple classes at once
        var hasClass, addClass, removeClass;

        if ( 'classList' in document.documentElement ) {
            hasClass = function( elem, c ) {
                return elem.classList.contains( c );
            };
            addClass = function( elem, c ) {
                elem.classList.add( c );
            };
            removeClass = function( elem, c ) {
                elem.classList.remove( c );
            };
        }
        else {
            hasClass = function( elem, c ) {
                return classReg( c ).test( elem.className );
            };
            addClass = function( elem, c ) {
                if ( !hasClass( elem, c ) ) {
                        elem.className = elem.className + ' ' + c;
                }
            };
            removeClass = function( elem, c ) {
                elem.className = elem.className.replace( classReg( c ), ' ' );
            };
        }

        function toggleClass( elem, c ) {
            var fn = hasClass( elem, c ) ? removeClass : addClass;
            fn( elem, c );
        }

        var classie = {
            // full names
            hasClass: hasClass,
            addClass: addClass,
            removeClass: removeClass,
            toggleClass: toggleClass,
            // short names
            has: hasClass,
            add: addClass,
            remove: removeClass,
            toggle: toggleClass
        };

        // transport
        if ( typeof define === 'function' && define.amd ) {
            // AMD
            define( classie );
        } else {
            // browser global
            window.classie = classie;
        }

        [].slice.call( document.querySelectorAll( 'ul.grid > li > figure' ) ).forEach( function( el, i ) {
            el.querySelector( 'figcaption > a' ).addEventListener( 'touchstart', function(e) {
                e.stopPropagation();
            }, false );
            el.addEventListener( 'touchstart', function(e) {
                classie.toggle( this, 'cs-hover' );
            }, false );
        } );
    }
}

for (var i = 0; i < source.length; i++) {
    task.getData(source[i], source.length);
}
