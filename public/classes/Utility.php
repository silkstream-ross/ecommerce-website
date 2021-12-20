<?php

namespace Silkstream\EreborClay\Common;

use DateTime;
use DateTimeZone;

/**
 * Utility class to handle standard functions
 */
class Utility {
    static public $FORMAT_TAGS = array(
        '[em]'=>'<em>',
        '[/em]'=>'</em>'
    );

    /**
     * return the first paragraph from a passed html string
     *
     * @param string $text
     * @return string
     */
    static function firstParagraph($text) {
        $matches = array();
        preg_match_all('/<p>(.*)<\/p>/', $text, $matches);
        if (isset($matches[1]) && is_array($matches[1])) {
            foreach ($matches[1] as $match) {
                $match = strip_tags($match);
                if (strlen($match) > 20) {
                    return $match;
                }
            }
        }
        return '';
    }

    /**
     * Loop through trail array to see if id is present
     *
     * @param array $trail
     * @param int $id
     * @return bool
     */
    static function idInTrail($trail, $id) {
        if ($trail) {
            foreach ($trail as $item) {
                if ($item['id'] == $id) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    // Makes a url slug from a passed string value

    /**
     * @param string $text
     * @return string
     */
    static function makeSlug($text) {
        $slug = str_replace('&amp;', '&', $text);
        $slug = str_replace(' & ',' and ',$slug);
        $slug = str_replace(array_keys(self::$FORMAT_TAGS),'',$slug);
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/([a-z])(?:\'|’)([a-z])/','$1$2',$slug);
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    static function makeSlugPath($text) {
        $parts = explode('/',$text);
        array_walk($parts,function($val){
            self::makeSlug($val);
        });
        return implode('/',$parts);
    }

    /**
     * output string for display purposes, optionally trancate if too long
     *
     * @param string $string
     * @param bool|int $length
     * @param bool $with_format_tags
     * @return string
     */
    static function outputString($string, $length = FALSE, $with_format_tags = false) {
        if ($length && strlen($string) > $length) $string = htmlentities(substr($string, 0, $length), ENT_QUOTES, Config::$ENCODING) . '&hellip;';
        else $string = htmlentities($string, ENT_QUOTES, Config::$ENCODING);

        if ($with_format_tags) $string = strtr($string,self::$FORMAT_TAGS);
        else $string = str_replace(array_keys(self::$FORMAT_TAGS),'',$string);

        return $string;
    }

    static function htmlCharToPlain($string) {
        return html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    }

    static function removeFormatTags($string) {
        return str_replace(array_keys(self::$FORMAT_TAGS),'',$string);
    }

    /**
     * Generate a random password
     *
     * @param int $length
     * @param bool $include_numbers
     * @return string
     */
    static function generatePassword($length = 5, $include_numbers = TRUE) {
        $vowels = array('a', 'e', 'i', 'u');
        $cons = array('b', 'c', 'd', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'u', 'v', 'w', 'tr', 'cr', 'br', 'fr', 'th', 'dr', 'ch', 'ph', 'wr', 'st', 'sp', 'sw', 'pr', 'sl', 'cl');

        $num_vowels = count($vowels);
        $num_cons = count($cons);

        $pre = $post = $password = '';

        if ($include_numbers) {
            while ((($length / (strlen($pre) + strlen($post) + 1)) > 2)) {
                if (rand(0, 1) === 0) {
                    $pre .= chr(rand(49, 57));
                } else {
                    $post .= chr(rand(49, 57));
                }
            }
        }

        $string_length = $length - (strlen($pre) + strlen($post));
        while (strlen($password) < $string_length) {
            $password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)];
        }

        return $pre . substr($password, 0, $string_length) . $post;
    }

    // Longer timeout curl session with post data
    // used to send information to sagepay to register for a payment
    /**
     * @param string $url
     * @param string $data
     * @return array
     */
    static function requestPost($url, $data) {
        // Set a one-minute timeout for this script
        set_time_limit(60);

        // Initialise output variable
        $output = array();

        // Open the cURL session
        $curlSession = curl_init();

        // Set the URL
        curl_setopt($curlSession, CURLOPT_URL, $url);
        // No headers, please
        curl_setopt($curlSession, CURLOPT_HEADER, 0);
        // It's a POST request
        curl_setopt($curlSession, CURLOPT_POST, 1);
        // Set the fields for the POST
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, $data);
        // Return it direct, don't print it out
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
        // This connection will timeout in 60 seconds
        curl_setopt($curlSession, CURLOPT_TIMEOUT, 60);
        //The next two lines must be present for the kit to work with newer version of cURL
        //You should remove them if you have any problems in earluer version of cURL
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, 1);


        //Send the request and store the result in an array
        $response = explode(chr(10), curl_exec($curlSession));

        // Check that a connection was made
        if (curl_error($curlSession)) {
            // If it wasn't...
            $output['Status'] = "FAIL";
            $output['StatusDetail'] = curl_error($curlSession);
        }

        // Close the cURL session
        curl_close($curlSession);

        // Tokenise the response
        for ($i = 0; $i < count($response); $i++) {
            // Find position of first "=" character
            $splitAt = strpos($response[$i], "=");
            // Create an associative (hash) array with key/value pairs ('trim' strips excess whitespace)
            $output[trim(substr($response[$i], 0, $splitAt))] = trim(substr($response[$i], ($splitAt + 1)));
        } // END for ($i=0; $i<count($response); $i++)

        // Return the output
        return $output;

    } // END function requestPost

