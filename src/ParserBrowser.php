<?php

namespace rootlocal\parser;

use yii\base\Component;
use rootlocal\parser\helpers\WhichBrowser;
use yii\helpers\ArrayHelper;

/**
 * Class ParserBrowser
 *
 * @property WhichBrowser $parser
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\parser
 */
class ParserBrowser extends Component
{
    /** @var array|null */
    public ?array $headers = null;
    /** @var array */
    public array $options = [];

    /** @var ParserBrowser|null */
    private static ?ParserBrowser $_instance = null;
    /** @var WhichBrowser|null */
    private ?WhichBrowser $_parser = null;


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->headers)) {
            $this->headers = getallheaders(); // or $_SERVER['HTTP_USER_AGENT'];
        }

        $defaultOptions = ['detectBots' => true];
        $this->options = ArrayHelper::merge($defaultOptions, $this->options);
    }

    /**
     * @param array $config
     * @return ParserBrowser
     */
    public static function getInstance(array $config = []): ParserBrowser
    {
        if (self::$_instance === null) {
            self::$_instance = new self($config);
        }

        return self::$_instance;
    }

    /**
     * @param array $headers  Optional, an array with all the headers or a string with just the User-Agent header
     * @param array $options  Optional, an array with configuration options
     * @return WhichBrowser
     */
    public function getParser(array $headers = [], array $options = []): WhichBrowser
    {
        if (empty($headers)) {
            $headers = $this->headers;
        }

        if (empty($options)) {
            $options = $this->options;
        }

        if (empty($this->_parser)) {
            $this->_parser = WhichBrowser::getInstance($headers, $options);
        }

        return $this->_parser;
    }

}