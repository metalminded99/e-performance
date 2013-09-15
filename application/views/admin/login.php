<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>
			IntelliCare ePerformance Admin
		</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url().CSS?>login.css" media="screen">
	</head>
	<body>
		<div class="wrap">
			<div id="content">
				<div id="main">
					<div class="full_w">
						<div id="logo">
							<img src = "<?=base_url().IMG?>logo.png" title = "IntelliCare ePerformance" width="100%" style="opacity:0.8;">
						</div>
						<?php if( isset($invalid) && $invalid === true ) : ?>
						<div class="n_error">
							<p>Access denied! Invalid username/password.</p>
						</div>
						<?php endif; ?>
						<form action="" method="post">
							<label for="login">Username:</label> <input id="login" name="user_name" class="text" autocomplete="off"> 
							<label for="pass">Password:</label> <input id="pass" name="user_password" type="password" class="text" autocomplete="off">
							<div class="sep"></div>
							<button type="submit" class="ok">Login</button>
						</form>
					</div>
					<div class="footer">
						» <a href="<?=base_url()?>">E-performance</a> | IntelliCare E-Performance Admin Panel
					</div>
				</div>
			</div>
		</div>
	</body>
</html>