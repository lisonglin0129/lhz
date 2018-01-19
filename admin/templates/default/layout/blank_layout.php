<?php defined('ShopMall') or exit('Access Invalid!');?>
<!doctype html>
<html><head>
 <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
</head>
<body>
<?php 
	require_once($tpl_file);
?>
</body>
</html>