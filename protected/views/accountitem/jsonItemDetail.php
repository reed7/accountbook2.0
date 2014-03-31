{"id":"<?php echo $model->id?>", "name":"<?php echo $model->name?>", "type":"<?php echo $model->type?>", "category_name":"<?php echo $model->category->category_name?>", "category_id":"<?php echo $model->category_id?>", 
"balance":"<?php echo $model->balance?>", "account_date_timestamp":"<?php echo $model->account_date * 1000;?>", "account_date":"<?php echo date('Y-m-d', $model->account_date)?>", "location":"<?php echo $model->location?>", 
"comment":"<?php echo $model->comment?>"}
