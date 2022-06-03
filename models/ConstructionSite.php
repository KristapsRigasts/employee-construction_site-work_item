<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "construction_site".
 *
 * @property int $id
 * @property string $location
 * @property int $quadrature
 * @property int $access_level
 *
 * @property WorkItem[] $workItems
 */
class ConstructionSite extends ActiveRecord
{
    private array $constructionSiteAccessLevels = [1 => 1, 2 => 2, 3 => 3];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'construction_site';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location', 'quadrature', 'access_level'], 'required'],
            [['quadrature', 'access_level'], 'integer'],
            [['location'], 'string', 'max' => 255],
            [['location'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location' => 'Location',
            'quadrature' => 'Quadrature',
            'access_level' => 'Access Level',
        ];
    }

    /**
     * Gets query for [[WorkItems]].
     *
     * @return ActiveQuery
     */
    public function getWorkItems()
    {
        return $this->hasMany(WorkItem::className(), ['construction_site_id' => 'id']);
    }

    public function getAllAccessLevels()
    {
        return $this->constructionSiteAccessLevels;
    }
}
