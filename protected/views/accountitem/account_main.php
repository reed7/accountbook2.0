<?php $this->pageTitle = 'Main - '.Yii::app()->name;?>
<!-- outer -->
<div class="center_part">
<header>
	<h1 style='margin: 0;font-family: 微软雅黑;'>第七号狗熊的账本</h1>
	<nav class='header_nav'>		
		<a href='javascript:return false;' id='create_new_btn' class='create_item_btn'>新  建</a>
		<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
		<a href='javascript:return false;' id='statistic_btn' class='view_statistic'>统  计</a>
	</nav>
</header>

<div class='modal_dlg' id='itemDetailDialog'>
<?php include(Yii::app()->basePath . '/views/widgets/account_item_detail.php');?>
</div>

<div class='modal_dlg' id='statisticDialog'>
	<div id="statisticForm">
	<form action=<?php echo Yii::app()->homeUrl . '/accountstatistic';?> method='get' target='_blank'>	
			<div class='row'>			
				时间：
				<select name='AccountStatisticForm[statisticYear]'>
					<option value="0">年</option>
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
					<option value="2012" selected>2012</option>
				</select>
				<select name="AccountStatisticForm[statisticMonth]">
					<option value="0">月</option>
					<option value="1">Jan.</option>
					<option value="2">Feb.</option>
					<option value="3">Mar.</option>
					<option value="4">Apr.</option>
					<option value="5">May.</option>
					<option value="6">Jun.</option>
					<option value="7">Jul.</option>
					<option value="8">Aug.</option>
					<option value="9">Sep.</option>
					<option value="10">Oct.</option>
					<option value="11">Nov.</option>
					<option value="12">Dec.</option>
				</select>
			</div>
			<div class='row'>
				类型：
				<select name="AccountStatisticForm[statisticType]" id="AccountStatisticForm_statisticType">
					<option value="0">收支</option>
					<option value="1">支出</option>
					<option value="2">收入</option>
				</select>					
			</div>
			<div class='statisticBtnDiv'>
				<input type='submit' value='Click to view the statistic NOW!' style='height: 30px;'/>				
			</div>
		</form>
	</div>
</div>

<div class='item_list_part'>
<?php include(Yii::app()->basePath . '/views/widgets/account_list.php');?>
</div>
</div>

<script type='text/javascript'>
$(function() {
	$('#create_new_btn').click(function() {		
		$("#itemDetailDialog").dialog('open');
	});

	$('#statistic_btn').click(function() {		
		$("#statisticDialog").dialog('open');
	});
	
	$('#itemDetailDialog').dialog({title:'添加账目',autoOpen:false,modal:true,height:340,width:460,resizable:false,
		close:function(event, ui){closeMe("outgo_cat_list"); closeMe("income_cat_list"); resetDetailForm();}});

	$('#statisticDialog').dialog({title:'选择统计时间范围',autoOpen:false,modal:true,height:160,width:300,resizable:false});
});
</script>

<!-- outer end -->