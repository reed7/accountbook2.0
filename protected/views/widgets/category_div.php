<div id='outgo_cat_list'
	class='cat_list_outgo'>
	<div>
		<span class='edit_cat_list_close'><a href='javascript:return false;'
			onclick='javascript:closeMe("outgo_cat_list");'>x</a> </span>
	</div>
	<!-- The outgo categories list  -->
	<?php for($i = 0;$i < sizeof($categories['outgo']);$i++) {
			if($i % 5 === 0){ // swap the line
	?>	
	<div class='edit_cat_list_line'>
	<?php }?>	
		<div class='edit_cat_list_ele'>
			<a href='javascript:return false;'
				onclick="javascript:setCatValue(1, <?php echo $categories['outgo'][$i]->id?>, this.innerHTML);"><?php echo $categories['outgo'][$i]->category_name;?></a>
		</div>
		<?php if($i % 5 === 0){?>
		</div>
		<?php }//end if
		 }// end for
		?>
</div>
<div id='income_cat_list'
	class='cat_list_income'>
	<div>
		<span class='edit_cat_list_close'><a href='javascript:return false;'
			onclick='javascript:closeMe("income_cat_list");'>x</a> </span>
	</div>
	<!-- The income categories list  -->
	<?php for($i = 0;$i < sizeof($categories['income']);$i++) {
			if($i % 5 === 0){ // swap the line
	?>	
	<div class='edit_cat_list_line'>
	<?php }?>
		<div class='edit_cat_list_ele'>
			<a href='javascript:return false;'
				onclick="javascript:setCatValue(2, <?php echo $categories['income'][$i]->id?>, this.innerHTML);"><?php echo $categories['income'][$i]->category_name;?></a>
		</div>
		<?php if($i % 5 === 0){?>
	</div>
	<?php }//end if
	 }// end for
	?>
</div>
