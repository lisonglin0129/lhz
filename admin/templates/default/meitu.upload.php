<html>
	<head>
		<title>文件上传</title>
		<script type='text/javascript' src='/js/mt/init.js'></script>
		<style type="text/css">
		.upload {width:50%; height:350px; overflow: hidden; float:left;}
		.upload object{position:relative; bottom:30px;}
		.input{padding-top: 17px;  width: 500px; margin: 0 auto;}
		.right {float:left; width:40%; }
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
		<div class='upload' >
			<div id="mt"></div>
		</div>
		<div class='right'>
			<dl class='input' id='form'>
				<dt><span>名称</span></dt>
				<dd><input type='text' name='name'></dd>
				<dt><span>链接地址</span></dt>
				<dd><input type='text' name='link'></dd>
				<dt><span>是否开启</span></dt>
				<dd><span>开启</span><input type='radio' name='off' class='radio' value='1' checked><span>关闭</span><input type='radio' name='off' class='radio' value='0'></dd>
				<div style='clear: both;'></div>
				<dt><span>排序</span></dt>
				<dd><input type='text' name='sort'></dd>
			</dl>
		</div>
				<script type="text/javascript">
			window.onload=function(){
				setTimeout(function(){
					/*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
					xiuxiu.embedSWF("mt",8,"100%","380px");
					//修改为您自己的图片上传接口
					xiuxiu.setUploadURL("http://"+Host+"/admin/index.php?act=mobile_timplate&op=upload");
					xiuxiu.setUploadType(2);
					xiuxiu.setUploadDataFieldName("upload_file");
					xiuxiu.onInit = function ()
					{
						//xiuxiu.loadPhoto("/js/slider/img/01.jpg");
					
					}
					xiuxiu.onBeforeUpload = function (data, id)
					{
					  var size = data.size;
					  if(size > 2 * 1024 * 1024)
					  { 
					    alert("图片不能超过2M"); 
					    return false; 
					  }
					  var input =  get.Tag(get.Id('form'),'input');
					  var json  = "{";
					  for(var i = 0; i<input.length; i++)
					  {
						  if(input[i].type == 'radio')
						  {
							  if(input[i].checked){
								  json = json + input[i].name + ':"'+input[i].value+'",';
							  }
						  }
						  if(input[i].type == 'text')
						  {
							  if(input[i].value){
								  json = json + input[i].name + ':"'+input[i].value+'",'
							  }else {
								  json = json + input[i].name + ':"",';
							  }
						  }
				      }
					  json = json.substr(0,json.length-1);
					  json = json +"}";
				      var str_json = string.toJson(json);
					  xiuxiu.setUploadArgs(str_json,id);
					  return true; 
					}
					/* xiuxiu.onDebug = function (data)
					{
						alert("错误响应" + data);
					} */
					xiuxiu.onUploadResponse = function (data) 
					{
						var json = string.toJson(data);
						if(json.code == 'SUCCESS')
						{
							var index = parent.layer.getFrameIndex(window.name);
							parent.layer.close(index);
							parent.$('#banner').prepend('<li><img src="'+json.img_path+'"></li>');
						}
					}
				},2000)
			
			}
		</script>
	</body>
</html>

