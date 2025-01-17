<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\helpers\ArrayHelper;
use app\modules\eoffice_repair\models\RepairDescription;
use app\modules\eoffice_repair\models\RepairStatus;
use app\modules\eoffice_repair\models\EofficeAssetViewAsset;
use app\modules\eoffice_repair\models\EofficeCentralViewPisRoom;
/* @var $this yii\web\View */
/* @var $model app\modules\eoffice_repair\models\RepairDescription */

$this->title = 'แสดงข้อมูลการแจ้งซ่อม';
// $this->title = 'รายการแจ้งซ่อม' ,$model->rep_desc_id;
$this->params['breadcrumbs'][] = ['label' => 'Repair Descriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repair-description-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->rep_desc_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rep_desc_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->


    <div id="panel-info" class="panel panel-default cs-remargin" style="margin-top: 20px">
        <div class="panel-body">
            <div class="content-info">
                <!--            <h3><i class="glyphicon glyphicon-file"></i>ทำรายการเบิกวัสดุ<span class="pull-right widen_id"><b>รหัสใบเบิกวัสดุ : </b>6589/21</span>-->
                <!--            </h3>-->
                <h3>
                    <i class="glyphicon glyphicon-list-alt"></i>ข้อมูลใบแจ้งซ่อม

                </h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rep_desc_id',
            [
              'attribute'=>'rep_desc_fname',

              'value'=>function($model){
                return $model->rep_desc_fname.' '.$model->rep_desc_lname;
              }
            ],
          //  'rep_desc_fname',
          //  'rep_desc_lname',
            'rep_desc_email:email',
            'rep_desc_tel',
            'asset_detail_id',
              'asset_detail_name',
              'rep_location',

            // [
            //
            //   'label' => 'หมายเลขครุภัณฑ์',
            //   'attribute'=>'rep_desc_id',
            //   'filter'=>ArrayHelper::map(RepairDescription::find()->all(),'rep_desc_id','asset_detail_id'),
            //   'value'=>function($model){
            //     return $model->repDesc->asset_detail_id;
            //   }
            // ],
            // [
            //
            //     'label' => 'ชื่อครุภัณฑ์',
            //   'attribute'=>'rep_desc_id',
            //   'filter'=>ArrayHelper::map(RepairDescription::find()->all(),'rep_desc_id','asset_detail_name'),
            //   'value'=>function($model){
            //     return $model->repDesc->asset_detail_name;
            //   }
            // ],
          //  'rep_desc_cost',
          //  'rep_desc_room_other',
          //  'rep_desc_comment',
            'rep_desc_request_date',

            // [
            //          'attribute'=>'buildings_id',
            //              'filter'=>ArrayHelper::map(Buildings::find()->all(),'buildings_id','buildings_id'),
            //                 'value'=>function($model){
            //                   return $model->buildings->buildings_id;
            //                }
            //             ],
            //'buildings_id',
//            [
//                          'attribute'=>'r',
//                          'filter'=>ArrayHelper::map(Rooms::find()->all(),'rooms_id','rooms_name'),
//                          'value'=>function($model){
//                              return $model->rooms->rooms_name;
//                          }
//                      ],
          //  'rooms_id',
          //  'rep_image_id',

        //    'rep_status_id',
//        [
//                      'attribute'=>'asset_detail_id',
//                      'filter'=>ArrayHelper::map(EofficeAssetViewAsset::find()->all(),'asset_detail_id','asset_dept_code_start'),
//                      'value'=>function($model){
//                          return $model->assetDetail->asset_dept_code_start;
//                      }
//                  ],
//                  [
//                                'attribute'=>'asset_detail_name',
//                                'filter'=>ArrayHelper::map(EofficeAssetViewAsset::find()->all(),'asset_detail_id','asset_detail_name'),
//                                'value'=>function($model){
//                                    return $model->assetDetail->asset_detail_name;
//                                }
//                            ],
  'rep_desc_detail',
                            [
                                          'attribute'=>'rep_status_id',
                                          'filter'=>ArrayHelper::map(RepairStatus::find()->all(),'rep_status_id','rep_status_name'),
                                          'value'=>function($model){
                                              return $model->repStatus->rep_status_name;
                                          }
                                      ],
                                      //'staff.staff_name',
                                      [
                                        'attribute'=>'staff.staff_name',
                                          'label'=>'เจ้าหน้าที่ผู้ดูแล',

                                      ],
            //'asset_detail_id',
        ],
    ]) ?></div></div></div>
    <div class="form-group">
    <?= Html::a('กลับไปหน้ารายการแจ้งซ่อม', ['/eoffice_repair/repair-description/list-repair'], ['class'=>'btn btn-primary pull-right']) ?>
    </div>
</div>
