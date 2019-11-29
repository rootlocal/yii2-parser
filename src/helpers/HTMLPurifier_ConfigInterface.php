<?php

namespace rootlocal\parser\helpers;

/**
 * Interface HTMLPurifier_ConfigInterface
 * @package rootlocal\parser\helpers
 */
interface HTMLPurifier_ConfigInterface
{
    /**
     * @param HTMLPurifier_ConfigSchema $definition
     * @param HTMLPurifier_PropertyList $parent
     * @return HTMLPurifier_Config
     */
    public static function getInstance($definition = null, $parent = null);

    /**
     * @return \HTMLPurifier_HTML5Config
     */
    public static function createDefault();

    /**
     * @return \HTMLPurifier_Config
     */
    public function getDefaultConfig();

    /**
     * @return \HTMLPurifier_Config
     */
    public function getFilterAllConfig();
}