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
			<h2>
				<strong>Liste des items</strong>&nbsp;
				<a href="insert.php" class="btn-success btn-lg"> 
					<i class="fas fa-plus"></i> Ajouter
				</a>
			</h2>

			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Description</th>
						<th>Prix</th>
						<th>Catégorie</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>

					<?php 
					require 'database.php';
					$db = database::connect();
					$statement = $db->query("SELECT items.id, items.name, items.description, items.price, categories.name AS category from items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC");

					while ($item = $statement->fetch()) {
						echo "<tr>";
						echo "<td>" . utf8_decode($item['name']) ."</td>";
						echo "<td>" . utf8_decode($item['description']) ."</td>";
						echo "<td>" . number_format((float)$item['price'],2,'.', '') . "</td>";
						echo "<td>" . $item['category'] . "</td>";
						echo "<td>";
						echo '<a class="btn btn-info" href="view.php?id=' . $item["id"] . '">
						<i class="far fa-eye"></i> Voir
						</a>';
						echo " ";
						echo '<a class="btn btn-primary" href="update.php?id=' . $item["id"] .'">
						<i class="fas fa-pencil-alt"></i> Modifier
						</a>';
						echo " ";
						echo '<a class="btn btn-danger" href="delete.php?id=' . $item["id"] . '">
						<i class="fas fa-trash"></i> Supprimer
						</a>';
						echo "</td>";
						echo "</tr>";

						Database::disconnect();
					}
					?>



					
				</tbody>
			</table>

		</div>

	</div>
</body>

<footer>
	<div id="creator"><a target="_blank" href="https://www.demet.fr">Site crée par Léo DEMET</a></div>
	
</footer>
<script src="../js/script.js"></script>
</html>