<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	
	<h1>Crear Nueva Categoría</h1>
	<form action="index.php?c=CategoryController&a=create" method="POST">
	    <label for="name_category">Nombre:</label>
	    <input type="text" id="name_category" name="name_category" required>
	    <label for="desc_category">Descripción:</label>
	    <input type="text" id="desc_category" name="desc_category">
	    <button type="submit">Guardar</button>
	</form>

</body>
</html>