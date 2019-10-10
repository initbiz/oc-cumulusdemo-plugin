<?php namespace Initbiz\CumulusDemo;

use Backend;
use System\Classes\PluginBase;

/**
 * CumulusDemo Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'initbiz.cumulusdemo::lang.plugin.name',
            'description' => 'initbiz.cumulusdemo::lang.plugin.description',
            'author'      => 'Initbiz',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function registerComponents()
    {
        return [
            'Initbiz\CumulusDemo\Components\Todo' =>  'todo'
        ];
    }
    public function register()
    {
        $this->registerConsoleCommand('cumulus:seed', 'Initbiz\CumulusDemo\Console\Seed');
    }

    public function registerCumulusFeatures()
    {
        return [
           'initbiz.cumulusdemo.basic.dashboard' => [
               'name' => 'initbiz.cumulusdemo::lang.features.basic_dashboard',
               'description' => 'initbiz.cumulusdemo::lang.features.basic_dashboard_desc',
           ],
           'initbiz.cumulusdemo.advanced.dashboard' => [
               'name' => 'initbiz.cumulusdemo::lang.features.advanced_dashboard',
               'description' => 'initbiz.cumulusdemo::lang.features.advanced_dashboard_desc',
           ],
           'initbiz.cumulusdemo.basic.todo' => [
               'name' => 'initbiz.cumulusdemo::lang.features.basic_todo',
               'description' => 'initbiz.cumulusdemo::lang.features.basic_todo_desc',
           ],
           'initbiz.cumulusdemo.basic.gallery' => [
               'name' => 'initbiz.cumulusdemo::lang.features.basic_gallery',
               'description' => 'initbiz.cumulusdemo::lang.features.basic_gallery_desc',
           ],
           'initbiz.cumulusdemo.advanced.todo' => [
               'name' => 'initbiz.cumulusdemo::lang.features.advanced_todo',
               'description' => 'initbiz.cumulusdemo::lang.features.advanced_todo_desc',
           ],
           'initbiz.cumulusdemo.advanced.gallery' => [
               'name' => 'initbiz.cumulusdemo::lang.features.advanceds_gallery',
               'description' => 'initbiz.cumulusdemo::lang.features.advanced_gallery_desc',
           ],
        ];
    }
}
