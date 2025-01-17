<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\modules\pfc\models\ProcessProgress;
use yii\widgets\ActiveForm;
use app\modules\pfc\models\ProcessRequirementConnect;
use app\modules\pfc\models\ProcessProgressFile;
use app\modules\pfc\models\ProcessProgressConnect;

/* @var $this yii\web\View */
/* @var $model app\modules\pfc\models\Project */
/* @var $model app\modules\pfc\models\Student */
/* @var $model app\modules\pfc\models\Requirement */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
$project_id_k = "";
$process_id_k = "";
$type_k = "";
$bar_set = 0.00;
$bar_day =0.00;
$bar_month =0.00;
$bar_constant = 0.00;
$count = 1;
$check_requirement = 1;
$check_process_add = null;

$bar_sets = 0.00;
$bar_days =0.00;
$bar_months =0.00;
$bar_constants = 0.00;

$score_full_sum = 0;
$score_full = 0;
?>

<link href="<?= Yii::$app->homeUrl ?>web_pfc/css/gantt.css" rel="stylesheet" type="text/css" />


    <header id="page-header">
        <h1>กำหนดการของโครงงาน</h1>
        <ol class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>pfc/project/project_student?student_id=<?= $session['pfc_id'] ?>">
                    <?= $project_name ?></a></li>
            <li class="active">กำหนดการโครงงาน <?= $project_name ?></li>
        </ol>
    </header>

    <div class="padding-20">
        <div class="row">
            <ul class="nav">

                <label><!-- PER PAGE SELECTOR . you can move it to panel-heading -->
                    <select class="form-control pointer" id="change-page-size">
                        <option value="1">1 / page</option>
                        <option value="5">5 / page</option>
                        <option value="10" selected="selected">10 / page</option>
                        <option value="100">All</option>
                    </select>
                </label><!-- /PER PAGE SELECTOR -->
                <table class="fooTableInit" width='100' style='table-layout:fixed'>
                    <thead>
                    <tr>
                        <th class="footable-visible footable-sortable" style="width: 250px">หัวข้อ</th>
                        <th class="footable-visible footable-sortable" style="width: 670px">
                            <div>
                                <?php
                                $month = ['ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.'];
                                for($i=0;$i<12;$i++){
                                ?>
                                <div class="stacked-bar-graph">
                                    <span style="width:60px" class="block-mount"><?= $month[$i]; ?></span>
                                    <?php } ?>
                                </div>
                                <?php for($i=0;$i<12;$i++){?>
                                <div class="stacked-bar-graph">
                                    <span style="width:15px" class="block-week">1</span>
                                    <span style="width:15px" class="block-week">2</span>
                                    <span style="width:15px" class="block-week">3</span>
                                    <span style="width:15px" class="block-week">4</span>
                                    <?php } ?>
                                </div>

                            </div>
                        </th>
                        <th class="footable-visible footable-sortable"style="width: 70px">คะแนน</th>
                        <th data-type="text" data-hide = "s600,s1000" class=""></th>
                    </tr>
                    </thead>

                    <tbody>

    <!-- ----------------------------------------------------------------------------------------------------------------- -->
                    <?php $process_id_k = $process[0]->process_id; ?>
                    <?php $project_id_k = $process[0]->project_id; ?>
                    <?php $type_k = $type; ?>
                    <?php foreach ($process_progress as $process_progressn){
                        foreach ($process_add_con as $process_add_cons) {
                            if ($process_add_cons->process_progress_id == $process_progressn->process_progress_id) {
                                foreach ($process_add as $process_adds) {
                                    if ($process_adds->process_add_id == $process_add_cons->process_add_id) {
                                                $add_id = $process_adds->process_add_id;

//=================================================== Bar Calculate =============================================================================

                                                $start_dates = strtotime($process_adds->process_add_date_start);
                                                $end_dates = strtotime($process_adds->process_add_date_end);
                                                $start_date_constants = strtotime($start_date_constant);
                                                $bar_constant_ms = 0;
                                                $bar_constant_ds = 0;

//============================================= White Bar Calculate =============================================================================

                                                if ($start_date_constants != $start_dates) {
                                                    if (date('y', $start_date_constants) != date('y', $start_dates)) {
                                                        $bar_constant_ms = (12 - date('m', $start_date_constants) + date('m', $start_dates)) * 4;
                                                    } else {
                                                        $bar_constant_ms = (date('m', $start_dates) - date('m', $start_date_constants)) * 4;
                                                        if (date('m', $start_date_constants) != date('m', $start_dates)) {
                                                            $bar_constant_ms = (date('m', $start_dates) - date('m', $start_date_constants)) * 4;
                                                        }
                                                    }

                                                    $bar_constant_ds = round((date('d', $start_dates) - date('d', $start_date_constants)) / 7);

                                                    $bar_constants = $bar_constant_ds + $bar_constant_ms;
                                                } else {
                                                    $bar_constants = 0;
                                                }


//===========================================  End White Bar Calculate ========================================================================

                                                $bar_sets = $end_dates - $start_dates;
                                                $bar_sets = round((floor($bar_sets / (60 * 60 * 24)) - 1) / 7);

//=================================================== End Bar Calculate =========================================================================
                                                ?>
                                                <tr>
                                                    <td><?= $process_progressn->process_progress_no ?>
                                                        .<?= $process_adds->process_add_topic ?></td>
                                                    <td>
                                                        <div class="stacked-bar-graph">

                                                            <?php $iss = 1;
                                                            while ($bar_constants >= $iss): ?>
                                                                <span style="width:15px" class="bar-1"></span>
                                                                <?php $iss++; endwhile; ?>

                                                            <?php $jss = 1;
                                                            while ($bar_sets >= $jss): ?>
                                                                <span style="width:15px" class="bar-2"></span>
                                                                <?php $jss++; endwhile; ?>

                                                            <?php $kss = 1;
                                                            while (48 - ($bar_constants + $bar_sets) >= $kss): ?>
                                                                <span style="width:15px" class="bar-1"></span>
                                                                <?php $kss++; endwhile; ?>
                                                        </div>

                                                    </td>

                                                    <!-- =========================================================    Chart    ================================================================= -->

                                                    <td style="text-align:center;">
                                                        <div>
                                                            <?php if($process_progressn->process_progress_score != 0){ ?>
                                                                <span class="easyPieChart" data-percent="<?= $process_progressn->process_progress_score/$process_progressn->process_progress_score_full*100 ?>"
                                                                      data-easing="easeOutBounce" data-barColor="#F08080"
                                                                      data-trackColor="#dddddd" data-scaleColor="#dddddd"
                                                                      data-size="43" data-lineWidth="4" onclick="clickScore(this)"
                                                                      onmouseover="scorePopup()"></span>
                                                            <?php }else{ ?>
                                                                <span class="easyPieChart" data-percent="0"
                                                                      data-easing="easeOutBounce" data-barColor="#F08080"
                                                                      data-trackColor="#dddddd" data-scaleColor="#dddddd"
                                                                      data-size="43" data-lineWidth="4" onclick="clickScore(this)"
                                                                      onmouseover="scorePopup()"></span>
                                                            <?php } ?>
                                                        </div>

                                                        <div>
                                                            <span>
                                                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                                                        data-target="#bs-example-modal-lg-score-<?= $process_progressn->process_progress_id ?>">
                                                                    <?= $process_progressn->process_progress_score ?> / <?= $process_progressn->process_progress_score_full ?>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <!-- =========================================================    Chart    ================================================================= -->

                                                    <td style="display: none;">
                                                        <div>
                                                            รายละเอียด : <?= $process_adds->process_add_detail ?><br>
                                                            วันที่กำหนด : <?= date('d/m/Y', $start_dates) ?>
                                                            - <?= date('d/m/Y', $end_dates) ?>
                                                        </div>
                                                        <br>

                                                        <!-- ========================================================= Requirement check ================================================================= -->
                                                        <?php $requirement_check = 0; ?>
                                                        <?php foreach ($process_requirement as $process_requirements_check) {
                                                            if ($process_requirements_check->process_progress_id == $process_progressn->process_progress_id) {
                                                                $requirement_check = 1;
                                                            }
                                                        }
                                                        ?>

                                                        <!-- ========================================================= Requirement check ================================================================= -->

                                                        <?php if ($requirement_check == 1) { ?>
                                                            <table class="table table-bordered nomargin">
                                                                <thead>
                                                                <tr class="warning">
                                                                    <th style="width: 150px">
                                                                        หัวข้อกำหนดการย่อย
                                                                    </th>
                                                                    <th style="width: 250px">รายละเอียด</th>
                                                                    <th style="width: 150px">ไฟล์งาน</th>
                                                                    <th style="width: 15px"></th>
                                                                    <th style="width: 150px">ตรวจสอบ</th>
                                                                </tr>
                                                                </thead>
                                                                <?php foreach ($process_requirement as $process_requirements) {
                                                                    if ($process_requirements->process_progress_id == $process_progressn->process_progress_id) { ?>
                                                                        <tbody>
                                                                        <tr class="warning">
                                                                            <td><?= $process_requirements->process_requirement_topic ?></td>
                                                                            <td><?= $process_requirements->process_requirement_detail ?></td>
                                                                            <td>
                                                                                <div class="col-md-12 col-sm-12">
                                                                                    <label>อาจารย์</label>
                                                                                    <div class="col-md-12">
                                                                                        <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                                                            <option selected="selected">เลือกไฟล์...</option>
                                                                                            <?php $process_requirement_con = ProcessRequirementConnect::find()->where("process_requirement_id like :b", [":b" => $process_requirements->process_requirement_id])->all();
                                                                                            $process_progress_file = ProcessProgressFile::find()->all();
                                                                                            foreach ($process_requirement_con as $process_requirement_cons){
                                                                                                foreach ($process_progress_file as $process_progress_files){
                                                                                                    if($process_requirement_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                                                        if($process_progress_files->process_progress_file_persontype == 1){ ?>
                                                                                                            <option style="width: 250px" value="<?= Yii::$app->homeUrl ?>pfc/process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                                                <?= $process_progress_files->process_progress_file_name.
                                                                                                                ' / '.$process_progress_files->process_progress_file_date ?>
                                                                                                            </option>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-12 col-sm-12">
                                                                                    <label>นักศึกษา</label>
                                                                                    <div class="col-md-12">
                                                                                        <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                                                            <option selected="selected">เลือกไฟล์...</option>
                                                                                            <?php $process_requirement_con = ProcessRequirementConnect::find()->where("process_requirement_id like :b", [":b" => $process_requirements->process_requirement_id])->all();
                                                                                            $process_progress_file = ProcessProgressFile::find()->all();
                                                                                            foreach ($process_requirement_con as $process_requirement_cons){
                                                                                                foreach ($process_progress_file as $process_progress_files){
                                                                                                    if($process_requirement_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                                                        if($process_progress_files->process_progress_file_persontype == 2){ ?>
                                                                                                            <option style="width: 250px" value="<?= Yii::$app->homeUrl ?>pfc/process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                                                <?= $process_progress_files->process_progress_file_name.
                                                                                                                ' / '.$process_progress_files->process_progress_file_date ?>
                                                                                                            </option>
                                                                                                        <?php } ?>
                                                                                                    <?php } ?>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <button type="button"
                                                                                        class="btn btn-default"
                                                                                        data-toggle="modal"
                                                                                        data-target="#bs-example-modal-lg-upload-<?= $process_requirements->process_requirement_id ?>"
                                                                                        style="margin-top: 30px">
                                                                                    <i class="fa fa-cloud-upload"></i>
                                                                                    Upload
                                                                                </button>
                                                                            </td>

                                                                            <td style="text-align:center;">
                                                                                <?php if($process_requirements->process_requirement_status == 1){ ?>
                                                                                    <img src="<?= Yii::$app->homeUrl ?>web_pfc/images/pfc_pass.png" alt width="70" style="margin-top: 30px">
                                                                                <?php }else{ ?>
                                                                                    <img src="<?= Yii::$app->homeUrl ?>web_pfc/images/pfc_wait.png" alt width="70">
                                                                                    <button type="submit" class="btn btn-warning"
                                                                                            style="margin-left: 10px;
                                                                                            margin-top: 10px;
                                                                                            font-size: 17px">ดำเนินการตรวจสอบ</button>
                                                                                <?php } ?>
                                                                            </td>

                                                                        </tr>
                                                                        </tbody>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </table>
                                                            <br>
                                                            <div>
                                                                <button type="button"
                                                                        class="btn btn-default btn-xs"
                                                                        data-toggle="modal"
                                                                        data-target="#bs-example-modal-lg-edit-<?= $process_progressn->process_progress_id ?>">
                                                                    <i class="fa fa-file-text-o"></i>
                                                                    แก้ไขรายละเอียดของกำหนดการ
                                                                </button>

                                                                <button type="button"
                                                                        class="btn btn-default btn-xs"
                                                                        data-toggle="modal"
                                                                        data-target="#bs-example-modal-lg-<?= $process_progressn->process_progress_id ?>">
                                                                    <i class="fa fa-times white"></i>
                                                                    ลบกำหนดการ
                                                                </button>

                                                            </div>

                                                        <?php } elseif (isset($process_requirement)) { ?>

                                                            <!-- ========================================================= Requirement ================================================================= -->

                                                            <!-- ========================================================= Progress ================================================================= -->
                                                            <div class="col-md-3">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-md-1 col-sm-1">
                                                                            <label>อาจารย์</label>
                                                                            <div class="col-md-2">
                                                                                <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                                                    <option selected="selected" value="--" >เลือกไฟล์...</option>
                                                                                    <?php $process_progress_con = ProcessProgressConnect::find()->where("process_progress_id like :b", [":b" => $process_progressn->process_progress_id])->all();
                                                                                    $process_progress_file = ProcessProgressFile::find()->all();
                                                                                    foreach ($process_progress_con as $process_progress_cons){
                                                                                        foreach ($process_progress_file as $process_progress_files){
                                                                                            if($process_progress_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                                                if($process_progress_files->process_progress_file_persontype == 1){?>
                                                                                                    <option style="width: 250px" value="<?= Yii::$app->homeUrl ?>pfc/process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                                        <?= $process_progress_files->process_progress_file_name.
                                                                                                        ' / '.$process_progress_files->process_progress_file_date ?>
                                                                                                    </option>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-md-1 col-sm-1">
                                                                            <label>นักศึกษา</label>
                                                                            <div class="col-md-1">
                                                                                <select name="page" onChange="goTo(this.options[this.selectedIndex].value)" class="listBox" style="width: 250px">
                                                                                    <option selected="selected" value="--" >เลือกไฟล์...</option>
                                                                                    <?php $process_progress_con = ProcessProgressConnect::find()->where("process_progress_id like :b", [":b" => $process_progressn->process_progress_id])->all();
                                                                                    $process_progress_file = ProcessProgressFile::find()->all();
                                                                                    foreach ($process_progress_con as $process_progress_cons){
                                                                                        foreach ($process_progress_file as $process_progress_files){
                                                                                            if($process_progress_cons->process_progress_file_id == $process_progress_files->process_progress_file_id){
                                                                                                if($process_progress_files->process_progress_file_persontype == 2){?>
                                                                                                    <option value="<?= Yii::$app->homeUrl ?>pfc/process/process_download?fileupload=<?= $process_progress_files->process_progress_file_progress ?>&process_id=<?= $process_progressn->process_id ?>">
                                                                                                        <?= $process_progress_files->process_progress_file_name.
                                                                                                        ' / '.$process_progress_files->process_progress_file_date ?>
                                                                                                    </option>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-3">
                                                                <?php if($process_progressn->process_progress_status_id == 1){ ?>
                                                                    <img src="<?= Yii::$app->homeUrl ?>web_pfc/images/pfc_pass.png" alt width="150" style="margin-left: 400px">
                                                                <?php }else{ ?>
                                                                    <img src="<?= Yii::$app->homeUrl ?>web_pfc/images/pfc_wait.png" alt width="150" style="margin-left: 400px">
                                                                    <button type="submit" class="btn btn-warning"
                                                                            style="margin-left: 330px;
                                                                            width: 300px; height: 50px;
                                                                            font-size: 17px">ดำเนินการตรวจสอบ</button>
                                                                <?php } ?>
                                                            </div>

                                                            <div class="col-md-12" style="margin-top: 20px">
                                                                <button type="button" class="btn btn-default btn-xs"
                                                                        data-toggle="modal"
                                                                        data-target="#bs-example-modal-lg-edit-<?= $process_progressn->process_progress_id ?>">
                                                                    <i class="fa fa-file-text-o"></i>
                                                                    แก้ไขระยะเวลาของกำหนดการ
                                                                </button>

                                                                <button type="button" class="btn btn-default btn-xs"
                                                                        data-toggle="modal"
                                                                        data-target="#bs-example-modal-lg-upload-<?= $process_progressn->process_progress_id ?>">
                                                                    <i class="fa fa-cloud-upload"></i> Upload
                                                                </button>

                                                            </div>

                                                        <?php } ?>

                                                        <!-- ========================================================= Progress ================================================================= -->

                                                    </td>
                                                </tr>
                                            <?php $score_full_sum = $score_full_sum + $process_progressn->process_progress_score_full;
                                        $score_full = $score_full + $process_progressn->process_progress_score;
                                    }
                                }
                            }
                        }

                    } ?>
    <!-- ------------------------------------------------------------------------------------------------------------------ -->

                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td style="text-align:right;">ผลรวมคะแนน</td>
                            <td style="text-align:center;"><?= $score_full ?>/<?= $score_full_sum ?></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="margin-top20 pagination text-center"><!-- PAGINATION --></div>
            </ul>

    <!-- ------------------------------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------------------------------------ -->

            <!-- ////////////////////////////////////////////////////// Upload progress /////////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){ ?>
                <div class="modal fade" id="bs-example-modal-lg-upload-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">Upload</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form method=post action="<?= Yii::$app->homeUrl ?>pfc/process/process_upload" enctype="multipart/form-data">
                                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                    <input type="hidden" name="type" value="<?= $type_k ?>" />
                                    <input type="hidden" name="process_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />
                                    <input type="hidden" name="upload_check" value="1" />

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>เฉพาะไฟล์ docx , PDF , Zip เท่านั้น</label>
                                                <div class="fancy-file-upload fancy-file-default">
                                                    <i class="fa fa-upload"></i>
                                                    <input type="file" class="form-control" name="upload" onchange="jQuery(this).next('input').val(this.value);" />
                                                    <input type="text" class="form-control" placeholder="no file selected" readonly="" />
                                                    <span class="button">Choose File</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" href="" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// Upload progress /////////////////////////////////////////////////////// -->


            <!-- ////////////////////////////////////////////////////// Upload Requirement /////////////////////////////////////////////////////// -->
            <?php foreach ($process_requirement as $process_requirementn1){ ?>
                <div class="modal fade" id="bs-example-modal-lg-upload-<?= $process_requirementn1->process_requirement_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- header modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myLargeModalLabel">Upload</h4>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <form method=post action="<?= Yii::$app->homeUrl ?>pfc/process/process_upload" enctype="multipart/form-data">
                                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                    <input type="hidden" name="type" value="<?= $type_k ?>" />
                                    <input type="hidden" name="process_requirement_id" value="<?= $process_requirementn1->process_requirement_id ?>" />
                                    <input type="hidden" name="upload_check" value="2" />

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12">
                                                <label>เฉพาะไฟล์ docx , PDF , Zip เท่านั้น</label>
                                                <div class="fancy-file-upload fancy-file-default">
                                                    <i class="fa fa-upload"></i>
                                                    <input type="file" class="form-control" name="upload" onchange="jQuery(this).next('input').val(this.value);" />
                                                    <input type="text" class="form-control" placeholder="no file selected" readonly="" />
                                                    <span class="button">Choose File</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"
                                         style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" href="" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- ////////////////////////////////////////////////////// Upload Requirement /////////////////////////////////////////////////////// -->



            <!-- /////////////////////////////////////////////////// Edit process //////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){
                foreach ($process_add_con as $process_add_cons3) {
                    if ($process_add_cons3->process_progress_id == $process_progressn3->process_progress_id) {
                        foreach ($process_add as $process_adds3) {
                            if ($process_adds3->process_add_id == $process_add_cons3->process_add_id) { ?>
                                <div class="modal fade" id="bs-example-modal-lg-edit-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- header modal -->
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myLargeModalLabel">แก้ไขรายละเอียดกำหนดการ</h4>
                                            </div>
                                            <!-- body modal -->
                                            <div class="modal-body">
                                                <form action="<?= Yii::$app->homeUrl ?>pfc/process/process_edit" method="post" enctype="multipart/form-data">
                                                    <fieldset>
                                                        <!-- required [php action request] -->
                                                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                                                        <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                                        <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                                        <input type="hidden" name="type" value="<?= $type_k ?>" />
                                                        <input type="hidden" name="process_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />
                                                        <input type="hidden" name="process_add_id" value="<?= $process_add_cons3->process_add_id ?>" />

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>ลำดับกำหนดการ</label>
                                                                    <input type="text" name="edit_no_form" id="edit_no_form" value="<?= $process_progressn3->process_progress_no ?>" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>หัวข้อกำหนดการ</label>
                                                                    <input type="text" name="edit_topic_form" id="edit_topic_form" value="<?= $process_adds3->process_add_topic ?>" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12">
                                                                    <label>รายละเอียดของกำหนดการ</label>
                                                                    <textarea name="edit_detail_form" id="edit_detail_form" rows="4" class="form-control" readonly><?= $process_adds3->process_add_detail ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <label>วันที่เริ่มต้น</label>
                                                                    <input type="text" name="edit_date_start_form" id="edit_date_start_form" value="<?= $process_adds3->process_add_date_start ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <label>วันสุดท้าย</label>
                                                                    <input type="text" name="edit_date_end_form" id="edit_date_end_form" value="<?= $process_adds3->process_add_date_end ?>" class="form-control datepicker" data-format="yyyy/mm/dd" data-lang="en" data-RTL="false" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>

                                                    <!-- ------ foot -------- -->
                                                    <div class="row"
                                                         style="margin-top: 20px;">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>pfc/process/process_edit" class="btn btn-green">บันทึก</button>
                                                        </div>
                                                    </div>

                                                    <!-- ------ foot -------- -->

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
            } ?>
            <!-- /////////////////////////////////////////////////// Edit process //////////////////////////////////////////////////// -->


            <!-- ////////////////////////////////////////////////////// Delete /////////////////////////////////////////////////////// -->
            <?php foreach ($process_progress as $process_progressn3){
                foreach ($process_add_con as $process_add_cons3) {
                    if ($process_add_cons3->process_progress_id == $process_progressn3->process_progress_id) {
                        foreach ($process_add as $process_adds3) {
                            if ($process_adds3->process_add_id == $process_add_cons3->process_add_id) { ?>
                                <div class="modal fade" id="bs-example-modal-lg-delete-<?= $process_progressn3->process_progress_id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- header modal -->
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myLargeModalLabel">ยืนยันการลบกำหนดการ</h4>
                                            </div>
                                            <!-- body modal -->
                                            <div class="modal-body">
                                                <form action="<?= Yii::$app->homeUrl ?>pfc/process/process_delete" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="process_id" value="<?= $process_id_k ?>" />
                                                    <input type="hidden" name="project_id" value="<?= $project_id_k ?>" />
                                                    <input type="hidden" name="type" value="<?= $type_k ?>" />
                                                    <input type="hidden" name="delete_progress_id" value="<?= $process_progressn3->process_progress_id ?>" />
                                                    <input type="hidden" name="delete_add_id" value="<?= $process_add_cons3->process_add_id ?>" />
                                                    <input type="hidden" name="delete_add_con_id" value="<?= $process_add_cons3->process_add_connect_id ?>" />

                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="col-md-12 col-sm-12">
                                                                <label>ยืนยันการลบกำหนดการ </label>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row"
                                                         style="margin-top: 20px;">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                                            <button type="submit" href="<?= Yii::$app->homeUrl ?>pfc/process/process_delete" class="btn btn-danger">ยืนยัน</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                }
            } ?>
            <!-- ////////////////////////////////////////////////////// Delete /////////////////////////////////////////////////////// -->



            <!-- /////////////////////////////////////////////////// js dropdown //////////////////////////////////////////////////// -->
            <script>
                function goTo (page) {
                    if (page != "" ) {
                        if (page == "--" ) {
                            resetMenu();
                        } else {
                            document.location.href = page;
                        }
                    }
                    return false;
                }
            </script>
            <!-- /////////////////////////////////////////////////// js dropdown //////////////////////////////////////////////////// -->

