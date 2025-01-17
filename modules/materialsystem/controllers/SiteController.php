<?php

namespace app\modules\materialsystem\controllers;


use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Controller;
use app\modules\materialsystem\models\MatsysBillDetail;
use app\modules\materialsystem\models\MatsysCompany;
use app\modules\materialsystem\models\MatsysDetail;
use app\modules\materialsystem\models\MatsysLocation;
use app\modules\materialsystem\models\MatsysOrderDetail;
use app\modules\materialsystem\models\MatsysOrderHasMaterial;
use app\modules\materialsystem\models\MatsysOrderReturn;
use app\modules\materialsystem\models\Search;
use app\modules\materialsystem\models\MatsysMaterial;
use app\modules\materialsystem\models\MatsysMaterialType;
use app\modules\materialsystem\models\MatsysOrder;
//use yii\web\UploadedFile;
use yii\db\Query;


class SiteController extends Controller
{
    public function init()
    {
        Yii::setAlias('@mat_assets', '@web/../modules/material_management/assets');
        parent::init(); // TODO: Change the autogenerated stub
    }

//    public function actionIndex()
//    {
//        $model = MatsysMaterial::find()->all();
//        $mat_type = MatsysMaterialType::find()->all();
//        $mat_stock = MatsysMaterialHasStock::find()->all();
//        $this->layout = 'main_material';
//        $this->view->params['statuspage'] = 'index';
//        return $this->render('index', array('model' => $model, 'mat_type' => $mat_type, 'mat_stock' => $mat_stock));
//    }

