<?php namespace Initbiz\CumulusDemo\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;

class Todo extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Todo List',
            'description' => 'Implements a simple to-do list.'
        ];
    }


    public function onAddItem()
    {
        $items = post('items', []);

        if (count($items) >= $this->property('max')) {
            throw new ApplicationException(sprintf('Sorry only %s items are allowed.', $this->property('max')));
        }

        if (($newItem = post('newItem')) != '') {
            $items[] = $newItem;
        }

        $this->page['items'] = $items;
    }
}
