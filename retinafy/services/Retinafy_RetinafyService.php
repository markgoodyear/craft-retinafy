<?php
namespace Craft;

class Retinafy_RetinafyService extends BaseApplicationComponent
{

    /**
     * The Retinafy plugin instance.
     *
     * @var \Craft\RetinafyPlugin
     */
    protected $plugin;

    /**
     * Retinafy's settings.
     *
     * @var array
     */
    protected $settings;

    /**
     * Get Retinafy's settings.
     *
     * @return void
     */
    public function __construct()
    {
        $this->plugin = craft()->plugins->getPlugin('retinafy');
        $this->settings = $this->plugin->getSettings();
    }

    /**
     * Generate image and markup.
     *
     * @param \Craft\AssetFileModel $image
     * @param string                $transformHandle
     * @return void
     */
    public function retinaService(AssetFileModel $image, $transformHandle)
    {
        // Not transform and not 2x file. Return image url.
        if (!isset($transformHandle) && !$this->is2xFile($image))
        {
            $markup = $image->getUrl(false);
        }

        // Transform and not forced and not 2x file. Return transform image url.
        if (isset($transformHandle) && !$this->settings->force && !$this->is2xFile($image))
        {
            $markup = $image->getUrl($transformHandle);
        }

        // Not transform and 2x file. Create 1x image.
        if (!isset($transformHandle) && $this->is2xFile($image))
        {
            $markup = $this->create1xImage($image);
        }

        // Transform and is forced or 2x file. Create 2x image.
        if (isset($transformHandle) && ($this->settings->force || $this->is2xFile($image)))
        {
            // Use AssetTransformsService (AssetTransformModel).
            $transform = craft()->assetTransforms->getTransformByHandle($transformHandle);

            $markup = $this->create2xImage($image, $transform);
        }

        echo $markup;
    }

    /**
     * Check if image has @2x suffix.
     *
     * @param \Craft\AssetFileModel $image
     * @return bool
     */
    protected function is2xFile(AssetFileModel $image)
    {
        return preg_match('/' . $this->settings->suffix . '\\.\\w+$/', $image->filename) === 1;
    }

    /**
     * Create the 1x image.
     *
     * @param \Craft\AssetFileModel $image
     * @return string               $markup
     */
    protected function create1xImage(AssetFileModel $image)
    {
        // Set transform params.
        $params = [
            'mode'  => 'fit',
            'width' => round($image->width / 2)
        ];

        // Markup for the image.
        $markup = $image->getUrl($params) . '" srcset="' .  $image->getUrl() . ' 2x';

        return $markup;
    }

    /**
     * Create the 2x image.
     *
     * @param \Craft\AssetFileModel      $image
     * @param \Craft\AssetTransformModel $transform
     * @return string                    $markup
     */
    protected function create2xImage(AssetFileModel $image, AssetTransformModel $transform)
    {
        // Grab sizes as int.
        $originalWidth   = (int) $image->getWidth(false);
        $transformWidth  = (int) $transform->width;
        $transformHeight = (int) $transform->height;

        // Set transform params, uses params set in Craft.
        $params = [
            'mode'     => $transform->mode,
            'width'    => $transformWidth * 2,
            'height'   => $transformHeight * 2,
            'quality'  => $transform->quality,
            'position' => $transform->position
        ];

        // Markup for the specified transform.
        $markup = $image->getUrl($transform->handle);

        // If original width is bigger than the 2x size for the specified transform, add the srcset.
        if ($originalWidth >= $transformWidth * 2)
        {
            $markup .= '" srcset="' . $image->getUrl($params) . ' 2x';
        }

        return $markup;
    }

}
