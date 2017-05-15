<?php

namespace app\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\Product;
use app\models\Customer;
use app\models\SalesRef;
use app\models\Orders;
use mPDF;
use kartik\mpdf\Pdf;

class SalesRefController extends \yii\web\Controller
{
  public function behaviors()
  {  
    return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'index'=>['get'],       
          'upload-sales-ref'=>['post'],  
          'update-sales-ref'=>['post'],  
          'delete-sales-ref'=>['post'],  
          'send-mail'=>['post'], 
          'sync'  =>['post'],   
        ],        
      ]
    ];
  }
  public function beforeAction($event)
  {
    $action = $event->id;    
    if (isset($this->actions[$action])) {
      $verbs = $this->actions[$action];
    } 
    elseif (isset($this->actions['*'])) {
      $verbs = $this->actions['*'];
    } 
    else {
      return $event->isValid;
    }
    $verb = Yii::$app->getRequest()->getMethod(); 
    $allowed = array_map('strtoupper', $verbs); 
    if (!in_array($verb, $allowed)) {          
      $this->setHeader(400);
     echo json_encode(array('status'=>"'method not allowed"),JSON_PRETTY_PRINT);
      exit;          
    }         
   return true;  
  }   
    
  public function actionIndex() {         
    $query= new Query;     
    $query  ->select(['sales_RefID','cust_List','sales_Name','sales_Pswd','sales_Email','sales_No','sales_RefImg','is_Active']) 
      ->from('sales_ref');                 
    $command = $query->createCommand();
    $models = $command->queryAll();    
    $this->setHeader(200);     
    echo json_encode(array_filter($models),JSON_UNESCAPED_SLASHES);    
  }   

  public function actionUploadSalesRef() {       
  $params = Yii::$app->getRequest()->getBodyParams();      
  $model = new SalesRef();
  $model->sales_RefID=$params['salesRefID'];
  $model->sales_Name=$params['salesName'];
  $model->sales_Pswd=$params['salesPswd'];
  $model->sales_Email=$params['salesMail'];
  $model->sales_No=$params['salesNo'];
  $model->cust_List=$params['custList'];
  
   if(isset($_FILES['salesRefImg']) && !empty($_FILES['salesRefImg'])) {    
   $target_path = yii::$app->basePath . "/uploads/salesref_img/" . $_FILES['salesRefImg']['name'];
   $ext = pathinfo($target_path, PATHINFO_EXTENSION);
   $ext=($ext)?$ext:'.jpg';
   $img_name = time() . "." . $ext;
   $path = yii::$app->basePath . "/uploads/salesref_img/" . $img_name; 
   $syntax = move_uploaded_file($_FILES['salesRefImg']['tmp_name'], $path);
   if($syntax)
   {
    $model->sales_RefImg= "http://api.pro-z.in/uploads/salesref_img/".$img_name;        
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success",'data'=>array('image'=>$model->sales_RefImg)),JSON_UNESCAPED_SLASHES);        
    } 
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }
    }
    }
     else{
      if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success"),JSON_PRETTY_PRINT);        
    } 
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    } 
    }
  } 
  public function actionUpdateSalesRef($salesRefID) {   
    $params = Yii::$app->getRequest()->getBodyParams();      
    $model = new SalesRef();
    $model = $this->findModel($salesRefID); 
    $model->sales_RefID=$params['salesRefID'];
    $model->sales_Name=$params['salesName'];
    $model->sales_Pswd=$params['salesPswd'];
    $model->sales_Email=$params['salesMail'];
    $model->sales_No=$params['salesNo'];
    $model->cust_List=$params['custList'];
     if(isset($_FILES['salesRefImg']) && !empty($_FILES['salesRefImg'])) {
      $target_path = yii::$app->basePath . "/uploads/salesref_img/" . $_FILES['salesRefImg']['name'];
      $ext = pathinfo($target_path, PATHINFO_EXTENSION);
      $ext=($ext)?$ext:'.jpg';
      $img_name = time() . "." . $ext;
      $path = yii::$app->basePath . "/uploads/salesref_img/" . $img_name;
      $syntax = move_uploaded_file($_FILES['salesRefImg']['tmp_name'], $path);
      if($syntax)
      {
        $model->sales_RefImg = "http://api.pro-z.in/uploads/salesref_img/".$img_name;
          
      if ($model->save()) {      
        $this->setHeader(200);
         echo json_encode(array('status'=>"success",'data'=>array('image'=>$model->sales_RefImg)),JSON_UNESCAPED_SLASHES);               
      } 
      else {
        $this->setHeader(400);
       echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
      }
      } 
    }
    else{
      $model->sales_RefImg=$model['sales_RefImg'];
      if ($model->save()) {      
        $this->setHeader(200);
        echo json_encode(array('status'=>"success",'data'=>array('image'=>$model['sales_RefImg'])),JSON_UNESCAPED_SLASHES);        
      } 
      else {
        $this->setHeader(400);
       echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
      }

    }  
  }  
  public function actionDeleteSalesRef($salesRefID) {           
    $model = new SalesRef();
    $model = $this->findModel($salesRefID);   
    $model->is_Active='1';     
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success"),JSON_PRETTY_PRINT);        
    } 
    else {
      $this->setHeader(400);
     echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }     
  } 
 
 

   public function actionSync(){
    $params = Yii::$app->getRequest()->getBodyParams(); 
    $data =$params['date'];
    $date = date('Y-m-d H:i', strtotime($data));      
    $proModel = $this->getSyncProduct($date);
    $catModel = $this->getSyncCat($date);
    $saleModel = $this->getSyncSales($date);
    $custModel = $this->getSyncCust($date);


    if($proModel!==[] || $catModel!==[] || $saleModel!==[] || $custModel!==[])  {
    $this->setHeader(200);     
    echo json_encode(array('current_date'=> date('d-m-Y H:i'),'product'=>array_filter($proModel),'category'=>array_filter($catModel),'salesRef'=>array_filter($saleModel),'customer'=>array_filter($custModel)),JSON_PRETTY_PRINT); 
  }
  else{
    $this->setHeader(400);
      echo json_encode(array('data'=>"data not found"),JSON_PRETTY_PRINT);
      exit;

  }
  }  
  protected function findModel($salesRefID) { 
    if (($model = SalesRef::findOne(['sales_RefID' => $salesRefID])) !== null) {
      return $model;
    }
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array('message'=>'Bad request')),JSON_PRETTY_PRINT);
      exit;
    }
  }
  protected function getProduct($value, $data) {  
  $model = array();     
    for($i=0; $i<$value;$i++) {            
      $model[] = Product::findOne(['product_Id' => $data[$i]->product_id]);             
    }  return $model;             
  }
  protected function getCustomer($id){
    $model = Customer::findOne(['cust_Id' => $id]); 
    return $model;
       
  }
  protected function getSalesRef($id){
    $model = SalesRef::findOne(['sales_RefID' => $id]); 
    return $model;       
  }

  protected function getSyncProduct($date){
    $proquery = new Query;    
    $proquery  ->select(['c.category_id as Category_ID','c.category_name as category_Name', 'p.product_Count', 'p.product_Desc', 'p.product_Id','p.product_Band', 'p.product_Image',  'p.product_Name', 'p.product_Price','p.is_Active']) 
    ->from('Product as p')
    ->leftJoin('category as c', 'c.category_id = p.Category_ID')
    ->where(['>=', 'p.date_time', $date]);           
    $procommand = $proquery->createCommand();
    return $models = $procommand->queryAll();
  }
  protected function getSyncCat($date){    
    $query= new Query;//refer from use yii\db\Query.It is initialize start the prg
    $query ->from('category') //table name     
    ->select("category_id as category_ID,category_name as category_Name, is_Active")
    ->where(['>=', 'date_time', $date]);           
    $command = $query->createCommand();
    return $models = $command->queryAll();
  }
  protected function getSyncSales($date){
    $salesquery = new Query;     
    $salesquery  ->select(['sales_RefID','cust_List','sales_Name','sales_Pswd','sales_Email','sales_No','sales_RefImg','is_Active']) 
      ->from('sales_ref')
    ->where(['>=', 'date_time', $date]);           
    $salescmd = $salesquery->createCommand();
    return $salesmodel = $salescmd->queryAll(); 
  }
  protected function getSyncCust($date){
    $query= new Query;       
    $query  ->select(['cust_ID','cust_Name','cust_Door_No','cust_Street_Name', 'cust_town as cust_Town','cust_country as cust_Country','cust_postcode as cust_Postcode','cust_band as cust_Band','cust_img as cust_Img','cust_no as cust_No', 'cust_AltNo', 'cust_mail as cust_Mail','is_Active']) 
    ->from('Customer')
    ->where(['>=', 'date_time', $date]);           
    $command = $query->createCommand();
    return $models = $command->queryAll();
  }
  
  private function setHeader($status) {    
    $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
    $content_type = "application/json";  
    header($status_header);
    header('Content-type: ' . $content_type);
    header('X-Powered-By: ' . "ProZ Solutions");
  }
  private function _getStatusCodeMessage($status)
  {
    $codes = Array(
      200 => 'OK.',
      201 =>'A resource was successfully created in response to a POST request. The Location header contains the URL pointing to the newly created resource.',
      204 =>  'The request was handled successfully and the response contains no content.', 
      304 =>  'The resource was not modified.',
      400 =>  'Bad request.',
      401 =>  'Authentication failed.',
      403 =>  'The authenticated user is not allowed to access the specified API endpoint.',
      404 =>  'The resource does not exist.',
      405 =>  'Method not allowed.',
      415 =>  'Unsupported media type.',
      422 =>  'Data validation failed.',
      429 =>  'Too many requests.',
      500 =>  'Internal server error.',     
    );
    return (isset($codes[$status])) ? $codes[$status] : '';
  }
}
