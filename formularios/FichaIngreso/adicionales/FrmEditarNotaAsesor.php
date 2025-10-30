<?php
$servidor = "localhost";
$user = "cisneadminbd";
$password = "Imb29304044";
$database = "siscisne";

$conexion = mysqli_connect($servidor, $user, $password, $database);

// Validar que existe el parámetro OT
if (!isset($_GET['ot']) || empty($_GET['ot'])) {
    die("Error: No se ha especificado una OT");
}

$ot = mysqli_real_escape_string($conexion, $_GET['ot']);

$consultaot = "
    SELECT
    tblfinfichaingreso.FinId, 
    tblsucsucursal.SucNombre, 
    tblclicliente.CliNombreCompleto, 
    tblclicliente.CliNumeroDocumento, 
    tbleinvehiculoingreso.EinVIN, 
    tblfinfichaingreso.FinNota,
    tblfinfichaingreso.FinIndicacionTecnico
    FROM
        tblfinfichaingreso
        INNER JOIN
        tblclicliente
        ON 
            tblfinfichaingreso.CliId = tblclicliente.CliId
        INNER JOIN
        tblsucsucursal
        ON 
            tblfinfichaingreso.SucId = tblsucsucursal.SucId
        INNER JOIN
        tbleinvehiculoingreso
        ON 
            tblfinfichaingreso.EinId = tbleinvehiculoingreso.EinId
    WHERE
        tblfinfichaingreso.FinId = '$ot'
";

$resultado = mysqli_query($conexion, $consultaot);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: No se encontró la OT especificada");
}

$dataOT = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="es" style="font-family: 'Arial', sans-serif;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notas - OT <?php echo htmlspecialchars($ot); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .container-fluid {
            height: 100vh;
            padding: 20px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
            height: calc(100vh - 40px);
            display: flex;
            flex-direction: column;
        }
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .alert {
            display: none;
        }
        .textarea-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        .textareas-row {
            flex: 1;
            display: flex;
            gap: 15px;
            min-height: 0;
        }
        .textarea-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        textarea.form-control {
            resize: vertical;
            flex: 1;
            min-height: 150px;
        }
        .content-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .btn-footer {
            margin-top: auto;
            padding-top: 15px;
        }
        @media (max-width: 768px) {
            .textareas-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-12">
                <!-- Alertas -->
                <div id="alertSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> Los cambios se guardaron correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                
                <div id="alertError" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> <span id="errorMessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-0">Editar Notas de Servicio</h4>
                                <small class="text-muted">OT: <?php echo htmlspecialchars($ot); ?></small>
                            </div>
                            <div class="col-auto">
                                <button onclick="cerrarVentana()" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content-section">
                            <!-- Información de la OT -->
                            <div class="info-section">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Sucursal:</strong><br>
                                        <?php echo htmlspecialchars($dataOT['SucNombre']); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Cliente:</strong><br>
                                        <?php echo htmlspecialchars($dataOT['CliNombreCompleto']); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Documento:</strong><br>
                                        <?php echo htmlspecialchars($dataOT['CliNumeroDocumento']); ?>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <strong>VIN:</strong> <?php echo htmlspecialchars($dataOT['EinVIN']); ?>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Textareas para las notas -->
                            <div class="textarea-container">
                                <div class="textareas-row">
                                    <!-- Nota de Asesor -->
                                    <div class="textarea-col">
                                        <label for="notaAsesor" class="form-label fw-bold">Nota de Asesor:</label>
                                        <textarea class="form-control" id="notaAsesor" placeholder="Ingrese las observaciones del asesor..."><?php echo htmlspecialchars(trim($dataOT['FinNota'])); ?></textarea>
                                    </div>
                                    
                                    <!-- Indicación del Técnico -->
                                    <div class="textarea-col">
                                        <label for="indicacionTecnico" class="form-label fw-bold">Indicación del Técnico:</label>
                                        <textarea class="form-control" id="indicacionTecnico" placeholder="Ingrese las indicaciones del técnico..."><?php echo htmlspecialchars(trim($dataOT['FinIndicacionTecnico'])); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="btn-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button onclick="cerrarVentana()" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cerrar Ventana
                                    </button>
                                    <button id="btnGuardar" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnGuardar = document.getElementById('btnGuardar');
            const notaAsesor = document.getElementById('notaAsesor');
            const indicacionTecnico = document.getElementById('indicacionTecnico');
            const alertSuccess = document.getElementById('alertSuccess');
            const alertError = document.getElementById('alertError');
            const errorMessage = document.getElementById('errorMessage');

            btnGuardar.addEventListener('click', function() {
                guardarNotas();
            });

            function guardarNotas() {
                // Mostrar estado de carga
                btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
                btnGuardar.disabled = true;

                // Ocultar alertas anteriores
                alertSuccess.style.display = 'none';
                alertError.style.display = 'none';

                // Preparar datos para enviar
                const datos = {
                    ot: '<?php echo $ot; ?>',
                    nota: notaAsesor.value,
                    indicacion_tecnico: indicacionTecnico.value
                };

                // Enviar datos via AJAX
                fetch('guardar_nota.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(datos)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar éxito
                        alertSuccess.style.display = 'block';
                    } else {
                        // Mostrar error
                        errorMessage.textContent = data.message || 'Error al guardar los cambios';
                        alertError.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.textContent = 'Error de conexión. Intente nuevamente.';
                    alertError.style.display = 'block';
                })
                .finally(() => {
                    // Restaurar botón
                    btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar Cambios';
                    btnGuardar.disabled = false;
                });
            }

            // Función para cerrar la ventana
            window.cerrarVentana = function() {
                window.close();
            }

            // También se puede cerrar con la tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    cerrarVentana();
                }
            });
        });
    </script>
</body>
</html>
<?php
mysqli_close($conexion);
?>