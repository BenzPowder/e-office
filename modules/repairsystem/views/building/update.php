<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\repairsystem\models\Building */

$this->title = 'Update Building: ' . $model->building_id;
$this->params['breadcrumbs'][] = ['label' => 'Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->building_id, 'url' => ['view', 'id' => $model->building_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="building-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
