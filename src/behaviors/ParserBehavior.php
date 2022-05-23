<?php

namespace rootlocal\parser\behaviors;

use yii\behaviors\AttributeBehavior;
use rootlocal\parser\helpers\Parsedown;
use rootlocal\parser\helpers\HtmlPurifier;
use rootlocal\parser\helpers\HTMLPurifier_Config;
use yii\db\BaseActiveRecord;


/**
 * Class ParserBehavior
 *
 *
 * ```php
 *  public function behaviors()
 *  {
 *      return [
 *           [
 *               'class' => ParserBehavior::class,
 *               'srcAtAttribute' => 'content',
 *               'dstAtAttribute' => 'content_html',
 *               'templateConfig' => 'filterAll',
 *           ],
 *       ];
 *   }
 * ```
 *
 * @property Parsedown $parserMarkDown
 * @property HtmlPurifier $htmlPurifier
 * @property HTMLPurifier_Config $htmlPurifierConfig
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\parser\behaviors
 */
class ParserBehavior extends AttributeBehavior
{
    /** @var array attributes */
    public $attributes = [];
    /** @var string */
    public string $srcAtAttribute = 'content';
    /** @var string */
    public string $dstAtAttribute = 'content_html';
    /**
     * @var string
     * @example  default filterAll
     */
    public string $templateConfig = 'default';
    /**
     * {@inheritdoc}
     *
     * In case, when the value is `null`, the result of the
     * PHP function [time()](https://secure.php.net/manual/en/function.time.php)
     * will be used as value.
     */
    public $value;

    /** @var Parsedown|null */
    private ?Parsedown $_parserMarkDown = null;
    /** @var HtmlPurifier|null */
    private ?HtmlPurifier $_htmlPurifier =null;
    /** @var HTMLPurifier_Config|null */
    private ?HTMLPurifier_Config $_htmlPurifierConfig =null;



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
    public function events(): array
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

        if (!empty($markDown)) {
            $html = $this->parse_markDown($markDown);
            $owner->{$this->dstAtAttribute} = $this->process($html);
        }

    }


    /**
     * @return Parsedown
     */
    public function getParserMarkDown(): Parsedown
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
    public function getHtmlPurifier(): HtmlPurifier
    {
        if (empty($this->_htmlPurifier)) {
            $this->_htmlPurifier = new HtmlPurifier();
        }

        return $this->_htmlPurifier;
    }

    /**
     * @return HTMLPurifier_Config
     */
    public function getHtmlPurifierConfig(): HTMLPurifier_Config
    {
        if (empty($this->_htmlPurifierConfig)) {
            $config = HTMLPurifier_Config::getInstance();

            if ($this->templateConfig === 'default' || empty($this->templateConfig)) {
                $this->_htmlPurifierConfig = $config->getDefaultConfig();
            }

            if ($this->templateConfig === 'filterAll') {
                $this->_htmlPurifierConfig = $config->getFilterAllConfig();
            }
        }

        return $this->_htmlPurifierConfig;
    }

    /**
     * @param HTMLPurifier_Config $config
     */
    public function setHtmlPurifierConfig(HTMLPurifier_Config $config)
    {
        $this->_htmlPurifierConfig = $config;
    }

    /**
     * @param $text string
     * @return string
     */
    protected function parse_markDown(string $text): string
    {
        return $this->getParserMarkDown()->text($text);
    }

    /**
     * @param $html string
     * @return string
     */
    protected function process(string $html): string
    {
        return $this->getHtmlPurifier()::process($html, $this->getHtmlPurifierConfig());
    }
}