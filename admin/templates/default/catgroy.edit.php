<html>
  <head>
    <title>修改分类</title>
    <script type='text/javascript' src='/js/mt/init.js'></script>
    <style type="text/css">
    .upload {width:50%; height:350px; overflow: hidden; float:left;}
    .upload object{position:relative; bottom:30px;}
    .input{padding-top: 17px;  width: 500px; margin: 0 auto;}
    .right {float:left; width:10%; }
    .input dd , .input dt { margin-top:18px; float:left; margin-left:20px;}
    .input dt span{ font-size:20px; display:block; width:82px; line-height:35px;}
    .input dd input {width:300px; height:35px;}
    .input dd  .radio {width:22px; margin-left:5px; float:left;}
    .input dd span{line-height: 44px;  margin-left:12px;  float:left;}
    .textarea {width:300px; min-height:150px;}
    </style>
    <script type="text/javascript" src='/js/lib.js'></script>
  </head>
  <body>
    <div class='right'>
      <dl class='input' id='form'>
        <form method="post" action="/admin/index.php?act=mobile_catgroy&op=update">
          <dt><span>名称</span></dt>
          <dd><input type='text' name='name' value='<?php if($output['data']){echo $output['data']['catgroy_name'];}?>'></dd>
          <dt><span>链接地址</span></dt>
          <dd><input type='text' name='url' value='<?php if($output['data']){echo $output['data']['url'];}?>'></dd>
          <dt><span>是否开启</span></dt>
          <?php if($output['data'] && $output['data']['catgroy_state'] == 1){?>
          <dd><span>开启</span><input type='radio' name='catgroy_state' class='radio' value='1' checked><span>关闭</span><input type='radio' name='catgroy_state' class='radio' value='0'></dd>
          <?php }else{?>
          <dd><span>开启</span><input type='radio' name='catgroy_state' class='radio' value='1'><span>关闭</span><input type='radio' name='catgroy_state' class='radio' value='0' checked></dd>
          <?php }?>
          <div style='clear: both;'></div>
          <dt><span>排序</span></dt>
          <dd><input type='text' name='sort' value='<?php if($output['data']){echo $output['data']['sort'];}?>'></dd>
          <dt><span></span></dt>
          <input type="hidden" name='id' value="<?php echo $output['data']['mobile_catgroy_id'];?>" />
          <dd onclick="tj()"><input type='submit' id='tj' value='修改'></dd>
        </form>
      </dl>
    </div>
    <script type="text/javascript">
    //单击事件先提交form然后关闭显示框
    function tj()
    {
      setTimeout(function(){
        var index = parent.layer.getFrameIndex(window.name);
      parent.layer.close(index);
      },300);
    }
    </script>
  </body>
</html>

