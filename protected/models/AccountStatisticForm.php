<?php
class AccountStatisticForm extends CFormModel
{
	public $statisticYear;
	public $statisticMonth;
	public $statisticType;
	public $categoryId;

	public function rules()
	{
		return array(			
			array('statisticYear, statisticMonth, statisticType, categoryId', 'safe'),
		);
	}
}
