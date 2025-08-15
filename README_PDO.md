# Guía de Conexión PDO a MySQL para Sistema SISCISNE

Este directorio contiene archivos de ejemplo y herramientas para implementar conexiones PDO a MySQL de forma segura y eficiente.

## 📁 Archivos Incluidos

### 1. `ejemplo_conexion_pdo.php`
Archivo de ejemplo completo que demuestra todas las funcionalidades de PDO con MySQL.

**Características:**
- ✅ Conexión básica a MySQL
- ✅ Consultas SELECT, INSERT, UPDATE, DELETE
- ✅ Transacciones
- ✅ JOINs y agregaciones
- ✅ Paginación
- ✅ Búsquedas con LIKE
- ✅ Operadores IN
- ✅ GROUP BY y estadísticas

### 2. `config_pdo_ejemplo.php`
Archivo de configuración de ejemplo para conexiones PDO.

**Características:**
- ✅ Configuración del servidor
- ✅ Credenciales de acceso
- ✅ Opciones de PDO
- ✅ Timeouts y reintentos
- ✅ Pool de conexiones
- ✅ Logging y estadísticas
- ✅ Configuración SSL opcional

### 3. `clases/ClsPDO.php`
Clase PDO avanzada para el sistema SISCISNE.

**Características:**
- ✅ Manejo automático de errores
- ✅ Sistema de reintentos
- ✅ Logging detallado
- ✅ Transacciones seguras
- ✅ Estadísticas de rendimiento
- ✅ Reconexión automática
- ✅ Pool de conexiones

## 🚀 Inicio Rápido

### 1. Conexión Básica

```php
<?php
// Cargar configuración
$config = require 'config_pdo_ejemplo.php';

// Crear conexión
$pdo = new PDO(
    "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
    $config['username'],
    $config['password'],
    $config['options']
);

// Ejecutar consulta
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([1]);
$usuario = $stmt->fetch();
?>
```

### 2. Usando la Clase Avanzada

```php
<?php
require_once 'clases/ClsPDO.php';

// Crear instancia
$db = new ClsPDO();

// Consulta SELECT
$result = $db->select("SELECT * FROM usuarios WHERE estado = ?", ['activo']);
if ($result['success']) {
    foreach ($result['data'] as $usuario) {
        echo $usuario['nombre'] . "\n";
    }
}

// Transacción
$queries = [
    ['sql' => 'INSERT INTO log (accion) VALUES (?)', 'params' => ['crear']],
    ['sql' => 'UPDATE contador SET total = total + 1', 'params' => []]
];
$db->executeTransaction($queries);
?>
```

## 🔧 Configuración

### Variables de Entorno

```bash
# Configuración de base de datos
DB_HOST=localhost
DB_PORT=3306
DB_NAME=siscisne
DB_USER=usuario
DB_PASSWORD=contrasena
DB_CHARSET=utf8mb4
```

### Archivo de Configuración Personalizado

```php
<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'port' => $_ENV['DB_PORT'] ?? 3306,
    'dbname' => $_ENV['DB_NAME'] ?? 'siscisne',
    'username' => $_ENV['DB_USER'] ?? 'usuario',
    'password' => $_ENV['DB_PASSWORD'] ?? 'contrasena',
    'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    'timeout' => 30,
    'retry_attempts' => 3,
    'retry_delay' => 1000,
];
?>
```

## 📊 Ejemplos de Consultas

### SELECT con Parámetros

```php
$sql = "SELECT * FROM usuarios WHERE estado = ? AND rol = ? LIMIT ?";
$usuarios = $db->select($sql, ['activo', 'admin', 10]);
```

### INSERT con Múltiples Valores

```php
$sql = "INSERT INTO usuarios (nombre, email, estado) VALUES (?, ?, ?)";
$result = $db->insert($sql, ['Juan Pérez', 'juan@email.com', 'activo']);
$nuevo_id = $result['lastInsertId'];
```

### UPDATE con Condiciones

