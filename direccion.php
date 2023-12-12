<?php
// Tu variable con un conjunto de palabras
$direccion = "Esto es un ejemplo de dirección en PHP";

// Convertir la cadena en un array de palabras
$palabras = explode(" ", $direccion);

// Variable para almacenar el query
$query = "";

// Recorrer cada palabra y construir la consulta
foreach ($palabras as $palabra) {
    // Verificar si la longitud de la palabra es mayor a 3 caracteres
    if (strlen($palabra) > 3) {
        // Construir la parte del query para esta palabra
        $query .= "SELECT * FROM tabla WHERE calle = '$palabra' UNION ALL ";
    }
}

// Eliminar la última ocurrencia de "UNION ALL " para evitar errores sintácticos
$query = rtrim($query, "UNION ALL ");

// Puedes imprimir o ejecutar la consulta aquí según tus necesidades
echo $query;
?>
