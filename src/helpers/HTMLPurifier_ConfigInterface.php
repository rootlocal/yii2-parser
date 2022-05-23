<?php

namespace rootlocal\parser\helpers;

use HTMLPurifier_ConfigSchema;
use HTMLPurifier_HTML5Config;
use HTMLPurifier_PropertyList;

/**
 * Interface HTMLPurifier_ConfigInterface
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\parser\helpers
 */
interface HTMLPurifier_ConfigInterface
{
    /**
     * @param HTMLPurifier_ConfigSchema|null $definition
     * @param HTMLPurifier_PropertyList|null $parent
     * @return HTMLPurifier_Config
     */
    public static function getInstance(HTMLPurifier_ConfigSchema $definition = null, HTMLPurifier_PropertyList $parent = null): HTMLPurifier_Config;

    /**
     * @return HTMLPurifier_HTML5Config
     */
    public static function createDefault(): HTMLPurifier_HTML5Config;

    /**
     * @return \HTMLPurifier_Config
     */
    public function getDefaultConfig(): \HTMLPurifier_Config;

    /**
     * @return \HTMLPurifier_Config
     */
    public function getFilterAllConfig(): \HTMLPurifier_Config;
}