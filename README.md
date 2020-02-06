SEO For Yii2
============
Library for working with SEO parameters of models

[![Latest Stable Version](https://poser.pugx.org/yiier/yii2-seo/v/stable)](https://packagist.org/packages/yiier/yii2-seo) 
[![Total Downloads](https://poser.pugx.org/yiier/yii2-seo/downloads)](https://packagist.org/packages/yiier/yii2-seo) 
[![Latest Unstable Version](https://poser.pugx.org/yiier/yii2-seo/v/unstable)](https://packagist.org/packages/yiier/yii2-seo) 
[![License](https://poser.pugx.org/yiier/yii2-seo/license)](https://packagist.org/packages/yiier/yii2-seo)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiier/yii2-seo "*"
```

or add

```
"yiier/yii2-seo": "*"
```

to the require section of your `composer.json` file.

Configuration
-----

change your config file

```php
<?php
return [
    'components' => [
        'view' => [
            'as seo' => [
                'class' => 'yiier\seo\SeoViewBehavior',
                'names' => [

                    'keywords' => 'blog,forecho',
                    'author' => getenv('APP_NAME'),
                ],
                'properties' => [
                    [
                        'property' => ['title', 'og:title'],
                        'content' => function () {
                            return ' tag1, tag2';
                        },
                    ],
                    'title1' => 'title'
                ],
            ]
        ]
    ]
];
```


In model file add seo model behavior:

```php
<?php

public function behaviors()
{
    return [
        'seo' => [
            'class' => 'yiier\seo\SeoModelBehavior',
            'names' => [
                'viewport' => function (self $model) {
                    return $model->title . ', tag1, tag2';
                },
                'keywords' => 'blog,forecho',
                'author' => 'author', // model field
            ],
            'properties' => [
                [
                    'property' => ['title', 'og:title'],
                    'content' => function (self $model) {
                        return $model->title . ', tag1, tag2';
                    },
                ],
                'title1' => 'title',
                [
                    'property' => 'description',
                    'content' => function (self $model) {
                        return $model->title . ', tag1, tag2';
                    },
                ],
            ],
        ],
    ];
}
```

PHPdoc for model:

```
/**
 * @property \yiier\seo\SeoModelBehavior $seoBehavior
 * @method \yiier\seo\SeoModelBehavior getSeoBehavior()
 */
```

Change `/frontend/views/layouts/main.php`:

```php
<?php
/* @var $this \yii\web\View|\yiier\seo\SeoViewBehavior */
?>
<head>
    <!-- Replace default <title> tag -->    
    <title><?= Html::encode($this->title) ?></title>
    <!-- by this line: -->    
    <?php $this->renderMetaTags(); ?>
    ...
</head>
```

Usage
-----

In "view.php" file for model:

```php
// set SEO:meta data for current page
$this->setSeoData($model->getSeoBehavior());
```


or in controller:

```php
 Yii::$app->view->setSeoData($model->getSeoBehavior());
```

Simple url rules example in '/frontend/config/main.php':

```php
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<module>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
        'post/<action:(index|create|update|delete)>' => 'post/<action>',
        'post/<title:[-\w]+>' => 'post/view',
    ],
],
```

Reference
-----

[demisang/yii2-seo](https://github.com/demisang/yii2-seo)