```php
$sql = "UPDATE usuarios SET estado = ?, fecha_modificacion = NOW() WHERE id = ?";
$result = $db->update($sql, ['inactivo', 123]);
```

### DELETE con Parámetros

```php
$sql = "DELETE FROM usuarios WHERE id = ? AND estado = ?";
$result = $db->delete($sql, [123, 'inactivo']);
```

### Transacciones Complejas

```php
$queries = [
    [
        'sql' => 'INSERT INTO usuarios (nombre, email) VALUES (?, ?)',
        'params' => ['Nuevo Usuario', 'nuevo@email.com']
    ],
    [
        'sql' => 'INSERT INTO log_usuarios (usuario_id, accion) VALUES (LAST_INSERT_ID(), ?)',
        'params' => ['crear']
    ],
    [
        'sql' => 'UPDATE contadores SET total_usuarios = total_usuarios + 1',
        'params' => []
    ]
];

$success = $db->executeTransaction($queries);
```

## 🔍 Consultas Avanzadas

### JOINs Múltiples

```php
$sql = "
    SELECT 
        u.id, u.nombre, u.email,
        r.nombre as rol_nombre,
        p.nombre as perfil_nombre
    FROM usuarios u
    LEFT JOIN roles r ON u.rol_id = r.id
    LEFT JOIN perfiles p ON u.perfil_id = p.id
    WHERE u.estado = ?
    ORDER BY u.fecha_creacion DESC
    LIMIT ?
";

$usuarios = $db->select($sql, ['activo', 20]);
```

### Agregaciones y GROUP BY

```php
$sql = "
    SELECT 
        estado,
        COUNT(*) as cantidad,
        AVG(DATEDIFF(NOW(), fecha_creacion)) as dias_promedio
    FROM usuarios
    GROUP BY estado
    ORDER BY cantidad DESC
";

$estadisticas = $db->select($sql);
```

### Paginación con SQL_CALC_FOUND_ROWS

```php
$pagina = 1;
$por_pagina = 10;
$offset = ($pagina - 1) * $por_pagina;

$sql = "
    SELECT SQL_CALC_FOUND_ROWS
        id, nombre, email, estado
    FROM usuarios
    ORDER BY fecha_creacion DESC
    LIMIT ? OFFSET ?
";

$usuarios = $db->select($sql, [$por_pagina, $offset]);

// Obtener total
$total = $db->select("SELECT FOUND_ROWS() as total")[0]['total'];
```

## 🛡️ Seguridad

### Prepared Statements

**✅ CORRECTO:**
```php
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
```

**❌ INCORRECTO:**
```php
$sql = "SELECT * FROM usuarios WHERE id = " . $id;
$stmt = $pdo->query($sql);
```

### Validación de Parámetros

```php
// Validar ID antes de usar
if (!is_numeric($id) || $id <= 0) {
    throw new InvalidArgumentException('ID inválido');
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
```

## 📈 Rendimiento

### Índices Recomendados

```sql
-- Índices para consultas comunes
CREATE INDEX idx_usuarios_estado ON usuarios(estado);
CREATE INDEX idx_usuarios_fecha_creacion ON usuarios(fecha_creacion);
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_rol_id ON usuarios(rol_id);

-- Índices compuestos
CREATE INDEX idx_usuarios_estado_fecha ON usuarios(estado, fecha_creacion);
```

### Optimización de Consultas

```php
// ✅ Usar LIMIT para consultas grandes
$sql = "SELECT * FROM usuarios WHERE estado = ? LIMIT 1000";

// ✅ Evitar SELECT * cuando sea posible
$sql = "SELECT id, nombre, email FROM usuarios WHERE estado = ?";

// ✅ Usar índices en WHERE y ORDER BY
$sql = "SELECT * FROM usuarios WHERE estado = ? ORDER BY fecha_creacion DESC";
```

## 🚨 Manejo de Errores

### Try-Catch Básico

```php
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch();
} catch (PDOException $e) {
    error_log("Error de base de datos: " . $e->getMessage());
    throw new Exception("Error interno del sistema");
}
```

