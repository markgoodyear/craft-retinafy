<?php
namespace Craft;

class Retinafy_RetinafyService extends BaseApplicationComponent
{

    /**
     * Determin which image to create.
     *
     * @param \Craft\AssetFileModel $image
     * @param string                $transformHandle
     * @return void
     */
    public function retinaService(AssetFileModel $image, $transformHandle)
    {
        // Return original image (with transform if specified) if not intended for @2x.
        if (!$this->is2xFile($image))
        {
            return $this->generateMarkup($image->getUrl(isset($transformHandle) ? $transformHandle : false));
        }

        // If transform specified, create 2x of it.
        if (isset($transformHandle))
        {
            // Use AssetTransformsService (AssetTransformModel).
            $transform = craft()->assetTransforms->getTransformByHandle($transformHandle);

            $this->create2xImage($image, $transform);

            return;
        }

        // No transform handle. Uploaded image is the 2x version, so we create the 1x version.
        $this->create1xImage($image);
    }

    /**
     * Check if image has @2x suffix.
     *
     * @param \Craft\AssetFileModel $image
     * @return bool
     */
    protected function is2xFile(AssetFileModel $image)
    {
        return preg_match('/@2x\\.\\w+$/', $image->filename) === 1;
    }

    /**
     * Create the 1x image.
     *
     * @param \Craft\AssetFileModel $image
     * @return void
     */
    protected function create1xImage(AssetFileModel $image)
    {
        // Set transform params.
        $params = [
            'mode'  => 'fit',
            'width' => round($image->width / 2)
        ];

        // Markup for the image.
        $markup = $image->getUrl($params) . '" srcset="' .  $image->getUrl() . ' 2x"';

        $this->generateMarkup($markup);
    }

    /**
     * Create the 2x image.
     *
     * @param \Craft\AssetFileModel      $image
     * @param \Craft\AssetTransformModel $transform
     * @return void
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
            'height'   => $transformHeight *2,
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

        $this->generateMarkup($markup);
    }

    /**
     * Echo out the markup.
     *
     * @param string $markup
     * @return void
     */
    protected function generateMarkup($markup)
    {
        echo $markup;
    }

}