    public function actionIndex()
    {
        $mat_type = MatsysMaterialType::find()->all();
        $bill_detail = MatsysBillDetail::find()->all();
        $mat_order = MatsysOrder::find()->all();
        $mat_detail = MatsysDetail::find()->all();
        $mat_order_detail = MatsysOrderDetail::find()->all();


        $query = MatsysMaterial::find();
        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 8] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'allmaterial';
        return $this->render('allmaterial', array('model' => $models,'pages'=>$pages, 'mat_type' => $mat_type, 'bill_detail' => $bill_detail, 'mat_order' => $mat_order, 'mat_detail' => $mat_detail, 'mat_order_detail' => $mat_order_detail ));
    }

    public function actionGetpermit()
    {
        echo Json::encode(
            \Yii::$app->authManager->getPermit(\Yii::$app->user->identity->id, \Yii::$app->controller->module->id)
        );
    }

    public function actionGetpermitreturn()
    {
        echo \Yii::$app->authManager->getPermitReturn("/module5/menu/menu1","module5");
    }

    public function actionWiden()
    {
        $model = MatsysMaterial::find()->all();
        $mat_type = MatsysMaterialType::find()->all();
        $bill_detail = MatsysBillDetail::find()->all();
        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'widen';
        return $this->render('widen', array('model' => $model, 'mat_type' => $mat_type, 'bill_detail' => $bill_detail));
    }

    public function actionOrder_status()
    {
        $query = MatsysOrder::find()->where(['person_id' => \app\modules\materialsystem\models\Person::findOne(Yii::$app->user->identity->getId())->id])->andWhere(['order_status_confirm' => 'confirm'])->andWhere(['order_status' => '0']);
        $model_order = MatsysOrderHasMaterial::find()->all();

        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 10] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'order_status';
        return $this->render('order_status' ,['model' => $models, 'pages' => $pages, 'model_order' => $model_order]);
    }

    public function actionHistory()
    {
        $query = MatsysOrder::find()->where(['person_id' => \app\modules\materialsystem\models\Person::findOne(Yii::$app->user->identity->getId())->id]);
        $model_order = MatsysOrderHasMaterial::find()->all();

        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 10] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'history';
        return $this->render('history' ,['model' => $models, 'pages' => $pages , 'model_order' => $model_order]);
    }

    public function actionAll_material()
    {
        $mat_type = MatsysMaterialType::find()->all();
        $bill_detail = MatsysBillDetail::find()->all();
        $mat_order = MatsysOrder::find()->all();
        $mat_detail = MatsysDetail::find()->all();
        $mat_order_detail = MatsysOrderDetail::find()->all();


        $query = MatsysMaterial::find();
        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 8] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'allmaterial';
        return $this->render('allmaterial', array('model' => $models,'pages'=>$pages, 'mat_type' => $mat_type, 'bill_detail' => $bill_detail, 'mat_order' => $mat_order, 'mat_detail' => $mat_detail, 'mat_order_detail' => $mat_order_detail ));
    }

    public function actionType()
    {
//        $searchModel = new Search();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = MatsysMaterialType::find();
        $mat = MatsysMaterial::find()->all();

        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 10] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'type';
        return $this->render('type', ['mat_type' => $models, 'pages' => $pages, 'mat' => $mat,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCompany()
    {
        $query = MatsysCompany::find();
        $mat = MatsysBillDetail::find()->all();

        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 10] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'company';
        return $this->render('company', ['mat_company' => $models, 'pages' => $pages, 'mat' => $mat]);
    }

    public function actionLocation()
    {
        $query = MatsysLocation::find();
        $mat = MatsysMaterial::find()->all();

        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 10] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'location';
        return $this->render('location', ['mat_location' => $models, 'pages' => $pages, 'mat' => $mat]);
    }
    /*public function actionDeletetype($idtype)
    {
        $mat_type = MatsysMaterialType::find()->where('material_type_id = $idtype')->all();
        foreach ($mat_type as $type) {
            $type->delete();
        }
        return $this->render('type');
    }*/

    /*public function actionDeletetype($idtype)
    {
        $this->findModel($idtype)->delete();
        return $this->render('type');
    }*/

    //================= ================ ================= ================//

    public function actionReturn_order()
    {

        $query = MatsysOrder::find()->where(['order_status' => '1' , 'person_id' => \app\modules\materialsystem\models\Person::findOne(Yii::$app->user->identity->getId())->id]);
        $order_mat = MatsysOrderReturn::find()->all();
//        print_r($order);
//        return Json::encode($order);
        $countQuery = clone $query;         //คำสั่งสร้าง Page แบ่งหน้า
        $pages = new Pagination( ['totalCount' => $countQuery->count(), 'pageSize' => 10] );
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->all();

        $this->layout = 'main_material';
        $this->view->params['statuspage'] = 'return';
        return $this->render('return_order', ['order' => $models, 'pages' => $pages , 'order_mat' => $order_mat]);
    }

    public function actionReturnsubmit()
    {
        $order_id_list = [];
        $mat_id_list = [];
        $return_amount_list = [];
        $stock_id_list = [];
        foreach (Yii::$app->request->post() as $key => $post) {
            if (strpos($key, 'order_id') === 0) {
                array_push($order_id_list, $post);
            } else if (strpos($key, 'order_return_amount') === 0) {
                array_push($return_amount_list, $post);
            } else if (strpos($key, 'material_id') === 0) {
                array_push($mat_id_list, $post);
            } else if (strpos($key,'stock_id') === 0) {
                array_push($stock_id_list, $post);
            }
        }
//        print_r($order_id_list);
//        echo "<br>";
//        $order_id_check = $_POST['order_id_check'];
//        print_r($order_id_check);
//        exit();
//
/////////////////////////////////////////////////////////////////////////////////

//        $order_id_check = $_POST['order_id_check'];
//        $mat_id_check = $_POST['mat_id_check'];
//        $stock_id_check = $_POST['stock_id_check'];
//        $mat_amount = $_POST['mat_amount'];

//        echo($order_id_check[$key]); echo "<br>";echo "<br>";echo "<br>";
//        echo($mat_id_check[$key]); echo "<br>";echo "<br>";echo "<br>";
//        echo($stock_id_check[$key]); echo "<br>";echo "<br>";echo "<br>";

//        print_r($order_id_check); echo "<br>";echo "<br>";echo "<br>";
//        print_r($mat_id_check); echo "<br>";echo "<br>";echo "<br>";
//        print_r($stock_id_check); echo "<br>";echo "<br>";echo "<br>";
//        print_r($mat_amount); echo "<br>";echo "<br>";echo "<br>";
//        exit();


        foreach ($_POST['order_id_check'] as $key => $value)
        {
            date_default_timezone_set("Asia/Bangkok");
          $order_return = new MatsysOrderReturn();
          $order_return->order_id = $_POST['order_id_check'][$key];
          $order_return->material_id = $_POST['mat_id_check'][$key];
          $order_return->order_return_amount = $_POST['mat_amount'][$key];
//          $order_return->order_return_amount = $return_amount_list[$key];
//          $order_return->material->billMasters[0]->bill_master_id = $_POST['stock_id_check'][$key];
          $order_return->order_return_date = date('Y-m-d H:i:s');
            if ($order_return->order_return_amount != 0) {
                $order_return->save();
            }
        }

        foreach ($_POST['order_id_check'] as $value1){
            $order = MatsysOrder::findOne($value1);
            $order->order_status_return = '2';
            $order->save();
        }
        return $this->redirect('@web/materialsystem/site/return_order');

/////////////////////////////////////////////////////////////////////////////////

        /*for ($i = 0; $i < count($order_id_list); $i++) {
            $order_return = new MatsysOrderReturn();
            $order_return->order_id = $order_id_list[$i];
            $order_return->material_id = $mat_id_list[$i];
            $order_return->order_return_amount = $return_amount_list[$i];
            $order_return->stock_id = $stock_id_list[$i];
            $order_return->order_return_date = date("Y-m-d");
            if ($order_return->order_return_amount != 0) {
                $order_return->save();
            }

            return $this->redirect('@web/materialsystem/site/return_order');
        }*/
    }
