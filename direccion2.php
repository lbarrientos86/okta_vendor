<?php
// Valores iniciales
$direccion = "CA. LOS HERAL DOS MAGNOLIAS calle ca";
$ubigeo = "150132";
$nfiltro = 3;
$excluir = array("AV", "CA", "CALLE", "VIA");
$query = "";

// Limpiar la cadena eliminando palabras con longitud igual o menor a $nfiltro y excluyendo las palabras en $excluir
$palabras = explode(" ", $direccion);
$palabrasFiltradas = array_filter($palabras, function ($palabra) use ($nfiltro, $excluir) {
    return strlen($palabra) > $nfiltro && !in_array($palabra, $excluir);
});

// Imprimir la cadena resultante después de la limpieza
$cadenaLimpia = implode(" ", $palabrasFiltradas);
echo "Cadena limpia: $cadenaLimpia\n";

// Construir una condición LIKE con % entre las palabras
$condicionLike = '%' . implode('%', $palabrasFiltradas) . '%';

// Imprimir la condición LIKE
echo "Condición LIKE: calle LIKE '$condicionLike'\n";

// Obtener todas las combinaciones posibles de palabras
$combinaciones = obtenerCombinaciones($palabrasFiltradas);

// Construir la parte del query para cada combinación
foreach ($combinaciones as $combinacion) {
    $query .= "SELECT * FROM tabla WHERE calle LIKE '%" . implode('%', $combinacion) . "%' AND ubigeo = '$ubigeo' \nUNION ALL ";
    // Puedes ejecutar la consulta aquí según tus necesidades
}

// Eliminar la última ocurrencia de "UNION ALL " para evitar errores sintácticos
$query = rtrim($query, "UNION ALL ");
echo "$query\n";

// Función para obtener todas las combinaciones posibles de palabras
function obtenerCombinaciones($palabras) {
    $combinaciones = [];
    $total = count($palabras);

    for ($i = 0; $i < $total; $i++) {
        for ($j = $i + 1; $j <= $total; $j++) {
            $combinaciones[] = array_slice($palabras, $i, $j - $i);
        }
    }

    return $combinaciones;
}
?>
