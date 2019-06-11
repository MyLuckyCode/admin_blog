<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理</title>
	<meta http-equiv="refresh" content="1;url={$url}" >
	<link rel="stylesheet" href="view/admin/style/basic.css">
	<link rel="stylesheet" href="view/admin/style/succ.css">
</head>
<body>
	
<h2>成功--提示页</h2>


<div id="list" class="succ">
{foreach from=$message key=key item=value}
	<p>{$key}.{$value}</p>
{/foreach}
<p><a href="{$url}">[如果浏览器 没有及时跳转。请点击这里]</a></p>

</div>



</body>
</html>