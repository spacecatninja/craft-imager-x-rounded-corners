<?php
/**
 * Rounded corners effect for Imager X
 *
 * @link      https://www.spacecat.ninja/
 * @copyright Copyright (c) 2022 André Elvan
 */

namespace spacecatninja\imagerxroundedcorners\effects;

use craft\helpers\ArrayHelper;
use spacecatninja\imagerx\effects\ImagerEffectsInterface;
use spacecatninja\imagerx\exceptions\ImagerException;
use spacecatninja\imagerx\services\ImagerService;
use Imagine\Gd\Image as GdImage;
use Imagine\Imagick\Image as ImagickImage;
use Imagine\Imagick\Imagick;

class RoundedCornersEffect implements ImagerEffectsInterface
{

    /**
     * @param GdImage|ImagickImage             $imageInstance
     * @param array|string|int|float|bool|null $params
     */
    public static function apply(ImagickImage|GdImage $imageInstance, $params): void
    {
        if (ArrayHelper::isAssociative($params)) {
            $radius = $params['radius'] ?? 0;
            $fixEdge = $params['fixEdge'] ?? false;
        } elseif (is_int($params)) {
            $radius = $params;
            $fixEdge = false;
        } else {
            throw new ImagerException('Invalid parameter passed to rounded corners effect. It either needs to be an integer specifying the radius of the corners, or an object with keys for `radius` and (optionally) `fixEdge`.');
        }
        
        if (ImagerService::$imageDriver === 'imagick') {
            /** @var ImagickImage $imageInstance */
            $imagickInstance = $imageInstance->getImagick();
            $width = $imageInstance->getSize()->getWidth();
            $height = $imageInstance->getSize()->getHeight();

            $mask = new Imagick();
            $mask->newImage($width, $height, new \ImagickPixel('transparent'), 'png');
            
            // create the rounded rectangle
            $shape = new \ImagickDraw();
            $shape->setFillColor(new \ImagickPixel('red'));
            $shape->roundRectangle(0, 0, $width-($fixEdge ? 1 : 0), $height-($fixEdge ? 1 : 0), $radius, $radius);
            
            // draw the rectangle
            $mask->drawImage($shape);
            
            // apply mask
            $imagickInstance->setImageFormat('png');
            $imagickInstance->setImageBackgroundColor(new \ImagickPixel('transparent'));
            
            if (method_exists($imagickInstance, 'setImageAlpha')) { // ImageMagick >= 7
                $imagickInstance->setImageAlpha(true);
            } else if (method_exists($imagickInstance, 'setImageOpacity')) {
                $imagickInstance->setImageOpacity(true);
            }            
                
            $imagickInstance->compositeImage($mask, Imagick::COMPOSITE_DSTATOP, 0, 0);
        }
    }
}