    static function highlightFirstword($string) {
        $wordarray = explode(' ', $string, 2);
        if (count($wordarray) > 0) {
            $wordarray[0] = '<span>' . ($wordarray[0]) . '</span>';
            $string = implode(' ', $wordarray);
        }
        return $string;
    }

    static function highlightLastword($string) {
        $wordarray = explode(' ', $string);
        if (count($wordarray) > 0) {
            $wordarray[count($wordarray) - 1] = '<span>' . ($wordarray[count($wordarray) - 1]) . '</span>';
            $string = implode(' ', $wordarray);
        }
        return $string;
    }

    static function getURL($url) {
        $crl = curl_init();
        $timeout = 1; // Short timeout, so as not to slow down page load
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
    }

    static function getExternalFileContents($url='') {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    static function outputJSON($phpob = array()) {
        ob_clean();
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($phpob);
        exit;
    }

    static function slug2Text($slug = '', $ucwords = false) {
        $slug = str_replace(['-','/'], [' ',' / '], (string)$slug);
        return ($ucwords) ? ucwords($slug) : $slug;
    }

    static function isCli() {
        return php_sapi_name() === 'cli';
    }

    static function isSessionStarted() {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    static function cleanHtmlQueryString($query_string = '') {
        return str_replace('&amp;', '&', $query_string);
    }

    // warning: may not work on shared servers with old php
    static function getMimeType($filepath) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filepath);
            finfo_close($finfo);
            return $mimetype;
        }
        return 'application/octet-stream';
    }

    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    static function getSystemMaxUploadSize($max_size=-1) {
        // Start with post_max_size.
        $ini_post_max_size = self::parseSize(ini_get('post_max_size'));
        if ($ini_post_max_size > 0 && ($max_size < 0 || $ini_post_max_size < $max_size)) {
            $max_size = $ini_post_max_size;
        }

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $ini_upload_max_filesize = self::parseSize(ini_get('upload_max_filesize'));
        if ($ini_upload_max_filesize > 0 && ($max_size < 0 || $ini_upload_max_filesize < $max_size)) {
            $max_size = $ini_upload_max_filesize;
        }
        return $max_size;
    }

    static function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        return round($size);
    }

    static function convertFileSize($size, $from_unit = 'b', $to_unit = 'b') {
        if ($size) {
            $from_unit = preg_replace('/[^bkmgtpezy]/i', '', $from_unit);
            $to_unit = preg_replace('/[^bkmgtpezy]/i', '', $to_unit);

            $from_key = stripos('bkmgtpezy', $from_unit[0]);
            $to_key = stripos('bkmgtpezy', $to_unit[0]);

            if ($from_key !== false && $to_key !== false && $from_key != $to_key) {
                if ($from_key > $to_key) {
                    // larger unit, smaller number
                    return $size / pow(1024, $to_key - $from_key);
                } else {
                    // smaller unit, bigger number
                    return $size * pow(1024, $from_key - $to_key);
                }
            }
        }
        return $size;
    }

    public static function generateRandomString($length = 10, $use_numbers = true, $use_letters = true, $use_letters_caps = true) {
        $str = '';

        if ($length > 0) {
            $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
            $letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
            $letters_caps = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

            $chars = array();
            if ($use_numbers) $chars = array_merge($chars, $numbers);
            if ($use_letters) $chars = array_merge($chars, $letters);
            if ($use_letters_caps) $chars = array_merge($chars, $letters_caps);

            $count_chars = count($chars);

            if ($count_chars > 0) {
                if ($count_chars > 1) shuffle($chars);

                for ($i = 0; $i < $length; $i++) {
                    $str .= $chars[rand(0, $count_chars - 1)];
                }
            }
        }

        return $str;
    }

    static function convertBytesToReadable($size) {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    static function getCurrentMemoryUsage() {
        return self::convertBytesToReadable(memory_get_usage(true));
    }

    // To be safe, make sure to specify from_date as Y-m-d H:i:s
    static function convertToInternalDateFormat($from_timezone, $from_date, $format = 'r') {
        $dt = new DateTime($from_date, new DateTimeZone($from_timezone));
        $dt->setTimezone(new DateTimeZone(Config::$INTERNAL_TIME_ZONE));
        return $dt->format($format);
    }

    static function convertToUserDateFormat($format='r', $date='') {
        if ($date = self::databaseDate($date)) {
            return self::userDateFormat($format,strtotime($date));
        }
        return '';
    }

    static function userDateFormat($format='r',$timestamp=false,$override_timezone=false) {
        $timestamp = ($timestamp) ? (int)$timestamp : time();
        $timezone = ($override_timezone) ? $override_timezone : Config::$USER_TIME_ZONE;
        $btz = date_default_timezone_get();
        if ($btz != $timezone) date_default_timezone_set($timezone);
        $return_date = date($format, $timestamp);
        if ($btz != $timezone) date_default_timezone_set($btz);
        return $return_date;
    }

    /* Straight format of any timestamp, treats the timestamp as UTC and converts to date format using UTC */
    static function internalDateFormat($format='r',$timestamp=false) {
        $timestamp = ($timestamp) ? (int)$timestamp : time();
        $timezone = Config::$INTERNAL_TIME_ZONE;
        $btz = date_default_timezone_get();
        if ($btz != $timezone) date_default_timezone_set($timezone);
        $return_date = date($format, $timestamp);
        if ($btz != $timezone) date_default_timezone_set($btz);
        return $return_date;
    }

    static function formatDate($format='r',$timestamp=false) {
        return self::internalDateFormat($format,$timestamp);
    }

    static function reformatDate($format='r',$date='') {
        if ($date = self::databaseDate($date)) {
            return self::internalDateFormat($format,strtotime($date));
        }
        return '';
    }

    static function arrayDeepRead(&$array, $indexes = array(), $return_error = false, $html_entities = false) {
        if (!is_array($indexes)) {
            $indexes = array($indexes);
        }

        $count_indexes = count($indexes);
        if ($count_indexes > 0) {
            $ref = &$array;
            for ($increment = 0; $increment < $count_indexes; $increment++) {
                if ((!isset($ref[$indexes[$increment]]))
                    || ($increment < $count_indexes-1 && !is_array($ref[$indexes[$increment]]))) {
                    return (is_string($return_error) && $html_entities) ? self::outputString($return_error) : $return_error;
                }
                $ref = &$ref[$indexes[$increment]];
            }
            return (is_string($ref) && $html_entities) ? self::outputString($ref) : $ref;
        }

        return (is_string($return_error) && $html_entities) ? self::outputString($return_error) : $return_error;
    }

    static function arrayDeepWrite(&$array,$indexes=array(),$value=null) {
        if (!is_array($indexes)) {
            $indexes = array($indexes);
        }

        $count_indexes = count($indexes);
        if ($count_indexes > 0) {
            $ref = &$array;
            for ($increment = 0; $increment < $count_indexes; $increment++) {
                if ($increment == $count_indexes-1) {
                    $ref[$indexes[$increment]] = $value;
                    return true;
                }
                if (!isset($ref[$indexes[$increment]]) || !is_array($ref[$indexes[$increment]])) {
                    $ref[$indexes[$increment]] = [];
                }
                $ref = &$ref[$indexes[$increment]];
            }
        }

        return false;
    }

    static function arrayDeepDelete(&$array,$indexes=array()) {
        if (!is_array($indexes)) {
            $indexes = array($indexes);
        }

        $count_indexes = count($indexes);
        if ($count_indexes > 0) {
            $ref = &$array;
            for ($increment = 0; $increment < $count_indexes; $increment++) {
                if ($increment == $count_indexes-1) {
                    unset($ref[$indexes[$increment]]);
                    return true;
                }
                if (!isset($ref[$indexes[$increment]]) || !is_array($ref[$indexes[$increment]])) {
                    return false;
                }
                $ref = &$ref[$indexes[$increment]];
            }
        }

        return false;
    }

    static function arrayRemoveValues(&$array,$values=[]) {
        foreach ($values as $value) {
            if (($key = array_search($value,$array)) !== false) {
                unset($array[$key]);
            }
        }
    }

    static function appendQueryString($url = '', $params = array()) {
        return (!empty($params)) ? $url . (strpos($url, '?') !== false ? '&' : '?') . http_build_query($params,null,'&',PHP_QUERY_RFC3986) : $url;
    }

    public static function downloadFile($file) {
        if (file_exists($file) && is_file($file)) {
            ob_clean();
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_end_flush();
            readfile($file);
            exit;
        }
    }

    public static function normalizePath($path = '') {
        return preg_replace('/' . preg_quote(DIRECTORY_SEPARATOR, '/') . '+/', '/', str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $path));
    }

    static function highlightFirstWordsPercent($string, $wordcountpercent = 0.5, $highlight_single = false) {

        $new_string = '';

        if (strlen($string) > 0) {

            $wordarray = explode(' ', $string);
            $wordarray_count = count($wordarray);
            $wordarray_break = ceil($wordarray_count * $wordcountpercent);

            if ($wordarray_count > 1) {

                $new_string .= '<span>';

                for ($i = 0; $i < $wordarray_count; $i++) {

                    if ($i == $wordarray_break) {
                        $new_string .= '</span>';
                    }

                    if ($i > 0) {
                        $new_string .= ' ';
                    }
                    $new_string .= $wordarray[$i];
                }
            } else {

                if ($highlight_single) {
                    $new_string = '<span>' . $string . '</span>';
                } else {
                    $new_string = $string;
                }
            }
        }
        return $new_string;
    }

    static function databaseDate($input) {
        if ($input != '' && !in_array($input, array('0000-00-00', '0000-00-00 00:00:00')) && preg_match('/^[0-9]{4}\\-[0-9]{2}\\-[0-9]{2}(?: [0-9]{2}\\:[0-9]{2}\\:[0-9]{2})?$/', $input) && strtotime($input)) {
            return $input;
        }
        return '';
    }

    static function convertToDatabaseDate($input) {
        if ($output = self::databaseDate($input)) {
            return $output;
        }
        else if ($input = self::readableDate($input)) {
            $input = preg_replace('/^([0-9]{2})\\/([0-9]{2})\\/([0-9]{4})/', '$3-$2-$1', $input, 1);
            if (strtotime($input)) {
                return $input;
            }
        }
        return '';
    }

    static function readableDate($input) {
        if ($input != '' && !in_array($input, array('00/00/0000', '00/00/0000 00:00:00')) && preg_match('/^[0-9]{2}\\/[0-9]{2}\\/[0-9]{4}(?: [0-9]{2}\\:[0-9]{2}\\:[0-9]{2})?$/', $input)) {
            return $input;
        }
        return '';
    }

    static function convertToReadableDate($input, $with_time = false) {
        if ($output = self::readableDate($input)) {
            return $output;
        }
        else if ($input = self::databaseDate($input)) {
            if ($with_time) return self::internalDateFormat(Config::$DATETIME_FORMAT, strtotime($input));
            else return self::internalDateFormat(Config::$DATE_FORMAT, strtotime($input));
        }
        return '';
    }

    static function replaceFirst($search, $replace, $subject) {
        $pos = strpos($subject, $search);
        if ($pos !== false) {
            return substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }

    static function abstractProtocol($url='') {
        return str_replace(array('http:','https:'),'',$url);
    }

    static function alphaStrict($input,$chars='LOWERCASE|UPPERCASE|NUMBER|HYPHEN|_') {
        $v = (string)$input;
        $chars = str_replace(array('|||','|\\|','|/|'),array('|PIPE|','|BACKSLASH|','|FORWARDSLASH|'),$chars);
        $chars_ar = explode('|',$chars);
        $match_chars = '.+';

        if (!empty($chars_ar))
        {
            $chars_ar = array_unique($chars_ar);
            $match_chars_p = '';

            foreach($chars_ar as $chars_ari)
            {
                switch ($chars_ari)
                {
                    case 'LOWERCASE':
                        $match_chars_p .= 'a-z';
                        break;
                    case 'UPPERCASE':
                        $match_chars_p .= 'A-Z';
                        break;
                    case 'NUMBER':
                        $match_chars_p .= '0-9';
                        break;
                    case 'HYPHEN':
                        $match_chars_p .= '\\-';
                        break;
                    case 'BACKSLASH':
                        $match_chars_p .= '\\\\';
                        break;
                    case 'FORWARDSLASH':
                        $match_chars_p .= '\\/';
                        break;
                    case 'PIPE':
                        $match_chars_p .= '|';
                        break;
                    case 'OPENSQUAREBRACKET':
                        $match_chars_p .= '\\[';
                        break;
                    case 'CLOSESQUAREBRACKET':
                        $match_chars_p .= '\\]';
                        break;
                    default:
                        $match_chars_p .= $chars_ari;
                        break;
                }
            }

            if ($match_chars_p) $match_chars = '['.$match_chars_p.']+';
        }

        if (!preg_match('/^'.$match_chars.'$/',$v))
        {
            $v = '';
        }
        return $v;
    }

    static function getUri() {
        $args = func_get_args();
        $uri = '';
        if (!empty($args)) {
            foreach ($args as $arg) {
                $uri .= '/'.rawurlencode($arg);
            }
        }
        return $uri;
    }

    static function pathToUri($path='') {
        $uri = '';
        if ($path) {
            $path = self::normalizePath($path);
            $path_parts = explode(DIRECTORY_SEPARATOR,$path,100);
            foreach ($path_parts as $path_part) {
                $uri .= '/'.rawurlencode($path_part);
            }
        }
        return $uri;
    }

    static function snippet($string='',$length=0,$mode='plain',$html_breaks=false) {
        if ($string && $length > 0) {
            switch ($mode) {
                case 'plain':
                default:
                    if (mb_strlen($string) > $length) {
                        $string = mb_substr($string,0,$length).'...';
                    }
                    break;
                case 'html_to_plain':
                    $string = strip_tags($string);
                    $string = self::htmlCharToPlain($string);
                    if (mb_strlen($string) > $length) {
                        $string = mb_substr($string,0,$length).'...';
                    }
                    break;
                case 'html':

                    break;
            }
        }

        if ($html_breaks) {
            $string = nl2br($string);
        }

        return $string;
    }

    static function explodeLimitedPop($delimiter,$string,$limit) {
        if ($string) {
            $fake_limit = $limit+1;
            $results = explode($delimiter,$string,$fake_limit);
            if (count($results) > $limit) array_pop($results);
            return $results;
        }
        return array();
    }
}
