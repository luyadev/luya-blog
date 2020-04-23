<?php

namespace luya\blog\tests\widgets;

use luya\blog\widgets\BlogOverviewWidget;
use luya\blog\tests\BlogTestCase;
use luya\testsuite\traits\CmsDatabaseTableTrait;

class BlogOverviewWidgetTest extends BlogTestCase
{
    use CmsDatabaseTableTrait;

    public function afterSetup()
    {
        parent::afterSetup();
    }

    public function testRun()
    {
        ob_start();
        $blog = BlogOverviewWidget::begin(['rootId' => 1, 'skipFirstLevel' => false]);
        foreach ($blog->getItems() as $item) {
            echo "[title: " .$item->title."]";
        }
        $blog::end();

        $content = ob_get_clean();

        $this->assertSame('[title: World][title: Sub of World]', $content);
    }

    public function testRunSkipFirstLevel()
    {
        ob_start();
        $blog = BlogOverviewWidget::begin(['skipFirstLevel' => true]);
        foreach ($blog->getItems() as $item) {
            echo "title: " .$item->title;
        }
        $blog::end();

        $content = ob_get_clean();

        $this->assertSame('title: Sub of World', $content);
    }
}