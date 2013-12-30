<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>更换头像</title>
	<link rel="stylesheet" href="<?php echo C('__PUBLIC__')?>css/common.css" />
	<link rel="stylesheet" href="<?php echo RUN_URL?>Extend/Org/js/Uploadify/uploadify.css" />
	<link rel="stylesheet" href="<?php echo RUN_URL?>Extend/Org/js/Jcrop/jquery.Jcrop.css" />
	<script src="<?php echo RUN_URL?>Extend/Org/js/Jquery/jquery-1.10.2.min.js"></script>
	<script src="<?php echo RUN_URL?>Extend/Org/js/Uploadify/jquery.uploadify.min.js"></script>
	<script src="<?php echo RUN_URL?>Extend/Org/js/Jcrop/jquery.Jcrop.min.js"></script>

	<style>
		/*.wrapper{width:960px;margin:0 auto;}*/
		.uploadify .uploadify-button {
			font-size: 12px;
			height:30px;
			line-height: 30px;
			text-align: right;
		}
		.uploadify span{margin-right: 7px;}
		.uploadify:hover .uploadify-button {
			background-position: 0 -30px;
			color:#fff;
		}
		.uploadify-queue{display: none;}
		.avatar_crop{width:960px;margin:0 auto;margin-top:30px;}
		
		.avatar_crop ul li{float:left;margin-right:20px;text-align: center;line-height: 24px;}
		#img_300,#img_180,#img_100,#img_50{border:1px solid #ccc;overflow: hidden;float:left;margin:0 20px;}
		#img_300{width:300px;height:300px;position: relative;}
		#img_180{width:180px;height:180px;}
		#img_100{width:100px;height:100px;}
		#img_50{width:50px;height:50px;}
		.loading{position: absolute;left:142.5px;top:142.5px;display: none;}
		button{background:linear-gradient(#f3b94f,#FDA708,#f3b94f);border-radius: 3px;color:#fff;text-shadow:1px 1px 3px rgba(0,0,0.8);}
		button:hover{text-shadow:1px 1px 3px #ccc;}
	</style>

	<script>
		$(function(){
			$('#file_upload').uploadify({
				'buttonImage' : '<?php echo C("TPL_PUBLIC")?>images/upload.png',
				'buttonText' : '选择上传',
				'swf'      : '<?php echo RUN_URL?>Extend/Org/js/Uploadify/uploadify.swf',
				'uploader' : '?c=member&m=upload',
				'width':'82',
				'fileTypeExts' : '*.gif; *.jpg; *.jpeg; *.png',
				'fileSizeLimit':'2048',
				'onUploadStart':function(){
				// console.log('readyUpload');
				$('.loading').show();
			},
			'onUploadSuccess' : function(file,data) {
				if(data=='error')return;
				$('.loading').hide();
				$('img:not(".loading")').attr('src',data);
				$('[name=sImg]').val(data);//表单input元素隐藏图片地址
				$('.img_300').Jcrop({
					onChange: updatePreview,
					onSelect: updatePreview,
					aspectRatio:1,
					boxWidth:300,
					boxHeight:300,
					bgColor:'white'
				},function(){
					jcrop_api = this;
					dim = jcrop_api.getBounds();//利用api获取图片实际宽度、高度。
					dims = jcrop_api.getWidgetSize();//利用api获取图片在画布中的宽度、高度。
					sizeRatio=jcrop_api.getScaleFactor();//图片缩放比例
					$s=180*sizeRatio[0];//选框大小
					if(dim[0]<$s)$s=dim[0];
					if(dim[1]<$s)$s=dim[1];
					jcrop_api.setSelect(getCoord());//设置初始化时选框
					$('.jcrop-holder').css({'left':(300-dims[0])/2,'top':(300-dims[1])/2});//让上传的图片居中显示
				})
				function getCoord(){//获取初始化是选框坐标
					x1=(dim[0]-$s)/2;
					y1=(dim[1]-$s)/2;
					x2=(dim[0]-$s)/2+$s;
					y2=(dim[1]-$s)/2+$s;
					return [x1,y1,x2,y2];
				}
				function updatePreview(c){
					$('#x').val(c.x);
					$('#y').val(c.y);
					$('#w').val(c.w);
					$('#h').val(c.h);
					var arr=[180,100,50];//图像大小
					for (var i = 0; i < arr.length; i++) {
						var rx=arr[i]/c.w;
						$('.img_'+arr[i]).css({//改变图片宽、高等样式
							width:Math.round(dim[0]*rx),
							height:Math.round(dim[1]*rx),
							marginLeft:'-'+ Math.round(c.x*rx) +'px',
							marginTop:'-'+ Math.round(c.y*rx) +'px',
						})
					}
				}
			}
		})
})
</script>
</head>
<body>
	<div class="avatar_crop">
		<input type="file" name="file_upload" id="file_upload" />
		<div style="height:30px;"></div>
		<ul class="clearfix">
			<li>
				<div id="img_300">
					<img src="<?php echo C('TPL_PUBLIC')?>images/up_bg.gif" class="img_300" alt="">
					<img src="<?php echo C('TPL_PUBLIC')?>images/loading.gif" class="loading" alt="">
				</div>
			</li>
			<li>
				<div id="img_180">
					<img src="<?php echo $_data['me']['avatar']?>?>" class="img_180" alt="" width="180">
					<p>大尺寸头像,180*180像素</p>
				</div>
			</li>
			<li>
				<div id="img_100">
					<img src="<?php echo $_data['me']['avatar']?>" class="img_100" alt="" width="100">
					<p>中尺寸头像,100*100像素（自动生成）</p>
				</div>
			</li>
			<li>
				<div id="img_50">
					<img src="<?php echo $_data['me']['avatar']?>" class="img_50" alt="" width="50">
					<p>50*50</p>
				</div>
			</li>
		</ul>
		
		<form action="?c=member&amp;m=crop" method="post">
			<input type="hidden" id="x" name="x">
			<input type="hidden" id="y" name="y">
			<input type="hidden" id="w" name="w">
			<input type="hidden" id="h" name="h">
			<input type="hidden" name="sImg">
			<p style="text-align:center;"><button>确 定</button></p>
		</form>
	</div>
</body>
</html>