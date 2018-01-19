<?php defined('ShopMall') or exit('Access Invalid!');?>
<div class="fixed-bar">
    <div class="item-title">
      <h3><a href="index.php?act=mobile_catgroy&op=catgroy">分类管理</a></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>列表</span></a></li>
      </ul>
    </div>
  </div>
 <div style="float:left;width:60%;">
	<table class="table tb-type2 nobdb">
	    <thead>
	      	<tr class="thead">
	        	<th class="align-center">分类名称</th>
	        	<th class="align-center">分类logo</th>
	        	<th class="align-center">状态</th>
	        	<th class="align-center">操作</th>
	      	</tr>
	    </thead>
	    <tbody>
	    <?php if($output['data']){ ?>
	    <?php foreach($output['data'] as $v){?>
	      	<tr class="hover">
	        	<td class="align-center" id="catgroy_name"><?php echo $v['catgroy_name'];?><input id="upd_name" style="display:none;" type="text" name="" value="<?php echo $v['catgroy_name'];?>"/></td>

	        	<td class="align-center">
	        		<img style="width:50px;" id="image" name="image" src="<?php echo UPLOAD_SITE_URL?>/admin/mobile/<?php echo $v['catgroy_logo'];?>">
	        		<input onchange="fileSelected(1)"  type="file" name="logo" value="" style="display:none;"accept="image/*" id="inputfile"  />
	        	</td>
	        	<td class="align-center"><?php if($v['catgroy_state'] == 1){ echo '显示';}else{ echo '隐藏';}?></td>
	        	<td class="align-center">
	        	<a href="index.php?act=mobile_catgroy&op=upd&mobile_catgroy_id=<?php echo $v['mobile_catgroy_id'];?>">修改</a> <a href="index.php?act=mobile_catgroy&op=del&mobile_catgroy_id=<?php echo $v['mobile_catgroy_id'];?>">删除</a>
	        	</td>
	      	</tr>
	    <?php }?>
	    <?php }else{?>
	      	<tr class="no_data">
	        	<td colspan="15"><?php echo $lang['nc_no_record'];?>&nbsp;&nbsp;&nbsp;&nbsp;添加分类</td>
	      	</tr>
	    <?php }?>
	    </tbody>
	    <tfoot>
	      	<tr class="tfoot">
	        	<td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
	      	</tr>
	    </tfoot>
	</table>
</div>
  	<botton style="float:left;height:20px;width:50px;background-color:#CCC;margin-left:10px;margin-top:20px;"><a href="index.php?act=mobile_catgroy&op=add">添加分类</a></botton>
  	<div style="margin-left:5%;float:left;width:30%;height:500px;background-color:green;">手机预览</div>