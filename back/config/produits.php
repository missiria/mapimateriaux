<?php require_once"../../inc/settings.php"; ?>
<?php if($_SESSION['user'] = $user) :?>
<!doctype html>
<html>
<head>
	<title>Mapi Materiaux - UI</title>
	<link rel="stylesheet" href="../../files/css/default.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script src="../../files/js/custom.js"></script>
</head>
<body>

<!-- start:Wrap -->
<div id="wrap">

<?php include '../../header.php'; ?>

<!-- start:Content -->
<div id="content">

<h1>produits</h1>
	<a href="../models/logout.php" title="déconnecté vous !">Deconnecte</a>
	
	<ul>
		<li><a href="../index" title="Commandes">Commandes</a></li>
		<li><a href="../livraison" title="Traitement des commandes">Livraison</a></li>	
		<li><a href="../facturation" title="Commandes">Facturation</a></li>	
		<li><a href="../achats" title="Achats">Achats</a></li>
		<li><a href="../stock" title="Stock">Stock</a></li>		
		<li><a href="../productivite" title="Productivité">Productivité</a></li>	
		<li><a href="../transport" title="Gestion Transport">Gestion Transport</a></li>
		<li><a href="../parametres" title="Paramétrages" class="config active">Paramétrages</a>
				<ul>
					<li><a href="clients" title="clients">clients</a></li>
					<li><a href="produits" title="produits" class="active">produits</a></li>	
					<li><a href="references" title="references">references</a></li>	
					<li><a href="stocks" title="stocks">stocks</a></li>
					<li><a href="vehicules" title="vehicules">vehicules</a></li>
				</ul>			
		</li>
	</ul>
	<hr>
	<div id="content" class="commandes">
		<form method="post" action="models/produits.php">
			<label>le nom de produit :</label><br /><input type="text" name="libelle"><br />
			<label>caracteristique :</label><br /><textarea name="caracteristique"></textarea><br />
			<label>references :</label><br /><input type="text" name="references"><br />

			<hr>
			<input type="submit" value="Ajouter">
			<input type="reset" value="Annuler	">
		</form>
	</div>
	
</div>
<!-- end:Content -->

<?php include '../../footer.php'; ?>

</div>
<!-- end:Wrap -->
	<?php else: ?>
		<?php echo "You dont have the permission to connect !!"; ?>
	<? endif; ?>
</body>
</html>
