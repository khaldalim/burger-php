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

	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>




<body>
	<div class="container site">
		<h1 class="text-logo">
			<i class="fas fa-utensils"></i> Burger Léo <i class="fas fa-utensils"></i>
		</h1>

		<?php 
		require 'admin/database.php';
// <!-- navigation -->
		echo '<nav>
		<ul class="nav nav-pills"  role="tablist">';


		$db = Database::connect();
		$statement = $db->query('SELECT * From categories');
		$categories = $statement->fetchAll();

		foreach ($categories as $category ) {
			if ($category['id'] == '1') {
				echo '<li  class="nav-item"role="presentation">
				<a class="nav-link active" id="one-tab" data-toggle="tab" href="#data-' . $category['id'] .  '" role="tab" aria-controls="data-' . $category['id'] . '" aria-selected="true">' . $category['name']  .'</a>
				</li>';
			}
			else{
				echo '<li  class="nav-item"role="presentation">
				<a class="nav-link" id="one-tab" data-toggle="tab" href="#data-' . $category['id'] .  '" role="tab" aria-controls="data-' . $category['id'] . '" aria-selected="true">' . $category['name']  .'</a>
				</li>';
			}
			
		}
		echo '</ul>
		</nav>';





		echo '<div class="tab-content" id="myTabContent">';

		foreach ($categories as $category ) {
			if ($category['id'] == '1') {
				echo'<div class="tab-pane fade show active" id="data-'. $category['id'] .'" role="tabpanel" aria-labelledby="data-' . $category['id'] . '-tab">
				';	}
				else{
					echo'<div class="tab-pane fade show" id="data-'. $category['id'] .'" role="tabpanel" aria-labelledby="data-' . $category['id'] . '-tab">';
				}
				echo "<div class='row'>";

				$statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
				$statement->execute(array($category['id']));

				while ($item = $statement->fetch()) {
					echo '<div class="col-sm-6 col-md-4">
					<div class="thumbnail">
					<img src="images/' . $item['image'] .'" alt="">
					<div class="price">' . number_format($item['price'], 2, '.', '') .'€</div>
					<div class="caption">
					<h4>' . utf8_decode($item['name']) .'</h4>
					<p>' . utf8_decode($item['description']) .'</p>
					<a href="#" class="btn btn-order" role="button"><i class="fas fa-shopping-cart"></i> Commander</a>
					</div>
					</div>
					</div>';
				}
				echo "</div></div>";
			}
			Database::disconnect();
			echo "</div>";
			?>

		</div>
	</body>

	<footer>
		<div id="creator"><a target="_blank" href="https://www.demet.fr">Site crée par Léo DEMET</a></div>

	</footer>
	<script src="js/script.js"></script>
	</html>