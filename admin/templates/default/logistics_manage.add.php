<?php defined('ShopMall') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>联合物流运单管理</h3>
      <ul class="tab-base">
         <li><a href="index.php?act=logistics&op=logistics_all"><span><?php echo '所有物流运单';?></span></a></li>
        <li><a href="index.php?act=logistics&op=truck_list"><span><?php echo '车辆管理';?></span></a></li>
	    <li><a href="index.php?act=logistics&op=logistics_setting"><span><?php echo '物流设置';?></span></a></li>
		<li><a  href="JavaScript:void(0);" class="current"><span><?php echo '新增物流运单';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="reason_info">配送要求:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea id="delivery_info" name="delivery_info"  rows="6" class="tarea"  style="width:400px">
车辆要求：
配送范围：
货物情况：
		</textarea></td>
          <td class="vatop tips">例如车辆要求，配送范围，货物情况等，方面接单商家了解配送情况 </td>
        </tr>
         <tr>  
		   <td colspan="2" class="required"><label class="validation" for="reason_info">添加承运车辆:</label></td>
        </tr>
       <tr class="noborder">
            <td colspan="2" class="vatop rowform"><label  style="padding-right:20px"  for="sort">承运车信息:</label>
			   <span id="truckInfo"></span>
		        <a href="javascript:void(0);" id="btn_show_search_truck" class="ncsc-btn ncsc-btn-acidblue">选择承运车辆</a>
                 <input id="tru_id" name="tru_id" type="hidden" value=""/>
				  <input id="store_id" name="store_id" type="hidden" value=""/>
				  <input id="store_name" name="store_name" type="hidden" value=""/>
				  <input id="truck_code" name="truck_code" type="hidden" value=""/>
                  <input id="Factor" name="Factor" type="hidden" value=""/>
			      <input id="Area" name="Area" type="hidden" value=""/>
		         <div id="div_search_goods" class="div-goods-select mt10" style="display: none;">
                  <table class="search-form">
              <tr>
                  <th class="w150">
                      <strong>第一步：搜索车辆登记信息</strong>
                  </th>
                  <td class="w160">
                      <select name="type"  id="type" >
            <option value="store_name" <?php if($_GET['type'] == 'store_name'){?>selected<?php }?>>商家名称</option>
            <option value="truck_name" <?php if($_GET['type'] == 'truck_name'){?>selected<?php }?>>所有人/身份证号</option>
            <option value="truck_code" <?php if($_GET['type'] == 'truck_code'){?>selected<?php }?>>车牌号</option>
            <option value="memo" <?php if($_GET['type'] == 'memo'){?>selected<?php }?>>运送范围</option>
			<option value="contact" <?php if($_GET['type'] == 'contact'){?>selected<?php }?>>联系人</option>
			<option value="contactphone" <?php if($_GET['type'] == 'contactphone'){?>selected<?php }?>>联系电话</option>
          </select><input type="text" class="text" name="key" id="key" value="<?php echo trim($_GET['key']); ?>" />
                  </td>
                  <td class="w70 tc">
                      <a href="javascript:void(0);" id="btn_search_goods" class="ncsc-btn"/><i class="icon-search"></i><?php echo $lang['nc_search'];?></a></td>
                    <td class="w10"></td>
                    <td>
                        <p class="hint"> </p>
                    </td>
                </tr>
            </table>
            <div id="div_goods_search_result" class="search-result" style="width:739px;"></div>
            <a id="btn_hide_search_goods" class="close" href="javascript:void(0);">X</a>
        </div>
		
			</td>
         </tr>
        <tr>
        <td colspan="2" class="required"><label class="validation" for="reason_info">费用情况:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><label  style="padding-right:20px"  for="sort">车辆运费:</label><input type="text" value="" name="order_amount"  id="order_amount" class="txt" readonly></td>
           <td class="vatop rowform"><label style="padding-right:20px"  for="sort">附加费:</label><input type="text" value="" name="extra_amount"  id="extra_amount" class="txt"></td>
        </tr>
		 
		 <tr>  
		   <td colspan="2" class="required"><label class="validation" for="reason_info">其他说明:</label></td>
        </tr>
        <tr class="noborder"> 
		 <td class="vatop " id="region"><label style="padding-right:20px"  for="sort">承运所在地区:</label><select class="class-select">
			</select>
			<input type="hidden" name="area_id_2" id="area_id_2" value="">&nbsp;
			<input type="hidden" name="area_info" id="area_info" value="" class="area_names" />&nbsp;
			<input type="hidden" name="area_id" id="area_id" value="" class="area_ids" />&nbsp;
			<span></span></td>
          <td class="vatop rowform"><label style="padding-right:20px"  for="sort">要求完成时间:</label><input class="txt date" type="text" value="" id="deliverytime" name="deliverytime"></td>
         
        </tr>
		
        	 <tr>  
		   <td colspan="2" class="required"><label class="validation" for="reason_info">添加承运订单:</label></td>
        </tr>
		
		 <tr class="noborder">
            <td colspan="2" class="vatop rowform"><label  style="padding-right:20px"  for="sort">承运订单信息:</label>
			   <span id="truckInfo"></span>
		        <a href="javascript:void(0);" id="btn_show_search_order" class="ncsc-btn ncsc-btn-acidblue">选择承运订单</a>
			
               <table class="table tb-type2 mtw">
      <thead class="thead">
         <tr>
          <th>单号</th>
		  <th>商品金额</th>
		  <th>客户名称</th>
          <th>箱积（立方米）</th>
          <th>重量（公斤）</th>
          <th class="align-center">物流单号</th>
		  <th>承担运费  <a href="javascript:void(0);" id="btn_calcOrderFee" class="ncsc-btn ncsc-btn-acidblue">核算承担运费</a></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="tr_model"   nc_type="order_model">
	<tr></tr>
	  </tbody>
	  </table>
		         <div id="div_search_order" class="div-goods-select mt10" style="display: none;">
                  <table class="search-form">
              <tr>
                  <th class="w150">
                      <strong>第一步：搜索派送订单</strong>
                  </th>
                  <td class="w160">
                      <select name="otype"  id="otype" >
            <option value="store_name" >商家名称</option>
            <option value="buyer_name" >客户名称</option>
            <option value="reciver_info">收货地址</option>
            <option value="order_sn" >订单编号</option>
			<option value="reciver_name">收货人姓名</option>
			<option value="reciver_info" >收货人电话</option>
          </select><input type="text" class="text" name="okey" id="okey" value="<?php echo trim($_GET['key']); ?>" />
                  </td>
                  <td class="w70 tc">
                      <a href="javascript:void(0);" id="btn_search_order" class="ncsc-btn"/><i class="icon-search"></i><?php echo $lang['nc_search'];?></a></td>
                    <td class="w10"></td>
                    <td>
                        <p class="hint"> </p>
                    </td>
                </tr>
            </table>
            <div id="div_order_search_result" class="search-result" style="width:739px;"></div>
            <a id="btn_hide_search_order" class="close" href="javascript:void(0);">X</a>
        </div>
		
			</td>
         </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
 <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 
