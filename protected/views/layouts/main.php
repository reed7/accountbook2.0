<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->pageTitle?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>

<?php switch($this->innerPage){
	case Controller::PAGE_LOGIN:?>
	<link rel="stylesheet" href="/accountbook/css/login.css" type="text/css"></link>
	<?php 
	break;
	case Controller::PAGE_STATISTIC :
	?>
	<link rel="stylesheet" href='/accountbook/css/statistic.css' type="text/css"></link>
	<link rel="stylesheet" href="/accountbook/css/account_book.css" type="text/css"></link>
	<link rel="stylesheet" href="/accountbook/css/account_item_detail.css" type="text/css"></link>
	<?php 
	break;
	default : ?>
	<link rel="stylesheet" href="/accountbook/css/account_book.css" type="text/css"></link>	
	<link rel="stylesheet" href="/accountbook/css/account_item_detail.css" type="text/css"></link>
	<link rel="stylesheet" href="/accountbook/css/statistic_time_range.css" type="text/css"></link>	
	<link rel="stylesheet" href="/accountbook/assets/b53eeb24/jui/css/base/jquery-ui.css" type="text/css" ></link>
	
	<script type="text/javascript" src="/accountbook/assets/b53eeb24/jquery.js"></script>
	<script type="text/javascript" src="/accountbook/assets/b53eeb24/jui/js/jquery-ui.min.js"></script>
<?php }// end switch?>

<script type="text/javascript" src="/accountbook/js/main.js"></script>
</head>
<body>
<?php echo $content;?>
</body>
</html>