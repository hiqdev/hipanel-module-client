<?php

namespace hipanel\modules\client\widgets;

use hipanel\modules\client\assets\PermissionTreeAsset;
use hipanel\modules\client\models\Permission;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\View;

class PermissionTree extends Widget
{
    public Permission $model;

    public string $selector;

    private string $tableId;

    public function init()
    {
        parent::init();
        $this->tableId = 'permission-tree-' . $this->id;
    }

    public function run(): string
    {
        $this->registerScript();

        return $this->render('PermissionTreeView', ['tableId' => $this->tableId]);
    }

    private function registerScript(): void
    {
        PermissionTreeAsset::register($this->view);
        $opts = [
            'roles' => $this->model->getRoles(),
            'permissions' => $this->model->getPermissions(),
            'children' => $this->model->getChildren(),
        ];
        $selector = Json::htmlEncode($this->selector);
        $treeTable = Json::htmlEncode('#' . $this->tableId);
        $this->view->registerJsVar('_pt_opts', $opts, View::POS_BEGIN);
        $this->view->registerJs(<<<"JS"
;(() => {
  const table = $({$treeTable});
  table.treetable({
    expandable:     true,
    onNodeExpand:   nodeExpand
  });
  function nodeHasChildren(name) {
    const children = _pt_opts.children[name];

    return children && Object.keys(children).length;
  }
  function nodeExpand () {
  	const parentNodeID = this.id;
  	const childNodes = _pt_opts.children[parentNodeID];
  	if (childNodes) {
        const parentNode = table.treetable("node", parentNodeID);
        for (const [key, value] of Object.entries(childNodes)) {
          var nodeToAdd = table.treetable("node", key);
          if (!nodeToAdd) {
           table.treetable("loadBranch", parentNode, renderNode(key, value, nodeHasChildren(key), parentNodeID)); 
          }
        }
  	}
  }
  function clearTable() {
    table.find('tr').each(function () {
      const id = this.dataset.ttId;
      const parenId = this.dataset.ttParentId;
      if (id && !parenId) {
        table.treetable("removeNode", id);
      }
    });
  }
  function renderNode(name, elem, isBranch = false, parentName = null) {
      let html = "<tr";
      html += " data-tt-id='" + elem.name + "'";
      if (isBranch) {
          html += " data-tt-branch='true'";
      }
      if (parentName) {
          html += " data-tt-parent-id='" + parentName + "'";
      }
      html += ">";
      html += "<td>" + elem.name + "</td>";
      html += "<td>" + elem.description + "</td>";
      html += "</tr>";

      return html;
  }
  $({$selector}).change(() => {
    clearTable();
    const items = [];
    const selected = Array.prototype.slice.call(document.querySelectorAll({$selector} + " option:checked"), 0).map((v) => v.value);
    selected.forEach(name => {
      const elem = _pt_opts.roles[name] || _pt_opts.permissions[name];
      items.push(renderNode(name, elem, nodeHasChildren(name)));
    });
    for (let idx = 0; idx < items.length; idx++) {
      table.treetable("loadBranch", null, items[idx]);
    }
  });
})();
JS
            , View::POS_END);
    }
}
