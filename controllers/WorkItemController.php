<?php

namespace app\controllers;

use app\models\ConstructionSite;
use app\models\Employee;
use app\models\WorkItem;
use app\models\WorkItemSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkItemController implements the CRUD actions for WorkItem model.
 */
class WorkItemController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['update', 'create', 'delete', 'index', 'view', 'lists'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function () {
                                return Employee::loggedInUserRole() === 'admin';
                            }
                        ],
                        [
                            'actions' => ['create', 'index', 'lists'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function () {
                                return Employee::loggedInUserRole() === 'manager';
                            }
                        ],
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function () {
                                return Employee::loggedInUserRole() === 'employee';
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all WorkItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $loggedInUserRole = Employee::loggedInUserRole();

        $employeeWorkList = new ActiveDataProvider([
            'query' => WorkItem::find()->where(['employee_id' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'loggedInUserRole' => $loggedInUserRole,
            'employeeWorkList' => $employeeWorkList,
        ]);
    }

    /**
     * Displays a single WorkItem model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WorkItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WorkItem();

        $workItemConstructionSite = WorkItem::workItemConstructionSite();

        $workItemEmployees = WorkItem::workItemEmployees();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if(Employee::loggedInUserRole() === 'manager')
                {
                    Yii::$app->session->setFlash('success', 'Work item has been added!');
                    return $this->redirect('/work-item');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'workItemConstructionSite' => $workItemConstructionSite,
            'workItemEmployees' => $workItemEmployees,
        ]);
    }

    /**
     * Updates an existing WorkItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $workItemConstructionSite = WorkItem::workItemConstructionSite();

        $workItemEmployees = WorkItem::workItemEmployees();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'workItemConstructionSite' => $workItemConstructionSite,
            'workItemEmployees' => $workItemEmployees,
        ]);
    }

    /**
     * Deletes an existing WorkItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return WorkItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkItem::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLists($id)
    {
        $constructionSiteAccessLevel = ConstructionSite::find()->select('access_level')->where(['id' => $id])->One();
        $employeesWithAccessLevel = Employee::find()->where(['access_level' => $constructionSiteAccessLevel])->all();

        if (isset($employeesWithAccessLevel) && count($employeesWithAccessLevel) > 0) {
            foreach ($employeesWithAccessLevel as $employee) {
                echo "<option value='" . $employee->id . "'>" . $employee->username . "</option>";
            }
        } else {
            echo "<option> No Employees With Access Level </option>";
        }
    }
}
