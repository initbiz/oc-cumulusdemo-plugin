<?php namespace Initbiz\Cumulusdemo\Components;

use Cms\Classes\ComponentBase;
use Initbiz\CumulusCore\Classes\Helpers;

class Gallery extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'gallery Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRun()
    {
        $cluster = Helpers::getCluster();
        
        if($cluster->canEnterFeature('initbiz.cumulusdemo.advanced.todo'))
        {
            $img_path = '/plugins/initbiz/cumulusdemo/assets/img/gallery/cumulus-demo-icon.png';
        }
        else{
            $img_path = '/plugins/initbiz/cumulusdemo/assets/img/gallery/watermark.png';
        }        
        $this->page['img'] = $img_path; 
    }
}