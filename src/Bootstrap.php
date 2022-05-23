<?php

namespace rootlocal\parser;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\parser
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // add module I18N category
        if (!isset($app->i18n->translations['parser'])) {
            $app->i18n->translations['parser'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@rootlocal/parser/messages',
            ];
        }
    }
}