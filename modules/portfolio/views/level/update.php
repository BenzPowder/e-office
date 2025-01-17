<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\portfolio\models\Level */

$this->title = 'Update Level: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->level_id, 'url' => ['view', 'id' => $model->level_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
