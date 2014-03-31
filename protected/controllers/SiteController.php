<?php

class SiteController extends Controller
{	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(				
				'order'=>'account_date DESC, gmt_create DESC',				
		));
		$count=AccountItem::model()->count($criteria);
		$pages=new CPagination($count);
		$pages->pageSize=20;
		$pages->applyLimit($criteria);
				
		$items=AccountItem::getViewModel($criteria);
		$this->render('index', array('items'=>$items, 'pages'=>$pages));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm();
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()){
				$this->redirect(Yii::app()->homeUrl);
			}
		}
		
		// display the login form
		$this->innerPage = Controller::PAGE_LOGIN;		
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
		
// 	public function filters()
// 	{
// 		return array(
// 				array( // filters classes from outside the controller
// 						'ESetReturnUrlFilter',
// 				),
// 		);
// 	}
}