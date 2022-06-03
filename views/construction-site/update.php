<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConstructionSite */
/* @var $allAccessLevels app\models\ConstructionSite */

$this->title = 'Update Construction Site: ' . $model->location;
$this->params['breadcrumbs'][] = ['label' => 'Construction Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->location, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="construction-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allAccessLevels' => $allAccessLevels,
    ]) ?>

</div>
