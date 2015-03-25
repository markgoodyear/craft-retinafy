# Retinafy plugin for Craft.

Retinafy will only work on images with `@2x` in the filename. The `@2x` signifies its intended use.

By default, Retinafy generates the 1x version of the 2x version uploaded. The 1x version is used as the image tags `src` attribute, and the uploaded version is the `srcset` 2x version. For example, if your image is to be displayed at 250x250px, upload a 500x500px version, and Retinafy will handle the rest.

**Example output**:

```html
<img src="[generated_image_at_250x250].png"
     srcset="[uploaded_image_at_500x500].png 2x">
```

## Usage

### As a Craft variable
Retinafy can be used as a Craft variable:

```twig
<img src="{{ craft.retinafy.image(assetFieldName) }}">
```

### As a Twig filter
Retinafy can also be used as a Twig filter:
```twig
<img src="{{ assetFieldName | retinafy }}">
```
## Options
Retinafy allows passing in a custom image transform:

```twig
{# As a Craft variable #}
<img src="{{ craft.retinafy.image(assetFieldName, 'transformHandle') }}">

{# As a Twig filter #}
<img src="{{ assetFieldName | retinafy('transformHandle') }}">
```
When passing in a transform, Retinafy will use the generated image as the image tags `src`, and then determine if the uploaded image can be used as a 2x version. If the image is large enough, it will create the 2x version of the transform and add in the required `srcset` markup.

## Plugin Settings
Retinafy currently provides plugin settings to control the 2x suffix to suit your workflow (`@2x`, `.2x` etc.), and to bypass the 2x suffix when using transforms. Bypassing the 2x suffix on transforms is useful in many situations, such as when creating thumbnails for an image gallery where the original file wouldn't necessarily be 2x, but the thumbnails could display a 2x image if the original is big enough.

![Retinafy settings page](/screenshots/settings.png)

# License
Retinafy is licensed under the [MIT license](/LICENSE.md).
