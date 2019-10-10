<?php namespace Initbiz\CumulusDemo\Components;

use Cms\Classes\ComponentBase;

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
        $this->addCss("assets/node_modules/gridstack/dist/chartist.min.css");
        $this->addJs("assets/chartist.min.js");
    }
}
