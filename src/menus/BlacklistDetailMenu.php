<?php declare(strict_types=1);

namespace hipanel\modules\client\menus;

use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use hipanel\widgets\SimpleOperation;
use Yii;

class BlacklistDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public BlacklistCategoryInterface $category;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Edit'),
                'icon' => 'fa-pencil',
                'url' => [
                    sprintf('%s/update', $this->category->getUrlAlias()),
                    'id' => $this->model->id,
                ],
            ],
            'delete' => [
                'label' => SimpleOperation::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'buttonLabel' => '<i class="fa fa-fw fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                    'buttonClass' => '',
                    'body' => Yii::t('hipanel:hosting:account', sprintf('Are you sure you want to delete %s {name}?', $this->category->getLabel()), ['name' => $this->model->name]),
                    'modalHeaderLabel' => Yii::t('hipanel:hosting:account', sprintf('Confirm %s deleting', $this->category->getLabel())),
                    'modalHeaderOptions' => ['class' => 'label-danger'],
                    'modalFooterLabel' => Yii::t('hipanel:hosting:account', 'Delete'),
                    'modalFooterLoading' => Yii::t('hipanel:hosting:account', sprintf('Deleting %s', $this->category->getLabel())),
                    'modalFooterClass' => 'btn btn-danger',
                ]),
                'encode' => false,
                'visible' => true,
            ],
        ];
    }

    public function getViewPath()
    {
        return sprintf('@vendor/hiqdev/hipanel-module-client/src/views/%s', strtolower($this->category->getLabel()));
    }
}