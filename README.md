


Model:
```php
<?php

use rootlocal\parser\behaviors\ParserBehavior;

// ...
// ...

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // ...
            [
                'class' => ParserBehavior::class,
                'srcAtAttribute' => 'content',
                'dstAtAttribute' => 'content_html',
            ],
            // ...
        ];
    }
 ?>
// ...
```  

Form:
```php
<?php

use yii2mod\markdown\MarkdownEditor;
?>

// ...
// ...

<?= $form->field($model, 'content')->widget(MarkdownEditor::class, [
        'options' => [
            'id' => !$model->isNewRecord ? 'content-' . $model->id : 'content',
        ],
        'editorOptions' => [
            'showIcons' => ["code", "table"],
        ],
    ]); ?>
```  

View:
```php
<?= $model->content_html ?>
```  

ParserBrowser:  
[whichbrowser/parser](https://github.com/WhichBrowser/Parser-PHP)  

```php
<?php

use rootlocal\parser\ParserBrowser;
?>

<?= ParserBrowser::getInstance()->parser->toString(); ?>
// You are using Chrome 27 on OS X Mountain Lion 10.8
// or
<?= ParserBrowser::getInstance()->getParser(getallheaders())->toString(); ?>
// or
<?= ParserBrowser::getInstance(['headers' => $_SERVER['HTTP_USER_AGENT']])->getParser()->toString(); ?>

<?php var_dump(ParserBrowser::getInstance()->parser->isType('desktop')); ?>
// bool(true)
```