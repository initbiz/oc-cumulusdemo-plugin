<?php namespace Initbiz\CumulusDemo\Components;

use Flash;
use ApplicationException;
use Cms\Classes\ComponentBase;
use Initbiz\InitDry\Classes\Helpers;
use Initbiz\CumulusDemo\Models\TodoItem;
use Initbiz\CumulusCore\Classes\Helpers as CumulusHelpers;

class Todo extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Todo List',
            'description' => 'Implements a simple to-do list.'
        ];
    }

    public function onRun()
    {   
        $this->page['items'] = TodoItem::with('user')->clusterIdFiltered()->get();
    }

    public function onAddItem()
    {
        $cluster = CumulusHelpers::getCluster();
        $user = Helpers::getUser();

        $item = new TodoItem();
        $item->name = post('newItem');
        $item->cluster_id = $cluster->id; 
        $item->user_id = $user->id;
        try{
            $item->save();
        }
        catch(Exception $e){
            Flash::error($e->getMessage());
            return;
        }

        $this->page['items'] = TodoItem::with('user')->clusterIdFiltered()->get();
    }
    public function onRemoveItem()
    {
        $del= TodoItem::where('id', post('delItem'))->delete();
    }
}
