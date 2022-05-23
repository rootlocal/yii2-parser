<?php

namespace rootlocal\parser\helpers;

use HTMLPurifier_HTML5Config;
use Yii;
use HTMLPurifier_ConfigSchema;
use HTMLPurifier_PropertyList;

/**
 * Class HTMLPurifier_Config_Content
 * @package rootlocal\parser\helpers
 *
 * @property HTMLPurifier_Config $instance
 */
class HTMLPurifier_Config extends HTMLPurifier_HTML5Config implements HTMLPurifier_ConfigInterface
{


    /**
     * @param HTMLPurifier_ConfigSchema|null $definition
     * @param HTMLPurifier_PropertyList|null $parent
     * @return HTMLPurifier_Config
     */
    public static function getInstance(HTMLPurifier_ConfigSchema $definition = null, HTMLPurifier_PropertyList $parent = null): HTMLPurifier_Config
    {
        if (empty($definition)) {
            $definition = HTMLPurifier_ConfigSchema::instance();
        }

         return new self($definition, $parent);
    }

    /**
     * @return HTMLPurifier_HTML5Config
     */
    public static function createDefault(): HTMLPurifier_HTML5Config
    {
        return parent::createDefault();
    }

    /**
     * @return HTMLPurifier_Config
     */
    public function getDefaultConfig(): HTMLPurifier_Config
    {
        $this->set('HTML.Doctype', 'HTML 4.01 Transitional');
        //$this->set('Cache.DefinitionImpl', null);
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
     * @return HTMLPurifier_Config
     */
    public function getFilterAllConfig(): HTMLPurifier_Config
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