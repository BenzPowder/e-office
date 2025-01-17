<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\eoffice_asset\models\AssetGetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asset Gets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-get-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Asset Get', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->asset_get_id), ['view', 'id' => $model->asset_get_id]);
        },
    ]) ?>
</div>
