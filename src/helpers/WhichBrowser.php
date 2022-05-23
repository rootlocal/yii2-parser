<?php

namespace rootlocal\parser\helpers;

use WhichBrowser\Parser;

/**
 * Class WhichBrowser
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\parser
 */
class WhichBrowser extends Parser
{


    /**
     * @param  array|string $headers Optional, an array with all the headers or a string with just the User-Agent header
     * @param array $options Optional, an array with configuration options
     * @return WhichBrowser
     */
    public static function getInstance($headers = null, array $options = []): WhichBrowser
    {
        return new self($headers, $options);
    }

}