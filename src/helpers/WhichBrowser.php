<?php

namespace rootlocal\parser\helpers;

use WhichBrowser\Parser;

/**
 * Class WhichBrowser
 * @package rootlocal\parser
 */
class WhichBrowser extends Parser
{

    /**
     * @var WhichBrowser
     */
    private static $_instance;

    /**
     * @param  array|string $headers
     * Optional, an array with all of the headers or a string with just the User-Agent header
     * @param  array $options
     * Optional, an array with configuration options
     * @return WhichBrowser
     */
    public static function getInstance($headers = null, $options = [])
    {
        self::$_instance = new self($headers, $options);
        return self::$_instance;
    }

}