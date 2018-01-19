<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['return_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=return&op=return_manage"><span><?php echo '待处理';?></span></a></li>
        <li><a href="index.php?act=return&op=return_all"><span><?php echo '所有记录';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_view'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><?php echo '商品名称'.$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['return']['goods_name']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
        
          <td class="vatop rowform"><?php echo ncPriceFormat($output['return']['refund_amount']); ?>&nbsp;
        <?php if($output['return']['is_admin_chcked']!=3){ ?>
          <a onclick="edit()">修改退款金额</a>
        <?php }?>
          </td>
           
          <td class="vatop tips"></td>
        </tr>
        <tr style="display:none" id="return_remount">
          <td ><input id="refund_amount" type="text" value=""></td>
          <td onclick="ajaxeditprice(<?php echo $output['return']['refund_id']; ?>)"><button>保存</button></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['return_buyer_message'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['return']['reason_info']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo '退货说明'.$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['return']['buyer_message']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo '凭证上传'.$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
        <?php if (is_array($output['pic_list']) && !empty($output['pic_list'])) { ?>
          <?php foreach ($output['pic_list'] as $key => $val) { ?>
          <?php if(!empty($val)){ ?>
          <a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/'.$val;?>" class="nyroModal" rel="gal">
            <img width="64" height="64" class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/'.$val;?>"></a>
          <?php } ?>
          <?php } ?>
        <?php } ?>
            </td>
          <td class="vatop tips"></td>
        </tr>
        <?php if($output['return']['is_admin_chcked'] >= 1) {  ?>
	        <tr>
	          <td colspan="2" class="required"><?php echo '平台审核';?></td>
	        </tr>
	        <tr class="noborder">
	          <td class="vatop rowform">
	           	<?php switch ($output['return']['is_admin_chcked']) {
	        		case 1 : {
	        			 echo '待审核';
	        			 break;
	        		}
	        		case 2 : {
	        			echo '待处理';
	        			break;
	        		}
	        		case 3 : {
	        			echo '该单已结束';
	        			break;
	        		}
	        		case 4 : {
	        			echo '已打款';
	        			break;
	        		}
	        	} ?>
	          </td>
	          <td class="vatop tips"></td>
	        </tr>
        <?php } ?>
         <tr>
          <td colspan="2" class="required"><?php echo '商家审核'.$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['state_array'][$output['return']['seller_state']];?></td>
          <td class="vatop tips"></td>
        </tr>
        
        <tr>
          <td colspan="2" class="required"><?php echo $lang['refund_seller_message'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['return']['seller_message']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['return']['seller_state'] == 2) { ?>
        <tr>
          <td colspan="2" class="required"><?php echo '平台确认'.$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['admin_array'][$output['return']['refund_state']];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['refund_message'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['return']['admin_message']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php } ?>
        <?php if($output['return']['is_admin_chcked'] == 1) { ?>
        <tr>
          <td colspan="2" class="required">审核是否通过</td>
        </tr>
	        <tr class="noborder">
	          <td class="vatop tips"><input type='radio' name='is_admin_chcked' checked value='2'>审核通过&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='is_admin_chcked' value='0'>不通过</td>
	        </tr>
	        <tr>
	          <td colspan="2" class="required">说明</td>
	        </tr>
	        <tr class="noborder">
	          <td class="vatop tips"><textarea rows="10" cols="60" name='admin_message'></textarea></td>
	        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" >
          		<a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a>
            <?php if($output['return']['is_admin_chcked'] == 1) { ?>
				<a id='sub' href="JavaScript:void(0);" class="btn"><span>确认</span></a>
				<script type="text/javascript" src='/js/lib.js'></script>
				<script type="text/javascript">
					$('#sub').click(function(){
						 var radio = get.Name('is_admin_chcked');
						 for(var i =0; i<radio.length; i++)
						 {
							 if(radio[i].checked)
							 {
								 var form = add.Dom(document.body,'form');
								 var input = add.Dom(form,'input');
								 var submit = add.Dom(form,'input');
								 var order_id = add.Dom(form,'input');
								 var admin_message = add.Dom(form,'input');
								 add.Attr(form,'action','/admin/index.php?act=return&op=view&return_id=<?php echo $output['return']['refund_id']; ?>');
								 add.Attr(form,'method','post');

								 add.Attr(input,'type','hidden');
								 add.Attr(input,'name','is_admin_chcked');
								 add.Attr(input,'value',radio[i].value);

								 add.Attr(order_id,'type','hidden');
								 add.Attr(order_id,'name','order_id');
								 add.Attr(order_id,'value', '<?php echo $output['return']['order_id']; ?>');

								 add.Attr(admin_message,'type','hidden');
								 add.Attr(admin_message,'name','admin_message');
								 add.Attr(admin_message,'value',get.Name('admin_message')[0].value);
								 
								 add.Attr(submit,'type','hidden');
								 add.Attr(submit,'name','form_submit');
								 add.Attr(submit,'value','ok');
								 form.submit();
							}
						 }
					})
				</script>
		    <?php } ?>
         </td>
        </tr>
      </tfoot>
    </table>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
$(function(){
    $('.nyroModal').nyroModal();
});
function edit()
{
  var return_remount = document.getElementById('return_remount');
  return_remount.style.display = 'block'; 
}
function ajaxeditprice(id)
{
  var refund_amount = document.getElementById('refund_amount').value;
  $.ajax({
    type:'post',
    url:"/admin/index.php?act=return&op=editPrice",
    data:{id:id,refund_amount:refund_amount},
    success:function(data)
    {
      location.reload();
    },
    error:function()
    {
      alert("异常");
    },
  });
}
</script>