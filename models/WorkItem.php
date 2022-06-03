<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "work_item".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $construction_site_id
 * @property string $work_description
 *
 * @property ConstructionSite $constructionSite
 * @property Employee $employee
 */
class WorkItem extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'construction_site_id', 'work_description'], 'required'],
            [['employee_id', 'construction_site_id'], 'integer'],
            [['work_description'], 'string', 'max' => 255],
            [['construction_site_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConstructionSite::className(), 'targetAttribute' => ['construction_site_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee',
            'construction_site_id' => 'Construction Site',
            'work_description' => 'Work Description',
        ];
    }

    /**
     * Gets query for [[ConstructionSite]].
     *
     * @return ActiveQuery
     */
    public function getConstructionSite()
    {
        return $this->hasOne(ConstructionSite::className(), ['id' => 'construction_site_id']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    public static function getEmployeesForConstructionSite($location)
    {
        $constructionSiteId = ConstructionSite::find()->select('id')->where(['location' => lcfirst($location)])->one();

        $workItemData = WorkItem::find()->where(['construction_site_id' => $constructionSiteId])->all();

        $employeesForConstructionSite = [];

        foreach ($workItemData as $data) {
            if (!in_array($data->employee->name . " " . $data->employee->surname, $employeesForConstructionSite)) {
                $employeesForConstructionSite[] = $data->employee->name . " " . $data->employee->surname;
            }
        }
        return $employeesForConstructionSite;
    }

    public static function workItemConstructionSite()
    {
        return ArrayHelper::map(ConstructionSite::find()->orderBy('access_level ASC')->all(),
            'id', "location", 'access_level');
    }

    public static function workItemEmployees()
    {
        return ArrayHelper::map(Employee::find()->orderBy('access_level ASC')->all(),
            'id', "username", 'access_level');
    }
}
