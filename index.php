<?php require_once"inc/settings.php"; ?>
<!doctype html>
<html>
<head>
	<title>Mapi Materiaux - UI</title>
	<link rel="stylesheet" href="files/css/default.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script src="files/js/custom.js"></script>
</head>
<body>

<!-- start:Wrap -->
<div id="wrap">

<?php include 'header.php'; ?>

<!-- start:Content -->
<div id="content">

<h1>Login</h1>
	
	<iframe name="iframeLogin" src="back/models/login.php" height="30px" width="100%" frameborder="0"></iframe>
	<?php if(!isset($_SESSION['user'])) :?>
		<form method="post" action="back/models/login.php" target="iframeLogin" >
			<label>Login :</label><input type="text" name="user" id="user"/><br />
			<label>Pass :</label><input type="password" name="password" id="password"/><br />
			<label></label><input type="submit" />
		</form>
	<?php else: ?>
		<?php header("Location: back/index.html"); ?>
	<?php endif; ?>
	
</div>
<!-- end:Content -->

<?php include 'footer.php'; ?>

</div>
<!-- end:Wrap -->
</body>
</html>