//        return Json::encode([$order_id_list, $mat_id_list, $return_amount_list]);


//        if (is_array($_POST['order_id']) || is_object($_POST['order_id'])) {
//            foreach ($_POST['order_id'] as $item) {
//                $model = MatsysOrderReturn::findOne($item);
//                $model->order_id = $_POST['order_id'];
//                $model->order_return_amount = $_POST['order_return_amount'];
//                $model->order_return_date = date("Y-m-d");
//
//                echo $model->order_id;
//                echo $_POST['order_return_amount'];
//                exit();
//            }
//        }

    public function actionDrop_file()
    {
        $this->view->params['statuspage'] = 'widen';
        $this->layout = 'main_material';
        $session = Yii::$app->session;
        if (isset($session['file_count'])) {
            $file_count = $session['file_count'];
        } else {
            $session->set('file_count', 0);
            $file_count = $session['file_count'];
        }


        $fileName = 'file';
        $uploadPath = '../modules/material_management/uploads';
        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);
            if ($file->saveAs($uploadPath . '/' . $file_count . '.' . $file->extension)) {
                echo \yii\helpers\Json::encode($file);
                $file_count++;
            }
            $session->set('file_count', $file_count);
            echo "<script>console.log('" . $file_count . "')</script>";
        } else {
            echo "<script>console.log('file count = " . $file_count . "')</script>";
            return $this->render('drop_file');
        }

        return false;
    }

    public function actionViewfile()
    {
        $material_count = 1;
        $file_count = Yii::$app->session->get('file_count');
//        echo "<table border='1'>";
//        echo " <tr><th class=\"col-md-1\">ลำดับ</th><th class=\"col-md-2\">ชื่อวัสดุ</th><th class=\"col-md-1\">รูปภาพ</th><th class=\"col-md-2\">นำเข้าสู่</th><th class=\"col-md-2\">ประเภท</th><th class=\"col-md-1\">จำนวน</th><th class=\"col-md-1\">หน่วยนับ</th><th class=\"col-md-1\">ราคา/หน่วย</th><th class=\"col-md-1\">ราคารวม</th></tr>";

        for ($file_count_number = 0; $file_count_number < $file_count; $file_count_number++) {

            $file = "../modules/material_management/uploads/" . $file_count_number . ".xml";

//          Covert to UTF-8
            $message = file_get_contents($file);
            $message = iconv(mb_detect_encoding($message, mb_detect_order(), true), "UTF-8", $message);

            $xml = simplexml_load_string($message);
            $result_No = $xml->xpath('//LIST_G_PR_NO/G_PR_NO/LIST_G_DETAIL/G_DETAIL/SEQ');
            $result_name = $xml->xpath('//LIST_G_PR_NO/G_PR_NO/LIST_G_DETAIL/G_DETAIL/CF_DESCRIPTION');
            $result_amount = $xml->xpath('//LIST_G_PR_NO/G_PR_NO/LIST_G_DETAIL/G_DETAIL/CF_QTY_UMS');
            $result_priceperunit = $xml->xpath('//LIST_G_PR_NO/G_PR_NO/LIST_G_DETAIL/G_DETAIL/UNIT_PRICE');
            $result_priceallper_mat = $xml->xpath('//LIST_G_PR_NO/G_PR_NO/LIST_G_DETAIL/G_DETAIL/AMT');
            $result_detail = $xml->xpath('//LIST_G_DETAIL/G_DETAIL/REMARK');


            for ($i = 0; $i < count($result_No); $i++) {
                $result_unit = explode(' ', $result_amount[$i]);
                echo "<tr>";
                echo "<td>" . $material_count . "</td><td>"
                    . $result_name[$i] . "</td><td></td><td></td><td></td><td>"
                    . $result_unit[0] . "</td><td>"
                    . $result_unit[1] . "</td><td>"
                    . $result_priceperunit[$i] . "</td><td>"
                    . $result_priceallper_mat[$i] . "</td>";
                echo "</tr>";
                $material_count++;
            }
        }


//        while (list(, $node) = each($result_No)) {
//            echo '', $node, "<br>";
//        }
//        while (list(, $node) = each($result)) {
//            echo '', $node, "\n";
//        }
    }

    public function actionShowmodel()
    {
        $model = new Material();
        $model['material_name'] = "cakezaza";
        $model['material_type'] = 1;
        $model['location_id'] = 1;
        echo $model['material_name'];
        try {
            $model->save();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function actionDestroysession()
    {
        $session = Yii::$app->session;
        $session->remove('file_count');
        echo "cake";
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
