<?php
namespace Craft;

class RetinafyPlugin extends BasePlugin
{

    /**
     * Adds the Twig extension.
     *
     * @return \Twig_Extension
     */
    public function addTwigExtension()
    {
        Craft::import('plugins.retinafy.twigextensions.RetinafyTwigExtension');

        return new RetinafyTwigExtension();
    }

    /**
     * Returns the name of the plugin.
     *
     * @return string
     */
    public function getName()
    {
        return 'Retinafy';
    }

    /**
     * Returns the plugin’s version number.
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
    * Returns the plugin developer’s name.
    *
    * @return string
    */
    public function getDeveloper()
    {
        return 'Mark Goodyear';
    }

    /**
    * Returns the plugin developer’s URL.
    *
    * @return string
    */
    public function getDeveloperUrl()
    {
        return 'http://markgoodyear.com';
    }

}
