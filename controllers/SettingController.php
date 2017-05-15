<?php

namespace app\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\Setting;

class SettingController extends \yii\web\Controller
{
    public function behaviors()
  {  
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'index'=>['get'],     
          'update-setting'=>['post'],               
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
    $query  ->select(['gold','bronze','silver']) 
      ->from('setting');                
    $command = $query->createCommand();
    $models = $command->queryAll();      
    $this->setHeader(200);     
    echo json_encode(array_filter($models),JSON_UNESCAPED_SLASHES);    
  }   

  
  public function actionUpdateSetting() { 
  	$params = Yii::$app->getRequest()->getBodyParams();      
  	$model = new Setting();   
  	$model = $this->findModel(); 
    $model->attributes=$params;
    if($model->save()){
      $this->setHeader(200);
      echo json_encode(array('status'=>"success"),JSON_UNESCAPED_SLASHES);        
    } 
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }        
  }

  protected function findModel() { 
    if(($model = Setting::findOne(['id' => 1])) !== null) {
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
