<?php
namespace Craft;

Use Twig_Extension;
use Twig_SimpleFilter;

class RetinafyTwigExtension extends Twig_Extension {

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'Retinafy';
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('retinafy', [ $this, 'retinafy' ])
        ];
    }

    /**
     * Retinafy Twig filter.
     *
     * @param \Craft\AssetFileModel $image
     * @param string                $transformHandle
     * @return void
     */
    public function retinafy(AssetFileModel $image, $transformHandle = null)
    {
        craft()->retinafy_retinafy->retinaService($image, $transformHandle);
    }

}
