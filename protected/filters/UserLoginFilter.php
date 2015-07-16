<?php
/**
 * You should login to access the Account Book.
 */
class UserLoginFilter extends CFilter
{
	protected function preFilter($filterChain)
	{
		if(Yii::app()->user->isGuest){
			$filterChain->controller->redirect(Yii::app()->homeUrl . '?r=site/login');
		}
		return true;
	}
}
?>
