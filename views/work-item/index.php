<?php

use app\models\WorkItem;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $loggedInUserRole app\models\Employee */
/* @var $employeeWorkList app\models\WorkItem */


$this->title = 'Work Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($loggedInUserRole === 'admin' || $loggedInUserRole === 'manager'): ?>
    <p>
        <?= Html::a('Create Work Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

<?php if($loggedInUserRole === 'admin'): ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Employee',
                'attribute' => 'employee_id',
                'value' => 'employee.username'
            ],
            [
                'label' => 'Construction Site',
                'attribute' => 'construction_site_id',
                'value' => 'constructionSite.location'
            ],
            'work_description',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, WorkItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]);

    ?>

<?php endif; ?>

    <?php if($loggedInUserRole === 'employee'): ?>

    <?= GridView::widget([
        'dataProvider' => $employeeWorkList,
        'pager' => [
            'class' => LinkPager::class
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Employee',
                'attribute' => 'employee_id',
                'value' => 'employee.username'
            ],
            [
                'label' => 'Construction Site',
                'attribute' => 'construction_site_id',
                'value' => 'constructionSite.location'
            ],
            'work_description',
        ],
    ]);
    ?>
    <?php endif; ?>

</div>
