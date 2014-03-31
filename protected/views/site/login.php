<?php $this->pageTitle = 'Login - '.Yii::app()->name;?>
<form action=<?php echo Yii::app()->homeUrl . '?r=site/login'?> method='post'>
	<div class="input">
		<div>
			<label>Username</label>		
			<input type='text' name='LoginForm[username]' id='username' required/>
		</div>
		<div>
			<label>Password&nbsp;</label>		
			<input type='password' name='LoginForm[password]' id='password' required/>		
		</div>
	</div>	
	<div class="submitbtndiv">
		<input type='submit' class='submitbtn' value='Login!'/>
	</div>
</form>
<!-- Print error message if there is any -->
<div class=<?php echo $model->getError('password') == null ? "'errorMessage_hide'" : "'errorMessage_show'";?>><?php echo $model->getError('password');?></div>
