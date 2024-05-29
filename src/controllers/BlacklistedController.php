<?php declare(strict_types=1);
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\models\Ref;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryFactory;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use Yii;

class BlacklistedController extends CrudController
{
    private function getCategory(): BlacklistCategoryInterface
    {
        return BlacklistCategoryFactory::getInstance(Yii::$app->request->get('category', 'blacklist'));
    }

    public function actions(): array
    {
        $category = $this->getCategory();

        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) use ($category) {
                    return [
                        'types' => $this->getRefs($category->getRefsName(), 'hipanel:client'),
                        'states' => $this->getRefs('state,blacklisted', 'hipanel:client'),
                        'blacklistCategory' => $category,
                    ];
                },
                'findOptions' => [
                    'category' => $category->getExternalValue()
                ],
                /*'filterStorageMap' => [
                    'state' => 'client.blacklist.state',
                    'states' => 'client.blacklist.states',
                    'type' => 'client.blacklist.type',
                ],*/
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'group' => $category,
                'data' => [
                    'blacklistCategory' => $category,
                ],
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Blacklist was updated'),
                'data' => [
                    'blacklistCategory' => $category,
                ],
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:client', $category->getLabel() . ' was created'),
                'data' => function ($action, $data) use ($category) {
                    return array_merge($data, [
                        'types' => Ref::getList($category->getRefsName()),
                        'blacklistCategory' => $category,
                    ]);
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', $category->getLabel() . '(s) were deleted'),
                'error' => Yii::t(
                    'hipanel:client',
                    sprintf('Failed to delete %s(s)', $category->getLabel()),
                ),
            ],
        ]);
    }
}