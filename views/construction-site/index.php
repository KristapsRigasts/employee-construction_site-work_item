<?php

use app\models\ConstructionSite;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConstructionSiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Construction Sites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="construction-site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Construction Site', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'location',
            'quadrature',
            'access_level',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ConstructionSite $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>
