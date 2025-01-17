<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\eoffice_form\models\ApprovePosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="content" class="dashboard">
    <div id="panel-1" class="panel panel-primary">
        <div class="panel-heading">
                  <span class="title elipsis">
                    <strong>Request Form</strong>
                  </span>
        </div>
        <div class="panel-body">
            <div class="approve-position-form">

                <?php $form = ActiveForm::begin(); ?>

                <?php
//                $attributeFunction = app\modules\eoffice_form\models\PositionDirectors::find()->all();
//                $listData=ArrayHelper::map($attributeFunction,'director_id','position_name');
                $attributeFunction = app\modules\eoffice_form\models\ViewPositionJoinAssign::find()->all();
                $listData=ArrayHelper::map($attributeFunction,'position_id','position_name');
                ?>

                <?= $form->field($model, 'position_id')->dropDownList(
                        [
                                ['9999' => 'อาจารย์ที่ปรึกษา' ],
                                $listData,
                        ],
                    ['prompt'=>'-- เลือกประเภท --'])
                ?>



                <?= $form->field($model, 'position_order')->textInput(['type'=>'number']) ?>

                <?= $form->field($model, 'approve_group_id')->hiddenInput(['value'=> $group_id,'readonly'=>'true'])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-check']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>


