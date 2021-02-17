<?php 
require 'database.php';

if (!empty($_GET['id'])) {
	$id = checkInput($_GET['id']);
}

$db = Database::connect();
$statement = $db->prepare("SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category from items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ? ");

$statement->execute(array($id));
$item = $statement->fetch();
Database::disconnect();


function checkInput($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Burger-Léo</title>

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.0/umd/popper.min.js"></script>

	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

	<link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="../css/style.css">

</head>

<body>
	<h1 class="text-logo">
		<i class="fas fa-utensils"></i> Burger Léo <i class="fas fa-utensils"></i>
	</h1>

	<div class="container admin">
		<div class="row">			

			<div class="col-sm-6">
				<h2>
					<strong>Voir un item</strong>&nbsp;		
				</h2>
				<br>
				<form>
					<div class="form-group">
						<label>Nom : </label><?php echo " " . utf8_decode($item['name']); ?>
					</div>
					<div class="form-group">
						<label>Description : </label><?php echo " " . utf8_decode($item['description']); ?>
					</div>
					<div class="form-group">
						<label>Prix : </label><?php echo " " . number_format((float)$item['price'],2,'.', '') . '€' ; ?> 
					</div>
					<div class="form-group">
						<label>Categorie : </label><?php echo " " . utf8_decode($item['category']); ?>
					</div>
					<div class="form-group">
						<label>Nom de l'image : </label><?php echo " " . utf8_decode($item['image']); ?>
					</div>
				</form>
				<div class="form-actions">
					<a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Retour</a>	
				</div>

			</div>


			<div class="col-sm-6 site">
				<div class="thumbnail" style="padding: 0px;">
					<?php 
					$imageSrc = '../images/' .utf8_decode($item['image']);
					?>
					<img src="<?php echo $imageSrc ; ?>" alt="">
					<div class="price"><?php echo  number_format((float)$item['price'],2,'.', ''); ?> €</div>
					<div class="caption">
						<h4><?php echo utf8_decode($item['name']); ?></h4>
						<p><?php echo utf8_decode($item['description']); ?></p>
						<a href="#" class="btn btn-order" role="button"><i class="fas fa-shopping-cart"></i> Commander</a>
					</div>
				</div>
			</div>

		</div>

	</div>
</body>

<footer>
	<div id="creator"><a target="_blank" href="https://www.demet.fr">Site crée par Léo DEMET</a></div>

</footer>
<script src="../js/script.js"></script>
</html>