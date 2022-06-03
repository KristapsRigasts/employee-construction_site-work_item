<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $password
 * @property string|null $birthday
 * @property int $access_level
 * @property string $role
 * @property string|null $auth_key
 *
 * @property WorkItem[] $workItems
 */
class Employee extends ActiveRecord implements IdentityInterface
{
    private array $employeeRoles = ['admin' => 'admin', 'manager' => 'manager', 'employee' => 'employee'];

    private array $employeeAccessLevels = [1 => 1, 2 => 2, 3 => 3];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'password', 'access_level', 'role'], 'required'],
            [['birthday'], 'string'],
            [['access_level'], 'integer'],
            [['name', 'surname', 'username', 'password', 'birthday', 'auth_key'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 50],
            [['role'], 'string', 'max' => 50],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'username' => 'Username',
            'password' => 'Password',
            'birthday' => 'Birthday',
            'access_level' => 'Access Level',
            'role' => 'Role',
            'auth_key' => 'Auth Key',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function signup($attributes)
    {
        if(Employee::find()->where(['username' => $attributes['username']])->one())
        {
             Yii::$app->session->setFlash('error', 'Username is taken!');
        }
        else {
            $employee = new Employee();
            $employee->name = $attributes['name'];
            $employee->surname = $attributes['surname'];
            $employee->username = $attributes['username'];
            $employee->password = Yii::$app->security->generatePasswordHash($attributes['password']);
            $employee->birthday = $attributes['birthday'];
            $employee->access_level = $attributes['access_level'];
            $employee->role = $attributes['role'];
            $employee->auth_key = Yii::$app->security->generateRandomString();

            $employee->save();

            return $employee->id;
        }
    }

    public function getRole()
    {
        return $this->role;
    }

    /**
     * Gets query for [[WorkItems]].
     *
     * @return ActiveQuery
     */
    public function getWorkItems()
    {
        return $this->hasMany(WorkItem::className(), ['employee_id' => 'id']);
    }

    public function getAllEmployeeRoles()
    {
        return $this->employeeRoles;
    }

    public function getAllAccessLevels()
    {
        return $this->employeeAccessLevels;
    }

    public static function loggedInUserRole()
    {
        if (Yii::$app->user->identity != null) {
            return Yii::$app->user->identity->getRole();
        }
    }
}
