<?php

namespace app\modules\eoffice_form\models;

use Yii;

/**
 * This is the model class for table "req_approval".
 *
 * @property int $user_id
 * @property int $template_id
 * @property string $cr_date
 * @property int $cr_term
 * @property int $cr_year
 * @property int $approve_group_queue
 * @property int $approve_id
 * @property string $approve_name
 * @property int $approve_queue
 * @property string $approve_status
 * @property string $approve_comment
 * @property string $approve_visible
 * @property string $approve_enddate
 * @property string $approve_json
 *
 * @property ReqApproveGroup $user
 */
class ReqApproval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'req_approval';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_form');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'template_id', 'cr_date', 'cr_term', 'cr_year', 'approve_group_queue', 'approve_id'], 'required'],
            [['user_id', 'template_id', 'cr_term', 'cr_year', 'approve_group_queue', 'approve_id', 'approve_queue'], 'integer'],
            [['cr_date', 'approve_enddate'], 'safe'],
            [['approve_json'], 'string'],
            [['approve_name'], 'string', 'max' => 150],
            [['approve_status', 'approve_visible'], 'string', 'max' => 45],
            [['approve_comment'], 'string', 'max' => 450],
            [['user_id', 'template_id', 'cr_date', 'cr_term', 'cr_year', 'approve_group_queue', 'approve_id'], 'unique', 'targetAttribute' => ['user_id', 'template_id', 'cr_date', 'cr_term', 'cr_year', 'approve_group_queue', 'approve_id']],
            [['user_id', 'template_id', 'cr_date', 'cr_term', 'cr_year', 'approve_group_queue'], 'exist', 'skipOnError' => true, 'targetClass' => ReqApproveGroup::className(), 'targetAttribute' => ['user_id' => 'user_id', 'template_id' => 'template_id', 'cr_date' => 'cr_date', 'cr_term' => 'cr_term', 'cr_year' => 'cr_year', 'approve_group_queue' => 'approve_group_queue']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'template_id' => 'แบบฟอร์มคำร้อง',
            'cr_date' => 'วันที่สร้าง',
            'cr_term' => 'เทอม',
            'cr_year' => 'ปีการศึกษา',
            'approve_group_queue' => 'กลุ่มพิจารณาที่',
            'approve_id' => 'รหัสผู้พิจารณา',
            'approve_name' => 'ชื่อผู้พิจารณา',
            'approve_queue' => 'ลำดับผู้พิจารณา',
            'approve_status' => 'สถานะการพิจารณา',
            'approve_comment' => 'รายละเอียด',
            'approve_visible' => 'Approve Visible',
            'approve_enddate' => 'วันที่สิ้นสุด',
            'approve_json' => 'Approve Json',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(ReqApproveGroup::className(), ['user_id' => 'user_id', 'template_id' => 'template_id', 'cr_date' => 'cr_date', 'cr_term' => 'cr_term', 'cr_year' => 'cr_year', 'approve_group_queue' => 'approve_group_queue']);
    }

    public function getUsername()
    {
        return $this->hasOne(ViewStudentJoinUser::className(), ['id' => 'user_id']);
    }
}
