<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\portfolio\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="project-index">



    <?= GridView::widget([
        'dataProvider' => $model,

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'project_id',
            'project_name_thai',
            'project_name_eng',
            'budget',
            //'sponsor_sponsor_id',
            // 'project_start',
            // 'project_end',
            // 'project_duration',
            // 'project_budget',
            // 'repayment',
            // 'project_url:url',
            // 'year_start',
            // 'year_end',
             'website',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
