<?php

namespace rootlocal\parser\helpers;

use Yii;
use HTMLPurifier_ConfigSchema;
use HTMLPurifier_PropertyList;

/**
 * Class HTMLPurifier_Config_Content
 * @package rootlocal\parser\helpers
 *
 * @property HTMLPurifier_Config $instance
 */
class HTMLPurifier_Config extends \HTMLPurifier_Config
{
    /**
     * @var HTMLPurifier_Config
     */
    private static $_instance;

    /**
     * @param HTMLPurifier_ConfigSchema $definition
     * @param HTMLPurifier_PropertyList $parent
     * @return HTMLPurifier_Config
     */
    public static function getInstance($definition = null, $parent = null)
    {
        if (empty($definition))
            $definition = HTMLPurifier_ConfigSchema::instance();

        self::$_instance = new self($definition, $parent);

        return self::$_instance;
    }

    /**
     * @return \HTMLPurifier_Config
     * Дефолтный конфиг
     */
    public function getDefaultConfig()
    {
        $this->set('HTML.Doctype', 'HTML 4.01 Transitional');
        //$this->set('Cache.DefinitionImpl', null);
        $this->set('Cache.SerializerPath', Yii::$app->getRuntimePath());
        $this->set('HTML.ForbiddenElements', ["iframe", "pre"]); // "script"
        $this->set('AutoFormat.AutoParagraph', false);
        $this->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
        $this->set('AutoFormat.RemoveEmpty', false);
        $this->set('AutoFormat.Linkify', true);
        $this->set('HTML.DefinitionID', 'User Content Filter');
        $this->set('Filter.YouTube', true);
        $this->set('HTML.TidyLevel', 'heavy'); // none light medium heavy
        $this->set('HTML.DefinitionRev', 1);
        $this->set('HTML.Trusted', true);   // javascript
        $this->set('HTML.SafeObject', true);
        $this->set('Output.FlashCompat', true);
        $this->set('Attr.AllowedFrameTargets', ['_blank', '_self', '_parent', '_top']);
        $this->set('Cache.SerializerPath', Yii::$app->getRuntimePath());
        return $this;
    }

    /**
     * @return \HTMLPurifier_Config
     * Конфиг с строгой фильтрацией контента
     */
    public function getFilterAllConfig()
    {
        $config = $this->getDefaultConfig();
        $config->set('HTML.ForbiddenAttributes', ['style', 'border', 'cellspacing', 'cellpadding']);
        $config->set('HTML.Allowed', 'b,i,a,em,p,span,img,li,ul,ol,sup,sub,small,big,code,blockquote,h1,h2,h3,h4,h5,h6');
        $config->set('HTML.AllowedAttributes', 'a.href,a.title,span.class,span.id,img.src,img.style,img.alt,img.title,img.width,img.height,action');
        $config->set('HTML.SafeObject', false);
        $config->set('AutoFormat.RemoveEmpty', true);

        //$config->set("HTML.AllowedElements", []);
        return $config;
    }
}