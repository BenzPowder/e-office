<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\repairsystem\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            'password_hash',
            'auth_key',
            // 'confirmed_at',
            // 'unconfirmed_email:email',
            // 'blocked_at',
            // 'registration_ip',
            // 'created_at',
            // 'updated_at',
            // 'flags',
            // 'last_login_at',
            // 'status',
            // 'password_reset_token',
            // 'fname',
            // 'lname',
            // 'tel',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
