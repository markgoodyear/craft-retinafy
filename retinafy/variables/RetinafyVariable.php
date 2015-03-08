<?php
namespace Craft;

class RetinafyVariable
{

    /**
     * Echo out src and srcset markup.
     *
     * @param \Craft\AssetFileModel $image
     * @param string                $transformHandle
     * @return void
     */
    public function image(AssetFileModel $image, $transformHandle = null)
    {
        craft()->retinafy_retinafy->retinaService($image, $transformHandle);
    }

}
