<?php defined('ShopMall') or exit('Access Invalid!');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['special_detail']['special_title']; ?></title>
<meta name="keywords" content="<?php echo $output['special_detail']['special_title']; ?>" />
<meta name="description" content="<?php echo $output['special_detail']['special_title']; ?>" />


<style type="text/css">
#body { color: #333333; background-color: <?php echo $output['special_detail']['special_background_color'];?>; background-image: url(<?php echo getCMSSpecialImageUrl($output['special_detail']['special_background']);?>); background-repeat: <?php echo $output['special_detail']['special_repeat'];?>; background-position: top center; width: 100%; padding: 0; margin: 0; overflow: hidden;}
img { border: 0; vertical-align: top; }
.cms-special-detail-content { width: 100%; margin-top: <?php echo $output['special_detail']['special_margin_top']?>px; margin-right: auto; margin-bottom: 0; margin-left: auto; overflow: hidden;}
.special-content-link, .special-hot-point { text-align: 0; display: block; width: 100%; float: left; clear: both; padding: 0; margin: 0; border: 0; overflow: hidden;}
.special-content-link img{width:100%}
.special-content-goods-list { width: 1200px; margin: 0 auto; overflow: hidden;}
.special-content-goods-title { width: 1200px; margin: 0 auto; overflow: hidden;line-height:40px;border-bottom:solid 2px #e4393c; font-size:14px; }
.special-content-goods-title h1 {float:left;font-weight:normal;font-size:14px}
.special-content-goods-title em {float:right;display:inline-block; margin-right:10px; padding-right:30px; background:url('/shop/templates/default/images/shop/titledot.png') center right no-repeat;}
.special-content-goods-title1 { width: 1200px; margin: 0 auto; overflow: hidden;line-height:50px;background:url('/shop/templates/default/images/shop/title1.jpg') no-repeat; font-size:16px;color:#fff;font-weight:bold;height:90px;background-position:0 30px;padding-top:30px;padding-left:10px;}
.special-goods-list { background: #FFFFFF; width: 1188px; padding: 0 2px 0 0; overflow: hidden;}
.special-goods-list li { float: left; width: 160px; padding: 5px 30px; margin: 15px 5px 10px 12px;}
.special-goods-list dl { border: none; width: 160px; height: 60px; padding: 160px 0 0 0; position: relative; z-index: 1;}
.special-goods-list dt.name { font-size: 12px; line-height: 18px; height: 36px; margin: 2px; overflow: hidden;}
.special-goods-list dd.image { width: 160px; height: 160px; position: absolute; z-index: 1; top: 0; left: 0;}
.special-goods-list dd.image a { text-align: center; vertical-align: middle; display: table-cell; width:160px; height: 160px; overflow: hidden;}
.special-goods-list dd.image img { max-width: 160px; max-height: 160px; margin-top:expression(100-this.height/2);}
.special-goods-list dd.price {margin: 5px; color: #999;}
.special-goods-list dd.price em { font-weight: 600; color: #F30;}
</style>
</head>
<body>
<div class="cms-special-detail-content"><?php echo html_entity_decode($output['special_detail']['special_content']);?></div>
</body>
</html>
