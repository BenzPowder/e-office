<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\consulting\models\ViewPisUser */

$this->title = 'Create View Pis User';
$this->params['breadcrumbs'][] = ['label' => 'View Pis Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view-pis-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
