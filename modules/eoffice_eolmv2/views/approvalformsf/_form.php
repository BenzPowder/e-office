<?php
use app\modules\eoffice_eolmv2\models\model_main\EofficeMainProvince;
use app\modules\eoffice_eolmv2\models\EolmBudgettype;
use app\modules\eoffice_eolmv2\models\EolmBudgetplan;
use app\modules\eoffice_eolmv2\models\EolmExpenditurecategoty;
use app\modules\eoffice_eolmv2\models\EolmVehicleType;
use app\modules\eoffice_eolmv2\models\ProjectSub;
use app\modules\eoffice_eolmv2\models\ProjectSubChild;
use app\modules\eoffice_eolmv2\models\EolmType;
use app\modules\eoffice_eolmv2\models\Person;
use app\modules\eoffice_eolmv2\models\model_main\EofficeMainViewPisPerson;
use app\modules\eoffice_eolmv2\models\model_main\EofficeMainPerson;
use app\modules\eoffice_eolmv2\models\model_main\EofficeMainViewStudentFull;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\eoffice_eolmv2\assets\AppAssetEolm;
use app\modules\eoffice_eolmv2\controllers;
use yii\bootstrap\Modal;




/* @var $this yii\web\View */
/* @var $model app\modules\eoffice_eolmv2\models\EolmApprovalform */
/* @var $form yii\widgets\ActiveForm */
AppAssetEolm::register( $this );
?>

