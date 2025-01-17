<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\repairsystem\models\RepairPhoto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repair-photo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rep_photo_id')->textInput() ?>

    <?= $form->field($model, 'rep_photo_detail')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
