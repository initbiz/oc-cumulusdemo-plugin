<?php namespace Initbiz\CumulusDemo\Components;

use Cms\Classes\ComponentBase;
use Initbiz\CumulusCore\Classes\Helpers;
use Initbiz\CumulusDemo\Models\TodoItem;

class Chart extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'chart Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun()
    {
        $this->addCss("assets/chartist.min.css");
        $this->addJs("assets/chartist.min.js");

        $cluster = Helpers::getCluster();
        $todoItemsCount = TodoItem::clusterIdFiltered()->count();
        
        if($cluster->canEnterFeature('initbiz.cumulusdemo.advanced.dashboard'))
        {
            $allowedItemsCount = 5;
            if ($cluster->canEnterFeature('initbiz.cumulusdemo.advanced.todo')) {
                $allowedItemsCount = 10;
            }

            $this->page['todoItemsCount'] = $todoItemsCount;
            $this->page['allowedItemsCount'] = $allowedItemsCount;
        }        
    }
}
