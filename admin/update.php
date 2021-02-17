<?php 
require 'database.php';

if (!empty($_GET['id'])) {
	$id = checkInput($_GET['id']);
}


$name = "";
$description = "";
$price = "";
$category = "";
$image = "";

$nameError = "";
$descriptionError = "";
$priceError = "";
$categoryError = "";
$imageError = "";

if (!empty($_POST)) {
	// RECUPERATION DES VARIABLES
	$name 			= checkInput($_POST['name']);
	$description 	= checkInput($_POST['description']);
	$price 			= checkInput($_POST['price']);
	$category 		= checkInput($_POST['category']);
	$image 			= checkInput($_FILES['image']['name']);
	$imagePath		= "../images/" . basename($image);
	$imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
	$isSuccess 		= true;
	// $isUploadSuccess= false;

// VERIFICATION QUE LES CHAMPS NE SONT PAS VIDE
	if (empty($name)) {
		$nameError = "Ce champs est vide";
		$isSuccess = false;
	}
	if (empty($description)) {
		$descriptionError = "Ce champs est vide";
		$isSuccess = false;
	}
	if (empty($price)) {
		$priceError = "Ce champs est vide";
		$isSuccess = false;
	}
	if (empty($category)) {
		$categoryError = "Ce champs est vide";
		$isSuccess = false;
	}
	if (empty($image)) {
		$isImageUpdated = false;
		
	}

	// VERIFICATION IMAGE
	else{
		$isImageUpdated = true;
		$isUploadSuccess = true;

		if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
			$imageError = "les fichiers autorisé sont : JPG, PGN JPEG et GIF";
			$isUploadSuccess = false;
		}

		if (file_exists($imagePath)) {
			$imageError = "Le fichier existe déja";
			$isUploadSuccess = false;
		}

		if ($_FILES["image"]["size"] > 500000) {
			$imageError = "Le fichier ne doit pas dépasser les 500KB";
			$isUploadSuccess = false;
		}

		if ($isUploadSuccess) {
			if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
				$imageError = "Il y a eu une error lors de l'upload";
				$isUploadSuccess = false;
			}
		}

	}


// si tout est OK
	if (($isSuccess && $isImageUpdated && $isUploadSuccess ) || ($isSuccess && !$isImageUpdated)) {

		if ($isImageUpdated) {
			$db = Database::connect();
			$statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category= ?, image = ? WHERE id = ?");
			$statement->execute(array(utf8_encode($name), utf8_encode($description), $price, utf8_encode($category), utf8_encode($image), $id));
		}
		else if (!$isImageUpdated) {
			$db = Database::connect();
			$statement = $db->prepare("UPDATE items set name = ?, description = ?, price = ?, category= ? WHERE id = ?");
			$statement->execute(array(utf8_encode($name), utf8_encode($description), $price, utf8_encode($category), $id));
		}
		Database::disconnect();
		header("Location: index.php");
	}



	else if($isImageUpdated && !$isUploadSuccess ){
		$db = Database::connect();
		$statement = $db->prepare("SELECT image FROM items WHERE id=? ");
		$statement->execute(array($id));
		$item = $statement->fetch();
		$image	= $item['image'];
		Database::disconnect();
	}


}

// PASSAGE ICI SI IL Y A RIEN DANS LE "POST", SOIT LE ER PASSAGE DANS LA PAGE
else{
	$db = Database::connect();
	$statement = $db->prepare("SELECT * FROM items WHERE id=? ");
	$statement->execute(array($id));
	$item = $statement->fetch();
	$name 				= $item['name'];
	$description 		= $item['description'];
	$price 				= $item['price'];
	$category			= $item['category'];
	$image				= $item['image'];

	Database::disconnect();
}

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
					<strong>Modifier un item</strong>&nbsp;		
				</h2>
				<br>

				<form class="form" action="<?php echo 'update.php?id=' . $id  ?>" method="post"  enctype="multipart/form-data">

					<div class="form-group">
						<label for="name">Nom : </label>
						<br>
						<input type="text" name="name" id="name" value="<?php echo $name; ?>" placeholder="Nom" >
						<span class="help-inline"><?php echo $nameError; ?></span>
					</div>

					<div class="form-group">
						<label for="description">Description : </label>
						<br>
						<input type="text" name="description" id="description" value="<?php echo $description; ?>" placeholder="Description">
						<span class="help-inline"><?php echo $descriptionError; ?></span>
					</div>

					<div class="form-group">
						<label for="price">Prix : (en €) </label>
						<br>
						<input type="number" step="0.01" name="price" placeholder="Prix" id="price" value="<?php echo $price; ?>">
						<span class="help-inline"><?php echo $priceError; ?></span>
					</div>

					<div class="form-group">
						<label for="category">Categorie : </label>
						<br>
						<select class="form-control" id="category" name="category">
							<?php
							$db =Database::connect();
							foreach ($db->query("SELECT * From categories") as $row) {
								if ($row['id'] == $category) {
									echo '<option selected="selected" value="'. $row['id'] .'">' . $row['name'] . '</option>';
								}
								else{
									echo '<option value="'. $row['id'] .'">' . $row['name'] . '</option>';
								}
							}
							Database::disconnect();
							?>
						</select>
						<span class="help-inline"><?php echo $categoryError; ?></span>
					</div>

					<div class="form-group">
						<label>Image:</label>
						<p><?php echo $image; ?></p>
						<label for="image">Séléctionner l'image : </label>
						<br>
						<input type="file" name="image" name="image">
						<span class="help-inline"><?php echo $imageError; ?></span>
					</div>


					<br>



					<div class="form-actions">
						<button type="submit" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Modifier</button>
						<a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Retour</a>	
					</div>
				</form>			


			</div>
			<div class="col-sm-6 site">
				<div class="thumbnail" style="padding: 0px;">
					<?php 
					$imageSrc = '../images/' .utf8_decode($image);
					?>
					<img src="<?php echo $imageSrc ; ?>" alt="">
					<div class="price"><?php echo  number_format((float)$price,2,'.', ''); ?> €</div>
					<div class="caption">
						<h4><?php echo utf8_decode($name); ?></h4>
						<p><?php echo utf8_decode($description); ?></p>
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