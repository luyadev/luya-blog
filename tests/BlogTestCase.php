<?php
namespace luya\blog\tests;

use luya\testsuite\cases\WebApplicationTestCase;
use luya\testsuite\components\DummyMenu;

class BlogTestCase extends WebApplicationTestCase
{
    public function getConfigArray()
    {
        return [
            'id' => 'blogtest',
            'basePath' => __DIR__,
            'language' => 'en',
            'components' => [
                'menu' => [
                    'class' => DummyMenu::class,
                    'items' => [
                        'en' => [
                            [
                                'id' => 1,
                                'title' => 'Hello',
                                'is_home' => 1,
                                'items' => [
                                    [
                                        'id' => 2,
                                        'title' => 'World',
                                        'link' => 'hello-world-link',
                                    ]
                                ]   
                            ]
                        ]
                    ]
                ],
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ]
            ],
            'modules' => [
                'admin' => 'luya\admin\Module',
                'cms' => 'luya\cms\frontend\Module',
            ]
        ];
    }
}
