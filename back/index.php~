<?php require_once"../inc/settings.php"; ?>
<?php if($_SESSION['user'] = $user) :?>

<!doctype html>
<html>
<head>
	<title>Mapi Materiaux - UI</title>
	<link rel="stylesheet" href="../files/css/default.css" />
	<link rel="stylesheet" href="../files/css/themes/base/jquery.ui.all.css">
	<script src="../files/js/jquery-1.7.1.min.js"></script>
	<script src="../files/js/jquery-ui-1.8.18.custom.min"></script>
	<script src="../files/js/ui/jquery.ui.datepicker.js"></script>	
	<script src="../files/js/custom.js"></script>
	
	<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	</script>
	
</head>
<body>

<!-- start:Wrap -->
<div id="wrap">

<?php include '../header.php'; ?>
<?php include 'models/commandes.php'; ?>

<!-- start:Content -->
<div id="content">

<h1>Commandes</h1>
	<a href="models/logout.php" title="déconnecté vous !">Deconnecte</a>
	
	<ul>
		<li><a href="index" title="Commandes" class="active">Commandes</a></li>
		<li><a href="livraison" title="Traitement des commandes">Livraison</a></li>	
		<li><a href="facturation" title="Commandes">Facturation</a></li>	
		<li><a href="achats" title="Achats">Achats</a></li>
		<li><a href="stock" title="Stock">Stock</a></li>		
		<li><a href="productivite" title="Productivité">Productivité</a></li>	
		<li><a href="transport" title="Gestion Transport">Gestion Transport</a></li>
		<li><a href="parametres" title="Paramétrages" class="config">Paramétrages</a></li>
	</ul>
	<hr>
	<div id="content" class="commandes">
		<form action="">
			<label>Date </label><input id="datepicker" type="text" name="date_commande" ><br />
			<label>Clients </label>
			<select>
				<?php if($results_clients->rowCount() > 0) {
					foreach ($results_clients as $item) {
						echo "<option>". ($item['nom_resp']). "</option>";
					}
				} ?>			
			</select><br />
			<label>Produits </label>
			<select>
				<?php if($results_produits->rowCount() > 0) {
					foreach ($results_produits as $item) {
						echo "<option>". ($item['libelle']) ."</option>";
					}
				} ?>			
			</select><br />
			<label>Ref produits </label>
			
			<select>
				<?php if($results_produits->rowCount() > 0) {
					foreach ($results_produits as $item) {
						echo "<option>". ($item['references']) ."</option>";
					}
				} ?>			
			</select><br />
			<label>Quantité </label><input type="text" name="qt_commande" ><br />
			<label>Prix Unitaire </label><input type="text" name="prix_unitaire" ><br />
			<hr>			
			<input type="submit" value="Valide">
			<input type="reset" value="Annuler">
		</form>
	</div>
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