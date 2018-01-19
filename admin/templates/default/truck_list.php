<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>联合物流运单管理</h3>
      <ul class="tab-base">
          <li><a href="index.php?act=logistics&op=logistics_all" ><span><?php echo '所有物流运单';?></span></a></li>
        <li><a href="index.php?act=logistics&op=truck_list" class="current"><span><?php echo '车辆管理';?></span></a></li>
					    <li><a href="index.php?act=logistics&op=logistics_setting"><span><?php echo '物流设置';?></span></a></li>

		<li><a href="index.php?act=logistics&op=add_logistics"><span><?php echo '新增物流运单';?></span></a></li>

      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="logistics" />
    <input type="hidden" name="op" value="truck_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><select name="type">
            <option value="store_name" <?php if($_GET['type'] == 'store_name'){?>selected<?php }?>>商家名称</option>
            <option value="truck_name" <?php if($_GET['type'] == 'truck_name'){?>selected<?php }?>>所有人/身份证号</option>
            <option value="truck_code" <?php if($_GET['type'] == 'truck_code'){?>selected<?php }?>>车牌号</option>
            <option value="memo" <?php if($_GET['type'] == 'memo'){?>selected<?php }?>>运送范围</option>
			<option value="contact" <?php if($_GET['type'] == 'contact'){?>selected<?php }?>>联系人</option>
			<option value="contactphone" <?php if($_GET['type'] == 'contactphone'){?>selected<?php }?>>联系电话</option>
          </select></th>
        <td><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
          <th><label for="add_time_from"><?php echo '入库时间';?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from">
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to"/></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>商家提交的车辆信息。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
	   <th class="w90">商家名称</th>
        <th class="w90">车牌号</th>
       <th class="w90">车型/品牌</th>
       <th class="w90">载重（公斤）</th>
	   <th class="w90">箱积（立方米）</th>
	   <th class="w150">运货区域</th>
	  <th class="w150">联系人</th>
	  <th class="w150">联系方式</th>
	   <th >状态</th>
	    <th class="align-center"><?php echo $lang['nc_handle'];?></th>

       </tr>
    </thead>
    <tbody>
       <?php if(!empty($output['truck_list']) && is_array($output['truck_list'])){?>
    <?php foreach($output['truck_list'] as $key=>$address){?>
		<tr class="bd-line">
     <td> <?php echo $address['store_name'];?></td>
	 <td> <?php echo $address['truck_code'];?></td>
      <td><?php echo $address['truck_type'];?>/<?php echo $address['truck_brand'];?></td>
      <td ><?php echo $address['Factor'];?></td>
	 <td ><?php echo $address['Area'];?></td>
	  <td ><?php echo $address['memo'];?></td>
	 <td > <?php echo $address['contact'];?></td>
	 <td > <?php echo $address['contactphone'];?></td>
      <td><?php echo $output['truestate_array'][ $address['truck_state']];?></td>
      <td class="nscs-table-handle align-center"><span> <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=logistics&op=truck_del&tru_id=<?php echo $address['tru_id'];?>'}" class="btn-red">
        <p><?php echo $lang['nc_del'];?></p>
        </a></span></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
    </tbody>
   
      <?php if (is_array($output['truck_list']) && !empty($output['truck_list'])) { ?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script> 


<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
});
</script>
