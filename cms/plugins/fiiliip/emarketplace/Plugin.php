<?php namespace Fiiliip\EMarketplace;

use Backend;
use System\Classes\PluginBase;

/**
 * EMarketplace Plugin Information File
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
            'name'        => 'EMarketplace',
            'description' => 'Plugin for EMarketplace.',
            'author'      => 'Fiiliip',
            'icon'        => 'icon-shopping-cart'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Fiiliip\EMarketplace\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'fiiliip.emarketplace.some_permission' => [
                'tab' => 'EMarketplace',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'emarketplace' => [
                'label'       => 'EMarketplace',
                'url'         => Backend::url('fiiliip/emarketplace/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['fiiliip.emarketplace.*'],
                'order'       => 500,
            ],
        ];
    }
}
