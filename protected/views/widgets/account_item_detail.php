<?php /* <div class="edit_title"><span class="edit_title_txt"><?php echo $model->id != null ? '修改' : '新增'?>账单</span></div> */ ?>
	<div class="edit_form">
	<form action=<?php echo Yii::app()->homeUrl . '?r=accountitem/save&id=0'?> method='post' id='itemDetailForm'>
		<input type='hidden' name='AccountItem[id]' id='id'/>
		
		<!-- name -->
		<div class="edit_input left">
			<span style="color:red">*</span><span class="edit_label">记账项目:</span>		
			<input type='text' name='AccountItem[name]' id='name' maxLength='30' required/>
		</div>
		
		<!-- type -->
		<div class="edit_input right">
			<span style="color:red">*</span><span class="edit_label">账目类型:</span>
			<input value="1" onclick="javascript:selectCategory(1);" name="AccountItem[type]" id="type1" type="radio" checked/>
			<span style='color:black;font-size:13px'>支出</span>
			<input value="2" onclick="javascript:selectCategory(2);" style="margin-left: 20px" name="AccountItem[type]" id="type2" type="radio"/>
			<span style='color:black;font-size:13px'>收入</span>
		</div>
		
		<!-- category -->
		<div class="edit_input left">
			<span style="color:red">*</span><span class="edit_label">所属类别:</span>
			<input type='text' name='AccountItem[category_name]' id='category_name' value='正餐'
				style='display:inline;width:100px' readonly onclick='javascript:showCategory(1);'/>
			<input type='hidden' name='AccountItem[category_id]' id='category_id' value='16'/>
			<?php include(Yii::app()->basePath . '/views/widgets/category_div.php');?>			
		</div>
		
		<!-- balance -->
		<div class="edit_input right">
			<span style="color:red">*</span><span class="edit_label">账目金额:</span>
			<input name='AccountItem[balance]' id='balance' required style='width:120px;'/>
		</div>
		
		<!-- account_date -->
		<div class="edit_input left">	
			<span style="color:red">*</span><span class="edit_label">发生日期:</span>
			<?php 
			/*	Explain for '(strtotime(date('Y-m-d', time())) * 1000)' below
			 *  1、we execute strtotime(date('Y-m-d', time()) to generate a timestamp represents current date, e.g. 2012-04-22 00:00:00
			 *  2、php's timestamp is in second while js is in millisecond, so by default server side will divide timestamp get from front by 1000
			 */
			?>		
			<input type='hidden' name='AccountItem[account_date]' id='account_date_timestamp'
				value='<?php echo strtotime(date('Y-m-d', time())) * 1000?>'/>
			<input type='hidden' id='today'
				value='<?php echo date('Y-m-d', time()) /*for conveniently reset the form*/?>'/>
			<input readonly id="account_date" type="text" value="<?php echo date('Y-m-d', time())?>" name="account_date" style='width:100px;' />	
		</div>
		
		<!-- location -->
		<div class="edit_input right">	
			&nbsp;&nbsp;<span class="edit_label">发生地点:</span>
			<input type='text' name='AccountItem[location]' id='location' style='width:120px;'/>			
		</div>
		
		<!-- comment -->
		<div class="edit_input left commentDiv">
			&nbsp;&nbsp;<span class="edit_label">备&nbsp;&nbsp;&nbsp;&nbsp;注</span><br/>	
			<textarea name='AccountItem[comment]' rows='5' cols='68' id='comment'></textarea>
		</div>
		
		<!-- submit button -->
		<div class="edit_input submitBtnDiv">
			<input type='submit' value='Create' class='submitBtn' id='submitBtn'/>
		</div>
	</form>	
	<script type='text/javascript'>	
	$(function() {
		$('#account_date').datepicker({'altField':'#account_date_timestamp','altFormat':'@'/*timestamp*/,'showAnim':'fold','dateFormat':'yy-mm-dd','showButtonPanel':'true','changeYear':'true','yearRange':'2008:c+5',});
	});
	</script>
</div>
