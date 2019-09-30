<?php namespace Initbiz\Cumulusdemo\Components;

use Cms\Classes\ComponentBase;

class ToDo extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'ToDo Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
}
