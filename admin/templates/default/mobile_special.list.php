<?php defined('ShopMall') or exit('Access Invalid!');?>

<div class="page"> 
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $output['item_title'];?></h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"> <div class="title nomargin">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr>
        <td><ul>
            <li>点击右侧组件的<strong>“添加”</strong>按钮，增加对应类型版块到页面，其中<strong>“广告条版块”</strong>只能添加一个。</li>
            <li>鼠标触及左侧页面对应版块，出现操作类链接，可以对该区域块进行<strong>“移动”、“启用/禁用”、“编辑”、“删除”</strong>操作。</li>
            <li>新增加的版块内容默认为<strong>“禁用”</strong>状态，编辑内容并<strong>“启用”</strong>该块后将在手机端即时显示。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <div>
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg">列表</th>
        </tr>
        <tr class="thead">
          <th class="w12">&nbsp;</th>
          <th>专题编号</th>
          <th>专题描述</th>
          <th class="w200 align-center"><span>操作</span></th>
        </tr>
      	</thead>
      <tbody id="treet1">
        <tr class="hover" style="background: rgb(255, 255, 255);">
          <td>&nbsp;</td>
          <td>1</td>
          <td><span nc_type="edit_special_desc" column_id="1" title="可编辑" class="tooltip w270 editable">123456789</span></td>
          <td class="nowrap align-center"><a href="/admin/index.php?act=mb_special&amp;op=special_edit&amp;special_id=1">编辑</a>&nbsp;|&nbsp; <a href="javascript:;" nctype="btn_del" data-special-id="1">删除</a></td>
        </tr>
       　　　　<!-- 这个是添加 -->
        <tr style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
          <td colspan="20"><a id="btn_add_mb_special" href="javascript:;" class="btn-add marginleft">添加专题</a></td>
        </tr>
      </tbody>
            <tfoot>
        <tr class="tfoot">
          <td colspan="16"><div class="pagination"> <ul><li><span>首页</span></li><li><span>上一页</span></li><li><span class="currentpage">1</span></li><li><span>下一页</span></li><li><span>末页</span></li></ul> </div></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script>
	window.open("http://www.baidu.com/",'新开googleWin',"fullscreen=1")
</script>

