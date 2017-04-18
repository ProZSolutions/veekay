<?php

namespace app\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\Customer;


class CustomerListController extends \yii\web\Controller
{
    public $documentPath = __DIR__ . '/images/';
public function behaviors()
  {  
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'index'=>['get'],     
          'upload-customer-list'=>['post'], 
          'update-customer-list'=>['post'],
          'delete-customer-list'=>['post'],        
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
    echo json_encode(array('status'=>"method not allowed"),JSON_PRETTY_PRINT);
      exit;          
    }         
   return true;  
  }   
    
  public function actionIndex() {         
    $query= new Query;    
    $query  ->select(['p.cust_id as cust_ID','p.cust_name as cust_Name', 'p.cust_addr as cust_Addr','p.cust_no as custNo', 'p.cust_alt_no as cust_AltNo', 'p.cust_band as cust_Band', 'p.cust_image as cust_Img',  'p.cust_mail as cust_mail']) 
      ->from('customer as p');               
    $command = $query->createCommand();
    $models = $command->queryAll();      
    $this->setHeader(200);     
    echo json_encode(array_filter($models),JSON_UNESCAPED_SLASHES);    
  }   

  public function actionUploadCustomerList() {       
  $params = Yii::$app->getRequest()->getBodyParams();      
  $model = new Customer();     
  $model->cust_id=$params['cust_ID'];
  $model->cust_name=$params['cust_Name'];
  $model->cust_addr=$params['cust_Addr'];
  $model->cust_alt_no=$params['cust_AltNo'];
  $model->cust_band=$params['cust_Band'];
  $model->cust_mail=$params['cust_Mail'];  
  $model->cust_no=$params['custNo']; 
  if(isset($_FILES['cust_Img']) && !empty($_FILES['cust_Img'])) {
   $target_path = yii::$app->basePath . "/uploads/cus_img/" . $_FILES['cust_Img']['name'];
   $ext = pathinfo($target_path, PATHINFO_EXTENSION);
   $ext=($ext)?$ext:'.jpg';
   $img_name = time() . "." . $ext;

   $path = yii::$app->basePath . "/uploads/cus_img/" . $img_name;

   $syntax = move_uploaded_file($_FILES['cust_Img']['tmp_name'], $path);
   if($syntax)
   {
  $model->cust_image = "http://api.pro-z.in/uploads/cus_img/".$img_name;
        
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
      
 
  public function actionUpdateCustomerList($cust_ID) { 
  $params = Yii::$app->getRequest()->getBodyParams();      
  $model = new Customer();   
  $model = $this->findModel($cust_ID);   
  $model->cust_id=$params['cust_ID'];
  $model->cust_name=$params['cust_Name'];
  $model->cust_addr=$params['cust_Addr'];
  $model->cust_alt_no=$params['cust_AltNo'];
  $model->cust_band=$params['cust_Band'];
  $model->cust_mail=$params['cust_Mail'];  
  $model->cust_no=$params['custNo']; 
   if(isset($_FILES['cust_Img']) && !empty($_FILES['cust_Img'])) {
      $target_path = yii::$app->basePath . "/uploads/" . $_FILES['cust_Img']['name'];
      $ext = pathinfo($target_path, PATHINFO_EXTENSION);
      $ext=($ext)?$ext:'.jpg';
      $img_name = time() . "." . $ext;
      $path = yii::$app->basePath . "/uploads/" . $img_name;
      $syntax = move_uploaded_file($_FILES['cust_Img']['tmp_name'], $path);
      if($syntax)
      {
        $model->cust_image = "http://api.pro-z.in/uploads/cus_img/".$img_name;
          
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
    else{
      $model->cust_image=$model['cust_image'];
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
   public function actionDeleteCustomerList($cust_ID) {   
    $model = new Customer();
    $model = $this->findModel($cust_ID);   
    $model->is_active='N';     
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success"),JSON_PRETTY_PRINT);        
    } 
    else {
      $this->setHeader(400);
     echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }     
  }

  protected function findModel($cust_ID) { 
    if (($model = Customer::findOne(['cust_id' => $cust_ID,'is_active' => 'Y'])) !== null) {
      return $model;
    }
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array('message'=>'Bad request')),JSON_PRETTY_PRINT);
      exit;
    }
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
