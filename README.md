


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