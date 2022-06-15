<?php

namespace luya\blog\widgets;

use luya\base\Widget;
use luya\cms\menu\Item;
use luya\cms\menu\Query;
use luya\cms\menu\QueryOperatorFieldInterface;
use Yii;
use yii\data\Pagination;

/**
 * Blog Overview Widgets.
 * 
 * Display pages based on a root item.
 * 
 * ```php
 * <?php $blog = BlogOverviewWidget::begin(); ?>
 *     <h2>Blogs</h2>
 *     <?php foreach ($blog->items as $item): ?>
 *           <h3><?= $item->title; ?></h3>
 *     <?php endforeach; ?>
 * 
 *     <?= LinkPager::widget(['pagination' => $blog->pagination]); ?>
 * 
 * <?php BlogOverviewWidget::end();
 * ```
 *  
 * @property Item[] $items Return the items for current page.
 * @property Pagination $pagination Get the pagination object for LinkPager Widget.
 * 
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.0
 */
class BlogOverviewWidget extends Widget
{
    /**
     * @var integer The number of items per page.
     */
    public $perPage = 10;

    /**
     * @var integer The Nav Id which will be taken as root to travarse its children, which are then blogs.
     */
    public $rootId;

    /**
     * @var array Order by certain fields. If empty or false, no ordering.
     * @since 1.1.0
     */
    public $orderBy = [QueryOperatorFieldInterface::FIELD_TIMESTAMPCREATE => SORT_DESC];

    /**
     * @var boolean This is usefull when blog items are created within a year subpage. Assuming /blog/2019/my-blog where 2019 is a page.
     * If enabled the 2019 entries (first level of $rootId) will be skiped.
     */
    public $skipFirstLevel = false;

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        return $content;
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return new Pagination([
            'totalCount' => $this->getTotalCount(),
            'pageSize' => $this->perPage,
            'defaultPageSize' => $this->perPage,
            'route' => '/cms/default/index',
            'params' => ['page' => Yii::$app->request->get('page'), 'path' => $this->getRootItem()->alias]
        ]);
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->itemsByPage($this->getPagination()->getPage());
    }
    
    /**
     * @return integer Total number of entries
     */
    public function getTotalCount()
    {
        return count($this->getItemIds());
    }

    /**
     * @param int $page
     * @return Item[]
     */
    protected function itemsByPage($page)
    {
        /** @var Query $query */
        $query = Yii::$app->menu->find()->where(['in', QueryOperatorFieldInterface::FIELD_ID, $this->getItemIds()]);
        // set query limit
        $query->limit($this->perPage);
        // set query offset (offset * page)
        $query->offset($page * $this->perPage);

        // order by given timestamp
        if ($this->orderBy) {
            $query->orderBy($this->orderBy);
        }

        return $query->all();
    }

    /**
     * @return array
     */
    public function getItemIds()
    {
        if ($this->skipFirstLevel) {
            $ids = [];
            foreach ($this->getRootItem()->children as $child) {
                $ids = array_merge($ids, $child->children->column('id'));
            }
            return $ids;
    
        }
        return $this->getRootItem()->getDescendants()->column(QueryOperatorFieldInterface::FIELD_ID);
    }

    /**
     * @return Item
     */
    public function getRootItem()
    {
        if ($this->rootId) {
            return Yii::$app->menu->findOne([QueryOperatorFieldInterface::FIELD_ID => $this->rootId]);
        }
        
        return Yii::$app->menu->current;
    }
}
