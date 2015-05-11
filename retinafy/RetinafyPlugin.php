<?php
namespace Craft;

class RetinafyPlugin extends BasePlugin
{

    /**
     * Define plugin settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return [
            'force'  => [ AttributeType::Bool, 'default' => false ],
            'suffix' => [ AttributeType::String, 'default' => '@2x', 'required' => true ]
        ];
    }

    /**
     * Get the HTML for settings.
     *
     * @return string
     */
    public function getSettingsHtml()
    {
        return craft()->templates->render('retinafy/_settings', [
            'settings' => $this->getSettings()
        ]);
    }

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
        return Craft::t('Retinafy');
    }

    /**
     * Returns the plugin’s version number.
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.2.1';
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
