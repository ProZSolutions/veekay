<?php

namespace app\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\ActiveQuery;
use app\models\Product;


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
          'sync'=>['post'],      
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
    $query  ->select(['c.category_id as Category_ID','c.category_name as category_Name', 'p.product_Count', 'p.product_Desc', 'p.product_Id','p.product_Band', 'p.product_Image',  'p.product_Name', 'p.product_Price','p.is_Active']) 
      ->from('Product as p')
      ->leftJoin('category as c', 'c.category_id = p.Category_ID');             
    $command = $query->createCommand();
    $models = $command->queryAll();    
    $this->setHeader(200);     
    echo json_encode(array_filter($models),JSON_UNESCAPED_SLASHES);    
  }   

  public function actionUploadProductList() {       
  $params = Yii::$app->getRequest()->getBodyParams();      
  $model = new Product(); 
  $model->Category_ID=$params['category_ID'];
  $model->product_Count=$params['product_Count'];
  $model->product_Id=$params['product_Id'];
  $model->product_Name=$params['product_Name'];
  $model->product_Price=$params['product_Price'];
  $model->product_Desc=$params['product_Desc'];
  $model->product_Band=$params['product_Band'];
   if(isset($_FILES['product_Image']) && !empty($_FILES['product_Image'])) {    
   $target_path = yii::$app->basePath . "/uploads/prod_img/" . $_FILES['product_Image']['name'];
   $ext = pathinfo($target_path, PATHINFO_EXTENSION);
   $ext=($ext)?$ext:'.jpg';
   $img_name = time() . "." . $ext;
   $path = yii::$app->basePath . "/uploads/prod_img/" . $img_name; 
   $syntax = move_uploaded_file($_FILES['product_Image']['tmp_name'], $path);
   if($syntax)
   {
    $model->product_Image = "http://api.pro-z.in/uploads/prod_img/".$img_name;        
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success",'data'=>array('image'=>$model->product_Image)),JSON_UNESCAPED_SLASHES);        
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
    $model = new Product();
    $model = $this->findModel($product_ID); 
    $model->Category_ID=$params['category_ID'];
    $model->product_Count=$params['product_Count'];
    $model->product_Id=$params['product_Id'];
    $model->product_Name=$params['product_Name'];
    $model->product_Price=$params['product_Price'];
    $model->product_Desc=$params['product_Desc'];
    $model->product_Band=$params['product_Band'];
     if(isset($_FILES['product_Image']) && !empty($_FILES['product_Image'])) {
      $target_path = yii::$app->basePath . "/uploads/prod_img/" . $_FILES['product_Image']['name'];
      $ext = pathinfo($target_path, PATHINFO_EXTENSION);
      $ext=($ext)?$ext:'.jpg';
      $img_name = time() . "." . $ext;
      $path = yii::$app->basePath . "/uploads/prod_img/" . $img_name;
      $syntax = move_uploaded_file($_FILES['product_Image']['tmp_name'], $path);
      if($syntax)
      {
        $model->product_Image = "http://api.pro-z.in/uploads/prod_img/".$img_name;
          
      if ($model->save()) {      
        $this->setHeader(200);
         echo json_encode(array('status'=>"success",'data'=>array('image'=>$model->product_Image)),JSON_UNESCAPED_SLASHES);               
      } 
      else {
        $this->setHeader(400);
       echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
      }
      } 
    }
    else{
      $model->product_Image=$model['product_Image'];
      if ($model->save()) {      
        $this->setHeader(200);
        echo json_encode(array('status'=>"success",'data'=>array('image'=>$model['product_Image'])),JSON_UNESCAPED_SLASHES);        
      } 
      else {
        $this->setHeader(400);
       echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
      }

    }  
  }  
   public function actionDeleteProductList($product_ID) {           
    $model = new Product();
    $model = $this->findModel($product_ID);   
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
    $query= new Query;     
    $query  ->select(['c.category_id as Category_ID','c.category_name as category_Name', 'p.product_Count', 'p.product_Desc', 'p.product_Id','p.product_Band', 'p.product_Image',  'p.product_Name', 'p.product_Price','p.is_Active']) 
    ->from('Product as p')
    ->leftJoin('category as c', 'c.category_id = p.Category_ID')
    ->where(['>=', 'p.date_time', $date]);           
    $command = $query->createCommand();
    $models = $command->queryAll();
    if($models!==[])  {
    $this->setHeader(200);     
    echo json_encode(array('current_date'=> date('d-m-Y H:i'),'data'=>array_filter($models)),JSON_UNESCAPED_SLASHES);
  }
  else{
    $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array('message'=>'Bad request')),JSON_PRETTY_PRINT);
      exit;

  }
  }
      
  protected function findModel($product_ID) { 

    if (($model = Product::findOne(['product_Id' => $product_ID])) !== null) {
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
