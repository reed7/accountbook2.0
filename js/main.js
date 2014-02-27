function selectCategory(type){
	if(1 == type){
		closeMe('income_cat_list');			
		setCategoryElementsValue('16', '正餐');
	} else {
		closeMe('outgo_cat_list');
		setCategoryElementsValue('26', '打工收入');
	}
	
	document.getElementById('category_name').onclick = new Function("showCategory(" + type + ")");
}

function showCategory(type){
	if(1 == type){
		show = 'outgo_cat_list';
		hide = 'income_cat_list';
	} else {
		show = 'income_cat_list';
		hide = 'outgo_cat_list';
	}
	
	document.getElementById(show).style.display = 'block';
	document.getElementById(hide).style.display = 'none';
}

function closeMe(id){
	document.getElementById(id).style.display = 'none';
}

function setCatValue(type, cat_id, cat_name){	
	if(1 == type){
		closeMe('outgo_cat_list');	
	} else {
		closeMe('income_cat_list');				
	}
	
	setCategoryElementsValue(cat_id, cat_name);	
}

function setCategoryElementsValue(cat_id, cat_name){
	document.getElementById('category_id').value = cat_id;
	document.getElementById('category_name').value = cat_name;			
}

function resetDetailForm() {
	document.getElementById('id').value = '';
	document.getElementById('name').value = '';
	document.getElementById('type1').checked = true;
	document.getElementById('category_name').value = '正餐';
	document.getElementById('category_name').onclick = new Function("showCategory(1)");
	document.getElementById('category_id').value = '16';
	document.getElementById('balance').value = '';
	document.getElementById('account_date_timestamp').value = new Date().getTime();
	document.getElementById('account_date').value = document.getElementById('today').value;
	document.getElementById('location').value = '';
	document.getElementById('comment').innerHTML = '';
	document.getElementById('itemDetailForm').action = 'index.php/accountitem/save/0';
	document.getElementById('submitBtn').value = 'Create';
}

function fillUpdateForm(data){
	document.getElementById('id').value = data['id'];
	document.getElementById('name').value = data['name'];
	document.getElementById('type' + data['type']).checked = true;
	document.getElementById('category_name').value = data['category_name'];
	document.getElementById('category_name').onclick = new Function("showCategory(" + data['type'] + ")");
	document.getElementById('category_id').value = data['category_id'];
	document.getElementById('balance').value = data['balance'];
	document.getElementById('account_date_timestamp').value = data['account_date_timestamp'];
	document.getElementById('account_date').value = data['account_date'];
	document.getElementById('location').value = data['location'];
	document.getElementById('comment').innerHTML = data['comment'];
	document.getElementById('itemDetailForm').action = 'index.php/accountitem/save/' + data['id']; 
	document.getElementById('submitBtn').value = 'Update';
	$("#itemDetailDialog").dialog('open');
}
