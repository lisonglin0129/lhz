<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>二级分类管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=mb_category&op=mb_category_list" ><span>返回上一级</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method='post' id="form_link">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>排序</th>
          <th>PC分类名称</th>
          <th>mobile分类名称</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      <?php if($output['data']){?>
      <?php foreach($output['data'] as $key => $value){?>
        <tr class="hover edit">
          <td><input type='text' id='<?php echo $value['gc_id'];?>' onblur='my(<?php echo $value['gc_id'];?>)' name='sort' value="<?php echo $value['sort']?>"/></td>
          <td><?php echo $value['pc_name']?></td>
          <td><input type='text' id='cate_name<?php echo $value['gc_id'];?>' name='cate_name' onblur='myname(<?php echo $value['gc_id'];?>)' value="<?php echo $value['cate_name']?>"/></td>
		  <td><a href='#' id='state<?php echo $value['gc_id'];?>' onclick='state(<?php echo $value['gc_id'];?>)' title='单击改变状态'><?php if($value['state'] == 1){echo '显示';}else{echo '隐藏';}?></a></td>
          <td><a href="index.php?act=mb_category&op=sunCategoryList&gc_id=<?php echo $value['gc_id']?>">查看子分类</a></td>
        </tr>
       <?php }?>
       <?php }else{?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
       <?php }?>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript">
	function my(id)
	{
		var sort = $("#"+id).val();
		if(sort == '')
		{
			$("#"+id).css('border','1px solid red');
		}else{
			$("#"+id).css('border','1px solid #CCC');
			MyAjax(id,sort,'','');
		}
	}
	function myname(id)
	{
		var cate_name = $("#cate_name"+id).val();
		if(cate_name == '')
		{
			$("#cate_name"+id).css('border','1px solid red');
		}else{
			$("#cate_name"+id).css('border','1px solid #CCC');
			MyAjax(id,'',cate_name,'');
		}	
	}

	function MyAjax(id,sort,cate_name,state)
	{
		$.ajax({
			type:'post',
			url:'index.php?act=mb_category&op=upd',
			data:{id,sort,cate_name,state},
			success:function(e)
			{
				if(e)
				{
					window.location.reload();
				}
			}
		});
	}

	function state(id)
	{
		if($('#state'+id).html()=='显示'){
			var state = 2;
		}else{
			var state = 1;
		}
		MyAjax(id,'','',state);
	}	
</script>
