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
use hipanel\actions\SmartDeleteAction;
use hipanel\base\CrudController;
use Yii;

class BlacklistController extends CrudController
{
    public function actions(): array
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'types' => $this->getRefs('type,blacklisted', 'hipanel:client'),
                    ];
                },
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', 'Blacklist(s) were deleted'),
                'error' => Yii::t('hipanel:client', 'Failed to delete Blacklist(s)'),
            ],
            'bulk-delete-modal' => [
                'class' => PrepareBulkAction::class,
                'view' => '_bulkDelete',
            ],
        ]);
    }
}