<script  type="text/javascript"  src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
 <script  type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
 
<script>
 
$(function(){
   $('#btn_show_search_truck').on('click', function() {
        $('#div_search_goods').show();
    });

    $('#btn_hide_search_goods').on('click', function() {
        $('#div_search_goods').hide();
    });
	

 //搜索车型
    $('#btn_search_goods').on('click', function() {
        var url = "<?php echo urlAdmin('logistics', 'search_truck');?>";
          url += '&' + $.param({type: $('#type').val()});
		  url += '&' + $.param({key: $('#key').val()});
         $('#div_goods_search_result').load(url);
    });

    $('#div_goods_search_result').on('click', 'a.demo', function() {
        $('#div_goods_search_result').load($(this).attr('href'));
        return false;
    });

    //选择车型
    $('#div_goods_search_result').on('click', '[nctype="btn_add_groupbuy_goods"]', function() {
        var goods_commonid = $(this).attr('data-goods-commonid');
	 
        $.get('<?php echo urlAdmin('logistics', 'logisticstruck_info');?>', {truid: goods_commonid}, function(data) {
            if(data.result) {
 			     $('#store_id').val(data.store_id);
                 $('#store_name').val(data.store_name);
                 $('#truck_code').val(data.truck_code);
                 $('#tru_id').val(data.tru_id);
				 $('#Factor').val(data.Factor);
				 $('#Area').val(data.Area);
				 $('#order_amount').val(+data.shipping_fee);

				$('#truckInfo').html('     车牌号：'+data.truck_code+'     载重：'+data.Factor+'     箱积：'+data.Area+'     使用费：'+data.shipping_fee+'     联系方式：'+ data.contact+'（'+data.contactphone+'）');
                  $('#div_search_goods').hide();
            } else {
                showError(data.message);
            }
        }, 'json');
    });


 $('#btn_show_search_order').on('click', function() {
      if (($('#order_amount').val()!='')&&($('#order_amount').val()!='')){
        $('#div_search_order').show();
		}
		else{
          showError('请先添加承运车辆！');
   }});

    $('#btn_hide_search_order').on('click', function() {
        $('#div_search_order').hide();
    });
	
	
//搜索订单
  $('#btn_search_order').on('click', function() {
        var url = "<?php echo urlAdmin('logistics', 'search_order');?>";
          url += '&' + $.param({type: $('#otype').val()});
		  url += '&' + $.param({key: $('#okey').val()});
         $('#div_order_search_result').load(url);
		  removeorder();
    });

    $('#div_order_search_result').on('click', 'a.demo', function() {
        $('#div_order_search_result').load($(this).attr('href'));
        return false;
    });
   
 	
    //选择订单
    $('#div_order_search_result').on('click', '[nctype="btn_add_order"]', function() {
        var orderid= $(this).attr('data-order');
		if (isaddorder(orderid))
{
        $.get('<?php echo urlAdmin('logistics', 'logisticsorder_info');?>', {orderid: orderid}, function(data) {
            if(data.result) {
             var carry_rate = <?php echo isset($output['setting']['carry_rate'])?$output['setting']['carry_rate']:0;?>;
			 var ratio_limit = <?php echo isset($output['setting']['ratio_limit'])?$output['setting']['ratio_limit']:0;?>;
			 var anmount = data.goods_amount * (carry_rate/100).toFixed(2);
			 anmount = anmount >= ratio_limit ? ratio_limit : anmount;
			 var tr_model = '<tr class="hover edit">'+
	    '<td class="w48"><label  name="or_orderinfo[key][order_sn]"   id="or_orderinfo[key][order_sn]" >'+data.order_sn+'</label></td>'+
		'<td class="w48"><label  nc_type="goods_amount"   orderid="key"  name="or_orderinfo[key][goods_amount]"  id="or_orderinfo[key][goods_amount]"  >'+data.goods_amount+'</label></td>'+
		'<td class="w48"><label  name="or_orderinfo[key][buyer_name]"  id="or_orderinfo[key][buyer_name]" >'+data.buyer_name+'</label></td>'+
		'<td class="w48"><input type="text"   nc_type="change_area"    name="or_orderinfo[key][Area]" id="or_orderinfo[key][Area]"  value="0" /></td>'+
		'<td class="w48"><input type="text"   nc_type="change_factor"  name="or_orderinfo[key][Factor]"  id="or_orderinfo[key][Factor]" value="0" /></td>'+
	    '<td class="w48"><input type="text"  name="or_orderinfo[key][shipping_code]" id="or_orderinfo[key][shipping_code]"  value="'+data.shipping_code+'" /></td>'+
	    '<td class="w48"><input type="text"   nc_type="change_fee"  orderid="key"   name="or_orderinfo[key][shipping_fee]" id="or_orderinfo[key][shipping_fee]"  value="'+/*(data.goods_amount*2.5/100).toFixed(2)*/anmount+'" /></td>'+
 		'<td class="align-center w60"><a onclick="remove_tr($(this));" href="JavaScript:void(0);">移除</a></td>'+
	    '</tr>';
			$('#tr_model > tr:last').after(tr_model.replace(/key/g,data.order_id));
	    	$.getScript(RESOURCE_SITE_URL+"/js/admincp.js");
		
               } else {
                showError(data.message);
            }
        }, 'json');
		$(this).hide();
		}
		else
{
  showError("该订单已经添加过了哦");
}
    });

    $('#btn_calcOrderFee').on('click', function() {calcOrderFee();});
   $('#deliverytime').datepicker({dateFormat: 'yy-mm-dd'});

   regionInit("region");

	$("#submitBtn").click(function(){
        if($("#post_form").valid()){
	     	 calcOrderFee();
            $("#post_form").submit();
    	}
	});
	
	$("#post_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            delivery_info : {
                required : true
            },
			 deliverytime : {
                required : true
            },
			order_amount : {
                required : true,
				number:true
            },
			 extra_amount : {
              required : true,
				number:true
             },
			area_info : {
                required : true
            },
        },
        messages : {
            delivery_info : {
                required : "配送要求不能为空"
            },
			  deliverytime : {
                required : "要求完成时间不能为空"
            },
			order_amount: {
                required : "车辆运费不能为空",
				number: "车辆运费必须为数字",
            },
			extra_amount :{
                required : "附加费不能为空",
					number: "附加费必须为数字",
        },
	     area_info: {
             required : "商家所在区域不能为空"
         }
		},
	});
});
 
