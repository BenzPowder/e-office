<?php

namespace app\modules\eoffice_eolmv2\models\model_main;

use Yii;

/**
 * This is the model class for table "eoffice_central.person".
 *
 * @property int $person_id
 * @property string $person_card_id
 * @property string $person_name
 * @property string $person_name_eng
 * @property string $person_surname
 * @property string $person_surname_eng
 * @property string $person_citizen_id
 * @property string $prefix_id
 * @property string $person_gender
 * @property string $person_birthdate
 * @property string $person_operate_status
 * @property string $person_start_date
 * @property string $person_contract_date
 * @property string $person_expire_date
 * @property string $person_confirmed_date
 * @property string $person_pass_probation_date
 * @property string $person_retire_date
 * @property string $person_official_age
 * @property string $person_decommission_date
 * @property string $person_account_hold
 * @property string $person_current_work_place
 * @property string $person_person_type
 * @property string $person_position_type
 * @property double $person_salary
 * @property string $person_administer_position
 * @property string $person_salary_position
 * @property string $person_pension
 * @property string $person_pension_withdraw
 * @property string $person_talent
 * @property string $person_current_address
 * @property int $person_current_district
 * @property int $person_current_amphur
 * @property int $person_current_province
 * @property int $person_current_zipcode
 * @property string $person_mobile
 * @property string $person_email
 * @property string $person_home_address
 * @property int $person_home_district
 * @property int $person_home_amphur
 * @property int $person_home_province
 * @property int $person_home_zipcode
 * @property string $person_fax
 * @property int $person_type
 * @property string $academic_positions_id
 * @property int $department_id
 * @property int $major_id
 * @property int $faculty_id
 * @property string $person_marital_status
 * @property string $person_group_blood
 * @property string $person_underlying_disease
 * @property int $person_religion_id
 * @property int $person_nation_id
 * @property string $person_website
 * @property string $person_line
 * @property string $person_facbook
 * @property string $person_img
 * @property string $person_position_staff
 */
class EofficeMainPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eoffice_central.person';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_eolm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_card_id', 'person_name', 'person_surname', 'person_citizen_id', 'prefix_id', 'person_email', 'person_type', 'department_id', 'faculty_id', 'person_religion_id', 'person_nation_id'], 'required'],
            [['person_birthdate', 'person_start_date', 'person_contract_date', 'person_expire_date', 'person_confirmed_date', 'person_pass_probation_date', 'person_retire_date', 'person_decommission_date'], 'safe'],
            [['person_salary'], 'number'],
            [['person_current_district', 'person_current_amphur', 'person_current_province', 'person_current_zipcode', 'person_home_district', 'person_home_amphur', 'person_home_province', 'person_home_zipcode', 'person_type', 'department_id', 'major_id', 'faculty_id', 'person_religion_id', 'person_nation_id'], 'integer'],
            [['person_card_id', 'person_mobile'], 'string', 'max' => 20],
            [['person_name', 'person_name_eng', 'person_surname', 'person_surname_eng', 'person_citizen_id', 'prefix_id', 'person_gender', 'person_operate_status', 'person_official_age', 'person_account_hold', 'person_current_work_place', 'person_person_type', 'person_position_type', 'person_administer_position', 'person_salary_position', 'person_pension', 'person_pension_withdraw', 'person_talent', 'academic_positions_id'], 'string', 'max' => 50],
            [['person_current_address', 'person_email', 'person_home_address', 'person_position_staff'], 'string', 'max' => 100],
            [['person_fax'], 'string', 'max' => 13],
            [['person_marital_status', 'person_group_blood', 'person_underlying_disease', 'person_website', 'person_line', 'person_facbook'], 'string', 'max' => 45],
            [['person_img'], 'string', 'max' => 200],
            [['person_card_id'], 'unique'],
            [['person_citizen_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'person_id' => 'Person ID',
            'person_card_id' => 'Person Card ID',
            'person_name' => 'Person Name',
            'person_name_eng' => 'Person Name Eng',
            'person_surname' => 'Person Surname',
            'person_surname_eng' => 'Person Surname Eng',
            'person_citizen_id' => 'Person Citizen ID',
            'prefix_id' => 'Prefix ID',
            'person_gender' => 'Person Gender',
            'person_birthdate' => 'Person Birthdate',
            'person_operate_status' => 'Person Operate Status',
            'person_start_date' => 'Person Start Date',
            'person_contract_date' => 'Person Contract Date',
            'person_expire_date' => 'Person Expire Date',
            'person_confirmed_date' => 'Person Confirmed Date',
            'person_pass_probation_date' => 'Person Pass Probation Date',
            'person_retire_date' => 'Person Retire Date',
            'person_official_age' => 'Person Official Age',
            'person_decommission_date' => 'Person Decommission Date',
            'person_account_hold' => 'Person Account Hold',
            'person_current_work_place' => 'Person Current Work Place',
            'person_person_type' => 'Person Person Type',
            'person_position_type' => 'Person Position Type',
            'person_salary' => 'Person Salary',
            'person_administer_position' => 'Person Administer Position',
            'person_salary_position' => 'Person Salary Position',
            'person_pension' => 'Person Pension',
            'person_pension_withdraw' => 'Person Pension Withdraw',
            'person_talent' => 'Person Talent',
            'person_current_address' => 'Person Current Address',
            'person_current_district' => 'Person Current District',
            'person_current_amphur' => 'Person Current Amphur',
            'person_current_province' => 'Person Current Province',
            'person_current_zipcode' => 'Person Current Zipcode',
            'person_mobile' => 'Person Mobile',
            'person_email' => 'Person Email',
            'person_home_address' => 'Person Home Address',
            'person_home_district' => 'Person Home District',
            'person_home_amphur' => 'Person Home Amphur',
            'person_home_province' => 'Person Home Province',
            'person_home_zipcode' => 'Person Home Zipcode',
            'person_fax' => 'Person Fax',
            'person_type' => 'Person Type',
            'academic_positions_id' => 'Academic Positions ID',
            'department_id' => 'Department ID',
            'major_id' => 'Major ID',
            'faculty_id' => 'Faculty ID',
            'person_marital_status' => 'Person Marital Status',
            'person_group_blood' => 'Person Group Blood',
            'person_underlying_disease' => 'Person Underlying Disease',
            'person_religion_id' => 'Person Religion ID',
            'person_nation_id' => 'Person Nation ID',
            'person_website' => 'Person Website',
            'person_line' => 'Person Line',
            'person_facbook' => 'Person Facbook',
            'person_img' => 'Person Img',
            'person_position_staff' => 'Person Position Staff',
        ];
    }
}
