<?php 
require 'database.php';

if (!empty($_GET['id'])) {
	$id = checkInput($_GET['id']);
}

if (!empty($_POST['id'])) {
	$id = checkInput($_POST['id']);
	$db = Database::connect();
	$statement = $db->prepare("DELETE FROM items where id = ?");
	$statement->execute(array($id));
	Database::disconnect();
	header("Location: index.php");
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

			<div class="col-sm-12">
				<h2>
					<strong>Supprimer un item</strong>&nbsp;		
				</h2>
				<br>

				<form class="form" role="form" action="delete.php" method="post">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<p class="alert alert-warning"><strong>Etes vous sur de vouloir supprimer ?</strong></p>
					<br>



					<div class="form-actions">
						<button type="submit" class="btn btn-warning"> Oui</button>
						<a href="index.php" class="btn btn-primary"> Non</a>	
					</div>
				</form>			


			</div>
		</div>


	</div>

	
</body>

<footer>
	<div id="creator"><a target="_blank" href="https://www.demet.fr">Site crée par Léo DEMET</a></div>

</footer>
<script src="../js/script.js"></script>
</html>