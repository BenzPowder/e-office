<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FrequencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Frequencies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequency-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Frequency', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'frequency_order_id',
            'frequency_name',
            'frequency_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
