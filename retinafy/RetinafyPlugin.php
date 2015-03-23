<?php
namespace Craft;

class RetinafyPlugin extends BasePlugin
{

    protected function defineSettings()
    {
        return [
            'force'  => [ AttributeType::Bool, 'default' => false ],
            'suffix' => [ AttributeType::String, 'default' => '@2x', 'required' => true ]
        ];
    }

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
        return '1.2.0';
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
