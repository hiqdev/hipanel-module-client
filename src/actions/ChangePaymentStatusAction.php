<?php declare(strict_types=1);

namespace hipanel\modules\client\actions;

use hipanel\actions\RedirectAction;
use hipanel\actions\SmartUpdateAction;

class ChangePaymentStatusAction extends SmartUpdateAction
{
    public function init(): void
    {
        parent::init();
        $this->_items['POST html']['error'] = [
            'class' => RedirectAction::class,
            'url' => static fn($action) => $action->collection->count() > 1 ?
                $action->controller->getSearchUrl() :
                $action->controller->getActionUrl('view', ['id' => $action->collection->first->id]),
        ];
    }
}
