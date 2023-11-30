<?php
// Verificar que se proporcionó la ruta del archivo como parámetro
if ($argc != 2) {
    echo "Uso: php script.php <ruta_del_archivo_csv>\n";
    exit(1);
}

// Obtener la ruta del archivo desde los argumentos de la línea de comandos
$rutaArchivo = $argv[1];

// Validar si el archivo existe
if (!file_exists($rutaArchivo)) {
    echo "El archivo no existe: $rutaArchivo\n";
    exit(1);
}

// Validar si la extensión del archivo es csv
$extension = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
if (strtolower($extension) != 'csv') {
    echo "El archivo no tiene la extensión CSV: $rutaArchivo\n";
    exit(1);
}

// Abrir el archivo en modo lectura
$archivoEntrada = fopen($rutaArchivo, 'r');

// Validar si se pudo abrir el archivo
if (!$archivoEntrada) {
    echo "Error al abrir el archivo: $rutaArchivo\n";
    exit(1);
}

// Crear un nuevo archivo CSV para la salida
$rutaArchivoSalida = 'salida.csv';
$archivoSalida = fopen($rutaArchivoSalida, 'w');

// Validar si se pudo crear el archivo de salida
if (!$archivoSalida) {
    echo "Error al crear el archivo de salida: $rutaArchivoSalida\n";
    fclose($archivoEntrada);
    exit(1);
}

// Leer la cabecera del archivo CSV de entrada
$cabecera = fgetcsv($archivoEntrada);

// Verificar si la cabecera es válida
if ($cabecera === false) {
    echo "Error al leer la cabecera del archivo CSV: $rutaArchivo\n";
    fclose($archivoEntrada);
    fclose($archivoSalida);
    exit(1);
}

// Escribir la cabecera en el archivo de salida
fputcsv($archivoSalida, array_merge($cabecera, ['Resultado1', 'Resultado2', 'Resultado3', 'Resultado4', 'Resultado5']));

// Leer y procesar el resto del archivo de entrada
while (($fila = fgetcsv($archivoEntrada)) !== false) {
    // Procesar cada fila según tus necesidades
    // Supongamos que las operaciones se realizan sobre las primeras 5 columnas
    $resultado1 = $fila[0] * 2;  // Ejemplo de operación
    $resultado2 = $fila[1] + 5;  // Ejemplo de operación
    $resultado3 = $fila[2] - 3;  // Ejemplo de operación
    $resultado4 = $fila[3] / 2;  // Ejemplo de operación
    $resultado5 = $fila[4] ** 2; // Ejemplo de operación

    // Agregar los resultados a la fila
    $filaConResultados = array_merge($fila, [$resultado1, $resultado2, $resultado3, $resultado4, $resultado5]);

    // Escribir la fila con resultados en el archivo de salida
    fputcsv($archivoSalida, $filaConResultados);
}

// Cerrar los archivos
fclose($archivoEntrada);
fclose($archivoSalida);

echo "Operaciones completadas. Resultados guardados en: $rutaArchivoSalida\n";
?>
