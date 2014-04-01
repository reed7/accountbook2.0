<?php $this->pageTitle = 'Statistic - '.Yii::app()->name?>
<div class="statistic_table">
	<header id='statistic_header'>
		<h1 style='margin: 0;font-family: 微软雅黑;'><?php echo $pageText?></h1>
	</header>
	<?php if(sizeof($statisticList) == 0){?>
	<span>没有数据，请重新选择！</span>
	<?php } else {?>
	<table>
		<?php 
		$totalOut = 0; $totalIn = 0; $rowIdx = 0;
		foreach($statisticList as $statisticItem){
			$rowIdx++;
			$balance = $statisticItem->balance;
			if($statisticItem->type == '1'){
				$totalOut += $balance;
				$className = 'black_right';
			} else {
				$totalIn += $balance;
				$className = 'red_right';
			}
		
		?>
			<tr <?php if($rowIdx % 2 == 0) echo 'class="alt"'?>><td><?php echo $statisticItem->category_name?></td>			
			<td class='<?php echo $className?>'><?php echo $balance?></td></tr>
			
		<?php } // end foreach?>
		<?php if($form->statisticType == 1 || $form->statisticType == 0){?>		
		<tr><td>总支出</td><td class='black_total'><?php echo $totalOut?></td></tr>
		<?php 
		}
		if($form->statisticType == 2 || $form->statisticType == 0){
		?>
		<tr><td>总收入</td><td class='red_total'><?php echo $totalIn?></td></tr>
		<?php }?>
		</table>
	<?php } // end else?>
</div>

<div class="center_part">
	<header>
		<h1 style='margin: 0;font-family: 微软雅黑;'>第七号狗熊的账本</h1>
	</header>
	
	<div class="item_list_part"> 
	<?php include(Yii::app()->basePath.'/views/widgets/account_list.php')?>
	</div>
</div>
