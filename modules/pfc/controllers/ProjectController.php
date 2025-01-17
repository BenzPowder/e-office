<?php
/**
 * Created by PhpStorm.
 * User: pessm
 * Date: 7/19/2017
 * Time: 3:29 PM
 */

namespace app\modules\pfc\controllers;

use app\modules\pfc\models\Subjects;
use Yii;
use app\modules\pfc\models\Project;
use app\modules\pfc\models\ProjectConnect;
use app\modules\pfc\models\Teacher;
use app\modules\pfc\models\Student;
use app\modules\pfc\models\Process;
use app\modules\pfc\models\StudentDept;
use app\modules\pfc\models\ProcessProgress;
use app\modules\pfc\models\ProcessProgressConnect;
use app\modules\pfc\models\ProcessGantt;
use app\modules\pfc\models\ProcessGanttType;
use app\modules\pfc\models\ProcessAdd;
use app\modules\pfc\models\ProcessAddConnect;
use app\modules\pfc\models\ViewProject;
use app\modules\pfc\models\ViewPisOpenSubject;
use app\modules\pfc\models\ViewStudentFull;
use app\modules\pfc\models\ViewUser;
use app\modules\pfc\models\ViewStudentProject;
use app\modules\pfc\models\ViewAdvise;


use yii\web\Controller;

class ProjectController extends Controller
{

    public  function  actionHome(){
        return $this->render('home', [

        ]);
    }

    public function actionProject_teacher()
    {
        $session = Yii::$app->session;
        if($session->get('pfc_id') != $session->get('pfc_id')){
            $this->redirect(['project/home']);
        }else {
            $user = ViewUser::find()->where("username like :b", [":b" => $session->get('pfc_id')])->all();
            $teacher = ViewAdvise::find()->where("adviser_id like :b ORDER BY project_id", [":b" => $user[0]->id])->all();
            $project = ViewProject::find()->all();

            return $this->render('project_list', [
                'project' => $project,
                'teacher' => $teacher,
                'subject_id' => 0,
                'dept_id' => 0,
                'dept_name' => 'สาขา',
                'subject_name' => 'รายวิชา',
                'type_degree' => $_REQUEST['type_degree'],
            ]);
        }
    }

    public function actionProject_all_subject($teacher_id,$dept_id,$type_degree)
    {
        $session = Yii::$app->session;
        if($session->get('pfc_id') != $teacher_id){
            $this->redirect(['project/home']);
        }else {
            $teacher = Teacher::find()->where("teacher_id like :b", [":b" => $teacher_id])->all();
            $dept = StudentDept::find()->where("student_dept_id like :b", [":b" => $dept_id])->all();
            $project_con = ProjectConnect::find()->where("teacher_id like :b", [":b" => $teacher_id])->all();
            $project = Project::find()->all();

            if ($dept_id == 0) {
                $dept_name = 'สาขา';
            } else {
                $dept_name = $dept[0]->student_dept_name;
            }
            return $this->render('project_list', [
                'teacher' => $teacher,
                'project_con' => $project_con,
                'project' => $project,
                'dept_id' => $dept_id,
                'subject_id' => 0,
                'dept_name' => $dept_name,
                'subject_name' => 'รายวิชา',
                'type_degree' => $type_degree,
            ]);
        }
    }

    public function actionProject_all_dept($teacher_id,$subject_id,$type_degree)
    {
        $session = Yii::$app->session;
        if($session->get('pfc_id') != $teacher_id){
            $this->redirect(['project/home']);
        }else {
            $project_con = null;
            $project = null;
            $teacher = Teacher::find()->where("teacher_id like :b", [":b" => $teacher_id])->all();
            $student = Student::find()->all();
            $subject = Subjects::find()->where("subjects_id like :b", [":b" => $subject_id])->all();

            if ($subject_id == 0) {
                $subject_name = 'รายวิชา';
                $project_con = ProjectConnect::find()->where(['teacher_id' => $teacher_id])->all();
                $project = Project::find()->all();
            } else {
                $subject_name = $subject[0]->subjects_name_thai;
                $project_con = ProjectConnect::find()->where(['subjects_id' => $subject_id, 'teacher_id' => $teacher_id])->all();
                $project = Project::find()->all();
            }

            return $this->render('project_list', [
                'teacher' => $teacher,
                'project' => $project,
                'project_con' => $project_con,
                'student' => $student,
                'dept_id' => 0,
                'dept_name' => 'สาขา',
                'subject_name' => $subject_name,
                'subject_id' => $subject_id,
                'type_degree' => $type_degree,
            ]);
        }
    }

