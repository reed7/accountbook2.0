<?php

/**
 * This is the model class for table "account_items".
 *
 * The followings are the available columns in table 'account_items':
 * @property string $id
 * @property string $name
 * @property string $account_date
 * @property double $balance
 * @property string $category_id
 * @property string $location
 * @property string $comment
 * @property integer $type
 * @property integer $is_hidden
 * @property string $gmt_create
 *
 * The followings are the available model relations:
 * @property AccountCategory $category
 */
class AccountItem extends CActiveRecord
{	
	/**
	 * An array to store addtional properties for view.
	 * @var array
	 */
	public $addtionalProperties;
	
	public $sum;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, account_date, balance, category_id', 'required'),
			array('type, is_hidden', 'numerical', 'integerOnly'=>true),
			array('balance', 'numerical'),
			array('name, account_date, location', 'length', 'max'=>120),
			array('category_id', 'length', 'max'=>11),
			array('comment', 'length', 'max'=>128),
			array('id, gmt_create', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, account_date, balance, category_id, location, comment, type, is_hidden, gmt_create', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category' => array(self::BELONGS_TO, 'AccountCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '记账项目',
			'account_date' => 'Account Date',
			'balance' => 'Balance',
			'category_id' => 'Category',
			'location' => 'Location',
			'comment' => 'Comment',
			'type' => 'Type',
			'is_hidden' => 'Is Hidden',
			'gmt_create' => 'Gmt Create',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('account_date',$this->account_date,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('is_hidden',$this->is_hidden);
		$criteria->compare('gmt_create',$this->gmt_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Get account items list
	 * @param CDbCriteria $criteria
	 */
	public static function getAccountItems($criteria){
		$items=AccountItem::model()->findAll($criteria);
		$viewItems = array(); $idx = 0;
		$currentMonth = ''; $currentDate = '';
		
		foreach($items as $item){
			$accountTimestamp = $item->account_date;
			$accountYearMonth = date('Y-m', $accountTimestamp);
			$accountDate = date('Y-m-d', $accountTimestamp);
			
			if($currentMonth != $accountYearMonth){
				$currentMonth = $accountYearMonth;
				$monthlyIncome = AccountItem::getMonthlyIncome($accountYearMonth);
				$monthlyOutgo = AccountItem::getMonthlyOutgo($accountYearMonth);
				
				$item->addtionalProperties['monthTitle_income'] = $monthlyIncome;
				$item->addtionalProperties['monthTitle_outgo'] = $monthlyOutgo;
			}
			
			if($currentDate != $accountDate){
				$currentDate = $accountDate;
				$dailyIncome = AccountItem::getDailyIncome($accountTimestamp);
				$dailyOutgo = AccountItem::getDailyOutgo($accountTimestamp);
				
				$item->addtionalProperties['dateTitle_income'] = $dailyIncome;
				$item->addtionalProperties['dateTitle_outgo'] = $dailyOutgo;
			}
			
			$item->addtionalProperties['account_month'] = $accountYearMonth;
			$item->addtionalProperties['account_date'] = $accountDate;
			$viewItems[$idx++] = $item;
		}
		
		return $viewItems;
	}
	
	// -------------- self define query method ------------------------- //
	static function getMonthlyIncome($currentYearMonth){
		return AccountItem::getMonthlyBalanceByType($currentYearMonth, 2);
	}
	
	static function getMonthlyOutgo($currentYearMonth){
		return AccountItem::getMonthlyBalanceByType($currentYearMonth, 1);
	}
	
	/**
	 *
	 * @param string $currentYearMonth format of this argument should be 'yyyy-mm'
	 * @param integer $type account type : 1|2
	 */
	static function getMonthlyBalanceByType($currentYearMonth, $type){
		$currentMonth = substr($currentYearMonth, 5, 7);
		$currentYear = substr($currentYearMonth, 0, 4);
	
		$firstDateTimestamp = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
		$lastDateTimestamp = mktime(0, 0, 0, $currentMonth + 1, 1, $currentYear);
			
		$criteria=new CDbCriteria(array(
				'select'=>'round(sum(balance), 2) as sum',
				'condition'=>"account_date >= $firstDateTimestamp and account_date < $lastDateTimestamp and type = $type"));
		return AccountItem::model()->query($criteria)->sum;		
	}
	
	static function getDailyIncome($timestamp){
		return AccountItem::getDailyBalanceByType($timestamp, 2);
	}
	
	static function getDailyOutgo($timestamp){
		return AccountItem::getDailyBalanceByType($timestamp, 1);
	}
	
	static function getDailyBalanceByType($timestamp, $type){
		$criteria = new CDbCriteria(array(
				'select'=>'round(sum(balance), 2) as sum',
				'condition'=>"account_date = $timestamp and type = $type"));
		return AccountItem::model()->query($criteria)->sum;		
	}
}
