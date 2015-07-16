<?php
class AccountStatisticController extends Controller
{
	public function actionIndex()
	{	
		$form = new AccountStatisticForm();
		
		if(isset($_GET['AccountStatisticForm'])){
			$form->attributes = $_GET['AccountStatisticForm'];
			
			$timeStart = ''; $timeEnd = ''; $pageText = '';
			$statisticYear = $form->statisticYear;
			$statisticMonth = $form->statisticMonth;
			$statisticType = $form->statisticType;
			$categoryId = $form->categoryId;
			
			switch($statisticType){
				case 0: $textType = '收支'; break;
				case 1: $textType = '支出'; break;
				case 2: $textType = '收入'; break;
				default: break;
			}
			
			// conditions for statistic table
			$statisticListCriteria = new CDbCriteria();
			$statisticListCriteria->select = 'category_id, round(sum(balance), 2) balance, type';
			$statisticListCriteria->group = 'category_id';
			$statisticListCriteria->order = 'balance DESC';
			
			// conditions for right side account item list
			$accountItemListCriteria = new CDbCriteria();
			$accountItemListCriteria->order = 'account_date DESC, gmt_create DESC';					
			
			if($statisticType > '0'){
				$statisticListCriteria->addCondition("type = $statisticType");			
				$accountItemListCriteria->addCondition("type = $statisticType");
			}
					
			if($statisticYear == '0'){
				$pageText = '全部年份的'.$textType.'统计信息';
				// query without any time range
			} else {
				if($statisticMonth == '0'){ // whole year
					$pageText = $statisticYear.'年的'.$textType.'统计信息';
					
					$timeStart = mktime(0, 0, 0, 1, 1, $statisticYear);
					$timeEnd = mktime(23, 59, 59, 12, 31, $statisticYear);				
				} else { // whole month
					$pageText = $statisticYear.'年'.$statisticMonth.'月的'.$textType.'统计信息';
					$timeStart = mktime(0, 0, 0, $statisticMonth, 1, $statisticYear);
					$timeEnd = mktime(0, 0, 0, $statisticMonth+1, 1, $statisticYear);
				}
				
				$statisticListCriteria->addCondition(array("account_date >= $timeStart", "account_date < $timeEnd"));
				$accountItemListCriteria->addCondition(array("account_date >= $timeStart", "account_date < $timeEnd"));
				if(!is_null($categoryId) && $categoryId !== '0') {
					$accountItemListCriteria->addCondition(array("category_id = $categoryId"));
				}
			}
			
			$array = AccountItem::model()->findAll($statisticListCriteria);
			$statisticList = array();

			foreach ($array as $row) {
				$statisticItem = new StatisticItem();				
				$statisticItem->categoryName = AccountCategory::getCategoryNameById($row->category_id);
				$statisticItem->categoryId = $row->category_id;
				$statisticItem->type = $row->type;
				$statisticItem->globalType = $statisticType;
				$statisticItem->balance = $row->balance;
				$statisticItem->year = $statisticYear;
				$statisticItem->month = $statisticMonth;
				$statisticList[] = $statisticItem;
			}

			$count = AccountItem::model()->count($accountItemListCriteria);
			$pages = new CPagination($count);
			$pages->pageSize = 30;
			$pages->applyLimit($accountItemListCriteria);
			/*
			 *  We should set these 3 values as page turnning url's GET parameter, otherwise controller will receive 
			 *  no data after turnning to another page rather than the default page.
			 *  Maybe we could use a cache to store these statistic querying parameter to avoid the ugly long url in 
			 *  the further.
			 */
			$pages->params = array(
					'AccountStatisticForm[statisticYear]'=>$statisticYear,
					'AccountStatisticForm[statisticMonth]'=>$statisticMonth,
					'AccountStatisticForm[statisticType]'=>$statisticType);
			$accountItemList = AccountItem::getAccountItems($accountItemListCriteria);			
			
			$this->innerPage = Controller::PAGE_STATISTIC;
			
			$this->render('statistic', 
					array('accountItemModels'=>$accountItemList, 'statisticList'=>$statisticList, 'currentCategoryId'=>$categoryId, 'pages'=>$pages, 'pageText'=>$pageText, 'form'=>$form));
		} else {
			throw new CHttpException(400, 'The post data is empty!');
		}
	}	
	
	public function filters()
	{
		return array(			
			array(
					'application.filters.UserLoginFilter + index'
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
?>