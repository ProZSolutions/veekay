<?php

namespace app\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\ActiveQuery;
use app\models\ProductList;
use yii\web\UploadedFile;

class ProductListController extends \yii\web\Controller
{
   
public $documentPath = __DIR__ . '/images/';
public function behaviors()
  {  
    return [
         'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'index'=>['get'],       
          'upload-product-list'=>['post'],  
          'update-product-list'=>['post'],  
          'delete-product-list'=>['post'],        
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
    $query  ->select(['c.category_id as category_ID','c.category_name as category_Name', 'p.product_count as product_Count', 'p.product_desc as product_Desc', 'p.product_id as product_ID', 'p.product_image as product_Image',  'p.product_name as product_Name', 'p.product_price as product_Price']) 
      ->from('product_list as p')
      ->leftJoin('category_list as c', 'c.category_id = p.category_id')
      ->where(['p.is_active' => 'Y']);  
              
    $command = $query->createCommand();
    $models = $command->queryAll();       
      
    $this->setHeader(200);     
   echo json_encode(array_filter($models),JSON_UNESCAPED_SLASHES);    
  }   

  public function actionUploadProductList() {       
  $params = Yii::$app->getRequest()->getBodyParams();      
  $model = new ProductList(); 
  $model->category_id=$params['category_ID'];
  $model->product_count=$params['product_Count'];
  $model->product_id=$params['product_Id'];
  $model->product_name=$params['product_Name'];
  $model->product_price=$params['product_Price'];
  $model->product_desc=$params['product_Desc']; 

   if(isset($_FILES['product_Image']) && !empty($_FILES['product_Image'])) {
    
   $target_path = yii::$app->basePath . "/uploads/" . $_FILES['product_Image']['name'];
   $ext = pathinfo($target_path, PATHINFO_EXTENSION);
   $ext=($ext)?$ext:'.jpg';
   $img_name = time() . "." . $ext;

   $path = yii::$app->basePath . "/uploads/" . $img_name;
 
   $syntax = move_uploaded_file($_FILES['product_Image']['tmp_name'], $path);
   if($syntax)
   {

  $model->product_image = "http://api.pro-z.in/uploads/".$img_name;
        
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
  public function actionUpdateProductList($product_ID) {   
    $params = Yii::$app->request->getBodyParams();       
    $model = new ProductList();
    $model = $this->findModel($product_ID);       
    $model->category_id=$params['category_ID'];
    $model->product_count=$params['product_Count'];
    $model->product_id=$params['product_Id'];
    $model->product_name=$params['product_Name'];
    $model->product_price=$params['product_Price'];
    $model->product_desc=$params['product_Desc'];
     if(isset($_FILES['product_Image']) && !empty($_FILES['product_Image'])) {
      $target_path = yii::$app->basePath . "/uploads/" . $_FILES['product_Image']['name'];
      $ext = pathinfo($target_path, PATHINFO_EXTENSION);
      $ext=($ext)?$ext:'.jpg';
      $img_name = time() . "." . $ext;
      $path = yii::$app->basePath . "/uploads/" . $img_name;
      $syntax = move_uploaded_file($_FILES['product_Image']['tmp_name'], $path);
      if($syntax)
      {
        $model->product_image = "http://api.pro-z.in/uploads/".$img_name;
          
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
      $model->product_image=$model['product_image'];
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
   public function actionDeleteProductList($product_ID) {           
    $model = new ProductList();
    $model = $this->findModel($product_ID);   
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
 
      
  protected function findModel($product_ID) { 

    if (($model = ProductList::findOne(['product_id' => $product_ID,'is_active' => 'Y'])) !== null) {
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
