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
    public function register()
    {
        $this->registerConsoleCommand('cumulus:seed', 'Initbiz\CumulusDemo\Console\Seed');
    }

    public function registerCumulusFeatures()
    {
        return [
           'initbiz.cumulusdemo.free_feature' => [
               'name' => 'initbiz.cumulusdemo::lang.features.free_feature',
               'description' => 'initbiz.cumulusdemo::lang.features.free_feature_desc',
           ],
           'initbiz.cumulusdemo.paid_feature' => [
               'name' => 'initbiz.cumulusdemo::lang.features.paid_feature',
               'description' => 'initbiz.cumulusdemo::lang.features.paid_feature_desc',
           ]
        ];
    }
}
