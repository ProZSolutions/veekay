<?php

namespace app\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\ActiveQuery;
use app\models\CategoryList;

class CategoryListController extends \yii\web\Controller
{
    

public function behaviors()
  {  //declare url for use get and post
    return [
         'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'index'=>['get'],    
          'upload-category-list'=>['post'],
          'update-category-list'=>['post'],
          'delete-category-list'=>['post'],                  
        ],        
      ]

    ];
  }
  //access the action (for example actionUplaodCategoryList)
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
  //this method used to get all category list  
  public function actionIndex() {         
    $query= new Query;      
    $query ->from('category_list')      
    ->select("category_id as category_ID,category_name as category_Name")
    ->where(['is_active' => 'Y']);           
    $command = $query->createCommand();
    $models = $command->queryAll();  
    $this->setHeader(200);     
    echo json_encode(array_filter($models),JSON_UNESCAPED_SLASHES);     
  }   
 
//uploading category list
  public function actionUploadCategoryList() {       
    $params = Yii::$app->getRequest()->getBodyParams();    
    $model = new CategoryList();       
    $model->category_id=$params['category_ID'];  
    $model->category_name=$params['category_Name'];     
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success"),JSON_PRETTY_PRINT);        
    } 
    else {
      $this->setHeader(400);
     echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }     
  } 
//update category list using(category id)
  public function actionUpdateCategoryList($category_ID) {   
    $params = Yii::$app->request->getBodyParams();       
    $model = new CategoryList();
    $model = $this->findModel($category_ID);    
    $model->category_id=$params['category_ID'];  
    $model->category_name=$params['category_Name'];     
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success"),JSON_PRETTY_PRINT);        
    } 
    else {
      $this->setHeader(400);
     echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }     
  } 
  //delete category list using category id
  public function actionDeleteCategoryList($category_ID) {           
    $model = new CategoryList();
    $model = $this->findModel($category_ID);   
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
  //find particular data for delete and update process
  protected function findModel($category_ID) { 
    if (($model = CategoryList::findOne(['category_id' => $category_ID,'is_active' => 'Y'])) !== null) {
      return $model;
    }
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array('message'=>'Bad request')),JSON_PRETTY_PRINT);
      exit;
    }
  }
  //used to set header
  private function setHeader($status) {    
    $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
    $content_type = "application/json";  
    header($status_header);
    header('Content-type: ' . $content_type);
    header('X-Powered-By: ' . "ProZ Solutions");
  }
  //get satus code
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
