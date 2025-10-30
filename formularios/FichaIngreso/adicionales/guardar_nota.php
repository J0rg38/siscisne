<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servidor = "localhost";
$user = "cisneadminbd";
$password = "Imb29304044";
$database = "siscisne";

$conexion = mysqli_connect($servidor, $user, $password, $database);

// Verificar conexión
if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Leer los datos JSON enviados
$input = json_decode(file_get_contents('php://input'), true);

// Validar datos recibidos
if (!isset($input['ot']) || !isset($input['nota']) || !isset($input['indicacion_tecnico'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Sanitizar datos
$ot = mysqli_real_escape_string($conexion, $input['ot']);
$nota = mysqli_real_escape_string($conexion, $input['nota']);
$indicacion_tecnico = mysqli_real_escape_string($conexion, $input['indicacion_tecnico']);

// Preparar y ejecutar la consulta de actualización
$query = "UPDATE tblfinfichaingreso 
          SET FinNota = '$nota', 
              FinIndicacionTecnico = '$indicacion_tecnico' 
          WHERE FinId = '$ot'";

if (mysqli_query($conexion, $query)) {
    if (mysqli_affected_rows($conexion) > 0) {
        echo json_encode(['success' => true, 'message' => 'Notas actualizadas correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se realizaron cambios o la OT no existe']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . mysqli_error($conexion)]);
}

mysqli_close($conexion);
?>