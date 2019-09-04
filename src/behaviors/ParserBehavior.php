<?php

namespace rootlocal\parser\behaviors;

use yii\behaviors\AttributeBehavior;
use rootlocal\parser\helpers\Parsedown;
use rootlocal\parser\helpers\HtmlPurifier;
use rootlocal\parser\helpers\HTMLPurifier_Config;
use yii\db\BaseActiveRecord;

/**
 * Class ParserBehavior
 * @package rootlocal\parser\behaviors
 *
 * ```php
 *  public function behaviors()
 *  {
 *      return [
 *           [
 *               'class' => ParserBehavior::class,
 *               'srcAtAttribute' => 'content',
 *               'dstAtAttribute' => 'content_html',
 *           ],
 *       ];
 *   }
 * ```
 *
 * @property Parsedown $parserMarkDown
 * @property HtmlPurifier $htmlPurifier
 * @property HTMLPurifier_Config $htmlPurifierConfig
 */
class ParserBehavior extends AttributeBehavior
{
    /**
     * @var array attributes
     */
    public $attributes = [];

    /**
     * @var string
     */
    public $srcAtAttribute = 'content';

    /**
     * @var string
     */
    public $dstAtAttribute = 'content_html';

    /**
     * @var Parsedown
     */
    private $_parserMarkDown;

    /**
     * @var HtmlPurifier
     */
    private $_htmlPurifier;

    /**
     * @var HTMLPurifier_Config
     */
    private $_htmlPurifierConfig;

    /**
     * {@inheritdoc}
     *
     * In case, when the value is `null`, the result of the
     * PHP function [time()](https://secure.php.net/manual/en/function.time.php)
     * will be used as value.
     */
    public $value;


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->srcAtAttribute, $this->dstAtAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->srcAtAttribute, $this->dstAtAttribute],
            ];
        }
    }

    /**
     * {@inheritdoc}
     *
     * In case, when the [[value]] is `null`, the result of
     * the PHP function [time()](https://secure.php.net/manual/en/function.time.php)
     * will be used as value.
     */
    protected function getValue($event)
    {
        return parent::getValue($event);
    }

    /**
     * Declares event handlers for the [[owner]]'s events.
     *
     * Child classes may override this method to declare what PHP callbacks should
     * be attached to the events of the [[owner]] component.
     *
     * The callbacks will be attached to the [[owner]]'s events when the behavior is
     * attached to the owner; and they will be detached from the events when
     * the behavior is detached from the component.
     **/
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'parseEvent',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'parseEvent',
        ];
    }

    /**
     * Before validate event
     */
    public function parseEvent()
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        $markDown = $owner->{$this->srcAtAttribute};
        $html = $this->parse_markDown($markDown);
        $owner->{$this->dstAtAttribute} = $this->process($html);
    }


    /**
     * @return Parsedown
     */
    public function getParserMarkDown()
    {
        if (empty($this->_parserMarkDown)) {
            $this->_parserMarkDown = Parsedown::instance()
                ->setSafeMode(false)
                ->setMarkupEscaped(false);
        }

        return $this->_parserMarkDown;
    }

    /**
     * @return HtmlPurifier
     */
    public function getHtmlPurifier()
    {
        if (empty($this->_htmlPurifier)) {
            $this->_htmlPurifier = new HtmlPurifier();
        }

        return $this->_htmlPurifier;
    }

    /**
     * @return HTMLPurifier_Config
     */
    public function getHtmlPurifierConfig()
    {
        if (empty($this->_htmlPurifierConfig)) {
            $this->_htmlPurifierConfig = HTMLPurifier_Config::getInstance()->getDefaultConfig();
        }

        return $this->_htmlPurifierConfig;
    }

    /**
     * @param $text string
     * @return string
     */
    protected function parse_markDown($text)
    {
        return $this->getParserMarkDown()->text($text);
    }

    /**
     * @param $html string
     * @return string
     */
    protected function process($html)
    {
        return $this->getHtmlPurifier()::process($html, $this->getHtmlPurifierConfig());
    }
}