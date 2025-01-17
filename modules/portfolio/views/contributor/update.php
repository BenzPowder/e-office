<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\portfolio\models\Contributor */

$this->title = 'Update Contributor: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Contributors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->contributor_id, 'url' => ['view', 'id' => $model->contributor_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contributor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
