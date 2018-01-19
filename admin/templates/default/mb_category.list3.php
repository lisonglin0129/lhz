
<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>三级分类管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=mb_category&op=soneCategoryList&gc_id=<?php echo $output['result'][0]['gc_parent_id'];?>" ><span>返回上一级</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"> </div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd" style="background: rgb(255, 255, 255);">
        <th colspan="12" class="nobg"> <div class="title nomargin">
            <h5>操作提示</h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr class="odd" style="background: rgb(255, 255, 255);">
        <td><ul>
            <li>分类logo建议上传大小50*50px</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_link">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>排序</th>
          <th>mobile分类Logo</th>
          <th>PC分类名称</th>
          <th>mobile分类名称</th>
          <th>状态</th>
        </tr>
      </thead>
      <tbody>
      <?php if($output['data']){?>
      <?php foreach($output['data'] as $key => $value){?>
        <tr class="hover edit">
          <td><input type='text' id='<?php echo $value['gc_id'];?>' onblur='my(<?php echo $value['gc_id'];?>)' name='sort' value="<?php echo $value['sort']?>"/></td>
          <td><img src='<?php echo $value['source'];?>' onclick='img(<?php echo $value['gc_id'];?>)' <?php if($value['source']== ''){?>style='height:0px;'<?php }else{?>style='height:50px;'<?php }?>/><input style="display:<?php if($value['source'] != ''){echo 'none';}else{echo 'block';} ?>" id="img<?php echo $value['gc_id'];?>" accept="image/*,audio/*" name="logo" type="file"  gc_id="<?php echo $value['gc_id'];?>"/></td>
          <td><?php echo $value['pc_name']?></td>
          <td><input type='text' id='cate_name<?php echo $value['gc_id'];?>' name='cate_name' onblur='myname(<?php echo $value['gc_id'];?>)' value="<?php echo $value['cate_name']?>"/></td>
		  <td><a href='#' id='state<?php echo $value['gc_id'];?>' onclick='state(<?php echo $value['gc_id'];?>)' title='单击改变状态'><?php if($value['state'] == 1){echo '显示';}else{echo '隐藏';}?></a></td>
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
<script type="text/javascript"src='/js/lib.js'></script>
<script type="text/javascript"src='/wap/js/lrz.all.bundle.js'></script>
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

	function img(id)
    {
        $('#img'+id).click();

    }
    function sc(id)
    {
     file.upload({
            form:'banner', //form的id
            url:'index.php?act=mb_category&op=upload&gc_id='+id+"&img_id=img"+id,//
            dataType:'json',
            progress:function(ev) {
          
            },
            file:'img'+id, 
            success:function(e){
            	if(e)
				{
					window.location.reload();
				}
            }
        });
       
    }	

    $('input[name=logo]').on('change', function(){
        var id = $(this).attr('gc_id');
	    lrz(this.files[0],{width: 640}).then(function(rst){
	          $.ajax({
	        	   url:'index.php?act=mb_category&op=compress&gc_id='+id,
	               type: 'post',
	               data: {img:rst.base64},
	               dataType: 'json',
	               timeout: 20000,
	               success:function(e)
	               {
	            	   window.location.reload();
	               }
	           });
	               
	       })
	       .catch(function (err) {
	    	   window.location.reload();
	       })
	       .always(function () {
	    	   //window.location.reload();
	       });
	});
</script>
