(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

module.exports = function unserialize(data) {
  //  discuss at: http://locutus.io/php/unserialize/
  // original by: Arpad Ray (mailto:arpad@php.net)
  // improved by: Pedro Tainha (http://www.pedrotainha.com)
  // improved by: Kevin van Zonneveld (http://kvz.io)
  // improved by: Kevin van Zonneveld (http://kvz.io)
  // improved by: Chris
  // improved by: James
  // improved by: Le Torbi
  // improved by: Eli Skeggs
  // bugfixed by: dptr1988
  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: d3x
  //    input by: Brett Zamir (http://brett-zamir.me)
  //    input by: Martin (http://www.erlenwiese.de/)
  //    input by: kilops
  //    input by: Jaroslaw Czarniak
  //      note 1: We feel the main purpose of this function should be
  //      note 1: to ease the transport of data between php & js
  //      note 1: Aiming for PHP-compatibility, we have to translate objects to arrays
  //   example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}')
  //   returns 1: ['Kevin', 'van', 'Zonneveld']
  //   example 2: unserialize('a:2:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";}')
  //   returns 2: {firstName: 'Kevin', midName: 'van'}

  var $global = typeof window !== 'undefined' ? window : GLOBAL;

  var utf8Overhead = function utf8Overhead(chr) {
    // http://locutus.io/php/unserialize:571#comment_95906
    var code = chr.charCodeAt(0);
    var zeroCodes = [338, 339, 352, 353, 376, 402, 8211, 8212, 8216, 8217, 8218, 8220, 8221, 8222, 8224, 8225, 8226, 8230, 8240, 8364, 8482];
    if (code < 0x0080 || code >= 0x00A0 && code <= 0x00FF || zeroCodes.indexOf(code) !== -1) {
      return 0;
    }
    if (code < 0x0800) {
      return 1;
    }
    return 2;
  };
  var error = function error(type, msg, filename, line) {
    throw new $global[type](msg, filename, line);
  };
  var readUntil = function readUntil(data, offset, stopchr) {
    var i = 2;
    var buf = [];
    var chr = data.slice(offset, offset + 1);

    while (chr !== stopchr) {
      if (i + offset > data.length) {
        error('Error', 'Invalid');
      }
      buf.push(chr);
      chr = data.slice(offset + (i - 1), offset + i);
      i += 1;
    }
    return [buf.length, buf.join('')];
  };
  var readChrs = function readChrs(data, offset, length) {
    var i, chr, buf;

    buf = [];
    for (i = 0; i < length; i++) {
      chr = data.slice(offset + (i - 1), offset + i);
      buf.push(chr);
      length -= utf8Overhead(chr);
    }
    return [buf.length, buf.join('')];
  };
  var _unserialize = function _unserialize(data, offset) {
    var dtype;
    var dataoffset;
    var keyandchrs;
    var keys;
    var contig;
    var length;
    var array;
    var readdata;
    var readData;
    var ccount;
    var stringlength;
    var i;
    var key;
    var kprops;
    var kchrs;
    var vprops;
    var vchrs;
    var value;
    var chrs = 0;
    var typeconvert = function typeconvert(x) {
      return x;
    };

    if (!offset) {
      offset = 0;
    }
    dtype = data.slice(offset, offset + 1).toLowerCase();

    dataoffset = offset + 2;

    switch (dtype) {
      case 'i':
        typeconvert = function typeconvert(x) {
          return parseInt(x, 10);
        };
        readData = readUntil(data, dataoffset, ';');
        chrs = readData[0];
        readdata = readData[1];
        dataoffset += chrs + 1;
        break;
      case 'b':
        typeconvert = function typeconvert(x) {
          return parseInt(x, 10) !== 0;
        };
        readData = readUntil(data, dataoffset, ';');
        chrs = readData[0];
        readdata = readData[1];
        dataoffset += chrs + 1;
        break;
      case 'd':
        typeconvert = function typeconvert(x) {
          return parseFloat(x);
        };
        readData = readUntil(data, dataoffset, ';');
        chrs = readData[0];
        readdata = readData[1];
        dataoffset += chrs + 1;
        break;
      case 'n':
        readdata = null;
        break;
      case 's':
        ccount = readUntil(data, dataoffset, ':');
        chrs = ccount[0];
        stringlength = ccount[1];
        dataoffset += chrs + 2;

        readData = readChrs(data, dataoffset + 1, parseInt(stringlength, 10));
        chrs = readData[0];
        readdata = readData[1];
        dataoffset += chrs + 2;
        if (chrs !== parseInt(stringlength, 10) && chrs !== readdata.length) {
          error('SyntaxError', 'String length mismatch');
        }
        break;
      case 'a':
        readdata = {};

        keyandchrs = readUntil(data, dataoffset, ':');
        chrs = keyandchrs[0];
        keys = keyandchrs[1];
        dataoffset += chrs + 2;

        length = parseInt(keys, 10);
        contig = true;

        for (i = 0; i < length; i++) {
          kprops = _unserialize(data, dataoffset);
          kchrs = kprops[1];
          key = kprops[2];
          dataoffset += kchrs;

          vprops = _unserialize(data, dataoffset);
          vchrs = vprops[1];
          value = vprops[2];
          dataoffset += vchrs;

          if (key !== i) {
            contig = false;
          }

          readdata[key] = value;
        }

        if (contig) {
          array = new Array(length);
          for (i = 0; i < length; i++) {
            array[i] = readdata[i];
          }
          readdata = array;
        }

        dataoffset += 1;
        break;
      default:
        error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
        break;
    }
    return [dtype, dataoffset - offset, typeconvert(readdata)];
  };

  return _unserialize(data + '', 0)[2];
};

},{}],2:[function(require,module,exports){
/*!
 * php-unserialize-js JavaScript Library
 * https://github.com/bd808/php-unserialize-js
 *
 * Copyright 2013 Bryan Davis and contributors
 * Released under the MIT license
 * http://www.opensource.org/licenses/MIT
 */

(function (root, factory) {
  /*global define, exports, module */
  "use strict";

  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define([], factory);
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory();
  } else {
    // Browser globals (root is window)
    root.phpUnserialize = factory();
  }
}(this, function () {
  "use strict";

  /**
   * Parse php serialized data into js objects.
   *
   * @param {String} phpstr Php serialized string to parse
   * @return {mixed} Parsed result
   */
  return function (phpstr) {
    var idx = 0
      , refStack = []
      , ridx = 0
      , parseNext // forward declaraton for "use strict"

      , readLength = function () {
          var del = phpstr.indexOf(':', idx)
            , val = phpstr.substring(idx, del);
          idx = del + 2;
          return parseInt(val, 10);
        } //end readLength

      , readInt = function () {
          var del = phpstr.indexOf(';', idx)
            , val = phpstr.substring(idx, del);
          idx = del + 1;
          return parseInt(val, 10);
        } //end readInt

      , parseAsInt = function () {
          var val = readInt();
          refStack[ridx++] = val;
          return val;
        } //end parseAsInt

      , parseAsFloat = function () {
          var del = phpstr.indexOf(';', idx)
            , val = phpstr.substring(idx, del);
          idx = del + 1;
          val = parseFloat(val);
          refStack[ridx++] = val;
          return val;
        } //end parseAsFloat

      , parseAsBoolean = function () {
          var del = phpstr.indexOf(';', idx)
            , val = phpstr.substring(idx, del);
          idx = del + 1;
          val = ("1" === val)? true: false;
          refStack[ridx++] = val;
          return val;
        } //end parseAsBoolean

      , readString = function () {
          var len = readLength()
            , utfLen = 0
            , bytes = 0
            , ch
            , val;
          while (bytes < len) {
            ch = phpstr.charCodeAt(idx + utfLen++);
            if (ch <= 0x007F) {
              bytes++;
            } else if (ch > 0x07FF) {
              bytes += 3;
            } else {
              bytes += 2;
            }
          }
          val = phpstr.substring(idx, idx + utfLen);
          idx += utfLen + 2;
          return val;
        } //end readString

      , parseAsString = function () {
          var val = readString();
          refStack[ridx++] = val;
          return val;
        } //end parseAsString

      , readType = function () {
          var type = phpstr.charAt(idx);
          idx += 2;
          return type;
        } //end readType

      , readKey = function () {
          var type = readType();
          switch (type) {
            case 'i': return readInt();
            case 's': return readString();
            default:
              throw {
                name: "Parse Error",
                message: "Unknown key type '" + type + "' at position " +
                    (idx - 2)
              };
          } //end switch
        }

      , parseAsArray = function () {
          var len = readLength()
            , resultArray = []
            , resultHash = {}
            , keep = resultArray
            , lref = ridx++
            , key
            , val
            , i
            , j
            , alen;

          refStack[lref] = keep;
          for (i = 0; i < len; i++) {
            key = readKey();
            val = parseNext();
            if (keep === resultArray && parseInt(key, 10) === i) {
              // store in array version
              resultArray.push(val);

            } else {
              if (keep !== resultHash) {
                // found first non-sequential numeric key
                // convert existing data to hash
                for (j = 0, alen = resultArray.length; j < alen; j++) {
                  resultHash[j] = resultArray[j];
                }
                keep = resultHash;
                refStack[lref] = keep;
              }
              resultHash[key] = val;
            } //end if
          } //end for

          idx++;
          return keep;
        } //end parseAsArray

      , fixPropertyName = function (parsedName, baseClassName) {
          var class_name
            , prop_name
            , pos;
          if ("\u0000" === parsedName.charAt(0)) {
            // "<NUL>*<NUL>property"
            // "<NUL>class<NUL>property"
            pos = parsedName.indexOf("\u0000", 1);
            if (pos > 0) {
              class_name = parsedName.substring(1, pos);
              prop_name  = parsedName.substr(pos + 1);

              if ("*" === class_name) {
                // protected
                return prop_name;
              } else if (baseClassName === class_name) {
                // own private
                return prop_name;
              } else {
                // private of a descendant
                return class_name + "::" + prop_name;

                // On the one hand, we need to prefix property name with
                // class name, because parent and child classes both may
                // have private property with same name. We don't want
                // just to overwrite it and lose something.
                //
                // On the other hand, property name can be "foo::bar"
                //
                //     $obj = new stdClass();
                //     $obj->{"foo::bar"} = 42;
                //     // any user-defined class can do this by default
                //
                // and such property also can overwrite something.
                //
                // So, we can to lose something in any way.
              }
            }
          } else {
            // public "property"
            return parsedName;
          }
        }

      , parseAsObject = function () {
          var len
            , obj = {}
            , lref = ridx++
            // HACK last char after closing quote is ':',
            // but not ';' as for normal string
            , clazzname = readString()
            , key
            , val
            , i;

          refStack[lref] = obj;
          len = readLength();
          for (i = 0; i < len; i++) {
            key = fixPropertyName(readKey(), clazzname);
            val = parseNext();
            obj[key] = val;
          }
          idx++;
          return obj;
        } //end parseAsObject

      , parseAsCustom = function () {
          var clazzname = readString()
            , content = readString();
          return {
            "__PHP_Incomplete_Class_Name": clazzname,
            "serialized": content
          };
        } //end parseAsCustom

      , parseAsRefValue = function () {
          var ref = readInt()
            // php's ref counter is 1-based; our stack is 0-based.
            , val = refStack[ref - 1];
          refStack[ridx++] = val;
          return val;
        } //end parseAsRefValue

      , parseAsRef = function () {
          var ref = readInt();
          // php's ref counter is 1-based; our stack is 0-based.
          return refStack[ref - 1];
        } //end parseAsRef

      , parseAsNull = function () {
          var val = null;
          refStack[ridx++] = val;
          return val;
        }; //end parseAsNull

      parseNext = function () {
        var type = readType();
        switch (type) {
          case 'i': return parseAsInt();
          case 'd': return parseAsFloat();
          case 'b': return parseAsBoolean();
          case 's': return parseAsString();
          case 'a': return parseAsArray();
          case 'O': return parseAsObject();
          case 'C': return parseAsCustom();

          // link to object, which is a value - affects refStack
          case 'r': return parseAsRefValue();

          // PHP's reference - DOES NOT affect refStack
          case 'R': return parseAsRef();

          case 'N': return parseAsNull();
          default:
            throw {
              name: "Parse Error",
              message: "Unknown type '" + type + "' at position " + (idx - 2)
            };
        } //end switch
      }; //end parseNext

      return parseNext();
  };
}));

},{}],3:[function(require,module,exports){
var app = angular.module('App', []),
    server = "https://safe-shelf-6136.herokuapp.com",
    api = "/book/discount/week/",
    source = [
        "taaze",
        "bookscom",
        "sanmin",
        "iread"
    ],
    unserialize = require('locutus/php/var/unserialize'),
    phpUnserialize = require('phpUnserialize/phpUnserialize');

app.controller('Ctrl', ['$scope', '$http', function ($scope, $http) {
    $scope.Data = [];
    $scope.Source = source;

    for (val of source) {
        var service = server.concat(api.concat(val));

        $http.get(service, {withCredentials: true}).then(function(response){
            var status = response.data.status,
                data = response.data.data;

            if (status != undefined || status == 'successful') {
                if (val == "iread") {
                    var clearData = phpUnserialize(decodeURIComponent(data));
                } else {
                    var clearData = unserialize(decodeURIComponent(data));
                }

                $scope.Data.push(clearData);
                console.log($scope.Data);
            }
        })
    }
}])

},{"locutus/php/var/unserialize":1,"phpUnserialize/phpUnserialize":2}]},{},[3]);
