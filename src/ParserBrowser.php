<?php

namespace rootlocal\parser;

use yii\base\Component;
use rootlocal\parser\helpers\WhichBrowser;
use yii\helpers\ArrayHelper;

/**
 * Class ParserBrowser
 * @package rootlocal\parser
 *
 * @property WhichBrowser $parser
 */
class ParserBrowser extends Component
{
    /**
     * @var string
     */
    public $headers;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var ParserBrowser
     */
    private static $_instance;

    /**
     * @var WhichBrowser
     */
    private $_parser;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->headers)) {
            $this->headers = getallheaders(); // or $_SERVER['HTTP_USER_AGENT'];
        }

        $defaultOptions = [
            'detectBots' => true,
        ];

        $this->options = ArrayHelper::merge($defaultOptions, $this->options);

    }

    /**
     * @param array $config
     * @return ParserBrowser
     */
    public static function getInstance($config = [])
    {
        self::$_instance = new self($config);
        return self::$_instance;
    }

    /**
     * @param  array|string $headers
     * Optional, an array with all of the headers or a string with just the User-Agent header
     * @param  array $options
     * Optional, an array with configuration options
     * @return WhichBrowser
     */
    public function getParser($headers = null, $options = [])
    {
        if (empty($headers)) {
            $headers = $this->headers;
        }

        if (empty($options)) {
            $options = $this->options;
        }

        if (empty($this->_parser))
            $this->_parser = WhichBrowser::getInstance($headers, $options);

        return $this->_parser;
    }

}