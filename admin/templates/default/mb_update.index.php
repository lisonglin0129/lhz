<?php defined('ShopMall') or exit('Access Invalid!');?>
<style>
	.add_btn {float:right; font-size:17px; margin-right:10px; padding:10px 0px;}
</style>
<a class='add_btn' href="/admin/index.php?act=mb_update&op=add_app">添加</a>
<table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th>App名称</th>
          <th>版本名称</th>
          <th>应用系统</th>
          <th>添加时间</th>
          <th>类型</th>
          <th>推送</th>
        </tr>
      </thead>
      <tbody>
   
      	<?php if(count($output['vession']) <= 0) {?>
        <tr class="no_data" style="background: rgb(255, 255, 255);">
          <td colspan="10">没有符合条件的记录</td>
        </tr>
        
        <?php } else{ ?>
        	<?php foreach($output['vession'] AS $vessionList) { ?>
        	 	<tr>
        	 		<td></td>
        	 		<td><?php echo $vessionList['app_name']; ?></td>
        	 		<td><?php echo $vessionList['vession_name']; ?></td>
					<td><?php echo $vessionList['system_type'] == 1?'Android':'iphone'; ?></td>
        	 		<td><?php echo date("Y-m-d H:i:s",$vessionList['add_time']); ?></td>
        	 		<td><?php echo $vessionList['type'] == 1? '客户端':'商家版'; ?></td>
        	 		<td>
						<?php if($vessionList['is_upload'] == 1) { ?>
							<button onclick="sub_update('<?php echo $vessionList['id']; ?>',0)">否</button>
						<?php }else{ ?>
							<button onclick="sub_update('<?php echo $vessionList['id']; ?>',1)">是</button>
						<?php }?>
					</td>
        	 	</tr>
        	<?php } ?>
        <?php } ?>
      </tbody>
      <tfoot></tfoot>
</table>
<script type="text/javascript" src='/js/lib.js'></script>
    <script>
		function sub_update(id,option)
		{
			var dat = new Object();
			dat.id= id;
			dat.option = option;
			$.ajax({
				type:'post',
				data:dat,
				url:'/admin/index.php?act=mb_update&op=is_checked_vession',
				dataType:'json',
				success:function(e){
					if(e.code == 200) {
						set.reload();
					}
				}
			})
		}
	</script>