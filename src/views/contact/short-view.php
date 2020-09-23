<?php

use hipanel\modules\client\grid\ContactGridView;
use hipanel\widgets\Box;
use yii\helpers\Inflector;

/**
 * @var \hipanel\modules\client\models\Contact
 */
$this->title = Inflector::titleize($model->name, true);
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $box = Box::begin(['renderBody' => false]) ?>
    <?php $box->beginBody() ?>
        <?= ContactGridView::detailView([
            'boxed'   => false,
            'model'   => $model,
            'columns' => [
                'id',
                'first_name', 'last_name', 'organization',
                'street1', 'city', 'province', 'postal_code', 'country',
            ],
        ]) ?>
    <?php $box->endBody() ?>
<?php $box->end() ?>

