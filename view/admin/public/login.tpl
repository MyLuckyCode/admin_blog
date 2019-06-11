<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
	<link rel="stylesheet" href="view/admin/style/basic.css">
	<link rel="stylesheet" href="view/admin/style/login.css">
</head>
<body>

	<div class="superlogin"></div>
	<div class="loginBox">
		<div class="loginMain">
			<form action="?a=login&m=login" id="form" method="post">
				<dl>
					<dd>管理员登录</dd>
					<dd>
						账号：<input type="text" class="text" name="user">
					</dd>
					<dd>
						密码：<input type="password" class="text" name="pass">
					</dd>
					<dd class="info" style="padding-left:50px;color:red;font-size:15px;display: none;">用户名或密码错误</dd>
					<dd class="btnView">
						<input type="submit" name="send" class="btn loginbtn" value="登录">
						<input type="reset" class="btn resetbtn" value="重置">
					</dd>
				</dl>
			</form>
		</div>
	</div>
	<div class="footer"></div>

	
	<script type="text/javascript" src="view/admin/js/login.js"></script>
</body>
</html>