<?php

namespace luya\blog\widgets;

use luya\base\Widget;
use luya\cms\menu\Item;
use luya\cms\menu\QueryOperatorFieldInterface;
use Yii;
use yii\data\Pagination;

class BlogOverviewWidget extends Widget
{
    public $perPage = 10;

    public $rootId;

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
     * Undocumented function
     *
     * @return Pagination
     */
    public function getPagination()
    {
        return new Pagination([
            'totalCount' => $this->getTotalCount(),
        ]);
    }

    public function getItems()
    {
        return $this->itemsByPage($this->getPagination()->getPage());
    }
    
    /**
     * Undocumented function
     *
     * @return integer Total number of entries
     */
    public function getTotalCount()
    {
        return count($this->getItemIds());
    }

    /**
     * Undocumented function
     *
     * @param [type] $page
     * @return Item[]
     */
    protected function itemsByPage($page)
    {
        $query = Yii::$app->menu->find()->where(['in', QueryOperatorFieldInterface::FIELD_ID, $this->getItemIds()]);
        // set query limit
        $query->limit($this->perPage);
        // set query offset (offset * page)
        $query->offset($page * $this->perPage);

        return $query->all();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getItemIds()
    {
        return $this->getRootItem()->getDescendants()->column(QueryOperatorFieldInterface::FIELD_ID);
    }

    /**
     * @return Item
     */
    public function getRootItem()
    {
        return Yii::$app->menu->findOne([QueryOperatorFieldInterface::FIELD_ID => $this->rootId]);
    }
}