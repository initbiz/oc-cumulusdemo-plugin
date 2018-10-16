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
            'name'        => 'Cumulus Demo Plugin',
            'description' => 'Demonstration plugin for CumulusCore based application',
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
}
