<?php require_once"../inc/settings.php"; ?>
<?php if($_SESSION['user'] = $user) :?>
<!doctype html>
<html>
<head>
	<title>Mapi Materiaux - UI</title>
	<link rel="stylesheet" href="../files/css/default.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script src="../files/js/custom.js"></script>
</head>
<body>

<!-- start:Wrap -->
<div id="wrap">

<?php include '../header.php'; ?>

<!-- start:Content -->
<div id="content">

<h1>Livraison</h1>
	<a href="logout.php" title="déconnecté vous !">Deconnecte</a>
	
	<ul>
		<li><a href="index.php" title="Commandes">Commandes</a></li>
		<li><a href="Livraison.php" title="Traitement des commandes" class="active">Livraison</a></li>	
		<li><a href="facturation.php" title="Commandes">Facturation</a></li>	
		<li><a href="achats.php" title="Achats">Achats</a></li>
		<li><a href="stock.php" title="Stock">Stock</a></li>		
		<li><a href="productivite.php" title="Productivité">Productivité</a></li>	
		<li><a href="transport.php" title="Gestion Transport">Gestion Transport</a></li>
	</ul>
	
</div>
<!-- end:Content -->

<?php include '../footer.php'; ?>

</div>
<!-- end:Wrap -->
	<?php else: ?>
		<?php echo "You dont have the permission to connect !!"; ?>
	<? endif; ?>
</body>
</html>