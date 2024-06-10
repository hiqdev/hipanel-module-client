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
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\models\Ref;
use hipanel\modules\client\helpers\blacklist\BlacklistCategory;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use Yii;

class BlacklistController extends CrudController
{
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
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'data' => [
                    'blacklistCategory' => $category,
                ],
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', sprintf('%s was updated', $category->getLabel())),
                'data' => [
                    'blacklistCategory' => $category,
                ],
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:client', sprintf('%s was created successfully', $category->getLabel())),
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
                'success' => Yii::t('hipanel:client', sprintf('%s(s) were deleted', $category->getLabel())),
                'error' => Yii::t(
                    'hipanel:client',
                    sprintf('Failed to delete %s(s)', $category->getLabel()),
                ),
            ],
        ]);
    }

    protected function getCategory(): BlacklistCategoryInterface
    {
        return new BlacklistCategory();
    }
}