function remove_tr(o){
	o.parents('tr:first').remove();
	 removeorder();
}

function removeorder()
{
       $('a[nc_type="btn_add_order"]').each(function(){
 	   orderid= $(this).attr('data-order');
		$(this).show();
         $('label[nc_type="goods_amount"]').each(function(){
          orderid2= $(this).attr('orderid');
           if ( orderid2 == orderid) {$(this).hide();}
		});
	});
}

function isaddorder(orderid)
{
   var allowaorder=true;
     $('label[nc_type="goods_amount"]').each(function(){
          orderid2= $(this).attr('orderid');
           if ( orderid2 == orderid) { allowaorder= false;}
 	});
 	  return allowaorder;
}

function calcOrderFee() {
    if (($('#order_amount').val()!='')&&($('#extra_amount').val()!='')){
    var allTotal =   parseFloat($('#order_amount').val())+parseFloat($('#extra_amount').val());
	var percent=<?php echo $output['setting']['logistics_rate'];?>;
	var eachTotal = 0;
	var avgtotal=0;
	var num=0;
     $('label[nc_type="goods_amount"]').each(function(){
        orderid= $(this).attr('orderid');
         if ($(this).html().length > 0) {
        	eachTotal += parseFloat($(this).html()*percent/100);
			num+=1;
	    }
     });

	 if (allTotal>eachTotal)
     {
       avgtotal=parseFloat((allTotal-eachTotal)/num).toFixed(2);
     }
	 
    $('input[nc_type="change_fee"]').each(function(){
      var  orderid= $(this).attr('orderid');
	  var  sigamount=parseFloat($("#or_orderinfo\\["+orderid+"\\]\\[goods_amount\\]").html()*percent/100).toFixed(2);
            $(this).val(parseFloat(sigamount)+ parseFloat(avgtotal));
      });
  }
else
{
 showError("请先添加车辆运费和附加费用");
}
removeorder();
}
 
</script>
