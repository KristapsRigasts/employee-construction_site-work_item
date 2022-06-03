<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkItem */
/* @var $workItemConstructionSite app\models\WorkItem */
/* @var $workItemEmployees app\models\WorkItem */

$this->title = 'Update Work Item: ' . $model->constructionSite->location;
$this->params['breadcrumbs'][] = ['label' => 'Work Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->constructionSite->location, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="work-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'workItemConstructionSite' => $workItemConstructionSite,
        'workItemEmployees' => $workItemEmployees,
    ]) ?>

</div>
