<!-- List Start -->
<?php 
$currentMonth = '';
$currentDate = '';
foreach($accountItemModels as $item) {
if($currentMonth != $item->addtionalProperties['account_month']) {
$currentMonth = $item->addtionalProperties['account_month'];
?>
<!-- Month title -->
<div class='monthly_cell_title'>
	<div style='float: left'>
		<span class='account_month'><?php echo $currentMonth?> </span>
	</div>
	<div style='text-align: right; margin-right: 22px;'>
		<?php if ($item->addtionalProperties['monthTitle_income'] > 0) {?>
		<span style='margin-right: 10px; color: red; font-weight: bold'><?php echo $item->addtionalProperties['monthTitle_income']?></span>
		<?php }			
		if ($item->addtionalProperties['monthTitle_outgo'] > 0) {?>
		<span style='margin-right: 10px; color: green; font-weight: bold'><?php echo $item->addtionalProperties['monthTitle_outgo']?></span>
		<?php }?>
	</div>
</div>
<?php }
if($currentDate != $item->addtionalProperties['account_date']) {
$currentDate = $item->addtionalProperties['account_date']?>
<!-- Date title -->
<div class='daily_cell_title'>
	<div style='float: left'>
		<span class='account_date'><?php echo $currentDate?> </span>
	</div>
	<div style='text-align: right; margin-right: 22px;'>
		<?php if ($item->addtionalProperties['dateTitle_income'] > 0) {?>
		<span style='margin-right: 10px; color: red; font-weight: bold'><?php echo $item->addtionalProperties['dateTitle_income']?></span>
		<?php }
		if ($item->addtionalProperties['dateTitle_outgo'] > 0) {?>			 
		<span style='margin-right: 10px; color: green; font-weight: bold'><?php echo $item->addtionalProperties['dateTitle_outgo']?></span>
		<?php }?>		
	</div>
</div>
<?php }
$fontColor='black';
if($item->type == 2){
	$fontColor='red';
}
?>
<!-- account items -->
<div class='list_row'>
	<div class='item_name' title='<?php echo $item->name?>'><?php echo $item->name?></div>
	<span class='location' title='<?php echo $item->location?>'><?php echo $item->location?></span>
	<span class='comment' title='<?php echo $item->comment?>'><?php echo $item->comment?></span>
	<span class='balance' style='color: <?php echo $fontColor?>'><?php echo $item->balance?></span>	
	<a href='javascript:return false;' onclick='javascript:showUpdateDiv(<?php echo $item->id?>);' title='修改'>
		<img src="<?php echo Yii::app()->getBaseUrl();?>/images/transparent.gif" class="update_item"/>
	</a>	
	<a href='javascript:return false;' onclick='javascript:return confirmDel(<?php echo $item->id?>);' title='删除'>
		<img src="<?php echo Yii::app()->getBaseUrl();?>/images/transparent.gif" class="delete_item"/>
	</a>
</div>
<?php
}
?>
<div id='delConfirmDialog' class='modal_dlg'>
	<div class='delete_confim_txt'>确认删除这条账目？</div>
</div>
<!-- List End -->

<div style='posotion: fixed;bottom: 0px;'>
<?php $this->widget('CListPager', array(
		'pages' => $pages,
)) ?>
<?php $this->widget('CLinkPager', array(
		'pages' => $pages,
		'header'=>''
)) ?>
</div>
<!-- Page turnning part start
<div class="page_turn">
	{if $pageNum gt 0}
	<a href="javascript:return false;" onclick="javascript:goPrevPage();">上一页</a>
	{/if}
	 第 <input type='text' id='inputPageNum' value='{$pageNum+1}' style='width:28px;text-align:right;' maxlength='3'/> / {$pageCount} 页	
	<input type="button" value="GO!" onclick="javascript:go2ChosenPage();"></input>
	{if $pageNum+1 lt $pageCount}
	<a href="javascript:return false;" onclick="javascript:goNextPage();">下一页</a>
	{/if}	
</div>
<form id="page" action="{$parentPage}" method="get">
	<input type="hidden" id="pageNum" name="pageNum"/>
	<input type="hidden" id="itemCount" name="itemCount" value="{$itemCount}"/>
	<input type="hidden" id="pageCount" name="pageCount" value="{$pageCount}"/>
	<input type="hidden" id="statisticYear" name="statisticYear" value="{$year}"/>
	<input type="hidden" id="statisticMonth" name="statisticMonth" value="{$month}"/>
	<input type="hidden" id="statisticType" name="statisticType" value="{$type}"/>
</form>
Page turnning part end -->
<script type='text/javascript'>
function showUpdateDiv(id){
	$.get('?r=accountitem/ajaxShowUpdate', {'id':id}, fillUpdateForm, 'json');
}

var deleteId = '';
function confirmDel(id){
	$('#delConfirmDialog').dialog('open');	
	deleteId = id;
}

function deleteItem(){
	location.href= '<?php echo Yii::app()->homeUrl;?>' + "?r=accountitem/delete&id=" + deleteId;
}

$(function() {
	$('#delConfirmDialog').dialog({'title':'删除账目','autoOpen':false,'modal':true,'height':200,'width':400,
		'buttons':{'Delete':function(){deleteItem()},'Cancel':function(){$("#delConfirmDialog").dialog("close")}}});
});
/*
function go2ChosenPage(){
	var pageNum = document.getElementById("inputPageNum").value;
	go2Page(pageNum-1,{$itemCount});
}

function goPrevPage(){	
	var pageNum = {$pageNum};
	var itemCount = {$itemCount};
	pageNum -= 1;
	if(pageNum < 0){
		alert("已到达第一页！");			
		return;
	}
	
	go2Page(pageNum, itemCount);
}

function goNextPage(){	
	var pageNum = {$pageNum};
	var itemCount = {$itemCount};
	var pageCount = {$pageCount};
	pageNum += 1;
	if(pageNum >= pageCount){
		alert("已到达最后一页！");
		return;
	}
	
	go2Page(pageNum, itemCount);
}

/**
 * pageNum start with 0, end with total-1

function go2Page(pageNum, itemCount){
	var pageCount = {$pageCount};
	if(pageNum > pageCount-1 || pageNum < 0){
		alert("这不是一个正确的页码！");
		return false;
	}
	document.getElementById("pageNum").value = pageNum;				
	document.getElementById("page").submit();
} */
</script>