### Con la Clase Avanzada

```php
$db = new ClsPDO();

$result = $db->select("SELECT * FROM usuarios WHERE id = ?", [$id]);
if (!$result['success']) {
    error_log("Error en consulta: " . $result['error']);
    throw new Exception("Error al obtener usuario");
}

$usuario = $result['data'][0] ?? null;
```

## 📝 Logging y Monitoreo

### Configuración de Logging

```php
$config = [
    'logging' => [
        'enabled' => true,
        'level' => 'INFO',
        'file' => 'logs/database.log',
    ]
];

$db = new ClsPDO($config);
```

### Estadísticas de Rendimiento

```php
$stats = $db->getStats();

echo "Consultas ejecutadas: " . $stats['queryCount'] . "\n";
echo "Tiempo de actividad: " . round($stats['uptime'], 2) . " segundos\n";
echo "Consultas por segundo: " . round($stats['queriesPerSecond'], 2) . "\n";
echo "Versión del servidor: " . $stats['serverInfo'] . "\n";
```

## 🔄 Migración desde mysqli

### Antes (mysqli)

```php
$mysqli = mysqli_connect($host, $user, $pass, $db);
$result = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id = " . $id);
$usuario = mysqli_fetch_assoc($result);
mysqli_close($mysqli);
```

### Después (PDO)

```php
$pdo = new PDO($dsn, $user, $pass, $options);
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();
$pdo = null;
```

## 🧪 Testing

### Archivo de Pruebas

```php
<?php
// test_pdo.php
require_once 'clases/ClsPDO.php';

// Configuración de prueba
$config = [
    'host' => 'localhost',
    'dbname' => 'test_siscisne',
    'username' => 'test_user',
    'password' => 'test_pass'
];

$db = new ClsPDO($config);

// Pruebas
echo "=== PRUEBAS DE CONEXIÓN PDO ===\n";

// Test 1: Conexión
echo "Test 1: Conexión - ";
if ($db->isConnected()) {
    echo "✅ PASÓ\n";
} else {
    echo "❌ FALLÓ\n";
}

// Test 2: SELECT simple
echo "Test 2: SELECT simple - ";
$result = $db->select("SELECT 1 as test");
if ($result['success'] && $result['data'][0]['test'] == 1) {
    echo "✅ PASÓ\n";
} else {
    echo "❌ FALLÓ\n";
}

// Test 3: Transacción
echo "Test 3: Transacción - ";
$queries = [
    ['sql' => 'CREATE TEMPORARY TABLE test (id INT)', 'params' => []],
    ['sql' => 'INSERT INTO test VALUES (1)', 'params' => []],
    ['sql' => 'SELECT COUNT(*) as total FROM test', 'params' => []]
];

if ($db->executeTransaction($queries)) {
    echo "✅ PASÓ\n";
} else {
    echo "❌ FALLÓ\n";
}

echo "=== PRUEBAS COMPLETADAS ===\n";
?>
```

## 📚 Recursos Adicionales

### Documentación Oficial
- [PHP PDO](https://www.php.net/manual/es/book.pdo.php)
- [MySQL PDO Driver](https://www.php.net/manual/es/ref.pdo-mysql.php)

### Mejores Prácticas
- [OWASP SQL Injection Prevention](https://owasp.org/www-community/attacks/SQL_Injection)
- [PHP Security Guide](https://www.php.net/manual/es/security.php)

### Herramientas de Monitoreo
- [MySQL Workbench](https://www.mysql.com/products/workbench/)
- [phpMyAdmin](https://www.phpmyadmin.net/)
- [Percona Monitoring](https://www.percona.com/software/database-tools/percona-monitoring-and-management)

## 🤝 Contribuciones

Para contribuir a este proyecto:

1. Fork el repositorio
2. Crea una rama para tu feature
3. Commit tus cambios
4. Push a la rama
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

**Nota:** Este archivo es parte del sistema SISCISNE. Asegúrate de adaptar la configuración a tu entorno específico antes de usar en producción.