    public function actionProject_dept_subject($teacher_id,$subject_id,$dept_id,$type_degree)
    {
        $session = Yii::$app->session;
        if($session->get('pfc_id') != $teacher_id){
            $this->redirect(['project/home']);
        }else {
            $project_con_array[] = null;
            $subject_name = null;
            $dept_name = null;
            $project = null;
            $dept_id_control = $dept_id;
            $dept = StudentDept::find()->where("student_dept_id like :b", [":b" => $dept_id])->all();
            $teacher = Teacher::find()->where("teacher_id like :b", [":b" => $teacher_id])->all();
            $subject = Subjects::find()->where("subjects_id like :b", [":b" => $subject_id])->all();
            $student = Student::find()->where("student_dept_id like :b", [":b" => $dept_id])->all();

            if ($subject_id != 0) {
                $subject_name = $subject[0]->subjects_name_thai;
                $project_con = ProjectConnect::find()->where(['subjects_id' => $subject_id, 'teacher_id' => $teacher_id])->all();
                $project = Project::find()->all();
//            "subjects_id like :a" and "teacher_id like :b" ,[":a"=>$subject_id ,":b"=>$teacher_id
            } else {
                $subject_name = 'รายวิชา';
                $project_con = ProjectConnect::find()->where("teacher_id like :b", [":b" => $teacher_id])->all();
                $project = Project::find()->all();
            }

            if ($dept_id == 0) {
                $dept_name = 'สาขา';
                $dept_id_control = 0;
            } else {
                $dept_name = $dept[0]->student_dept_name;
                $n = 0;
                foreach ($student as $students):
                    $project_con_array[$n] = ProjectConnect::find()->where("student_id like :a", [":a" => $students->student_id])->all();
                    $n++;
                endforeach;
            }
            return $this->render('project_list', [
                'teacher' => $teacher,
                'project' => $project,
                'project_con' => $project_con,
                'dept_id' => $dept_id_control,
                'dept_name' => $dept_name,
                'subject_name' => $subject_name,
                'subject_id' => $subject_id,
                'student' => $student,
                'project_con_array' => $project_con_array,
                'type_degree' => $type_degree,
            ]);
        }
    }

    public function actionProject_student()
    {
        $session = Yii::$app->session;
        if($session->get('pfc_id') != $session->get('pfc_id')){
            $this->redirect(['project/home']);
        }else {
            $user = ViewUser::find()->where("username like :b", [":b" => $session->get('pfc_id')])->all();
            $student = ViewStudentProject::find()->where("student_id like :b", [":b" => $user[0]->id])->all();
            $project = ViewProject::find()->where("id like :b", [":b" => $student[0]->project_id])->all();
            $process = Process::find()->where("project_id like :b", [":b" => $project[0]->id])->all();
            $process_gantt_type = ProcessGanttType::find()->where("subjects_id like :b", [":b" => '3224982561'])->all();

            if ($process != null) {
                $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no", [":b" => $process[0]->process_id])->all();
                $process_gantt = ProcessGantt::find()->all();
                $process_add = ProcessAdd::find()->all();
                $process_add_con = ProcessAddConnect::find()->all();
                $check_progress = 0;
                $process_progree_count = 0;
                $check_progress_sum = 0;
                $check_score_sum = 0;
                $check_score_full = 0;

                foreach ($process_progress as $process_progressn) {
                    $process_progree_count++;
                    $check_score_sum = $check_score_sum + $process_progressn->process_progress_score;
                    $check_score_full = $check_score_full + $process_progressn->process_progress_score_full;
                    if ($process_progressn->process_progress_status_id == 1) {
                        $check_progress++;
                    }
                }

                if($process_progress != null) {
                    $check_progress_sum = $check_progress / $process_progree_count * 100;
                }


                if ($project != null) {
                    return $this->render('project_student', [
                        'process' => $process,
                        'project' => $project,
                        'student' => $student,
                        'process_progress' => $process_progress,
                        'process_gantt' => $process_gantt,
                        'process_add' => $process_add,
                        'process_add_con' => $process_add_con,
                        'type_degree' => $user[0]->major_id,
                        'check_progress_sum' => $check_progress_sum,
                        'process_gantt_type_code' => $process_gantt_type[0]->process_gantt_tpye_code,
                        'check_score_sum' => $check_score_sum,
                        'check_score_full' => $check_score_full,
                    ]);
                }
            }else{
                $processn = Process::find()->all();
                $project_id_add = $student[0]->project_id;

                $process_count = count($processn)+1;
                $process_add = New Process();
                $process_add->process_id = $project_id_add.'_process_'.$process_count;
                $process_add->project_id = $project_id_add;
                $process_add->process_gantt_tpye_code = $process_gantt_type[0]->process_gantt_tpye_code;
                $process_add->save();

                return $this->redirect(['project_student',
                    'project_id' => $student[0]->project_id,
                    'project_name' => $project[0]->name_th,
                    'type_degree' => $user[0]->major_id,
                    'process_gantt_type_code' => $process_gantt_type[0]->process_gantt_tpye_code,
                    'id'=>$session->get('pfc_id')
                ]);
            }
        }
    }

