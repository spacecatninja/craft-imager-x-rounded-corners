<?php
/**
 * Rounded corners effect for Imager X
 *
 * @link      https://www.spacecat.ninja/
 * @copyright Copyright (c) 2022 André Elvan
 */

namespace spacecatninja\imagerxroundedcorners;

use craft\base\Plugin;

use spacecatninja\imagerxroundedcorners\effects\RoundedCornersEffect;
use yii\base\Event;

/**
 * @author    SpaceCatNinja
 * @package   ImagerXRoundedCorners
 * @since     1.0.0
 *
 */
class ImagerXRoundedCorners extends Plugin
{
    public function init(): void
    {
        parent::init();

        Event::on(\spacecatninja\imagerx\ImagerX::class,
            \spacecatninja\imagerx\ImagerX::EVENT_REGISTER_EFFECTS,
            static function (\spacecatninja\imagerx\events\RegisterEffectsEvent $event) {
                $event->effects['roundedcorners'] = RoundedCornersEffect::class;
            }
        );
    }
}
