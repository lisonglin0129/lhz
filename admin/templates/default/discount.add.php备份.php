<?php defined('ShopMall') or exit('Access Invalid!');?>
<style>
	.box {height:572px; width:100%; overflow-y: scroll;}
	#sd_goods{height:572px; width:100%; overflow-y: scroll;}
	.goods {width:130px;   float:left; margin-left:13px; margin-top:13px;}
	.goodsImage {width:130px; height:130px;  border:1px solid #FFF;}
	.goodsImage_click {width:130px; height:130px;  border:1px solid #FF0000;}
	.goodsname {margin-top:10px;}
</style>
<script type="text/javascript" src='/js/lib.js'></script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=discount&op=discount"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2">
          	<label class="validation" for="activity_title">优惠券名称:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="waybill_name" name="waybill_name" class="txt"></td>
          <td class="vatop tips">优惠券名称，最多10个字</td>
        </tr>
        <tr class="noborder">
          <td colspan="2">
          	<label class="validation" for="activity_title">类型:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          	 <select name="waybill_express">
			      <option value="1">优惠券</option>
			      <option value="2">折扣券</option>
			 </select>
          </td>
          <td class="vatop tips">优惠券类别</td>
        </tr>
        <tr>
          <td colspan="2" class="required">
         	 <label class="validation" >开始时间:</label>
         </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
        	  <input type="text" id="activity_start_date" name="activity_start_date" class="txt date"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required">
         	 <label class="validation" >结束时间:</label>
         </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          	<input type="text" id="activity_end_date" name="activity_end_date" class="txt date"/></td>
          	<td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2">
          	<label class="validation" for="activity_title">金额:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
         	 <input type="text" id="amount" name="amount" class="txt">
          </td>
          <td class="vatop tips">金额0~9999</td>
        </tr>
        <tr class="noborder">
          <td colspan="2">
          	<label class="validation" for="activity_title">金额上限:</label>
         </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
         	 <input type="text" id="max_amount" name="max_amount" class="txt">
          </td>
          <td class="vatop tips">兑换商品累计上限0~9999则不可以使用</td>
        </tr>
        <tr class="noborder">
          <td colspan="2">
          	<label class="validation" for="activity_title">金额下限:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
         	 <input type="text" id="min_amount" name="min_amount" class="txt">
          </td>
          <td class="vatop tips">购买商品累计金额下限达到0~9999</td>
        </tr>
        <tr class="noborder">
          	<td colspan="2">
          		<label class="validation" for="activity_title">总数量:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
         	 <input type="text" id="number" name="number" class="txt">
          </td>
          <td class="vatop tips">总共发放数量（单位张）</td>
        </tr>
        <tr class="noborder">
          	<td colspan="2">
          		<label class="validation" for="activity_title">使用数量上限:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
         	 <input type="text" id="max_number" name="max_number" class="txt">
          </td>
          <td class="vatop tips">每个用于所使用的数量上限，0就是无上限</td>
        </tr>
        <tr class="noborder">
          	<td colspan="2">
          		<label class="validation" for="activity_title">领取数量上限:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
         	 <input type="text" id="max_ceiling" name="max_ceiling" class="txt">
          </td>
          <td class="vatop tips">每个用户可以领，0就是无上限</td>
        </tr>
        <tr class="noborder">
          	<td colspan="2">
          		<label class="validation" for="activity_title">	使用有效规格:</label>
          	</td>
        </tr>
        <tr class="noborder">
          <td id='cat' class="vatop rowform" style='width:80%;'>       			
          </td>
          <td><input type='button' id='seach' value='查找'></td>
        </tr>
         <tr class="noborder">
         	<td class="vatop rowform" style='width:80%;'>
         		<div id='goods' class='box' style='display:none;'>
         		
         		</div>
         	</td>
         	 <td  class="vatop rowform" style='vertical-align:top'>
	          	<div id='sd_goods' style='display:none;'>
	          		
	          	</div>
	         </td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" >活动图片:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform type-file-box">
              <input type="file" class="type-file-file" id="activity_banner" name="customimg" size="30" hidefocus="true"  nc_type="upload_activity_banner" title="<?php echo $lang['activity_index_banner'];?>">
          </td>
          <td class="vatop tips"><?php echo $lang['activity_new_banner_tip'];?></td>
        </tr>
        <tr style="display:none;">
          <td colspan="2" class="required"><label><?php echo $lang['activity_new_style'];?>:</label></td>
        </tr>
        <tr class="noborder" style="display:none;">
          <td class="vatop rowform"><select id="activity_style" name="activity_style">
              <option value="default_style"><?php echo $lang['activity_index_default'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_style_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_desc"><?php echo $lang['activity_new_desc'];?>:</label></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"  for="activity_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_sort" name="activity_sort" class="txt" value="0"></td>
          <td class="vatop tips"><?php echo $lang['activity_new_sort_tip1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_sort"><?php echo $lang['activity_openstate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="activity_state1" class="cb-enable selected" ><span><?php echo $lang['activity_openstate_open'];?></span></label>
            <label for="activity_state0" class="cb-disable"><span><?php echo $lang['activity_openstate_close'];?></span></label>
            <input id="activity_state1" name="activity_state" checked="checked" value="1" type="radio">
            <input id="activity_state0" name="activity_state" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/jquery.ui.js";?>"></script> 
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script> 
<script>
get.Id("submitBtn").onclick  = function()
{
	var str_json = '{"';
	images = get.Tag(get.Id('sd_goods'),'img');
	for(var k = 0; k<images.length; k++)
	{
		str_json  =  str_json + 'goods_id":"'+images[k].alt+'"},{"';
	}
	stringJson = '['+str_json.substr(0,str_json.length-3) +']';
	var inp = add.Dom(this,'input');
	add.Attr(inp,'type','hidden');
	add.Attr(inp,'value',string.base64encode(stringJson));
	add.Attr(inp,'name','postData');
	get.Id("add_form").submit();
	
}
	//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
	}
	});
});
$(document).ready(function(){
	$("#activity_start_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#activity_end_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	amount:{
        		required : true
            },
        	waybill_name:{
        		required : true
            },
        	activity_title: {
        		required : true
        	},
        	activity_start_date: {
        		required : true,
				date     : false
        	},
        	activity_end_date: {
        		required : true,
				date      : false
        	},
        	activity_banner: {
        		required: false,
				accept : 'png|jpeg|gif'	
			},
        	activity_sort: {
        		required : true,
        		min:0,
        		max:255
        	},
        	max_amount:{
        		required: true,
            },
            min_amount:{
            	required: true,
            }
            ,
            number:{
            	required: true,
            },
            min_amount:{
            	required: true,
            },
            max_number:{
				required:true,
            }
        },
        messages : {
        	max_number:{
        		required : '使用数量上限不能为空'
            },
        	number:{
        		required : '总数量不能为空'
           	},
        	max_amount:{
        		required : '金额不能为空'
            },
            min_amount:{
            	required : '金额上限不能为空'
            },
            amount:{
            	required : '金额下限不能为空'
       		},
        	waybill_name: {
        		required : '名字不能为空'
        	},
        	activity_title: {
        		required : '<?php echo $lang['activity_new_title_null'];?>'
        	},
        	activity_start_date: {
        		required : '<?php echo $lang['activity_new_startdate_null'];?>'
        	},
        	activity_end_date: {
        		required : '<?php echo $lang['activity_new_enddate_null'];?>'
        	},
			activity_banner: {
        		required : '<?php echo $lang['activity_new_banner_null'];?>',
				accept   : '<?php echo $lang['activity_new_ing_wrong'];?>'	
			},
        	activity_sort: {
        		required : '<?php echo $lang['activity_new_sort_null'];?>',
        		min:'<?php echo $lang['activity_new_sort_minerror'];?>',
        		max:'<?php echo $lang['activity_new_sort_maxerror'];?>'
        	}
        }
	});


		
});
get.Id('seach').onclick = function()
{
	var set = get.Tag(get.Id('cat'),'select');
	var JSON = '{"';
	var dat = new Object();
	
	for(var i = 0; i<set.length; i++)
	{
		var gc = "gc_id_"+(i+1);
		JSON = JSON + gc +'":"' + set[i].value + '","';		
	}
	JSON = JSON.substr(0,JSON.length-2) + '}';
	dat.data = string.base64encode(JSON);
	get.Id("goods").style.display = 'block';
	var goodsImage;
	var p;
	var rightDiv;
	var href;
	$.ajax({
		type:'post',
		url:'/admin/index.php?act=discount&op=selectCat&type=goods',
		data:dat,
		success:function(e)
		{
			var div;
			jsonstr = string.toJson(string.base64decode(e));
			get.Id("goods").innerHTML = '';
			for(var j in jsonstr)
			{
				div 		= add.Dom(get.Id("goods"),'div');
				goodsImage  = add.Dom(div,'img');
				p 			= add.Dom(div,'p');
				p2			= add.Dom(div,'p');
				add.Attr(goodsImage,'src',jsonstr[j].goods_image);
				add.Attr(goodsImage,'alt',jsonstr[j].goods_id);
				add.Attr(goodsImage,'class','goodsImage');
				add.Attr(div,'class','goods');
				add.Attr(p,'class','goodsname');
				add.Attr(p2,'class','goodsname');
				p.innerHTML = jsonstr[j].goods_name;
				p2.innerHTML = jsonstr[j].goods_barcode;
			}
			var image = get.Tag(get.Id("goods"),'img');
			
			for(var i=0; i<image.length; i++)
			{
				(function(index){
					
					image[i].onclick = function()
					{
						get.Id("sd_goods").style.display = 'block';
						this.className = this.className == 'goodsImage_click'?'goodsImage':'goodsImage_click';
						if(this.className == 'goodsImage_click') {
							var goodsDiv = get.Tag(get.Id("goods"),'div');
							rightDiv = add.Dom(get.Id("sd_goods"),'div');
							add.Attr(rightDiv,'class','goods');
							rightDiv.innerHTML = goodsDiv[index].innerHTML;
							href = add.Dom(rightDiv,'a');
							add.Attr(href,'href','javascript:void(0)');
							href.innerHTML = '删除';
							href.onclick = function ()
							{
								this.parentNode.parentNode.removeChild(this.parentNode);
							}
						}
					}
				})(i)
			
			}
		}
	});
}
$.ajax({
	type:'get',
	url:'/admin/index.php?act=discount&op=selectCat',
	success:function(e)
	{
		
		var cat = "";
		var json = string.toJson(string.base64decode(e));
		var select = add.Dom(get.Id('cat'),'select');
		for(cat in json)
		{
			var option = add.Dom(select,'option');
			add.Attr(option,'value',json[cat].gc_id);
			set.html(option,json[cat]['gc_name']);
		}
		
		get.Id(select).onchange = function()
		{
			//--一级分类
			$.ajax({
				type:'post',
				url:'/admin/index.php?act=discount&op=selectCat',
				data:{'cat_id':this.value,'cat':'1'},
				success:function(e)
				{
					var cat_2 = string.toJson(string.base64decode(e));
					if(get.Id('select2') == null) {
						var select2 = add.Dom(get.Id('cat'),'select');
						add.Attr(select2,'id','select2');
						var i = 0;
						for(cattemp in cat_2)
						{
							var option2 = add.Dom(select2,'option');
							if(i == 0){
								set.html(option2,'--请选择分类--');
								add.Attr(option2,'value','');
							}else {
								set.html(option2,cat_2[cattemp]['gc_name']);
								add.Attr(option2,'value',cat_2[cattemp].gc_id);
							}
							i++;
						}
					}else {
						set.html(get.Id('select2'),'');
						var i = 0;
						for(cattemp in cat_2)
						{
							var option2 = add.Dom(get.Id('select2'),'option');
							if(i == 0){
								set.html(option2,'--请选择分类--');
								add.Attr(option2,'value','');
							}else {
								add.Attr(option2,'value',cat_2[cattemp].gc_id);
								set.html(option2,cat_2[cattemp]['gc_name']);
							}
							i++;
						}
					}
					//--二级分类
					get.Id('select2').onchange = function()
					{
						$.ajax({
							type:'post',
							url:'/admin/index.php?act=discount&op=selectCat',
							data:{'cat_id':this.value,'cat':'1'},
							success:function(e){
								//--三级分类
								var cat_3 = string.toJson(string.base64decode(e));
								if(cat_3.length <= 1)
								{
									return ;
								}
								if(get.Id('select3') == null) {
									var select3 = add.Dom(get.Id('cat'),'select');
									add.Attr(select3,'id','select3');
									var i = 0;
									for(cattemp in cat_3)
									{
										var option3 = add.Dom(select3,'option');
										if(i == 0){ 
											set.html(option3,'--请选择分类--');
											add.Attr(option3,'value','');
										}else {
											add.Attr(option3,'value',cat_3[cattemp].gc_id);
											set.html(option3,cat_3[cattemp]['gc_name']);
										}
										i++;
									}
								}else {
									set.html(get.Id('select3'),'');
									var i = 0;
									for(cattemp in cat_3)
									{
										var option3 = add.Dom(get.Id('select3'),'option');
										if(i == 0){ 
											set.html(option3,'--请选择分类--');
											add.Attr(option3,'value','');
										}else {
											add.Attr(option3,'value',cat_3[cattemp].gc_id);
											set.html(option3,cat_3[cattemp]['gc_name']);
										}
										i++;
									}
								}
							}
						});
							
					}
				}
			})
		}
	}
	
})

$(function(){
// 模拟活动页面横幅Banner上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#activity_banner");
    $("#activity_banner").change(function(){
	$("#textfield1").val($("#activity_banner").val());
    });
});
</script> 