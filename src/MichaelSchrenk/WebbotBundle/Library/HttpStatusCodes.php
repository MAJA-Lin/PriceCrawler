<?php

namespace MichaelSchrenk\WebbotBundle\Library;

/*
########################################################################
Copyright 2007, Michael Schrenk
   This software is designed for use with the book,
   "Webbots, Spiders, and Screen Scarpers", Michael Schrenk, 2007 No Starch Press, San Francisco CA

W3C� SOFTWARE NOTICE AND LICENSE

This work (and included software, documentation such as READMEs, or other
related items) is being provided by the copyright holders under the following license.
 By obtaining, using and/or copying this work, you (the licensee) agree that you have read,
 understood, and will comply with the following terms and conditions.

Permission to copy, modify, and distribute this software and its documentation, with or
without modification, for any purpose and without fee or royalty is hereby granted, provided
that you include the following on ALL copies of the software and documentation or portions thereof,
including modifications:
   1. The full text of this NOTICE in a location viewable to users of the redistributed
      or derivative work.
   2. Any pre-existing intellectual property disclaimers, notices, or terms and conditions.
      If none exist, the W3C Software Short Notice should be included (hypertext is preferred,
      text is permitted) within the body of any redistributed or derivative code.
   3. Notice of any changes or modifications to the files, including the date changes were made.
      (We recommend you provide URIs to the location from which the code is derived.)

THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT HOLDERS MAKE NO REPRESENTATIONS OR
WARRANTIES, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR FITNESS
FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD
PARTY PATENTS, COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.

COPYRIGHT HOLDERS WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL DAMAGES ARISING OUT
OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.

The name and trademarks of copyright holders may NOT be used in advertising or publicity pertaining to the
software without specific, written prior permission. Title to copyright in this software and any associated
documentation will at all times remain with copyright holders.
########################################################################
*/

class HttpStatusCodes
{
    #-------------------------------------
    # Define 100 series http codes (informational)
    # Define 200 series http codes (successful)
    # Define 300 series http codes (redirection)
    # Define 400 series http codes (client error)
    # Define 500 series http codes (server error)
    #-------------------------------------
    public static $status_code_array = [
        '100' => "100 Continue",
        '101' => "101 Switching Protocols",
        # Define 200 series http codes (successful)
        '200' => "200 OK",
        '201' => "201 Created",
        '202' => "202 Accepted",
        '203' => "203 Non-Authoritative Information",
        '204' => "204 No Content",
        '205' => "205 Reset Content",
        '206' => "206 Partial Content",
        # Define 300 series http codes (redirection)
        '300' => "300 Multiple Choices",
        '301' => "301 Moved Permanently",
        '302' => "302 Found",
        '303' => "303 See Other",
        '304' => "304 Not Modified",
        '305' => "305 Use Proxy",
        '306' => "306 (Unused)",
        '307' => "307 Temporary Redirect",
        # Define 400 series http codes (client error)
        '400' => "400 Bad Request",
        '401' => "401 Unauthorized",
        '402' => "402 Payment Required",
        '403' => "403 Forbidden",
        '404' => "404 Not Found",
        '405' => "405 Method Not Allowed",
        '406' => "406 Not Acceptable",
        '407' => "407 Proxy Authentication Required",
        '408' => "408 Request Timeout",
        '409' => "409 Conflict",
        '410' => "410 Gone",
        '411' => "411 Length Required",
        '412' => "412 Precondition Failed",
        '413' => "413 Request Entity Too Large",
        '414' => "414 Request-URI Too Long",
        '415' => "415 Unsupported Media Type",
        '416' => "416 Requested Range Not Satisfiable",
        '417' => "417 Expectation Failed",
        # Define 500 series http codes (server error)
        '500' => "500 Internal Server Error",
        '501' => "501 Not Implemented",
        '502' => "502 Bad Gateway",
        '503' => "503 Service Unavailable",
        '504' => "504 Gateway Timeout",
        '505' => "505 HTTP Version Not Supported",
    ];
}