<div class="eolm-approvalform-form">
    <!--<div class="panel-heading panel-heading-transparent">
        <h5 align = "right"><?/*= controllers::t( 'label_appform','travel request')*/?></h5>
    </div>-->
    <?php $form = ActiveForm::begin([

    ]); ?>

    <div class="col-md-12">
        <div class="panel panel-info ">
            <div class="panel-body">
                    <h4 align = "center">บันทึกข้อความ</h4>
                    <h5>ส่วนราชการ ภาควิชาวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์ โทร 44456</h5>

                <div class="col-md-6 col-sm-6" style="padding-left: 0px;">
                        <!-- วันที่ -->
                        <?= $form->field($model, 'eolm_app_date')->input('date',['class'=>'form-control'/*,'value'=> date("Y-m-d"),'disabled' => true*/])->label(controllers::t( 'label_appform','Date') ) ?>
                </div>

                <div  class="row">
                    <div class="col-md-6 col-sm-6">
                        <!-- โครงการ -->
                        <?=$form->field($model, 'pro_id')
                            ->dropDownList(
                                ArrayHelper::map(ProjectSub::find()->asArray()->all(), 'ProSub_id','ProSub_name')
                            )->label(controllers::t( 'label_appform','The project') ) ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?= $form->field($model, 'eolm_app_subject')->textarea(['rows' => '2'])->label(controllers::t( 'label_appform','Subject')) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <!-- อาจารย์ผู้ขออนุมัติ --->
                        <?=$form->field($model, 'person_ids1')
                            ->dropDownList(
                                ArrayHelper::map(EofficeMainViewPisPerson::find()->asArray()->where(['person_type' => 1])->all(), 'person_id' ,
                                    function($model) {
                                        return $model['academic_positions_abb_thai'].' '.$model['person_name'].' '.$model['person_surname'];
                                }
                        ))->label(controllers::t( 'label_appform','User approval'))
                        ?>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <!-- ผู้ติดตาม -->
                        <?= $form->field($model, 'person_ids')->widget(Select2::className(), [
                            'data' => ArrayHelper::map(EofficeMainViewPisPerson::find()->where(['person_type' => 1])->all(), 'person_id', function($model) {
                                return $model['academic_positions_abb_thai'].' '.$model['person_name'].' '.$model['person_surname'];
                            } /*'ใส่ชื่อและนามสกุล'*/),
                            'model' => $model,
                            'attribute' => 'person_ids',
                            'language' => 'th',
                            'options' => ['placeholder' => controllers::t( 'label_appform','Select...')],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ])->label(controllers::t( 'label_appform','Follower') ) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <!-- นักศึกษาที่ไปด้วย -->
                        <?= $form->field($model, 'person_ids2')->textarea(['rows' => '1'])->label(controllers::t( 'label_appform','Student follower')) ?>
                    </div>
                <?php if ($model->eolm_status_id == 3){
                    echo '<div class="row">
                    <div class="col-md-6 col-sm-6">
                         '.$form->field($model, 'eolm_app_number')->textInput()->label(controllers::t( 'label_appform','MOE')).'
                    </div>
                    <div class="col-md-6 col-sm-6">
                         '.$form->field($model, 'eolm_app_number2')->textInput()->label(controllers::t( 'label_appform','MOE')).'
                    </div>
                </div>';
                }?>

                    <div class="col-md-6 col-sm-6">
                        <!-- จังหวัด -->
                        <?= $form->field($model, 'provinces')->widget(Select2::className(), [
                            'model' => $model,
                            'attribute' => 'provinces',
                            'data' => ArrayHelper::map(EofficeMainProvince::find()->asArray()->orderBy('PROVINCE_NAME')->all(), 'PROVINCE_ID', 'PROVINCE_NAME'),
                            'options' => [
                                'multiple' => true,
                                'placeholder' => controllers::t( 'label_appform','Select...')
                            ],
                            'pluginOptions' => [
                                /*'EolmProvs' => true,*/
                                'allowClear' => true,
                            ],
                        ])->label(controllers::t( 'label_appform','Province') ) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <!-- ออกเดินทางจากที่พัก/ที่ทำงานตั้งแต่วันที่่ -->
                        <?= $form->field($model, 'eolm_app_deprture_date')->input('date'/*,['style'=>'width:180px']*/)->label(controllers::t( 'label_appform','Day of departure') ) ?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <!-- เดินทางกลับถึงที่พัก/ที่ทำงานในวันที -->
                        <?= $form->field($model, 'eolm_app_return_date')->input('date'/*,['style'=>'width:180px']*/)->label(controllers::t( 'label_appform','Day of return')  ) ?>
                    </div>
                </div>


                <div class="row">
                    <!---div class="col-md-6 col-sm-6">
                        <?=$form->field($model, 'eolm_app_number', [
                        ])->textInput(['maxlength' => true,'disabled' => true])->label(controllers::t( 'label_appform','MOE')  ) ?>
                    </div-->

                    <div class="col-md-6 col-sm-6">
                        <?=$form->field($model, 'eolm_budp_id')
                            ->dropDownList(
                                ArrayHelper::map(EolmBudgetplan::find()->asArray()->all(), 'eolm_budp_id', 'eolm_budp_name')
                            )->label(controllers::t( 'label_appform','From budget plan') ) ?>
                    </div>
                    <!-- หมวดรายจ่าย -->
                    <div class="col-md-6 col-sm-6">
                        <?=$form->field($model, 'eolm_exp_id')
                            ->dropDownList(
                                ArrayHelper::map(EolmExpenditurecategoty::find()->asArray()->all(), 'eolm_exp_id', 'eolm_exp_name')
                            )->label(controllers::t( 'label_appform','Group disbursement') ) ?>
                    </div>


                    <!-- งบประมาณ -->
                    <div class="col-md-6 col-sm-6">
                        <?php
                        $model->eolm_budt_id = '1';
                        echo $form->field($model, 'eolm_budt_id')->radioList(
                            ArrayHelper::map(EolmBudgettype::find()->asArray()->all(), 'eolm_budt_id', 'eolm_budt_name'), [/*'separator' => '<br>',*/'itemOptions' => ['disabled' => false, 'divOptions' => ['class' => 'radio-success']]]
                        )->label(controllers::t( 'label_appform','Budgets') ) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <!-- ประเภทการไปราชการ -->
                        <?=
                        $form->field($model, 'eolm_type_id')
                            ->dropDownList(
                                ArrayHelper::map(EolmType::find()->asArray()->all(), 'eolm_type_id', 'eolm_type_name')
                            )->label(controllers::t( 'label_appform','Type to be on duty as a civil servan')) ?>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <?php /*echo $form->field($model, 'eolm_budget_year')->widget(etsoft\widgets\YearSelectbox::classname(), [
                        'yearStart' => 543,
                        'yearEnd' => 548,
                    ])->label('ปีงบประมาณ') */?>
                        <?= $form->field($model, 'eolm_budget_year')->textInput(['value'=>date("Y") +543])->label(controllers::t( 'label_appform','Budget year')) ?>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 text-center">
        <div class="row">
            <?= Html::a(controllers::t( 'label','Back'), Yii::$app->request->referrer,['class' => 'btn btn-primary']);?>

            <?= Html::submitButton($model->isNewRecord ? controllers::t( 'label','Save') : controllers::t( 'label','Update'), [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'save']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>