    public function actionProject_detail($project_id,$id,$type_degree)
    {
        $session = Yii::$app->session;
        if($session->get('pfc_id') != $id){
            $this->redirect(['project/home']);
        }else {
            $project = ViewProject::find()->where("id like :b", [":b" => $project_id])->all();
            $student = ViewStudentProject::find()->where("project_id like :b", [":b" => $project[0]->id])->all();
            $process = Process::find()->where("project_id like :b", [":b" => $project[0]->id])->all();
            $session->set('pfc_type_degree', $type_degree);
            $process_gantt_type = ProcessGanttType::find()->where("subjects_id like :b", [":b" => '3224982561'])->all();

            if($process != null) {
                $process_progress = ProcessProgress::find()->where("process_id like :b ORDER BY process_progress_no", [":b" => $process[0]->process_id])->all();
                $process_gantt = ProcessGantt::find()->all();
                $process_add = ProcessAdd::find()->all();
                $process_add_con = ProcessAddConnect::find()->all();
                $check_progress = 0;
                $process_progree_count = 0;
                $check_progress_sum = 0;
                $check_score_sum = 0;
                $check_score_full = 0;

                foreach ($process_progress as $process_progressn) {
                    $process_progree_count++;
                    $check_score_sum = $check_score_sum + $process_progressn->process_progress_score;
                    $check_score_full = $check_score_full + $process_progressn->process_progress_score_full;
                    if($process_progressn->process_progress_status_id == 1){
                        $check_progress++;
                    }
                }

                if($type_degree == 1) {
                    if($process_progress != null) {
                        $check_progress_sum = $check_progress / $process_progree_count * 100;
                    }
                }

                return $this->render('project_detail', [
                    'process' => $process,
                    'project' => $project,
                    'student' => $student,
                    'process_gantt' => $process_gantt,
                    'process_progress' => $process_progress,
                    'process_add' => $process_add,
                    'process_add_con' => $process_add_con,
                    'type_degree' => $type_degree,
                    'check_progress_sum' => $check_progress_sum,
                    'process_gantt_type_code' => $process_gantt_type[0]->process_gantt_tpye_code,
                    'check_score_sum' => $check_score_sum,
                    'check_score_full' => $check_score_full,
                ]);
            }else{
                $processn = Process::find()->all();

                $process_count = count($processn)+1;
                $process_add = New Process();
                $process_add->process_id = $project_id.'_process_'.$process_count;
                $process_add->project_id = $project_id;
                $process_add->process_gantt_tpye_code = $process_gantt_type[0]->process_gantt_tpye_code;
                $process_add->save();

                return $this->redirect(['project_detail',
                    'project_id' => $project_id,
                    'type_degree' => $type_degree,
                    'id'=>$session->get('pfc_id'),
                    'process_gantt_type_code' => $process_gantt_type[0]->process_gantt_tpye_code,

                ]);
            }
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    public  function  actionPersonnel_type(){
        return $this->render('personnel_type', [

        ]);
    }

}

