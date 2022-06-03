<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConstructionSite */
/* @var $form yii\widgets\ActiveForm */
/* @var $allAccessLevels app\models\ConstructionSite */
?>

<div class="construction-site-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quadrature')->textInput() ?>

    <?= $form->field($model, 'access_level')->dropDownList($allAccessLevels, ['prompt' => 'Select Access Level']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
