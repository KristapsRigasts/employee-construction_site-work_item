<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WorkItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $workItemConstructionSite app\models\WorkItem */
/* @var $workItemEmployees app\models\WorkItem */
?>

<div class="work-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'construction_site_id')->dropDownList(
        $workItemConstructionSite,
        ['prompt' => 'Select Construction Site by Access Level',
        'onchange'=>'
        $.post("/work-item/lists?id='.'"+$(this).val(), function(data) {
        $("select#workitem-employee_id").html(data);
        });'
        ]); ?>

    <?= $form->field($model, 'employee_id')->dropDownList(
        $workItemEmployees,
        ['prompt' => 'Select Employee by Access Level']
    )
    ?>

    <?= $form->field($model, 'work_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
