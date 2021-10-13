<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client;

use hipanel\grid\RepresentationCollectionFinder;
use hipanel\grid\RepresentationCollectionFinderInterface;
use hipanel\grid\RepresentationCollectionFinderProviderInterface;
use yii\helpers\Inflector;
use Yii;

class Module extends \hipanel\base\Module implements RepresentationCollectionFinderProviderInterface
{
    public function getRepresentationCollectionFinder(): RepresentationCollectionFinderInterface
    {
        return new class(
            $this->id, Inflector::id2camel(Yii::$app->controller->id), '\hipanel\modules\%s\grid\%sRepresentations'
        ) extends RepresentationCollectionFinder {
            protected function buildClassName()
            {
                // Override
                return parent::buildClassName();
            }
        };
    }
}
