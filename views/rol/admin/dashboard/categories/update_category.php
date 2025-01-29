<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<h1>Editar Categoría</h1>
	<form action="index.php?c=CategoryController&a=update" method="POST">
	    <input type="hidden" name="id_category" value="<?= htmlspecialchars($category->getIdCategory()) ?>">
	    <label for="name_category">Nombre:</label>
	    <input type="text" id="name_category" name="name_category" value="<?= htmlspecialchars($category->getNameCategory()) ?>" required>
	    <label for="desc_category">Descripción:</label>
	    <input type="text" id="desc_category" name="desc_category" value="<?= htmlspecialchars($category->getDescCategory()) ?>">
	    <button type="submit">Actualizar</button>
	</form>

		
</body>
</html>