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
            $this->create2xImage($image, $transformHandle);

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
     * @param AssetFileModel $image
     * @return void
     */
    protected function create1xImage(AssetFileModel $image)
    {
        $markup  = $image->getUrl($this->getTransform($image, true)) . '" srcset="' .  $image->getUrl() . ' 2x"';

        $this->generateMarkup($markup);
    }

    /**
     * Create the 2x image.
     *
     * @param \Craft\AssetFileModel $image
     * @param string                $transformHandle
     * @return void
     */
    protected function create2xImage(AssetFileModel $image, $transformHandle)
    {
        $originalWidth  = (int) $image->getWidth(false);
        $transformWidth = (int) $image->getWidth($transformHandle);

        // Markup for the specified transform.
        $markup = $image->getUrl($transformHandle);

        // If original width is bigger than the 2x size for the specified transform, add the srcset.
        if ($originalWidth > $transformWidth * 2)
        {
            $markup .= '" srcset="' . $image->getUrl($this->getTransform($image)) . ' 2x';
        }

        $this->generateMarkup($markup);
    }

    /**
     * Get transform.
     * @param \Craft\AssetFileModel $image
     * @param bool                  $is2x - If the image we pass in is the 2x version
     * @return array
     */
    protected function getTransform(AssetFileModel $image, $is2x = false)
    {
        return [
            'mode'  => 'fit',
            'width' => $is2x ? round($image->width / 2) : $image->width * 2
        ];
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
