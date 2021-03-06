<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkItem */
/* @var $workItemConstructionSite app\models\WorkItem */
/* @var $workItemEmployees app\models\WorkItem */

$this->title = 'Create Work Item';
$this->params['breadcrumbs'][] = ['label' => 'Work Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'workItemConstructionSite' => $workItemConstructionSite,
        'workItemEmployees' => $workItemEmployees,
    ]) ?>

</div>
