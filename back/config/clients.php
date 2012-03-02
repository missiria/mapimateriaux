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

<h1>clients</h1>
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
					<li><a href="clients" title="clients" class="active">clients</a></li>
					<li><a href="produits" title="produits">produits</a></li>	
					<li><a href="references" title="references">references</a></li>	
					<li><a href="stocks" title="stocks">stocks</a></li>
					<li><a href="vehicules" title="vehicules">vehicules</a></li>
				</ul>			
		</li>
	</ul>
	
	<hr>
	<div id="content" class="commandes">
		<form method="post" action="models/clients.php">
			<label>raison Social :</label><br /><input type="text" name="raison_social"><br />
			<label>Nom responsable :</label><br /><input type="text" name="nom_resp"><br />
			<label>Prenom responsable :</label><br /><input type="text" name="prenom_resp"><br />
			<label>email :</label><br /><input type="text" name="email"><br />
			<label>telephone :</label><br /><input type="text" name="tel"><br />
			<label>Adresse :</label><br /><input type="text" name="adresse"><br />
			<label>Numéro de carte bancaire :</label><br /><input type="text" name="num_compte_bancaire"><br />
			<label>Ville :</label><br /><input type="text" name="ville"><br />
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
