<?php

namespace app\modules\correspondence\models;

use app\modules\correspondence\controllers;
use app\modules\correspondence\models\model_main\EofficeCentralViewPisUser;
use bedezign\yii2\audit\components\db\ActiveRecord;
use Yii;

/**
 * AuditTrail
 *
 * @property integer $id
 * @property integer $entry_id
 * @property integer $user_id
 * @property string $action
 * @property string $model
 * @property string $model_id
 * @property string $field
 * @property string $new_value
 * @property string $old_value
 * @property string $created
 *
 * @property AuditEntry $entry
 */
class AuditTrail extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%audit_trail}}';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('audit', 'ID'),
            'entry_id' => Yii::t('audit', 'Entry ID'),
            'user_id' => Yii::t('audit', 'User ID'),
            'action' => Yii::t('audit', 'Action'),
            'model' => Yii::t('audit', 'Type'),
            'model_id' => Yii::t('audit', 'Model ID'),
            'field' => Yii::t('audit', 'Field'),
            'old_value' => Yii::t('audit', 'Old Value'),
            'new_value' => Yii::t('audit', 'New Value'),
            'created' => Yii::t('audit', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(AuditEntry::className(), ['id' => 'entry_id']);
    }

    public function getDocument()
    {
        return $this->hasOne(CmsDocument::className(), ['doc_id' => 'model_id']);
    }
    public function getUser()
    {
        return $this->hasOne(EofficeCentralViewPisUser::className(), ['id' => 'user_id']);
    }
    /**
     * @return mixed
     */
    public function getDiffHtml($model)
    {
        if ($model->old_value == "1") {
            $model->old_value = controllers::t('menu', CmsDocCheck::findOne($model->old_value)->check_name);
        } elseif ($model->old_value == "2") {
            $model->old_value = controllers::t('menu', CmsDocCheck::findOne($model->old_value)->check_name);
        }

        if ($model->new_value == "1") {
            $model->new_value = controllers::t('menu', CmsDocCheck::findOne($model->new_value)->check_name);
        } elseif ($model->new_value == "2") {
            $model->new_value = controllers::t('menu', CmsDocCheck::findOne($model->new_value)->check_name);
        }
        $old = explode("\n", $model->old_value);
        $new = explode("\n", $model->new_value);

        foreach ($old as $i => $line) {
            $old[$i] = rtrim($line, "\r\n");
        }
        foreach ($new as $i => $line) {
            $new[$i] = rtrim($line, "\r\n");
        }

        $diff = new \Diff($old, $new);
        return $diff->render(new \Diff_Renderer_Html_Inline);
    }

    /**
     * @return ActiveRecord|bool
     */
    public function getParent()
    {
        $parentModel = new $this->model;
        $parent = $parentModel::findOne($this->model_id);
        return $parent ? $parent : $parentModel;
    }

}
