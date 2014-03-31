<?php
class AccountItemController extends Controller
{
	private $accountItem;

	public function actionIndex()
	{
		$criteria = new CDbCriteria(array(				
				'order'=>'account_date DESC, gmt_create DESC',				
		));
		$count = AccountItem::model()->count($criteria);
		$pages = new CPagination($count);
		$pages->pageSize = 30;
		$pages->applyLimit($criteria);
				
		$items = AccountItem::getAccountItems($criteria);
		if($this->accountItem == null){
			$this->accountItem = new AccountItem();
		}		
		$this->accountItem->type = 1;
		
		$categories['outgo'] = AccountCategory::getCategoryByType('1');
		$categories['income'] = AccountCategory::getCategoryByType('2');
		
		$this->render('account_main', array('accountItemModels'=>$items, 'pages'=>$pages, 'model'=>$this->accountItem, 'categories'=>$categories, 'accountStatisticForm'=>new AccountStatisticForm()));
	}
	
	/**
	 * Will execute 'Create' if $id is null, otherwise will execute 'Update'.
	 * @param string $id
	 */
	public function actionSave($id){	
		if($id == '0'){ // id that doesn't exist indicates that it's a create new command
			$this->accountItem = new AccountItem(); // Every time php received a request, it will initiate a new controller instance to process it, so we can't share the accountItem instance created in actionIndex()			
			if(isset($_POST['AccountItem'])){
				$this->createItem($_POST['AccountItem']);				
			} else {				
				$this->accountItem->addError('general', 'Illegal request, \'AccountItem\' is null!');
			}
		} else {
			$this->updateItem($id, $_POST['AccountItem']);			
		}
		
		Yii::log('$model failed to pass the validation and request is being redirected to the main page with validation error information.'.
				'[name->'.$this->accountItem->name.', balance->'.$this->accountItem->balance.', type->'.$this->accountItem->type.']', CLogger::LEVEL_INFO);
		$this->actionIndex();
	}	
	
	public function actionDelete($id){		
		AccountItem::model()->deleteByPk($id);
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionAjaxShowUpdate($id){
		Yii::log('ajax request received!');
		
		$model = AccountItem::model()->findByPk($id);
	
		$model->category = AccountCategory::model()->findByPk($model->category_id);
	
		$categories['outgo'] = AccountCategory::getCategoryByType('1');
		$categories['income'] = AccountCategory::getCategoryByType('2');
	
		$this->renderPartial('jsonItemDetail', array('model'=>$model));
	}
	
	public function actionShowUpdate($id){
		$model = AccountItem::model()->findByPk($id);
		
		$model->category = AccountCategory::model()->findByPk($model->category_id);
		
		$categories['outgo'] = AccountCategory::getCategoryByType('1');
		$categories['income'] = AccountCategory::getCategoryByType('2');
		
		$this->render('account_item_update', array('model'=>$model, 'categories'=>$categories));
	}
	
	private function createItem($postAccountItem){
		$this->accountItem->attributes = $postAccountItem;
		$this->accountItem->account_date = $this->accountItem->account_date / 1000;
		
		if($this->accountItem->validate()){
			Yii::log('$model has passed the validation, going to [CREATE] to DB.[name->'.$this->accountItem->name.', balance->'.$this->accountItem->balance.', type->'.$this->accountItem->type.']', CLogger::LEVEL_INFO);
			$this->accountItem->id = null;
			$this->accountItem->gmt_create = new CDbExpression('NOW()');
			$this->accountItem->save();
			$this->redirect(Yii::app()->user->returnUrl);
		}
	}
	
	private function updateItem($id, $postAccountItem){
		$this->accountItem = AccountItem::model()->findByPk($id);
		
		$this->accountItem->attributes = $postAccountItem;
		$this->accountItem->account_date = $this->accountItem->account_date / 1000;
		if($this->accountItem->validate()){
			Yii::log('$model has passed the validation, going to [UPDATE] to DB.[name->'.$this->accountItem->name.', balance->'.$this->accountItem->balance.', type->'.$this->accountItem->type.']', CLogger::LEVEL_INFO);
			$this->accountItem->update();
			$this->redirect(Yii::app()->user->returnUrl);
		}
	}	

	public function filters()
	{
		return array(
				array( // filters classes from outside the controller
						'ESetReturnUrlFilter',
				),
				array(
						'application.filters.UserLoginFilter + index, save, delete'
				),
		);
	}
/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}