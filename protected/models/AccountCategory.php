<?php

/**
 * This is the model class for table "account_category".
 *
 * The followings are the available columns in table 'account_category':
 * @property integer $id
 * @property string $category_name
 * @property integer $is_delete
 * @property integer $account_type
 *
 * The followings are the available model relations:
 * @property AccountItems[] $accountItems
 */
class AccountCategory extends CActiveRecord
{
	public static function getCategoryByType($type){
		$criteria = new CDbCriteria();
		$criteria->condition = 'account_type = :account_type and is_delete = 0';
		$criteria->order = 'category_name ASC';
		$criteria->params = array(':account_type'=>$type);
		return AccountCategory::model()->findAll($criteria);
	}

	public static function getCategoryNameById($id) {
		$criteria = new CDbCriteria();
		$criteria->condition = 'id = :category_id';
		$criteria->params = array(':category_id'=>$id);
		$result = AccountCategory::model()->find($criteria);
		return $result->category_name;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountCategory the static model class
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
		return 'account_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_name', 'required'),
			array('is_delete, account_type', 'numerical', 'integerOnly'=>true),
			array('category_name', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_name, is_delete, account_type', 'safe', 'on'=>'search'),
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
			'accountItems' => array(self::HAS_MANY, 'AccountItems', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_name' => 'Category Name',
			'is_delete' => 'Is Delete',
			'account_type' => 'Account Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('account_type',$this->account_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}