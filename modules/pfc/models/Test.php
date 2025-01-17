<?php

namespace app\modules\pfc\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $testName
 * @property string $testemail
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pfc');
    }


    public function rules()
    {
        return [
            [['testName', 'testemail'], 'required'],
            [['testName', 'testemail'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testName' => 'Test Name',
            'testemail' => 'Testemail',
        ];
    }
}
