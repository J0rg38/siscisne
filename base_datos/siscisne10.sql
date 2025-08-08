/*
 Navicat Premium Dump SQL

 Source Server         : Cisne3
 Source Server Type    : MySQL
 Source Server Version : 50560 (5.5.60-MariaDB)
 Source Host           : 179.43.96.234:3306
 Source Schema         : siscisne10

 Target Server Type    : MySQL
 Target Server Version : 50560 (5.5.60-MariaDB)
 File Encoding         : 65001

 Date: 05/08/2025 14:27:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acompras
-- ----------------------------
DROP TABLE IF EXISTS `acompras`;
CREATE TABLE `acompras`  (
  `CODIGO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DESCRIPCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PEDIDO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FECHA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FACTURA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MONEDA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CANT.` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COSTO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COSTO TOTAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FACTURA2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for acorregir_salidas
-- ----------------------------
DROP TABLE IF EXISTS `acorregir_salidas`;
CREATE TABLE `acorregir_salidas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salida` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1921 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for acorregir_salidas2
-- ----------------------------
DROP TABLE IF EXISTS `acorregir_salidas2`;
CREATE TABLE `acorregir_salidas2`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salida` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2371 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for apablo_vines
-- ----------------------------
DROP TABLE IF EXISTS `apablo_vines`;
CREATE TABLE `apablo_vines`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for apablo_vines2
-- ----------------------------
DROP TABLE IF EXISTS `apablo_vines2`;
CREATE TABLE `apablo_vines2`  (
  `VIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COLOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AÑO FAB` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AÑO MOD` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SEDE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FECHA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PROPIETARIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TELEFONO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DNI` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PLACA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for apablo_vines_junio
-- ----------------------------
DROP TABLE IF EXISTS `apablo_vines_junio`;
CREATE TABLE `apablo_vines_junio`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 107 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for apablo_vines_junio2
-- ----------------------------
DROP TABLE IF EXISTS `apablo_vines_junio2`;
CREATE TABLE `apablo_vines_junio2`  (
  `VIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COLOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AÑO FAB` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AÑO MOD` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SUCURSAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FECHA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PROPIETARIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TELEFONO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DNI` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PLACA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for apablo_vines_septiembre
-- ----------------------------
DROP TABLE IF EXISTS `apablo_vines_septiembre`;
CREATE TABLE `apablo_vines_septiembre`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 134 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aproducto_marca
-- ----------------------------
DROP TABLE IF EXISTS `aproducto_marca`;
CREATE TABLE `aproducto_marca`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `marca` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 121577 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aproducto_marca_copy
-- ----------------------------
DROP TABLE IF EXISTS `aproducto_marca_copy`;
CREATE TABLE `aproducto_marca_copy`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `marca` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28410 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aproducto_marca_copy1
-- ----------------------------
DROP TABLE IF EXISTS `aproducto_marca_copy1`;
CREATE TABLE `aproducto_marca_copy1`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `marca` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32611 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aproducto_marca_copy2
-- ----------------------------
DROP TABLE IF EXISTS `aproducto_marca_copy2`;
CREATE TABLE `aproducto_marca_copy2`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `marca` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 77556 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aproductos_repetidos
-- ----------------------------
DROP TABLE IF EXISTS `aproductos_repetidos`;
CREATE TABLE `aproductos_repetidos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `codigo_real` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `codigo_reemplazo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `estado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 190 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for arestaurar
-- ----------------------------
DROP TABLE IF EXISTS `arestaurar`;
CREATE TABLE `arestaurar`  (
  `CODIGO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DESCRIPCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PEDIDO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FECHA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FACTURA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MONEDA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CANT.` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COSTO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COSTO TOTAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FACTURA2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for arestaurar2
-- ----------------------------
DROP TABLE IF EXISTS `arestaurar2`;
CREATE TABLE `arestaurar2`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for articulos
-- ----------------------------
DROP TABLE IF EXISTS `articulos`;
CREATE TABLE `articulos`  (
  `id_articulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `existencia` double NULL DEFAULT 0,
  `Moneda_precio` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'S/.',
  `precio_venta1` double NULL DEFAULT 0,
  `precio_venta2` double NULL DEFAULT 0,
  `precio_venta3` double NULL DEFAULT 0,
  `precio_venta4` double NULL DEFAULT 0,
  `precio_venta5` double NULL DEFAULT 0,
  `precio_venta6` double NULL DEFAULT 0,
  `localizacion` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `costo_promedio` double NULL DEFAULT 0,
  `cant_min` double NULL DEFAULT 0,
  `grupo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `unidad_medida` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Unidades',
  `Reduce_Stock` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'SI',
  `Descripcion` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `Marca` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `link_pdf` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `activo` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'SI',
  `tipo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'GENERAL',
  `indicaciones` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `costo_ultima_compra` double NULL DEFAULT 0,
  `autor` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `annoedicion` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `sub_grupo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `cant_max` double NULL DEFAULT 0,
  `modelo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'SIN DETERMINAR',
  `categoria` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `grabado_igv` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'SI',
  `id_tabla5` int(11) NOT NULL DEFAULT 1,
  `paramPrecio_venta` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `porcentPrecio_venta` int(11) NULL DEFAULT 5,
  `UsaNumSerie` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `nGenerarPedidos` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `PeriodoPedido` char(7) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'MENSUAL',
  `NumPedidosGenerados` int(11) NULL DEFAULT 1,
  `nombreVIN` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'VIN/N Serie',
  `mostrarColumnas` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'vin, id_articulo, talla, modelo, color',
  `generaDevolucion` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `nombreDevolucion` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Envase',
  `unidad_medida2` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NIU',
  `factor_conversion` double NULL DEFAULT 1,
  `peso` double NULL DEFAULT 1,
  `litros` double NULL DEFAULT 1,
  `colores` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `tallas` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `codigo_externo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod1` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unidadMedidacod1` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NIU',
  `cantidadcod1` double NULL DEFAULT 1,
  `cod2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unidadMedidacod2` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NIU',
  `cantidadcod2` double NULL DEFAULT 1,
  `limiteDescuento` int(11) NULL DEFAULT 100,
  `articulo_ligado` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto1` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto2` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto3` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto4` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto5` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto6` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto7` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto8` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto9` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto10` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `empaque` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sub_empaque` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `precio_venta7` double NULL DEFAULT 0,
  `textoPrecioVenta7` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidadPrecioVenta7` double NULL DEFAULT 1,
  `precio_venta8` double NULL DEFAULT 0,
  `textoPrecioVenta8` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidadPrecioVenta8` double NULL DEFAULT 1,
  `precio_venta9` double NULL DEFAULT 0,
  `textoPrecioVenta9` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidadPrecioVenta9` double NULL DEFAULT 1,
  `precio_venta10` double NULL DEFAULT 0,
  `textoPrecioVenta10` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidadPrecioVenta10` double NULL DEFAULT 1,
  `cod3` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod4` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod5` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod6` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod7` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod8` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod9` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod10` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `abc_q` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'D',
  `abc_p` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'D',
  `cod11` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto11` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod12` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto12` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod13` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto13` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `cod14` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `texto14` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod15` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto15` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `cod16` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto16` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `cod17` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `texto17` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod18` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto18` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `cod19` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto19` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `cod20` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `texto20` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod21` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto21` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `cod22` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto22` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `cod23` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `texto23` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod24` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `texto24` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `cod25` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto25` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `precio_venta21` double NULL DEFAULT 0,
  `textoPrecioVenta21` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidadPrecioVenta21` double NULL DEFAULT 1,
  `precio_venta22` double NULL DEFAULT 0,
  `textoPrecioVenta22` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidadPrecioVenta22` double NULL DEFAULT 1,
  `ventaRapida` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `proveedor` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `idProveedor` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `valorCompra` double NULL DEFAULT 0,
  `descuentoCompra` double NULL DEFAULT 0,
  `usaPorcentajeDescuento` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `costoCompra` double NULL DEFAULT 0,
  `utilidad` double NULL DEFAULT 0,
  `valorVenta` double NULL DEFAULT 0,
  `cantMinVenta` double NULL DEFAULT 0,
  `impresoraComanda` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Sin Impresora',
  PRIMARY KEY (`id_articulo`) USING BTREE,
  INDEX `fk_articulos_grupos1_idx`(`grupo`) USING BTREE,
  INDEX `fk_articulos_unidades1_idx`(`unidad_medida`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for astd
-- ----------------------------
DROP TABLE IF EXISTS `astd`;
CREATE TABLE `astd`  (
  `F1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aux2
-- ----------------------------
DROP TABLE IF EXISTS `aux2`;
CREATE TABLE `aux2`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tiempo` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3954507 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aux6
-- ----------------------------
DROP TABLE IF EXISTS `aux6`;
CREATE TABLE `aux6`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tiempo` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3126483 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for aux666
-- ----------------------------
DROP TABLE IF EXISTS `aux666`;
CREATE TABLE `aux666`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tiempo` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3201643 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for auxlog
-- ----------------------------
DROP TABLE IF EXISTS `auxlog`;
CREATE TABLE `auxlog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tiempo` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3117824 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for avinduaimportar
-- ----------------------------
DROP TABLE IF EXISTS `avinduaimportar`;
CREATE TABLE `avinduaimportar`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vin` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `dua` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1149 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for boletas_electronicas
-- ----------------------------
DROP TABLE IF EXISTS `boletas_electronicas`;
CREATE TABLE `boletas_electronicas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_emision` datetime NULL DEFAULT NULL,
  `firma_digital` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `razon_social` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nombre_comercial` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `domicilio_fiscal` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ruc` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo_documento` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `serie` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `correlativo` int(11) NULL DEFAULT NULL,
  `tipo_documento_adquiriente` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `documento_adquiriente` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `razon_social_adquiriente` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `total_valor_gravada` decimal(12, 2) NULL DEFAULT NULL,
  `total_valor_inafecta` decimal(12, 2) NULL DEFAULT NULL,
  `totalVentaExonerada` decimal(12, 2) NULL DEFAULT NULL,
  `total_valor_gratuito` decimal(12, 2) NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `isc` decimal(12, 2) NULL DEFAULT NULL,
  `otros_tributos` decimal(12, 2) NULL DEFAULT NULL,
  `otros_cargos` decimal(12, 2) NULL DEFAULT 0.00,
  `descuentos` decimal(12, 2) NULL DEFAULT NULL,
  `total` decimal(12, 2) NULL DEFAULT NULL,
  `percepcion_soles` decimal(12, 2) NULL DEFAULT NULL,
  `monto_total_soles` decimal(12, 2) NULL DEFAULT NULL,
  `tipo_gua_remision` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `numero_guia_remision` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_otro_documento` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `numero_otro_documento` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `monto_letras` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `leyenda` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `versio_ubl` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '2.0',
  `version_estructura_documento` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1.0',
  `tipo_moneda` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'PEN',
  `tasa_igv` int(11) NULL DEFAULT 18,
  `anulado` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO',
  `json` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `id_pedido` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tienda` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vendedor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ref` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `otros` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `guia` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `conductor` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `placa` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `viaticos` double NULL DEFAULT NULL,
  `segen1` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segen2` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segsal1` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segsal2` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usuario_creador` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `estado` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descuentoGlobal` decimal(12, 2) NULL DEFAULT 0.00,
  `porcentajeDescuentoGlobal` decimal(4, 2) NULL DEFAULT 0.00,
  `totalDescuento` decimal(12, 2) NULL DEFAULT 0.00,
  `totalVentaGratuita` decimal(12, 2) NULL DEFAULT 0.00,
  `fechaVencimiento` date NULL DEFAULT NULL,
  `checkin` datetime NULL DEFAULT NULL,
  `checkout` datetime NULL DEFAULT NULL,
  `grupoHotel` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipoPago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `observaciones` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estado2` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `habitacion` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16991 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for boletas_electronicas_detalle
-- ----------------------------
DROP TABLE IF EXISTS `boletas_electronicas_detalle`;
CREATE TABLE `boletas_electronicas_detalle`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serie` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `correlativo` int(11) NOT NULL,
  `ruc` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_articulo` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `unidad_medida` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidad` decimal(12, 3) NULL DEFAULT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `precio_venta_unitario` decimal(12, 2) NULL DEFAULT NULL,
  `afectacion_igv` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `sistema_isc` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `isc` decimal(12, 2) NULL DEFAULT NULL,
  `valor_unitario` decimal(12, 2) NULL DEFAULT NULL,
  `valor_unitario_no_onerosas` decimal(12, 2) NULL DEFAULT NULL,
  `valor_total` decimal(12, 2) NULL DEFAULT NULL,
  `descuento` decimal(12, 2) NULL DEFAULT 0.00,
  `porcentajeDescuento` decimal(12, 2) NULL DEFAULT 0.00,
  `tipoPrecioVentaUnitario` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '01',
  `cantidad_impresion` double NULL DEFAULT NULL,
  `unidad_impresion` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `valor_unitario_impresion` double NULL DEFAULT NULL,
  `precio_unitario_impresion` double NULL DEFAULT NULL,
  `factor` double NULL DEFAULT NULL,
  `id_comanda` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57743 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for codigosrepuestos
-- ----------------------------
DROP TABLE IF EXISTS `codigosrepuestos`;
CREATE TABLE `codigosrepuestos`  (
  `codigo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas
-- ----------------------------
DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas`  (
  `tipo_entrada` int(11) NOT NULL DEFAULT 1,
  `folio_factura` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `fecha_factura` datetime NULL DEFAULT NULL,
  `proveedor` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `total` double NULL DEFAULT NULL,
  `base_imponible` double NULL DEFAULT 0,
  `igv` double NULL DEFAULT 0,
  `moneda` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo_cambio` double NULL DEFAULT NULL,
  `estado` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `user_login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha_entrada` date NULL DEFAULT NULL,
  `fecha_registro` date NULL DEFAULT NULL,
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `id_almacen` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `id_empresa` int(11) NULL DEFAULT NULL,
  `transportista` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `costo_flete` double NULL DEFAULT 0,
  `estado_pago` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'PAGADA - CANCELADA',
  `saldo` double NULL DEFAULT 0,
  `ruc_proveedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `direccion_proveedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `tipo_bien_servicio` int(11) NULL DEFAULT NULL,
  `otros_guiaremision` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `otros_personalrecibiomercaderia` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `otros_descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `id_tabla12` int(11) NULL DEFAULT NULL,
  `fecha_vencimiento` date NULL DEFAULT NULL,
  `incluyeIGV` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `id_costo` int(11) NULL DEFAULT 2,
  `id_glosa` int(11) NULL DEFAULT 70,
  `orden_compra` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `totalBruto` double NULL DEFAULT 0,
  `totalDescuentos` double NULL DEFAULT 0,
  PRIMARY KEY (`id_entrada`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11394 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas2
-- ----------------------------
DROP TABLE IF EXISTS `entradas2`;
CREATE TABLE `entradas2`  (
  `tipo_entrada` int(11) NOT NULL DEFAULT 1,
  `folio_factura` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fecha_factura` datetime NULL DEFAULT NULL,
  `proveedor` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `total` double NULL DEFAULT NULL,
  `base_imponible` double NULL DEFAULT 0,
  `igv` double NULL DEFAULT 0,
  `moneda` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo_cambio` double NULL DEFAULT NULL,
  `estado` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `user_login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha_entrada` date NULL DEFAULT NULL,
  `fecha_registro` date NULL DEFAULT NULL,
  `id_entrada` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_almacen` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `id_empresa` int(11) NULL DEFAULT NULL,
  `transportista` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `costo_flete` double NULL DEFAULT 0,
  `estado_pago` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'PAGADA - CANCELADA',
  `saldo` double NULL DEFAULT 0,
  `ruc_proveedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `direccion_proveedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `tipo_bien_servicio` int(11) NULL DEFAULT NULL,
  `otros_guiaremision` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `otros_personalrecibiomercaderia` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `otros_descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `id_tabla12` int(11) NULL DEFAULT NULL,
  `fecha_vencimiento` date NULL DEFAULT NULL,
  `incluyeIGV` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `id_costo` int(11) NULL DEFAULT 2,
  `id_glosa` int(11) NULL DEFAULT 70,
  `orden_compra` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_entrada`) USING BTREE,
  INDEX `fk_entradas_users1_idx`(`user_login`) USING BTREE,
  INDEX `costoEntrada_idx`(`id_costo`) USING BTREE,
  INDEX `glosaEntrada_idx`(`id_glosa`) USING BTREE,
  CONSTRAINT `costoEntrada` FOREIGN KEY (`id_costo`) REFERENCES `centro_costos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `glosaEntrada` FOREIGN KEY (`id_glosa`) REFERENCES `glosas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas333
-- ----------------------------
DROP TABLE IF EXISTS `entradas333`;
CREATE TABLE `entradas333`  (
  `tipo_entrada` int(11) NOT NULL DEFAULT 1,
  `folio_factura` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `fecha_factura` datetime NULL DEFAULT NULL,
  `proveedor` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `total` double NULL DEFAULT NULL,
  `base_imponible` double NULL DEFAULT 0,
  `igv` double NULL DEFAULT 0,
  `moneda` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo_cambio` double NULL DEFAULT NULL,
  `estado` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `user_login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha_entrada` date NULL DEFAULT NULL,
  `fecha_registro` date NULL DEFAULT NULL,
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `id_almacen` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `id_empresa` int(11) NULL DEFAULT NULL,
  `transportista` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `costo_flete` double NULL DEFAULT 0,
  `estado_pago` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'PAGADA - CANCELADA',
  `saldo` double NULL DEFAULT 0,
  `ruc_proveedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `direccion_proveedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `tipo_bien_servicio` int(11) NULL DEFAULT NULL,
  `otros_guiaremision` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `otros_personalrecibiomercaderia` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `otros_descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '-',
  `id_tabla12` int(11) NULL DEFAULT NULL,
  `fecha_vencimiento` date NULL DEFAULT NULL,
  `incluyeIGV` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `id_costo` int(11) NULL DEFAULT 2,
  `id_glosa` int(11) NULL DEFAULT 70,
  `orden_compra` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `totalBruto` double NULL DEFAULT 0,
  `totalDescuentos` double NULL DEFAULT 0,
  PRIMARY KEY (`id_entrada`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11394 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas_detalle
-- ----------------------------
DROP TABLE IF EXISTS `entradas_detalle`;
CREATE TABLE `entradas_detalle`  (
  `id_entrada_detalla` int(11) NOT NULL AUTO_INCREMENT,
  `id_entrada` int(11) NULL DEFAULT NULL,
  `id_articulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `precio_compra` double NULL DEFAULT NULL,
  `iva` double NULL DEFAULT NULL,
  `ref` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `precio_prorrateado` double NULL DEFAULT 0,
  `cta_contable` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gravado` bit(1) NULL DEFAULT b'1',
  `lote` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fechaUtil` date NULL DEFAULT NULL,
  `porrecibir` double NULL DEFAULT 0,
  `unidad_medida` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NIU',
  `porcentaje` int(11) NULL DEFAULT 0,
  `descuento` decimal(20, 5) NULL DEFAULT 0.00000,
  `porcentajeDescuento` decimal(8, 5) NULL DEFAULT 0.00000,
  PRIMARY KEY (`id_entrada_detalla`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31776 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas_detalle2
-- ----------------------------
DROP TABLE IF EXISTS `entradas_detalle2`;
CREATE TABLE `entradas_detalle2`  (
  `id_entrada_detalla` int(11) NOT NULL AUTO_INCREMENT,
  `id_entrada` int(11) NULL DEFAULT NULL,
  `id_articulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `precio_compra` double NULL DEFAULT NULL,
  `iva` double NULL DEFAULT NULL,
  `ref` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `precio_prorrateado` double NULL DEFAULT 0,
  `cta_contable` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `gravado` bit(1) NULL DEFAULT b'1',
  `lote` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fechaUtil` date NULL DEFAULT NULL,
  `porrecibir` double NULL DEFAULT 0,
  `unidad_medida` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NIU',
  `porcentaje` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`id_entrada_detalla`) USING BTREE,
  INDEX `fk_entradas_detalle_articulos1_idx`(`id_articulo`) USING BTREE,
  INDEX `fk_entradas_detalle_entradas1_idx`(`id_entrada`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30061 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entradas_detalle333
-- ----------------------------
DROP TABLE IF EXISTS `entradas_detalle333`;
CREATE TABLE `entradas_detalle333`  (
  `id_entrada_detalla` int(11) NOT NULL AUTO_INCREMENT,
  `id_entrada` int(11) NULL DEFAULT NULL,
  `id_articulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `precio_compra` double NULL DEFAULT NULL,
  `iva` double NULL DEFAULT NULL,
  `ref` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `precio_prorrateado` double NULL DEFAULT 0,
  `cta_contable` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gravado` bit(1) NULL DEFAULT b'1',
  `lote` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fechaUtil` date NULL DEFAULT NULL,
  `porrecibir` double NULL DEFAULT 0,
  `unidad_medida` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NIU',
  `porcentaje` int(11) NULL DEFAULT 0,
  `descuento` decimal(20, 5) NULL DEFAULT 0.00000,
  `porcentajeDescuento` decimal(8, 5) NULL DEFAULT 0.00000,
  PRIMARY KEY (`id_entrada_detalla`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31776 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entregas2019
-- ----------------------------
DROP TABLE IF EXISTS `entregas2019`;
CREATE TABLE `entregas2019`  (
  `CLIENTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MODELO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VI` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ASESOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FECHA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for facturas_electronicas
-- ----------------------------
DROP TABLE IF EXISTS `facturas_electronicas`;
CREATE TABLE `facturas_electronicas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_emision` datetime NULL DEFAULT NULL,
  `firma_digital` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `razon_social` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nombre_comercial` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `domicilio_fiscal` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ruc` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_documento` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `serie` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `correlativo` int(11) NULL DEFAULT NULL,
  `tipo_documento_adquiriente` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `documento_adquiriente` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `razon_social_adquiriente` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `total_valor_gravada` decimal(12, 2) NULL DEFAULT NULL,
  `total_valor_inafecta` decimal(12, 2) NULL DEFAULT NULL,
  `totalVentaExonerada` decimal(12, 2) NULL DEFAULT NULL,
  `total_valor_gratuito` decimal(12, 2) NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `isc` decimal(12, 2) NULL DEFAULT NULL,
  `otros_tributos` decimal(12, 2) NULL DEFAULT NULL,
  `otros_cargos` decimal(12, 2) NULL DEFAULT 0.00,
  `descuentos` decimal(12, 2) NULL DEFAULT NULL,
  `total` decimal(12, 2) NULL DEFAULT NULL,
  `percepcion_soles` decimal(12, 2) NULL DEFAULT NULL,
  `monto_total_soles` decimal(12, 2) NULL DEFAULT NULL,
  `tipo_gua_remision` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `numero_guia_remision` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_otro_documento` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `numero_otro_documento` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `monto_letras` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `leyenda` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `versio_ubl` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '2.0',
  `version_estructura_documento` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1.0',
  `tipo_moneda` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'PEN',
  `tasa_igv` int(11) NULL DEFAULT 18,
  `anulado` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO',
  `json` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `id_pedido` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tienda` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vendedor` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ref` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `otros` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `guia` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `conductor` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `placa` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `viaticos` double NULL DEFAULT NULL,
  `segen1` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segen2` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segsal1` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segsal2` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usuario_creador` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `estado` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descuentoGlobal` decimal(12, 2) NULL DEFAULT 0.00,
  `porcentajeDescuentoGlobal` decimal(8, 5) NULL DEFAULT 0.00000,
  `totalDescuento` decimal(12, 2) NULL DEFAULT 0.00,
  `totalVentaGratuita` decimal(12, 2) NULL DEFAULT 0.00,
  `fechaVencimiento` date NULL DEFAULT NULL,
  `checkin` datetime NULL DEFAULT NULL,
  `checkout` datetime NULL DEFAULT NULL,
  `grupoHotel` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipoPago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `observaciones` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estado2` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `habitacion` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4028 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for facturas_electronicas_detalle
-- ----------------------------
DROP TABLE IF EXISTS `facturas_electronicas_detalle`;
CREATE TABLE `facturas_electronicas_detalle`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serie` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `correlativo` int(11) NOT NULL,
  `ruc` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_articulo` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `unidad_medida` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidad` decimal(12, 3) NULL DEFAULT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `precio_venta_unitario` decimal(12, 2) NULL DEFAULT NULL,
  `afectacion_igv` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `sistema_isc` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `isc` decimal(12, 2) NULL DEFAULT NULL,
  `valor_unitario` decimal(12, 2) NULL DEFAULT NULL,
  `valor_unitario_no_onerosas` decimal(12, 2) NULL DEFAULT NULL,
  `valor_total` decimal(12, 2) NULL DEFAULT NULL,
  `descuento` decimal(12, 2) NULL DEFAULT 0.00,
  `porcentajeDescuento` decimal(12, 2) NULL DEFAULT 0.00,
  `tipoPrecioVentaUnitario` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '01',
  `guia` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `placa` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `cantidad_impresion` double NULL DEFAULT NULL,
  `unidad_impresion` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `valor_unitario_impresion` double NULL DEFAULT NULL,
  `precio_unitario_impresion` double NULL DEFAULT NULL,
  `factor` double NULL DEFAULT NULL,
  `id_comanda` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19575 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for kardex2018
-- ----------------------------
DROP TABLE IF EXISTS `kardex2018`;
CREATE TABLE `kardex2018`  (
  `id_articulo1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `articulo1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `marca` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `modelo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `categoria` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo_salida` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha_ultima_entrada` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha_ultima_salida` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `detalle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `documento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cant_entra` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `valor_entra` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `importe_entra` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cant_salida` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `valor_salida` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `importe_salida` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cant_saldo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `valor_saldo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `importe_saldo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for listaprecios
-- ----------------------------
DROP TABLE IF EXISTS `listaprecios`;
CREATE TABLE `listaprecios`  (
  `id` int(20) NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `costo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `unidad` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_credito_electronica
-- ----------------------------
DROP TABLE IF EXISTS `nota_credito_electronica`;
CREATE TABLE `nota_credito_electronica`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serie` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `correlativo` int(11) NULL DEFAULT NULL,
  `fecha_emision` datetime NULL DEFAULT NULL,
  `firma_digital` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `razon_social` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nombre_comercial` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `domicilio_fiscal` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ruc` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_documento` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `documento_adquiriente` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_documento_adquiriente` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `razon_social_adquiriente` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `total_valor_gravada` decimal(12, 2) NULL DEFAULT NULL,
  `total_valor_inafecta` decimal(12, 2) NULL DEFAULT NULL,
  `TotalVentaExonerada` decimal(12, 2) NULL DEFAULT NULL,
  `total_valor_gratuito` decimal(12, 2) NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `isc` decimal(12, 2) NULL DEFAULT NULL,
  `total` decimal(12, 2) NULL DEFAULT NULL,
  `tipo_moneda` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `serie_modifica` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `correlativo_modifica` int(11) NULL DEFAULT NULL,
  `tipo_documento_modifica` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_nota_credito_electronica` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `motivo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `json` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estado` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tienda` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usuario_creador` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `monto_letras` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `descuentoGlobal` decimal(12, 2) NULL DEFAULT 0.00,
  `porcentajeDescuentoGlobal` decimal(8, 5) NULL DEFAULT 0.00000,
  `totalDescuento` decimal(12, 2) NULL DEFAULT 0.00,
  `totalVentaGratuita` decimal(12, 2) NULL DEFAULT 0.00,
  `vendedor` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `otros_cargos` decimal(12, 2) NULL DEFAULT 0.00,
  `estado2` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `observaciones` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1455 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nota_credito_electronica_detalle
-- ----------------------------
DROP TABLE IF EXISTS `nota_credito_electronica_detalle`;
CREATE TABLE `nota_credito_electronica_detalle`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serie` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `correlativo` int(11) NULL DEFAULT NULL,
  `ruc` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_articulo` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unidad_medida` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidad` decimal(12, 3) NULL DEFAULT NULL,
  `articulo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `precio_venta_unitario` decimal(12, 2) NULL DEFAULT NULL,
  `afectacion_igv` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `sistema_isc` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `isc` decimal(12, 2) NULL DEFAULT NULL,
  `valor_unitario` decimal(12, 2) NULL DEFAULT NULL,
  `precio_venta` decimal(12, 2) NULL DEFAULT NULL,
  `valor_total` decimal(12, 2) NULL DEFAULT NULL,
  `descuento` decimal(12, 2) NULL DEFAULT 0.00,
  `porcentajeDescuento` decimal(15, 5) NULL DEFAULT 0.00000,
  `tipoPrecioVentaUnitario` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '01',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3209 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salidas
-- ----------------------------
DROP TABLE IF EXISTS `salidas`;
CREATE TABLE `salidas`  (
  `id_salida` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` date NULL DEFAULT NULL,
  `fecha_salida` date NULL DEFAULT NULL,
  `responsable` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `user_login` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `placa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `cliente` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `cartilla` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `estado` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `id_almacen` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tipo_salida` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Taller',
  `id_tabla10` int(11) NOT NULL DEFAULT 1,
  `documento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `id_tabla12` int(11) NULL DEFAULT NULL,
  `id_NotaCreditoRecibida` int(11) NULL DEFAULT NULL,
  `tipo_referencia` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nro_referencia` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `observaciones` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `id_tercero` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `moneda` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `subtotal` decimal(16, 6) NULL DEFAULT NULL,
  `igv` decimal(16, 6) NULL DEFAULT NULL,
  `total` decimal(16, 6) NULL DEFAULT NULL,
  `tipo_cambio` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `documento2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `documento3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_salida`) USING BTREE,
  INDEX `fk_salidas_users1_idx`(`user_login`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 90909 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salidas_detalle
-- ----------------------------
DROP TABLE IF EXISTS `salidas_detalle`;
CREATE TABLE `salidas_detalle`  (
  `id_salida_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_salida` int(11) NULL DEFAULT NULL,
  `id_articulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `precio_ultima_compra` double NULL DEFAULT 0,
  `precio_promedio` double NULL DEFAULT 0,
  `observaciones` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `precio` decimal(16, 6) NULL DEFAULT NULL,
  `importe` decimal(16, 6) NULL DEFAULT NULL,
  PRIMARY KEY (`id_salida_detalle`) USING BTREE,
  INDEX `fk_salidas_detalle_articulos1_idx`(`id_articulo`) USING BTREE,
  INDEX `fk_salidas_detalle_salidas1_idx`(`id_salida`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 163275 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for servicios
-- ----------------------------
DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios`  (
  `id_servicios` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `servicios` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `RUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `razon_social` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `direccion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fecha` datetime NULL DEFAULT NULL,
  `fecha_entrega` date NULL DEFAULT NULL,
  `total` double NULL DEFAULT NULL,
  `total_dolares` double NULL DEFAULT NULL,
  `moneda` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_pago` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `saldo` double NULL DEFAULT 0,
  `saldo_dolares` double NULL DEFAULT 0,
  `documento` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NINGUNO',
  `observaciones` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usuario_creador` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `aprobado` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'SI',
  `anulado` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `fecha_anulado` date NULL DEFAULT NULL,
  `usuario_anulo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `motivo_anula` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cancelado` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `ref` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `id_tienda` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '-',
  `vendedor` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `otros` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `placa` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `kilometraje` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `garantia` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `direccion2` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `EstadoGeneral` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ABIERTO',
  `fecha_EstadoGeneral` date NULL DEFAULT NULL,
  `usuario_EstadoGeneral` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_salida` int(11) NULL DEFAULT 0,
  `IdCotizacion` int(11) NULL DEFAULT 0,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `total_gravado` decimal(12, 2) NULL DEFAULT NULL,
  `total_exonerado` decimal(12, 2) NULL DEFAULT NULL,
  `total_inafecto` decimal(12, 2) NULL DEFAULT NULL,
  `descuento` double NULL DEFAULT 0,
  `porcentaje` double NULL DEFAULT 0,
  `bonificacion` double NULL DEFAULT 0,
  `totalDescuento` double NULL DEFAULT 0,
  `mantenimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `reparacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `campaña` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pyp` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lavado` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cliente` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `reingreso` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `detalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `horaEntrega` time NULL DEFAULT NULL,
  `fechaEntregaEfectiva` date NULL DEFAULT NULL,
  `horaEntregaEfectiva` time NULL DEFAULT NULL,
  `tPropiedad` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pDeLunas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `luzSalonDel` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `luzSalonPost` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emblemaDel` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emblemaPost` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tSoat` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sticketSoat` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `luzChica` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `luzAlta` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tapaAceite` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `radiador` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cServicio` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `manual` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `espejoInterior` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `espejoExterior` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tapaCombustible` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `topes` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `llavero` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `llaves` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `control` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fundas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pisos` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ltaRtoNueva` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ltaRtoUsada` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segRuedas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `segVasos` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `brazo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `plumilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tapas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `gata` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `palanca` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `radio` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mascara` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cd` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `antenaNormal` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `antenaElectrica` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `llaveRuedas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `boca` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `encendedor` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cenicero` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `frenoEstacionamiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trinagSeguridad` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `alicate` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `parlantesDel` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `parlantesPost` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `vasos` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `copas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `escarpines` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `extintor` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `botiquin` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `emblemaPosterior` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `contacto` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fono1` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fono2` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fechaIngreso` date NULL DEFAULT NULL,
  `horaIngreso` time NULL DEFAULT NULL,
  `tipo_salida` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `id_costo` int(11) NULL DEFAULT 2,
  `id_glosa` int(11) NULL DEFAULT 542,
  `usuario_autorizo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `equipo` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `condiciones` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `informe` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `recomendaciones` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id_servicios`) USING BTREE,
  INDEX `costo`(`id_costo`) USING BTREE,
  INDEX `glosa`(`id_glosa`) USING BTREE,
  CONSTRAINT `costo` FOREIGN KEY (`id_costo`) REFERENCES `centro_costos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `glosa` FOREIGN KEY (`id_glosa`) REFERENCES `glosas` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for servicios_detalle
-- ----------------------------
DROP TABLE IF EXISTS `servicios_detalle`;
CREATE TABLE `servicios_detalle`  (
  `id_detalles_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `id_servicio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `id_articulo` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `articulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `precio_unitario` double NULL DEFAULT NULL,
  `total` double NULL DEFAULT NULL,
  `precio_promedio` double NULL DEFAULT 0,
  `precio_ultima_compra` double NULL DEFAULT 0,
  `usuario_cambiocosto` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fecha_cambiocosto` datetime NULL DEFAULT NULL,
  `detalle_cambiocosto` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `igv` decimal(12, 2) NULL DEFAULT NULL,
  `afectacion_igv` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descuento` double NULL DEFAULT 0,
  `porcentaje` double NULL DEFAULT 0,
  `tipoPrecioVentaUnitario` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '01',
  `asignado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_ocstdetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `detalle` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id_detalles_servicio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 221702 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblacialmacencierre
-- ----------------------------
DROP TABLE IF EXISTS `tblacialmacencierre`;
CREATE TABLE `tblacialmacencierre`  (
  `AciId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AciFechaInicio` date NOT NULL,
  `AciFechaFin` datetime NULL DEFAULT NULL,
  `AciObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AciEntradasTotalCompras` decimal(16, 6) NULL DEFAULT NULL,
  `AciEntradasTotalOtrasFichas` decimal(16, 6) NULL DEFAULT NULL,
  `AciEntradasTotalTransferencias` decimal(16, 6) NULL DEFAULT NULL,
  `AciEntradasTotalConversiones` decimal(16, 6) NULL DEFAULT NULL,
  `AciSalidasTotalFichaIngresos` decimal(16, 6) NULL DEFAULT NULL,
  `AciSalidasTotalVentaConcretadas` decimal(16, 6) NULL DEFAULT NULL,
  `AciSalidasTotalOtrasFichas` decimal(16, 6) NULL DEFAULT NULL,
  `AciSalidasTotalConversiones` decimal(16, 6) NULL DEFAULT NULL,
  `AciSalidasTotalTransferencias` decimal(16, 6) NULL DEFAULT NULL,
  `AciEstado` tinyint(1) NOT NULL,
  `AciTiempoCreacion` datetime NOT NULL,
  `AciTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`AciId`) USING BTREE,
  INDEX `FK_ACI_PERID_idx`(`PerId`) USING BTREE,
  CONSTRAINT `FK_ACI_PERID` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblalmalmacen
-- ----------------------------
DROP TABLE IF EXISTS `tblalmalmacen`;
CREATE TABLE `tblalmalmacen`  (
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmSigla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AlmDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmDistrito` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmProvincia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmDepartamento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmEstado` tinyint(1) NOT NULL DEFAULT 0,
  `AlmTiempoCreacion` datetime NULL DEFAULT NULL,
  `AlmTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`AlmId`) USING BTREE,
  INDEX `FK_ALM_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `FK_ALM_SUCID` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle`;
CREATE TABLE `tblamdalmacenmovimientodetalle`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProIdAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdAux3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle050219
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle050219`;
CREATE TABLE `tblamdalmacenmovimientodetalle050219`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProIdAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle050219_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle140119
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle140119`;
CREATE TABLE `tblamdalmacenmovimientodetalle140119`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle140119_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle_copy`;
CREATE TABLE `tblamdalmacenmovimientodetalle_copy`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle_copy1
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle_copy1`;
CREATE TABLE `tblamdalmacenmovimientodetalle_copy1`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle_copy2
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle_copy2`;
CREATE TABLE `tblamdalmacenmovimientodetalle_copy2`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy2_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle_copy3
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle_copy3`;
CREATE TABLE `tblamdalmacenmovimientodetalle_copy3`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy3_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamdalmacenmovimientodetalle_copy4
-- ----------------------------
DROP TABLE IF EXISTS `tblamdalmacenmovimientodetalle_copy4`;
CREATE TABLE `tblamdalmacenmovimientodetalle_copy4`  (
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdCantidad` decimal(10, 3) NOT NULL,
  `AmdCantidadReal` decimal(16, 6) NOT NULL,
  `AmdCosto` decimal(16, 6) NOT NULL,
  `AmdCostoAnterior` decimal(16, 6) NOT NULL,
  `AmdCostoExtraTotal` decimal(16, 6) NOT NULL,
  `AmdCostoExtraUnitario` decimal(16, 6) NOT NULL,
  `AmdValorTotal` decimal(16, 6) NOT NULL,
  `AmdUtilidad` decimal(16, 6) NOT NULL,
  `AmdPrecioVenta` decimal(16, 6) NOT NULL,
  `AmdImporte` decimal(16, 6) NOT NULL,
  `AmdCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmdCostoPromedio` decimal(16, 6) NOT NULL,
  `AmdInternacionalTotalAduana` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalTransporte` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalDesestiba` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAlmacenaje` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAdValorem` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalAduanaNacional` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalGastoAdministrativo` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto1` decimal(10, 3) NOT NULL,
  `AmdInternacionalTotalOtroCosto2` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalRecargo` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalFlete` decimal(10, 3) NOT NULL,
  `AmdNacionalTotalOtroCosto` decimal(10, 3) NOT NULL,
  `AmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdReingreso` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdFecha` date NULL DEFAULT NULL,
  `AmdCierre` tinyint(1) NULL DEFAULT NULL,
  `AmdCompraOrigen` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmdMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmdEstado` tinyint(1) NOT NULL,
  `AmdTiempoCreacion` datetime NOT NULL,
  `AmdTiempoModificacion` datetime NOT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxIdDetalle` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProIdAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmdId`) USING BTREE,
  INDEX `FK_AMD_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_AMD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_AMD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_AMD_AMDIDANTERIOR_idx`(`AmdIdAnterior`) USING BTREE,
  INDEX `FK_AMD_FAAID_idx`(`FaaId`) USING BTREE,
  INDEX `FK_AMD_VDDID_idx`(`VddId`) USING BTREE,
  INDEX `FK_AMD_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_AMD_PPDID`(`PpdId`) USING BTREE,
  INDEX `FK_AMD_TADID`(`TadId`) USING BTREE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_1` FOREIGN KEY (`AmdIdAnterior`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_3` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_4` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_5` FOREIGN KEY (`PpdId`) REFERENCES `tblppdproduccionproductodetalle` (`PpdId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_6` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_7` FOREIGN KEY (`TadId`) REFERENCES `tbltadtrasladoalmacendetalle` (`TadId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_8` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamdalmacenmovimientodetalle_copy4_ibfk_9` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento`;
CREATE TABLE `tblamoalmacenmovimiento`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAux3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumeroAux` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_10` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_11` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_12` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_13` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_2` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_3` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_4` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_5` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_6` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_7` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_8` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_ibfk_9` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento050219
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento050219`;
CREATE TABLE `tblamoalmacenmovimiento050219`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento050219_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento140119
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento140119`;
CREATE TABLE `tblamoalmacenmovimiento140119`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140119_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento140918
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento140918`;
CREATE TABLE `tblamoalmacenmovimiento140918`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_10` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_11` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_12` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_2` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_3` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_4` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_5` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_6` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_7` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_8` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento140918_ibfk_9` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_comparar
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_comparar`;
CREATE TABLE `tblamoalmacenmovimiento_comparar`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAux3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_comparar_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_copy`;
CREATE TABLE `tblamoalmacenmovimiento_copy`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_copy1
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_copy1`;
CREATE TABLE `tblamoalmacenmovimiento_copy1`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_copy2
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_copy2`;
CREATE TABLE `tblamoalmacenmovimiento_copy2`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy2_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_copy3
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_copy3`;
CREATE TABLE `tblamoalmacenmovimiento_copy3`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy3_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_copy4
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_copy4`;
CREATE TABLE `tblamoalmacenmovimiento_copy4`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy4_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblamoalmacenmovimiento_copy5
-- ----------------------------
DROP TABLE IF EXISTS `tblamoalmacenmovimiento_copy5`;
CREATE TABLE `tblamoalmacenmovimiento_copy5`  (
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `AmoFecha` date NOT NULL,
  `AmoDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoDocumentoOrigen` tinyint(1) NOT NULL,
  `AmoResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoGuiaRemisionFecha` date NULL DEFAULT NULL,
  `AmoGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `AmoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `AmoPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `AmoPorcentajeMantenimiento` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalFlete` decimal(10, 3) NULL DEFAULT NULL,
  `AmoNacionalTotalOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduana` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalTransporte` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalDesestiba` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAlmacenaje` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAdValorem` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalAduanaNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalGastoAdministrativo` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto1` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalTotalOtroCosto2` decimal(10, 3) NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoInternacionalNumeroComprobante9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalNumeroComprobante3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdInternacional9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvIdNacional3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTotalInternacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoTotalNacional` decimal(10, 3) NULL DEFAULT NULL,
  `AmoMargenUtilidad` decimal(10, 3) NULL DEFAULT NULL,
  `AmoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `AmoSubTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoDescuento` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoImpuesto` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoTotal` decimal(16, 6) NULL DEFAULT 0.000000,
  `AmoSubTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoImpuestoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTotalReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoNacionalTotalRecargoReal` decimal(16, 6) NULL DEFAULT NULL,
  `AmoTipo` tinyint(2) NOT NULL,
  `AmoSubTipo` tinyint(2) NOT NULL,
  `AmoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoIgnorar` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoCancelado` tinyint(1) NOT NULL DEFAULT 2,
  `AmoRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `AmoNacionalFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoNacionalFoto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoFacturable` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '1',
  `AmoEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteClave` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteFecha` date NULL DEFAULT NULL,
  `AmoEmpresaTransporteTipoEnvio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEmpresaTransporteDestino` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoTipoMovimiento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoEstado` tinyint(1) NOT NULL,
  `AmoTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `AmoCierre` tinyint(1) NULL DEFAULT NULL,
  `AmoValidarStock` tinyint(1) NULL DEFAULT NULL,
  `AmoTiempoCreacion` datetime NOT NULL,
  `AmoTiempoModificacion` datetime NOT NULL,
  `AmoMigrado` tinyint(1) NULL DEFAULT NULL,
  `AmoUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCartilla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoAuxCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoComprobanteFecha2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AmoId`) USING BTREE,
  INDEX `FK_AMO_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_AMO_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_AMO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_AMO_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_AMO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_AMO_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_AMO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_AMO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_AMO_TALID`(`TalId`) USING BTREE,
  INDEX `FK_AMO_AMOIDORIGEN`(`AmoIdOrigen`) USING BTREE,
  INDEX `FK_AMO_LTIID`(`LtiId`) USING BTREE,
  INDEX `FK_AMO_PPRID`(`PprId`) USING BTREE,
  INDEX `FK_AMO_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_1` FOREIGN KEY (`AmoIdOrigen`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_10` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_11` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_12` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_13` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_2` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_3` FOREIGN KEY (`TalId`) REFERENCES `tbltaltrasladoalmacen` (`TalId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_4` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_6` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_7` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_8` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblamoalmacenmovimiento_copy5_ibfk_9` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblapralmacenproducto
-- ----------------------------
DROP TABLE IF EXISTS `tblapralmacenproducto`;
CREATE TABLE `tblapralmacenproducto`  (
  `AprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AlmId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AprAno` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AprStock` decimal(16, 6) NOT NULL,
  `AprStockReal` decimal(16, 6) NOT NULL,
  `AprStockRealIngresado` decimal(16, 6) NULL DEFAULT NULL,
  `AprObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AprObservacionInicial` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AprUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AprFechaUltimaEntrada` date NULL DEFAULT NULL,
  `AprFechaUltimaSalida` date NULL DEFAULT NULL,
  `AprEstado` tinyint(1) NOT NULL DEFAULT 0,
  `AprTiempoCreacion` datetime NULL DEFAULT NULL,
  `AprTiempoModificacion` datetime NULL DEFAULT NULL,
  `AprStockMinimo` decimal(10, 3) NULL DEFAULT 0.000,
  `AprStockMaximo` decimal(10, 3) NULL DEFAULT 0.000,
  PRIMARY KEY (`AprId`) USING BTREE,
  INDEX `FK_APR_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_APR_ALMID_idx`(`AlmId`) USING BTREE,
  CONSTRAINT `tblapralmacenproducto_ibfk_1` FOREIGN KEY (`AlmId`) REFERENCES `tblalmalmacen` (`AlmId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblapralmacenproducto_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblarcarchivos
-- ----------------------------
DROP TABLE IF EXISTS `tblarcarchivos`;
CREATE TABLE `tblarcarchivos`  (
  `ArcId` int(10) NOT NULL AUTO_INCREMENT,
  `CpId` int(10) NULL DEFAULT NULL,
  `TpaId` int(11) NULL DEFAULT NULL,
  `ArcNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ArcEstado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ArcRuta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ArcFechaCreacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ArcFechaModificacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ArcId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblarearea
-- ----------------------------
DROP TABLE IF EXISTS `tblarearea`;
CREATE TABLE `tblarearea`  (
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AreNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AreDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AreUso` tinyint(1) NULL DEFAULT NULL,
  `AreEstado` tinyint(1) NOT NULL DEFAULT 0,
  `AreTiempoCreacion` datetime NOT NULL,
  `AreTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`AreId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblaucaulavirtualcurso
-- ----------------------------
DROP TABLE IF EXISTS `tblaucaulavirtualcurso`;
CREATE TABLE `tblaucaulavirtualcurso`  (
  `AucId` int(11) NOT NULL AUTO_INCREMENT,
  `AuvId` int(11) NULL DEFAULT NULL,
  `AucNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AucEstado` int(1) NULL DEFAULT NULL,
  `AucDescripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `AucDuracion` int(10) NULL DEFAULT NULL,
  `AucFechaCreacion` date NULL DEFAULT NULL,
  `AucPortada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AucId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblaudauditoria
-- ----------------------------
DROP TABLE IF EXISTS `tblaudauditoria`;
CREATE TABLE `tblaudauditoria`  (
  `AudId` int(20) NOT NULL AUTO_INCREMENT,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudIP` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudCodigo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '',
  `AudPersonal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudAccion` tinyint(1) NOT NULL,
  `AudDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudDatos` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AudTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`AudId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 926713 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblaudauditoria_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblaudauditoria_copy`;
CREATE TABLE `tblaudauditoria_copy`  (
  `AudId` int(20) NOT NULL AUTO_INCREMENT,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudIP` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudCodigo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudUsuario` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `AudPersonal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudAccion` tinyint(1) NOT NULL,
  `AudDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudDatos` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AudTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`AudId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 104832 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblaudauditoriav2
-- ----------------------------
DROP TABLE IF EXISTS `tblaudauditoriav2`;
CREATE TABLE `tblaudauditoriav2`  (
  `AudId` int(20) NOT NULL AUTO_INCREMENT,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudIP` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudCodigo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudAccion` tinyint(1) NOT NULL,
  `AudUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudPersonal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AudDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AudDatos` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AudTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`AudId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 138195 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblaueaulavirtualencargado
-- ----------------------------
DROP TABLE IF EXISTS `tblaueaulavirtualencargado`;
CREATE TABLE `tblaueaulavirtualencargado`  (
  `AueId` int(11) NOT NULL AUTO_INCREMENT,
  `AucId` int(11) NULL DEFAULT NULL,
  `AuvId` int(11) NULL DEFAULT NULL,
  `AueEstado` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`AueId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblauiaulavirtualinscripcion
-- ----------------------------
DROP TABLE IF EXISTS `tblauiaulavirtualinscripcion`;
CREATE TABLE `tblauiaulavirtualinscripcion`  (
  `AuiId` int(11) NOT NULL AUTO_INCREMENT,
  `AucId` int(11) NULL DEFAULT NULL,
  `AuvId` int(11) NULL DEFAULT NULL,
  `AuiEstado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AuiId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 323 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblauvaulavirtual
-- ----------------------------
DROP TABLE IF EXISTS `tblauvaulavirtual`;
CREATE TABLE `tblauvaulavirtual`  (
  `AuvId` int(11) NOT NULL AUTO_INCREMENT,
  `UsuId` int(11) NULL DEFAULT NULL,
  `AuvTipo` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AuvEstado` int(1) NULL DEFAULT NULL,
  `AuvPonderado` int(3) NULL DEFAULT NULL,
  `AuvFechaCreacion` date NULL DEFAULT NULL,
  PRIMARY KEY (`AuvId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblavcaulavirtualcheck
-- ----------------------------
DROP TABLE IF EXISTS `tblavcaulavirtualcheck`;
CREATE TABLE `tblavcaulavirtualcheck`  (
  `AvcId` int(11) NOT NULL AUTO_INCREMENT,
  `AvvId` int(11) NULL DEFAULT NULL,
  `AuvId` int(11) NULL DEFAULT NULL,
  `AvcFecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`AvcId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 215 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblavecampanavehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblavecampanavehiculo`;
CREATE TABLE `tblavecampanavehiculo`  (
  `AveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AveVIN` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AveConcesionario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AveStatus` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AveCampana` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AveEstado` tinyint(1) NOT NULL,
  `AveTiempoCreacion` datetime NOT NULL,
  `AveTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`AveId`) USING BTREE,
  INDEX `FK_AVE_CAMID_idx`(`CamId`) USING BTREE,
  CONSTRAINT `tblavecampanavehiculo_ibfk_1` FOREIGN KEY (`CamId`) REFERENCES `tblcamcampana` (`CamId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblaviaviso
-- ----------------------------
DROP TABLE IF EXISTS `tblaviaviso`;
CREATE TABLE `tblaviaviso`  (
  `AviId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AviFecha` date NOT NULL,
  `AviObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AviEstado` tinyint(1) NOT NULL,
  `AviTiempoCreacion` datetime NOT NULL,
  `AviTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`AviId`) USING BTREE,
  INDEX `FK_AVI_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_AVI_CLIID_idx`(`CliId`) USING BTREE,
  CONSTRAINT `tblaviaviso_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblaviaviso_ibfk_2` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblavmaulavirtualmaterial
-- ----------------------------
DROP TABLE IF EXISTS `tblavmaulavirtualmaterial`;
CREATE TABLE `tblavmaulavirtualmaterial`  (
  `AvmId` int(11) NOT NULL AUTO_INCREMENT,
  `AucId` int(11) NULL DEFAULT NULL,
  `AvmNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvmEstado` int(1) NULL DEFAULT NULL,
  `AvmRuta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvmIcono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvmFechaCreacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`AvmId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblavmaulavirtualmodulo
-- ----------------------------
DROP TABLE IF EXISTS `tblavmaulavirtualmodulo`;
CREATE TABLE `tblavmaulavirtualmodulo`  (
  `AvmId` int(11) NOT NULL AUTO_INCREMENT,
  `AucId` int(11) NULL DEFAULT NULL,
  `AvmNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvmEstado` int(1) NULL DEFAULT NULL,
  `AvmFechaCreacion` date NULL DEFAULT NULL,
  PRIMARY KEY (`AvmId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblavvasignacionventavehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblavvasignacionventavehiculo`;
CREATE TABLE `tblavvasignacionventavehiculo`  (
  `AvvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvFecha` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvHora` time NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AvvObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AvvSolicitante` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvVehiculoMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvVehiculoModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvVehiculoVersion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvColor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvAnoModelo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvAprobacion` tinyint(1) NULL DEFAULT NULL,
  `AvvEstado` tinyint(1) NOT NULL,
  `AvvTiempoCreacion` datetime NOT NULL,
  `AvvTiempoModificacion` datetime NOT NULL,
  `AvvUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AvvUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`AvvId`) USING BTREE,
  INDEX `FK_AFF_OVVID`(`OvvId`) USING BTREE,
  INDEX `FK_AFF_EINID`(`EinId`) USING BTREE,
  INDEX `FK_AVV_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `tblavvasignacionventavehiculo_ibfk_1` FOREIGN KEY (`OvvId`) REFERENCES `tblovvordenventavehiculo` (`OvvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblavvasignacionventavehiculo_ibfk_2` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblavvasignacionventavehiculo_ibfk_3` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblavvaulavirtualvideo
-- ----------------------------
DROP TABLE IF EXISTS `tblavvaulavirtualvideo`;
CREATE TABLE `tblavvaulavirtualvideo`  (
  `AvvId` int(11) NOT NULL AUTO_INCREMENT,
  `AucId` int(11) NULL DEFAULT NULL,
  `AvmId` int(11) NULL DEFAULT NULL,
  `AvvNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvvEstado` int(1) NULL DEFAULT NULL,
  `AvvRuta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvvMiniatura` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `AvvFechaCreacion` date NULL DEFAULT NULL,
  PRIMARY KEY (`AvvId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbamboletaalmacenmovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblbamboletaalmacenmovimiento`;
CREATE TABLE `tblbamboletaalmacenmovimiento`  (
  `BamId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`BamId`) USING BTREE,
  INDEX `FK_BAM_AMOID`(`AmoId`) USING BTREE,
  INDEX `BolId`(`BolId`, `BtaId`) USING BTREE,
  CONSTRAINT `tblbamboletaalmacenmovimiento_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbamboletaalmacenmovimiento_ibfk_2` FOREIGN KEY (`BolId`, `BtaId`) REFERENCES `tblbolboleta` (`BolId`, `BtaId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbanbanco
-- ----------------------------
DROP TABLE IF EXISTS `tblbanbanco`;
CREATE TABLE `tblbanbanco`  (
  `BanId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BanNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BanDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BanEstado` tinyint(1) NOT NULL,
  `BanTiempoCreacion` datetime NOT NULL,
  `BanTiempoModificacion` datetime NOT NULL,
  `BanEliminado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`BanId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbclboletacliente
-- ----------------------------
DROP TABLE IF EXISTS `tblbclboletacliente`;
CREATE TABLE `tblbclboletacliente`  (
  `BclId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BclTiempoCreacion` datetime NOT NULL,
  `BclTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`BclId`) USING BTREE,
  INDEX `FK_BCL_BOLID_idx`(`BolId`, `BtaId`) USING BTREE,
  INDEX `FK_BCL_CLIID_idx`(`CliId`) USING BTREE,
  CONSTRAINT `tblbclboletacliente_ibfk_1` FOREIGN KEY (`BolId`, `BtaId`) REFERENCES `tblbolboleta` (`BolId`, `BtaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblbclboletacliente_ibfk_2` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbdeboletadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblbdeboletadetalle`;
CREATE TABLE `tblbdeboletadetalle`  (
  `BdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FatId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BdeTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BdeCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `BdeDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BdeCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BdeUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BdeUnidadMedidaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BdePrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BdeImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BdeValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `BdeImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `BdeImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `BdeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `BdeExonerado` tinyint(1) NULL DEFAULT NULL,
  `BdeGratuito` tinyint(1) NULL DEFAULT NULL,
  `BdeIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `BdeCompraOrigen` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BdeTiempoCreacion` datetime NOT NULL,
  `BdeTiempoModificacion` datetime NOT NULL,
  `BdeAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`BdeId`) USING BTREE,
  INDEX `FK_BDE_BOLID_idx`(`BolId`, `BtaId`) USING BTREE,
  INDEX `FK_BDE_AMDID_idx`(`AmdId`) USING BTREE,
  INDEX `FK_BDE_FATID`(`FatId`) USING BTREE,
  CONSTRAINT `tblbdeboletadetalle_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbdeboletadetalle_ibfk_2` FOREIGN KEY (`BolId`, `BtaId`) REFERENCES `tblbolboleta` (`BolId`, `BtaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblbdeboletadetalle_ibfk_3` FOREIGN KEY (`FatId`) REFERENCES `tblfatfichaacciontarea` (`FatId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbolboleta
-- ----------------------------
DROP TABLE IF EXISTS `tblbolboleta`;
CREATE TABLE `tblbolboleta`  (
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolFechaEmision` date NOT NULL,
  `BolPorcentajeImpuestoVenta` decimal(8, 2) NULL DEFAULT NULL,
  `BolPorcentajeImpuestoSelectivo` decimal(8, 2) NULL DEFAULT NULL,
  `BolDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolTotalPagar` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalExonerado` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalGratuito` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalGravado` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalBruto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolTotalReal` decimal(16, 6) NOT NULL,
  `BolObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolObservacionImpresa` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolObservacionCaja` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolLeyenda` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolCantidadDia` mediumint(3) NOT NULL,
  `BolCancelado` tinyint(1) NULL DEFAULT 2,
  `BolCredito` tinyint(1) NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolTipoCambio` decimal(8, 3) NULL DEFAULT NULL,
  `BolObsequio` tinyint(1) NULL DEFAULT 2,
  `BolCierre` tinyint(1) NULL DEFAULT 1,
  `RegId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolRegimenPorcentaje` decimal(8, 2) NULL DEFAULT 0.00,
  `BolRegimenMonto` decimal(8, 3) NULL DEFAULT 0.000,
  `BolRegimenComprobanteNumero` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolRegimenComprobanteFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaBajaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `BolSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `BolSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioDigestValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolPagoComision` tinyint(1) NULL DEFAULT NULL,
  `BolSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatUltimaRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolDatoAdicional1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional9` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional10` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional11` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional12` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional13` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional14` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional15` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional18` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional19` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional20` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional21` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional22` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional23` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional24` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional25` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional26` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional27` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional28` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolNumeroPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolVendedor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolObservado` tinyint(1) NULL DEFAULT NULL,
  `BolEstado` tinyint(1) NOT NULL DEFAULT 1,
  `BolTiempoCreacion` datetime NOT NULL,
  `BolTiempoModificacion` datetime NOT NULL,
  `BolAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatUltimaActividad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolFechaEmisionAux` date NULL DEFAULT NULL,
  `BolFechaVencimiento` date NULL DEFAULT NULL,
  `NpaIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolTipoCambioAux` decimal(16, 6) NULL DEFAULT NULL,
  `BolCuota` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`BolId`, `BtaId`) USING BTREE,
  INDEX `FK_BOL_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_BOL_BTAID_idx`(`BtaId`) USING BTREE,
  INDEX `FK_BOL_NPAID_idx`(`NpaId`) USING BTREE,
  INDEX `FK_BOL_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_BOL_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_BOL_FCCID`(`FccId`) USING BTREE,
  CONSTRAINT `tblbolboleta_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_ibfk_2` FOREIGN KEY (`BtaId`) REFERENCES `tblbtaboletatalonario` (`BtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_ibfk_3` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_ibfk_4` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_ibfk_6` FOREIGN KEY (`NpaId`) REFERENCES `tblnpacondicionpago` (`NpaId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbolboleta_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblbolboleta_copy`;
CREATE TABLE `tblbolboleta_copy`  (
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolFechaEmision` date NOT NULL,
  `BolPorcentajeImpuestoVenta` decimal(8, 2) NULL DEFAULT NULL,
  `BolPorcentajeImpuestoSelectivo` decimal(8, 2) NULL DEFAULT NULL,
  `BolDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolTotalPagar` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalExonerado` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalGratuito` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalGravado` decimal(16, 6) NULL DEFAULT NULL,
  `BolTotalBruto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `BolTotalReal` decimal(16, 6) NOT NULL,
  `BolObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolObservacionImpresa` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolObservacionCaja` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolLeyenda` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolCantidadDia` mediumint(3) NOT NULL,
  `BolCancelado` tinyint(1) NULL DEFAULT 2,
  `BolCredito` tinyint(1) NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolTipoCambio` decimal(8, 3) NULL DEFAULT NULL,
  `BolObsequio` tinyint(1) NULL DEFAULT 2,
  `BolCierre` tinyint(1) NULL DEFAULT 1,
  `RegId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolRegimenPorcentaje` decimal(8, 2) NULL DEFAULT 0.00,
  `BolRegimenMonto` decimal(8, 3) NULL DEFAULT 0.000,
  `BolRegimenComprobanteNumero` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolRegimenComprobanteFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaBajaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `BolSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `BolSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `BolSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `BolSunatRespuestaEnvioDigestValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolPagoComision` tinyint(1) NULL DEFAULT NULL,
  `BolSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatUltimaRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BolDatoAdicional1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional9` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional10` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional11` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional12` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional13` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional14` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional15` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional18` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional19` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional20` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional21` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional22` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional23` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional24` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional25` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional26` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional27` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolDatoAdicional28` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolNumeroPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolVendedor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolObservado` tinyint(1) NULL DEFAULT NULL,
  `BolEstado` tinyint(1) NOT NULL DEFAULT 1,
  `BolTiempoCreacion` datetime NOT NULL,
  `BolTiempoModificacion` datetime NOT NULL,
  `BolAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolSunatUltimaActividad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`BolId`, `BtaId`) USING BTREE,
  INDEX `FK_BOL_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_BOL_BTAID_idx`(`BtaId`) USING BTREE,
  INDEX `FK_BOL_NPAID_idx`(`NpaId`) USING BTREE,
  INDEX `FK_BOL_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_BOL_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_BOL_FCCID`(`FccId`) USING BTREE,
  CONSTRAINT `tblbolboleta_copy_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_copy_ibfk_2` FOREIGN KEY (`BtaId`) REFERENCES `tblbtaboletatalonario` (`BtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_copy_ibfk_3` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_copy_ibfk_4` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblbolboleta_copy_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblbtaboletatalonario
-- ----------------------------
DROP TABLE IF EXISTS `tblbtaboletatalonario`;
CREATE TABLE `tblbtaboletatalonario`  (
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaInicio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaNumero` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BtaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `BtaTiempoCreacion` datetime NOT NULL,
  `BtaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`BtaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcalcalificacion
-- ----------------------------
DROP TABLE IF EXISTS `tblcalcalificacion`;
CREATE TABLE `tblcalcalificacion`  (
  `CalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CalTipo` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CalTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CalCosto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CalMargen` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CalRango` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CalRangoInicio` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `CalRangoFin` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `CalTiempoCreacion` datetime NOT NULL,
  `CalTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CalId`) USING BTREE,
  INDEX `FK_CAL_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tblcalcalificacion_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcamcampana
-- ----------------------------
DROP TABLE IF EXISTS `tblcamcampana`;
CREATE TABLE `tblcamcampana`  (
  `CamId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CamNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CamFechaInicio` date NOT NULL,
  `CamFechaFin` date NULL DEFAULT NULL,
  `CamArchivo1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamArchivo2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamArchivo3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamOperacionCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CamOperacionTiempo` decimal(10, 2) NULL DEFAULT NULL,
  `CamBoletinCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CamBoletin` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CamEstado` tinyint(1) NOT NULL,
  `CamTiempoCreacion` datetime NOT NULL,
  `CamTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CamId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcbacodigobarra
-- ----------------------------
DROP TABLE IF EXISTS `tblcbacodigobarra`;
CREATE TABLE `tblcbacodigobarra`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tiempocreacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tblccicajacierre
-- ----------------------------
DROP TABLE IF EXISTS `tblccicajacierre`;
CREATE TABLE `tblccicajacierre`  (
  `CciId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CciFecha` date NOT NULL,
  `CciComprobanteNumero` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CciComprobanteFecha` date NULL DEFAULT NULL,
  `CueId` tinyint(1) NULL DEFAULT NULL,
  `CciFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CciTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CciObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CciTotal` decimal(16, 6) NULL DEFAULT NULL,
  `CciRevisado` tinyint(1) NULL DEFAULT NULL,
  `CciEstado` tinyint(1) NOT NULL,
  `CciTiempoCreacion` datetime NOT NULL,
  `CciTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CciId`) USING BTREE,
  INDEX `FK_CCI_SUCID`(`SucId`) USING BTREE,
  INDEX `FK_CCI_PERID`(`PerId`) USING BTREE,
  INDEX `FK_CCI_MONID`(`MonId`) USING BTREE,
  CONSTRAINT `FK_CCI_MONID` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_CCI_PERID` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_CCI_SUCID` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblccvcotizacionvehiculocondicionventa
-- ----------------------------
DROP TABLE IF EXISTS `tblccvcotizacionvehiculocondicionventa`;
CREATE TABLE `tblccvcotizacionvehiculocondicionventa`  (
  `CcvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CovId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CcvEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CcvTiempoCreacion` datetime NULL DEFAULT NULL,
  `CcvTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`CcvId`) USING BTREE,
  INDEX `FK_CCV_CVEID_idx`(`CveId`) USING BTREE,
  INDEX `FK_CCV_COVID_idx`(`CovId`) USING BTREE,
  CONSTRAINT `tblccvcotizacionvehiculocondicionventa_ibfk_1` FOREIGN KEY (`CovId`) REFERENCES `tblcovcondicionventa` (`CovId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblccvcotizacionvehiculocondicionventa_ibfk_2` FOREIGN KEY (`CveId`) REFERENCES `tblcvecotizacionvehiculo` (`CveId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcemconfiguracionempresa
-- ----------------------------
DROP TABLE IF EXISTS `tblcemconfiguracionempresa`;
CREATE TABLE `tblcemconfiguracionempresa`  (
  `CemId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemAlias` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CemNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemNombreComercial` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CemCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CemRepresentanteNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemRepresentanteNumeroDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemEmail` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CemWeb` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemFax` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemPais` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemPaisAbreviacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemDireccion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemDepartamento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemDistrito` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemProvincia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemLogo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemImpuestoVenta` decimal(8, 2) NULL DEFAULT NULL,
  `CemImpuestoSelectivo` decimal(8, 2) NULL DEFAULT NULL,
  `CemImpuestoRenta` decimal(8, 2) NULL DEFAULT NULL,
  `CemArticuloTipoCodificacion` tinyint(1) NULL DEFAULT NULL,
  `CemCorreoPedidoTaller` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CemCorreoVentaVehiculo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CemCorreoVentaRepuesto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CemCorreoPedidoGM` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CemRepuestoMargenUtilidad` decimal(10, 2) NULL DEFAULT NULL,
  `CemRepuestoFlete` decimal(10, 2) NULL DEFAULT NULL,
  `CemTipoCambioComercial` decimal(10, 3) NULL DEFAULT NULL,
  `CemCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CemMantenimientoPorcentajeManoObra` decimal(8, 2) NULL DEFAULT NULL,
  `CemTiempoCreacion` datetime NULL DEFAULT NULL,
  `CemTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`CemId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcitcita
-- ----------------------------
DROP TABLE IF EXISTS `tblcitcita`;
CREATE TABLE `tblcitcita`  (
  `CitId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitFecha` date NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerIdMecanico` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitFechaProgramada` date NOT NULL,
  `CitHoraProgramada` time NULL DEFAULT NULL,
  `CitTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitEmail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CitKilometrajeMantenimiento` int(10) NULL DEFAULT NULL,
  `CitDuracion` tinyint(1) NULL DEFAULT NULL,
  `CitVehiculoPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitVehiculoMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitVehiculoModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitVehiculoVersion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitEstado` tinyint(1) NOT NULL,
  `CitTiempoCreacion` datetime NOT NULL,
  `CitTiempoModificacion` datetime NOT NULL,
  `CitUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerIdRegistro` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`CitId`) USING BTREE,
  INDEX `FK_CIT_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_CIT_EINID_idx`(`EinId`) USING BTREE,
  CONSTRAINT `tblcitcita_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblcitcita_ibfk_2` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblclicliente
-- ----------------------------
DROP TABLE IF EXISTS `tblclicliente`;
CREATE TABLE `tblclicliente`  (
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TrfId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TdoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliTipoDocumentoOtro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliNombreComercial` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliNombreCompleto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CliAbreviatura` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliNombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliApellidoPaterno` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliApellidoMaterno` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliNumeroDocumento` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliNumeroDocumento1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliNumeroDocumento2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliRepresentanteNombre` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliRepresentanteNumeroDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliRepresentanteNacionalidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliRepresentanteActividadEconomica` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliDireccion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliDistrito` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliProvincia` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliDepartamento` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliPais` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliEmail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliFechaNacimiento` date NULL DEFAULT NULL,
  `CliFax` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoNombre1` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoCelular1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoEmail1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoNombre2` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoCelular2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoEmail2` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoNombre3` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoCelular3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliContactoEmail3` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CliUso` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliTipoCambioFecha` date NULL DEFAULT NULL,
  `CliTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CliLineaCredito` decimal(10, 3) NULL DEFAULT NULL,
  `CliIncluyeImpuesto` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliCSIIncluir` tinyint(1) NOT NULL DEFAULT 1,
  `CliCSIExcluirMotivo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CliCSIExcluirFecha` date NULL DEFAULT NULL,
  `CliCSIExcluirUsuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliCSIVentaIncluir` tinyint(1) NULL DEFAULT NULL,
  `CliCSIVentaExcluirMotivo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CliCSIVentaExcluirFecha` date NULL DEFAULT NULL,
  `CliCSIVentaExcluirUsuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliActividadEconomica` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliClasificacion` tinyint(1) NOT NULL DEFAULT 1,
  `CliBloquear` tinyint(1) NULL DEFAULT NULL,
  `CliClaveElectronica` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliEmailFacturacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliEstadoCivil` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliSexo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliLeadFechaAsignado` datetime NULL DEFAULT NULL,
  `CliLeadModelo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliLeadObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CliLeadEtapaFase` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliLeadTiempoModificacion` datetime NULL DEFAULT NULL,
  `CliLead` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '',
  `CliEstado` tinyint(1) NOT NULL,
  `CliTiempoCreacion` datetime NOT NULL,
  `CliTiempoModificacion` datetime NOT NULL,
  `CliUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`CliId`) USING BTREE,
  INDEX `FK_CLI_CTIID_idx`(`LtiId`) USING BTREE,
  INDEX `FK_CLI_LTIID_idx`(`LtiId`) USING BTREE,
  INDEX `FK_CLI_TDOID_idx`(`TdoId`) USING BTREE,
  INDEX `FK_CLI_TRFID`(`TrfId`) USING BTREE,
  CONSTRAINT `tblclicliente_ibfk_1` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblclicliente_ibfk_2` FOREIGN KEY (`TdoId`) REFERENCES `tbltdotipodocumento` (`TdoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblclicliente_ibfk_3` FOREIGN KEY (`TrfId`) REFERENCES `tbltrftiporeferido` (`TrfId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcnoclientenota
-- ----------------------------
DROP TABLE IF EXISTS `tblcnoclientenota`;
CREATE TABLE `tblcnoclientenota`  (
  `CnoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CnoTipo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CnoFecha` date NULL DEFAULT NULL,
  `CnoDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CnoEstado` tinyint(1) NULL DEFAULT NULL,
  `CnoTiempoCreacion` datetime NOT NULL,
  `CnoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CnoId`) USING BTREE,
  INDEX `FK_CNO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_CNO_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `tblcnoclientenota_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcnoclientenota_ibfk_2` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcolcotizacionllamada
-- ----------------------------
DROP TABLE IF EXISTS `tblcolcotizacionllamada`;
CREATE TABLE `tblcolcotizacionllamada`  (
  `ColId` int(11) NOT NULL AUTO_INCREMENT,
  `CveId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ColPregunta1` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ColPregunta2` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ColPregunta3` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ColPregunta4` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ColPregunta5` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ColVerbatin` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ColFecha` datetime NULL DEFAULT NULL,
  `ColFechaLlamada` datetime NULL DEFAULT NULL,
  `ColEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ColId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcovcondicionventa
-- ----------------------------
DROP TABLE IF EXISTS `tblcovcondicionventa`;
CREATE TABLE `tblcovcondicionventa`  (
  `CovId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CovNombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CovSigla` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CovDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CovOrden` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CovUso` tinyint(1) NOT NULL DEFAULT 1,
  `CovEstado` tinyint(1) NOT NULL,
  `CovTiempoCreacion` datetime NOT NULL,
  `CovTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CovId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcpcarpetas
-- ----------------------------
DROP TABLE IF EXISTS `tblcpcarpetas`;
CREATE TABLE `tblcpcarpetas`  (
  `CpId` int(5) NOT NULL AUTO_INCREMENT,
  `CpPadre` int(5) NULL DEFAULT NULL,
  `CpNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CpTipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CpCompartido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CpEstado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CpComentario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `CpFechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CpId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcpcclientepagocomprobante
-- ----------------------------
DROP TABLE IF EXISTS `tblcpcclientepagocomprobante`;
CREATE TABLE `tblcpcclientepagocomprobante`  (
  `CpcId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`CpcId`) USING BTREE,
  INDEX `FK_CPC_CPAID_idx`(`CpaId`) USING BTREE,
  INDEX `FK_CPC_FACID_idx`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_CPC_BOLID_idx`(`BolId`, `BtaId`) USING BTREE,
  CONSTRAINT `tblcpcclientepagocomprobante_ibfk_1` FOREIGN KEY (`BolId`, `BtaId`) REFERENCES `tblbolboleta` (`BolId`, `BtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcpcclientepagocomprobante_ibfk_2` FOREIGN KEY (`CpaId`) REFERENCES `tblcpaclientepago` (`CpaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblcpcclientepagocomprobante_ibfk_3` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcpeclientepersonal
-- ----------------------------
DROP TABLE IF EXISTS `tblcpeclientepersonal`;
CREATE TABLE `tblcpeclientepersonal`  (
  `CpeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CpeFecha` date NULL DEFAULT NULL,
  `CpeDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CpeEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CpeTiempoCreacion` datetime NULL DEFAULT NULL,
  `CpeTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`CpeId`) USING BTREE,
  INDEX `FK_CPE_CLIID`(`CliId`) USING BTREE,
  INDEX `FK_CPE_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `tblcpeclientepersonal_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblcpeclientepersonal_ibfk_2` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcpfcotizacionproductofoto
-- ----------------------------
DROP TABLE IF EXISTS `tblcpfcotizacionproductofoto`;
CREATE TABLE `tblcpfcotizacionproductofoto`  (
  `CpfId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CprId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CpfArchivo` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CpfTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CpfEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CpfTiempoCreacion` datetime NULL DEFAULT NULL,
  `CpfTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`CpfId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcppcotizacionproductoplanchadopintado
-- ----------------------------
DROP TABLE IF EXISTS `tblcppcotizacionproductoplanchadopintado`;
CREATE TABLE `tblcppcotizacionproductoplanchadopintado`  (
  `CppId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CprId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CppDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CppCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CppPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CppImporte` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CppTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CppEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CppTiempoCreacion` datetime NOT NULL,
  `CppTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CppId`) USING BTREE,
  INDEX `FK_CPP_CPRID_idx`(`CprId`) USING BTREE,
  CONSTRAINT `tblcppcotizacionproductoplanchadopintado_ibfk_1` FOREIGN KEY (`CprId`) REFERENCES `tblcprcotizacionproducto` (`CprId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcprcotizacionproducto
-- ----------------------------
DROP TABLE IF EXISTS `tblcprcotizacionproducto`;
CREATE TABLE `tblcprcotizacionproducto`  (
  `CprId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliIdSeguro` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprFecha` date NOT NULL,
  `CprHora` time NULL DEFAULT NULL,
  `CprFechaLlegada` date NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprVIN` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprAnoFabricacion` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprAnoModelo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprAnoVehiculo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CprIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 1,
  `CprPorcentajeImpuestoVenta` decimal(10, 2) NOT NULL,
  `CprPorcentajeMargenUtilidad` decimal(10, 2) NULL DEFAULT NULL,
  `CprPorcentajeOtroCosto` decimal(10, 2) NULL DEFAULT NULL,
  `CprPorcentajeDescuento` decimal(10, 2) NULL DEFAULT NULL,
  `CprPorcentajeManoObra` decimal(10, 2) NULL DEFAULT NULL,
  `CprObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CprObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CprNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CprTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprDireccion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprEmail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprRepresentante` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprAsegurado` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprManoObra` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `CprVigencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `CprTiempoEntrega` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `CprPlanchadoTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprPintadoTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprProductoTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprDescuento` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CprFirmaDigital` tinyint(1) NOT NULL DEFAULT 2,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprVerificar` tinyint(1) NOT NULL DEFAULT 0,
  `CprNotificar` tinyint(1) NOT NULL DEFAULT 2,
  `CprVentaPerdida` tinyint(1) NULL DEFAULT NULL,
  `CprVentaPerdidaMotivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprNivelInteres` tinyint(1) NULL DEFAULT NULL,
  `CprEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CprTiempoCreacion` datetime NOT NULL,
  `CprTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CprId`) USING BTREE,
  INDEX `FK_CPR_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_CPR_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_CPR_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_CPR_PERID_idx`(`PerId`) USING BTREE,
  INDEX `FK_CPR_LTIID_idx`(`LtiId`) USING BTREE,
  INDEX `FK_CPR_FINID_idx`(`FinId`) USING BTREE,
  CONSTRAINT `tblcprcotizacionproducto_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcprcotizacionproducto_ibfk_2` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcprcotizacionproducto_ibfk_3` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcprcotizacionproducto_ibfk_4` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcprcotizacionproducto_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcprcotizacionproducto_ibfk_6` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcpvcostoporvehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblcpvcostoporvehiculo`;
CREATE TABLE `tblcpvcostoporvehiculo`  (
  `CpvId` int(11) NOT NULL AUTO_INCREMENT,
  `CtvId` int(11) NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CpvMotivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CpvMonto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CpvReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CpvFechaCreacion` datetime NULL DEFAULT NULL,
  `CpvEstado` int(1) NULL DEFAULT NULL,
  `UsuId` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`CpvId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcrdcotizacionproductodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblcrdcotizacionproductodetalle`;
CREATE TABLE `tblcrdcotizacionproductodetalle`  (
  `CrdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CprId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CrdCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CrdDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CrdCantidad` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdCantidadReal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdCosto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdValorVenta` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdPrecioBruto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdDescuentoUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `CrdDescuento` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdAdicionalUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `CrdAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdImporteBruto` decimal(16, 6) NOT NULL,
  `CrdImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `CrdDias` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CrdMargenPorcentaje` decimal(16, 6) NULL DEFAULT NULL,
  `CrdMantenimientoPorcentaje` decimal(16, 6) NULL DEFAULT NULL,
  `CrdFletePorcentaje` decimal(16, 6) NULL DEFAULT NULL,
  `CrdDescuentoPorcentaje` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPorcentajeUtilidad` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPorcentajeOtroCosto` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPorcentajeManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPorcentajePedido` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPorcentajeAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `CrdPorcentajeDescuento` decimal(10, 3) NULL DEFAULT NULL,
  `CrdTipoPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CrdObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CrdEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CrdTiempoCreacion` datetime NOT NULL,
  `CrdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CrdId`) USING BTREE,
  INDEX `FK_CRD_CPRID_idx`(`CprId`) USING BTREE,
  INDEX `FK_CRD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_CRD_UMEID_idx`(`UmeId`) USING BTREE,
  CONSTRAINT `tblcrdcotizacionproductodetalle_ibfk_1` FOREIGN KEY (`CprId`) REFERENCES `tblcprcotizacionproducto` (`CprId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblcrdcotizacionproductodetalle_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcrdcotizacionproductodetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcticomprobantetipo
-- ----------------------------
DROP TABLE IF EXISTS `tblcticomprobantetipo`;
CREATE TABLE `tblcticomprobantetipo`  (
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CtiCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CtiDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiUso` tinyint(1) NOT NULL,
  PRIMARY KEY (`CtiId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblctvcostotipovehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblctvcostotipovehiculo`;
CREATE TABLE `tblctvcostotipovehiculo`  (
  `CtvId` int(11) NOT NULL AUTO_INCREMENT,
  `CtvNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtvAccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtvEstado` int(1) NULL DEFAULT NULL,
  `CtvFechaCreacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CtvId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcuecuenta
-- ----------------------------
DROP TABLE IF EXISTS `tblcuecuenta`;
CREATE TABLE `tblcuecuenta`  (
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CueCCI` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CueNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BanId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CueSaldo` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `CueDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CueEstado` tinyint(1) NOT NULL,
  `CueTiempoCreacion` datetime NOT NULL,
  `CueTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CueId`) USING BTREE,
  INDEX `FK_CUE_BANID_idx`(`BanId`) USING BTREE,
  INDEX `FK_CUE_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tblcuecuenta_ibfk_1` FOREIGN KEY (`BanId`) REFERENCES `tblbanbanco` (`BanId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcuecuenta_ibfk_2` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcvecotizacionvehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblcvecotizacionvehiculo`;
CREATE TABLE `tblcvecotizacionvehiculo`  (
  `CveId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveAno` int(4) NOT NULL,
  `CveMes` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerIdReferente` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveFecha` date NOT NULL,
  `CveHora` time NULL DEFAULT NULL,
  `CveFechaVigencia` date NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CveIncluyeImpuesto` tinyint(1) NOT NULL,
  `CvePorcentajeImpuestoVenta` decimal(10, 2) NOT NULL,
  `CveObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CveAdicional` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CveTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveDireccion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveEmail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveAnoModelo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveAnoFabricacion` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveColor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveId2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveId3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CvePrecio` decimal(16, 6) NULL DEFAULT NULL,
  `CveDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `CveSubTotal` decimal(16, 6) NOT NULL,
  `CveImpuesto` decimal(16, 6) NOT NULL,
  `CveCantidad` int(10) NULL DEFAULT NULL,
  `CveTotalUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `CveTotal` decimal(16, 6) NOT NULL,
  `CveCondicionVentaOtro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveObsequioOtro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveNivelInteres` tinyint(1) NULL DEFAULT NULL,
  `CveCotizoOtroLugar` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveObservacionReporte` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CveFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '',
  `TrfId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveGLP` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveEstado` tinyint(1) NOT NULL,
  `CveTiempoCreacion` datetime NOT NULL,
  `CveTiempoModificacion` datetime NOT NULL,
  `CvePrecio2` decimal(16, 6) NULL DEFAULT NULL,
  `CveDescuento2` decimal(16, 6) NULL DEFAULT NULL,
  `CveSubTotal2` decimal(16, 6) NULL DEFAULT NULL,
  `CveImpuesto2` decimal(16, 6) NULL DEFAULT NULL,
  `CveCantidad2` int(10) NULL DEFAULT NULL,
  `CveTotalUnitario2` decimal(16, 6) NULL DEFAULT NULL,
  `CveTotal2` decimal(16, 6) NULL DEFAULT NULL,
  `CveGLP2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveAnoFabricacion2` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveAnoModelo2` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveColor2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveAnoModelo3` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveAnoFabricacion3` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveColor3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveCantidad3` int(10) NULL DEFAULT NULL,
  `CvePrecio3` decimal(16, 6) NULL DEFAULT NULL,
  `CveDescuento3` decimal(16, 6) NULL DEFAULT NULL,
  `CveSubTotal3` decimal(16, 6) NULL DEFAULT NULL,
  `CveImpuesto3` decimal(16, 0) NULL DEFAULT NULL,
  `CveTotal3` decimal(16, 6) NULL DEFAULT NULL,
  `CveGLP3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveStatus` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`CveId`) USING BTREE,
  INDEX `FK_CVE_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_CVE_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_CVE_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_CVE_VVEID_idx`(`VveId`) USING BTREE,
  INDEX `FK_CVE_PERID_idx`(`PerId`) USING BTREE,
  INDEX `FK_CVE_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblcvecotizacionvehiculo_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcvecotizacionvehiculo_ibfk_2` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcvecotizacionvehiculo_ibfk_3` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcvecotizacionvehiculo_ibfk_4` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcvecotizacionvehiculo_ibfk_5` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblcvecotizacionvehiculo_ibfk_6` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcvfcotizacionvehiculofoto
-- ----------------------------
DROP TABLE IF EXISTS `tblcvfcotizacionvehiculofoto`;
CREATE TABLE `tblcvfcotizacionvehiculofoto`  (
  `CvfId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CvfArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CvfEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CvfTiempoCreacion` datetime NOT NULL,
  `CvfTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`CvfId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcvlcotizacionvehiculollamada
-- ----------------------------
DROP TABLE IF EXISTS `tblcvlcotizacionvehiculollamada`;
CREATE TABLE `tblcvlcotizacionvehiculollamada`  (
  `CvlId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CvlNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CvlFecha` date NULL DEFAULT NULL,
  `CvlFechaProgramada` date NULL DEFAULT NULL,
  `CvlObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `CvlEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CvlTiempoCreacion` datetime NULL DEFAULT NULL,
  `CvlTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`CvlId`) USING BTREE,
  INDEX `FK_CVL_CVEID`(`CveId`) USING BTREE,
  CONSTRAINT `tblcvlcotizacionvehiculollamada_ibfk_1` FOREIGN KEY (`CveId`) REFERENCES `tblcvecotizacionvehiculo` (`CveId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblcvocotizacionvehiculoobsequio
-- ----------------------------
DROP TABLE IF EXISTS `tblcvocotizacionvehiculoobsequio`;
CREATE TABLE `tblcvocotizacionvehiculoobsequio`  (
  `CvoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CveId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ObsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CvoAprobado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CvoObsequio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CvoEstado` tinyint(1) NOT NULL DEFAULT 0,
  `CvoTiempoCreacion` datetime NULL DEFAULT NULL,
  `CvoTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`CvoId`) USING BTREE,
  INDEX `FK_CVO_CVEID`(`CveId`) USING BTREE,
  INDEX `FK_CVO_OBSID`(`ObsId`) USING BTREE,
  CONSTRAINT `tblcvocotizacionvehiculoobsequio_ibfk_1` FOREIGN KEY (`CveId`) REFERENCES `tblcvecotizacionvehiculo` (`CveId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblcvocotizacionvehiculoobsequio_ibfk_2` FOREIGN KEY (`ObsId`) REFERENCES `tblobsobsequio` (`ObsId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbldcodesembolsocomprobante
-- ----------------------------
DROP TABLE IF EXISTS `tbldcodesembolsocomprobante`;
CREATE TABLE `tbldcodesembolsocomprobante`  (
  `DcoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DesId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GasId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`DcoId`) USING BTREE,
  INDEX `FK_DCO_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_DCO_DESID_idx`(`DesId`) USING BTREE,
  INDEX `FK_FCO_GASID_idx`(`GasId`) USING BTREE,
  CONSTRAINT `tbldcodesembolsocomprobante_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbldcodesembolsocomprobante_ibfk_2` FOREIGN KEY (`DesId`) REFERENCES `tbldesdesembolso` (`DesId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbldcodesembolsocomprobante_ibfk_3` FOREIGN KEY (`GasId`) REFERENCES `tblgasgasto` (`GasId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbldesdesembolso
-- ----------------------------
DROP TABLE IF EXISTS `tbldesdesembolso`;
CREATE TABLE `tbldesdesembolso`  (
  `DesId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DesFecha` date NOT NULL,
  `DesNumeroCheque` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DesConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `DesObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `DesObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DesTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `DesFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DesMonto` decimal(16, 6) NOT NULL,
  `DesTipo` tinyint(1) NULL DEFAULT NULL,
  `DesTipoDestino` tinyint(1) NULL DEFAULT NULL,
  `DesReferencia` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `DesEstado` tinyint(1) NOT NULL,
  `DesTiempoCreacion` datetime NULL DEFAULT NULL,
  `DesTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`DesId`) USING BTREE,
  INDEX `FK_DES_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_DES_CUEID_idx`(`CueId`) USING BTREE,
  INDEX `FK_DES_PERID_idx`(`PerId`) USING BTREE,
  INDEX `FK_DES_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_DES_PRVID_idx`(`PrvId`) USING BTREE,
  CONSTRAINT `FK_DES_CLIID` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_DES_CUEID` FOREIGN KEY (`CueId`) REFERENCES `tblcuecuenta` (`CueId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_DES_MONID` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_DES_PERID` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_DES_PRVID` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblecopersonalcomision
-- ----------------------------
DROP TABLE IF EXISTS `tblecopersonalcomision`;
CREATE TABLE `tblecopersonalcomision`  (
  `EcoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EcoPorcentaje` decimal(10, 2) NULL DEFAULT NULL,
  `EcoFecha` date NULL DEFAULT NULL,
  `EcoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`EcoId`) USING BTREE,
  INDEX `FK_CIT_CLIID_idx`(`CliId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbledeencuestadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tbledeencuestadetalle`;
CREATE TABLE `tbledeencuestadetalle`  (
  `EdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EncId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EdeRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EdeEstado` tinyint(1) NULL DEFAULT NULL,
  `EdeTiempoCreacion` datetime NULL DEFAULT NULL,
  `EdeTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`EdeId`) USING BTREE,
  INDEX `FK_EDE_ENCID_idx`(`EncId`) USING BTREE,
  INDEX `FK_EDE_EPRID_idx`(`EprId`) USING BTREE,
  CONSTRAINT `FK_EDE_ENCID` FOREIGN KEY (`EncId`) REFERENCES `tblencencuesta` (`EncId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_EDE_EPRID` FOREIGN KEY (`EprId`) REFERENCES `tbleprencuestapregunta` (`EprId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbleinvehiculoingreso
-- ----------------------------
DROP TABLE IF EXISTS `tbleinvehiculoingreso`;
CREATE TABLE `tbleinvehiculoingreso`  (
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OncId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinVIN` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinFechaVenta` date NULL DEFAULT NULL,
  `EinNumeroMotor` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinDUA` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinGuiaTransporte` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinGuiaRemision` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinPlaca` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinPoliza` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinZofra` tinyint(1) NULL DEFAULT NULL,
  `EinNacionalizado` tinyint(1) NULL DEFAULT NULL,
  `EinPrecio` decimal(10, 3) NULL DEFAULT NULL,
  `EinAnoFabricacion` int(4) NULL DEFAULT NULL,
  `EinAnoModelo` int(4) NULL DEFAULT NULL,
  `EinAnoVehiculo` int(4) NULL DEFAULT NULL,
  `EinColor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinColorInterior` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinColorInterno` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinTransmision` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinTipo` tinyint(1) NULL DEFAULT NULL,
  `EinNotaPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinNumeroProforma` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinAnoProforma` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinMesProforma` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinArchivoDAM` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinArchivoDAM2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinArchivoDAM3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFechaSalidaDAM` date NULL DEFAULT NULL,
  `EinFechaRetornoDAM` date NULL DEFAULT NULL,
  `EinEstadoVehicular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinSolicitud` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinEstadoVehicularFechaSalida` date NULL DEFAULT NULL,
  `EinEstadoVehicularFechaLlegada` date NULL DEFAULT NULL,
  `EinNumeroViaje` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinManualPropietario` tinyint(1) NULL DEFAULT NULL,
  `EinManualGarantia` tinyint(1) NULL DEFAULT NULL,
  `EinFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFotoVIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFotoFrontal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFotoCupon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica9` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica10` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica11` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica12` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica13` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica14` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica15` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica18` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica19` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCaracteristica20` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `EinDescuentoGerencia` decimal(16, 6) NULL DEFAULT NULL,
  `EinRecepcionFecha` date NULL DEFAULT NULL,
  `EinRecepcionZonaComprometida` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinRecepcionRepuestoDetalle` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinRecepcionSolucion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinRecepcionObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinClaveAlarma` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinKilometraje` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinPromedioDiaMantenimiento` decimal(10, 2) NULL DEFAULT NULL,
  `EinFichaIngresoFechaUltimo` date NULL DEFAULT NULL,
  `EinFichaIngresoMantenimientoKilometrajeUltimo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFichaIngresoFechaPredecida` date NULL DEFAULT NULL,
  `EinComprobanteCompraNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinComprobanteCompraFecha` date NULL DEFAULT NULL,
  `EinFechaUltimoMovimiento` date NULL DEFAULT NULL,
  `EinFechaIngreso` date NULL DEFAULT NULL,
  `EinCodigoPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFacturaNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinFacturaFecha` date NULL DEFAULT NULL,
  `EinFacturaValor` decimal(16, 6) NULL DEFAULT NULL,
  `EinProveedor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinUbicacionAdicional` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinUbicacionReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinSerie` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinMarca` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinModelo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCostoIngreso` decimal(16, 6) NULL DEFAULT NULL,
  `EinCostoIngresoReal` decimal(16, 6) NULL DEFAULT NULL,
  `MonIdIngreso` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinTipoCambioIngreso` decimal(10, 3) NULL DEFAULT NULL,
  `EinObservado` tinyint(1) NULL DEFAULT NULL,
  `EinObservadoMotivo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinEstado` tinyint(1) NOT NULL,
  `EinTiempoCreacion` datetime NOT NULL,
  `EinTiempoModificacion` datetime NOT NULL,
  `EinColorAduana` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinAux` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinVINAnterior` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinFechaUltimoInventario` date NULL DEFAULT NULL,
  `EinDatoAdicional` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinControlGuiaRemisionFecha` date NULL DEFAULT NULL,
  `EinControlGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinControlEmpresaTransporte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinControlFechaRecepcion` date NULL DEFAULT NULL,
  `EinControlGuiaRemisionFechaOtro` date NULL DEFAULT NULL,
  `EinControlGuiaRemisionNumeroOtro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinCancelado` tinyint(1) NULL DEFAULT NULL,
  `EinEntregaImportado` tinyint(1) NULL DEFAULT NULL,
  `EinEntregaFechaImportado` date NULL DEFAULT NULL,
  `EinPredictivoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EinPredictivoFecha` date NULL DEFAULT NULL,
  `EinFechaEntregaTramitadora` date NULL DEFAULT NULL,
  `EinFechaEntregaRegistrosPublicos` date NULL DEFAULT NULL,
  `EinFechaRecibeTarjetaPropiedad` date NULL DEFAULT NULL,
  `EinFechaEntregaTarjetaPropiedad` date NULL DEFAULT NULL,
  `EinFechaRecibePlaca` date NULL DEFAULT NULL,
  `EinFechaEntregaPlaca` date NULL DEFAULT NULL,
  PRIMARY KEY (`EinId`) USING BTREE,
  INDEX `FK_EIN_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_EIN_ONCID_idx`(`OncId`) USING BTREE,
  INDEX `FK_EIN_VMAID_idx`(`VmaId`) USING BTREE,
  INDEX `FK_EIN_VMOID_idx`(`VmoId`) USING BTREE,
  INDEX `FK_EIN_VVEID_idx`(`VveId`) USING BTREE,
  INDEX `FK_EIN_VPRID_idx`(`VprId`) USING BTREE,
  INDEX `FK_EIN_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tbleinvehiculoingreso_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbleinvehiculoingreso_ibfk_2` FOREIGN KEY (`OncId`) REFERENCES `tbloncconcesionario` (`OncId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbleinvehiculoingreso_ibfk_3` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbleinvehiculoingreso_ibfk_4` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbleisencuestaisuzu
-- ----------------------------
DROP TABLE IF EXISTS `tbleisencuestaisuzu`;
CREATE TABLE `tbleisencuestaisuzu`  (
  `EisId` int(11) NOT NULL AUTO_INCREMENT,
  `OvvId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisSucursal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisCelular` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisModelo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisFechaOvv` date NULL DEFAULT NULL,
  `EisPregunta1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisPregunta1Comentarios` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EisPregunta2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisPregunta2Comentarios` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EisPregunta3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisPregunta3Comentarios` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EisPregunta4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisPregunta4Comentarios` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EisPregunta5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisPregunta5Comentarios` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EisEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EisFechaEncuesta` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`EisId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 200 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblencencuesta
-- ----------------------------
DROP TABLE IF EXISTS `tblencencuesta`;
CREATE TABLE `tblencencuesta`  (
  `EncId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncFecha` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncVerbatin` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EncTipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncEstado` tinyint(1) NULL DEFAULT NULL,
  `EncObservacionDealer` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncSolucionDealer` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EncTiempoCreacion` datetime NULL DEFAULT NULL,
  `EncTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`EncId`) USING BTREE,
  INDEX `FK_ENC_FINID_idx`(`FinId`) USING BTREE,
  CONSTRAINT `FK_ENC_FINID` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblepeencuestapreguntarespuesta
-- ----------------------------
DROP TABLE IF EXISTS `tblepeencuestapreguntarespuesta`;
CREATE TABLE `tblepeencuestapreguntarespuesta`  (
  `EpeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EpeNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EpeValor` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EpeEstado` tinyint(1) NOT NULL,
  `EpeTiempoCreacion` datetime NOT NULL,
  `EpeTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`EpeId`) USING BTREE,
  INDEX `FK_EPE_EPRID_idx`(`EprId`) USING BTREE,
  CONSTRAINT `FK_EPE_EPRID` FOREIGN KEY (`EprId`) REFERENCES `tbleprencuestapregunta` (`EprId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbleprencuestapregunta
-- ----------------------------
DROP TABLE IF EXISTS `tbleprencuestapregunta`;
CREATE TABLE `tbleprencuestapregunta`  (
  `EprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EpsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EprNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EprTipo` tinyint(1) NULL DEFAULT NULL,
  `EprSubTipo` tinyint(1) NULL DEFAULT NULL,
  `EprUso` tinyint(1) NULL DEFAULT NULL,
  `EprOrden` decimal(10, 0) NULL DEFAULT NULL,
  `EprEstado` tinyint(1) NULL DEFAULT NULL,
  `EprTiempoCreacion` datetime NULL DEFAULT NULL,
  `EprTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`EprId`) USING BTREE,
  INDEX `FK_EPR_EPSID`(`EpsId`) USING BTREE,
  CONSTRAINT `FK_EPR_EPSID` FOREIGN KEY (`EpsId`) REFERENCES `tblepsencuestapreguntaseccion` (`EpsId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblepsencuestapreguntaseccion
-- ----------------------------
DROP TABLE IF EXISTS `tblepsencuestapreguntaseccion`;
CREATE TABLE `tblepsencuestapreguntaseccion`  (
  `EpsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EpsNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EpsUso` tinyint(1) NULL DEFAULT NULL,
  `EpsTipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EpsEstado` tinyint(1) NULL DEFAULT NULL,
  `EpsTiempoCreacion` datetime NULL DEFAULT NULL,
  `EpsTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`EpsId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblevventregaventavehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblevventregaventavehiculo`;
CREATE TABLE `tblevventregaventavehiculo`  (
  `EvvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EvvFecha` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EvvHora` time NULL DEFAULT NULL,
  `EvvFechaProgramada` date NULL DEFAULT NULL,
  `EvvHoraProgramada` time NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EvvObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EvvObservacionSalida` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `EvvSolicitante` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EvvAprobacion` tinyint(1) NULL DEFAULT NULL,
  `EvvDuracion` int(10) NULL DEFAULT NULL,
  `EvvEstado` tinyint(1) NOT NULL,
  `EvvTiempoCreacion` datetime NOT NULL,
  `EvvTiempoModificacion` datetime NOT NULL,
  `EvvUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EvvUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`EvvId`) USING BTREE,
  INDEX `FK_EVV_OVVID`(`OvvId`) USING BTREE,
  INDEX `FK_EVV_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `tblevventregaventavehiculo_ibfk_1` FOREIGN KEY (`OvvId`) REFERENCES `tblovvordenventavehiculo` (`OvvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblevventregaventavehiculo_ibfk_2` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfaafichaaccionmantenimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblfaafichaaccionmantenimiento`;
CREATE TABLE `tblfaafichaaccionmantenimiento`  (
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FiaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `FaaAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FaaNivel` tinyint(1) NOT NULL DEFAULT 0,
  `FaaVerificar1` tinyint(1) NOT NULL DEFAULT 0,
  `FaaVerificar2` tinyint(1) NOT NULL DEFAULT 0,
  `FaaEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FaaTiempoCreacion` datetime NOT NULL,
  `FaaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FaaId`) USING BTREE,
  UNIQUE INDEX `UNQ_FAA_FCCID_PMTID`(`FccId`, `PmtId`) USING BTREE,
  INDEX `FK_FAA_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_FAA_PMTID_idx`(`PmtId`) USING BTREE,
  INDEX `FK_FAA_FIAID_idx`(`FiaId`) USING BTREE,
  CONSTRAINT `tblfaafichaaccionmantenimiento_ibfk_1` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfaafichaaccionmantenimiento_ibfk_2` FOREIGN KEY (`FiaId`) REFERENCES `tblfiafichaingresomantenimiento` (`FiaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfaafichaaccionmantenimiento_ibfk_3` FOREIGN KEY (`PmtId`) REFERENCES `tblpmtplanmantenimientotarea` (`PmtId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfacfactura
-- ----------------------------
DROP TABLE IF EXISTS `tblfacfactura`;
CREATE TABLE `tblfacfactura`  (
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacFechaEmision` date NOT NULL,
  `FacFechaVencimiento` date NULL DEFAULT NULL,
  `FacPorcentajeImpuestoVenta` decimal(8, 2) NULL DEFAULT 0.00,
  `FacPorcentajeImpuestoSelectivo` decimal(8, 2) NULL DEFAULT NULL,
  `FacDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacTotalBruto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacTotalPagar` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalExonerado` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalGratuito` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalGravado` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `FacSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacTotalReal` decimal(16, 6) NOT NULL,
  `FacObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacObservacionImpresa` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacObservacionCaja` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacLeyenda` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacOrdenFecha` date NULL DEFAULT NULL,
  `FacOrdenNumero` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacOrdenTipo` tinyint(1) NULL DEFAULT NULL,
  `FacOrdenFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSIAFNumero` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacCantidadDia` mediumint(3) NOT NULL,
  `FacIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 1,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacTipoCambio` decimal(8, 3) NULL DEFAULT NULL,
  `FacCancelado` tinyint(1) NULL DEFAULT 1,
  `FacCredito` tinyint(1) NULL DEFAULT NULL,
  `FacObsequio` tinyint(1) NULL DEFAULT 2,
  `FacSpot` tinyint(1) NULL DEFAULT 2,
  `FacRetencion` int(1) NULL DEFAULT NULL,
  `FacConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacTipo` tinyint(1) NULL DEFAULT NULL,
  `FacCierre` tinyint(1) NOT NULL DEFAULT 1,
  `RegId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacRegimenPorcentaje` decimal(8, 2) NULL DEFAULT NULL,
  `FacRegimenMonto` decimal(8, 3) NULL DEFAULT NULL,
  `FacRegimenComprobanteNumero` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacRegimenComprobanteFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioTicketEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '',
  `FacSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaEnvioRespuesta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaTicketEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaConsultaCDRFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacSunatRespuestaEnvioDigestValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacPagoComision` tinyint(1) NULL DEFAULT NULL,
  `FacPagoComisionFecha` date NULL DEFAULT NULL,
  `FacSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatUltimaRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacDatoAdicional1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional9` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional10` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional11` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional12` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional13` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional14` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional15` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional18` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional19` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional20` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional21` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional22` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional23` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional24` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional25` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional26` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional27` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional28` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacNumeroPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacVendedor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacObservado` tinyint(1) NULL DEFAULT NULL,
  `FacEstado` tinyint(1) NOT NULL DEFAULT 1,
  `FacTiempoCreacion` datetime NOT NULL,
  `FacTiempoModificacion` datetime NOT NULL,
  `FacAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacFechaEmisionAux` date NULL DEFAULT NULL,
  `NpaIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacTipoCambioAux` decimal(16, 6) NULL DEFAULT NULL,
  `FacCuota` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_FAC_GREID_idx`(`GreId`, `GrtId`) USING BTREE,
  INDEX `FK_FAC_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_FAC_FTAID_idx`(`FtaId`) USING BTREE,
  INDEX `FK_FCA_NPAID_idx`(`NpaId`) USING BTREE,
  INDEX `FK_FCA_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_FCA_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_FCA_FCCID`(`FccId`) USING BTREE,
  CONSTRAINT `tblfacfactura_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_ibfk_2` FOREIGN KEY (`FtaId`) REFERENCES `tblftafacturatalonario` (`FtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_ibfk_3` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_ibfk_4` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_ibfk_6` FOREIGN KEY (`NpaId`) REFERENCES `tblnpacondicionpago` (`NpaId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfacfactura_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblfacfactura_copy`;
CREATE TABLE `tblfacfactura_copy`  (
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacFechaEmision` date NOT NULL,
  `FacFechaVencimiento` date NULL DEFAULT NULL,
  `FacPorcentajeImpuestoVenta` decimal(8, 2) NULL DEFAULT 0.00,
  `FacPorcentajeImpuestoSelectivo` decimal(8, 2) NULL DEFAULT NULL,
  `FacDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacTotalBruto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacTotalPagar` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalExonerado` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalGratuito` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalGravado` decimal(16, 6) NULL DEFAULT NULL,
  `FacTotalImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `FacSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FacTotalReal` decimal(16, 6) NOT NULL,
  `FacObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacObservacionImpresa` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacObservacionCaja` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacLeyenda` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacOrdenFecha` date NULL DEFAULT NULL,
  `FacOrdenNumero` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacOrdenTipo` tinyint(1) NULL DEFAULT NULL,
  `FacOrdenFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSIAFNumero` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacCantidadDia` mediumint(3) NOT NULL,
  `FacIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 1,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacTipoCambio` decimal(8, 3) NULL DEFAULT NULL,
  `FacCancelado` tinyint(1) NULL DEFAULT 1,
  `FacCredito` tinyint(1) NULL DEFAULT NULL,
  `FacObsequio` tinyint(1) NULL DEFAULT 2,
  `FacSpot` tinyint(1) NULL DEFAULT 2,
  `FacConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacTipo` tinyint(1) NULL DEFAULT NULL,
  `FacCierre` tinyint(1) NOT NULL DEFAULT 1,
  `RegId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacRegimenPorcentaje` decimal(8, 2) NULL DEFAULT NULL,
  `FacRegimenMonto` decimal(8, 3) NULL DEFAULT NULL,
  `FacRegimenComprobanteNumero` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacRegimenComprobanteFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioTicketEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '',
  `FacSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaEnvioRespuesta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaTicketEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacSunatRespuestaConsultaCDRFecha` date NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRHora` time NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaConsultaCDRTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `FacSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacSunatRespuestaEnvioDigestValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacPagoComision` tinyint(1) NULL DEFAULT NULL,
  `FacPagoComisionFecha` date NULL DEFAULT NULL,
  `FacSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacSunatUltimaRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FacDatoAdicional1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional9` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional10` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional11` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional12` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional13` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional14` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional15` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional18` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional19` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional20` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional21` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional22` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional23` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional24` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional25` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional26` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional27` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacDatoAdicional28` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacNumeroPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacVendedor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacObservado` tinyint(1) NULL DEFAULT NULL,
  `FacEstado` tinyint(1) NOT NULL DEFAULT 1,
  `FacTiempoCreacion` datetime NOT NULL,
  `FacTiempoModificacion` datetime NOT NULL,
  `FacAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_FAC_GREID_idx`(`GreId`, `GrtId`) USING BTREE,
  INDEX `FK_FAC_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_FAC_FTAID_idx`(`FtaId`) USING BTREE,
  INDEX `FK_FCA_NPAID_idx`(`NpaId`) USING BTREE,
  INDEX `FK_FCA_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_FCA_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_FCA_FCCID`(`FccId`) USING BTREE,
  CONSTRAINT `tblfacfactura_copy_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_copy_ibfk_2` FOREIGN KEY (`FtaId`) REFERENCES `tblftafacturatalonario` (`FtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_copy_ibfk_3` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_copy_ibfk_4` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfacfactura_copy_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfaefichaacciontempario
-- ----------------------------
DROP TABLE IF EXISTS `tblfaefichaacciontempario`;
CREATE TABLE `tblfaefichaacciontempario`  (
  `FaeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FaeCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FaeTiempo` decimal(10, 2) NOT NULL,
  `FaeEstado` tinyint(1) NOT NULL,
  `FaeTiempoCreacion` datetime NOT NULL,
  `FaeTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FaeId`) USING BTREE,
  INDEX `FK_FAE_FCCID_idx`(`FccId`) USING BTREE,
  CONSTRAINT `tblfaefichaacciontempario_ibfk_1` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfaffichaaccionfoto
-- ----------------------------
DROP TABLE IF EXISTS `tblfaffichaaccionfoto`;
CREATE TABLE `tblfaffichaaccionfoto`  (
  `FafId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FafArchivo` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FafEstado` tinyint(1) NOT NULL,
  `FafTiempoCreacion` datetime NOT NULL,
  `FafTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FafId`) USING BTREE,
  INDEX `FK_FAF_FCCID_idx`(`FccId`) USING BTREE,
  CONSTRAINT `tblfaffichaaccionfoto_ibfk_1` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfamfacturaalmacenmovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblfamfacturaalmacenmovimiento`;
CREATE TABLE `tblfamfacturaalmacenmovimiento`  (
  `FamId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FamId`) USING BTREE,
  INDEX `FK_FAM_FACID`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_FAM_AMOID`(`AmoId`) USING BTREE,
  INDEX `FK_FAM_VMSID`(`VmvId`) USING BTREE,
  CONSTRAINT `tblfamfacturaalmacenmovimiento_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfamfacturaalmacenmovimiento_ibfk_2` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfamfacturaalmacenmovimiento_ibfk_3` FOREIGN KEY (`VmvId`) REFERENCES `tblvmvvehiculomovimiento` (`VmvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfapfichaaccionproducto
-- ----------------------------
DROP TABLE IF EXISTS `tblfapfichaaccionproducto`;
CREATE TABLE `tblfapfichaaccionproducto`  (
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapCantidad` decimal(10, 3) NOT NULL,
  `FapCantidadReal` decimal(10, 6) NOT NULL,
  `FapAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapVerificar1` tinyint(1) NOT NULL DEFAULT 0,
  `FapVerificar2` tinyint(1) NOT NULL DEFAULT 0,
  `FapEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FapTiempoCreacion` datetime NOT NULL,
  `FapTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FapId`) USING BTREE,
  INDEX `FK_FAP_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_FAP_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_FAP_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_FAP_FAAID_idx`(`FaaId`) USING BTREE,
  CONSTRAINT `tblfapfichaaccionproducto_ibfk_1` FOREIGN KEY (`FaaId`) REFERENCES `tblfaafichaaccionmantenimiento` (`FaaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfapfichaaccionproducto_ibfk_2` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfapfichaaccionproducto_ibfk_3` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfapfichaaccionproducto_ibfk_4` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfasfichaaccionsuministro
-- ----------------------------
DROP TABLE IF EXISTS `tblfasfichaaccionsuministro`;
CREATE TABLE `tblfasfichaaccionsuministro`  (
  `FasId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FasCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FasCantidadReal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FasVerificar1` tinyint(1) NULL DEFAULT 0,
  `FasVerificar2` tinyint(1) NULL DEFAULT 0,
  `FasEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FasTiempoCreacion` datetime NOT NULL,
  `FasTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FasId`) USING BTREE,
  INDEX `FK_FAS_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_FAS_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_FAS_UMEID_idx`(`UmeId`) USING BTREE,
  CONSTRAINT `tblfasfichaaccionsuministro_ibfk_1` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfasfichaaccionsuministro_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfasfichaaccionsuministro_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfatfichaacciontarea
-- ----------------------------
DROP TABLE IF EXISTS `tblfatfichaacciontarea`;
CREATE TABLE `tblfatfichaacciontarea`  (
  `FatId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FitId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FatDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FatAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FatEspecificacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FatCosto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FatVerificar1` tinyint(1) NOT NULL DEFAULT 0,
  `FatVerificar2` tinyint(1) NOT NULL DEFAULT 0,
  `FatEstado` tinyint(1) NOT NULL,
  `FatTiempoCreacion` datetime NOT NULL,
  `FatTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FatId`) USING BTREE,
  INDEX `FK_FAT_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_FTA_FITID_idx`(`FitId`) USING BTREE,
  CONSTRAINT `tblfatfichaacciontarea_ibfk_1` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfatfichaacciontarea_ibfk_2` FOREIGN KEY (`FitId`) REFERENCES `tblfitfichaingresotarea` (`FitId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfaxfacturaexportar
-- ----------------------------
DROP TABLE IF EXISTS `tblfaxfacturaexportar`;
CREATE TABLE `tblfaxfacturaexportar`  (
  `FaxId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FaxTipoCambio` decimal(16, 6) NULL DEFAULT NULL,
  `FaxEstado` tinyint(1) NULL DEFAULT NULL,
  `FaxTiempoCreacion` datetime NULL DEFAULT NULL,
  `FaxTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`FaxId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfccfichaaccion
-- ----------------------------
DROP TABLE IF EXISTS `tblfccfichaaccion`;
CREATE TABLE `tblfccfichaaccion`  (
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccFecha` date NOT NULL,
  `FccObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccCausa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FccPedido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FccSolucion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FccManoObra` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FccManoObraDetalle` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FccComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccComprobanteFecha` date NULL DEFAULT NULL,
  `FccFacturable` tinyint(1) NULL DEFAULT NULL,
  `FccEstado` tinyint(1) NOT NULL,
  `FccTiempoCreacion` datetime NOT NULL,
  `FccTiempoModificacion` datetime NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FccId`) USING BTREE,
  INDEX `FK_FCC_FIMID_idx`(`FimId`) USING BTREE,
  CONSTRAINT `tblfccfichaaccion_ibfk_1` FOREIGN KEY (`FimId`) REFERENCES `tblfimfichaingresomodalidad` (`FimId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfdefacturadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblfdefacturadetalle`;
CREATE TABLE `tblfdefacturadetalle`  (
  `FdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FatId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FdeCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `FdeCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FdeUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeUnidadMedidaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdePrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FdeImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FdeValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `FdeImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `FdeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `FdeGratuito` tinyint(1) NULL DEFAULT NULL,
  `FdeExonerado` tinyint(1) NULL DEFAULT NULL,
  `FdeIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `FdeImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `FdeCompraOrigen` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeTiempoCreacion` datetime NOT NULL,
  `FdeTiempoModificacion` datetime NOT NULL,
  `FdeAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FdeId`) USING BTREE,
  INDEX `FDE_FACID_idx`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_FDE_AMDID_idx`(`AmdId`) USING BTREE,
  INDEX `FK_FDE_FATID`(`FatId`) USING BTREE,
  CONSTRAINT `tblfdefacturadetalle_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfdefacturadetalle_ibfk_2` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfdefacturadetalle_ibfk_3` FOREIGN KEY (`FatId`) REFERENCES `tblfatfichaacciontarea` (`FatId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfdefacturadetalle_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblfdefacturadetalle_copy`;
CREATE TABLE `tblfdefacturadetalle_copy`  (
  `FdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FatId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FdeCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `FdeCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FdeUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeUnidadMedidaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdePrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FdeImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FdeValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `FdeImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `FdeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `FdeGratuito` tinyint(1) NULL DEFAULT NULL,
  `FdeExonerado` tinyint(1) NULL DEFAULT NULL,
  `FdeIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `FdeImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `FdeCompraOrigen` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeTiempoCreacion` datetime NOT NULL,
  `FdeTiempoModificacion` datetime NOT NULL,
  `FdeAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FdeId`) USING BTREE,
  INDEX `FDE_FACID_idx`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_FDE_AMDID_idx`(`AmdId`) USING BTREE,
  INDEX `FK_FDE_FATID`(`FatId`) USING BTREE,
  CONSTRAINT `tblfdefacturadetalle_copy_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfdefacturadetalle_copy_ibfk_2` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfdefacturadetalle_copy_ibfk_3` FOREIGN KEY (`FatId`) REFERENCES `tblfatfichaacciontarea` (`FatId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfdefacturadetalle_copy1
-- ----------------------------
DROP TABLE IF EXISTS `tblfdefacturadetalle_copy1`;
CREATE TABLE `tblfdefacturadetalle_copy1`  (
  `FdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FatId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FdeCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `FdeCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FdeUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeUnidadMedidaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdePrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FdeImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FdeValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `FdeImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `FdeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `FdeGratuito` tinyint(1) NULL DEFAULT NULL,
  `FdeExonerado` tinyint(1) NULL DEFAULT NULL,
  `FdeIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `FdeImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `FdeCompraOrigen` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FdeTiempoCreacion` datetime NOT NULL,
  `FdeTiempoModificacion` datetime NOT NULL,
  `FdeAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FdeId`) USING BTREE,
  INDEX `FDE_FACID_idx`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_FDE_AMDID_idx`(`AmdId`) USING BTREE,
  INDEX `FK_FDE_FATID`(`FatId`) USING BTREE,
  CONSTRAINT `tblfdefacturadetalle_copy1_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfdefacturadetalle_copy1_ibfk_2` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfdefacturadetalle_copy1_ibfk_3` FOREIGN KEY (`FatId`) REFERENCES `tblfatfichaacciontarea` (`FatId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfeafacturaexportacionalmacenmovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblfeafacturaexportacionalmacenmovimiento`;
CREATE TABLE `tblfeafacturaexportacionalmacenmovimiento`  (
  `FeaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FexId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FetId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`FeaId`) USING BTREE,
  INDEX `FK_FEA_FEXID_idx`(`FexId`, `FetId`) USING BTREE,
  INDEX `FK_FEA_AMOID_idx`(`AmoId`) USING BTREE,
  CONSTRAINT `tblfeafacturaexportacionalmacenmovimiento_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfeafacturaexportacionalmacenmovimiento_ibfk_2` FOREIGN KEY (`FexId`, `FetId`) REFERENCES `tblfexfacturaexportacion` (`FexId`, `FetId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfedfacturaexportaciondetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblfedfacturaexportaciondetalle`;
CREATE TABLE `tblfedfacturaexportaciondetalle`  (
  `FedId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FexId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FetId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FedTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FedCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `FedDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FedUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FedPrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FedImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `FedTiempoCreacion` datetime NOT NULL,
  `FedTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FedId`) USING BTREE,
  INDEX `FK_FED_FEXID_idx`(`FexId`, `FetId`) USING BTREE,
  INDEX `FK_FED_AMDID_idx`(`AmdId`) USING BTREE,
  CONSTRAINT `tblfedfacturaexportaciondetalle_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfedfacturaexportaciondetalle_ibfk_2` FOREIGN KEY (`FexId`, `FetId`) REFERENCES `tblfexfacturaexportacion` (`FexId`, `FetId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfiafichaingresomantenimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblfiafichaingresomantenimiento`;
CREATE TABLE `tblfiafichaingresomantenimiento`  (
  `FiaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FiaAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FiaNivel` tinyint(1) NOT NULL DEFAULT 0,
  `FiaVerificar1` tinyint(1) NOT NULL DEFAULT 0,
  `FiaVerificar2` tinyint(1) NOT NULL DEFAULT 0,
  `FiaEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FiaTiempoCreacion` datetime NOT NULL,
  `FiaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FiaId`) USING BTREE,
  UNIQUE INDEX `UNQ_FIMID_PMTID`(`FimId`, `PmtId`) USING BTREE,
  INDEX `FK_FIA_FIMID_idx`(`FimId`) USING BTREE,
  INDEX `FK_FIA_PMTID_idx`(`PmtId`) USING BTREE,
  CONSTRAINT `tblfiafichaingresomantenimiento_ibfk_1` FOREIGN KEY (`FimId`) REFERENCES `tblfimfichaingresomodalidad` (`FimId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfiafichaingresomantenimiento_ibfk_2` FOREIGN KEY (`PmtId`) REFERENCES `tblpmtplanmantenimientotarea` (`PmtId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfigfichaingresogasto
-- ----------------------------
DROP TABLE IF EXISTS `tblfigfichaingresogasto`;
CREATE TABLE `tblfigfichaingresogasto`  (
  `FigId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GasId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FigEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FigTiempoCreacion` datetime NOT NULL,
  `FigTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FigId`) USING BTREE,
  INDEX `FK_FIG_FINID_idx`(`FinId`) USING BTREE,
  INDEX `FK_FIG_GASID_idx`(`GasId`) USING BTREE,
  CONSTRAINT `tblfigfichaingresogasto_ibfk_1` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfigfichaingresogasto_ibfk_2` FOREIGN KEY (`GasId`) REFERENCES `tblgasgasto` (`GasId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfihfichaingresoherramienta
-- ----------------------------
DROP TABLE IF EXISTS `tblfihfichaingresoherramienta`;
CREATE TABLE `tblfihfichaingresoherramienta`  (
  `FihId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FihCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FihCantidadReal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FihEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FihTiempoCreacion` datetime NOT NULL,
  `FihTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FihId`) USING BTREE,
  INDEX `FK_FIH_FINID_idx`(`FinId`) USING BTREE,
  INDEX `FK_FIH_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_FIH_UMEID_idx`(`UmeId`) USING BTREE,
  CONSTRAINT `tblfihfichaingresoherramienta_ibfk_1` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfihfichaingresoherramienta_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfihfichaingresoherramienta_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfimfichaingresomodalidad
-- ----------------------------
DROP TABLE IF EXISTS `tblfimfichaingresomodalidad`;
CREATE TABLE `tblfimfichaingresomodalidad`  (
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimObsequio` tinyint(1) NOT NULL DEFAULT 2,
  `FimNotaCallcenter` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FimEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FimTiempoCreacion` datetime NOT NULL,
  `FimTiempoModificacion` datetime NOT NULL,
  `Aux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FimId`) USING BTREE,
  INDEX `FK_FIM_MINID_idx`(`MinId`) USING BTREE,
  INDEX `FK_FIM_FINID_idx`(`FinId`) USING BTREE,
  CONSTRAINT `tblfimfichaingresomodalidad_ibfk_1` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfimfichaingresomodalidad_ibfk_2` FOREIGN KEY (`MinId`) REFERENCES `tblminmodalidadingreso` (`MinId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfinfichaingreso
-- ----------------------------
DROP TABLE IF EXISTS `tblfinfichaingreso`;
CREATE TABLE `tblfinfichaingreso`  (
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinId2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CitId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CamId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ObsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `FinConductor` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinDireccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinContacto` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinClienteEmail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinFecha` date NOT NULL,
  `FinVentaFechaEntrega` date NULL DEFAULT NULL,
  `FinFechaActividad` date NULL DEFAULT NULL,
  `FinFechaGarantia` date NULL DEFAULT NULL,
  `FinFechaCita` date NULL DEFAULT NULL,
  `FinFechaEntrega` date NULL DEFAULT NULL,
  `FinHoraEntrega` time NULL DEFAULT NULL,
  `FinFechaEntregaExtendida` date NULL DEFAULT NULL,
  `FinHoraEntregaExtendida` time NULL DEFAULT NULL,
  `FinHora` time NOT NULL,
  `FinPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinModalidad` tinyint(1) NOT NULL,
  `FinVehiculoKilometraje` decimal(10, 2) NOT NULL,
  `FinMantenimientoKilometraje` int(10) NOT NULL,
  `FinExteriorDelantero1` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDelantero2` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDelantero3` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDelantero4` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDelantero5` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDelantero6` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDelantero7` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorPosterior1` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorPosterior2` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorPosterior3` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorPosterior4` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorPosterior5` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorPosterior6` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho1` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho2` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho3` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho4` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho5` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho6` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho7` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorDerecho8` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo1` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo2` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo3` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo4` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo5` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo6` tinyint(1) NULL DEFAULT NULL,
  `FinExteriorIzquierdo7` tinyint(1) NULL DEFAULT NULL,
  `FinInterior1` tinyint(1) NULL DEFAULT NULL,
  `FinInterior2` tinyint(1) NULL DEFAULT NULL,
  `FinInterior3` tinyint(1) NULL DEFAULT NULL,
  `FinInterior4` tinyint(1) NULL DEFAULT NULL,
  `FinInterior5` tinyint(1) NULL DEFAULT NULL,
  `FinInterior6` tinyint(1) NULL DEFAULT NULL,
  `FinInterior7` tinyint(1) NULL DEFAULT NULL,
  `FinInterior8` tinyint(1) NULL DEFAULT NULL,
  `FinInterior9` tinyint(1) NULL DEFAULT NULL,
  `FinInterior10` tinyint(1) NULL DEFAULT NULL,
  `FinInterior11` tinyint(1) NULL DEFAULT NULL,
  `FinInterior12` tinyint(1) NULL DEFAULT NULL,
  `FinInterior13` tinyint(1) NULL DEFAULT NULL,
  `FinInterior14` tinyint(1) NULL DEFAULT NULL,
  `FinInterior15` tinyint(1) NULL DEFAULT NULL,
  `FinInterior16` tinyint(1) NULL DEFAULT NULL,
  `FinInterior17` tinyint(1) NULL DEFAULT NULL,
  `FinInterior18` tinyint(1) NULL DEFAULT NULL,
  `FinInterior19` tinyint(1) NULL DEFAULT NULL,
  `FinInterior20` tinyint(1) NULL DEFAULT NULL,
  `FinInterior21` tinyint(1) NULL DEFAULT NULL,
  `FinInterior22` tinyint(1) NULL DEFAULT NULL,
  `FinInterior23` tinyint(1) NULL DEFAULT NULL,
  `FinInterior24` tinyint(1) NULL DEFAULT NULL,
  `FinInterior25` tinyint(1) NULL DEFAULT NULL,
  `FinInterior26` tinyint(1) NULL DEFAULT NULL,
  `FinInterior27` tinyint(1) NULL DEFAULT NULL,
  `FinObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerIdAsesor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinInformeTecnicoMantenimiento` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinInformeTecnicoRevision` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinInformeTecnicoDiagnostico` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinSalidaFecha` date NULL DEFAULT NULL,
  `FinSalidaHora` time NULL DEFAULT NULL,
  `FinSalidaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinSalidaObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinTerminadoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinAlmacenObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinTallerObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinActaEntrega` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinActaEntregaFecha` date NULL DEFAULT NULL,
  `FinManoObraPrecio` decimal(10, 3) NULL DEFAULT 0.000,
  `FinPrecioEstimado` decimal(10, 3) NULL DEFAULT 0.000,
  `FinPrioridad` tinyint(1) NOT NULL DEFAULT 2,
  `FinTiempoTallerConcluido` datetime NULL DEFAULT NULL,
  `FinTiempoTallerRevisando` datetime NULL DEFAULT NULL,
  `FinTiempoTrabajoTerminado` datetime NULL DEFAULT NULL,
  `FinFotoVIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinFotoFrontal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinFotoCupon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinFotoMantenimiento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinTipo` tinyint(1) NOT NULL DEFAULT 1,
  `FinOrigenEntrega` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinMontoPresupuesto` decimal(16, 6) NULL DEFAULT NULL,
  `FinCierre` tinyint(1) NULL DEFAULT NULL,
  `FinReferencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinCita` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinEstado` mediumint(3) NOT NULL,
  `FinTiempoCreacion` datetime NOT NULL,
  `FinTiempoModificacion` datetime NOT NULL,
  `FinMantenimientoKilometrajeAux` int(10) NULL DEFAULT NULL,
  `FinIndicacionTecnico` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FinComprobante` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinMigrado` tinyint(1) NULL DEFAULT NULL,
  `FinIdAnterior` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinAprobado1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinAprobado2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinEstadoMotivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinFechaAux` date NULL DEFAULT NULL,
  `FinObservacionCallcenter` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`FinId`) USING BTREE,
  INDEX `FK_FIN_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_FIN_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_FIN_PERID_idx`(`PerId`) USING BTREE,
  INDEX `FK_FIN_CAMID_idx`(`CamId`) USING BTREE,
  INDEX `FK_FIN_PERIDASESOR_idx`(`PerIdAsesor`) USING BTREE,
  INDEX `FK_FIN_MONID`(`MonId`) USING BTREE,
  INDEX `FK_FIN_TREID`(`TreId`) USING BTREE,
  INDEX `FK_FIN_OVMID`(`OvmId`) USING BTREE,
  INDEX `FK_FIN_CITID`(`CitId`) USING BTREE,
  CONSTRAINT `tblfinfichaingreso_ibfk_1` FOREIGN KEY (`CamId`) REFERENCES `tblcamcampana` (`CamId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_2` FOREIGN KEY (`CitId`) REFERENCES `tblcitcita` (`CitId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_3` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_4` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_6` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_7` FOREIGN KEY (`PerIdAsesor`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfinfichaingreso_ibfk_8` FOREIGN KEY (`TreId`) REFERENCES `tbltretiporeparacion` (`TreId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfipfichaingresoproducto
-- ----------------------------
DROP TABLE IF EXISTS `tblfipfichaingresoproducto`;
CREATE TABLE `tblfipfichaingresoproducto`  (
  `FipId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FipCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `FipPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `FipImporte` decimal(16, 6) NULL DEFAULT NULL,
  `FipEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FipTiempoCreacion` datetime NOT NULL,
  `FipTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FipId`) USING BTREE,
  INDEX `FK_FIP_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_FIP_FIMID_idx`(`FimId`) USING BTREE,
  INDEX `FK_FIP_UMEID`(`UmeId`) USING BTREE,
  CONSTRAINT `tblfipfichaingresoproducto_ibfk_1` FOREIGN KEY (`FimId`) REFERENCES `tblfimfichaingresomodalidad` (`FimId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfipfichaingresoproducto_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfipfichaingresoproducto_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfisfichaingresosuministro
-- ----------------------------
DROP TABLE IF EXISTS `tblfisfichaingresosuministro`;
CREATE TABLE `tblfisfichaingresosuministro`  (
  `FisId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FisCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `FisEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FisTiempoCreacion` datetime NOT NULL,
  `FisTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FisId`) USING BTREE,
  INDEX `FK_FIS_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_FIS_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_FIS_FIMID_idx`(`FimId`) USING BTREE,
  CONSTRAINT `tblfisfichaingresosuministro_ibfk_1` FOREIGN KEY (`FimId`) REFERENCES `tblfimfichaingresomodalidad` (`FimId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfisfichaingresosuministro_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblfisfichaingresosuministro_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfitfichaingresotarea
-- ----------------------------
DROP TABLE IF EXISTS `tblfitfichaingresotarea`;
CREATE TABLE `tblfitfichaingresotarea`  (
  `FitId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FitDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FitCantidad` double(16, 6) NULL DEFAULT NULL,
  `FitPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `FitImporte` decimal(16, 6) NULL DEFAULT NULL,
  `FitAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FitEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FitTiempoCreacion` datetime NOT NULL,
  `FitTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FitId`) USING BTREE,
  INDEX `FK_FIT_FIMID_idx`(`FimId`) USING BTREE,
  CONSTRAINT `tblfitfichaingresotarea_ibfk_1` FOREIGN KEY (`FimId`) REFERENCES `tblfimfichaingresomodalidad` (`FimId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfllfichaingresollamada
-- ----------------------------
DROP TABLE IF EXISTS `tblfllfichaingresollamada`;
CREATE TABLE `tblfllfichaingresollamada`  (
  `FllId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FllNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FllFecha` date NOT NULL,
  `FllObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FllEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FllTiempoCreacion` datetime NOT NULL,
  `FllTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FllId`) USING BTREE,
  INDEX `FK_FLL_FINID_idx`(`FinId`) USING BTREE,
  CONSTRAINT `tblfllfichaingresollamada_ibfk_1` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfmofichaingresomanoobra
-- ----------------------------
DROP TABLE IF EXISTS `tblfmofichaingresomanoobra`;
CREATE TABLE `tblfmofichaingresomanoobra`  (
  `FmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FimId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FmoDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FmoImporte` decimal(16, 6) NULL DEFAULT NULL,
  `FmoEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FmoTiempoCreacion` datetime NOT NULL,
  `FmoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FmoId`) USING BTREE,
  INDEX `FK_FIT_FIMID_idx`(`FimId`) USING BTREE,
  CONSTRAINT `tblfmofichaingresomanoobra_ibfk_1` FOREIGN KEY (`FimId`) REFERENCES `tblfimfichaingresomodalidad` (`FimId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfpaformapago
-- ----------------------------
DROP TABLE IF EXISTS `tblfpaformapago`;
CREATE TABLE `tblfpaformapago`  (
  `FpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FpaAbreviatura` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FpaNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FpaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FpaUso` tinyint(1) NOT NULL,
  `FpaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FpaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblfsxfichaaccionsalidaexterna
-- ----------------------------
DROP TABLE IF EXISTS `tblfsxfichaaccionsalidaexterna`;
CREATE TABLE `tblfsxfichaaccionsalidaexterna`  (
  `FsxId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FsxFechaSalida` date NULL DEFAULT NULL,
  `FsxFechaFinalizacion` date NULL DEFAULT NULL,
  `FsxObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FsxEstado` tinyint(1) NOT NULL DEFAULT 0,
  `FsxTiempoCreacion` datetime NOT NULL,
  `FsxTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FsxId`) USING BTREE,
  INDEX `FK_FSX_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_FSX_PRVID_idx`(`PrvId`) USING BTREE,
  CONSTRAINT `tblfsxfichaaccionsalidaexterna_ibfk_1` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblfsxfichaaccionsalidaexterna_ibfk_2` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblftafacturatalonario
-- ----------------------------
DROP TABLE IF EXISTS `tblftafacturatalonario`;
CREATE TABLE `tblftafacturatalonario`  (
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaNumero` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FtaInicio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `FtaTiempoCreacion` datetime NOT NULL,
  `FtaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`FtaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgamguiaremisionalmacenmovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblgamguiaremisionalmacenmovimiento`;
CREATE TABLE `tblgamguiaremisionalmacenmovimiento`  (
  `GamId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`GamId`) USING BTREE,
  INDEX `FK_GAM_GREID_idx`(`GreId`, `GrtId`) USING BTREE,
  INDEX `FK_GAM_AMOID_idx`(`AmoId`) USING BTREE,
  CONSTRAINT `tblgamguiaremisionalmacenmovimiento_ibfk_1` FOREIGN KEY (`GreId`, `GrtId`) REFERENCES `tblgreguiaremision` (`GreId`, `GrtId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblgamguiaremisionalmacenmovimiento_ibfk_2` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgargarantia
-- ----------------------------
DROP TABLE IF EXISTS `tblgargarantia`;
CREATE TABLE `tblgargarantia`  (
  `GarId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GarDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GarCiudad` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GarTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GarCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GarFechaEmision` date NOT NULL,
  `GarFechaVenta` date NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GarTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `GarSubTotalRepuestoStock` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarFactorPorcentaje1` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarSubTotalRepuestoOtro` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarFactorPorcentaje2` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarPorcentajeImpuestoVenta` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `GarTotalRepuesto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarTotalManoObra` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarSubTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarImpuesto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarModelo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GarTarifaAutorizada` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GarCausa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GarSolucion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GarObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GarObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GarTransaccionFecha` date NULL DEFAULT NULL,
  `GarTransaccionNumero` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GarObservacionFinal` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GarNumeroComprobante` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GarFechaPago` date NULL DEFAULT NULL,
  `GarEstado` tinyint(1) NOT NULL DEFAULT 0,
  `GarTiempoCreacion` datetime NOT NULL,
  `GarTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GarId`) USING BTREE,
  INDEX `FK_GAR_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_GAR_FCCID_idx`(`FccId`) USING BTREE,
  INDEX `FK_GAR_MOID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tblgargarantia_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblgargarantia_ibfk_2` FOREIGN KEY (`FccId`) REFERENCES `tblfccfichaaccion` (`FccId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblgargarantia_ibfk_3` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgasgasto
-- ----------------------------
DROP TABLE IF EXISTS `tblgasgasto`;
CREATE TABLE `tblgasgasto`  (
  `GasId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GasFecha` date NOT NULL,
  `GasComprobanteNumero` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GasComprobanteFecha` date NULL DEFAULT NULL,
  `GasCantidadDia` mediumint(3) NULL DEFAULT NULL,
  `GasDocumentoOrigen` tinyint(1) NULL DEFAULT NULL,
  `GasFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GasTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `GasPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `GasIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `GasConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GasObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GasSubTotal` decimal(16, 6) NULL DEFAULT NULL,
  `GasImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `GasTotal` decimal(16, 6) NULL DEFAULT NULL,
  `GasCancelado` tinyint(1) NULL DEFAULT NULL,
  `GasRevisado` tinyint(1) NULL DEFAULT NULL,
  `GasEstado` tinyint(1) NOT NULL,
  `GasTiempoCreacion` datetime NOT NULL,
  `GasTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GasId`) USING BTREE,
  INDEX `FK_GAS_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_GAS_CTIID_idx`(`CtiId`) USING BTREE,
  INDEX `FK_GAS_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_GAS_NPAID_idx`(`NpaId`) USING BTREE,
  INDEX `FK_GAS_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `FK_GAS_CTIID` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_GAS_MONID` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_GAS_NPAID` FOREIGN KEY (`NpaId`) REFERENCES `tblnpacondicionpago` (`NpaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_GAS_PRVID` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_GAS_TOPID` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgdegarantiadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblgdegarantiadetalle`;
CREATE TABLE `tblgdegarantiadetalle`  (
  `GdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GarId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GdeCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GdeDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GdeCosto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GdeCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `GdeCostoTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GdeMargen` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GdeCostoMargen` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GdeEstado` tinyint(1) NOT NULL DEFAULT 0,
  `GdeTiempoCreacion` datetime NOT NULL,
  `GdeTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GdeId`) USING BTREE,
  INDEX `FK_GDE_GARID_idx`(`GarId`) USING BTREE,
  INDEX `FK_GDE_AMDID`(`AmdId`) USING BTREE,
  CONSTRAINT `tblgdegarantiadetalle_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblgdegarantiadetalle_ibfk_2` FOREIGN KEY (`GarId`) REFERENCES `tblgargarantia` (`GarId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgllgarantiallamada
-- ----------------------------
DROP TABLE IF EXISTS `tblgllgarantiallamada`;
CREATE TABLE `tblgllgarantiallamada`  (
  `GllId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GarId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GllNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GllFecha` date NOT NULL,
  `GllObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GllEstado` tinyint(1) NOT NULL DEFAULT 0,
  `GllTiempoCreacion` datetime NOT NULL,
  `GllTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GllId`) USING BTREE,
  INDEX `FK_GLL_GARID_idx`(`GarId`) USING BTREE,
  CONSTRAINT `FK_GLL_GARID` FOREIGN KEY (`GarId`) REFERENCES `tblgargarantia` (`GarId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgopgarantiaoperacion
-- ----------------------------
DROP TABLE IF EXISTS `tblgopgarantiaoperacion`;
CREATE TABLE `tblgopgarantiaoperacion`  (
  `GopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GarId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FaeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GopNumero` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GopTiempo` decimal(10, 2) NOT NULL,
  `GopValor` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `GopCosto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `GopComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GopTransaccionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GopTransaccionFecha` date NULL DEFAULT NULL,
  `GopFechaAprobacion` date NULL DEFAULT NULL,
  `GopFechaPago` date NULL DEFAULT NULL,
  `GopEstado` tinyint(1) NOT NULL DEFAULT 0,
  `GopTiempoCreacion` datetime NOT NULL,
  `GopTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GopId`) USING BTREE,
  INDEX `FK_GOP_GARID_idx`(`GarId`) USING BTREE,
  INDEX `FK_GOP_FAEID`(`FaeId`) USING BTREE,
  CONSTRAINT `FK_GOP_FAEID` FOREIGN KEY (`FaeId`) REFERENCES `tblfaefichaacciontempario` (`FaeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_GOP_GARID` FOREIGN KEY (`GarId`) REFERENCES `tblgargarantia` (`GarId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgrdguiaremisiondetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblgrdguiaremisiondetalle`;
CREATE TABLE `tblgrdguiaremisiondetalle`  (
  `GrdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrdCodigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrdDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrdCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `GrdUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrdPesoNeto` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `GrdPesoTotal` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `GrdTiempoCreacion` datetime NOT NULL,
  `GrdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GrdId`) USING BTREE,
  INDEX `FK_GRD_GREID_idx`(`GreId`, `GrtId`) USING BTREE,
  CONSTRAINT `tblgrdguiaremisiondetalle_ibfk_1` FOREIGN KEY (`GreId`, `GrtId`) REFERENCES `tblgreguiaremision` (`GreId`, `GrtId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgreguiaremision
-- ----------------------------
DROP TABLE IF EXISTS `tblgreguiaremision`;
CREATE TABLE `tblgreguiaremision`  (
  `GreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreDestinatarioNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreDestinatarioNumeroDocumento1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreDestinatarioNumeroDocumento2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreFechaEmision` date NULL DEFAULT NULL,
  `GreFechaInicioTraslado` date NOT NULL,
  `GrePuntoPartida` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrePuntoLlegada` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GreNumeroRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreNumeroConstanciaInscripcion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreChofer` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreChoferNumeroDocumento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreNumeroLicenciaConducir` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreMotivoTraslado` tinyint(2) NOT NULL DEFAULT 0,
  `GreMotivoTrasladoOtro` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreMotivoTrasladoCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreMotivoTrasladoDescripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreComprobantePagoNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GreObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GrePuntoPartidaCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePuntoLlegadaCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreCierre` tinyint(1) NOT NULL DEFAULT 1,
  `GreSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GreSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioTicketEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GreSunatRespuestaEnvioRespuesta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaBajaTicketEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `GreSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `GreSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GreSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `GreSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GreSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `GreSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `GreSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `GrecSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `GreSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatUltimaRespuesta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreSunatRespuestaEnvioDigestValue` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GreEstado` tinyint(1) NOT NULL DEFAULT 1,
  `GreTiempoCreacion` datetime NOT NULL,
  `GreTiempoModificacion` datetime NOT NULL,
  `GrePuntoPartidaDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePuntoPartidaProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePuntoPartidaDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePuntoLlegadaDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePuntoLlegadaProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePuntoLlegadaDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrePesoTotal` decimal(10, 2) NULL DEFAULT NULL,
  `GreTotalPaquetes` decimal(10, 2) NULL DEFAULT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`GreId`, `GrtId`) USING BTREE,
  INDEX `FK_GRE_GRTID_idx`(`GrtId`) USING BTREE,
  INDEX `FK_GRE_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_GRE_PRVID_idx`(`PrvId`) USING BTREE,
  CONSTRAINT `tblgreguiaremision_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblgreguiaremision_ibfk_2` FOREIGN KEY (`GrtId`) REFERENCES `tblgrtguiaremisiontalonario` (`GrtId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblgreguiaremision_ibfk_3` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblgrtguiaremisiontalonario
-- ----------------------------
DROP TABLE IF EXISTS `tblgrtguiaremisiontalonario`;
CREATE TABLE `tblgrtguiaremisiontalonario`  (
  `GrtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrtNumero` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GrtInicio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GrtTiempoCreacion` datetime NOT NULL,
  `GrtTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`GrtId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblicoingresocomprobante
-- ----------------------------
DROP TABLE IF EXISTS `tblicoingresocomprobante`;
CREATE TABLE `tblicoingresocomprobante`  (
  `IcoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IngId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `GasId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IcoId`) USING BTREE,
  INDEX `FK_ICO_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_ICO_DESID_idx`(`IngId`) USING BTREE,
  INDEX `FK_ICO_GASID_idx`(`GasId`) USING BTREE,
  CONSTRAINT `tblicoingresocomprobante_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblicoingresocomprobante_ibfk_2` FOREIGN KEY (`GasId`) REFERENCES `tblgasgasto` (`GasId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblicoingresocomprobante_ibfk_3` FOREIGN KEY (`IngId`) REFERENCES `tbldesdesembolso` (`DesId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblindinmatriculaciondetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblindinmatriculaciondetalle`;
CREATE TABLE `tblindinmatriculaciondetalle`  (
  `IndId` int(20) NOT NULL AUTO_INCREMENT,
  `InmId` int(6) NULL DEFAULT NULL,
  `InpId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IndResultado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IndFechaEjecucion` date NULL DEFAULT NULL,
  `IndFechaFin` date NULL DEFAULT NULL,
  `IndEstado` int(1) NULL DEFAULT NULL,
  `IndObservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IndId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1513 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblingingreso
-- ----------------------------
DROP TABLE IF EXISTS `tblingingreso`;
CREATE TABLE `tblingingreso`  (
  `IngId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IngFecha` date NOT NULL,
  `IngNumeroCheque` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IngConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IngObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IngObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IngTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `IngFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IngMonto` decimal(16, 6) NOT NULL,
  `IngTipo` tinyint(1) NULL DEFAULT NULL,
  `IngTipoDestino` tinyint(1) NULL DEFAULT NULL,
  `IngReferencia` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IngEstado` tinyint(1) NOT NULL,
  `IngTiempoCreacion` datetime NULL DEFAULT NULL,
  `IngTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`IngId`) USING BTREE,
  INDEX `FK_DES_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_DES_CUEID_idx`(`CueId`) USING BTREE,
  INDEX `FK_DES_PERID_idx`(`PerId`) USING BTREE,
  INDEX `FK_DES_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_DES_PRVID_idx`(`PrvId`) USING BTREE,
  CONSTRAINT `tblingingreso_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblingingreso_ibfk_2` FOREIGN KEY (`CueId`) REFERENCES `tblcuecuenta` (`CueId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblingingreso_ibfk_3` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblingingreso_ibfk_4` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblingingreso_ibfk_5` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblinminmatriculacion
-- ----------------------------
DROP TABLE IF EXISTS `tblinminmatriculacion`;
CREATE TABLE `tblinminmatriculacion`  (
  `InmId` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `InmEstado` int(1) NULL DEFAULT NULL,
  `InmFecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`InmId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1478 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblinpinmatriculacionproceso
-- ----------------------------
DROP TABLE IF EXISTS `tblinpinmatriculacionproceso`;
CREATE TABLE `tblinpinmatriculacionproceso`  (
  `InpId` int(11) NOT NULL AUTO_INCREMENT,
  `InpNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `InpOrden` int(2) NULL DEFAULT NULL,
  `InpEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`InpId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbliteinformetecnico
-- ----------------------------
DROP TABLE IF EXISTS `tbliteinformetecnico`;
CREATE TABLE `tbliteinformetecnico`  (
  `IteId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteTipoCambio` decimal(10, 2) NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteCargo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteConcesionario` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteSedeLocal` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteFecha` date NOT NULL,
  `IteFechaVenta` date NULL DEFAULT NULL,
  `IteContactoGM` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ItePlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ItePropietario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteCondicion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IteCausa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IteCorreccion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IteConclusion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IteSolucionSatisfactoria` tinyint(1) NULL DEFAULT 0,
  `IteMotor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteTipoTransmision` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteTipoCarroceria` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteCarga` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteCiudad` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteDepartamento` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteUsoVehiculo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteAltitud` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IteObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `IteEstado` tinyint(1) NULL DEFAULT 0,
  `IteTiempoCreacion` datetime NOT NULL,
  `IteTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`IteId`) USING BTREE,
  INDEX `FK_ITE_FINID_idx`(`FinId`) USING BTREE,
  CONSTRAINT `tbliteinformetecnico_ibfk_1` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblitpinformetecnicoproducto
-- ----------------------------
DROP TABLE IF EXISTS `tblitpinformetecnicoproducto`;
CREATE TABLE `tblitpinformetecnicoproducto`  (
  `ItpId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IteId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FapId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ItpValorUnitario` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ItpCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `ItpValorTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ItpEstado` tinyint(1) NOT NULL DEFAULT 0,
  `ItpTiempoCreacion` datetime NOT NULL,
  `ItpTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`ItpId`) USING BTREE,
  INDEX `FK_ITP_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_ITP_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_ITP_FAPID_idx`(`FapId`) USING BTREE,
  INDEX `FK_ITP_ITEID_idx`(`IteId`) USING BTREE,
  CONSTRAINT `tblitpinformetecnicoproducto_ibfk_1` FOREIGN KEY (`FapId`) REFERENCES `tblfapfichaaccionproducto` (`FapId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblitpinformetecnicoproducto_ibfk_2` FOREIGN KEY (`IteId`) REFERENCES `tbliteinformetecnico` (`IteId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblitpinformetecnicoproducto_ibfk_3` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblitpinformetecnicoproducto_ibfk_4` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbllprlistaprecio
-- ----------------------------
DROP TABLE IF EXISTS `tbllprlistaprecio`;
CREATE TABLE `tbllprlistaprecio`  (
  `LprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LprEquivalente` decimal(10, 3) NULL DEFAULT NULL,
  `LprCosto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `LprPorcentajeOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `LprPorcentajeUtilidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `LprPorcentajeManoObra` decimal(10, 0) NULL DEFAULT NULL,
  `LprPorcentajeAdicional` decimal(10, 3) NULL DEFAULT NULL,
  `LprPorcentajeDescuento` decimal(10, 3) NULL DEFAULT NULL,
  `LprOtroCosto` decimal(10, 3) NULL DEFAULT NULL,
  `LprUtilidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `LprManoObra` decimal(10, 3) NULL DEFAULT NULL,
  `LprValorVenta` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `LprImpuesto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `LprAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `LprDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `LprPrecio` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `LprPrecioCotizacion` decimal(16, 6) NULL DEFAULT NULL,
  `LprTiempoCreacion` datetime NOT NULL,
  `LprTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`LprId`) USING BTREE,
  INDEX `FK_LPR_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_LPR_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_LPR_LTIID_idx`(`LtiId`) USING BTREE,
  INDEX `FK_LPR_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `FK_LPR_SUCID` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbllprlistaprecio_ibfk_1` FOREIGN KEY (`LtiId`) REFERENCES `tbllticlientetipo` (`LtiId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbllprlistaprecio_ibfk_2` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbllticlientetipo
-- ----------------------------
DROP TABLE IF EXISTS `tbllticlientetipo`;
CREATE TABLE `tbllticlientetipo`  (
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LtiAbreviatura` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiPorcentajeMargenUtilidad` decimal(10, 2) NULL DEFAULT NULL,
  `LtiPorcentajeOtroCosto` decimal(10, 2) NULL DEFAULT NULL,
  `LtiPorcentajeDescuento` decimal(10, 2) NULL DEFAULT NULL,
  `LtiPorcentajeManoObra` decimal(10, 2) NULL DEFAULT NULL,
  `LtiUtilidad` tinyint(1) NOT NULL,
  `LtiManoObra` decimal(10, 8) NULL DEFAULT NULL,
  `LtiUso` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `LtiObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `LtiEstado` tinyint(1) NOT NULL,
  `LtiTiempoCreacion` datetime NOT NULL,
  `LtiTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`LtiId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblminmodalidadingreso
-- ----------------------------
DROP TABLE IF EXISTS `tblminmodalidadingreso`;
CREATE TABLE `tblminmodalidadingreso`  (
  `MinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MinNombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MinSigla` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MinDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MinOrden` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `MinUso` tinyint(1) NOT NULL DEFAULT 1,
  `MinEstado` tinyint(1) NOT NULL,
  `MinTiempoCreacion` datetime NOT NULL,
  `MinTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`MinId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblmodmodulos
-- ----------------------------
DROP TABLE IF EXISTS `tblmodmodulos`;
CREATE TABLE `tblmodmodulos`  (
  `ModId` int(11) NOT NULL AUTO_INCREMENT,
  `ModNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ModIcono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ModLink` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ModFuncion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ModEstado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ModId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblmonmoneda
-- ----------------------------
DROP TABLE IF EXISTS `tblmonmoneda`;
CREATE TABLE `tblmonmoneda`  (
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonSigla` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonAbreviacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonCodigo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonNombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonSimbolo` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonEstado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`MonId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblmpamodalidadpago
-- ----------------------------
DROP TABLE IF EXISTS `tblmpamodalidadpago`;
CREATE TABLE `tblmpamodalidadpago`  (
  `MpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MpaAbreviatura` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MpaNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MpaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `MpaUso` tinyint(1) NOT NULL,
  PRIMARY KEY (`MpaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnccnotacreditocompra
-- ----------------------------
DROP TABLE IF EXISTS `tblnccnotacreditocompra`;
CREATE TABLE `tblnccnotacreditocompra`  (
  `NccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NccComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NccComprobanteFecha` date NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NccFechaEmision` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CvhId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NccTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `NccIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 0,
  `NccPorcentajeImpuestoVenta` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `NccObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NccSubTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `NccImpuesto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `NccTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `NccCierre` tinyint(1) NOT NULL DEFAULT 0,
  `NccFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NccEstado` tinyint(1) NOT NULL DEFAULT 0,
  `NccTiempoCreacion` datetime NOT NULL,
  `NccTiempoModificacion` datetime NOT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`NccId`) USING BTREE,
  INDEX `FK_NCC_AMOID_idx`(`AmoId`) USING BTREE,
  INDEX `FK_NCC_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_NCC_PRVID_idx`(`PrvId`) USING BTREE,
  CONSTRAINT `tblnccnotacreditocompra_ibfk_1` FOREIGN KEY (`AmoId`) REFERENCES `tblamoalmacenmovimiento` (`AmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblnccnotacreditocompra_ibfk_2` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblnccnotacreditocompra_ibfk_3` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblncdnotacreditodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblncdnotacreditodetalle`;
CREATE TABLE `tblncdnotacreditodetalle`  (
  `NcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NcdCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcdCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `NcdUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcdDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NcdPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `NcdImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NcdValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `NcdImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `NcdImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `NcdDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `NcdGratuito` tinyint(1) NULL DEFAULT NULL,
  `NcdExonerado` tinyint(1) NULL DEFAULT NULL,
  `NcdIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `NcdTiempoCreacion` datetime NOT NULL,
  `NcdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NcdId`) USING BTREE,
  INDEX `FK_NCD_NCRID_idx`(`NcrId`, `NctId`) USING BTREE,
  CONSTRAINT `tblncdnotacreditodetalle_ibfk_1` FOREIGN KEY (`NcrId`, `NctId`) REFERENCES `tblncrnotacredito` (`NcrId`, `NctId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblncrnotacredito
-- ----------------------------
DROP TABLE IF EXISTS `tblncrnotacredito`;
CREATE TABLE `tblncrnotacredito`  (
  `NcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrFechaEmision` date NOT NULL,
  `NcrDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrCierre` tinyint(1) NOT NULL DEFAULT 1,
  `NcrTotalPagar` decimal(16, 6) NULL DEFAULT NULL,
  `NcrTotalImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `NcrTotalExonerado` decimal(16, 6) NULL DEFAULT NULL,
  `NcrTotalDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `NcrTotalGratuito` decimal(16, 6) NULL DEFAULT NULL,
  `NcrTotalGravado` decimal(16, 6) NULL DEFAULT NULL,
  `NcrSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NcrImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NcrTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NcrObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrMotivo` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrMotivoCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrTipo` tinyint(1) NULL DEFAULT 1,
  `NcrIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `NcrPorcentajeImpuestoVenta` decimal(10, 0) NULL DEFAULT NULL,
  `NcrPorcentajeImpuestoSelectivo` double(10, 3) NULL DEFAULT NULL,
  `NcrSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaBajaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `NcrSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `NcrSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `NcrSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `NcrSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `NcrSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `NcrSunatRespuestaEnvioDigestValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrSunatUltimaRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrEstado` tinyint(1) NOT NULL DEFAULT 1,
  `NcrDatoAdicional1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional4` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional5` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional6` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional7` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional8` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional9` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional10` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional11` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional12` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional13` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional14` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional15` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional16` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional17` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional18` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional19` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional20` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional21` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional22` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional23` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional24` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional25` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional26` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional27` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrDatoAdicional28` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrVendedor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrNumeroPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrTiempoCreacion` datetime NOT NULL,
  `NcrTiempoModificacion` datetime NOT NULL,
  `NcrAux` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NcrTipoCambioAux` decimal(16, 6) NULL DEFAULT NULL,
  `NcrCuota` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`NcrId`, `NctId`) USING BTREE,
  INDEX `FK_NCR_NCTID_idx`(`NctId`) USING BTREE,
  INDEX `FK_NCR_MONID`(`MonId`) USING BTREE,
  INDEX `FK_NCR_CLIID`(`CliId`) USING BTREE,
  INDEX `FK_NCR_FACID`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_NCR_BOLID`(`BolId`, `BtaId`) USING BTREE,
  CONSTRAINT `tblncrnotacredito_ibfk_1` FOREIGN KEY (`BolId`, `BtaId`) REFERENCES `tblbolboleta` (`BolId`, `BtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblncrnotacredito_ibfk_2` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblncrnotacredito_ibfk_3` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblncrnotacredito_ibfk_4` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblncrnotacredito_ibfk_5` FOREIGN KEY (`NctId`) REFERENCES `tblnctnotacreditotalonario` (`NctId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnctnotacreditotalonario
-- ----------------------------
DROP TABLE IF EXISTS `tblnctnotacreditotalonario`;
CREATE TABLE `tblnctnotacreditotalonario`  (
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NctNumero` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NctInicio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NctDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NctTiempoCreacion` datetime NOT NULL,
  `NctTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NctId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblndbnotadebito
-- ----------------------------
DROP TABLE IF EXISTS `tblndbnotadebito`;
CREATE TABLE `tblndbnotadebito`  (
  `NdbId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbFechaEmision` date NOT NULL,
  `NdbDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbCierre` tinyint(1) NOT NULL DEFAULT 1,
  `NdbTotalPagar` decimal(16, 6) NULL DEFAULT NULL,
  `NdbTotalImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `NdbTotalExonerado` decimal(16, 6) NULL DEFAULT NULL,
  `NdbTotalDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `NdbTotalGratuito` decimal(16, 6) NULL DEFAULT NULL,
  `NdbTotalGravado` decimal(16, 6) NULL DEFAULT NULL,
  `NdbSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NdbImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NdbTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NdbObservacion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbMotivo` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbMotivoCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbTipo` tinyint(1) NULL DEFAULT 1,
  `NdbIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `NdbPorcentajeImpuestoVenta` decimal(10, 0) NULL DEFAULT NULL,
  `NdbPorcentajeImpuestoSelectivo` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdbSunatRespuestaEnvioTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioFecha` date NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioHora` time NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdbSunatRespuestaBajaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaBajaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaBajaFecha` date NULL DEFAULT NULL,
  `NdbSunatRespuestaBajaHora` time NULL DEFAULT NULL,
  `NdbSunatRespuestaBajaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaBajaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdbSunatRespuestaBajaId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaConsultaCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatRespuestaConsultaContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdbSunatRespuestaConsultaFecha` date NULL DEFAULT NULL,
  `NdbSunatRespuestaConsultaHora` time NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioTiempoCreacion` datetime NULL DEFAULT NULL,
  `NdbSunatRespuestaConsultaTiempoCreacion` datetime NULL DEFAULT NULL,
  `NdbSunatRespuestaBajaTiempoCreacion` datetime NULL DEFAULT NULL,
  `NdbSunatRespuestaEnvioDigestValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdbSunatRespuestaEnvioSignatureValue` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdbSunatUltimaAccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbSunatUltimaRespuesta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbEstado` tinyint(1) NOT NULL DEFAULT 1,
  `NdbDatoAdicional1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional4` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional5` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional6` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional7` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional8` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional9` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional10` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional11` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional12` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional13` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional14` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional15` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional16` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional17` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional18` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional19` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional20` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional21` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional22` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional23` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional24` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional25` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbDatoAdicional26` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbVendedor` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbNumeroPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbTiempoCreacion` datetime NOT NULL,
  `NdbTiempoModificacion` datetime NOT NULL,
  `NcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbTipoCambioAux` decimal(16, 6) NULL DEFAULT NULL,
  `NdbCuota` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`NdbId`, `NdtId`) USING BTREE,
  INDEX `FK_NDB_CLIID`(`CliId`) USING BTREE,
  INDEX `FK_NDB_FACID`(`FacId`, `FtaId`) USING BTREE,
  INDEX `FK_NDB_BOLID`(`BolId`, `BtaId`) USING BTREE,
  INDEX `FK_NDB_MONID`(`MonId`) USING BTREE,
  INDEX `FK_NDB_NDTID`(`NdtId`) USING BTREE,
  INDEX `FK_NDB_NCRID_NCTID`(`NcrId`, `NctId`) USING BTREE,
  CONSTRAINT `FK_NDB_NCRID_NCTID` FOREIGN KEY (`NcrId`, `NctId`) REFERENCES `tblncrnotacredito` (`NcrId`, `NctId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_NDB_NDTID` FOREIGN KEY (`NdtId`) REFERENCES `tblndtnotadebitotalonario` (`NdtId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblndbnotadebito_ibfk_1` FOREIGN KEY (`BolId`, `BtaId`) REFERENCES `tblbolboleta` (`BolId`, `BtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblndbnotadebito_ibfk_2` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblndbnotadebito_ibfk_3` FOREIGN KEY (`FacId`, `FtaId`) REFERENCES `tblfacfactura` (`FacId`, `FtaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblndbnotadebito_ibfk_4` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnddnotadebitodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblnddnotadebitodetalle`;
CREATE TABLE `tblnddnotadebitodetalle`  (
  `NddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NdbId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NddCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NddCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `NddUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NddDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NddPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `NddImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NddValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `NddImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `NddImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `NddDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `NddGratuito` tinyint(1) NULL DEFAULT NULL,
  `NddExonerado` tinyint(1) NULL DEFAULT NULL,
  `NddIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `NddTiempoCreacion` datetime NOT NULL,
  `NddTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NddId`) USING BTREE,
  INDEX `FK_NCD_NCRID_idx`(`NdbId`, `NdtId`) USING BTREE,
  CONSTRAINT `FK_NDD_NDBID_NDTID` FOREIGN KEY (`NdbId`, `NdtId`) REFERENCES `tblndbnotadebito` (`NdbId`, `NdtId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnddnotadebitodetalle_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblnddnotadebitodetalle_copy`;
CREATE TABLE `tblnddnotadebitodetalle_copy`  (
  `NddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NdbId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NddCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NddCantidad` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `NddUnidadMedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NddDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NddPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `NddImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `NddValorVenta` decimal(16, 6) NULL DEFAULT NULL,
  `NddImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `NddImpuestoSelectivo` decimal(16, 6) NULL DEFAULT NULL,
  `NddDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `NddGratuito` tinyint(1) NULL DEFAULT NULL,
  `NddExonerado` tinyint(1) NULL DEFAULT NULL,
  `NddIncluyeSelectivo` tinyint(1) NULL DEFAULT NULL,
  `NddTiempoCreacion` datetime NOT NULL,
  `NddTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NddId`) USING BTREE,
  INDEX `FK_NCD_NCRID_idx`(`NdbId`, `NdtId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblndtnotadebitotalonario
-- ----------------------------
DROP TABLE IF EXISTS `tblndtnotadebitotalonario`;
CREATE TABLE `tblndtnotadebitotalonario`  (
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdtNumero` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NdtInicio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdtDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NdtTiempoCreacion` datetime NOT NULL,
  `NdtTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NdtId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnfnnotificacion2
-- ----------------------------
DROP TABLE IF EXISTS `tblnfnnotificacion2`;
CREATE TABLE `tblnfnnotificacion2`  (
  `NfnId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuIdOrigen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnModulo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnFormulario` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NfnUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnPersonalNombreCompleto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnPersonalFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnTipo` tinyint(1) NULL DEFAULT NULL,
  `NfnIcono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnEnlace` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnEnlaceNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NfnEstado` tinyint(1) NOT NULL,
  `NfnTiempoCreacion` datetime NOT NULL,
  `NfnTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NfnId`) USING BTREE,
  INDEX `FK_NFN_USUID_idx`(`UsuId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnodnotacreditocompradetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblnodnotacreditocompradetalle`;
CREATE TABLE `tblnodnotacreditocompradetalle`  (
  `NodId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NodCantidad` decimal(10, 3) NOT NULL,
  `NodPrecio` decimal(10, 3) NOT NULL,
  `NodImporte` decimal(10, 3) NOT NULL,
  `NodEstado` tinyint(1) NOT NULL,
  `NodTiempoCreacion` datetime NOT NULL,
  `NodTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`NodId`) USING BTREE,
  INDEX `FK_NOD_NCCID_idx`(`NccId`) USING BTREE,
  INDEX `FK_NOD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_NOD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_NOD_AMDID_idx`(`AmdId`) USING BTREE,
  CONSTRAINT `tblnodnotacreditocompradetalle_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblnodnotacreditocompradetalle_ibfk_2` FOREIGN KEY (`NccId`) REFERENCES `tblnccnotacreditocompra` (`NccId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblnodnotacreditocompradetalle_ibfk_3` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblnodnotacreditocompradetalle_ibfk_4` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblnpacondicionpago
-- ----------------------------
DROP TABLE IF EXISTS `tblnpacondicionpago`;
CREATE TABLE `tblnpacondicionpago`  (
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NpaNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NpaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `NpaUso` tinyint(1) NOT NULL,
  PRIMARY KEY (`NpaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblobsobsequio
-- ----------------------------
DROP TABLE IF EXISTS `tblobsobsequio`;
CREATE TABLE `tblobsobsequio`  (
  `ObsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ObsNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ObsSigla` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ObsDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ObsOrden` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ObsUso` tinyint(1) NOT NULL DEFAULT 1,
  `ObsArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ObsFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ObsTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `ObsPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `ObsPrecioReal` decimal(16, 6) NULL DEFAULT NULL,
  `ObsEstado` tinyint(1) NOT NULL,
  `ObsTiempoCreacion` datetime NOT NULL,
  `ObsTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`ObsId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblociordencodificacion
-- ----------------------------
DROP TABLE IF EXISTS `tblociordencodificacion`;
CREATE TABLE `tblociordencodificacion`  (
  `OciId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciFecha` date NOT NULL,
  `OciFechaRespuesta` date NULL DEFAULT NULL,
  `OciHora` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciSolicitante` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciSolicitanteCargo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciDealerSucursal` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciDescripcionPN` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OciVIN` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciVehiculoModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciVehiculoAnoFabricacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciVehiculoMotorCilindrada` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OciObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OciObservacionCorreo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OciFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OciEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OciTiempoCreacion` datetime NOT NULL,
  `OciTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`OciId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblocoordencompra
-- ----------------------------
DROP TABLE IF EXISTS `tblocoordencompra`;
CREATE TABLE `tblocoordencompra`  (
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OcoTipo` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OcoAno` mediumint(4) NOT NULL,
  `OcoMes` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OcoCodigoDealer` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoVIN` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoOrdenTrabajo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoFecha` date NOT NULL,
  `OcoFechaLlegadaEstimada` date NULL DEFAULT NULL,
  `OcoHora` time NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `OcoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OcoRespuestaProveedor` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OcoProcesadoProveedor` tinyint(1) NULL DEFAULT NULL,
  `OcoTieneETA` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `OcoPorcentajeImpuestoVenta` decimal(10, 2) NULL DEFAULT NULL,
  `OcoSubTotal` decimal(16, 6) NULL DEFAULT NULL,
  `OcoImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `OcoTotal` decimal(16, 6) NOT NULL,
  `OcoEstado` tinyint(1) NOT NULL,
  `OcoTiempoCreacion` datetime NOT NULL,
  `OcoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`OcoId`) USING BTREE,
  INDEX `FK_OCO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_OCO_PRVID_idx`(`PrvId`) USING BTREE,
  CONSTRAINT `tblocoordencompra_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblocoordencompra_ibfk_2` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbloncconcesionario
-- ----------------------------
DROP TABLE IF EXISTS `tbloncconcesionario`;
CREATE TABLE `tbloncconcesionario`  (
  `OncId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OncCodigoDealer` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OncNumeroDocumento` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OncNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OncDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OncEstado` tinyint(1) NOT NULL,
  `OncTiempoCreacion` datetime NOT NULL,
  `OncTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`OncId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbloodordencotizaciondetalle
-- ----------------------------
DROP TABLE IF EXISTS `tbloodordencotizaciondetalle`;
CREATE TABLE `tbloodordencotizaciondetalle`  (
  `OodId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OotId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OodCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OodAno` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `OodModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OodCantidad` decimal(10, 3) NOT NULL,
  `OodPrecio` decimal(10, 3) NOT NULL,
  `OodImporte` decimal(10, 3) NOT NULL,
  `OodEstado` tinyint(1) NOT NULL,
  `OodTiempoCreacion` datetime NOT NULL,
  `OodTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`OodId`) USING BTREE,
  INDEX `FK_OOD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_OOD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_OOD_OOTID_idx`(`OotId`) USING BTREE,
  CONSTRAINT `tbloodordencotizaciondetalle_ibfk_1` FOREIGN KEY (`OotId`) REFERENCES `tblootordencotizacion` (`OotId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbloodordencotizaciondetalle_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbloodordencotizaciondetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblootordencotizacion
-- ----------------------------
DROP TABLE IF EXISTS `tblootordencotizacion`;
CREATE TABLE `tblootordencotizacion`  (
  `OotId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OotFecha` date NOT NULL,
  `OotFechaRespuesta` date NULL DEFAULT NULL,
  `OotHora` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OotTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `OotIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 0,
  `OotPorcentajeImpuestoVenta` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `OotObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OotSubTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `OotImpuesto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `OotTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `OotOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OotCodigoExterno` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OotCodigoReferencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OotEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OotTiempoCreacion` datetime NOT NULL,
  `OotTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`OotId`) USING BTREE,
  INDEX `FK_OOT_PRVID_idx`(`PrvId`) USING BTREE,
  INDEX `FK_OOT_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tblootordencotizacion_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblootordencotizacion_ibfk_2` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblovlordenventavehiculollamada
-- ----------------------------
DROP TABLE IF EXISTS `tblovlordenventavehiculollamada`;
CREATE TABLE `tblovlordenventavehiculollamada`  (
  `OvlId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvlNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvlFecha` date NULL DEFAULT NULL,
  `OvlObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OvlEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OvlTiempoCreacion` datetime NULL DEFAULT NULL,
  `OvlTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`OvlId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblovmordenventavehiculomantenimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblovmordenventavehiculomantenimiento`;
CREATE TABLE `tblovmordenventavehiculomantenimiento`  (
  `OvmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvmKilometraje` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvmEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OvmTiempoCreacion` datetime NULL DEFAULT NULL,
  `OvmTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`OvmId`) USING BTREE,
  INDEX `FK_OVO_OVVID_idx`(`OvvId`) USING BTREE,
  INDEX `FK_OVO_OBSID_idx`(`OvmKilometraje`) USING BTREE,
  CONSTRAINT `tblovmordenventavehiculomantenimiento_ibfk_1` FOREIGN KEY (`OvvId`) REFERENCES `tblovvordenventavehiculo` (`OvvId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblovnordenventavehiculocondicionventa
-- ----------------------------
DROP TABLE IF EXISTS `tblovnordenventavehiculocondicionventa`;
CREATE TABLE `tblovnordenventavehiculocondicionventa`  (
  `OvnId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CovId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvnEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OvnTiempoCreacion` datetime NULL DEFAULT NULL,
  `OvnTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`OvnId`) USING BTREE,
  INDEX `FK_OVN_OVVID_idx`(`OvvId`) USING BTREE,
  INDEX `FK_OVN_COVID_idx`(`CovId`) USING BTREE,
  CONSTRAINT `tblovnordenventavehiculocondicionventa_ibfk_1` FOREIGN KEY (`CovId`) REFERENCES `tblcovcondicionventa` (`CovId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblovoordenventavehiculoobsequio
-- ----------------------------
DROP TABLE IF EXISTS `tblovoordenventavehiculoobsequio`;
CREATE TABLE `tblovoordenventavehiculoobsequio`  (
  `OvoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ObsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvoAprobado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvoObsequio` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvoEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OvoTiempoCreacion` datetime NULL DEFAULT NULL,
  `OvoTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`OvoId`) USING BTREE,
  INDEX `FK_OVO_OVVID_idx`(`OvvId`) USING BTREE,
  INDEX `FK_OVO_OBSID_idx`(`ObsId`) USING BTREE,
  CONSTRAINT `tblovoordenventavehiculoobsequio_ibfk_1` FOREIGN KEY (`ObsId`) REFERENCES `tblobsobsequio` (`ObsId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblovoordenventavehiculoobsequio_ibfk_2` FOREIGN KEY (`OvvId`) REFERENCES `tblovvordenventavehiculo` (`OvvId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblovpordenventavehiculopropietario
-- ----------------------------
DROP TABLE IF EXISTS `tblovpordenventavehiculopropietario`;
CREATE TABLE `tblovpordenventavehiculopropietario`  (
  `OvpId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvpFirmaDJ` tinyint(1) NULL DEFAULT NULL,
  `OvpEstado` tinyint(1) NOT NULL DEFAULT 0,
  `OvpTiempoCreacion` datetime NULL DEFAULT NULL,
  `OvpTIempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`OvpId`) USING BTREE,
  INDEX `FK_OVP_OVVID_idx`(`OvvId`) USING BTREE,
  INDEX `FK_OVP_CLIID_idx`(`CliId`) USING BTREE,
  CONSTRAINT `tblovpordenventavehiculopropietario_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblovpordenventavehiculopropietario_ibfk_2` FOREIGN KEY (`OvvId`) REFERENCES `tblovvordenventavehiculo` (`OvvId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblovvordenventavehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblovvordenventavehiculo`;
CREATE TABLE `tblovvordenventavehiculo`  (
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CveId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvFecha` date NOT NULL,
  `OvvFechaEntrega` date NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `OvvIncluyeImpuesto` tinyint(1) NOT NULL,
  `OvvPorcentajeImpuestoVenta` decimal(10, 2) NOT NULL,
  `OvvObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OvvObservacionCorreo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OvvNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OvvTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvDireccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvEmail` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvAnoModelo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvAnoFabricacion` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvColor` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerIdFirmante` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `OvvDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `OvvBonoGM` decimal(16, 6) NULL DEFAULT NULL,
  `OvvBonoDealer` decimal(16, 6) NULL DEFAULT NULL,
  `OvvDescuentoGerencia` decimal(16, 6) NULL DEFAULT NULL,
  `OvvSubTotal` decimal(16, 6) NOT NULL,
  `OvvImpuesto` decimal(16, 6) NOT NULL,
  `OvvTotal` decimal(16, 6) NOT NULL,
  `OvvComprobanteVenta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvCondicionVentaOtro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvObsequioOtro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvActaEntregaFechaPDS` date NULL DEFAULT NULL,
  `OvvActaEntregaFecha` date NULL DEFAULT NULL,
  `OvvActaEntregaHora` time NULL DEFAULT NULL,
  `OvvActaEntregaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OvvFotoActaEntrega` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerIdActaEntrega` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvAprobacion1` tinyint(1) NULL DEFAULT NULL,
  `OvvAprobacion2` tinyint(1) NULL DEFAULT NULL,
  `OvvAprobacion3` tinyint(1) NULL DEFAULT NULL,
  `OvvCartaResponsabilidadFecha` date NULL DEFAULT NULL,
  `OvvCartaCompromisoFecha` date NULL DEFAULT NULL,
  `OvvDeclaracionJuradaFecha` date NULL DEFAULT NULL,
  `OvvDeclaracionJuradaSUNARPFecha` date NULL DEFAULT NULL,
  `OvvVehiculoMarca` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvVehiculoModelo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvVehiculoVersion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvGLP` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvSeparacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvInmediata` tinyint(1) NULL DEFAULT NULL,
  `OvvAnuladoAprobacion` tinyint(1) NULL DEFAULT NULL,
  `OvvReferencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvTipoPlaca` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvGLPModeloTanque` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvObservacionAsignacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `OvvTramite` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvEstado` tinyint(1) NOT NULL,
  `OvvTiempoCreacion` datetime NOT NULL,
  `OvvTiempoModificacion` datetime NOT NULL,
  `OvvIdAnterior` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvTiempoSolicitudEnvio` datetime NULL DEFAULT NULL,
  `OvvTiempoAprobacion1Envio` datetime NULL DEFAULT NULL,
  `OvvTiempoAprobacion2Envio` datetime NULL DEFAULT NULL,
  `OvvTiempoEmitido` datetime NULL DEFAULT NULL,
  `OvvTiempoAnulado` datetime NULL DEFAULT NULL,
  `OvvTiempoPorFacturar` datetime NULL DEFAULT NULL,
  `OvvTiempoFacturado` datetime NULL DEFAULT NULL,
  `OvvEnvioAux` int(10) NULL DEFAULT NULL,
  `OvvTarjeta` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvActaEntregaFechaAux` date NULL DEFAULT NULL,
  `OvvGNV` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`OvvId`) USING BTREE,
  INDEX `FK_OVV_CVEID_idx`(`CveId`) USING BTREE,
  INDEX `FK_OVV_PERID_idx`(`PerId`) USING BTREE,
  INDEX `FK_OVV_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_OVV_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_OVV_VVEID_idx`(`VveId`) USING BTREE,
  INDEX `FK_OVV_MONID_idx`(`MonId`) USING BTREE,
  INDEX `IDX_OVVID`(`OvvId`) USING BTREE,
  CONSTRAINT `tblovvordenventavehiculo_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblovvordenventavehiculo_ibfk_2` FOREIGN KEY (`CveId`) REFERENCES `tblcvecotizacionvehiculo` (`CveId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblovvordenventavehiculo_ibfk_4` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblovvordenventavehiculo_ibfk_5` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblovvordenventavehiculo_ibfk_6` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpacpagocomprobante
-- ----------------------------
DROP TABLE IF EXISTS `tblpacpagocomprobante`;
CREATE TABLE `tblpacpagocomprobante`  (
  `PacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '0',
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FexId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FetId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PacEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PacTiempoCreacion` datetime NOT NULL,
  `PacTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PacId`) USING BTREE,
  INDEX `FK_PAC_PAGID_idx`(`PagId`) USING BTREE,
  INDEX `FK_PAC_OVVID_idx`(`OvvId`) USING BTREE,
  INDEX `FK_PAC_VDIID_idx`(`VdiId`) USING BTREE,
  CONSTRAINT `tblpacpagocomprobante_ibfk_1` FOREIGN KEY (`OvvId`) REFERENCES `tblovvordenventavehiculo` (`OvvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpacpagocomprobante_ibfk_2` FOREIGN KEY (`PagId`) REFERENCES `tblpagpago` (`PagId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblpacpagocomprobante_ibfk_3` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpagpago
-- ----------------------------
DROP TABLE IF EXISTS `tblpagpago`;
CREATE TABLE `tblpagpago`  (
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFecha` date NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BanId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TarId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PagObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PagObservacionCaja` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PagConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PagNumeroTransaccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFechaTransaccion` date NULL DEFAULT NULL,
  `PagNumeroRecibo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagCantidadLetras` int(1) NULL DEFAULT NULL,
  `PagReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagMonto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `PagTipo` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagUtilizado` tinyint(4) NULL DEFAULT NULL,
  `PagEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PagTiempoCreacion` datetime NOT NULL,
  `PagTiempoModificacion` datetime NOT NULL,
  `PagUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagCierre` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`PagId`) USING BTREE,
  INDEX `FK_PAG_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_PAG_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_PAG_AREID_idx`(`AreId`) USING BTREE,
  INDEX `FK_PAG_CUEID_idx`(`CueId`) USING BTREE,
  INDEX `FK_PAG_FPAID_idx`(`FpaId`) USING BTREE,
  INDEX `FK_PAG_TARID_idx`(`TarId`) USING BTREE,
  CONSTRAINT `tblpagpago_ibfk_1` FOREIGN KEY (`AreId`) REFERENCES `tblarearea` (`AreId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_ibfk_2` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_ibfk_3` FOREIGN KEY (`CueId`) REFERENCES `tblcuecuenta` (`CueId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_ibfk_4` FOREIGN KEY (`FpaId`) REFERENCES `tblfpaformapago` (`FpaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_ibfk_6` FOREIGN KEY (`TarId`) REFERENCES `tbltartarjeta` (`TarId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpagpago_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblpagpago_copy`;
CREATE TABLE `tblpagpago_copy`  (
  `PagId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFecha` date NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BanId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TarId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PagObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PagObservacionCaja` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PagConcepto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PagNumeroTransaccion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFechaTransaccion` date NULL DEFAULT NULL,
  `PagNumeroRecibo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagCantidadLetras` int(1) NULL DEFAULT NULL,
  `PagReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagMonto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `PagTipo` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFoto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagFoto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PagUtilizado` tinyint(4) NULL DEFAULT NULL,
  `PagEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PagTiempoCreacion` datetime NOT NULL,
  `PagTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PagId`) USING BTREE,
  INDEX `FK_PAG_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_PAG_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_PAG_AREID_idx`(`AreId`) USING BTREE,
  INDEX `FK_PAG_CUEID_idx`(`CueId`) USING BTREE,
  INDEX `FK_PAG_FPAID_idx`(`FpaId`) USING BTREE,
  INDEX `FK_PAG_TARID_idx`(`TarId`) USING BTREE,
  CONSTRAINT `tblpagpago_copy_ibfk_1` FOREIGN KEY (`AreId`) REFERENCES `tblarearea` (`AreId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_copy_ibfk_2` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_copy_ibfk_3` FOREIGN KEY (`CueId`) REFERENCES `tblcuecuenta` (`CueId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_copy_ibfk_4` FOREIGN KEY (`FpaId`) REFERENCES `tblfpaformapago` (`FpaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_copy_ibfk_5` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpagpago_copy_ibfk_6` FOREIGN KEY (`TarId`) REFERENCES `tbltartarjeta` (`TarId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpanproductoano
-- ----------------------------
DROP TABLE IF EXISTS `tblpanproductoano`;
CREATE TABLE `tblpanproductoano`  (
  `PanId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PanAno` mediumint(9) NOT NULL,
  `PanTiempoCreacion` datetime NOT NULL,
  `PanTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PanId`) USING BTREE,
  INDEX `FK_PAN_PROID_idx`(`ProId`) USING BTREE,
  CONSTRAINT `tblpanproductoano_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpcaproductocategoria
-- ----------------------------
DROP TABLE IF EXISTS `tblpcaproductocategoria`;
CREATE TABLE `tblpcaproductocategoria`  (
  `PcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcaNombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcaOrden` decimal(10, 2) NULL DEFAULT NULL,
  `PcaEstado` tinyint(1) NULL DEFAULT NULL,
  `PcaTiempoCreacion` datetime NOT NULL,
  `PcaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PcaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpcdpedidocompradetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblpcdpedidocompradetalle`;
CREATE TABLE `tblpcdpedidocompradetalle`  (
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdAno` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `PcdModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdCantidad` decimal(10, 3) NOT NULL,
  `PcdPrecio` decimal(10, 3) NOT NULL,
  `PcdImporte` decimal(10, 3) NOT NULL,
  `PcdObservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdBOTiempoCarga` datetime NULL DEFAULT NULL,
  `PcdBOFecha` date NULL DEFAULT NULL,
  `PcdVIN` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdOT` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdBOEstado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcdAPTiempoCarga` datetime NULL DEFAULT NULL,
  `PcdAPCantidad` decimal(10, 3) NULL DEFAULT NULL,
  `PcdBSTiempoCarga` datetime NULL DEFAULT NULL,
  `PcdBSCantidad` decimal(10, 3) NULL DEFAULT NULL,
  `PcdEstado` tinyint(1) NOT NULL,
  `PcdTiempoCreacion` datetime NOT NULL,
  `PcdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PcdId`) USING BTREE,
  INDEX `FK_PCD_PCOID_idx`(`PcoId`) USING BTREE,
  INDEX `FK_PCD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_PCD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_PCD_VDDID_idx`(`VddId`) USING BTREE,
  CONSTRAINT `tblpcdpedidocompradetalle_ibfk_1` FOREIGN KEY (`PcoId`) REFERENCES `tblpcopedidocompra` (`PcoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblpcdpedidocompradetalle_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpcdpedidocompradetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpcdpedidocompradetalle_ibfk_4` FOREIGN KEY (`VddId`) REFERENCES `tblvddventadirectadetalle` (`VddId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpcopedidocompra
-- ----------------------------
DROP TABLE IF EXISTS `tblpcopedidocompra`;
CREATE TABLE `tblpcopedidocompra`  (
  `PcoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OcoId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FccId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcoFecha` date NOT NULL,
  `PcoHora` time NULL DEFAULT NULL,
  `PcoTipoPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcoTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PcoIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 0,
  `PcoPorcentajeImpuestoVenta` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `PcoObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PcoObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PcoObservacionCorreo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PcoSolicitudAprobacionRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PcoSubTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PcoImpuesto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PcoTotal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PcoOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PcoAprobado` tinyint(1) NULL DEFAULT NULL,
  `PcoEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PcoTiempoCreacion` datetime NOT NULL,
  `PcoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PcoId`) USING BTREE,
  INDEX `FK_PCO_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_PCO_OCOID_idx`(`OcoId`) USING BTREE,
  INDEX `FK_PCO_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_PCO_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_PCO_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `tblpcopedidocompra_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpcopedidocompra_ibfk_2` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpcopedidocompra_ibfk_3` FOREIGN KEY (`OcoId`) REFERENCES `tblocoordencompra` (`OcoId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tblpcopedidocompra_ibfk_4` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpcopedidocompra_ibfk_5` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpcrproductocodigoreemplazo
-- ----------------------------
DROP TABLE IF EXISTS `tblpcrproductocodigoreemplazo`;
CREATE TABLE `tblpcrproductocodigoreemplazo`  (
  `PcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcrOrden` int(10) NULL DEFAULT NULL,
  `PcrNumero` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcrTiempoCreacion` datetime NOT NULL,
  `PcrTiempoModificacion` datetime NOT NULL,
  `PcrBase` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`PcrId`) USING BTREE,
  UNIQUE INDEX `UNQ_PCR_PROID_PCRNUMERO`(`ProId`, `PcrNumero`) USING BTREE,
  INDEX `FK_PCR_PROID_idx`(`ProId`) USING BTREE,
  CONSTRAINT `tblpcrproductocodigoreemplazo_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpdiproductodisponibilidad
-- ----------------------------
DROP TABLE IF EXISTS `tblpdiproductodisponibilidad`;
CREATE TABLE `tblpdiproductodisponibilidad`  (
  `PdiId` bigint(20) NOT NULL AUTO_INCREMENT,
  `PdiCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PdiNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PdiDisponible` tinyint(1) NOT NULL,
  `PdiCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PdiEstado` tinyint(1) NOT NULL,
  `PdiTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`PdiId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26412855 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblperpersonal
-- ----------------------------
DROP TABLE IF EXISTS `tblperpersonal`;
CREATE TABLE `tblperpersonal`  (
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TdoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerAbreviatura` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerNombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerApellidoPaterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerApellidoMaterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerNumeroDocumento` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerSexo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerEstadoCivil` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerCantidadHijo` mediumint(2) NULL DEFAULT NULL,
  `PerFechaNacimiento` date NULL DEFAULT NULL,
  `PerEmail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerTelefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerCelular` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerPais` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerCiudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerSueldo` decimal(8, 2) NOT NULL DEFAULT 0.00,
  `PerTaller` tinyint(1) NOT NULL DEFAULT 0,
  `PerAlmacen` tinyint(1) NULL DEFAULT NULL,
  `PerRecepcion` tinyint(1) NOT NULL DEFAULT 0,
  `PerVenta` tinyint(1) NOT NULL DEFAULT 0,
  `PerFirmante` tinyint(1) NULL DEFAULT NULL,
  `PerFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerFirma` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerEstado` tinyint(1) NOT NULL,
  `PerTiempoCreacion` datetime NOT NULL,
  `PerTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PerId`) USING BTREE,
  INDEX `FK_PER_PTIID_idx`(`PtiId`) USING BTREE,
  INDEX `FK_PER_TDOID_idx`(`TdoId`) USING BTREE,
  INDEX `FK_PER_AREID`(`AreId`) USING BTREE,
  INDEX `FK_PER_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblperpersonal_ibfk_1` FOREIGN KEY (`AreId`) REFERENCES `tblarearea` (`AreId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblperpersonal_ibfk_2` FOREIGN KEY (`PtiId`) REFERENCES `tblptipersonaltipo` (`PtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblperpersonal_ibfk_3` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblperpersonal_ibfk_4` FOREIGN KEY (`TdoId`) REFERENCES `tbltdotipodocumento` (`TdoId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpespreentregaseccion
-- ----------------------------
DROP TABLE IF EXISTS `tblpespreentregaseccion`;
CREATE TABLE `tblpespreentregaseccion`  (
  `PesId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PesNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PesOrden` decimal(10, 2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`PesId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpetpreentregatarea
-- ----------------------------
DROP TABLE IF EXISTS `tblpetpreentregatarea`;
CREATE TABLE `tblpetpreentregatarea`  (
  `PetId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PesId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PetNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PetOrden` decimal(10, 2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`PetId`) USING BTREE,
  INDEX `FK_PET_PESID_idx`(`PesId`) USING BTREE,
  CONSTRAINT `tblpetpreentregatarea_ibfk_1` FOREIGN KEY (`PesId`) REFERENCES `tblpespreentregaseccion` (`PesId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpfoproductofoto
-- ----------------------------
DROP TABLE IF EXISTS `tblpfoproductofoto`;
CREATE TABLE `tblpfoproductofoto`  (
  `PfoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PfoArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PfoTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PfoEstado` tinyint(1) NULL DEFAULT NULL,
  `PfoTiempoCreacion` datetime NOT NULL,
  `PfoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PfoId`) USING BTREE,
  INDEX `FK_PFO_PROID_idx`(`ProId`) USING BTREE,
  CONSTRAINT `tblpfoproductofoto_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpldpedidocomprallegadadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblpldpedidocomprallegadadetalle`;
CREATE TABLE `tblpldpedidocomprallegadadetalle`  (
  `PldId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PleId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PldOrdenCompraId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PldOrdenCompraFecha` date NULL DEFAULT NULL,
  `PldCantidad` decimal(10, 3) NOT NULL,
  `PldCantidadEntregada` decimal(10, 3) NULL DEFAULT NULL,
  `PldComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PldComprobanteFecha` date NULL DEFAULT NULL,
  `PldGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PldGuiaRemisionFecha` date NULL DEFAULT NULL,
  `PldObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PldImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `PldEstado` tinyint(1) NOT NULL,
  `PldTiempoCreacion` datetime NOT NULL,
  `PldTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PldId`) USING BTREE,
  INDEX `FK_PLD_PLEID_idx`(`PleId`) USING BTREE,
  INDEX `FK_PLD_PCDID_idx`(`PcdId`) USING BTREE,
  CONSTRAINT `tblpldpedidocomprallegadadetalle_ibfk_1` FOREIGN KEY (`PcdId`) REFERENCES `tblpcdpedidocompradetalle` (`PcdId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblpldpedidocomprallegadadetalle_ibfk_2` FOREIGN KEY (`PleId`) REFERENCES `tblplepedidocomprallegada` (`PleId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblplepedidocomprallegada
-- ----------------------------
DROP TABLE IF EXISTS `tblplepedidocomprallegada`;
CREATE TABLE `tblplepedidocomprallegada`  (
  `PleId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PleFecha` date NOT NULL,
  `PleObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PleEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PleTiempoCreacion` datetime NOT NULL,
  `PleTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PleId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblploproductolistapromocion
-- ----------------------------
DROP TABLE IF EXISTS `tblploproductolistapromocion`;
CREATE TABLE `tblploproductolistapromocion`  (
  `PloId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PloTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PloCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PloNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PloMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PloPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PloPrecioReal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PloEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PloTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`PloId`) USING BTREE,
  INDEX `FK_PLP_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tblploproductolistapromocion_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblplpproductolistaprecio
-- ----------------------------
DROP TABLE IF EXISTS `tblplpproductolistaprecio`;
CREATE TABLE `tblplpproductolistaprecio`  (
  `PlpId` bigint(20) NOT NULL AUTO_INCREMENT,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PlpTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PlpCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PlpNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PlpMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PlpPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PlpPrecioReal` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `PlpEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PlpTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`PlpId`) USING BTREE,
  INDEX `FK_PLP_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tblplpproductolistaprecio_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblplrproductopreciolista
-- ----------------------------
DROP TABLE IF EXISTS `tblplrproductopreciolista`;
CREATE TABLE `tblplrproductopreciolista`  (
  `PlrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PlrTipoCambio` decimal(10, 0) NULL DEFAULT NULL,
  `PlrPrecioReal` decimal(16, 6) NULL DEFAULT NULL,
  `PlrPrecio` decimal(16, 6) NULL DEFAULT NULL,
  `PlrEstado` tinyint(1) NULL DEFAULT NULL,
  `PlrTiempoCreacion` datetime NOT NULL,
  `PlrTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PlrId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpmaplanmantenimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblpmaplanmantenimiento`;
CREATE TABLE `tblpmaplanmantenimiento`  (
  `PmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmaNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmaDuracion` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PmaNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PmaEstado` tinyint(1) NOT NULL,
  `PmaTiempoCreacion` datetime NOT NULL,
  `PmaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PmaId`) USING BTREE,
  INDEX `FK_PMA_VVEID_idx`(`VveId`) USING BTREE,
  INDEX `FK_PMA_VMAID_idx`(`VmaId`) USING BTREE,
  INDEX `FK_PMA_VMOID_idx`(`VmoId`) USING BTREE,
  CONSTRAINT `tblpmaplanmantenimiento_ibfk_1` FOREIGN KEY (`VmaId`) REFERENCES `tblvmavehiculomarca` (`VmaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpmaplanmantenimiento_ibfk_2` FOREIGN KEY (`VmoId`) REFERENCES `tblvmovehiculomodelo` (`VmoId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblpmaplanmantenimiento_ibfk_3` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpmdplanmantenimientodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblpmdplanmantenimientodetalle`;
CREATE TABLE `tblpmdplanmantenimientodetalle`  (
  `PmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmdAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmdKilometraje` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`PmdId`) USING BTREE,
  INDEX `FK_PMD_PMAID_idx`(`PmaId`) USING BTREE,
  INDEX `FK_PMD_PMTID_idx`(`PmtId`) USING BTREE,
  CONSTRAINT `tblpmdplanmantenimientodetalle_ibfk_1` FOREIGN KEY (`PmaId`) REFERENCES `tblpmaplanmantenimiento` (`PmaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblpmdplanmantenimientodetalle_ibfk_2` FOREIGN KEY (`PmtId`) REFERENCES `tblpmtplanmantenimientotarea` (`PmtId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpmsplanmantenimientoseccion
-- ----------------------------
DROP TABLE IF EXISTS `tblpmsplanmantenimientoseccion`;
CREATE TABLE `tblpmsplanmantenimientoseccion`  (
  `PmsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmsNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmsOrden` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`PmsId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpmtplanmantenimientotarea
-- ----------------------------
DROP TABLE IF EXISTS `tblpmtplanmantenimientotarea`;
CREATE TABLE `tblpmtplanmantenimientotarea`  (
  `PmtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmtNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmtSeccion` tinyint(1) NOT NULL,
  `PmsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PmtOrden` decimal(10, 3) NULL DEFAULT NULL,
  PRIMARY KEY (`PmtId`) USING BTREE,
  INDEX `FK_PMT_PMSID_idx`(`PmsId`) USING BTREE,
  CONSTRAINT `tblpmtplanmantenimientotarea_ibfk_1` FOREIGN KEY (`PmsId`) REFERENCES `tblpmsplanmantenimientoseccion` (`PmsId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblppdproduccionproductodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblppdproduccionproductodetalle`;
CREATE TABLE `tblppdproduccionproductodetalle`  (
  `PpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PpdCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `PpdCantidadReal` decimal(16, 6) NULL DEFAULT NULL,
  `PpdCosto` decimal(16, 6) NULL DEFAULT NULL,
  `PpdImporte` decimal(16, 6) NULL DEFAULT NULL,
  `PpdTipo` tinyint(1) NULL DEFAULT NULL,
  `PpdEstado` tinyint(1) NULL DEFAULT NULL,
  `PpdTiempoCreacion` datetime NOT NULL,
  `PpdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PpdId`) USING BTREE,
  INDEX `FK_PPD_PPRID_idx`(`PprId`) USING BTREE,
  INDEX `FK_PPD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_PPD_UMEID_idx`(`UmeId`) USING BTREE,
  CONSTRAINT `tblppdproduccionproductodetalle_ibfk_1` FOREIGN KEY (`PprId`) REFERENCES `tblpprproduccionproducto` (`PprId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tblppdproduccionproductodetalle_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblppdproduccionproductodetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpprpagoproveedor
-- ----------------------------
DROP TABLE IF EXISTS `tblpprpagoproveedor`;
CREATE TABLE `tblpprpagoproveedor`  (
  `PprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PprFecha` date NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PprTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PprReferenciaFecha` date NULL DEFAULT NULL,
  `PprReferenciaNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprMonto` decimal(16, 6) NULL DEFAULT NULL,
  `PprMontoReal` decimal(16, 6) NULL DEFAULT NULL,
  `PprObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PprObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PprEstado` tinyint(1) NULL DEFAULT NULL,
  `PprTiempoCreacion` datetime NULL DEFAULT NULL,
  `PprTiempoModificacion` datetime NULL DEFAULT NULL,
  `PprUsuarioCreo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PprUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`PprId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpreproductoreemplazo
-- ----------------------------
DROP TABLE IF EXISTS `tblpreproductoreemplazo`;
CREATE TABLE `tblpreproductoreemplazo`  (
  `PreId` bigint(20) NOT NULL AUTO_INCREMENT,
  `PreCodigo1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PreCodigo2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PreCodigo3` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PreCodigo4` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo5` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo6` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo7` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo8` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo9` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo10` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo11` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreCodigo12` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PreEstado` tinyint(1) NOT NULL DEFAULT 0,
  `PreTiempoCreacion` datetime NOT NULL,
  PRIMARY KEY (`PreId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 424603 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpriprivilegio
-- ----------------------------
DROP TABLE IF EXISTS `tblpriprivilegio`;
CREATE TABLE `tblpriprivilegio`  (
  `PriId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PriNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PriAlias` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`PriId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblprlpredictivoventasllamada
-- ----------------------------
DROP TABLE IF EXISTS `tblprlpredictivoventasllamada`;
CREATE TABLE `tblprlpredictivoventasllamada`  (
  `PrlId` int(11) NOT NULL AUTO_INCREMENT,
  `EinVIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrlRespuesta` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrlEstado` int(1) NULL DEFAULT NULL,
  `PrlFecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PrlId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblproproducto
-- ----------------------------
DROP TABLE IF EXISTS `tblproproducto`;
CREATE TABLE `tblproproducto`  (
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProNombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProCodigoOriginal` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProCodigoAlternativo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProUbicacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeIdIngreso` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProStock` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProStockReal` decimal(16, 6) NOT NULL,
  `ProStockMinimo` decimal(10, 6) NOT NULL DEFAULT 0.000000,
  `ProStockIngresado` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProStockRealIngresado` decimal(10, 6) NOT NULL,
  `ProDimension` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProMarca` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPeso` decimal(10, 6) NULL DEFAULT NULL,
  `ProLargo` decimal(10, 2) NULL DEFAULT NULL,
  `ProAncho` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProAlto` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProVolumen` decimal(10, 6) NULL DEFAULT NULL,
  `ProReferencia` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProPrecioMercado` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProCosto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProCostoIngreso` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProCostoIngresoNeto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProListaPrecioCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPromocionCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPrecioCosto` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPromocionCosto` decimal(16, 6) NULL DEFAULT NULL,
  `MonIdListaPrecio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdListaPromocion` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProCodigoBarra` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProValidarStock` tinyint(1) NOT NULL DEFAULT 1,
  `ProValidarUso` tinyint(1) NOT NULL DEFAULT 1,
  `ProFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `ProRevisadoFecha` date NULL DEFAULT NULL,
  `ProStockVerificado` tinyint(1) NULL DEFAULT 2,
  `ProRotacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPromedioDiario` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioMensual` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioTrimestral` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioSemestral` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioAnual` decimal(10, 2) NULL DEFAULT NULL,
  `ProFechaUltimaSalida` date NULL DEFAULT NULL,
  `ProFechaUltimaEntrada` date NULL DEFAULT NULL,
  `ProDiasInmovilizado` mediumint(4) NULL DEFAULT NULL,
  `ProProcedencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPorcentajeAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `ProPorcentajeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `ProCalcularPrecio` tinyint(1) NULL DEFAULT NULL,
  `ProDisponibilidadCantidadGM` decimal(10, 3) NULL DEFAULT NULL,
  `ProTieneDisponibilidadGM` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTieneReemplazoGM` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTipoPedidoUltimo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTienePromocion` tinyint(2) NULL DEFAULT NULL,
  `ProNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ProSalidaTotalAnual` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalTrimestral` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalSemestral` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalMensual` decimal(10, 3) NULL DEFAULT NULL,
  `ProABCInterno` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProDescontinuado` tinyint(1) NULL DEFAULT NULL,
  `ProCritico` tinyint(1) NULL DEFAULT NULL,
  `ProEstado` tinyint(1) NOT NULL,
  `ProMarcaReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTiempoCreacion` datetime NOT NULL,
  `ProTiempoModificacion` datetime NOT NULL,
  `ProAux` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProReemplazo` tinyint(1) NULL DEFAULT NULL,
  `ProFechaUltimaActividad` date NULL DEFAULT NULL,
  PRIMARY KEY (`ProId`) USING BTREE,
  UNIQUE INDEX `UNQ_PROCODIGOORIGINAL`(`ProCodigoOriginal`) USING BTREE,
  INDEX `FK_PRO_RTIID_idx`(`RtiId`) USING BTREE,
  INDEX `FK_PRO_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_PRO_UMEIDINGRESO_idx`(`UmeIdIngreso`) USING BTREE,
  INDEX `FK_PRO_MONID`(`MonId`) USING BTREE,
  CONSTRAINT `tblproproducto_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_ibfk_2` FOREIGN KEY (`RtiId`) REFERENCES `tblrtiproductotipo` (`RtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_ibfk_4` FOREIGN KEY (`UmeIdIngreso`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblproproducto_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblproproducto_copy`;
CREATE TABLE `tblproproducto_copy`  (
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProNombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProCodigoOriginal` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProCodigoAlternativo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProUbicacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeIdIngreso` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProStock` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProStockReal` decimal(16, 6) NOT NULL,
  `ProStockMinimo` decimal(10, 6) NOT NULL DEFAULT 0.000000,
  `ProStockIngresado` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProStockRealIngresado` decimal(10, 6) NOT NULL,
  `ProDimension` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProMarca` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPeso` decimal(10, 6) NULL DEFAULT NULL,
  `ProLargo` decimal(10, 2) NULL DEFAULT NULL,
  `ProAncho` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProAlto` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProVolumen` decimal(10, 6) NULL DEFAULT NULL,
  `ProReferencia` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProPrecioMercado` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProCosto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProCostoIngreso` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProCostoIngresoNeto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProListaPrecioCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPromocionCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPrecioCosto` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPromocionCosto` decimal(16, 6) NULL DEFAULT NULL,
  `MonIdListaPrecio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdListaPromocion` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProCodigoBarra` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProValidarStock` tinyint(1) NOT NULL DEFAULT 1,
  `ProValidarUso` tinyint(1) NOT NULL DEFAULT 1,
  `ProFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `ProRevisadoFecha` date NULL DEFAULT NULL,
  `ProStockVerificado` tinyint(1) NULL DEFAULT 2,
  `ProRotacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPromedioDiario` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioMensual` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioTrimestral` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioSemestral` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioAnual` decimal(10, 2) NULL DEFAULT NULL,
  `ProFechaUltimaSalida` date NULL DEFAULT NULL,
  `ProFechaUltimaEntrada` date NULL DEFAULT NULL,
  `ProDiasInmovilizado` mediumint(4) NULL DEFAULT NULL,
  `ProProcedencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPorcentajeAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `ProPorcentajeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `ProCalcularPrecio` tinyint(1) NULL DEFAULT NULL,
  `ProDisponibilidadCantidadGM` decimal(10, 3) NULL DEFAULT NULL,
  `ProTieneDisponibilidadGM` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTieneReemplazoGM` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTipoPedidoUltimo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTienePromocion` tinyint(2) NULL DEFAULT NULL,
  `ProNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ProSalidaTotalAnual` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalTrimestral` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalSemestral` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalMensual` decimal(10, 3) NULL DEFAULT NULL,
  `ProABCInterno` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProDescontinuado` tinyint(1) NULL DEFAULT NULL,
  `ProCritico` tinyint(1) NULL DEFAULT NULL,
  `ProEstado` tinyint(1) NOT NULL,
  `ProTiempoCreacion` datetime NOT NULL,
  `ProTiempoModificacion` datetime NOT NULL,
  `ProAux` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ProId`) USING BTREE,
  UNIQUE INDEX `UNQ_PROCODIGOORIGINAL`(`ProCodigoOriginal`) USING BTREE,
  INDEX `FK_PRO_RTIID_idx`(`RtiId`) USING BTREE,
  INDEX `FK_PRO_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_PRO_UMEIDINGRESO_idx`(`UmeIdIngreso`) USING BTREE,
  INDEX `FK_PRO_MONID`(`MonId`) USING BTREE,
  CONSTRAINT `tblproproducto_copy_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_copy_ibfk_2` FOREIGN KEY (`RtiId`) REFERENCES `tblrtiproductotipo` (`RtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_copy_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_copy_ibfk_4` FOREIGN KEY (`UmeIdIngreso`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblproproducto_copy1
-- ----------------------------
DROP TABLE IF EXISTS `tblproproducto_copy1`;
CREATE TABLE `tblproproducto_copy1`  (
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProNombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProCodigoOriginal` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProCodigoAlternativo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProUbicacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeIdIngreso` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProStock` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProStockReal` decimal(16, 6) NOT NULL,
  `ProStockMinimo` decimal(10, 6) NOT NULL DEFAULT 0.000000,
  `ProStockIngresado` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProStockRealIngresado` decimal(10, 6) NOT NULL,
  `ProDimension` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProMarca` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPeso` decimal(10, 6) NULL DEFAULT NULL,
  `ProLargo` decimal(10, 2) NULL DEFAULT NULL,
  `ProAncho` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProAlto` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProVolumen` decimal(10, 6) NULL DEFAULT NULL,
  `ProReferencia` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProPrecioMercado` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `ProCosto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProCostoIngreso` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProCostoIngresoNeto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `ProListaPrecioCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPromocionCostoReal` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPrecioCosto` decimal(16, 6) NULL DEFAULT NULL,
  `ProListaPromocionCosto` decimal(16, 6) NULL DEFAULT NULL,
  `MonIdListaPrecio` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonIdListaPromocion` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProCodigoBarra` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProValidarStock` tinyint(1) NOT NULL DEFAULT 1,
  `ProValidarUso` tinyint(1) NOT NULL DEFAULT 1,
  `ProFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProRevisado` tinyint(1) NOT NULL DEFAULT 0,
  `ProRevisadoFecha` date NULL DEFAULT NULL,
  `ProStockVerificado` tinyint(1) NULL DEFAULT 2,
  `ProRotacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPromedioDiario` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioMensual` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioTrimestral` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioSemestral` decimal(10, 2) NULL DEFAULT NULL,
  `ProPromedioAnual` decimal(10, 2) NULL DEFAULT NULL,
  `ProFechaUltimaSalida` date NULL DEFAULT NULL,
  `ProFechaUltimaEntrada` date NULL DEFAULT NULL,
  `ProDiasInmovilizado` mediumint(4) NULL DEFAULT NULL,
  `ProProcedencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `LtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProPorcentajeAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `ProPorcentajeDescuento` decimal(16, 6) NULL DEFAULT NULL,
  `ProCalcularPrecio` tinyint(1) NULL DEFAULT NULL,
  `ProDisponibilidadCantidadGM` decimal(10, 3) NULL DEFAULT NULL,
  `ProTieneDisponibilidadGM` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTieneReemplazoGM` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTipoPedidoUltimo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTienePromocion` tinyint(2) NULL DEFAULT NULL,
  `ProNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ProSalidaTotalAnual` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalTrimestral` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalSemestral` decimal(10, 3) NULL DEFAULT NULL,
  `ProSalidaTotalMensual` decimal(10, 3) NULL DEFAULT NULL,
  `ProABCInterno` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProDescontinuado` tinyint(1) NULL DEFAULT NULL,
  `ProCritico` tinyint(1) NULL DEFAULT NULL,
  `ProEstado` tinyint(1) NOT NULL,
  `ProMarcaReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProTiempoCreacion` datetime NOT NULL,
  `ProTiempoModificacion` datetime NOT NULL,
  `ProAux` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ProId`) USING BTREE,
  UNIQUE INDEX `UNQ_PROCODIGOORIGINAL`(`ProCodigoOriginal`) USING BTREE,
  INDEX `FK_PRO_RTIID_idx`(`RtiId`) USING BTREE,
  INDEX `FK_PRO_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_PRO_UMEIDINGRESO_idx`(`UmeIdIngreso`) USING BTREE,
  INDEX `FK_PRO_MONID`(`MonId`) USING BTREE,
  CONSTRAINT `tblproproducto_copy1_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_copy1_ibfk_2` FOREIGN KEY (`RtiId`) REFERENCES `tblrtiproductotipo` (`RtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_copy1_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblproproducto_copy1_ibfk_4` FOREIGN KEY (`UmeIdIngreso`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblprplpredictivopostventallamada
-- ----------------------------
DROP TABLE IF EXISTS `tblprplpredictivopostventallamada`;
CREATE TABLE `tblprplpredictivopostventallamada`  (
  `PrplId` int(11) NOT NULL AUTO_INCREMENT,
  `EinVIN` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrplRespuesta` varchar(550) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrplEstado` int(1) NULL DEFAULT NULL,
  `PrplFecha` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`PrplId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblprppredictivopostventa
-- ----------------------------
DROP TABLE IF EXISTS `tblprppredictivopostventa`;
CREATE TABLE `tblprppredictivopostventa`  (
  `PrpId` int(11) NOT NULL AUTO_INCREMENT,
  `EinVIN` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrpKilometraje` int(12) NULL DEFAULT NULL,
  `PrpFecha` date NULL DEFAULT NULL,
  `PrpFechaPredecida` date NULL DEFAULT NULL,
  `PrpUltimoPlanMant` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrpComentarios` varchar(550) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrpEstado` int(1) NULL DEFAULT NULL,
  `PrpFechaDesistimiento` date NULL DEFAULT NULL,
  `PrpMotivoDesistimiento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrpComentariosDesistimiento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrpFechaManual` date NULL DEFAULT NULL,
  PRIMARY KEY (`PrpId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2479 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblprupruebas
-- ----------------------------
DROP TABLE IF EXISTS `tblprupruebas`;
CREATE TABLE `tblprupruebas`  (
  `PruId` int(11) NOT NULL AUTO_INCREMENT,
  `PruNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PruEdad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PruCiudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`PruId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblprvpredictivoventas
-- ----------------------------
DROP TABLE IF EXISTS `tblprvpredictivoventas`;
CREATE TABLE `tblprvpredictivoventas`  (
  `PrvId` int(11) NOT NULL AUTO_INCREMENT,
  `EinVIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvKilometraje` int(255) NULL DEFAULT NULL,
  `PrvFecha` date NULL DEFAULT NULL,
  `PrvComentarios` varchar(550) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvEstado` int(1) NULL DEFAULT NULL,
  `PrvFechaDesistimiento` date NULL DEFAULT NULL,
  PRIMARY KEY (`PrvId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblprvproveedor
-- ----------------------------
DROP TABLE IF EXISTS `tblprvproveedor`;
CREATE TABLE `tblprvproveedor`  (
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TdoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvTipoDocumentoOtro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvNombreCompleto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PrvNombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PrvApellidoPaterno` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvApellidoMaterno` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvNumeroDocumento` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvNumeroDocumento1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvNumeroDocumento2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvDireccion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvDistrito` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvProvincia` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvDepartamento` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvPais` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvTelefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvCelular` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvEmail` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvFechaNacimiento` date NULL DEFAULT NULL,
  `PrvContactoNombre1` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoCelular1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoEmail1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoNombre2` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoCelular2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoEmail2` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoNombre3` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoCelular3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvContactoEmail3` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvUso` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvTipoCambioFecha` date NULL DEFAULT NULL,
  `PrvTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PrvLineaCredito` decimal(10, 3) NULL DEFAULT NULL,
  `PrvLineaCreditoActual` decimal(10, 3) NULL DEFAULT NULL,
  `PrvLineaCreditoActiva` tinyint(1) NULL DEFAULT NULL,
  `PrvCalcularCosto` tinyint(1) NULL DEFAULT NULL,
  `PrvLimiteRequiereAprovacion` decimal(16, 6) NULL DEFAULT NULL,
  `PrvEstado` tinyint(1) NOT NULL,
  `PrvTiempoCreacion` datetime NOT NULL,
  `PrvTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PrvId`) USING BTREE,
  INDEX `FK_PRV_TDOID_idx`(`TdoId`) USING BTREE,
  CONSTRAINT `tblprvproveedor_ibfk_1` FOREIGN KEY (`TdoId`) REFERENCES `tbltdotipodocumento` (`TdoId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblptipersonaltipo
-- ----------------------------
DROP TABLE IF EXISTS `tblptipersonaltipo`;
CREATE TABLE `tblptipersonaltipo`  (
  `PtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PtiNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PtiDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PtiEstado` tinyint(1) NOT NULL,
  `PtiTiempoCreacion` datetime NOT NULL,
  `PtiTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PtiId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblptuproductotipounidadmedida
-- ----------------------------
DROP TABLE IF EXISTS `tblptuproductotipounidadmedida`;
CREATE TABLE `tblptuproductotipounidadmedida`  (
  `PtuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PtuTipo` tinyint(1) NOT NULL,
  PRIMARY KEY (`PtuId`) USING BTREE,
  INDEX `FK_PTU_RTIID_idx`(`RtiId`) USING BTREE,
  INDEX `FK_PTU_UMEID_idx`(`UmeId`) USING BTREE,
  CONSTRAINT `tblptuproductotipounidadmedida_ibfk_1` FOREIGN KEY (`RtiId`) REFERENCES `tblrtiproductotipo` (`RtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblptuproductotipounidadmedida_ibfk_2` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpvdpagovehiculoingresodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblpvdpagovehiculoingresodetalle`;
CREATE TABLE `tblpvdpagovehiculoingresodetalle`  (
  `PvdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PviId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PvdCosto` decimal(16, 6) NOT NULL,
  `PvdCantidad` decimal(10, 3) NOT NULL,
  `PvdImporte` decimal(16, 6) NOT NULL,
  `PvdObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PvdEstado` tinyint(1) NOT NULL,
  `PvdTiempoCreacion` datetime NOT NULL,
  `PvdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PvdId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpvipagovehiculoingreso
-- ----------------------------
DROP TABLE IF EXISTS `tblpvipagovehiculoingreso`;
CREATE TABLE `tblpvipagovehiculoingreso`  (
  `PviId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BanId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PviFecha` date NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PviTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `PviTipoCambioComercial` double(10, 3) NULL DEFAULT NULL,
  `PviIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `PviPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `PviNumeroBloque` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PviComprobanteFecha` date NULL DEFAULT NULL,
  `PviComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PviObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `PviSubTotal` decimal(16, 6) NULL DEFAULT NULL,
  `PviImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `PviTotal` decimal(16, 6) NULL DEFAULT NULL,
  `PviTotalBruto` decimal(16, 6) NULL DEFAULT NULL,
  `PviFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PviEstado` tinyint(1) NULL DEFAULT NULL,
  `PviTiempoCreacion` datetime NULL DEFAULT NULL,
  `PviTiempoModificacion` datetime NULL DEFAULT NULL,
  `PviUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PviUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`PviId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblpvvproductovehiculoversion
-- ----------------------------
DROP TABLE IF EXISTS `tblpvvproductovehiculoversion`;
CREATE TABLE `tblpvvproductovehiculoversion`  (
  `PvvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PvvTiempoCreacion` datetime NOT NULL,
  `PvvTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`PvvId`) USING BTREE,
  INDEX `FK_PVE_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_PVE_VVEID_idx`(`VveId`) USING BTREE,
  CONSTRAINT `tblpvvproductovehiculoversion_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblpvvproductovehiculoversion_ibfk_2` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrbaresumenbaja
-- ----------------------------
DROP TABLE IF EXISTS `tblrbaresumenbaja`;
CREATE TABLE `tblrbaresumenbaja`  (
  `RbaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RbaNumeracion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RbaFecha` date NOT NULL,
  `RbaLineas` mediumint(10) NOT NULL,
  `RbaTiempoCreacion` datetime NULL DEFAULT NULL,
  `RbaTiempoModificacion` datetime NULL DEFAULT NULL,
  `FacId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RbaArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RbaEstado` tinyint(1) NULL DEFAULT NULL,
  `RbaSunatRespuestaResumenTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RbaSunatRespuestaResumenFecha` date NULL DEFAULT NULL,
  `RbaSunatRespuestaResumenHora` time NULL DEFAULT NULL,
  `RbaSunatRespuestaResumenCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RbaSunatRespuestaResumenContenido` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `RbaSunatRespuestaResumenTiempoCreacion` datetime NULL DEFAULT NULL,
  `RbaSunatRespuestaObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `RbaSunatRespuestaTicket` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RbaSunatRespuestaTicketEstado` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdbId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`RbaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrcdreportecosdiario
-- ----------------------------
DROP TABLE IF EXISTS `tblrcdreportecosdiario`;
CREATE TABLE `tblrcdreportecosdiario`  (
  `RcdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RcdMes` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RcdAno` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RcdDia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RcdNumeroCitas` int(10) NULL DEFAULT NULL,
  `RcdClientesParticulares` int(10) NULL DEFAULT NULL,
  `RcdClientesFlotas` int(10) NULL DEFAULT NULL,
  `RcdPromedioPermanencia` decimal(10, 2) NULL DEFAULT NULL,
  `RcdParalizados` double(10, 2) NULL DEFAULT NULL,
  `RcdPersonalMecanicos` int(10) NULL DEFAULT NULL,
  `RcdPersonalAsesores` int(10) NULL DEFAULT NULL,
  `RcdPersonalOtros` int(10) NULL DEFAULT NULL,
  `RcdDiasLaborados` int(100) NOT NULL,
  `RcdHoraDisponibles` decimal(10, 2) NULL DEFAULT NULL,
  `RcdHoraLaboradas` decimal(10, 2) NULL DEFAULT NULL,
  `RcdTarifaMO` decimal(10, 2) NULL DEFAULT NULL,
  `RcdHoraMOVendidas` decimal(10, 2) NULL DEFAULT NULL,
  `RcdVentaManoObra` decimal(10, 2) NULL DEFAULT NULL,
  `RcdVentaRepuestos` decimal(10, 2) NULL DEFAULT NULL,
  `RcdTicketPromedio` decimal(10, 2) NULL DEFAULT NULL,
  `RcdVentaGarantiaFA` decimal(10, 2) NULL DEFAULT NULL,
  `RcdTiempoCreacion` datetime NULL DEFAULT NULL,
  `RcdTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`RcdId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrcoreportecos
-- ----------------------------
DROP TABLE IF EXISTS `tblrcoreportecos`;
CREATE TABLE `tblrcoreportecos`  (
  `RcoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RcoMes` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RcoAno` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RcoNumeroCitas` int(10) NULL DEFAULT NULL,
  `RcoCitasEfectivas` int(10) NULL DEFAULT NULL,
  `RcoClientesParticulares` int(10) NULL DEFAULT NULL,
  `RcoClientesFlotas` int(10) NULL DEFAULT NULL,
  `RcoPromedioPermanencia` decimal(10, 2) NULL DEFAULT NULL,
  `RcoParalizados` double(10, 2) NULL DEFAULT NULL,
  `RcoPersonalMecanicos` int(10) NULL DEFAULT NULL,
  `RcoPersonalAsesores` int(10) NULL DEFAULT NULL,
  `RcoPersonalOtros` int(10) NULL DEFAULT NULL,
  `RcoDiasLaborados` int(100) NOT NULL,
  `RcoHoraDisponibles` decimal(10, 2) NULL DEFAULT NULL,
  `RcoHoraLaboradas` decimal(10, 2) NULL DEFAULT NULL,
  `RcoTarifaMO` decimal(10, 2) NULL DEFAULT NULL,
  `RcoHoraMOVendidas` decimal(10, 2) NULL DEFAULT NULL,
  `RcoVentaManoObra` decimal(10, 2) NULL DEFAULT NULL,
  `RcoVentaRepuestos` decimal(10, 2) NULL DEFAULT NULL,
  `RcoTicketPromedio` decimal(10, 2) NULL DEFAULT NULL,
  `RcoVentaMecanica` decimal(16, 2) NULL DEFAULT NULL,
  `RcoVentaGarantiaFA` decimal(10, 2) NULL DEFAULT NULL,
  `RcoIngresoSparkLite` int(10) NULL DEFAULT NULL,
  `RcoIngresoSparkGT` int(10) NULL DEFAULT NULL,
  `RcoIngresoN300MoveMax` int(10) NULL DEFAULT NULL,
  `RcoIngresoN300Work` int(10) NULL DEFAULT NULL,
  `RcoIngresoCorsaChevyTaxi` int(10) NULL DEFAULT NULL,
  `RcoIngresoSail` int(10) NULL DEFAULT NULL,
  `RcoIngresoOnix` int(10) NULL DEFAULT NULL,
  `RcoIngresoPrisma` int(10) NULL DEFAULT NULL,
  `RcoIngresoNuevoSail` int(10) NULL DEFAULT NULL,
  `RcoIngresoAveo` int(10) NULL DEFAULT NULL,
  `RcoIngresoOptra` int(10) NULL DEFAULT NULL,
  `RcoIngresoSonic` int(10) NULL DEFAULT NULL,
  `RcoIngresoCruze` int(10) NULL DEFAULT NULL,
  `RcoIngresoSpin` int(10) NULL DEFAULT NULL,
  `RcoIngresoTracker` int(10) NULL DEFAULT NULL,
  `RcoIngresoVivant` int(10) NULL DEFAULT NULL,
  `RcoIngresoOrlando` int(10) NULL DEFAULT NULL,
  `RcoIngresoCaptiva` int(10) NULL DEFAULT NULL,
  `RcoIngresoS10` int(10) NULL DEFAULT NULL,
  `RcoIngresoTrailblazer` int(10) NULL DEFAULT NULL,
  `RcoIngresoTraverse` int(10) NULL DEFAULT NULL,
  `RcoIngresoTahoeSuburban` int(10) NULL DEFAULT NULL,
  `RcoIngresoNLR3TON` int(10) NULL DEFAULT NULL,
  `RcoIngresoREWARD400DT` int(10) NULL DEFAULT NULL,
  `RcoIngresoREWARD400NMR` int(10) NULL DEFAULT NULL,
  `RcoIngresoNPR4TON` int(10) NULL DEFAULT NULL,
  `RcoIngresoREWARD500` int(10) NULL DEFAULT NULL,
  `RcoIngresoFTR10TON` int(10) NULL DEFAULT NULL,
  `RcoIngresoFORWARD800` int(10) NULL DEFAULT NULL,
  `RcoIngresoFORWARD1300` int(10) NULL DEFAULT NULL,
  `RcoIngresoFORWARD2000` int(10) NULL DEFAULT NULL,
  `RcoIngresoOtrasUnidades` int(10) NULL DEFAULT NULL,
  `RcoTotalIngresosUnidadesMantenimiento` int(10) NULL DEFAULT NULL,
  `RcoTotalIngresosUnidades` int(10) NULL DEFAULT NULL,
  `RcoIngresoPrimeraRevision` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio1000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio1500` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio5000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio10000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio15000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio20000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio25000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio30000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio35000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio40000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio45000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio50000` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicio50000Mas` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioReparaciones` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioPlanchadoPintado` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioTrabajoInterno` int(10) NULL DEFAULT NULL,
  `RcoIngreseServicioGarantias` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioInstalacionAccesorios` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioInstalacionGLP` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioSuperCambio99` int(10) NULL DEFAULT NULL,
  `RcoIngresoServicioReingresos` int(10) NULL DEFAULT NULL,
  `RcoEstado` tinyint(1) NULL DEFAULT NULL,
  `RcoTiempoCreacion` datetime NULL DEFAULT NULL,
  `RcoTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`RcoId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrcrreportecor
-- ----------------------------
DROP TABLE IF EXISTS `tblrcrreportecor`;
CREATE TABLE `tblrcrreportecor`  (
  `RcrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RcrMes` int(2) NULL DEFAULT NULL,
  `RcrAno` int(4) NULL DEFAULT NULL,
  `RcrVentaTallerMarca` decimal(10, 2) NULL DEFAULT NULL,
  `RcrVentaPPMarca` decimal(10, 2) NOT NULL,
  `RcrVentaMesonMarca` decimal(10, 2) NOT NULL,
  `RcrVentaRatailMarca` decimal(10, 2) NULL DEFAULT NULL,
  `RcrVentaRetailLubricantes` decimal(10, 2) NULL DEFAULT NULL,
  `RcrTotalVentasRetail` decimal(10, 2) NULL DEFAULT NULL,
  `RcrMargenAporte` decimal(10, 2) NULL DEFAULT NULL,
  `RcrStockMarca` decimal(10, 2) NULL DEFAULT NULL,
  `RcrStockLubricantes` decimal(10, 2) NULL DEFAULT NULL,
  `RcrTotalStock` decimal(10, 2) NULL DEFAULT NULL,
  `RcrValorRepuestosA` decimal(10, 2) NULL DEFAULT NULL,
  `RcrValorRepuestosB` decimal(10, 2) NOT NULL,
  `RcrValorRepuestosC` decimal(10, 2) NULL DEFAULT NULL,
  `RcrValorRepuestosD` decimal(10, 2) NULL DEFAULT NULL,
  `RcrRotationMarca` decimal(10, 2) NULL DEFAULT NULL,
  `RcrValorPreObsoletos` decimal(10, 2) NULL DEFAULT NULL,
  `RcrValorObsoletos` decimal(10, 2) NULL DEFAULT NULL,
  `RcrPedidosYSTK` int(10) NULL DEFAULT NULL,
  `RcrPedidosYRUSH` int(10) NULL DEFAULT NULL,
  `RcrPedidosZVOR` int(10) NULL DEFAULT NULL,
  `RcrPedidosZGAR` int(10) NULL DEFAULT NULL,
  `RcrTasaServicioTaller` decimal(10, 2) NULL DEFAULT NULL,
  `RcrMontoVentaPedidas` decimal(10, 2) NULL DEFAULT NULL,
  `RcrPersonalAsesorRepuestos` int(10) NULL DEFAULT NULL,
  `RcrPersonalAsistenteAlmacen` int(10) NULL DEFAULT NULL,
  `RcrDiasLaborados` int(10) NULL DEFAULT NULL,
  `RcrHorasDisponibles` decimal(10, 2) NULL DEFAULT NULL,
  `RcrTiempoCreacion` datetime NULL DEFAULT NULL,
  `RcrTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`RcrId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrdereclamodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblrdereclamodetalle`;
CREATE TABLE `tblrdereclamodetalle`  (
  `RdeId` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RecId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RdeObservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RdeCantidad` decimal(10, 3) NOT NULL,
  `RdePrecioUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `RdeMonto` decimal(16, 6) NOT NULL,
  `RdeEstado` tinyint(1) NOT NULL DEFAULT 0,
  `RdeTiempoCreacion` datetime NOT NULL,
  `RdeTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`RdeId`) USING BTREE,
  INDEX `FK_RDE_RECID_idx`(`RecId`) USING BTREE,
  INDEX `FK_RDE_AMDID_idx`(`AmdId`) USING BTREE,
  CONSTRAINT `tblrdereclamodetalle_ibfk_1` FOREIGN KEY (`AmdId`) REFERENCES `tblamdalmacenmovimientodetalle` (`AmdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblrdereclamodetalle_ibfk_2` FOREIGN KEY (`RecId`) REFERENCES `tblrecreclamo` (`RecId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblredpreentregadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblredpreentregadetalle`;
CREATE TABLE `tblredpreentregadetalle`  (
  `RedId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PetId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RedAccion` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RedTiempoCreacion` datetime NOT NULL,
  `RedTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`RedId`) USING BTREE,
  INDEX `FK_RED_PETID_idx`(`PetId`) USING BTREE,
  INDEX `FK_RED_FINID_idx`(`FinId`) USING BTREE,
  CONSTRAINT `tblredpreentregadetalle_ibfk_1` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblredpreentregadetalle_ibfk_2` FOREIGN KEY (`PetId`) REFERENCES `tblpetpreentregatarea` (`PetId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblregregimen
-- ----------------------------
DROP TABLE IF EXISTS `tblregregimen`;
CREATE TABLE `tblregregimen`  (
  `RegId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RegNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RegDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `RegPorcentaje` decimal(8, 2) NOT NULL,
  `RegUso` tinyint(1) NOT NULL,
  `RegAplicacion` tinyint(1) NOT NULL,
  PRIMARY KEY (`RegId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrolrol
-- ----------------------------
DROP TABLE IF EXISTS `tblrolrol`;
CREATE TABLE `tblrolrol`  (
  `RolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RolNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RolTiempoCreacion` datetime NOT NULL,
  `RolTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`RolId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrolroles
-- ----------------------------
DROP TABLE IF EXISTS `tblrolroles`;
CREATE TABLE `tblrolroles`  (
  `RolId` int(11) NOT NULL AUTO_INCREMENT,
  `UsuId` int(11) NULL DEFAULT NULL,
  `ModId` int(11) NULL DEFAULT NULL,
  `RolEstado` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`RolId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 163 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrtiproductotipo
-- ----------------------------
DROP TABLE IF EXISTS `tblrtiproductotipo`;
CREATE TABLE `tblrtiproductotipo`  (
  `RtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RtiNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RtiEstado` tinyint(1) NOT NULL,
  `RtiTiempoCreacion` datetime NOT NULL,
  `RtiTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`RtiId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblrzprolzonaprivilegio
-- ----------------------------
DROP TABLE IF EXISTS `tblrzprolzonaprivilegio`;
CREATE TABLE `tblrzprolzonaprivilegio`  (
  `RzpId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`RzpId`) USING BTREE,
  UNIQUE INDEX `UNQ_RZP_ROLID_ZPRID`(`RolId`, `ZprId`) USING BTREE,
  INDEX `FK_RZP_ROLID_idx`(`RolId`) USING BTREE,
  INDEX `FK_RZP_ZPRID_idx`(`ZprId`) USING BTREE,
  CONSTRAINT `tblrzprolzonaprivilegio_ibfk_1` FOREIGN KEY (`RolId`) REFERENCES `tblrolrol` (`RolId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblrzprolzonaprivilegio_ibfk_2` FOREIGN KEY (`ZprId`) REFERENCES `tblzprzonaprivilegio` (`ZprId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblscasunatcatalogo
-- ----------------------------
DROP TABLE IF EXISTS `tblscasunatcatalogo`;
CREATE TABLE `tblscasunatcatalogo`  (
  `ScaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ScaTipo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ScaCodigo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ScaNombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `ScaTiempoCreacion` datetime NOT NULL,
  `ScaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`ScaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsddsolicituddesembolsodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblsddsolicituddesembolsodetalle`;
CREATE TABLE `tblsddsolicituddesembolsodetalle`  (
  `SddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SdsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SddDescripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SddCantidad` decimal(10, 3) NULL DEFAULT 0.000,
  `SddImporte` decimal(10, 3) NULL DEFAULT 0.000,
  `SddEstado` tinyint(1) NOT NULL DEFAULT 0,
  `SddTiempoCreacion` datetime NOT NULL,
  `SddTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`SddId`) USING BTREE,
  INDEX `FK_SDD_SREID`(`SreId`) USING BTREE,
  INDEX `FK_SDD_SDSID`(`SdsId`) USING BTREE,
  CONSTRAINT `tblsddsolicituddesembolsodetalle_ibfk_1` FOREIGN KEY (`SdsId`) REFERENCES `tblsdssolicituddesembolso` (`SdsId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblsddsolicituddesembolsodetalle_ibfk_2` FOREIGN KEY (`SreId`) REFERENCES `tblsreserviciorepuesto` (`SreId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsdeserviciodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblsdeserviciodetalle`;
CREATE TABLE `tblsdeserviciodetalle`  (
  `SdeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdeCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `SdeImporte` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `SdeEstado` tinyint(1) NOT NULL DEFAULT 0,
  `SdeTiempoCreacion` datetime NOT NULL,
  `SdeTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`SdeId`) USING BTREE,
  INDEX `FK_VDT_VDIID_idx`(`SerId`) USING BTREE,
  INDEX `FK_SDE_PROID`(`ProId`) USING BTREE,
  INDEX `FK_SDE_UMEID`(`UmeId`) USING BTREE,
  CONSTRAINT `tblsdeserviciodetalle_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblsdeserviciodetalle_ibfk_2` FOREIGN KEY (`SerId`) REFERENCES `tblserservicio` (`SerId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblsdeserviciodetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsdrsucursaldatoreporte
-- ----------------------------
DROP TABLE IF EXISTS `tblsdrsucursaldatoreporte`;
CREATE TABLE `tblsdrsucursaldatoreporte`  (
  `SdrId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrFecha` date NULL DEFAULT NULL,
  `SdrPersonalAsesoresServicio` int(10) NOT NULL,
  `SdrPersonalTecnicos` int(10) NOT NULL,
  `SdrPersonalOtros` int(10) NULL DEFAULT NULL,
  `SdrPersonalAsesorRepuestos` int(10) NULL DEFAULT NULL,
  `SdrPersonalAsistenteAlmacen` int(10) NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrTarifaManoObra` decimal(16, 6) NULL DEFAULT NULL,
  `SdrTipoLocal` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrInicioOperacion` date NULL DEFAULT NULL,
  `SdrAreaTotalAlmacen` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrPuestoMantenimiento` int(10) NULL DEFAULT NULL,
  `SdrElevadoresDisponibles` int(10) NULL DEFAULT NULL,
  `SdrPuestosReparacion` int(10) NULL DEFAULT NULL,
  `SdrPuestosLavadoSecado` int(10) NULL DEFAULT NULL,
  `SdrEstacionamientoClientes` int(10) NULL DEFAULT NULL,
  `SdrEstacionamientosInternos` int(10) NULL DEFAULT NULL,
  `SdrPersonalGestorArea` int(10) NULL DEFAULT NULL,
  `SdrPersonalAsesorServicio` int(10) NULL DEFAULT NULL,
  `SdrPersonalAsistenteAdministrativo` int(10) NULL DEFAULT NULL,
  `SdrPersonalOperacionesOtro` int(10) NULL DEFAULT NULL,
  `SdrPersonalJefeTaller` int(10) NULL DEFAULT NULL,
  `SdrPersonalTecnico` int(10) NULL DEFAULT NULL,
  `SdrPersonalTecnicoOtro` int(10) NULL DEFAULT NULL,
  `SdrNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrDistrito` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrCargo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdrEstado` tinyint(1) NULL DEFAULT NULL,
  `SdrTiempoCreacion` datetime NULL DEFAULT NULL,
  `SdrTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`SdrId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsdssolicituddesembolso
-- ----------------------------
DROP TABLE IF EXISTS `tblsdssolicituddesembolso`;
CREATE TABLE `tblsdssolicituddesembolso`  (
  `SdsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsFecha` date NULL DEFAULT NULL,
  `SdsAsunto` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SdsObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SdsObservacionInterna` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsObservacionImpresa` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsObservacionCorreo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SdsCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsVIN` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsAprobado` tinyint(1) NULL DEFAULT NULL,
  `SdsSolicitudAprobacionRespuesta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `AreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TgaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `SdsGastoAsumido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SdsDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SdsMonto` decimal(16, 6) NULL DEFAULT NULL,
  `SdsEstado` tinyint(1) NOT NULL,
  `SdsTiempoCreacion` datetime NOT NULL,
  `SdsTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`SdsId`) USING BTREE,
  INDEX `FK_SDS_PERID`(`PerId`) USING BTREE,
  INDEX `FK_SDS_EINID`(`EinId`) USING BTREE,
  INDEX `FK_SDS_FINID`(`FinId`) USING BTREE,
  INDEX `FK_SDS_MONID`(`MonId`) USING BTREE,
  INDEX `FK_SDS_TGAID`(`TgaId`) USING BTREE,
  CONSTRAINT `tblsdssolicituddesembolso_ibfk_1` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblsdssolicituddesembolso_ibfk_2` FOREIGN KEY (`FinId`) REFERENCES `tblfinfichaingreso` (`FinId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblsdssolicituddesembolso_ibfk_3` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblsdssolicituddesembolso_ibfk_4` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblsdssolicituddesembolso_ibfk_5` FOREIGN KEY (`TgaId`) REFERENCES `tbltgatipogasto` (`TgaId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsreserviciorepuesto
-- ----------------------------
DROP TABLE IF EXISTS `tblsreserviciorepuesto`;
CREATE TABLE `tblsreserviciorepuesto`  (
  `SreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TgaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SreNombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SreDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SreOrden` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `SreEstado` tinyint(1) NOT NULL,
  `SreTiempoCreacion` datetime NOT NULL,
  `SreTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`SreId`) USING BTREE,
  INDEX `FK_SRE_TGAID`(`TgaId`) USING BTREE,
  CONSTRAINT `tblsreserviciorepuesto_ibfk_1` FOREIGN KEY (`TgaId`) REFERENCES `tbltgatipogasto` (`TgaId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsucsucursal
-- ----------------------------
DROP TABLE IF EXISTS `tblsucsucursal`;
CREATE TABLE `tblsucsucursal`  (
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucEtiqueta` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucSiglas` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCotizacionVehiculoCuentas` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucCiudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucInventarioFechaInicio` date NULL DEFAULT NULL,
  `SucUso` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucOrden` decimal(10, 1) NULL DEFAULT NULL,
  `SucEstado` tinyint(1) NOT NULL DEFAULT 0,
  `SucTiempoCreacion` datetime NOT NULL,
  `SucTiempoModificacion` datetime NOT NULL,
  `SucPersonalAsesoresServicio` int(10) NULL DEFAULT NULL,
  `SucPersonalTecnicos` int(10) NULL DEFAULT NULL,
  `SucPersonalOtros` int(10) NULL DEFAULT NULL,
  `VmaId` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId2` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCodigoAnexo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`SucId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsucsucursal_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblsucsucursal_copy`;
CREATE TABLE `tblsucsucursal_copy`  (
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucEtiqueta` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucSiglas` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCotizacionVehiculoCuentas` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucCiudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucInventarioFechaInicio` date NULL DEFAULT NULL,
  `SucUso` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucOrden` decimal(10, 1) NULL DEFAULT NULL,
  `SucEstado` tinyint(1) NOT NULL DEFAULT 0,
  `SucTiempoCreacion` datetime NOT NULL,
  `SucTiempoModificacion` datetime NOT NULL,
  `SucPersonalAsesoresServicio` int(10) NULL DEFAULT NULL,
  `SucPersonalTecnicos` int(10) NULL DEFAULT NULL,
  `SucPersonalOtros` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`SucId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsucsucursal_copy1
-- ----------------------------
DROP TABLE IF EXISTS `tblsucsucursal_copy1`;
CREATE TABLE `tblsucsucursal_copy1`  (
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucEtiqueta` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucSiglas` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCotizacionVehiculoCuentas` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucCiudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucInventarioFechaInicio` date NULL DEFAULT NULL,
  `SucUso` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucOrden` decimal(10, 1) NULL DEFAULT NULL,
  `SucEstado` tinyint(1) NOT NULL DEFAULT 0,
  `SucTiempoCreacion` datetime NOT NULL,
  `SucTiempoModificacion` datetime NOT NULL,
  `SucPersonalAsesoresServicio` int(10) NULL DEFAULT NULL,
  `SucPersonalTecnicos` int(10) NULL DEFAULT NULL,
  `SucPersonalOtros` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`SucId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsucsucursal_copy2
-- ----------------------------
DROP TABLE IF EXISTS `tblsucsucursal_copy2`;
CREATE TABLE `tblsucsucursal_copy2`  (
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucEtiqueta` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucSiglas` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCodigoUbigeo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucCotizacionVehiculoCuentas` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SucCiudad` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucInventarioFechaInicio` date NULL DEFAULT NULL,
  `SucUso` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucOrden` decimal(10, 1) NULL DEFAULT NULL,
  `SucEstado` tinyint(1) NOT NULL DEFAULT 0,
  `SucTiempoCreacion` datetime NOT NULL,
  `SucTiempoModificacion` datetime NOT NULL,
  `SucPersonalAsesoresServicio` int(10) NULL DEFAULT NULL,
  `SucPersonalTecnicos` int(10) NULL DEFAULT NULL,
  `SucPersonalOtros` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`SucId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblsvesucursalvehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblsvesucursalvehiculo`;
CREATE TABLE `tblsvesucursalvehiculo`  (
  `SveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SveAno` int(4) NULL DEFAULT NULL,
  `SveStock` decimal(16, 6) NULL DEFAULT NULL,
  `SveStockIngresado` decimal(16, 6) NULL DEFAULT NULL,
  `SveObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SveObservacionInicial` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `SveFechaUltimaEntrada` date NULL DEFAULT NULL,
  `SveFechaUltimaSalida` date NULL DEFAULT NULL,
  `SveEstado` tinyint(1) NOT NULL,
  `SveTiempoCreacion` datetime NOT NULL,
  `SveTiempoModificacion` datetime NOT NULL,
  `SveStockRealIngresado` decimal(16, 6) NULL DEFAULT NULL,
  PRIMARY KEY (`SveId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltadtrasladoalmacendetalle
-- ----------------------------
DROP TABLE IF EXISTS `tbltadtrasladoalmacendetalle`;
CREATE TABLE `tbltadtrasladoalmacendetalle`  (
  `TadId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TalId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TadCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `TadCantidadReal` decimal(16, 6) NULL DEFAULT NULL,
  `TadCosto` decimal(16, 6) NULL DEFAULT NULL,
  `TadImporte` decimal(16, 6) NULL DEFAULT NULL,
  `TadEstado` tinyint(1) NULL DEFAULT NULL,
  `TadTiempoCreacion` datetime NOT NULL,
  `TadTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`TadId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltartarjeta
-- ----------------------------
DROP TABLE IF EXISTS `tbltartarjeta`;
CREATE TABLE `tbltartarjeta`  (
  `TarId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TarNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TarDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `TarUso` tinyint(1) NOT NULL,
  `CueId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TarId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltcatipocambio
-- ----------------------------
DROP TABLE IF EXISTS `tbltcatipocambio`;
CREATE TABLE `tbltcatipocambio`  (
  `TcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TcaFecha` date NOT NULL,
  `TcaMontoCompra` decimal(10, 3) NOT NULL,
  `TcaMontoVenta` decimal(10, 3) NOT NULL,
  `TcaMontoComercial` decimal(10, 3) NULL DEFAULT NULL,
  `TcaTiempoCreacion` datetime NOT NULL,
  `TcaTiempoModificacion` datetime NOT NULL,
  `TcaUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TcaId`) USING BTREE,
  INDEX `FK_TCA_MONID_idx`(`MonId`) USING BTREE,
  CONSTRAINT `tbltcatipocambio_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltdotipodocumento
-- ----------------------------
DROP TABLE IF EXISTS `tbltdotipodocumento`;
CREATE TABLE `tbltdotipodocumento`  (
  `TdoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TdoCodigo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TdoNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TdoDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TdoUso` tinyint(1) NULL DEFAULT NULL,
  `TdoEstado` tinyint(1) NOT NULL,
  `TdoTiempoCreacion` datetime NOT NULL,
  `TdoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`TdoId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltgatipogasto
-- ----------------------------
DROP TABLE IF EXISTS `tbltgatipogasto`;
CREATE TABLE `tbltgatipogasto`  (
  `TgaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TgaNombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TgaDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TgaUso` tinyint(1) NULL DEFAULT NULL,
  `TgaEstado` tinyint(1) NOT NULL,
  `TgaTiempoCreacion` datetime NOT NULL,
  `TgaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`TgaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltoptipooperacion
-- ----------------------------
DROP TABLE IF EXISTS `tbltoptipooperacion`;
CREATE TABLE `tbltoptipooperacion`  (
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TopCodigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TopUso` tinyint(1) NOT NULL,
  PRIMARY KEY (`TopId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltpatipoarchivo
-- ----------------------------
DROP TABLE IF EXISTS `tbltpatipoarchivo`;
CREATE TABLE `tbltpatipoarchivo`  (
  `TpaId` int(11) NOT NULL,
  `TpaNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `TpaRutaImagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TpaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltpdtrasladoproductodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tbltpdtrasladoproductodetalle`;
CREATE TABLE `tbltpdtrasladoproductodetalle`  (
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TpdCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `TpdCantidadReal` decimal(16, 6) NULL DEFAULT NULL,
  `TpdCosto` decimal(16, 6) NULL DEFAULT NULL,
  `TpdImporte` decimal(16, 6) NULL DEFAULT NULL,
  `TpdEstado` tinyint(1) NULL DEFAULT NULL,
  `TpdTiempoCreacion` datetime NOT NULL,
  `TpdTiempoModificacion` datetime NOT NULL,
  `Aux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ProIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TpdId`) USING BTREE,
  INDEX `FK_TPD_TPTID`(`TptId`) USING BTREE,
  INDEX `FK_TPD_PROID`(`ProId`) USING BTREE,
  INDEX `FK_TPD_UMEID`(`UmeId`) USING BTREE,
  CONSTRAINT `tbltpdtrasladoproductodetalle_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpdtrasladoproductodetalle_ibfk_2` FOREIGN KEY (`TptId`) REFERENCES `tbltpttrasladoproducto` (`TptId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpdtrasladoproductodetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltpdtrasladoproductodetalle_copy
-- ----------------------------
DROP TABLE IF EXISTS `tbltpdtrasladoproductodetalle_copy`;
CREATE TABLE `tbltpdtrasladoproductodetalle_copy`  (
  `TpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TpdCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `TpdCantidadReal` decimal(16, 6) NULL DEFAULT NULL,
  `TpdCosto` decimal(16, 6) NULL DEFAULT NULL,
  `TpdImporte` decimal(16, 6) NULL DEFAULT NULL,
  `TpdEstado` tinyint(1) NULL DEFAULT NULL,
  `TpdTiempoCreacion` datetime NOT NULL,
  `TpdTiempoModificacion` datetime NOT NULL,
  `Aux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AuxId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TpdId`) USING BTREE,
  INDEX `FK_TPD_TPTID`(`TptId`) USING BTREE,
  INDEX `FK_TPD_PROID`(`ProId`) USING BTREE,
  INDEX `FK_TPD_UMEID`(`UmeId`) USING BTREE,
  CONSTRAINT `tbltpdtrasladoproductodetalle_copy_ibfk_1` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpdtrasladoproductodetalle_copy_ibfk_2` FOREIGN KEY (`TptId`) REFERENCES `tbltpttrasladoproducto` (`TptId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpdtrasladoproductodetalle_copy_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltprtareaproducto
-- ----------------------------
DROP TABLE IF EXISTS `tbltprtareaproducto`;
CREATE TABLE `tbltprtareaproducto`  (
  `TprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TprKilometraje` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PmtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TprCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `TprAno` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TprId`) USING BTREE,
  INDEX `FK_TPR_PMAID_idx`(`PmaId`) USING BTREE,
  INDEX `FK_TPR_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_TPR_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_TPR_PMTID_idx`(`PmtId`) USING BTREE,
  INDEX `FK_TPR_ALMID`(`AlmId`) USING BTREE,
  CONSTRAINT `tbltprtareaproducto_ibfk_1` FOREIGN KEY (`AlmId`) REFERENCES `tblalmalmacen` (`AlmId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltprtareaproducto_ibfk_2` FOREIGN KEY (`PmaId`) REFERENCES `tblpmaplanmantenimiento` (`PmaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbltprtareaproducto_ibfk_3` FOREIGN KEY (`PmtId`) REFERENCES `tblpmtplanmantenimientotarea` (`PmtId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltprtareaproducto_ibfk_4` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltprtareaproducto_ibfk_5` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltpttrasladoproducto
-- ----------------------------
DROP TABLE IF EXISTS `tbltpttrasladoproducto`;
CREATE TABLE `tbltpttrasladoproducto`  (
  `TptId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptReferencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptReferenciaFecha` date NULL DEFAULT NULL,
  `TptTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `TptFecha` date NOT NULL,
  `TptFechaLlegada` date NULL DEFAULT NULL,
  `TptObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `TptObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `TptPorcentajeImpuestoVenta` decimal(10, 2) NULL DEFAULT NULL,
  `TptIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `TptResponsable` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptCierre` tinyint(1) NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptEstado` tinyint(1) NOT NULL DEFAULT 0,
  `TptTiempoCreacion` datetime NOT NULL,
  `TptTiempoModificacion` datetime NOT NULL,
  `TptUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TptUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Aux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '',
  `IdAux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`TptId`) USING BTREE,
  INDEX `FK_TPT_CLIID`(`CliId`) USING BTREE,
  INDEX `FK_TPT_PRVID`(`PrvId`) USING BTREE,
  INDEX `FK_TPT_SUCID`(`SucId`) USING BTREE,
  INDEX `FK_TPT_SUCIDDESTINO`(`SucIdDestino`) USING BTREE,
  INDEX `FK_TPT_CTIID`(`CtiId`) USING BTREE,
  INDEX `FK_TPT_TOPID`(`TopId`) USING BTREE,
  INDEX `FK_TPT_MONID`(`MonId`) USING BTREE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_2` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_3` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_4` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_5` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_6` FOREIGN KEY (`SucIdDestino`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltpttrasladoproducto_ibfk_7` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltretiporeparacion
-- ----------------------------
DROP TABLE IF EXISTS `tbltretiporeparacion`;
CREATE TABLE `tbltretiporeparacion`  (
  `TreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TreNombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TreDescripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TreOrden` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `TreEstado` tinyint(1) NOT NULL,
  `TreTiempoCreacion` datetime NOT NULL,
  `TreTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`TreId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltrftiporeferido
-- ----------------------------
DROP TABLE IF EXISTS `tbltrftiporeferido`;
CREATE TABLE `tbltrftiporeferido`  (
  `TrfId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TrfNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TrfDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TrfEstado` tinyint(2) NULL DEFAULT NULL,
  `TrfTiempoCreacion` datetime NULL DEFAULT NULL,
  `TrfTiempoModificacion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`TrfId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltvdtrasladovehiculodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tbltvdtrasladovehiculodetalle`;
CREATE TABLE `tbltvdtrasladovehiculodetalle`  (
  `TvdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TvdDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `TvdCosto` decimal(16, 6) NULL DEFAULT NULL,
  `TvdCantidad` decimal(10, 3) NULL DEFAULT 0.000,
  `TvdImporte` decimal(16, 6) NULL DEFAULT NULL,
  `TvdObservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TvdEstado` tinyint(1) NOT NULL DEFAULT 0,
  `TvdTiempoCreacion` datetime NOT NULL,
  `TvdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`TvdId`) USING BTREE,
  INDEX `FK_TVD_TVEID`(`TveId`) USING BTREE,
  INDEX `FK_TVD_EINID`(`EinId`) USING BTREE,
  INDEX `FK_TVD_UMEID`(`UmeId`) USING BTREE,
  CONSTRAINT `tbltvdtrasladovehiculodetalle_ibfk_1` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvdtrasladovehiculodetalle_ibfk_2` FOREIGN KEY (`TveId`) REFERENCES `tbltvetrasladovehiculo` (`TveId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbltvdtrasladovehiculodetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbltvetrasladovehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tbltvetrasladovehiculo`;
CREATE TABLE `tbltvetrasladovehiculo`  (
  `TveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(29) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveComprobanteFecha` date NULL DEFAULT NULL,
  `TveFecha` date NULL DEFAULT NULL,
  `TveFechaLlegada` date NULL DEFAULT NULL,
  `TvePorcentajeImpuestoVenta` decimal(10, 2) NULL DEFAULT NULL,
  `TveObservacionInterna` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveObservacionImpresa` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveObservacionCorreo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `TveTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `TveIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `TveReferencia` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TveRevisado` tinyint(1) NULL DEFAULT NULL,
  `TveEstado` tinyint(1) NOT NULL,
  `TveTiempoCreacion` datetime NOT NULL,
  `TveTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`TveId`) USING BTREE,
  INDEX `FK_TVE_CTIID`(`CtiId`) USING BTREE,
  INDEX `FK_TVE_MONID`(`MonId`) USING BTREE,
  INDEX `FK_TVE_PERID`(`PerId`) USING BTREE,
  INDEX `FK_TVE_CLIID`(`CliId`) USING BTREE,
  INDEX `FK_TVE_PRVID`(`PrvId`) USING BTREE,
  INDEX `FK_TVE_SUCID`(`SucId`) USING BTREE,
  INDEX `FK_TVE_SUCIDDESTINO`(`SucIdDestino`) USING BTREE,
  INDEX `FK_TVE_TOPID`(`TopId`) USING BTREE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_2` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_3` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_4` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_5` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_6` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_7` FOREIGN KEY (`SucIdDestino`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tbltvetrasladovehiculo_ibfk_8` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblubiubigeo
-- ----------------------------
DROP TABLE IF EXISTS `tblubiubigeo`;
CREATE TABLE `tblubiubigeo`  (
  `UbiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UbiDepartamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UbiProvincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UbiDistrito` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UbiCodigo` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`UbiId`) USING BTREE,
  INDEX `FK_USU_ROLID_idx`(`UbiDepartamento`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblumcunidadmedidaconversion
-- ----------------------------
DROP TABLE IF EXISTS `tblumcunidadmedidaconversion`;
CREATE TABLE `tblumcunidadmedidaconversion`  (
  `UmcId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId1` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId2` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmcEquivalente` decimal(20, 7) NOT NULL,
  PRIMARY KEY (`UmcId`) USING BTREE,
  INDEX `FK_UMC_UMEID1_idx`(`UmeId1`) USING BTREE,
  INDEX `FK_UMC_UMEID2_idx`(`UmeId2`) USING BTREE,
  CONSTRAINT `tblumcunidadmedidaconversion_ibfk_1` FOREIGN KEY (`UmeId1`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tblumcunidadmedidaconversion_ibfk_2` FOREIGN KEY (`UmeId2`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblumeunidadmedida
-- ----------------------------
DROP TABLE IF EXISTS `tblumeunidadmedida`;
CREATE TABLE `tblumeunidadmedida`  (
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeAbreviacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeUso` tinyint(1) NOT NULL,
  `UmeCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UmeCodigoOtro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Aux` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`UmeId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblusuusuario
-- ----------------------------
DROP TABLE IF EXISTS `tblusuusuario`;
CREATE TABLE `tblusuusuario`  (
  `UsuId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `RolId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuUsuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuContrasena` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UsuFoto` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `UsuUltimaSesion` datetime NULL DEFAULT NULL,
  `UsuUltimaActividad` datetime NULL DEFAULT NULL,
  `UsuEstado` tinyint(1) NOT NULL,
  `UsuTiempoCreacion` datetime NOT NULL,
  `UsuTiempoModificacion` datetime NOT NULL,
  `UsuEliminado` tinyint(1) NOT NULL,
  `UsuApiToken` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`UsuId`) USING BTREE,
  UNIQUE INDEX `UNQ_USUUSUARIO`(`UsuUsuario`) USING BTREE,
  INDEX `FK_USU_ROLID_idx`(`RolId`) USING BTREE,
  CONSTRAINT `tblusuusuario_ibfk_1` FOREIGN KEY (`RolId`) REFERENCES `tblrolrol` (`RolId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblusuusuarios2
-- ----------------------------
DROP TABLE IF EXISTS `tblusuusuarios2`;
CREATE TABLE `tblusuusuarios2`  (
  `UsuId` int(11) NOT NULL AUTO_INCREMENT,
  `UsuNombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuApellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuCorreo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuContrasena` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuEstado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuPrimero` int(1) NULL DEFAULT NULL,
  `UsuToken` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuImagenPerfil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `UsuFechaNacimiento` date NULL DEFAULT NULL,
  `UsuImagenCumple` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`UsuId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 100 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvcsvehiculocaracteristicaseccion
-- ----------------------------
DROP TABLE IF EXISTS `tblvcsvehiculocaracteristicaseccion`;
CREATE TABLE `tblvcsvehiculocaracteristicaseccion`  (
  `VcsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VcsNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VcsEstado` tinyint(1) NOT NULL,
  `VcsTiempoCreacion` datetime NOT NULL,
  `VcsTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VcsId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvddventadirectadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblvddventadirectadetalle`;
CREATE TABLE `tblvddventadirectadetalle`  (
  `VddId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CrdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddCantidad` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddCantidadReal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddCosto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddUtilidad` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddValorTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddPrecioBruto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddImporteBruto` decimal(16, 6) NULL DEFAULT NULL,
  `VddDescuento` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddDescuentoUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `VddAdicional` decimal(16, 6) NULL DEFAULT NULL,
  `VddAdicionalUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `VddPrecioVenta` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddImporte` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VddCantidadConcretar` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VddCantidadPedir` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VddCantidadPedirFecha` date NULL DEFAULT NULL,
  `VddCodigoExterno` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddEntregado` tinyint(1) NULL DEFAULT NULL,
  `VddTipoPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VddNota` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VddAtendido` tinyint(1) NULL DEFAULT NULL,
  `VddPorcentajeUtilidad` decimal(10, 3) NULL DEFAULT 0.000,
  `VddPorcentajeOtroCosto` decimal(10, 3) NULL DEFAULT 0.000,
  `VddPorcentajeManoObra` decimal(10, 3) NULL DEFAULT 0.000,
  `VddPorcentajePedido` decimal(10, 3) NULL DEFAULT 0.000,
  `VddPorcentajeAdicional` decimal(10, 3) NULL DEFAULT 0.000,
  `VddPorcentajeDescuento` decimal(10, 3) NULL DEFAULT 0.000,
  `VddEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VddTiempoCreacion` datetime NOT NULL,
  `VddTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VddId`) USING BTREE,
  INDEX `FK_VDD_VDIID_idx`(`VdiId`) USING BTREE,
  INDEX `FK_VDD_PROID_idx`(`ProId`) USING BTREE,
  INDEX `FK_VDD_UMEID_idx`(`UmeId`) USING BTREE,
  INDEX `FK_VDD_CRDID_idx`(`CrdId`) USING BTREE,
  CONSTRAINT `tblvddventadirectadetalle_ibfk_1` FOREIGN KEY (`CrdId`) REFERENCES `tblcrdcotizacionproductodetalle` (`CrdId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvddventadirectadetalle_ibfk_2` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvddventadirectadetalle_ibfk_3` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvddventadirectadetalle_ibfk_4` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvdfventadirectafoto
-- ----------------------------
DROP TABLE IF EXISTS `tblvdfventadirectafoto`;
CREATE TABLE `tblvdfventadirectafoto`  (
  `VdfId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdiId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdfArchivo` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdfTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdfCodigoExterno` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdfEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VdfTiempoCreacion` datetime NOT NULL,
  `VdfTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VdfId`) USING BTREE,
  INDEX `FK_VDT_VDIID_idx`(`VdiId`) USING BTREE,
  CONSTRAINT `tblvdfventadirectafoto_ibfk_1` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvdiventadirecta
-- ----------------------------
DROP TABLE IF EXISTS `tblvdiventadirecta`;
CREATE TABLE `tblvdiventadirecta`  (
  `VdiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiFecha` date NULL DEFAULT NULL,
  `VdiDireccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiMarca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiModelo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiPlaca` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiAnoModelo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiAnoFabricacion` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiOrdenCompraNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiOrdenCompraFecha` date NULL DEFAULT NULL,
  `VdiTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `VdiIncluyeImpuesto` tinyint(1) NOT NULL DEFAULT 1,
  `VdiPorcentajeImpuestoVenta` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `VdiPorcentajeMargenUtilidad` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `VdiPorcentajeOtroCosto` decimal(10, 2) NULL DEFAULT NULL,
  `VdiPorcentajeManoObra` decimal(10, 2) NULL DEFAULT NULL,
  `VdiPorcentajeDescuento` decimal(10, 2) NULL DEFAULT NULL,
  `VdiObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VdiObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VdiResultado` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VdiManoObra` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiPlanchadoTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiPintadoTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiCentradoTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiTareaTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiDescuento` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiSubTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiImpuesto` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiTotal` decimal(16, 6) NOT NULL DEFAULT 0.000000,
  `VdiOrigen` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `VdiNotificar` tinyint(1) NOT NULL DEFAULT 2,
  `VdiArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiArchivoEntrega` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiArchivoEntrega2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiTipoPedido` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiCodigoExterno` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiObservado` tinyint(1) NULL DEFAULT 2,
  `VdiTipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiTipoFinal` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdiEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VdiTiempoCreacion` datetime NOT NULL,
  `VdiTiempoModificacion` datetime NOT NULL,
  `NpaIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VdiId`) USING BTREE,
  INDEX `FK_VDI_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_VDI_CPR_idx`(`CprId`) USING BTREE,
  INDEX `FK_VDI_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_VDI_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_VDI_TOPID_idx`(`TopId`) USING BTREE,
  INDEX `FK_VDI_NPAID_idx`(`NpaId`) USING BTREE,
  INDEX `FK_VDI_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `tblvdiventadirecta_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvdiventadirecta_ibfk_2` FOREIGN KEY (`CprId`) REFERENCES `tblcprcotizacionproducto` (`CprId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvdiventadirecta_ibfk_3` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvdiventadirecta_ibfk_4` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvdiventadirecta_ibfk_5` FOREIGN KEY (`NpaId`) REFERENCES `tblnpacondicionpago` (`NpaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvdiventadirecta_ibfk_6` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvdiventadirecta_ibfk_7` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvdtventadirectatarea
-- ----------------------------
DROP TABLE IF EXISTS `tblvdtventadirectatarea`;
CREATE TABLE `tblvdtventadirectatarea`  (
  `VdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdiId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdtDescripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VdtCantidad` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VdtPrecio` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VdtImporte` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VdtTipo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VdtEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VdtTiempoCreacion` datetime NOT NULL,
  `VdtTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VdtId`) USING BTREE,
  INDEX `FK_VDT_VDIID_idx`(`VdiId`) USING BTREE,
  CONSTRAINT `tblvdtventadirectatarea_ibfk_1` FOREIGN KEY (`VdiId`) REFERENCES `tblvdiventadirecta` (`VdiId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvehvehiculo
-- ----------------------------
DROP TABLE IF EXISTS `tblvehvehiculo`;
CREATE TABLE `tblvehvehiculo`  (
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehCodigoIdentificador` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehColor` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehInformacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VehEspecificacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehTransmision` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehEstado` tinyint(1) NOT NULL,
  `VehTiempoCreacion` datetime NOT NULL,
  `VehTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VehId`) USING BTREE,
  UNIQUE INDEX `UNQ_VEHCODIGOIDENTIFICADOR`(`VehCodigoIdentificador`) USING BTREE,
  INDEX `FK_VEH_VVEID_idx`(`VveId`) USING BTREE,
  CONSTRAINT `tblvehvehiculo_ibfk_1` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvibvehiculoingresobono
-- ----------------------------
DROP TABLE IF EXISTS `tblvibvehiculoingresobono`;
CREATE TABLE `tblvibvehiculoingresobono`  (
  `VibId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VibFecha` date NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VibTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `VibMonto` decimal(16, 6) NULL DEFAULT NULL,
  `VibMontoReal` decimal(16, 6) NULL DEFAULT NULL,
  `VibObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VibObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VibReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VibEstado` tinyint(1) NULL DEFAULT NULL,
  `VibTiempoCreacion` datetime NULL DEFAULT NULL,
  `VibTiempoModificacion` datetime NULL DEFAULT NULL,
  `VibUsuarioCreo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VibUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VibId`) USING BTREE,
  INDEX `FK_VIB_EINID`(`EinId`) USING BTREE,
  INDEX `FK_VIB_MONID`(`MonId`) USING BTREE,
  INDEX `FK_VIB_SUCID`(`SucId`) USING BTREE,
  INDEX `FK_VIB_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `FK_VIB_EINID` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIB_MONID` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIB_PERID` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIB_SUCID` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvicvehiculoingresocliente
-- ----------------------------
DROP TABLE IF EXISTS `tblvicvehiculoingresocliente`;
CREATE TABLE `tblvicvehiculoingresocliente`  (
  `VicId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VicFecha` date NULL DEFAULT NULL,
  `VicObservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VicEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VicTiempoCreacion` datetime NOT NULL,
  `VicTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VicId`) USING BTREE,
  INDEX `FK_VIC_CLIID_idx`(`CliId`) USING BTREE,
  INDEX `FK_VIC_EINID_idx`(`EinId`) USING BTREE,
  CONSTRAINT `tblvicvehiculoingresocliente_ibfk_1` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvicvehiculoingresocliente_ibfk_2` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvievehiculoingresoevento
-- ----------------------------
DROP TABLE IF EXISTS `tblvievehiculoingresoevento`;
CREATE TABLE `tblvievehiculoingresoevento`  (
  `VieId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VieFecha` date NULL DEFAULT NULL,
  `VieObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VieObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VieReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VieEstado` tinyint(1) NULL DEFAULT NULL,
  `VieTiempoCreacion` datetime NULL DEFAULT NULL,
  `VieTiempoModificacion` datetime NULL DEFAULT NULL,
  `VieUsuarioCreo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VieUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VieId`) USING BTREE,
  INDEX `FK_VIE_SUCID`(`SucId`) USING BTREE,
  INDEX `FK_VIE_EINID`(`EinId`) USING BTREE,
  INDEX `FK_VIE_PERID`(`PerId`) USING BTREE,
  CONSTRAINT `FK_VIE_EINID` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIE_PERID` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIE_SUCID` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvifvehiculoingresofoto
-- ----------------------------
DROP TABLE IF EXISTS `tblvifvehiculoingresofoto`;
CREATE TABLE `tblvifvehiculoingresofoto`  (
  `VifId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VifArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VifEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VifTiempoCreacion` datetime NOT NULL,
  `VifTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VifId`) USING BTREE,
  INDEX `FK_VIF_EINID_idx`(`EinId`) USING BTREE,
  CONSTRAINT `tblvifvehiculoingresofoto_ibfk_1` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvintemporal
-- ----------------------------
DROP TABLE IF EXISTS `tblvintemporal`;
CREATE TABLE `tblvintemporal`  (
  `EinVIN` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`EinVIN`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvipvehiculoingresopredictivo
-- ----------------------------
DROP TABLE IF EXISTS `tblvipvehiculoingresopredictivo`;
CREATE TABLE `tblvipvehiculoingresopredictivo`  (
  `VipId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VipReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VipFichaIngresoFechaPredecida` date NULL DEFAULT NULL,
  `VipFichaIngresoFechaUltimo` date NULL DEFAULT NULL,
  `VipFichaIngresoMantenimientoKilometrajeUltimo` decimal(16, 6) NULL DEFAULT NULL,
  `VipPromedioDiaMantenimiento` int(10) NULL DEFAULT NULL,
  `VipKilometrajeMantenimiento` decimal(16, 6) NULL DEFAULT NULL,
  `VipObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VipObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VipEstado` tinyint(1) NULL DEFAULT NULL,
  `VipTiempoCreacion` datetime NULL DEFAULT NULL,
  `VipTiempoModificacion` datetime NULL DEFAULT NULL,
  `VipUsuarioCreo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VipUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VipId`) USING BTREE,
  INDEX `FK_VIP_CLIID`(`CliId`) USING BTREE,
  INDEX `FK_VIP_EINID`(`EinId`) USING BTREE,
  INDEX `FK_VIP_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `FK_VIP_CLIID` FOREIGN KEY (`CliId`) REFERENCES `tblclicliente` (`CliId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIP_EINID` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VIP_SUCID` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvisvehiculoinstalar
-- ----------------------------
DROP TABLE IF EXISTS `tblvisvehiculoinstalar`;
CREATE TABLE `tblvisvehiculoinstalar`  (
  `VisId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VisFecha` date NULL DEFAULT NULL,
  `VisObservacionInterna` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VisObservacionImpresa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VisReferencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VisEstado` tinyint(1) NULL DEFAULT NULL,
  `VisTiempoCreacion` datetime NULL DEFAULT NULL,
  `VisTiempoModificacion` datetime NULL DEFAULT NULL,
  `VisUsuarioCreo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VisUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VisId`) USING BTREE,
  INDEX `FK_VIB_EINID`(`EinId`) USING BTREE,
  INDEX `FK_VIB_SUCID`(`SucId`) USING BTREE,
  CONSTRAINT `tblvisvehiculoinstalar_ibfk_1` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvisvehiculoinstalar_ibfk_3` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvldvehiculolistapreciodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblvldvehiculolistapreciodetalle`;
CREATE TABLE `tblvldvehiculolistapreciodetalle`  (
  `VldId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VlpId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VldFuente` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VldDescripcion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VldCosto` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VldPrecioCierre` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VldPrecioLista` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VldBonoGM` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VldBonoDealer` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VldDescuentoGerencia` decimal(10, 3) NOT NULL DEFAULT 0.000,
  `VldEstado` tinyint(1) NOT NULL,
  `VldTiempoCreacion` datetime NOT NULL,
  `VldTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VldId`) USING BTREE,
  INDEX `FK_VLD_VVEID_idx`(`VveId`) USING BTREE,
  INDEX `FL_VLD_VLPID_idx`(`VlpId`) USING BTREE,
  CONSTRAINT `tblvldvehiculolistapreciodetalle_ibfk_1` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvldvehiculolistapreciodetalle_ibfk_2` FOREIGN KEY (`VlpId`) REFERENCES `tblvlpvehiculolistaprecio` (`VlpId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvlpvehiculolistaprecio
-- ----------------------------
DROP TABLE IF EXISTS `tblvlpvehiculolistaprecio`;
CREATE TABLE `tblvlpvehiculolistaprecio`  (
  `VlpId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VlpAno` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VlpMes` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VlpAnoFabricacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VlpCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VlpNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VlpTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `VlpFecha` date NULL DEFAULT NULL,
  `VlpFechaVigencia` date NULL DEFAULT NULL,
  `VlpObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VlpEstado` tinyint(1) NOT NULL,
  `VlpTiempoCreacion` datetime NOT NULL,
  `VlpTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VlpId`) USING BTREE,
  INDEX `FK_VLP_MONID_idx`(`MonId`) USING BTREE,
  INDEX `FK_VLP_VMAID_idx`(`VmaId`) USING BTREE,
  CONSTRAINT `tblvlpvehiculolistaprecio_ibfk_1` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvlpvehiculolistaprecio_ibfk_2` FOREIGN KEY (`VmaId`) REFERENCES `tblvmavehiculomarca` (`VmaId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvmavehiculomarca
-- ----------------------------
DROP TABLE IF EXISTS `tblvmavehiculomarca`;
CREATE TABLE `tblvmavehiculomarca`  (
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmaNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmaNombreComercial` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaAbreviacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaFoto` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaPlantillaMSI` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaVigenciaVenta` tinyint(1) NOT NULL DEFAULT 0,
  `VmaOrden` decimal(10, 2) NULL DEFAULT NULL,
  `VmaEstado` tinyint(1) NOT NULL,
  `VmaTiempoCreacion` datetime NOT NULL,
  `VmaTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VmaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvmdvehiculomovimientodetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblvmdvehiculomovimientodetalle`;
CREATE TABLE `tblvmdvehiculomovimientodetalle`  (
  `VmdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TvdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VehId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdFecha` date NULL DEFAULT NULL,
  `VmdIdAnterior` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdValorTotal` decimal(16, 6) NULL DEFAULT NULL,
  `VmdCostoPromedio` decimal(16, 6) NULL DEFAULT NULL,
  `VmdCostoExtraUnitario` decimal(16, 6) NULL DEFAULT NULL,
  `VmdCostoExtraTotal` decimal(16, 6) NULL DEFAULT NULL,
  `VmdCostoAnterior` decimal(16, 6) NULL DEFAULT NULL,
  `VmdCostoIngreso` decimal(16, 6) NULL DEFAULT NULL,
  `VmdCosto` decimal(16, 6) NOT NULL,
  `VmdCantidad` decimal(10, 3) NOT NULL,
  `VmdImporte` decimal(16, 6) NOT NULL,
  `VmdUbicacion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VmdCaracteristica1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica4` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica5` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica6` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica7` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica8` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica9` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica10` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica11` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica12` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica13` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica14` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica15` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica16` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica17` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica18` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica19` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCaracteristica20` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmdCierre` tinyint(1) NULL DEFAULT NULL,
  `VmdEstado` tinyint(1) NOT NULL,
  `VmdTiempoCreacion` datetime NOT NULL,
  `VmdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VmdId`) USING BTREE,
  INDEX `FK_VMD_EINID`(`EinId`) USING BTREE,
  INDEX `FK_VMD_UMEID`(`UmeId`) USING BTREE,
  INDEX `FK_VMD_VMVID`(`VmvId`) USING BTREE,
  CONSTRAINT `tblvmdvehiculomovimientodetalle_ibfk_1` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmdvehiculomovimientodetalle_ibfk_2` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmdvehiculomovimientodetalle_ibfk_3` FOREIGN KEY (`VmvId`) REFERENCES `tblvmvvehiculomovimiento` (`VmvId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvmovehiculomodelo
-- ----------------------------
DROP TABLE IF EXISTS `tblvmovehiculomodelo`;
CREATE TABLE `tblvmovehiculomodelo`  (
  `VmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmoNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmoNombreComercial` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmoVigenciaVenta` tinyint(1) NOT NULL DEFAULT 0,
  `VmoFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmoFotoCaracteristica` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmoOrden` decimal(10, 2) NULL DEFAULT NULL,
  `VmoEstado` tinyint(1) NOT NULL,
  `VmoTiempoCreacion` datetime NOT NULL,
  `VmoTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VmoId`) USING BTREE,
  INDEX `FK_VMO_VMAID_idx`(`VmaId`) USING BTREE,
  INDEX `FK_VMO_VTIID_idx`(`VtiId`) USING BTREE,
  CONSTRAINT `tblvmovehiculomodelo_ibfk_1` FOREIGN KEY (`VmaId`) REFERENCES `tblvmavehiculomarca` (`VmaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmovehiculomodelo_ibfk_2` FOREIGN KEY (`VtiId`) REFERENCES `tblvtivehiculotipo` (`VtiId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvmvvehiculomovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tblvmvvehiculomovimiento`;
CREATE TABLE `tblvmvvehiculomovimiento`  (
  `VmvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `OvvId` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PrvId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CliId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NpaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TopId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCantidadDia` int(10) NULL DEFAULT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SucIdDestino` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `CtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `AlmId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvFecha` date NOT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `VmvTipoCambioComercial` double(10, 3) NULL DEFAULT NULL,
  `VmvIncluyeImpuesto` tinyint(1) NULL DEFAULT NULL,
  `VmvPorcentajeImpuestoVenta` decimal(10, 3) NULL DEFAULT NULL,
  `VmvComprobanteFecha` date NULL DEFAULT NULL,
  `VmvComprobanteNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvGuiaRemisionFecha` date NULL DEFAULT NULL,
  `VmvGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmvCierre` tinyint(1) NULL DEFAULT NULL,
  `VmvSubTotal` decimal(16, 6) NULL DEFAULT NULL,
  `VmvImpuesto` decimal(16, 6) NULL DEFAULT NULL,
  `VmvTotal` decimal(16, 6) NULL DEFAULT NULL,
  `VmvTotalBruto` decimal(16, 6) NULL DEFAULT NULL,
  `VmvCaracteristica1` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica2` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica3` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica4` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica5` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica6` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica7` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica8` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica9` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica10` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica11` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica12` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica13` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica14` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica15` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica16` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica17` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica18` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica19` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvCaracteristica20` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvGuiaRemisionFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VmvCancelado` tinyint(1) NULL DEFAULT NULL,
  `VmvRevisado` tinyint(1) NULL DEFAULT NULL,
  `VmvDocumentoOrigen` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvFacturable` tinyint(1) NULL DEFAULT NULL,
  `VmvTipo` tinyint(1) NULL DEFAULT NULL,
  `VmvSubTipo` tinyint(1) NULL DEFAULT NULL,
  `VmvEstado` tinyint(1) NULL DEFAULT NULL,
  `VmvTiempoCreacion` datetime NULL DEFAULT NULL,
  `VmvTiempoModificacion` datetime NULL DEFAULT NULL,
  `VmvUsuarioRegistro` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmvUsuarioModifico` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MigradoBaseImponible` decimal(16, 6) NULL DEFAULT NULL,
  `MigradoIGV` decimal(16, 6) NULL DEFAULT NULL,
  `NpaIdAux` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VmvId`) USING BTREE,
  INDEX `FK_VMV_SUCID`(`SucId`) USING BTREE,
  INDEX `FK_VMV_MONID`(`MonId`) USING BTREE,
  INDEX `FK_VMV_PRVID`(`PrvId`) USING BTREE,
  INDEX `FK_VMV_TOPID`(`TopId`) USING BTREE,
  INDEX `FK_VMV_CTIID`(`CtiId`) USING BTREE,
  INDEX `FK_VMV_NPAID`(`NpaId`) USING BTREE,
  INDEX `FK_VMV_SUCIDDESTINO`(`SucIdDestino`) USING BTREE,
  INDEX `FK_VMV_TVEID`(`TveId`) USING BTREE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_1` FOREIGN KEY (`CtiId`) REFERENCES `tblcticomprobantetipo` (`CtiId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_2` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_3` FOREIGN KEY (`NpaId`) REFERENCES `tblnpacondicionpago` (`NpaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_4` FOREIGN KEY (`PrvId`) REFERENCES `tblprvproveedor` (`PrvId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_5` FOREIGN KEY (`SucId`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_6` FOREIGN KEY (`SucIdDestino`) REFERENCES `tblsucsucursal` (`SucId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_7` FOREIGN KEY (`TopId`) REFERENCES `tbltoptipooperacion` (`TopId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvmvvehiculomovimiento_ibfk_8` FOREIGN KEY (`TveId`) REFERENCES `tbltvetrasladovehiculo` (`TveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvpdvehiculoproformadetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblvpdvehiculoproformadetalle`;
CREATE TABLE `tblvpdvehiculoproformadetalle`  (
  `VpdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VpdCosto` decimal(16, 6) NULL DEFAULT NULL,
  `VpdEstado` tinyint(1) NOT NULL,
  `VpdTiempoCreacion` datetime NOT NULL,
  `VpdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VpdId`) USING BTREE,
  INDEX `FK_VPD_VPRID_idx`(`VprId`) USING BTREE,
  INDEX `FK_VPD_EINID_idx`(`EinId`) USING BTREE,
  CONSTRAINT `FK_VPD_EINID` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VPD_VPRID` FOREIGN KEY (`VprId`) REFERENCES `tblvprvehiculoproforma` (`VprId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvprvehiculoproforma
-- ----------------------------
DROP TABLE IF EXISTS `tblvprvehiculoproforma`;
CREATE TABLE `tblvprvehiculoproforma`  (
  `VprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VprAno` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VprMes` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VmaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VprCodigo` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `MonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VprTipoCambio` decimal(10, 3) NULL DEFAULT NULL,
  `VprFecha` date NULL DEFAULT NULL,
  `VprObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VprTotal` decimal(16, 6) NULL DEFAULT NULL,
  `VprAdicional` tinyint(1) NULL DEFAULT 2,
  `VprEstado` tinyint(1) NOT NULL,
  `VprTiempoCreacion` datetime NOT NULL,
  `VprTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VprId`) USING BTREE,
  INDEX `FK_VPR_MONID_idx`(`MonId`) USING BTREE,
  INDEX `VmaId`(`VmaId`) USING BTREE,
  CONSTRAINT `tblvprvehiculoproforma_ibfk_1` FOREIGN KEY (`VmaId`) REFERENCES `tblvmavehiculomarca` (`VmaId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvprvehiculoproforma_ibfk_2` FOREIGN KEY (`MonId`) REFERENCES `tblmonmoneda` (`MonId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvrevehiculorecepcion
-- ----------------------------
DROP TABLE IF EXISTS `tblvrevehiculorecepcion`;
CREATE TABLE `tblvrevehiculorecepcion`  (
  `VreId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PerId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `EinId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VreFecha` date NOT NULL,
  `VreTieneGuia` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `VreGuiaRemisionNumero` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VreObservacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VreEstado` tinyint(1) NOT NULL,
  `VreTiempoCreacion` datetime NOT NULL,
  `VreTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VreId`) USING BTREE,
  INDEX `FK_VIR_EINID_idx`(`EinId`) USING BTREE,
  INDEX `FK_VIR_PERID_idx`(`PerId`) USING BTREE,
  CONSTRAINT `tblvrevehiculorecepcion_ibfk_1` FOREIGN KEY (`EinId`) REFERENCES `tbleinvehiculoingreso` (`EinId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvrevehiculorecepcion_ibfk_2` FOREIGN KEY (`PerId`) REFERENCES `tblperpersonal` (`PerId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvsdvehiculoinstalardetalle
-- ----------------------------
DROP TABLE IF EXISTS `tblvsdvehiculoinstalardetalle`;
CREATE TABLE `tblvsdvehiculoinstalardetalle`  (
  `VsdId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VisId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ProId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VsdCantidad` decimal(16, 6) NULL DEFAULT NULL,
  `UmeId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VsdObservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VsdEstado` tinyint(1) NOT NULL DEFAULT 0,
  `VsdTiempoCreacion` datetime NOT NULL,
  `VsdTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VsdId`) USING BTREE,
  INDEX `FK_VSD_PROID`(`ProId`) USING BTREE,
  INDEX `FK_VSD_UMEID`(`UmeId`) USING BTREE,
  INDEX `FK_VSD_VISID`(`VisId`) USING BTREE,
  CONSTRAINT `FK_VSD_PROID` FOREIGN KEY (`ProId`) REFERENCES `tblproproducto` (`ProId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VSD_UMEID` FOREIGN KEY (`UmeId`) REFERENCES `tblumeunidadmedida` (`UmeId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_VSD_VISID` FOREIGN KEY (`VisId`) REFERENCES `tblvisvehiculoinstalar` (`VisId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvtivehiculotipo
-- ----------------------------
DROP TABLE IF EXISTS `tblvtivehiculotipo`;
CREATE TABLE `tblvtivehiculotipo`  (
  `VtiId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VtiNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VtiEstado` tinyint(1) NOT NULL,
  `VtiTiempoCreacion` datetime NOT NULL,
  `VtiTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VtiId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvvcvehiculoversioncaracteristica
-- ----------------------------
DROP TABLE IF EXISTS `tblvvcvehiculoversioncaracteristica`;
CREATE TABLE `tblvvcvehiculoversioncaracteristica`  (
  `VvcId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VcsId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VvcAnoModelo` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VvcDescripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `VvcValor` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VvcTiempoCreacion` datetime NOT NULL,
  `VvcTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VvcId`) USING BTREE,
  INDEX `FK_VVC_VVEID_idx`(`VveId`) USING BTREE,
  INDEX `FK_VVC_VCSID_idx`(`VcsId`) USING BTREE,
  CONSTRAINT `tblvvcvehiculoversioncaracteristica_ibfk_1` FOREIGN KEY (`VcsId`) REFERENCES `tblvcsvehiculocaracteristicaseccion` (`VcsId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblvvcvehiculoversioncaracteristica_ibfk_2` FOREIGN KEY (`VveId`) REFERENCES `tblvvevehiculoversion` (`VveId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblvvevehiculoversion
-- ----------------------------
DROP TABLE IF EXISTS `tblvvevehiculoversion`;
CREATE TABLE `tblvvevehiculoversion`  (
  `VveId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VmoId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveNombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VveVigenciaVenta` tinyint(1) NOT NULL DEFAULT 0,
  `VveFoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveFotoLateral` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveFotoPosterior` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveFotoAdicional` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveFotoCaracteristica` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveArchivo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica3` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica4` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica5` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica6` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica7` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica8` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica9` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica10` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica11` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica12` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica13` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica14` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica15` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica18` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica19` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveCaracteristica20` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VveEstado` tinyint(1) NOT NULL,
  `VveTiempoCreacion` datetime NOT NULL,
  `VveTiempoModificacion` datetime NOT NULL,
  PRIMARY KEY (`VveId`) USING BTREE,
  INDEX `FK_VVE_VMOID_idx`(`VmoId`) USING BTREE,
  CONSTRAINT `tblvvevehiculoversion_ibfk_1` FOREIGN KEY (`VmoId`) REFERENCES `tblvmovehiculomodelo` (`VmoId`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblzcazonacategoria
-- ----------------------------
DROP TABLE IF EXISTS `tblzcazonacategoria`;
CREATE TABLE `tblzcazonacategoria`  (
  `ZcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZcaNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZcaAlias` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ZcaId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblzonzona
-- ----------------------------
DROP TABLE IF EXISTS `tblzonzona`;
CREATE TABLE `tblzonzona`  (
  `ZonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZcaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZonNombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZonAlias` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZonGrupo` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ZonId`) USING BTREE,
  INDEX `FK_ZON_ZCAID`(`ZcaId`) USING BTREE,
  CONSTRAINT `tblzonzona_ibfk_1` FOREIGN KEY (`ZcaId`) REFERENCES `tblzcazonacategoria` (`ZcaId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblzprzonaprivilegio
-- ----------------------------
DROP TABLE IF EXISTS `tblzprzonaprivilegio`;
CREATE TABLE `tblzprzonaprivilegio`  (
  `ZprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PriId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ZprId`) USING BTREE,
  INDEX `UNQ_ZONID_PRIID`(`ZonId`, `PriId`) USING BTREE,
  INDEX `FK_ZPR_ZONID_idx`(`ZonId`) USING BTREE,
  INDEX `FK_ZPR_PRIID_idx`(`PriId`) USING BTREE,
  CONSTRAINT `tblzprzonaprivilegio_ibfk_1` FOREIGN KEY (`PriId`) REFERENCES `tblpriprivilegio` (`PriId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblzprzonaprivilegio_ibfk_2` FOREIGN KEY (`ZonId`) REFERENCES `tblzonzona` (`ZonId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tblzprzonaprivilegio_copy
-- ----------------------------
DROP TABLE IF EXISTS `tblzprzonaprivilegio_copy`;
CREATE TABLE `tblzprzonaprivilegio_copy`  (
  `ZprId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ZonId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PriId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ZprId`) USING BTREE,
  INDEX `UNQ_ZONID_PRIID`(`ZonId`, `PriId`) USING BTREE,
  INDEX `FK_ZPR_ZONID_idx`(`ZonId`) USING BTREE,
  INDEX `FK_ZPR_PRIID_idx`(`PriId`) USING BTREE,
  CONSTRAINT `tblzprzonaprivilegio_copy_ibfk_1` FOREIGN KEY (`PriId`) REFERENCES `tblpriprivilegio` (`PriId`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tblzprzonaprivilegio_copy_ibfk_2` FOREIGN KEY (`ZonId`) REFERENCES `tblzonzona` (`ZonId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for traslados
-- ----------------------------
DROP TABLE IF EXISTS `traslados`;
CREATE TABLE `traslados`  (
  `id_traslado` int(11) NOT NULL AUTO_INCREMENT,
  `responsable_almacen1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `almacen_salida` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `almacen_entrada` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `responsable_almacen2` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fecha` datetime NULL DEFAULT NULL,
  `estado` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `id_tienda` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-',
  `id_tabla10` int(11) NOT NULL DEFAULT 1,
  `documento` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '-',
  `id_tabla12` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_traslado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4162 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for traslados_detalles
-- ----------------------------
DROP TABLE IF EXISTS `traslados_detalles`;
CREATE TABLE `traslados_detalles`  (
  `id_traslado_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_traslado` int(11) NULL DEFAULT NULL,
  `id_articulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cantidad` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ref` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `lote` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_traslado_detalle`) USING BTREE,
  INDEX `fk_traslados_detalles_articulos1_idx`(`id_articulo`) USING BTREE,
  INDEX `fk_traslados_detalles_traslados1_idx`(`id_traslado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11530 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vehiculospercy
-- ----------------------------
DROP TABLE IF EXISTS `vehiculospercy`;
CREATE TABLE `vehiculospercy`  (
  `VIN` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `Make` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ModelYear` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`VIN`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasabr19
-- ----------------------------
DROP TABLE IF EXISTS `ventasabr19`;
CREATE TABLE `ventasabr19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TIPO_DE_CAMBIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Nro Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasago19
-- ----------------------------
DROP TABLE IF EXISTS `ventasago19`;
CREATE TABLE `ventasago19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `T.C.` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `N° Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasfeb19
-- ----------------------------
DROP TABLE IF EXISTS `ventasfeb19`;
CREATE TABLE `ventasfeb19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TIPO_DE_CAMBIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `FtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `BtaId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NctId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NdtId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasju19
-- ----------------------------
DROP TABLE IF EXISTS `ventasju19`;
CREATE TABLE `ventasju19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `T.C.` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `N° Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasjun19
-- ----------------------------
DROP TABLE IF EXISTS `ventasjun19`;
CREATE TABLE `ventasjun19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TIPO_DE_CAMBIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `N° Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasmar19
-- ----------------------------
DROP TABLE IF EXISTS `ventasmar19`;
CREATE TABLE `ventasmar19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TIPO_DE_CAMBIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Nro Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasmay19
-- ----------------------------
DROP TABLE IF EXISTS `ventasmay19`;
CREATE TABLE `ventasmay19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `TIPO_DE_CAMBIO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `N° Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ventasset19
-- ----------------------------
DROP TABLE IF EXISTS `ventasset19`;
CREATE TABLE `ventasset19`  (
  `FECHA` date NULL DEFAULT NULL,
  `TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SERIE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `COMPROBANTE` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RUC` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `NOMBRE_RAZON_SOCIAL` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VALOR_DE_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `IGV` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `PRECIO_VENTA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `T.C.` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Fecha Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Tipo Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `Serie Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `N° Mod` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F16` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `F17` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- View structure for viscdicajadiaria
-- ----------------------------
DROP VIEW IF EXISTS `viscdicajadiaria`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `viscdicajadiaria` AS select `des`.`DesId` AS `CdiId`,`des`.`SucId` AS `SucId`,`des`.`PrvId` AS `PrvId`,`des`.`CliId` AS `CliId`,`des`.`PerId` AS `PerId`,`des`.`CueId` AS `CueId`,`des`.`DesFecha` AS `CdiFecha`,`des`.`MonId` AS `MonId`,`des`.`AreId` AS `AreId`,`des`.`DesTipoCambio` AS `CdiTipoCambio`,`des`.`DesObservacion` AS `CdiObservacion`,`des`.`DesObservacionImpresa` AS `CdiObservacionImpresa`,`des`.`DesConcepto` AS `CdiConcepto`,`des`.`DesNumeroCheque` AS `CdiNumeroCheque`,`des`.`DesReferencia` AS `CdiReferencia`,`des`.`DesMonto` AS `CdiMonto`,`des`.`DesTipo` AS `CdiTipo`,`des`.`DesFoto` AS `CdiFoto`,`des`.`DesTipoDestino` AS `CdiTipoDestino`,`des`.`DesEstado` AS `CdiEstado`,'Salida' AS `CdiTipoCajaDiaria`,`des`.`DesTiempoCreacion` AS `CdiTiempoCreacion`,`des`.`DesTiempoModificacion` AS `CdiTiempoModificacion`,`mon`.`MonNombre` AS `MonNombre`,`mon`.`MonSimbolo` AS `MonSimbolo`,`cue`.`CueNumero` AS `CueNumero`,`ban`.`BanNombre` AS `BanNombre`,`prv`.`PrvNombre` AS `PrvNombre`,`prv`.`PrvApellidoPaterno` AS `PrvApellidoPaterno`,`prv`.`PrvApellidoMaterno` AS `PrvApellidoMaterno`,`prv`.`PrvNumeroDocumento` AS `PrvNumeroDocumento`,`prv`.`TdoId` AS `TdoIdProveedor`,`tdo`.`TdoNombre` AS `TdoNombreProveedor`,`cli`.`CliNombre` AS `CliNombre`,`cli`.`CliApellidoPaterno` AS `CliApellidoPaterno`,`cli`.`CliApellidoMaterno` AS `CliApellidoMaterno`,`cli`.`CliNumeroDocumento` AS `CliNumeroDocumento`,`cli`.`TdoId` AS `TdoIdCliente`,`tdo2`.`TdoNombre` AS `TdoNombreCliente`,`per`.`PerNombre` AS `PerNombre`,`per`.`PerApellidoPaterno` AS `PerApellidoPaterno`,`per`.`PerApellidoMaterno` AS `PerApellidoMaterno`,`per`.`PerNumeroDocumento` AS `PerNumeroDocumento`,`per`.`TdoId` AS `TdoIdPersonal`,`tdo3`.`TdoNombre` AS `TdoNombrePersonal` from (((((((((`tbldesdesembolso` `des` left join `tblprvproveedor` `prv` on((`des`.`PrvId` = `prv`.`PrvId`))) left join `tbltdotipodocumento` `tdo` on((`prv`.`TdoId` = `tdo`.`TdoId`))) left join `tblclicliente` `cli` on((`des`.`CliId` = `cli`.`CliId`))) left join `tbltdotipodocumento` `tdo2` on((`cli`.`TdoId` = `tdo2`.`TdoId`))) left join `tblperpersonal` `per` on((`des`.`PerId` = `per`.`PerId`))) left join `tbltdotipodocumento` `tdo3` on((`per`.`TdoId` = `tdo3`.`TdoId`))) left join `tblcuecuenta` `cue` on((`des`.`CueId` = `cue`.`CueId`))) left join `tblbanbanco` `ban` on((`cue`.`BanId` = `ban`.`BanId`))) left join `tblmonmoneda` `mon` on((`des`.`MonId` = `mon`.`MonId`))) union all select `ing`.`IngId` AS `CdiId`,`ing`.`SucId` AS `SucId`,`ing`.`PrvId` AS `PrvId`,`ing`.`CliId` AS `CliId`,`ing`.`PerId` AS `PerId`,`ing`.`CueId` AS `CueId`,`ing`.`IngFecha` AS `CdiFecha`,`ing`.`MonId` AS `MonId`,`ing`.`AreId` AS `AreId`,`ing`.`IngTipoCambio` AS `CdiTipoCambio`,`ing`.`IngObservacion` AS `CdiObservacion`,`ing`.`IngObservacionImpresa` AS `CdiObservacionImpresa`,`ing`.`IngConcepto` AS `CdiConcepto`,`ing`.`IngNumeroCheque` AS `CdiNumeroCheque`,`ing`.`IngReferencia` AS `CdiReferencia`,`ing`.`IngMonto` AS `CdiMonto`,`ing`.`IngTipo` AS `CdiTipo`,`ing`.`IngFoto` AS `CdiFoto`,`ing`.`IngTipoDestino` AS `CdiTipoDestino`,`ing`.`IngEstado` AS `CdiEstado`,'Entrada' AS `CdiTipoCajaDiaria`,`ing`.`IngTiempoCreacion` AS `CdiTiempoCreacion`,`ing`.`IngTiempoModificacion` AS `CdiTiempoModificacion`,`mon`.`MonNombre` AS `MonNombre`,`mon`.`MonSimbolo` AS `MonSimbolo`,`cue`.`CueNumero` AS `CueNumero`,`ban`.`BanNombre` AS `BanNombre`,`prv`.`PrvNombre` AS `PrvNombre`,`prv`.`PrvApellidoPaterno` AS `PrvApellidoPaterno`,`prv`.`PrvApellidoMaterno` AS `PrvApellidoMaterno`,`prv`.`PrvNumeroDocumento` AS `PrvNumeroDocumento`,`prv`.`TdoId` AS `TdoIdProveedor`,`tdo`.`TdoNombre` AS `TdoNombreProveedor`,`cli`.`CliNombre` AS `CliNombre`,`cli`.`CliApellidoPaterno` AS `CliApellidoPaterno`,`cli`.`CliApellidoMaterno` AS `CliApellidoMaterno`,`cli`.`CliNumeroDocumento` AS `CliNumeroDocumento`,`cli`.`TdoId` AS `TdoIdCliente`,`tdo2`.`TdoNombre` AS `TdoNombreCliente`,`per`.`PerNombre` AS `PerNombre`,`per`.`PerApellidoPaterno` AS `PerApellidoPaterno`,`per`.`PerApellidoMaterno` AS `PerApellidoMaterno`,`per`.`PerNumeroDocumento` AS `PerNumeroDocumento`,`per`.`TdoId` AS `TdoIdPersonal`,`tdo3`.`TdoNombre` AS `TdoNombrePersonal` from (((((((((`tblingingreso` `ing` left join `tblprvproveedor` `prv` on((`ing`.`PrvId` = `prv`.`PrvId`))) left join `tbltdotipodocumento` `tdo` on((`prv`.`TdoId` = `tdo`.`TdoId`))) left join `tblclicliente` `cli` on((`ing`.`CliId` = `cli`.`CliId`))) left join `tbltdotipodocumento` `tdo2` on((`cli`.`TdoId` = `tdo2`.`TdoId`))) left join `tblperpersonal` `per` on((`ing`.`PerId` = `per`.`PerId`))) left join `tbltdotipodocumento` `tdo3` on((`per`.`TdoId` = `tdo3`.`TdoId`))) left join `tblcuecuenta` `cue` on((`ing`.`CueId` = `cue`.`CueId`))) left join `tblbanbanco` `ban` on((`cue`.`BanId` = `ban`.`BanId`))) left join `tblmonmoneda` `mon` on((`ing`.`MonId` = `mon`.`MonId`)));

-- ----------------------------
-- View structure for visp20promocion20k
-- ----------------------------
DROP VIEW IF EXISTS `visp20promocion20k`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `visp20promocion20k` AS select `ovv`.`OvvId` AS `OvvId`,`ovv`.`OvvFecha` AS `OvvFecha`,`ovv`.`EinId` AS `EinId`,`cli`.`CliNombre` AS `CliNombre`,`cli`.`CliApellidoPaterno` AS `CliApellidoPaterno`,`cli`.`CliApellidoMaterno` AS `CliApellidoMaterno`,`vma`.`VmaNombre` AS `VmaNombre`,`vmo`.`VmoNombre` AS `VmoNombre`,`vve`.`VveNombre` AS `VveNombre`,`ein`.`EinVIN` AS `EinVIN`,`ein`.`EinPlaca` AS `EinPlaca`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '1000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId1000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '1000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha1000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '5000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId5000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '5000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha5000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '10000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId10000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '10000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha10000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '15000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId15000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '15000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha15000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '20000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId20000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '20000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha20000` from (((((((`tblovvordenventavehiculo` `ovv` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv`.`OvvId`))) left join `tblclicliente` `cli` on((`ovv`.`CliId` = `cli`.`CliId`))) left join `tbleinvehiculoingreso` `ein` on((`ovv`.`EinId` = `ein`.`EinId`))) left join `tblvvevehiculoversion` `vve` on((`ein`.`VveId` = `vve`.`VveId`))) left join `tblvmovehiculomodelo` `vmo` on((`vve`.`VmoId` = `vmo`.`VmoId`))) left join `tblvmavehiculomarca` `vma` on((`vmo`.`VmaId` = `vma`.`VmaId`))) where (exists(select 1 from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10011'))) and (`ein`.`EinEstado` <> 6));

-- ----------------------------
-- View structure for visp30promocion30k
-- ----------------------------
DROP VIEW IF EXISTS `visp30promocion30k`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `visp30promocion30k` AS select `ovv`.`OvvId` AS `OvvId`,`ovv`.`OvvFecha` AS `OvvFecha`,`ovv`.`EinId` AS `EinId`,`cli`.`CliNombre` AS `CliNombre`,`cli`.`CliApellidoPaterno` AS `CliApellidoPaterno`,`cli`.`CliApellidoMaterno` AS `CliApellidoMaterno`,`vma`.`VmaNombre` AS `VmaNombre`,`vmo`.`VmoNombre` AS `VmoNombre`,`vve`.`VveNombre` AS `VveNombre`,`ein`.`EinVIN` AS `EinVIN`,`ein`.`EinPlaca` AS `EinPlaca`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '1000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId1000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '1000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha1000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '5000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId5000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '5000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha5000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '10000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId10000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '10000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha10000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '15000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId15000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '15000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha15000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '20000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId20000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '20000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha20000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '25000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId25000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '25000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha25000`,(select `fin`.`FinId` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '30000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinId30000`,(select `fin`.`FinFecha` from `tblfinfichaingreso` `fin` where ((`fin`.`FinMantenimientoKilometraje` = '30000') and (`fin`.`EinId` = `ovv`.`EinId`)) limit 1) AS `FinFecha30000` from (((((((`tblovvordenventavehiculo` `ovv` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv`.`OvvId`))) left join `tblclicliente` `cli` on((`ovv`.`CliId` = `cli`.`CliId`))) left join `tbleinvehiculoingreso` `ein` on((`ovv`.`EinId` = `ein`.`EinId`))) left join `tblvvevehiculoversion` `vve` on((`ein`.`VveId` = `vve`.`VveId`))) left join `tblvmovehiculomodelo` `vmo` on((`vve`.`VmoId` = `vmo`.`VmoId`))) left join `tblvmavehiculomarca` `vma` on((`vmo`.`VmaId` = `vma`.`VmaId`))) where (exists(select 1 from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10012'))) and (`ein`.`EinEstado` <> 6));

-- ----------------------------
-- View structure for visvmbvehiculomantenimientoobsequio
-- ----------------------------
DROP VIEW IF EXISTS `visvmbvehiculomantenimientoobsequio`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `visvmbvehiculomantenimientoobsequio` AS select `vmb`.`OvmId` AS `OvmId`,`vmb`.`OvvId` AS `OvvId`,`vmb`.`OvmKilometraje` AS `OvmKilometraje`,`ovv`.`EinId` AS `EinId`,(select ifnull(`bol`.`BolFechaEmision`,`fac`.`FacFechaEmision`) from ((`tblovvordenventavehiculo` `ovv2` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv2`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv2`.`OvvId`))) where (`ovv2`.`OvvId` = `ovv`.`OvvId`) limit 1) AS `VmbFechaVenta`,date_format(((select ifnull(`bol`.`BolFechaEmision`,`fac`.`FacFechaEmision`) from ((`tblovvordenventavehiculo` `ovv2` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv2`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv2`.`OvvId`))) where (`ovv2`.`OvvId` = `ovv`.`OvvId`) limit 1) + interval 730 day),'%Y-%m-%d') AS `VmbFechaVencimiento`,(to_days(cast(now() as date)) - to_days((select ifnull(`bol`.`BolFechaEmision`,`fac`.`FacFechaEmision`) from ((`tblovvordenventavehiculo` `ovv2` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv2`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv2`.`OvvId`))) where (`ovv2`.`OvvId` = `ovv`.`OvvId`) limit 1))) AS `VmbDiaTranscurrido`,(select `fin`.`FinVehiculoKilometraje` from `tblfinfichaingreso` `fin` where (`fin`.`EinId` = `ovv`.`EinId`) order by `fin`.`FinFecha` desc limit 1) AS `VmbVehiculoKilometraje`,(select `fin`.`FinMantenimientoKilometraje` from `tblfinfichaingreso` `fin` where (`fin`.`EinId` = `ovv`.`EinId`) order by `fin`.`FinFecha` desc limit 1) AS `VmbMantenimientoKilometraje`,(select count(`fin`.`FinId`) from `tblfinfichaingreso` `fin` where ((`fin`.`EinId` = `ovv`.`EinId`) and exists(select `fim`.`FimId` from `tblfimfichaingresomodalidad` `fim` where ((`fim`.`FinId` = `fin`.`FinId`) and (`fim`.`MinId` = 'MIN-10001')))) order by `fin`.`FinFecha` desc limit 1) AS `VmbCantidadMantenimientos` from ((`tblovmordenventavehiculomantenimiento` `vmb` left join `tblovvordenventavehiculo` `ovv` on((`vmb`.`OvvId` = `ovv`.`OvvId`))) left join `tbleinvehiculoingreso` `ein` on((`ovv`.`EinId` = `ein`.`EinId`)));

-- ----------------------------
-- View structure for visvrovehiculopromocion
-- ----------------------------
DROP VIEW IF EXISTS `visvrovehiculopromocion`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `visvrovehiculopromocion` AS select `ovv`.`OvvId` AS `OvvId`,`ovv`.`EinId` AS `EinId`,`ein`.`EinVIN` AS `EinVin`,(select ifnull(`bol`.`BolFechaEmision`,`fac`.`FacFechaEmision`) from ((`tblovvordenventavehiculo` `ovv2` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv2`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv2`.`OvvId`))) where (`ovv2`.`OvvId` = `ovv`.`OvvId`) limit 1) AS `VroFechaVenta`,date_format(((select ifnull(`bol`.`BolFechaEmision`,`fac`.`FacFechaEmision`) from ((`tblovvordenventavehiculo` `ovv2` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv2`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv2`.`OvvId`))) where (`ovv2`.`OvvId` = `ovv`.`OvvId`) limit 1) + interval 730 day),'%Y-%m-%d') AS `VobFechaVencimiento`,(to_days(cast(now() as date)) - to_days((select ifnull(`bol`.`BolFechaEmision`,`fac`.`FacFechaEmision`) from ((`tblovvordenventavehiculo` `ovv2` left join `tblfacfactura` `fac` on((`fac`.`OvvId` = `ovv2`.`OvvId`))) left join `tblbolboleta` `bol` on((`bol`.`OvvId` = `ovv2`.`OvvId`))) where (`ovv2`.`OvvId` = `ovv`.`OvvId`) limit 1))) AS `VroDiaTranscurrido`,(select `fin`.`FinVehiculoKilometraje` from `tblfinfichaingreso` `fin` where (`fin`.`EinId` = `ovv`.`EinId`) order by `fin`.`FinFecha` desc limit 1) AS `VroVehiculoKilometraje`,(select `fin`.`FinMantenimientoKilometraje` from `tblfinfichaingreso` `fin` where (`fin`.`EinId` = `ovv`.`EinId`) order by `fin`.`FinFecha` desc limit 1) AS `VroMantenimientoKilometraje`,(select count(`fin`.`FinId`) from `tblfinfichaingreso` `fin` where ((`fin`.`EinId` = `ovv`.`EinId`) and exists(select `fim`.`FimId` from `tblfimfichaingresomodalidad` `fim` where ((`fim`.`FinId` = `fin`.`FinId`) and (`fim`.`MinId` = 'MIN-10001')))) order by `fin`.`FinFecha` desc limit 1) AS `VroCantidadMantenimientos`,(case when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10010'))) then 'OBS-10010' when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10011'))) then 'OBS-10011' when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10012'))) then 'OBS-10012' when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10034'))) then 'OBS-10034' else '' end) AS `ObsId`,(select `obs`.`ObsNombre` from (`tblovoordenventavehiculoobsequio` `ovo` left join `tblobsobsequio` `obs` on((`ovo`.`ObsId` = `obs`.`ObsId`))) where (`ovo`.`OvvId` = `ovv`.`OvvId`) limit 1) AS `ObsNombre`,(case when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10010'))) then '50000' when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10011'))) then '20000' when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10012'))) then '30000' when exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and (`ovo`.`ObsId` = 'OBS-10034'))) then '100000' else '' end) AS `VroKilometrajeLimite` from (`tblovvordenventavehiculo` `ovv` left join `tbleinvehiculoingreso` `ein` on((`ovv`.`EinId` = `ein`.`EinId`))) where exists(select `ovo`.`OvoId` from `tblovoordenventavehiculoobsequio` `ovo` where ((`ovo`.`OvvId` = `ovv`.`OvvId`) and ((`ovo`.`ObsId` = 'OBS-10010') or (`ovo`.`ObsId` = 'OBS-10011') or (`ovo`.`ObsId` = 'OBS-10012') or (`ovo`.`ObsId` = 'OBS-10034'))));

-- ----------------------------
-- Function structure for FncListaPrecioCalcular
-- ----------------------------
DROP FUNCTION IF EXISTS `FncListaPrecioCalcular`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `FncListaPrecioCalcular`( oProId VARCHAR(20),oRtiId VARCHAR(20) ,oProListaPrecioCosto DECIMAL(16,6),oUmeId VARCHAR(20) ,oLtiPorcentajeOtroCosto DECIMAL(16,6),oLtiPorcentajeMargenUtilidad DECIMAL(16,6),oProPorcentajeManoObra DECIMAL(16,6),oProPorcentajeAdicional DECIMAL(16,6),oProPorcentajeDescuento DECIMAL(16,6) ,oLtiId VARCHAR(20),oUmeId2 VARCHAR(20)) RETURNS varchar(20) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN

DECLARE S_Respuesta VARCHAR(20);

DECLARE P_RtiId VARCHAR(20);
DECLARE P_UmeId VARCHAR(20);
DECLARE P_PtuTipo TINYINT(1);

DECLARE P_UmeEquivalente DECIMAL(20,7);
DECLARE P_AmdValorTotal DECIMAL(10,3);

DECLARE V_CostoIngreso DECIMAL(16,6);
DECLARE V_Costo DECIMAL(16,6);

DECLARE V_OtroCosto DECIMAL(16,6);
DECLARE V_Utilidad DECIMAL(16,6);
DECLARE V_ManoObra DECIMAL(16,6);

DECLARE V_ValorVenta DECIMAL(16,6);
DECLARE V_Impuesto DECIMAL(16,6);
DECLARE V_ValorVentaImpuesto DECIMAL(16,6);
DECLARE V_Adicional DECIMAL(16,6);
DECLARE V_Descuento DECIMAL(16,6);
DECLARE V_Precio DECIMAL(16,6);

DECLARE N_LprId VARCHAR(20);

DECLARE DONE_PTU BOOLEAN DEFAULT FALSE; 
				
DECLARE CUR_PTU CURSOR FOR 
		SELECT 
		ptu.RtiId, 
		ptu.UmeId,
		ptu.PtuTipo
		FROM tblptuproductotipounidadmedida ptu
			WHERE ptu.RtiId = oRtiId
			AND ptu.PtuTipo = 2
		ORDER BY ptu.RtiId ASC;

DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET DONE_PTU = TRUE;  
			
SET V_CostoIngreso = 0;
SET V_Costo = 0;

SET V_OtroCosto = 0;
SET V_Utilidad = 0;
SET V_ManoObra = 0;

SET V_ValorVenta = 0;
SET V_Impuesto = 0;
SET V_ValorVentaImpuesto = 0;
SET V_Adicional = 0;
SET V_Descuento = 0;
SET V_Precio = 0;


								SELECT MAX(CONVERT(SUBSTR(LprId,5),unsigned)) INTO N_LprId	
								FROM tbllprlistaprecio  
									WHERE LtiId = oLtiId AND UmeId = oUmeId2 AND ProId = oProId
								LIMIT 1;
								
								IF oUmeId = oUmeId2 THEN
									SET P_UmeEquivalente = 1;
								ELSE
									SELECT IFNULL(umc.UmcEquivalente,0) INTO P_UmeEquivalente 
									FROM tblumcunidadmedidaconversion umc 
										WHERE UmeId2 = oUmeId AND UmeId1 = oUmeId2 
									LIMIT 1;
								END IF;
								
								SET V_CostoIngreso = oProListaPrecioCosto;
								SET V_Costo = (IFNULL(P_UmeEquivalente,0) * IFNULL(V_CostoIngreso,0));
								
								SET V_OtroCosto = (V_Costo * (oLtiPorcentajeOtroCosto/100));								
								SET V_Utilidad = ( (V_Costo + V_OtroCosto) * (oLtiPorcentajeMargenUtilidad/100));
								SET V_ManoObra = ( (V_Costo + V_OtroCosto + V_Utilidad) * (oProPorcentajeManoObra/100));
								
								SET V_ValorVenta = V_Costo + V_OtroCosto + V_Utilidad + V_ManoObra;
								SET V_Impuesto = (V_ValorVenta * 0.18);		
								SET V_ValorVentaImpuesto = (V_ValorVenta + V_Impuesto);

								SET V_Adicional = ( V_ValorVentaImpuesto * (oProPorcentajeAdicional/100));
								SET V_Descuento = ( (V_ValorVentaImpuesto + V_Adicional) * (oProPorcentajeDescuento/100));								
								SET V_Precio = (V_ValorVentaImpuesto + V_Adicional - V_Descuento);
								
								
								IF N_LprId IS NULL OR N_LprId = "" THEN	
									
									SELECT MAX(CONVERT(SUBSTR(LprId,5),unsigned)) INTO N_LprId	FROM tbllprlistaprecio;
									IF N_LprId IS NULL OR N_LprId = "" THEN	SET N_LprId = "LPR-10000"; ELSE	SET N_LprId = N_LprId + 1; SET N_LprId = CONCAT("LPR-",N_LprId); END IF;
								
									INSERT INTO tbllprlistaprecio (
									LprId,
									ProId,
									LtiId,
									UmeId,
									
									LprEquivalente,
									LprCosto,
									
									LprPorcentajeOtroCosto,
									LprPorcentajeUtilidad,
									LprPorcentajeAdicional,
									LprPorcentajeDescuento,
									LprPorcentajeManoObra,
									
									LprOtroCosto,
									LprAdicional,
									LprUtilidad,
									LprManoObra,
									
									LprValorVenta,
									LprImpuesto,
									
									LprDescuento,
									LprPrecio,

									LprTiempoCreacion,
									LprTiempoModificacion) 
									VALUES (
									N_LprId,
									oProId,
									oLtiId,
									oUmeId2,
									
									IFNULL(P_UmeEquivalente,0),
									IFNULL(V_Costo,0),
									
									oLtiPorcentajeOtroCosto,
									oLtiPorcentajeMargenUtilidad,
									oProPorcentajeAdicional,
									oProPorcentajeDescuento,
									oProPorcentajeManoObra,

									IFNULL(V_OtroCosto,0),
									IFNULL(V_Adicional,0),
									IFNULL(V_Utilidad,0),
									IFNULL(V_ManoObra,0),
									
									IFNULL(V_ValorVenta,0),
									IFNULL(V_Impuesto,0),
									
									IFNULL(V_Descuento,0),
									IFNULL(V_Precio,0),
									
									NOW(),
									NOW()
									);
									
								ELSE	
								
									UPDATE tbllprlistaprecio 
									SET LprEquivalente = IFNULL(P_UmeEquivalente,0),

										LprCosto = IFNULL(V_Costo,0),

										LprPorcentajeOtroCosto = IFNULL(oLtiPorcentajeOtroCosto,0),
										LprPorcentajeUtilidad = IFNULL(oLtiPorcentajeMargenUtilidad,0),
										LprPorcentajeAdicional = IFNULL(oProPorcentajeAdicional,0),
										LprPorcentajeDescuento = IFNULL(oProPorcentajeDescuento,0),
										LprPorcentajeManoObra = IFNULL(oProPorcentajeManoObra,0),
										
										LprOtroCosto = IFNULL(V_OtroCosto,0),										
										LprAdicional = IFNULL(V_Adicional,0),
										LprUtilidad = IFNULL(V_Utilidad,0),
										LprManoObra = IFNULL(V_ManoObra,0),
										
										LprValorVenta = IFNULL(V_ValorVenta,0),
										LprImpuesto = IFNULL(V_Impuesto,0),
										
										LprDescuento = IFNULL(V_Descuento,0),
										LprPrecio = IFNULL(V_Precio,0),
										
										LprTiempoModificacion = NOW()
										
										WHERE LtiId = oLtiId
										AND ProId = oProId
										AND UmeId = oUmeId2;

								END IF;
						
								
								

	
SET S_Respuesta = "OK";  
RETURN S_Respuesta;

END
;;
delimiter ;

-- ----------------------------
-- Function structure for FncListaPrecioListarUnidadMedidas
-- ----------------------------
DROP FUNCTION IF EXISTS `FncListaPrecioListarUnidadMedidas`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `FncListaPrecioListarUnidadMedidas`( oProId VARCHAR(20),oRtiId VARCHAR(20) ,oProListaPrecioCosto DECIMAL(16,6),oUmeId VARCHAR(20) ,oLtiPorcentajeOtroCosto DECIMAL(16,6),oLtiPorcentajeMargenUtilidad DECIMAL(16,6),oLtiPorcentajeManoObra DECIMAL(16,6),oProPorcentajeAdicional DECIMAL(16,6),oProPorcentajeDescuento DECIMAL(16,6),oLtiId VARCHAR(20)) RETURNS varchar(20) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN

DECLARE S_Respuesta VARCHAR(20);

DECLARE P_RtiId VARCHAR(20);
DECLARE P_UmeId VARCHAR(20);
DECLARE P_PtuTipo TINYINT(1);

DECLARE P_UmeEquivalente DECIMAL(20,7);
DECLARE P_AmdValorTotal DECIMAL(10,3);

DECLARE V_CostoIngreso DECIMAL(16,6);
DECLARE V_Costo DECIMAL(16,6);

DECLARE V_OtroCosto DECIMAL(16,6);
DECLARE V_Utilidad DECIMAL(16,6);

DECLARE V_ValorVenta DECIMAL(16,6);
DECLARE V_Impuesto DECIMAL(16,6);
DECLARE V_Precio DECIMAL(16,6);

DECLARE N_LprId VARCHAR(20);

DECLARE AUX VARCHAR(20);


DECLARE DONE_PTU BOOLEAN DEFAULT FALSE; 
				
DECLARE CUR_PTU CURSOR FOR 
		SELECT 
		ptu.RtiId, 
		ptu.UmeId,
		ptu.PtuTipo
		FROM tblptuproductotipounidadmedida ptu
			WHERE ptu.RtiId = oRtiId
			AND ptu.PtuTipo = 2
		ORDER BY ptu.RtiId ASC;

		DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET DONE_PTU = TRUE;  
			
SET V_CostoIngreso = 1;
SET V_Costo = 1;

SET V_OtroCosto = 1;
SET V_Utilidad = 1;

SET V_ValorVenta = 1;
SET V_Impuesto = 1;
SET V_Precio = 1;

-- INSERT INTO aux4 (descripcion) values(CONCAT("F:RTIID: ",oRtiId));


OPEN CUR_PTU;
CUR_PTU_LOOP: LOOP

	FETCH CUR_PTU INTO P_RtiId, P_UmeId, P_PtuTipo; 
	IF DONE_PTU THEN LEAVE CUR_PTU_LOOP; END IF;  
							
	-- INSERT INTO aux4 (descripcion) values(P_UmeId);
								
	SET AUX = FncListaPrecioCalcular(oProId,oRtiId,oProListaPrecioCosto,oUmeId,oLtiPorcentajeOtroCosto,oLtiPorcentajeMargenUtilidad,oLtiPorcentajeManoObra,oProPorcentajeAdicional,oProPorcentajeDescuento,oLtiId,P_UmeId);

END LOOP CUR_PTU_LOOP;
CLOSE CUR_PTU;

	
SET S_Respuesta = "OK";  
RETURN S_Respuesta;

END
;;
delimiter ;

-- ----------------------------
-- Function structure for FncProductoCalcularCosto
-- ----------------------------
DROP FUNCTION IF EXISTS `FncProductoCalcularCosto`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `FncProductoCalcularCosto`( oProId VARCHAR(20),oAno VARCHAR(4),oCalcular VARCHAR(2) ) RETURNS varchar(20) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN
DECLARE S_Respuesta VARCHAR(20);
DECLARE Costo DECIMAL(10,3);
DECLARE CostoIngreso DECIMAL(10,3);
DECLARE CostoIngresoNeto DECIMAL(10,3);

DECLARE CostoBruto DECIMAL(10,3);
DECLARE CostoConvertido DECIMAL(10,3);
DECLARE CostoFinal DECIMAL(10,3);

DECLARE V_AmdId VARCHAR(20);
DECLARE V_OcoTipo VARCHAR(20);
DECLARE V_ProTienePromocion TINYINT(2);

DECLARE P_MonId VARCHAR(20);
DECLARE P_AmoTipoCambio DECIMAL(10,3);
DECLARE P_TcaMontoComercial DECIMAL(10,3);
DECLARE P_OcoTipo VARCHAR(20);


--  INSERT INTO aux2 (descripcion) values(CONCAT("FNC: ",oProId,"-",oAno,"-",(oAno)));

SET CostoConvertido = 0;
SET Costo = 0;
SET CostoFinal = 0;
SET V_ProTienePromocion = 2;

	SELECT amo.MonId INTO P_MonId 
		FROM tblamdalmacenmovimientodetalle amd 
			LEFT JOIN tblamoalmacenmovimiento amo 
			ON amd.AmoId = amo.AmoId 
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
	WHERE amo.AmoTipo = 1 
	AND amo.AmoEstado = 3 
	AND amd.ProId = oProId
	-- AND YEAR(amo.AmoFecha) = (oAno)
	AND ( amd.AmdCosto <> 0 OR amd.AmdCostoExtraUnitario <> 0 )
	ORDER BY amo.AmoFecha DESC, amo.AmoTiempoCreacion DESC LIMIT 1;
	
	
	SELECT amo.AmoTipoCambio  INTO P_AmoTipoCambio 
		FROM tblamdalmacenmovimientodetalle amd 
			LEFT JOIN tblamoalmacenmovimiento amo 
			ON amd.AmoId = amo.AmoId 
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
	WHERE amo.AmoTipo = 1 
	AND amo.AmoEstado = 3 
	AND amd.ProId = oProId
	-- AND YEAR(amo.AmoFecha) = (oAno)
	AND ( amd.AmdCosto <> 0 OR amd.AmdCostoExtraUnitario <> 0 )
	ORDER BY amo.AmoFecha DESC, amo.AmoTiempoCreacion DESC LIMIT 1;
	
	
	 SELECT (amd.AmdCosto/(amd.AmdCantidadReal/amd.AmdCantidad)) INTO Costo
	-- SELECT (amd.AmdCosto) INTO Costo
		FROM tblamdalmacenmovimientodetalle amd 
			LEFT JOIN tblamoalmacenmovimiento amo 
			ON amd.AmoId = amo.AmoId 
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
	WHERE amo.AmoTipo = 1 
	
	AND (amo.AmoSubTipo = 1 OR amo.TopId = "TOP-10015" OR amo.TopId = "TOP-10001" )
	
	AND amo.AmoEstado = 3 
	AND amd.ProId = oProId
	-- AND YEAR(amo.AmoFecha) = (oAno)
	AND ( amd.AmdCosto <> 0 )
	
	
	ORDER BY amo.AmoFecha DESC, amo.AmoTiempoCreacion DESC LIMIT 1;
	
	INSERT INTO aux2 (descripcion,tiempo) values(CONCAT("FNC: ProductoCalcularCosto - ProId: ",oProId," - Costo: ",Costo," - Ano ",(oAno)," - Moneda",P_MonId," - TC: ",IFNULL(P_AmoTipoCambio,0)," - Calcular: ",oCalcular),NOW());
	
	
	IF P_MonId != "MON-10000" THEN
	
		SELECT 
			IFNULL(TcaMontoComercial,0)
			INTO P_TcaMontoComercial
				FROM tbltcatipocambio 
		WHERE MonId = P_MonId
		ORDER BY TcaFecha DESC 
		LIMIT 1;
		
		IF P_TcaMontoComercial > 0 THEN
			SET CostoConvertido = (Costo / P_AmoTipoCambio);
			SET CostoFinal = (CostoConvertido * P_TcaMontoComercial);
		ELSE
			SET CostoFinal = 0;
		END IF;

		IF oCalcular = "1" THEN
			
			UPDATE tblproproducto 
			SET ProCosto = CostoFinal	
			WHERE ProId = oProId;

		END IF;
		
	ELSE
	
		IF oCalcular = "1" THEN

			UPDATE tblproproducto 
			SET ProCosto = Costo	
			WHERE ProId = oProId;

		END IF;

	END IF;
	
	SELECT amd.AmdId INTO V_AmdId
		FROM tblamdalmacenmovimientodetalle amd 
			LEFT JOIN tblamoalmacenmovimiento amo 
			ON amd.AmoId = amo.AmoId 
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
	WHERE amo.AmoTipo = 1 
	AND amo.AmoEstado = 3 
	AND amd.ProId = oProId
	-- AND YEAR(amo.AmoFecha) = (oAno)
	AND ( amd.AmdCosto <> 0 )
	ORDER BY amo.AmoFecha DESC, amo.AmoTiempoCreacion DESC LIMIT 1;

	
	SELECT IFNULL(oco.OcoTipo,"") INTO V_OcoTipo
		FROM tblamdalmacenmovimientodetalle amd 
			LEFT JOIN tblamoalmacenmovimiento amo 
			ON amd.AmoId = amo.AmoId 
				LEFT JOIN tblocoordencompra oco
				ON amo.OcoId = oco.OcoId
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
	WHERE amo.AmoTipo = 1 
	AND amo.AmoEstado = 3 
	AND amd.ProId = oProId
	-- AND YEAR(amo.AmoFecha) = (oAno)
	AND ( amd.AmdCosto <> 0 )
	ORDER BY amo.AmoFecha DESC, amo.AmoTiempoCreacion DESC LIMIT 1;

	IF(V_OcoTipo= "YPRO") THEN
		SET V_ProTienePromocion = 1;
	ELSE
		SET V_ProTienePromocion = 2;
	END IF;
	
	UPDATE tblproproducto 
	SET AmdId = V_AmdId,
	ProTipoPedidoUltimo = V_OcoTipo,
	ProTienePromocion = V_ProTienePromocion	
	WHERE ProId = oProId;

SET S_Respuesta = "OK";  
RETURN S_Respuesta;
  
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblacialmacencierre
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_ACI`;
delimiter ;;
CREATE TRIGGER `TRG_I_ACI` AFTER INSERT ON `tblacialmacencierre` FOR EACH ROW BEGIN

	IF NEW.AciFechaInicio != "" THEN
		
		IF NEW.AciFechaFin != "" THEN
			
			
			UPDATE tblamoalmacenmovimiento SET AmoCierre = 1 WHERE AmoFecha >= NEW.AciFechaInicio AND AmoFecha <= NEW.AciFechaFin;
			UPDATE tblamdalmacenmovimientodetalle SET AmdCierre = 1 WHERE AmdFecha >= NEW.AciFechaInicio AND AmdFecha <= NEW.AciFechaFin;
			
			UPDATE tbltpttrasladoproducto SET TptCierre = 1 WHERE TptFecha >= NEW.AciFechaInicio AND TptFecha <= NEW.AciFechaFin;
		
		END IF;
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblacialmacencierre
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_ACI`;
delimiter ;;
CREATE TRIGGER `TRG_D_ACI` AFTER DELETE ON `tblacialmacencierre` FOR EACH ROW BEGIN
 
	IF OLD.AciFechaInicio != "" THEN
		
		IF OLD.AciFechaFin != "" THEN
			
			UPDATE tblamoalmacenmovimiento SET AmoCierre = 2 WHERE AmoFecha >= OLD.AciFechaInicio AND AmoFecha <= OLD.AciFechaFin;
			UPDATE tblamdalmacenmovimientodetalle SET AmdCierre = 2 WHERE AmdFecha >= OLD.AciFechaInicio AND AmdFecha <= OLD.AciFechaFin;
			
			UPDATE tbltpttrasladoproducto SET TptCierre = 2 WHERE TptFecha >= OLD.AciFechaInicio AND TptFecha <= OLD.AciFechaFin;
		
		END IF;
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblamdalmacenmovimientodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_AMD`;
delimiter ;;
CREATE TRIGGER `TRG_I_AMD` AFTER INSERT ON `tblamdalmacenmovimientodetalle` FOR EACH ROW BEGIN

DECLARE P_PrvCalcularCosto TINYINT(1);
DECLARE P_ProCalcularPrecio TINYINT(1);

DECLARE P_AmoTipo TINYINT(1);
DECLARE P_AmoSubTipo TINYINT(1);
DECLARE P_AmoFecha VARCHAR(10);
DECLARE P_AmoComprobanteFecha VARCHAR(10);

DECLARE P_UltimaSalida VARCHAR(10);
DECLARE P_UltimaEntrada VARCHAR(10);

DECLARE P_SucId VARCHAR(20);
DECLARE P_AprId VARCHAR(20);
DECLARE N_AprId VARCHAR(20);

DECLARE AUX VARCHAR(20);
	
SELECT AmoTipo INTO P_AmoTipo FROM tblamoalmacenmovimiento WHERE AmoId = NEW.AmoId;
SELECT AmoSubTipo INTO P_AmoSubTipo FROM tblamoalmacenmovimiento WHERE AmoId = NEW.AmoId;
SELECT AmoFecha INTO P_AmoFecha FROM tblamoalmacenmovimiento WHERE AmoId = NEW.AmoId;

SELECT IFNULL(amo.AmoComprobanteFecha,"") INTO P_UltimaEntrada 
FROM tblamoalmacenmovimiento amo 
LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.AmoId = amo.AmoId 
WHERE amd.AmdEstado = 3 
AND amo.AmoEstado = 3 
AND amd.ProId = NEW.ProId 
AND amo.AmoTipo = 1  
AND amo.AmoSubTipo = 1 
ORDER BY amo.AmoComprobanteFecha DESC LIMIT 1;

SELECT IFNULL(amd.AmdFecha,"") INTO P_UltimaSalida 
FROM tblamoalmacenmovimiento amo 
LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.AmoId = amo.AmoId 
WHERE amd.AmdEstado = 3 
AND amo.AmoEstado = 3 
AND amd.ProId = NEW.ProId 
AND amo.AmoTipo = 2 
AND amo.AmoSubTipo <> 6 
AND amo.TopId <> "TOP-10010" 
ORDER BY amd.AmdFecha DESC LIMIT 1;

SELECT SucId INTO P_SucId FROM tblamoalmacenmovimiento WHERE AmoId = NEW.AmoId;

SELECT prv.PrvCalcularCosto INTO P_PrvCalcularCosto FROM tblamoalmacenmovimiento amo LEFT JOIN tblprvproveedor prv ON amo.PrvId = prv.PrvId WHERE amo.AmoId = NEW.AmoId;

SELECT pro.ProCalcularPrecio INTO P_ProCalcularPrecio FROM tblproproducto pro WHERE pro.ProId = NEW.ProId;


UPDATE tblproproducto 
SET ProFechaUltimaActividad = DATE(NOW())
WHERE ProId = NEW.ProId;

	CASE P_AmoTipo
		-- ENTRADA
        WHEN 1 THEN  
		
            IF NEW.AmdEstado = 3 THEN

				
				
				IF NEW.OcdId IS NOT NULL THEN
					UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo - NEW.AmdCantidad WHERE OcdId = NEW.OcdId;
				END IF;
				
				-- SET AUX = FncProductoCalcularCosto(NEW.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
								
				SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
				WHERE ProId = NEW.ProId 
				AND AlmId = NEW.AlmId
				AND AprAno = 1900;
				
				IF P_AprId IS NULL OR P_AprId = "" THEN

					SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
					IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

					INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
					VALUES (N_AprId,NEW.AlmId,1900,NEW.ProId,NEW.AmdCantidad,NEW.AmdCantidadReal,NEW.AmdCantidadReal,"CREADO / TRG_I_AMD / ENTRADA",3,NOW(),NOW());											

				ELSE 
				
					UPDATE tblapralmacenproducto 
					SET AprStock = AprStock + NEW.AmdCantidad,
					AprStockReal = AprStockReal + NEW.AmdCantidadReal,
					AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  + NEW.AmdCantidadReal,
					AprObservacion = "ACTUALIZADO / TRG_I_AMD / ENTRADA "					
					WHERE AprId = P_AprId;
					
				END IF;
				
				IF P_AmoSubTipo = 1 THEN
					
					IF P_UltimaEntrada != "" THEN
						
						UPDATE tblproproducto 
						SET ProFechaUltimaEntrada = P_UltimaEntrada
						WHERE ProId = NEW.ProId;

					END IF;
				  
				END IF;
				
			END IF;
        -- SALIDA
        WHEN 2 THEN 

            IF NEW.AmdEstado = 3 THEN
			
                
				
				SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
				WHERE ProId = NEW.ProId 
				AND AlmId = NEW.AlmId
				AND AprAno = 1900;
										
				IF P_AprId IS NULL OR P_AprId = "" THEN

					SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
					IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

					INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
					VALUES (N_AprId,NEW.AlmId,1900,NEW.ProId,(NEW.AmdCantidad*-1),(NEW.AmdCantidadReal*-1),0," CREADO / TRG_I_AMD / SALIDA ",3,NOW(),NOW());											

				ELSE 
					
					UPDATE tblapralmacenproducto 
					SET AprStock = AprStock - NEW.AmdCantidad,
					AprStockReal = AprStockReal - NEW.AmdCantidadReal ,
					AprObservacion = " ACTUALIZADO / TRG_I_AMD / SALIDA "					
					WHERE AprId = P_AprId;
					
				END IF;
				
				
            END IF;

    ELSE
    BEGIN
	END;        
    END CASE; 
      


END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblamdalmacenmovimientodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_AMD`;
delimiter ;;
CREATE TRIGGER `TRG_U_AMD` AFTER UPDATE ON `tblamdalmacenmovimientodetalle` FOR EACH ROW BEGIN

DECLARE P_PrvCalcularCosto TINYINT(1);
DECLARE P_ProCalcularPrecio TINYINT(1);

DECLARE P_AmoTipo TINYINT(1);
DECLARE P_AmoSubTipo TINYINT(1);
DECLARE P_AmoFecha VARCHAR(10);

DECLARE P_AmoComprobanteFecha VARCHAR(10);

DECLARE P_UltimaSalida VARCHAR(10);
DECLARE P_UltimaEntrada VARCHAR(10);

DECLARE P_AlmId VARCHAR(20);
DECLARE P_AprId VARCHAR(20);
DECLARE N_AprId VARCHAR(20);

DECLARE AUX VARCHAR(20);

SELECT AmoTipo INTO P_AmoTipo FROM tblamoalmacenmovimiento WHERE AmoId = OLD.AmoId;
SELECT AmoFecha INTO P_AmoFecha FROM tblamoalmacenmovimiento WHERE AmoId = OLD.AmoId;
SELECT AlmId INTO P_AlmId FROM tblamoalmacenmovimiento WHERE AmoId = OLD.AmoId;


SELECT IFNULL(amo.AmoComprobanteFecha,"") INTO P_UltimaEntrada FROM tblamoalmacenmovimiento amo LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.AmoId = amo.AmoId WHERE amd.AmdEstado = 3 AND amo.AmoEstado = 3 AND amd.ProId = OLD.ProId AND amo.AmoTipo = 1 AND amo.AmoSubTipo = 1 ORDER BY amo.AmoComprobanteFecha DESC LIMIT 1;

SELECT IFNULL(amd.AmdFecha,"") INTO P_UltimaSalida FROM tblamoalmacenmovimiento amo LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.AmoId = amo.AmoId WHERE amd.AmdEstado = 3 AND amo.AmoEstado = 3 AND amd.ProId = OLD.ProId AND amo.AmoTipo = 2 AND amo.AmoSubTipo <> 6 AND amo.TopId <> "TOP-10010" ORDER BY amd.AmdFecha DESC LIMIT 1;




SELECT prv.PrvCalcularCosto INTO P_PrvCalcularCosto FROM tblamoalmacenmovimiento amo
LEFT JOIN tblprvproveedor prv ON amo.PrvId = prv.PrvId WHERE amo.AmoId = OLD.AmoId;

SELECT pro.ProCalcularPrecio INTO P_ProCalcularPrecio FROM tblproproducto pro
WHERE pro.ProId = NEW.ProId;
	
UPDATE tblproproducto 
SET ProFechaUltimaActividad = DATE(NOW())
WHERE ProId = OLD.ProId;	
		
		IF (NEW.AmdFecha <> OLD.AmdFecha)  THEN
		
		CASE P_AmoTipo
				-- ENTRADA
				WHEN 1 THEN 

					IF P_UltimaEntrada != "" THEN
						
						UPDATE tblproproducto 
						SET ProFechaUltimaEntrada = P_UltimaEntrada
						WHERE ProId = OLD.ProId;

					END IF;
					
				BEGIN
				END;

				-- SALIDA
				WHEN 2 THEN				

					
				BEGIN
				END;

				ELSE
				BEGIN
				END;
				END CASE;  
		
		END IF;
		
		
		IF (NEW.AlmId <> OLD.AlmId)  THEN
		
			CASE P_AmoTipo
				-- ENTRADA
				WHEN 1 THEN 

					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = NEW.AlmId
					AND AprAno = 1900;

					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,NEW.AlmId,1900,OLD.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),(OLD.AmdCantidadReal)," CREADO / TRG_U_AMD / ENTRADA / ALMACEN DISTINTO ",3,NOW(),NOW());											

					ELSE 

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock  + OLD.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  + OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / ALMACEN DISTINTO NUEVO"
						
						WHERE AprId = P_AprId;
						
					END IF;
					
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NOT NULL AND P_AprId != "" THEN

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  - OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / ALMACEN DISTINTO ANTIGUO"
						
						WHERE AprId = P_AprId;
						
					END IF;

				BEGIN
				END;

				-- SALIDA
				WHEN 2 THEN				

					
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = NEW.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,NEW.AlmId,1900,OLD.ProId,(NEW.AmdCantidad*-1),(NEW.AmdCantidadReal*-1),0," CREADO / TRG_U_AMD / SALIDA / ALMACEN DISTINTO ",3,NOW(),NOW());											

					ELSE 
					
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - NEW.AmdCantidad,
						AprStockReal = AprStockReal - NEW.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / ALMACEN DISTINTO NUEVO "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;

					IF P_AprId IS NOT NULL AND P_AprId != "" THEN
					
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / ALMACEN DISTINTO ANTIGUO "
						
						WHERE AprId = P_AprId;

					END IF;
				
				BEGIN
				END;

				ELSE
				BEGIN
				END;
				END CASE;   
			
		
		END IF;
		
		
		IF (NEW.AmdCantidadReal <> OLD.AmdCantidadReal) AND OLD.AmdEstado = 3 THEN

			CASE P_AmoTipo
				-- ENTRADA
				WHEN 1 THEN 
				
					
					IF OLD.OcdId IS NOT NULL THEN
						UPDATE tblocdordencompradetalle 
						SET OcdSaldo = OcdSaldo + OLD.AmdCantidad - NEW.AmdCantidad  
						WHERE OcdId = OLD.OcdId;
					END IF;
					
					-- SET AUX =   FncProductoCalcularCosto(OLD.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
										
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,NEW.ProId,(NEW.AmdCantidad),(NEW.AmdCantidadReal),(NEW.AmdCantidadReal)," CREADO / TRG_U_AMD / ENTRADA / CANTIDAD DISTINTA ",3,NOW(),NOW());

					ELSE 
						
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad + NEW.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal + NEW.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0) - OLD.AmdCantidadReal + NEW.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / CANTIDAD DISTINTA "
						
						WHERE AprId = P_AprId;
						
					END IF;
							
				BEGIN
				END;

				-- SALIDA
				WHEN 2 THEN				

					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(NEW.AmdCantidad*-1),(NEW.AmdCantidadReal*-1),0," CREADO / TRG_U_AMD / SALIDA / CANTIDAD DISTINTA ",3,NOW(),NOW());		
						
					ELSE 
						
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad - NEW.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal - NEW.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / CANTIDAD DISTINTA "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
				BEGIN
				END;

				ELSE
				BEGIN
				END;
			END CASE;   
						
		END IF;

		IF (NEW.UmeId <> OLD.UmeId) AND OLD.AmdEstado = 3 THEN

			CASE P_AmoTipo
				-- ENTRADA
				WHEN 1 THEN 

					
						
					IF OLD.OcdId IS NOT NULL THEN
						UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo + OLD.AmdCantidad - NEW.AmdCantidad WHERE OcdId = OLD.OcdId;
					END IF;

				--	SET AUX =   FncProductoCalcularCosto(OLD.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,NEW.ProId,(NEW.AmdCantidad),(NEW.AmdCantidadReal),(NEW.AmdCantidadReal),3,NOW(),NOW());											

					ELSE 

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad + NEW.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal + NEW.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  - OLD.AmdCantidadReal + NEW.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / UNIDAD MEDIDA "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
					
				BEGIN
				END;

				-- SALIDA
				WHEN 2 THEN				

					
						
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(NEW.AmdCantidad*-1),(NEW.AmdCantidadReal*-1),0,3,NOW(),NOW());											

					ELSE 
					
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad - NEW.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal - NEW.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / UNIDAD MEDIDA "
						
						WHERE AprId = P_AprId;
						
					END IF;
				
				BEGIN
				END;

				ELSE
				BEGIN
				END;
			END CASE;   
						
		END IF;
		
		
		IF (NEW.ProId <> OLD.ProId) AND OLD.AmdEstado = 3 THEN

			CASE P_AmoTipo
				-- ENTRADA
				WHEN 1 THEN 
				
					
					
					
				--	SET AUX =   FncProductoCalcularCosto(OLD.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
					
					IF OLD.OcdId IS NOT NULL THEN
						UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo + OLD.AmdCantidad WHERE OcdId = OLD.OcdId;
					END IF;
					
				
					
					IF OLD.OcdId IS NOT NULL THEN
						UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo - OLD.AmdCantidad WHERE OcdId = OLD.OcdId;
					END IF;
					
				--	SET AUX =   FncProductoCalcularCosto(NEW.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));

					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad*-1),(OLD.AmdCantidadReal*-1),0,3,NOW(),NOW());											

					ELSE 
					
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  - OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / PRODUCTO DISTINTO ANTIGUO"
						
						WHERE AprId = P_AprId;
						
					END IF;
				
					
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = NEW.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,NEW.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),(OLD.AmdCantidadReal),3,NOW(),NOW());											

					ELSE 
										
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  + OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / PRODUCTO DISTINTO NUEVO "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
					
					
					
				BEGIN
				END;

				-- SALIDA
				WHEN 2 THEN				

					
					
						
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),(OLD.AmdCantidadReal),3,NOW(),NOW());											

					ELSE 
					
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal,						
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / PRODUCTO DISTINTO ANTIGUO "
						
						WHERE AprId = P_AprId;
						
					END IF;
				
					
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = NEW.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,NEW.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),(OLD.AmdCantidadReal),3,NOW(),NOW());											

					ELSE 
										
						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / PRODUCTO DISTINTO NUEVO "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
				BEGIN
				END;

				ELSE
				BEGIN
				END;
			END CASE;   
						
		END IF;
		
		

		IF NEW.AmdEstado <> OLD.AmdEstado THEN
			
			/*INSERT INTO aux6(descripcion) VALUES( CONCAT( "cambio de estado ",P_AmoTipo));*/
			
			CASE P_AmoTipo

			-- Entrada
			WHEN 1 THEN 
			

				IF (OLD.AmdEstado=1 OR OLD.AmdEstado = 2) AND (NEW.AmdEstado = 3) THEN
					
					
					
					IF OLD.OcdId IS NOT NULL THEN
						UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo - OLD.AmdCantidad WHERE OcdId = OLD.OcdId;
					END IF;

					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),(OLD.AmdCantidadReal),3,NOW(),NOW());											

					ELSE 

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  + OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / ESTADO DISTINTO 3 "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
					
					
				ELSEIF (NEW.AmdEstado=1 OR NEW.AmdEstado = 2) AND (OLD.AmdEstado = 3) THEN

					
					IF OLD.OcdId IS NOT NULL THEN
						UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo + OLD.AmdCantidad WHERE OcdId = OLD.OcdId;	
					END IF;
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad*-1),(OLD.AmdCantidadReal*-1),0,3,NOW(),NOW());											

					ELSE 

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal,
						AprStockRealIngresado = IFNULL(AprStockRealIngresado,0)  - OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / ENTRADA / ESTADO DISTINTO 1-2 "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
				END IF;

				-- SET AUX = FncProductoCalcularCosto(OLD.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
				
				IF P_AmoSubTipo = 1 THEN
					
					IF P_AmoComprobanteFecha != "" THEN
						
						UPDATE tblproproducto 
						SET ProFechaUltimaEntrada = P_AmoComprobanteFecha
						WHERE ProId = OLD.ProId;

					END IF;
				
				END IF;
			-- Salida
			WHEN 2 THEN
			
				IF (OLD.AmdEstado=1 OR OLD.AmdEstado = 2) AND NEW.AmdEstado = 3 THEN
				
					UPDATE tblproproducto 
					SET ProStock = ProStock - OLD.AmdCantidad,
					ProStockReal = ProStockReal - OLD.AmdCantidadReal 
					WHERE ProId = OLD.ProId
						AND 1900 = YEAR(NOW());			
					
					
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad*-1),(OLD.AmdCantidadReal*-1),0,3,NOW(),NOW());											

					ELSE 

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock - OLD.AmdCantidad,
						AprStockReal = AprStockReal - OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / ESTADO DISTINTO 3 "
						
						WHERE AprId = P_AprId;
						
					END IF;
					
					
				ELSEIF (NEW.AmdEstado=1 OR NEW.AmdEstado = 2) AND OLD.AmdEstado = 3  THEN
				
					UPDATE tblproproducto 
					SET ProStock = ProStock + OLD.AmdCantidad,
					ProStockReal = ProStockReal + OLD.AmdCantidadReal 
					WHERE ProId = OLD.ProId
						AND 1900 = YEAR(NOW());
				 
				 
					SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
					WHERE ProId = OLD.ProId 
					AND AlmId = OLD.AlmId
					AND AprAno = 1900;
					
					IF P_AprId IS NULL OR P_AprId = "" THEN

						SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
						IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

						INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
						VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),0,3,NOW(),NOW());											

					ELSE 

						UPDATE tblapralmacenproducto 
						SET AprStock = AprStock + OLD.AmdCantidad,
						AprStockReal = AprStockReal + OLD.AmdCantidadReal,
						AprObservacion = " ACTUALIZADO / TRG_U_AMD / SALIDA / ESTADO DISTINTO 1-2 "
					
						WHERE AprId = P_AprId;
						
					END IF;
					
				END IF;
				
			ELSE
			BEGIN
			END;
			END CASE; 

		
		END IF;
		
		
		
		CASE P_AmoTipo

			-- Entrada
			WHEN 1 THEN 
			
				BEGIN
				
			--	SET AUX = FncProductoCalcularCosto(OLD.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
				
				END;
			-- Salida
			WHEN 2 THEN
			
			BEGIN
			END;
				
			ELSE
			BEGIN
			END;
			END CASE; 

		

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblamdalmacenmovimientodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_AMD`;
delimiter ;;
CREATE TRIGGER `TRG_D_AMD` AFTER DELETE ON `tblamdalmacenmovimientodetalle` FOR EACH ROW BEGIN

DECLARE P_PrvCalcularCosto TINYINT(1);
DECLARE P_ProCalcularPrecio TINYINT(1);

DECLARE P_AmoTipo TINYINT(1);
DECLARE P_AmoSubTipo TINYINT(1);

DECLARE P_AmoFecha VARCHAR(10);
DECLARE P_AmoComprobanteFecha VARCHAR(10);
DECLARE P_UltimaSalida VARCHAR(10);
DECLARE P_UltimaEntrada VARCHAR(10);

DECLARE P_SucId VARCHAR(20);
DECLARE P_AprId VARCHAR(20);
DECLARE N_AprId VARCHAR(20);

DECLARE AUX VARCHAR(20);

SELECT AmoTipo INTO P_AmoTipo FROM tblamoalmacenmovimiento WHERE AmoId = OLD.AmoId;
SELECT AmoFecha INTO P_AmoFecha FROM tblamoalmacenmovimiento WHERE AmoId = OLD.AmoId;


SELECT IFNULL(amo.AmoComprobanteFecha,"") INTO P_UltimaEntrada FROM tblamoalmacenmovimiento amo LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.AmoId = amo.AmoId WHERE amd.AmdEstado = 3 AND amo.AmoEstado = 3 AND amd.ProId = OLD.ProId AND amo.AmoTipo = 1 AND amo.AmoSubTipo = 1  ORDER BY amo.AmoComprobanteFecha DESC LIMIT 1;

SELECT IFNULL(amd.AmdFecha,"") INTO P_UltimaSalida FROM tblamoalmacenmovimiento amo LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.AmoId = amo.AmoId WHERE amd.AmdEstado = 3 AND amo.AmoEstado = 3 AND amd.ProId = OLD.ProId AND amo.AmoTipo = 2 AND amo.AmoSubTipo <> 6 AND amo.TopId <> "TOP-10010" ORDER BY amd.AmdFecha DESC LIMIT 1;


SELECT AlmId INTO P_SucId FROM tblamoalmacenmovimiento WHERE AmoId = OLD.AmoId;

SELECT prv.PrvCalcularCosto INTO P_PrvCalcularCosto FROM tblamoalmacenmovimiento amo LEFT JOIN tblprvproveedor prv ON amo.PrvId = prv.PrvId WHERE amo.AmoId = OLD.AmoId;

SELECT pro.ProCalcularPrecio INTO P_ProCalcularPrecio FROM tblproproducto pro
WHERE pro.ProId = OLD.ProId;


UPDATE tblproproducto 
SET ProFechaUltimaActividad = DATE(NOW())
WHERE ProId = OLD.ProId;


	CASE P_AmoTipo
		-- ENTRADA
        WHEN 1 THEN  
            IF OLD.AmdEstado = 3 THEN
			
			
				
				IF OLD.OcdId IS NOT NULL THEN
					UPDATE tblocdordencompradetalle SET OcdSaldo = OcdSaldo + OLD.AmdCantidad WHERE OcdId = OLD.OcdId;
				END IF;
				
			--	SET AUX = FncProductoCalcularCosto(OLD.ProId,P_AmoFecha,IFNULL(P_ProCalcularPrecio,0));
				
				
				SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
				WHERE ProId = OLD.ProId 
				AND AlmId = OLD.AlmId
				AND AprAno = 1900;

				IF P_AprId IS NULL OR P_AprId = "" THEN

					SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
					IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

					INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
					VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad*-1),(OLD.AmdCantidadReal*-1),(OLD.AmdCantidadReal*-1),"CREADO / TRG_D_AMD / ENTRADA ",3,NOW(),NOW());											

				ELSE 
					
					UPDATE tblapralmacenproducto 
					SET AprStock = AprStock - OLD.AmdCantidad,
					AprStockReal = AprStockReal - OLD.AmdCantidadReal,
					AprObservacion = "ACTUALIZADO / TRG_D_AMD / ENTRADA "
					WHERE AprId = P_AprId;
					
				END IF;
				
				-- IF P_AmoSubTipo = 1 THEN
					
					IF P_UltimaEntrada != "" THEN
						
						UPDATE tblproproducto 
						SET ProFechaUltimaEntrada = P_UltimaEntrada
						WHERE ProId = OLD.ProId;

					END IF;
				
				-- END IF;
			END IF;
        -- SALIDA
        WHEN 2 THEN 
		
            IF OLD.AmdEstado = 3 THEN

           		 				 
				 
				SELECT AprId INTO P_AprId FROM tblapralmacenproducto 
				WHERE ProId = OLD.ProId 
				AND AlmId = OLD.AlmId
				AND AprAno = 1900;
				
				IF P_AprId IS NULL OR P_AprId = "" THEN

					SELECT MAX(CONVERT(SUBSTR(AprId,5),unsigned)) INTO P_AprId	FROM tblapralmacenproducto;
					IF P_AprId IS NULL OR P_AprId = "" THEN	SET N_AprId = "APR-10000"; ELSE	SET P_AprId = P_AprId + 1; SET N_AprId = CONCAT("APR-",P_AprId); END IF;

					INSERT INTO tblapralmacenproducto(AprId,AlmId,AprAno,ProId,AprStock,AprStockReal,AprStockRealIngresado,AprObservacion,AprEstado,AprTiempoCreacion,AprTiempoModificacion) 
					VALUES (N_AprId,OLD.AlmId,1900,OLD.ProId,(OLD.AmdCantidad),(OLD.AmdCantidadReal),(OLD.AmdCantidadReal),"CREADO / TRG_D_AMD / SALIDA ",3,NOW(),NOW());											

				ELSE 
					
					UPDATE tblapralmacenproducto 
					SET AprStock = AprStock + OLD.AmdCantidad,
					AprStockReal = AprStockReal + OLD.AmdCantidadReal,					
					AprObservacion = "ACTUALIZADO / TRG_D_AMD / SALIDA "					
					WHERE AprId = P_AprId
					AND AprAno = 1900;
					
				END IF;
				
				 IF P_AmoSubTipo != 6 THEN
					
					 IF P_UltimaSalida != "" AND P_UltimaSalida != "0000-00-00" THEN
						
					 	UPDATE tblproproducto 
					 	SET ProFechaUltimaSalida = P_UltimaSalida
					 	WHERE ProId = OLD.ProId;

					END IF;
				
				 END IF;

            END IF;

    ELSE
    BEGIN
	END;        
    END CASE;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblamoalmacenmovimiento
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_AMO`;
delimiter ;;
CREATE TRIGGER `TRG_U_AMO` AFTER UPDATE ON `tblamoalmacenmovimiento` FOR EACH ROW BEGIN

	IF NEW.AmoEstado <> OLD.AmoEstado THEN
				
		UPDATE tblamdalmacenmovimientodetalle SET AmdEstado = NEW.AmoEstado WHERE AmoId= OLD.AmoId;
		
	END IF;	

	IF NEW.AlmId <> OLD.AlmId THEN
		
			
			CASE OLD.AmoTipo
			
			WHEN 1 THEN  
			
				IF OLD.AmoEstado = 3 THEN
					
					UPDATE tblamdalmacenmovimientodetalle SET AmdEstado = 1 WHERE AmoId = OLD.AmoId;
					
					UPDATE tblamdalmacenmovimientodetalle SET AmdEstado = 3 WHERE AmoId = OLD.AmoId;
					
					
				END IF;
			
			WHEN 2 THEN 
			
				IF OLD.AmoEstado = 3 THEN

					UPDATE tblamdalmacenmovimientodetalle SET AmdEstado = 1 WHERE AmoId = OLD.AmoId;
					
					UPDATE tblamdalmacenmovimientodetalle SET AmdEstado = 3 WHERE AmoId = OLD.AmoId;
					
					
				END IF;

		ELSE
		BEGIN
		END;        
		END CASE;     
		
		
		
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblamoalmacenmovimiento
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_AMO`;
delimiter ;;
CREATE TRIGGER `TRG_D_AMO` BEFORE DELETE ON `tblamoalmacenmovimiento` FOR EACH ROW BEGIN
	


END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblavvasignacionventavehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_AVV`;
delimiter ;;
CREATE TRIGGER `TRG_I_AVV` AFTER INSERT ON `tblavvasignacionventavehiculo` FOR EACH ROW BEGIN

	IF NEW.AvvEstado = 3 THEN
	
		UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = NEW.AvvAprobacion WHERE OvvId = NEW.OvvId;
		
		IF NEW.AvvAprobacion = 1 THEN
		
			UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "RESERVADO" WHERE EinId = NEW.EinId;
			UPDATE tblovvordenventavehiculo SET EinId = NEW.EinId WHERE OvvId = NEW.OvvId;
			UPDATE tblovvordenventavehiculo SET OvvEstado = 3 WHERE OvvId = NEW.OvvId;
			
		END IF;
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblavvasignacionventavehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_AVV`;
delimiter ;;
CREATE TRIGGER `TRG_U_AVV` AFTER UPDATE ON `tblavvasignacionventavehiculo` FOR EACH ROW BEGIN

	IF NEW.AvvEstado != OLD.AvvEstado THEN
	
		IF NEW.AvvEstado = 6 THEN
		
			UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = 3 WHERE OvvId = OLD.OvvId;
			UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "STOCK" WHERE EinId = OLD.EinId;
			
			UPDATE tblovvordenventavehiculo SET OvvEstado = 3 WHERE OvvId = OLD.OvvId;
			
		ELSEIF NEW.AvvEstado = 1 THEN
			
			UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = 3 WHERE OvvId = OLD.OvvId;
			UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "STOCK" WHERE EinId = OLD.EinId;
		
		ELSEIF NEW.AvvEstado = 3 THEN
		
			IF NEW.AvvAprobacion = 1 THEN
			
				UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = 1 WHERE OvvId = OLD.OvvId;
			
			ELSEIF NEW.AvvAprobacion = 2 THEN
			
				UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = 2 WHERE OvvId = OLD.OvvId;
			
			ELSE
			
				UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = 3 WHERE OvvId = OLD.OvvId;
			
			END IF;
			
			
		END IF;
	
	
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblavvasignacionventavehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_AVV`;
delimiter ;;
CREATE TRIGGER `TRG_D_AVV` BEFORE DELETE ON `tblavvasignacionventavehiculo` FOR EACH ROW BEGIN

	IF OLD.AvvAprobacion = 1 THEN
	
		IF OLD.AvvEstado = 3 THEN
			
			UPDATE tblovvordenventavehiculo SET OvvAprobacion1 = 3 WHERE OvvId = OLD.OvvId;
			UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "STOCK" WHERE EinId = OLD.EinId;
		
		END IF;

	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblbamboletaalmacenmovimiento
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_BAM`;
delimiter ;;
CREATE TRIGGER `TRG_I_BAM` AFTER INSERT ON `tblbamboletaalmacenmovimiento` FOR EACH ROW BEGIN

	
	DECLARE P_BolEstado TINYINT(1);
	DECLARE P_VmvEstado TINYINT(1);
	
	SELECT IFNULL(BolEstado,0) INTO P_BolEstado FROM tblbolboleta WHERE BolId = NEW.BolId AND BtaId = NEW.BtaId;
	SELECT IFNULL(VmvEstado,0) INTO P_VmvEstado FROM tblvmvvehiculomovimiento WHERE VmvId = NEW.VmvId;
	
	IF P_BolEstado <> 6 THEN
	
		IF NEW.VmvId IS NOT NULL OR NEW.VmvId != "" THEN
			
			IF P_VmvEstado = 1 THEN
			
				UPDATE tblvmvvehiculomovimiento 
				SET VmvEstado = 3 ,
				VmvFecha = DATE(NOW())
				WHERE VmvId = NEW.VmvId;
				UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 3 WHERE VmvId = NEW.VmvId;
			
			ELSE
			
				UPDATE tblvmvvehiculomovimiento SET VmvEstado = 3 WHERE VmvId = NEW.VmvId;
				UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 3 WHERE VmvId = NEW.VmvId;
			
			END IF;
			
		END IF;
	
	END IF;
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblbamboletaalmacenmovimiento
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_BAM`;
delimiter ;;
CREATE TRIGGER `TRG_D_BAM` BEFORE DELETE ON `tblbamboletaalmacenmovimiento` FOR EACH ROW BEGIN

	DECLARE P_BolEstado TINYINT(1);
	
	SELECT IFNULL(BolEstado,0) INTO P_BolEstado FROM tblbolboleta WHERE BolId = OLD.BolId AND BtaId = OLD.BtaId;
	
	IF P_BolEstado <> 6 THEN
	
		IF OLD.VmvId != NULL AND OLD.VmvId != "" THEN
		
			UPDATE tblvmvvehiculomovimiento SET VmvEstado = 3 WHERE VmvId = OLD.VmvId;
			UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 3 WHERE VmvId = OLD.VmvId;
		
		END IF;
	
	END IF;

	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblbolboleta
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_BOL`;
delimiter ;;
CREATE TRIGGER `TRG_I_BOL` AFTER INSERT ON `tblbolboleta` FOR EACH ROW BEGIN

	DECLARE P_EinId VARCHAR(20);
		
	
	IF NEW.BolEstado != 6 THEN
	
		IF NEW.OvvId != "" OR NEW.OvvId IS NOT NULL THEN
		
			SELECT IFNULL(EinId,"") INTO P_EinId FROM tblovvordenventavehiculo ovv WHERE OvvId = NEW.OvvId LIMIT 1;
			
			IF P_EinId != ""  THEN
			
				UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "VENDIDO" WHERE EinId = P_EinId;
				UPDATE tblovvordenventavehiculo SET OvvEstado = 5 WHERE OvvId = NEW.OvvId;
			
			END IF;
			
		
		END IF;
		
	END IF;
			
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblbolboleta
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_BOL`;
delimiter ;;
CREATE TRIGGER `TRG_U_BOL` AFTER UPDATE ON `tblbolboleta` FOR EACH ROW BEGIN

	DECLARE P_VmvId VARCHAR(20);
	DECLARE P_AmoId VARCHAR(20);
	DECLARE P_EinId VARCHAR(20);
	
	SELECT IFNULL(VmvId,"") INTO P_VmvId FROM tblbamboletaalmacenmovimiento bam WHERE BolId = OLD.BolId AND BtaId = OLD.BtaId LIMIT 1;
	SELECT IFNULL(AmoId,"") INTO P_AmoId FROM tblbamboletaalmacenmovimiento bam WHERE BolId = OLD.BolId AND BtaId = OLD.BtaId LIMIT 1;
	
	IF OLD.OvvId != "" OR OLD.OvvId IS NOT NULL THEN
	
		SELECT IFNULL(EinId,"") INTO P_EinId FROM tblovvordenventavehiculo ovv WHERE OvvId = OLD.OvvId LIMIT 1;
		
		IF P_EinId != ""  THEN
			
			IF NEW.BolEstado = 6 THEN
			
				UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "RESERVADO" WHERE EinId = P_EinId;
				UPDATE tblovvordenventavehiculo SET OvvEstado = 4 WHERE OvvId = OLD.OvvId;
			
			END IF;
			
		END IF;
		
	
	END IF;

	IF P_VmvId != "" THEN
		
		IF NEW.BolEstado <> OLD.BolEstado THEN 
			
			IF NEW.BolEstado = 6 THEN
				
				UPDATE tblvmvvehiculomovimiento SET VmvEstado = 1 WHERE VmvId = P_VmvId;
				UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 1 WHERE VmvId = P_VmvId;

			END IF;
		
		END IF;
		
	END IF;
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblfacfactura
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_FAC`;
delimiter ;;
CREATE TRIGGER `TRG_I_FAC` AFTER INSERT ON `tblfacfactura` FOR EACH ROW BEGIN

	DECLARE P_EinId VARCHAR(20);
		
	
	IF NEW.FacEstado != 6 THEN
	
		IF NEW.OvvId != "" OR NEW.OvvId IS NOT NULL THEN
		
			SELECT IFNULL(EinId,"") INTO P_EinId FROM tblovvordenventavehiculo ovv WHERE OvvId = NEW.OvvId LIMIT 1;
			
			IF P_EinId != ""  THEN
			
				UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "VENDIDO" WHERE EinId = P_EinId;
				UPDATE tblovvordenventavehiculo SET OvvEstado = 5 WHERE OvvId = NEW.OvvId;
			
			END IF;
			
		
		END IF;
		
	END IF;
			
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblfacfactura
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_FAC`;
delimiter ;;
CREATE TRIGGER `TRG_U_FAC` AFTER UPDATE ON `tblfacfactura` FOR EACH ROW BEGIN

	DECLARE P_VmvId VARCHAR(20);
	DECLARE P_AmoId VARCHAR(20);
	DECLARE P_EinId VARCHAR(20);
	
	SELECT IFNULL(VmvId,"") INTO P_VmvId FROM tblfamfacturaalmacenmovimiento fam WHERE FacId = OLD.FacId AND FtaId = OLD.FtaId LIMIT 1;
	SELECT IFNULL(AmoId,"") INTO P_AmoId FROM tblfamfacturaalmacenmovimiento fam WHERE FacId = OLD.FacId AND FtaId = OLD.FtaId LIMIT 1;
	
	IF OLD.OvvId != "" OR OLD.OvvId IS NOT NULL THEN
	
		SELECT IFNULL(EinId,"") INTO P_EinId FROM tblovvordenventavehiculo ovv WHERE OvvId = OLD.OvvId LIMIT 1;
		
		IF P_EinId != ""  THEN
			
			IF NEW.FacEstado = 6 THEN
			
				UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "RESERVADO" WHERE EinId = P_EinId;
				UPDATE tblovvordenventavehiculo SET OvvEstado = 4 WHERE OvvId = OLD.OvvId;
			
			END IF;
			
		END IF;
		
	
	END IF;

	IF P_VmvId != "" THEN
		
		IF NEW.FacEstado <> OLD.FacEstado THEN 
			
			IF NEW.FacEstado = 6 THEN
				
				UPDATE tblvmvvehiculomovimiento SET VmvEstado = 1 WHERE VmvId = P_VmvId;
				UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 1 WHERE VmvId = P_VmvId;

			END IF;
		
		END IF;
		
	END IF;
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblfacfactura
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_FAC`;
delimiter ;;
CREATE TRIGGER `TRG_D_FAC` BEFORE DELETE ON `tblfacfactura` FOR EACH ROW BEGIN

	DECLARE P_VmvId VARCHAR(20);
	DECLARE P_AmoId VARCHAR(20);
	DECLARE P_EinId VARCHAR(20);
	
	SELECT IFNULL(VmvId,"") INTO P_VmvId FROM tblfamfacturaalmacenmovimiento fam WHERE FacId = OLD.FacId AND FtaId = OLD.FtaId LIMIT 1;
	SELECT IFNULL(AmoId,"") INTO P_AmoId FROM tblfamfacturaalmacenmovimiento fam WHERE FacId = OLD.FacId AND FtaId = OLD.FtaId LIMIT 1;
	
	
	IF OLD.OvvId != "" OR OLD.OvvId IS NOT NULL THEN
	
		SELECT IFNULL(EinId,"") INTO P_EinId FROM tblovvordenventavehiculo ovv WHERE OvvId = OLD.OvvId LIMIT 1;
		
		IF P_EinId != ""  THEN
			
			IF OLD.FacEstado != 6 THEN
			
				UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "RESERVADO" WHERE EinId = P_EinId;
				UPDATE tblovvordenventavehiculo SET OvvEstado = 4 WHERE OvvId = OLD.OvvId;
			
			END IF;
			
		END IF;
		
	
	END IF;

	IF P_VmvId != "" THEN
		
			
			IF OLD.FacEstado != 6 THEN
				
				UPDATE tblvmvvehiculomovimiento SET VmvEstado = 1 WHERE VmvId = P_VmvId;
				UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 1 WHERE VmvId = P_VmvId;

			END IF;
		
	END IF;
	
	

        
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblfinfichaingreso
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_FIN`;
delimiter ;;
CREATE TRIGGER `TRG_I_FIN` AFTER INSERT ON `tblfinfichaingreso` FOR EACH ROW BEGIN

	IF NEW.FinTipo = 2 THEN
		
			UPDATE tblovvordenventavehiculo 
			SET OvvActaEntregaFechaPDS = NEW.FinFecha 
			WHERE EinId = NEW.EinId 
			AND OvvEstado <> 6;
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblfinfichaingreso
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_FIN`;
delimiter ;;
CREATE TRIGGER `TRG_U_FIN` BEFORE UPDATE ON `tblfinfichaingreso` FOR EACH ROW BEGIN

	IF OLD.FinTipo = 2 THEN
		
		IF NEW.FinFecha  <> OLD.FinFecha  THEN
			
			UPDATE tblovvordenventavehiculo 
			SET OvvActaEntregaFechaPDS = NEW.FinFecha 
			WHERE EinId = OLD.EinId 
			AND OvvEstado <> 6;
		
		END IF;
		
		IF NEW.EinId  <> OLD.EinId  THEN
			
			UPDATE tblovvordenventavehiculo 
			SET OvvActaEntregaFechaPDS = NULL
			WHERE EinId = OLD.EinId 
			AND OvvEstado <> 6;
			
			UPDATE tblovvordenventavehiculo 
			SET OvvActaEntregaFechaPDS = NEW.FinFecha 
			WHERE EinId = NEW.EinId 
			AND OvvEstado <> 6;
			
		END IF;
		
		
	END IF;
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblfinfichaingreso
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_FIN`;
delimiter ;;
CREATE TRIGGER `TRG_D_FIN` AFTER DELETE ON `tblfinfichaingreso` FOR EACH ROW BEGIN
 
	IF OLD.FinTipo = 2 THEN
		
		
			
			UPDATE tblovvordenventavehiculo 
			SET OvvActaEntregaFechaPDS = NULL
			WHERE EinId = OLD.EinId 
			AND OvvEstado <> 6;
			
		
		
	END IF;
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblncrnotacredito
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_NCR`;
delimiter ;;
CREATE TRIGGER `TRG_I_NCR` AFTER INSERT ON `tblncrnotacredito` FOR EACH ROW BEGIN


	DECLARE P_OvvId VARCHAR(25);
	DECLARE P_VmvId VARCHAR(20);
	
	
	IF NEW.FacId IS NOT NULL AND NEW.FtaId  IS NOT NULL THEN
		
		IF NEW.NcrEstado != 6 THEN
		
			SELECT 
			IFNULL(fac.OvvId,"") 
			INTO P_OvvId 
			FROM tblfacfactura fac
			WHERE fac.FacId = NEW.FacId AND fac.FtaId = NEW.FtaId
			ORDER BY fac.FacFechaEmision DESC LIMIT 1;
			
			UPDATE tblovvordenventavehiculo SET OvvEstado = 3 WHERE OvvId = P_OvvId;
			
			INSERT INTO auxlog(descripcion,tiempo) VALUES(CONCAT("FAC: ",IFNULL(P_OvvId,"VACIO")),NOW());
			
			IF P_OvvId != "" THEN
			
				SELECT 
				IFNULL(VmvId,"") 
				INTO P_VmvId 
				FROM tblvmvvehiculomovimiento vmv 
				WHERE vmv.OvvId = P_OvvId AND vmv.VmvTipo = 2 AND vmv.VmvSubTipo = 1 AND vmv.VmvEstado <> 6
				ORDER BY vmv.VmvFecha DESC LIMIT 1;
				
				INSERT INTO auxlog(descripcion,tiempo) VALUES(CONCAT("FAC: ",IFNULL(P_VmvId,"VACIO")),NOW());
				
				IF P_VmvId != "" THEN
					UPDATE tblvmvvehiculomovimiento SET VmvEstado = 6 WHERE VmvId = P_VmvId;
				END IF;

			END IF;
			
			
		END IF;
		
	ELSEIF NEW.BolId IS NOT NULL AND NEW.BtaId IS NOT NULL THEN
	
		IF NEW.NcrEstado != 6 THEN
		
			SELECT 
			IFNULL(bol.OvvId,"") 
			INTO P_OvvId 
			FROM tblbolboleta bol
			WHERE bol.BolId = NEW.BolId AND bol.BtaId = NEW.BtaId
			ORDER BY bol.BolFechaEmision DESC LIMIT 1;
			
			UPDATE tblovvordenventavehiculo SET OvvEstado = 3 WHERE OvvId = P_OvvId;
			
			INSERT INTO auxlog(descripcion,tiempo) VALUES(CONCAT("BOL: ",IFNULL(P_OvvId,"VACIO")),NOW());
			
			IF P_OvvId != "" THEN
			
				SELECT 
				IFNULL(VmvId,"") 
				INTO P_VmvId 
				FROM tblvmvvehiculomovimiento vmv 
				WHERE vmv.OvvId = P_OvvId AND vmv.VmvTipo = 2 AND vmv.VmvSubTipo = 1 AND vmv.VmvEstado <> 6
				ORDER BY vmv.VmvFecha DESC LIMIT 1;
				
				INSERT INTO auxlog(descripcion,tiempo) VALUES(CONCAT("BOL: ",IFNULL(P_VmvId,"VACIO")),NOW());
				
				IF P_VmvId != "" THEN
				
					UPDATE tblvmvvehiculomovimiento SET VmvEstado = 6 WHERE VmvId = P_VmvId;
					
					
					
				END IF;

			END IF;
			
			
		END IF;
		
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblncrnotacredito
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_NCR`;
delimiter ;;
CREATE TRIGGER `TRG_U_NCR` AFTER UPDATE ON `tblncrnotacredito` FOR EACH ROW BEGIN

	DECLARE P_VmvId VARCHAR(20);
	
	SELECT 
	IFNULL(VmvId,"") 
	INTO P_VmvId 
	FROM tblvmvvehiculomovimiento vmv 
	WHERE vmv.OvvId = OLD.OvvId 
	AND VmvTipo = 1 
	AND VmvSubTipo =3
	ORDER BY vmv.VmvFecha DESC LIMIT 1;
	
	IF NEW.NcrEstado != OLD.NcrEstado THEN
	
		IF NEW.NcrEstado = 6 THEN
		
			IF OLD.OvvId != "" AND OLD.OvvId IS NOT NULL THEN
		
				UPDATE tblvmvvehiculomovimiento 
				SET VmvEstado = 6
				WHERE OvvId = OLD.OvvId 
				AND VmvTipo = 1 
				AND VmvSubTipo =3;
				
				IF P_VmvId != "" THEN
			
					UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 1 WHERE VmvId = P_VmvId;
					UPDATE tblvmvvehiculomovimiento SET VmvEstado = 6 WHERE OvvId = OLD.OvvId;
			
				END IF;
		
			
			END IF;
			
			
		
		ELSEIF NEW.NcrEstado != 6 THEN
		
		
			IF OLD.OvvId != "" AND OLD.OvvId IS NOT NULL THEN
		
				UPDATE tblvmvvehiculomovimiento 
				SET VmvEstado = 3
				WHERE OvvId = OLD.OvvId 
				AND VmvTipo = 1 
				AND VmvSubTipo =3;
				
				IF P_VmvId != "" THEN
			
					UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 3 WHERE VmvId = P_VmvId;
					UPDATE tblvmvvehiculomovimiento SET VmvEstado = 3 WHERE OvvId = OLD.OvvId;
			
				END IF;
		
			
			END IF;
			
			
		
		END IF;
		
	
	END IF;
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblncrnotacredito
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_NCR`;
delimiter ;;
CREATE TRIGGER `TRG_D_NCR` BEFORE DELETE ON `tblncrnotacredito` FOR EACH ROW BEGIN
	
	DECLARE P_VmvId VARCHAR(20);
	
	SELECT 
	IFNULL(VmvId,"") 
	INTO P_VmvId 
	FROM tblvmvvehiculomovimiento vmv 
	WHERE vmv.OvvId = OLD.OvvId 
	AND VmvTipo = 1 
	AND VmvSubTipo =3
	ORDER BY vmv.VmvFecha DESC LIMIT 1;
	
	
	IF OLD.OvvId != "" OR OLD.OvvId IS NOT NULL THEN
		
		IF P_VmvId != "" THEN
			
			DELETE FROM tblvmdvehiculomovimientodetalle  WHERE VmvId = P_VmvId;
			DELETE FROM tblvmvvehiculomovimiento WHERE VmvId = P_VmvId;
			
		END IF;
				
	
	END IF;
	
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblovvordenventavehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_OVV`;
delimiter ;;
CREATE TRIGGER `TRG_U_OVV` AFTER UPDATE ON `tblovvordenventavehiculo` FOR EACH ROW BEGIN

	DECLARE P_VmvId VARCHAR(20);
	
	SELECT IFNULL(VmvId,"") INTO P_VmvId 
	FROM tblvmvvehiculomovimiento vmv 
	WHERE vmv.OvvId = OLD.OvvId 
	ORDER BY vmv.VmvFecha DESC LIMIT 1;
	
	INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("P_VmvId: ",P_VmvId) ,NOW());
	
	IF NEW.CliId != OLD.CliId THEN
		
		UPDATE tblvmvvehiculomovimiento SET CliId = NEW.CliId WHERE OvvId = OLD.OvvId;
		
	END IF;
	
	
	
	
	
	IF NEW.OvvEstado = 3 AND OLD.OvvEstado = 4 THEN
		
		IF P_VmvId != "" THEN
			
			UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 1 WHERE VmvId = P_VmvId;
			UPDATE tblvmvvehiculomovimiento SET VmvEstado = 6 WHERE OvvId = OLD.OvvId;
			
		END IF;
		
	END IF;
	
	IF NEW.OvvEstado = 6 AND OLD.OvvEstado = 4 THEN
		
		IF P_VmvId != "" THEN
			
			UPDATE tblvmdvehiculomovimientodetalle SET VmdEstado = 1 WHERE VmvId = P_VmvId;
			UPDATE tblvmvvehiculomovimiento SET VmvEstado = 6 WHERE OvvId = OLD.OvvId;
			
		END IF;
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblpcdpedidocompradetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_PCD`;
delimiter ;;
CREATE TRIGGER `TRG_I_PCD` AFTER INSERT ON `tblpcdpedidocompradetalle` FOR EACH ROW BEGIN

	IF NEW.VddId IS NOT NULL THEN
		UPDATE tblvddventadirectadetalle SET VddCantidadPedir = VddCantidadPedir - NEW.PcdCantidad WHERE VddId = NEW.VddId;
	END IF;	

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblpcdpedidocompradetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_PCD`;
delimiter ;;
CREATE TRIGGER `TRG_U_PCD` BEFORE UPDATE ON `tblpcdpedidocompradetalle` FOR EACH ROW BEGIN

	IF OLD.VddId IS NOT NULL THEN
		UPDATE tblvddventadirectadetalle SET VddCantidadPedir = VddCantidadPedir + OLD.PcdCantidad - NEW.PcdCantidad WHERE VddId = OLD.VddId;
	END IF;			

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblpcdpedidocompradetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_PCD`;
delimiter ;;
CREATE TRIGGER `TRG_D_PCD` AFTER DELETE ON `tblpcdpedidocompradetalle` FOR EACH ROW BEGIN

  	IF OLD.VddId IS NOT NULL THEN
		UPDATE tblvddventadirectadetalle SET VddCantidadPedir = VddCantidadPedir + OLD.PcdCantidad WHERE VddId = OLD.VddId;
	END IF;	

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblppdproduccionproductodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_PPD`;
delimiter ;;
CREATE TRIGGER `TRG_I_PPD` AFTER INSERT ON `tblppdproduccionproductodetalle` FOR EACH ROW BEGIN

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_PoeId VARCHAR(20);
DECLARE N_PoeId VARCHAR(20);

DECLARE P_PosId VARCHAR(20);
DECLARE N_PosId VARCHAR(20);

DECLARE P_AmoEstadoIngreso TINYINT(1);
DECLARE P_AmoEstadoSalida TINYINT(1);

DECLARE P_AmoFechaIngreso DATE;
DECLARE P_AmoFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);


SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

SELECT AmoEstado INTO P_AmoEstadoIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AmoEstado INTO P_AmoEstadoSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

SELECT AmoFecha INTO P_AmoFechaIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AmoFecha INTO P_AmoFechaSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;


	IF NEW.PpdTipo = 1 THEN

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_PoeId	FROM tblamdalmacenmovimientodetalle;
		IF P_PoeId IS NULL OR P_PoeId = "" THEN	SET N_PoeId = "POE-10000"; ELSE	SET P_PoeId = P_PoeId + 1; SET N_PoeId = CONCAT("POE-",P_PoeId); END IF;
			
		INSERT INTO tblamdalmacenmovimientodetalle (
		AmdId,
		AmoId, 
				
		AmdIdOrigen,			
		PpdId,
				
		ProId,
		UmeId,			

		AmdCantidad,	
		AmdCantidadReal,		
			
		AmdValorTotal,
		AmdCosto,
		AmdImporte,
		
		AlmId,
		AmdFecha,
		AmdEstado,
		AmdTiempoCreacion,
		AmdTiempoModificacion
		) 
		VALUES (
		N_PoeId, 
		P_AmoIdIngreso, 
			
		NULL,
		NEW.PpdId,
				
		NEW.ProId,
		NEW.UmeId,
				
		NEW.PpdCantidad,
		NEW.PpdCantidadReal,
				
		NEW.PpdCosto,
		NEW.PpdCosto,
		NEW.PpdImporte,
		
		P_AlmIdIngreso,
		P_AmoFechaIngreso,
		P_AmoEstadoIngreso,
		NOW(), 				
		NOW());
	
	ELSE
	
		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_PosId	FROM tblamdalmacenmovimientodetalle;
		IF P_PosId IS NULL OR P_PosId = "" THEN	SET N_PosId = "POS-10000"; ELSE	SET P_PosId = P_PosId + 1; SET N_PosId = CONCAT("POS-",P_PosId); END IF;
		
		INSERT INTO tblamdalmacenmovimientodetalle (
		AmdId,
		AmoId, 
			
		AmdIdOrigen,
		PpdId,
			
		ProId,
		UmeId,			

		AmdCantidad,	
		AmdCantidadReal,		
			
		AmdCosto,
		AmdImporte,
			
		AlmId,
		AmdFecha,
		AmdEstado,
		AmdTiempoCreacion,
		AmdTiempoModificacion
		) 
		VALUES (
		N_PosId, 
		P_AmoIdSalida, 
			
		NULL,
		NEW.PpdId,
			
		NEW.ProId,
		NEW.UmeId,
			
		NEW.PpdCantidad,
		NEW.PpdCantidadReal,
		
		NEW.PpdCosto,
		NEW.PpdImporte,
		
		P_AlmIdSalida,
		P_AmoFechaSalida,
		P_AmoEstadoSalida,
		NOW(), 				
		NOW());
		
	END IF;

		
		 
	
		
	
	


END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblppdproduccionproductodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_PPD`;
delimiter ;;
CREATE TRIGGER `TRG_D_PPD` BEFORE DELETE ON `tblppdproduccionproductodetalle` FOR EACH ROW BEGIN

	DELETE FROM tblamdalmacenmovimientodetalle WHERE PpdId = OLD.PpdId;
		
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblppdproduccionproductodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_PPD`;
delimiter ;;
CREATE TRIGGER `TRG_U_PPD` AFTER UPDATE ON `tblppdproduccionproductodetalle` FOR EACH ROW BEGIN

DECLARE P_PoeId VARCHAR(20);
DECLARE N_PoeId VARCHAR(20);

DECLARE P_PosId VARCHAR(20);
DECLARE N_PosId VARCHAR(20);

DECLARE P_AmdIdIngreso VARCHAR(20);
DECLARE P_AmdIdSalida VARCHAR(20);

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_AmoEstadoIngreso TINYINT(1);
DECLARE P_AmoEstadoSalida TINYINT(1);

DECLARE P_AmoFechaIngreso DATE;
DECLARE P_AmoFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);

SELECT AmdId INTO P_AmdIdIngreso FROM tblamdalmacenmovimientodetalle amd LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId
WHERE PpdId = OLD.PpdId AND amo.AmoTipo = 1;

SELECT AmdId INTO P_AmdIdSalida FROM tblamdalmacenmovimientodetalle amd LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId
WHERE PpdId = OLD.PpdId AND amo.AmoTipo = 2;

SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

SELECT AmoEstado INTO P_AmoEstadoIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AmoEstado INTO P_AmoEstadoSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

SELECT AmoFecha INTO P_AmoFechaIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AmoFecha INTO P_AmoFechaSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblamoalmacenmovimiento WHERE PprId = NEW.PprId AND AmoTipo = 2;

	IF P_AmdIdIngreso IS NULL OR P_AmdIdIngreso = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_PoeId	FROM tblamdalmacenmovimientodetalle;
		IF P_PoeId IS NULL OR P_PoeId = "" THEN	SET N_PoeId = "POE-10000"; ELSE	SET P_PoeId = P_PoeId + 1; SET N_PoeId = CONCAT("POE-",P_PoeId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			PpdId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdValorTotal,
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_PoeId, 
			P_AmoIdIngreso, 
			
			NULL,
			NEW.PpdId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.PpdCantidad,
			NEW.PpdCantidadReal,
			
			NEW.PpdCosto,
			NEW.PpdCosto,
			NEW.PpdImporte,
			
			P_AlmIdIngreso,
			P_AmoFechaIngreso,
			P_AmoEstadoIngreso,
			NOW(), 				
			NOW());

	ELSE	SET P_PosId = P_PosId + 1; 

		UPDATE tblamdalmacenmovimientodetalle SET
		ProId = NEW.ProId,
		UmeId = NEW.UmeId,

		AmdCantidad = NEW.PpdCantidad,
		AmdCantidadReal =  NEW.PpdCantidadReal,
	
		AmdValorTotal = NEW.PpdCosto,
		AmdCosto = NEW.PpdCosto,	
		AmdImporte = NEW.PpdImporte,
		AmdEstado = P_AmoEstadoIngreso,
		
		AlmId = P_AlmIdIngreso,
		AmdFecha = P_AmoFechaIngreso,		
		AmdTiempoModificacion = NOW()
		WHERE AmdId = P_AmdIdIngreso;

	END IF;
		
	IF P_AmdIdSalida IS NULL OR P_AmdIdSalida = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_PosId	FROM tblamdalmacenmovimientodetalle;
			IF P_PosId IS NULL OR P_PosId = "" THEN	SET N_PosId = "POS-10000"; ELSE	SET P_PosId = P_PosId + 1; SET N_PosId = CONCAT("POS-",P_PosId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			PpdId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_PosId, 
			P_AmoIdSalida, 
			
			NULL,
			NEW.PpdId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.PpdCantidad,
			NEW.PpdCantidadReal,
			
			NEW.PpdCosto,
			NEW.PpdImporte,
			
			P_AlmIdSalida,
			P_AmoFechaSalida,
			P_AmoEstadoSalida,
			NOW(), 				
			NOW());

	ELSE	SET P_PosId = P_PosId + 1; 
		
		UPDATE tblamdalmacenmovimientodetalle SET

		ProId = NEW.ProId,
		UmeId = NEW.UmeId,

		AmdCantidad = NEW.PpdCantidad,
		AmdCantidadReal =  NEW.PpdCantidadReal,
	
		AmdValorTotal = NEW.PpdCosto,
		AmdCosto = NEW.PpdCosto,	
		AmdImporte = NEW.PpdImporte,
		
		AlmId = P_AlmIdSalida,
		AmdFecha = P_AmoFechaSalida,
		AmdEstado = P_AmoEstadoSalida,		
		AmdTiempoModificacion = NOW()
		WHERE AmdId = P_AmdIdSalida;

	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblproproducto
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_PRO`;
delimiter ;;
CREATE TRIGGER `TRG_U_PRO` AFTER UPDATE ON `tblproproducto` FOR EACH ROW BEGIN

DECLARE P_LtiId VARCHAR(20);
DECLARE P_LtiPorcentajeMargenUtilidad DECIMAL(10,3);
DECLARE P_LtiPorcentajeOtroCosto DECIMAL(10,3);
DECLARE P_LtiPorcentajeManoObra DECIMAL(10,3);

DECLARE P_LtiUso VARCHAR(4);
DECLARE P_ProListaPrecioCostoAntiguo DECIMAL(10,3);
DECLARE P_ProListaPrecioCostoNuevo DECIMAL(10,3);

DECLARE AUX VARCHAR(20);
DECLARE DONE_LTI BOOLEAN DEFAULT FALSE; 

DECLARE CUR_LTI CURSOR FOR 
	SELECT 
		lti.LtiId, 
		lti.LtiPorcentajeMargenUtilidad,
		lti.LtiPorcentajeOtroCosto,
		lti.LtiPorcentajeManoObra,
		
		lti.LtiUso
	FROM tbllticlientetipo lti
		
ORDER BY lti.LtiId ASC;
			
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET DONE_LTI = TRUE;  

IF IFNULL(NEW.ProCosto,0) <> IFNULL(OLD.ProCosto,0) THEN
	
	IF NEW.ProCalcularPrecio = 1 OR OLD.ProCalcularPrecio = 1 THEN
		
		OPEN CUR_LTI;
		CUR_LTI_LOOP: LOOP
			
			FETCH CUR_LTI INTO P_LtiId, P_LtiPorcentajeMargenUtilidad, P_LtiPorcentajeOtroCosto, P_LtiPorcentajeManoObra, P_LtiUso; 
			IF DONE_LTI THEN LEAVE CUR_LTI_LOOP; END IF;  

				
				SET AUX = FncListaPrecioListarUnidadMedidas(OLD.ProId,OLD.RtiId,IFNULL(NEW.ProCosto,0),OLD.UmeId,IFNULL(P_LtiPorcentajeOtroCosto,0),IFNULL(P_LtiPorcentajeMargenUtilidad,0),IFNULL(P_LtiPorcentajeManoObra,0),IFNULL(NEW.ProPorcentajeAdicional,0),IFNULL(NEW.ProPorcentajeDescuento,0),P_LtiId);
			
		END LOOP CUR_LTI_LOOP;
		CLOSE CUR_LTI;
	
	END IF;
	

END IF;

IF IFNULL(NEW.ProPorcentajeAdicional,0) <> IFNULL(OLD.ProPorcentajeAdicional,0) THEN

	OPEN CUR_LTI;
	CUR_LTI_LOOP: LOOP
		
		FETCH CUR_LTI INTO P_LtiId, P_LtiPorcentajeMargenUtilidad, P_LtiPorcentajeOtroCosto, P_LtiPorcentajeManoObra, P_LtiUso; 
		IF DONE_LTI THEN LEAVE CUR_LTI_LOOP; END IF;  

			INSERT INTO aux4 (descripcion) values(P_LtiId);
			SET AUX = FncListaPrecioListarUnidadMedidas(OLD.ProId,OLD.RtiId,IFNULL(NEW.ProCosto,0),OLD.UmeId,IFNULL(P_LtiPorcentajeOtroCosto,0),IFNULL(P_LtiPorcentajeMargenUtilidad,0),IFNULL(P_LtiPorcentajeManoObra,0),IFNULL(NEW.ProPorcentajeAdicional,0),IFNULL(NEW.ProPorcentajeDescuento,0),P_LtiId);
		
	END LOOP CUR_LTI_LOOP;
	CLOSE CUR_LTI;

END IF;

IF IFNULL(NEW.ProPorcentajeDescuento,0) <> IFNULL(OLD.ProPorcentajeDescuento,0) THEN

	OPEN CUR_LTI;
	CUR_LTI_LOOP: LOOP
		
		FETCH CUR_LTI INTO P_LtiId, P_LtiPorcentajeMargenUtilidad, P_LtiPorcentajeOtroCosto, P_LtiPorcentajeManoObra, P_LtiUso; 
		IF DONE_LTI THEN LEAVE CUR_LTI_LOOP; END IF;  

			
				
			SET AUX = FncListaPrecioListarUnidadMedidas(OLD.ProId,OLD.RtiId,IFNULL(NEW.ProCosto,0),OLD.UmeId,IFNULL(P_LtiPorcentajeOtroCosto,0),IFNULL(P_LtiPorcentajeMargenUtilidad,0),IFNULL(P_LtiPorcentajeManoObra,0),IFNULL(NEW.ProPorcentajeAdicional,0),IFNULL(NEW.ProPorcentajeDescuento,0),P_LtiId);
		
	END LOOP CUR_LTI_LOOP;
	CLOSE CUR_LTI;

END IF;

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblpvdpagovehiculoingresodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_PVD`;
delimiter ;;
CREATE TRIGGER `TRG_I_PVD` AFTER INSERT ON `tblpvdpagovehiculoingresodetalle` FOR EACH ROW BEGIN

	IF NEW.PvdEstado = 3 THEN
		
		UPDATE tbleinvehiculoingreso SET EinCancelado = 1 WHERE EinId = NEW.EinId;
		
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblpvdpagovehiculoingresodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_PVD`;
delimiter ;;
CREATE TRIGGER `TRG_U_PVD` BEFORE UPDATE ON `tblpvdpagovehiculoingresodetalle` FOR EACH ROW BEGIN

	IF NEW.PvdEstado = 3 AND OLD.PvdEstado = 1 THEN
		
		UPDATE tbleinvehiculoingreso SET EinCancelado = 1 WHERE EinId = OLD.EinId;
	
	ELSEIF NEW.PvdEstado = 1 AND OLD.PvdEstado = 3 THEN
	
		UPDATE tbleinvehiculoingreso SET EinCancelado = 2 WHERE EinId = OLD.EinId;
	
	END IF;		
	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblpvdpagovehiculoingresodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_PVD`;
delimiter ;;
CREATE TRIGGER `TRG_D_PVD` AFTER DELETE ON `tblpvdpagovehiculoingresodetalle` FOR EACH ROW BEGIN
 
	IF OLD.PvdEstado = 3 THEN
			
		UPDATE tbleinvehiculoingreso SET EinCancelado = 2 WHERE EinId = OLD.EinId;
			
	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltadtrasladoalmacendetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_TAD`;
delimiter ;;
CREATE TRIGGER `TRG_I_TAD` AFTER INSERT ON `tbltadtrasladoalmacendetalle` FOR EACH ROW BEGIN

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_TedId VARCHAR(20);
DECLARE N_TedId VARCHAR(20);

DECLARE P_TsdId VARCHAR(20);
DECLARE N_TsdId VARCHAR(20);

DECLARE P_AmoEstadoIngreso TINYINT(1);
DECLARE P_AmoEstadoSalida TINYINT(1);

DECLARE P_AmoFechaIngreso DATE;
DECLARE P_AmoFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);


SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

SELECT AmoEstado INTO P_AmoEstadoIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AmoEstado INTO P_AmoEstadoSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

SELECT AmoFecha INTO P_AmoFechaIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AmoFecha INTO P_AmoFechaSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;


	SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TedId	FROM tblamdalmacenmovimientodetalle;
	IF P_TedId IS NULL OR P_TedId = "" THEN	SET N_TedId = "TED-10000"; ELSE	SET P_TedId = P_TedId + 1; SET N_TedId = CONCAT("TED-",P_TedId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TadId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdValorTotal,
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TedId, 
			P_AmoIdIngreso, 
			
			NULL,
			NEW.TadId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TadCantidad,
			NEW.TadCantidadReal,
			
			NEW.TadCosto,
			NEW.TadCosto,
			NEW.TadImporte,
			
			P_AlmIdIngreso,
			P_AmoFechaIngreso,			
			P_AmoEstadoIngreso,
			NOW(), 				
			NOW());

			
			SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TsdId	FROM tblamdalmacenmovimientodetalle;
			IF P_TsdId IS NULL OR P_TsdId = "" THEN	SET N_TsdId = "TSD-10000"; ELSE	SET P_TsdId = P_TsdId + 1; SET N_TsdId = CONCAT("TSD-",P_TsdId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TadId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TsdId, 
			P_AmoIdSalida, 
			
			NULL,
			NEW.TadId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TadCantidad,
			NEW.TadCantidadReal,
			
			NEW.TadCosto,
			NEW.TadImporte,
			
			P_AlmIdSalida,
			P_AmoFechaSalida,			
			P_AmoEstadoSalida,
			NOW(), 				
			NOW());



END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltadtrasladoalmacendetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_TAD`;
delimiter ;;
CREATE TRIGGER `TRG_D_TAD` BEFORE DELETE ON `tbltadtrasladoalmacendetalle` FOR EACH ROW BEGIN

	DELETE FROM tblamdalmacenmovimientodetalle WHERE TadId = OLD.TadId;
		
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltadtrasladoalmacendetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_TAD`;
delimiter ;;
CREATE TRIGGER `TRG_U_TAD` AFTER UPDATE ON `tbltadtrasladoalmacendetalle` FOR EACH ROW BEGIN

DECLARE P_TedId VARCHAR(20);
DECLARE N_TedId VARCHAR(20);

DECLARE P_TsdId VARCHAR(20);
DECLARE N_TsdId VARCHAR(20);

DECLARE P_AmdIdIngreso VARCHAR(20);
DECLARE P_AmdIdSalida VARCHAR(20);

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_AmoEstadoIngreso TINYINT(1);
DECLARE P_AmoEstadoSalida TINYINT(1);

DECLARE P_AmoFechaIngreso DATE;
DECLARE P_AmoFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);

SELECT AmdId INTO P_AmdIdIngreso FROM tblamdalmacenmovimientodetalle amd LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId
WHERE TadId = OLD.TadId AND amo.AmoTipo = 1;

SELECT AmdId INTO P_AmdIdSalida FROM tblamdalmacenmovimientodetalle amd LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId
WHERE TadId = OLD.TadId AND amo.AmoTipo = 2;

SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

SELECT AmoEstado INTO P_AmoEstadoIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AmoEstado INTO P_AmoEstadoSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

SELECT AmoFecha INTO P_AmoFechaIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AmoFecha INTO P_AmoFechaSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblamoalmacenmovimiento WHERE TalId = NEW.TalId AND AmoTipo = 2;

	IF P_AmdIdIngreso IS NULL OR P_AmdIdIngreso = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TedId	FROM tblamdalmacenmovimientodetalle;
		IF P_TedId IS NULL OR P_TedId = "" THEN	SET N_TedId = "TED-10000"; ELSE	SET P_TedId = P_TedId + 1; SET N_TedId = CONCAT("TED-",P_TedId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TadId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdValorTotal,
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,			
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TedId, 
			P_AmoIdIngreso, 
			
			NULL,
			NEW.TadId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TadCantidad,
			NEW.TadCantidadReal,
			
			NEW.TadCosto,
			NEW.TadCosto,
			NEW.TadImporte,
			
			P_AlmIdIngreso,
			P_AmoFechaIngreso,
			P_AmoEstadoIngreso,
			NOW(), 				
			NOW());

	ELSE	SET P_TsdId = P_TsdId + 1; 
		
		UPDATE tblamdalmacenmovimientodetalle SET
		ProId = NEW.ProId,
		UmeId = NEW.UmeId,

		AmdCantidad = NEW.TadCantidad,
		AmdCantidadReal =  NEW.TadCantidadReal,
	
		AmdValorTotal = NEW.TadCosto,
		AmdCosto = NEW.TadCosto,	
		AmdImporte = NEW.TadImporte,
		AmdEstado = P_AmoEstadoIngreso,
		
		AlmId = P_AlmIdIngreso,
		AmdFecha = P_AmoFechaIngreso,		
		AmdTiempoModificacion = NOW()
		WHERE AmdId = P_AmdIdIngreso;

	END IF;
	
	IF P_AmdIdSalida IS NULL OR P_AmdIdSalida = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TsdId	FROM tblamdalmacenmovimientodetalle;
			IF P_TsdId IS NULL OR P_TsdId = "" THEN	SET N_TsdId = "TSD-10000"; ELSE	SET P_TsdId = P_TsdId + 1; SET N_TsdId = CONCAT("TSD-",P_TsdId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TadId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TsdId, 
			P_AmoIdSalida, 
			
			NULL,
			NEW.TadId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TadCantidad,
			NEW.TadCantidadReal,
			
			NEW.TadCosto,
			NEW.TadImporte,
			
			P_AlmIdSalida,
			P_AmoFechaSalida,
			P_AmoEstadoSalida,
			NOW(), 				
			NOW());			

	ELSE	SET P_TsdId = P_TsdId + 1; 
		
		UPDATE tblamdalmacenmovimientodetalle SET

		ProId = NEW.ProId,
		UmeId = NEW.UmeId,

		AmdCantidad = NEW.TadCantidad,
		AmdCantidadReal =  NEW.TadCantidadReal,
	
		AmdValorTotal = NEW.TadCosto,
		AmdCosto = NEW.TadCosto,	
		AmdImporte = NEW.TadImporte,
		
		AlmId = P_AlmIdSalida,
		AmdFecha = P_AmoFechaSalida,
		AmdEstado = P_AmoEstadoSalida,		
		AmdTiempoModificacion = NOW()
		WHERE AmdId = P_AmdIdSalida;

	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltpdtrasladoproductodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_TPD`;
delimiter ;;
CREATE TRIGGER `TRG_I_TPD` AFTER INSERT ON `tbltpdtrasladoproductodetalle` FOR EACH ROW BEGIN

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_TedId VARCHAR(20);
DECLARE N_TedId VARCHAR(20);

DECLARE P_TsdId VARCHAR(20);
DECLARE N_TsdId VARCHAR(20);

DECLARE P_AmoEstadoIngreso TINYINT(1);
DECLARE P_AmoEstadoSalida TINYINT(1);

DECLARE P_AmoFechaIngreso DATE;
DECLARE P_AmoFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);


SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

SELECT AmoEstado INTO P_AmoEstadoIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AmoEstado INTO P_AmoEstadoSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

SELECT AmoFecha INTO P_AmoFechaIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AmoFecha INTO P_AmoFechaSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;


	INSERT INTO aux6(descripcion) VALUES( CONCAT( "TRG_I_TPD: P_AlmIdIngreso",IFNULL(P_AlmIdIngreso,"")," / P_AlmIdSalida:",IFNULL(P_AlmIdSalida,"")));
	
	
	
	

	SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TedId	FROM tblamdalmacenmovimientodetalle;
	IF P_TedId IS NULL OR P_TedId = "" THEN	SET N_TedId = "TED-10000"; ELSE	SET P_TedId = P_TedId + 1; SET N_TedId = CONCAT("TED-",P_TedId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TpdId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdValorTotal,
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TedId, 
			P_AmoIdIngreso, 
			
			NULL,
			NEW.TpdId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TpdCantidad,
			NEW.TpdCantidadReal,
			
			NEW.TpdCosto,
			NEW.TpdCosto,
			NEW.TpdImporte,
			
			P_AlmIdIngreso,
			P_AmoFechaIngreso,			
			P_AmoEstadoIngreso,
			NOW(), 				
			NOW());

			
			SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TsdId	FROM tblamdalmacenmovimientodetalle;
			IF P_TsdId IS NULL OR P_TsdId = "" THEN	SET N_TsdId = "TSD-10000"; ELSE	SET P_TsdId = P_TsdId + 1; SET N_TsdId = CONCAT("TSD-",P_TsdId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TpdId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TsdId, 
			P_AmoIdSalida, 
			
			NULL,
			NEW.TpdId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TpdCantidad,
			NEW.TpdCantidadReal,
			
			NEW.TpdCosto,
			NEW.TpdImporte,
			
			P_AlmIdSalida,
			P_AmoFechaSalida,			
			P_AmoEstadoSalida,
			NOW(), 				
			NOW());



END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltpdtrasladoproductodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_TPD`;
delimiter ;;
CREATE TRIGGER `TRG_D_TPD` BEFORE DELETE ON `tbltpdtrasladoproductodetalle` FOR EACH ROW BEGIN

	DELETE FROM tblamdalmacenmovimientodetalle WHERE TpdId = OLD.TpdId;
		
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltpdtrasladoproductodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_TPD`;
delimiter ;;
CREATE TRIGGER `TRG_U_TPD` AFTER UPDATE ON `tbltpdtrasladoproductodetalle` FOR EACH ROW BEGIN

DECLARE P_TedId VARCHAR(20);
DECLARE N_TedId VARCHAR(20);

DECLARE P_TsdId VARCHAR(20);
DECLARE N_TsdId VARCHAR(20);

DECLARE P_AmdIdIngreso VARCHAR(20);
DECLARE P_AmdIdSalida VARCHAR(20);

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_AmoEstadoIngreso TINYINT(1);
DECLARE P_AmoEstadoSalida TINYINT(1);

DECLARE P_AmoFechaIngreso DATE;
DECLARE P_AmoFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);

SELECT AmdId INTO P_AmdIdIngreso FROM tblamdalmacenmovimientodetalle amd LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId
WHERE TpdId = OLD.TpdId AND amo.AmoTipo = 1;

SELECT AmdId INTO P_AmdIdSalida FROM tblamdalmacenmovimientodetalle amd LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId
WHERE TpdId = OLD.TpdId AND amo.AmoTipo = 2;

SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

SELECT AmoEstado INTO P_AmoEstadoIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AmoEstado INTO P_AmoEstadoSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

SELECT AmoFecha INTO P_AmoFechaIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AmoFecha INTO P_AmoFechaSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblamoalmacenmovimiento WHERE TptId = NEW.TptId AND AmoTipo = 2;

	IF P_AmdIdIngreso IS NULL OR P_AmdIdIngreso = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TedId	FROM tblamdalmacenmovimientodetalle;
		IF P_TedId IS NULL OR P_TedId = "" THEN	SET N_TedId = "TED-10000"; ELSE	SET P_TedId = P_TedId + 1; SET N_TedId = CONCAT("TED-",P_TedId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TpdId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdValorTotal,
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,			
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TedId, 
			P_AmoIdIngreso, 
			
			NULL,
			NEW.TpdId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TpdCantidad,
			NEW.TpdCantidadReal,
			
			NEW.TpdCosto,
			NEW.TpdCosto,
			NEW.TpdImporte,
			
			P_AlmIdIngreso,
			P_AmoFechaIngreso,
			P_AmoEstadoIngreso,
			NOW(), 				
			NOW());

	ELSE	SET P_TsdId = P_TsdId + 1; 
		
		UPDATE tblamdalmacenmovimientodetalle SET
		ProId = NEW.ProId,
		UmeId = NEW.UmeId,

		AmdCantidad = NEW.TpdCantidad,
		AmdCantidadReal =  NEW.TpdCantidadReal,
	
		AmdValorTotal = NEW.TpdCosto,
		AmdCosto = NEW.TpdCosto,	
		AmdImporte = NEW.TpdImporte,
		AmdEstado = P_AmoEstadoIngreso,
		
		AlmId = P_AlmIdIngreso,
		AmdFecha = P_AmoFechaIngreso,		
		AmdTiempoModificacion = NOW()
		WHERE AmdId = P_AmdIdIngreso;

	END IF;
	
	IF P_AmdIdSalida IS NULL OR P_AmdIdSalida = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) INTO P_TsdId	FROM tblamdalmacenmovimientodetalle;
			IF P_TsdId IS NULL OR P_TsdId = "" THEN	SET N_TsdId = "TSD-10000"; ELSE	SET P_TsdId = P_TsdId + 1; SET N_TsdId = CONCAT("TSD-",P_TsdId); END IF;

			INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 
			
			AmdIdOrigen,
			TpdId,
			
			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdCosto,
			AmdImporte,
			
			AlmId,
			AmdFecha,
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			N_TsdId, 
			P_AmoIdSalida, 
			
			NULL,
			NEW.TpdId,
			
			NEW.ProId,
			NEW.UmeId,
			
			NEW.TpdCantidad,
			NEW.TpdCantidadReal,
			
			NEW.TpdCosto,
			NEW.TpdImporte,
			
			P_AlmIdSalida,
			P_AmoFechaSalida,
			P_AmoEstadoSalida,
			NOW(), 				
			NOW());			

	ELSE	SET P_TsdId = P_TsdId + 1; 
		
		UPDATE tblamdalmacenmovimientodetalle SET

		ProId = NEW.ProId,
		UmeId = NEW.UmeId,

		AmdCantidad = NEW.TpdCantidad,
		AmdCantidadReal =  NEW.TpdCantidadReal,
	
		AmdValorTotal = NEW.TpdCosto,
		AmdCosto = NEW.TpdCosto,	
		AmdImporte = NEW.TpdImporte,
		
		AlmId = P_AlmIdSalida,
		AmdFecha = P_AmoFechaSalida,
		AmdEstado = P_AmoEstadoSalida,		
		AmdTiempoModificacion = NOW()
		WHERE AmdId = P_AmdIdSalida;

	END IF;
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltpttrasladoproducto
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_TPT`;
delimiter ;;
CREATE TRIGGER `TRG_I_TPT` AFTER INSERT ON `tbltpttrasladoproducto` FOR EACH ROW BEGIN

DECLARE P_TaeId VARCHAR(20);
DECLARE N_TaeId VARCHAR(20);

DECLARE P_TasId VARCHAR(20);
DECLARE N_TasId VARCHAR(20);

DECLARE P_TptEstado TINYINT(1);
DECLARE P_TptFechaLlegada VARCHAR(10);

DECLARE P_AlmId_E VARCHAR(20);
DECLARE P_AlmId_S VARCHAR(20);

	SELECT IFNULL(AlmId,"") INTO P_AlmId_E FROM tblalmalmacen WHERE SucId = NEW.SucIdDestino;
	SELECT IFNULL(AlmId,"") INTO P_AlmId_S FROM tblalmalmacen WHERE SucId = NEW.SucId;

	IF NEW.TptFechaLlegada IS NULL  THEN	
	
		SET  P_TptEstado = 1;
		SET  P_TptFechaLlegada = NEW.TptFecha;
		
	ELSE
		
		SET P_TptEstado = NEW.TptEstado;
		SET P_TptFechaLlegada = NEW.TptFechaLlegada;
		
	END IF;
	
		SELECT MAX(CONVERT(SUBSTR(AmoId,5),unsigned)) INTO P_TaeId	FROM tblamoalmacenmovimiento;
		IF P_TaeId IS NULL OR P_TaeId = "" THEN	SET N_TaeId = "TPE-10000"; ELSE	SET P_TaeId = P_TaeId + 1; SET N_TaeId = CONCAT("TPE-",P_TaeId); END IF;

				
		INSERT INTO aux6(descripcion) VALUES( CONCAT( "TRG_I_TPT: P_AlmId_E: ",IFNULL(P_AlmId_E,"")," / P_AlmId_S:",IFNULL(P_AlmId_S,"")," / NEW.SucIdDestino: ",IFNULL(NEW.SucIdDestino,"")," / NEW.SucId: ",IFNULL(NEW.SucId,"")));
	
		
		
		INSERT INTO tblamoalmacenmovimiento (
		AmoId,
		SucId,
		SucIdDestino,
		
		TptId,
		PprId,
		
		PerId, 
		PrvId,
		AlmId,
		
		TopId,
		CtiId,
		
		AmoIdOrigen,
		
		AmoComprobanteNumero,
		AmoComprobanteFecha,
		
		AmoFecha,
		AmoPorcentajeImpuestoVenta,
		
		AmoIncluyeImpuesto,
		
		AmoSubTotal,
		AmoImpuesto,
		AmoTotal,		
		
		AmoObservacion,
		
		MonId,
		AmoTipoCambio,	
		
		AmoFoto,
		AmoEstado,
		
		AmoTipo,
		AmoSubTipo,
		
		AmoTiempoCreacion,
		AmoTiempoModificacion
		
		) 
		VALUES (
		N_TaeId, 
		NEW.SucIdDestino,
		NULL,
		
		NEW.TptId, 
		NULL,
		
		NEW.PerId,
		NEW.PrvId,
		P_AlmId_E,
		
		NEW.TopId,
		NEW.CtiId,
		
		NULL,
		
		NEW.TptReferencia,
		NEW.TptReferenciaFecha,
		
		P_TptFechaLlegada,
		NEW.TptPorcentajeImpuestoVenta,
		
		NEW.TptIncluyeImpuesto,

		0,
		0,
		0,
		
		NEW.TptObservacion,

		NEW.MonId,
		NEW.TptTipoCambio,

		NEW.TptFoto,
		P_TptEstado,
		
		1,
		6,
		
		NOW(), 
		NOW());
	
	
	
	
	
		SELECT MAX(CONVERT(SUBSTR(AmoId,5),unsigned)) INTO P_TasId	FROM tblamoalmacenmovimiento;
		IF P_TasId IS NULL OR P_TasId = "" THEN	SET N_TasId = "TPS-10000"; ELSE	SET P_TasId = P_TasId + 1; SET N_TasId = CONCAT("TPS-",P_TasId); END IF;

		INSERT INTO tblamoalmacenmovimiento (
		AmoId,
		SucId,
		SucIdDestino,
		
		TptId,
		PprId,
		
		PerId, 
		CliId,
		AlmId,
		
		TopId,
		CtiId,
		
		AmoIdOrigen,
		
		AmoComprobanteNumero,
		AmoComprobanteFecha,
		
		AmoFecha,
		AmoPorcentajeImpuestoVenta,
		
		AmoIncluyeImpuesto,
		
		AmoSubTotal,
		AmoImpuesto,
		AmoTotal,		
		
		AmoObservacion,
		
		MonId,
		AmoTipoCambio,	
		
		AmoFoto,
		AmoEstado,

		AmoTipo,
		AmoSubTipo,
		
		AmoTiempoCreacion,
		AmoTiempoModificacion

		) 
		VALUES (
		N_TasId, 
		
		NEW.SucId,
		NULL,
		
		NEW.TptId, 
		NULL,
		
		NEW.PerId,
		NEW.CliId,
		P_AlmId_S,

		NEW.TopId,
		NEW.CtiId,

		NULL,

		NEW.TptReferencia,
		NEW.TptReferenciaFecha,

		NEW.TptFecha,
		NEW.TptPorcentajeImpuestoVenta,

		NEW.TptIncluyeImpuesto,

		0,
		0,
		0,

		NEW.TptObservacion,

		NEW.MonId,
		NEW.TptTipoCambio,

		NEW.TptFoto,
		NEW.TptEstado,

		2,
		6,

		NOW(), 
		NOW());
		
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltpttrasladoproducto
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_TPT`;
delimiter ;;
CREATE TRIGGER `TRG_U_TPT` AFTER UPDATE ON `tbltpttrasladoproducto` FOR EACH ROW BEGIN

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

DECLARE P_TptEstado TINYINT(1);
DECLARE P_TptFechaLlegada VARCHAR(10);

SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE TptId = OLD.TptId AND AmoTipo = 1 ORDER BY AmoTiempoCreacion DESC LIMIT 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE TptId = OLD.TptId AND AmoTipo = 2  ORDER BY AmoTiempoCreacion DESC LIMIT 1;

	IF OLD.TptFechaLlegada IS NULL AND NEW.TptFechaLlegada IS NOT NULL THEN	
	
		SET P_TptEstado = 3;
		SET P_TptFechaLlegada = NEW.TptFechaLlegada;
		
	ELSE
		
		IF OLD.TptFechaLlegada IS NOT NULL AND NEW.TptFechaLlegada IS NULL  THEN
		
			SET P_TptEstado = 1;
			SET P_TptFechaLlegada = NEW.TptFecha;
			
		ELSE
		
			SET P_TptEstado = NEW.TptEstado;
			SET P_TptFechaLlegada = NEW.TptFechaLlegada;
			
		END IF;
		
		
	END IF;
	
	
	UPDATE tblamoalmacenmovimiento SET 
				
	PerId = NEW.PerId,
	PrvId = NEW.PrvId,
	SucId = NEW.SucIdDestino,
	
	AmoComprobanteNumero = NEW.TptReferencia,
	AmoComprobanteFecha = NEW.TptReferenciaFecha,
	
	AmoFecha = P_TptFechaLlegada,
	AmoPorcentajeImpuestoVenta = NEW.TptPorcentajeImpuestoVenta,
	
	MonId = NEW.MonId,
	AmoTipoCambio = NEW.TptTipoCambio,
	
	AmoIncluyeImpuesto = NEW.TptIncluyeImpuesto,
	
	AmoFoto = NEW.TptFoto,
	AmoSubTotal = 0,
	AmoImpuesto = 0,
	AmoTotal = 0,
	AmoObservacion = NEW.TptIncluyeImpuesto,
	
	AmoEstado = P_TptEstado,
	AmoTiempoModificacion = NOW()			
	
	WHERE AmoId = P_AmoIdIngreso;

	
	UPDATE tblamoalmacenmovimiento SET 

	PerId = NEW.PerId,
	CliId = NEW.CliId,
	SucId = NEW.SucId,
	
	AmoComprobanteNumero = NEW.TptReferencia,
	AmoComprobanteFecha = NEW.TptReferenciaFecha,
			
	AmoFecha = NEW.TptFecha,
	AmoPorcentajeImpuestoVenta = NEW.TptPorcentajeImpuestoVenta,
			
	MonId = NEW.MonId,
	AmoTipoCambio = NEW.TptTipoCambio,
			
	AmoIncluyeImpuesto = NEW.TptIncluyeImpuesto,
			
	AmoFoto = NEW.TptFoto,
	AmoSubTotal = 0,
	AmoImpuesto = 0,
	AmoTotal = 0,
	AmoObservacion = NEW.TptIncluyeImpuesto,

	AmoEstado = NEW.TptEstado,
	AmoTiempoModificacion = NOW()			

	WHERE AmoId = P_AmoIdSalida;

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltpttrasladoproducto
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_TPT`;
delimiter ;;
CREATE TRIGGER `TRG_D_TPT` BEFORE DELETE ON `tbltpttrasladoproducto` FOR EACH ROW BEGIN

DECLARE P_AmoIdIngreso VARCHAR(20);
DECLARE P_AmoIdSalida VARCHAR(20);

SELECT AmoId INTO P_AmoIdIngreso FROM tblamoalmacenmovimiento WHERE TptId = OLD.TptId AND AmoTipo = 1 ORDER BY AmoTiempoCreacion DESC LIMIT 1;
SELECT AmoId INTO P_AmoIdSalida FROM tblamoalmacenmovimiento WHERE TptId = OLD.TptId AND AmoTipo = 2 ORDER BY AmoTiempoCreacion DESC LIMIT 1;
	
	DELETE FROM tblamdalmacenmovimientodetalle WHERE AmoId = P_AmoIdSalida;
	DELETE FROM tblamdalmacenmovimientodetalle WHERE AmoId = P_AmoIdIngreso;
		
	DELETE FROM tblamoalmacenmovimiento WHERE AmoId = P_AmoIdSalida;
	DELETE FROM tblamoalmacenmovimiento WHERE AmoId = P_AmoIdIngreso;	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltvdtrasladovehiculodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_TVD`;
delimiter ;;
CREATE TRIGGER `TRG_I_TVD` AFTER INSERT ON `tbltvdtrasladovehiculodetalle` FOR EACH ROW BEGIN


DECLARE P_VmvIdIngreso VARCHAR(20);
DECLARE P_VmvIdSalida VARCHAR(20);

DECLARE P_TedId VARCHAR(20);
DECLARE N_TedId VARCHAR(20);

DECLARE P_TsdId VARCHAR(20);
DECLARE N_TsdId VARCHAR(20);

DECLARE P_VmvEstadoIngreso TINYINT(1);
DECLARE P_VmvEstadoSalida TINYINT(1);

DECLARE P_VmvFechaIngreso DATE;
DECLARE P_VmvFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);

DECLARE P_SucIdDestino VARCHAR(20);
DECLARE P_SucId VARCHAR(20);


 
SELECT VmvId INTO P_VmvIdIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT VmvId INTO P_VmvIdSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT VmvEstado INTO P_VmvEstadoIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT VmvEstado INTO P_VmvEstadoSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT VmvFecha INTO P_VmvFechaIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT VmvFecha INTO P_VmvFechaSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT SucId INTO P_SucIdDestino FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT SucId INTO P_SucId FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;



	SELECT MAX(CONVERT(SUBSTR(VmdId,5),unsigned)) INTO P_TedId	FROM tblvmdvehiculomovimientodetalle;
	IF P_TedId IS NULL OR P_TedId = "" THEN	SET N_TedId = "VMD-10000"; ELSE	SET P_TedId = P_TedId + 1; SET N_TedId = CONCAT("VMD-",P_TedId); END IF;
			
			
			INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("TRG_I_TVD:::","N_TedId: ",N_TedId) ,NOW());
									
			INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("P_SucIdDestino: ",P_SucIdDestino,"P_SucId: ",P_SucId) ,NOW());
		
		
			UPDATE tbleinvehiculoingreso SET SucId = P_SucIdDestino WHERE EinId = NEW.EinId;
				
				
			INSERT INTO tblvmdvehiculomovimientodetalle (
			VmdId,
			VmvId, 
			
			TvdId,
			
			EinId,
			VehId,			
			UmeId,			

			VmdCantidad,	
			
			VmdCosto,
			VmdImporte,
			
			AlmId,
			VmdFecha,
			VmdEstado,
			VmdTiempoCreacion,
			VmdTiempoModificacion
			) 
			VALUES (
			N_TedId, 
			P_VmvIdIngreso, 
			
			NEW.TvdId,

			NEW.EinId,			
			NEW.VehId,
			NEW.UmeId,
			
			NEW.TvdCantidad,
		
			NEW.TvdCosto,
			NEW.TvdImporte,
			
			P_AlmIdIngreso,
			P_VmvFechaIngreso,			
			P_VmvEstadoIngreso,
			NOW(), 				
			NOW());

			
			SELECT MAX(CONVERT(SUBSTR(VmdId,5),unsigned)) INTO P_TsdId	FROM tblvmdvehiculomovimientodetalle;
			IF P_TsdId IS NULL OR P_TsdId = "" THEN	SET N_TsdId = "VMD-10000"; ELSE	SET P_TsdId = P_TsdId + 1; SET N_TsdId = CONCAT("VMD-",P_TsdId); END IF;
	
	
			INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("TRG_I_TVD:::","N_TsdId: ",N_TsdId) ,NOW());
	
	
			INSERT INTO tblvmdvehiculomovimientodetalle (
			VmdId,
			VmvId, 
			
			TvdId,
			
			EinId,
			VehId,
			UmeId,			

			VmdCantidad,	
			
			VmdCosto,
			VmdImporte,
			
			AlmId,
			VmdFecha,
			VmdEstado,
			VmdTiempoCreacion,
			VmdTiempoModificacion
			) 
			VALUES (
			N_TsdId, 
			P_VmvIdSalida, 
			
			NEW.TvdId,
			
			NEW.EinId,
			NEW.VehId,
			NEW.UmeId,
			
			NEW.TvdCantidad,
		
			NEW.TvdCosto,
			NEW.TvdImporte,
			
			P_AlmIdSalida,
			P_VmvFechaSalida,			
			P_VmvEstadoSalida,
			NOW(), 				
			NOW());

	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltvdtrasladovehiculodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_TVD`;
delimiter ;;
CREATE TRIGGER `TRG_D_TVD` BEFORE DELETE ON `tbltvdtrasladovehiculodetalle` FOR EACH ROW BEGIN

DECLARE P_SucId VARCHAR(20);
DECLARE P_SucIdDestino VARCHAR(20);

DECLARE P_TveEstado TINYINT(1);

SELECT IFNULL(SucId,"") INTO P_SucId FROM tbltvetrasladovehiculo WHERE TveId = OLD.TveId;
SELECT IFNULL(SucIdDestino,"") INTO P_SucIdDestino FROM tbltvetrasladovehiculo WHERE TveId = OLD.TveId;
	
	DELETE FROM tblvmdvehiculomovimientodetalle WHERE TvdId = OLD.TvdId;
	
	IF OLD.TvdEstado = 3 THEN
	
		UPDATE  tbleinvehiculoingreso
		SET SucId = P_SucId
		WHERE EinId = OLD.EinId;


	END IF;

	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltvdtrasladovehiculodetalle
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_TVD`;
delimiter ;;
CREATE TRIGGER `TRG_U_TVD` AFTER UPDATE ON `tbltvdtrasladovehiculodetalle` FOR EACH ROW BEGIN


DECLARE P_TedId VARCHAR(20);
DECLARE N_TedId VARCHAR(20);

DECLARE P_TsdId VARCHAR(20);
DECLARE N_TsdId VARCHAR(20);

DECLARE P_VmdIdIngreso VARCHAR(20);
DECLARE P_VmdIdSalida VARCHAR(20);

DECLARE P_VmvIdIngreso VARCHAR(20);
DECLARE P_VmvIdSalida VARCHAR(20);

DECLARE P_VmvEstadoIngreso TINYINT(1);
DECLARE P_VmvEstadoSalida TINYINT(1);

DECLARE P_VmvFechaIngreso DATE;
DECLARE P_VmvFechaSalida DATE;

DECLARE P_AlmIdIngreso VARCHAR(20);
DECLARE P_AlmIdSalida VARCHAR(20);

SELECT VmdId INTO P_VmdIdIngreso FROM tblvmdvehiculomovimientodetalle amd LEFT JOIN tblvmvvehiculomovimiento amo ON amd.VmvId = amo.VmvId
WHERE TvdId = OLD.TvdId AND amo.VmvTipo = 1;

SELECT VmdId INTO P_VmdIdSalida FROM tblvmdvehiculomovimientodetalle amd LEFT JOIN tblvmvvehiculomovimiento amo ON amd.VmvId = amo.VmvId
WHERE TvdId = OLD.TvdId AND amo.VmvTipo = 2;

SELECT VmvId INTO P_VmvIdIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT VmvId INTO P_VmvIdSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT VmvEstado INTO P_VmvEstadoIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT VmvEstado INTO P_VmvEstadoSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT VmvFecha INTO P_VmvFechaIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT VmvFecha INTO P_VmvFechaSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

SELECT AlmId INTO P_AlmIdIngreso FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 1;
SELECT AlmId INTO P_AlmIdSalida FROM tblvmvvehiculomovimiento WHERE TveId = NEW.TveId AND VmvTipo = 2;

	IF P_VmdIdIngreso IS NULL OR P_VmdIdIngreso = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(VmdId,5),unsigned)) INTO P_TedId	FROM tblvmdvehiculomovimientodetalle;
		IF P_TedId IS NULL OR P_TedId = "" THEN	SET N_TedId = "VMD-10000"; ELSE	SET P_TedId = P_TedId + 1; SET N_TedId = CONCAT("VMD-",P_TedId); END IF;
			
			
			UPDATE tbleinvehiculoingreso SET SucId = P_SucIdDestino WHERE EinId = NEW.EinId;
			
				
			INSERT INTO tblvmdvehiculomovimientodetalle (
			VmdId,
			VmvId, 
			
			TvdId,
			
			EinId,
			VehId,
			UmeId,			

			VmdCantidad,	
		
			VmdCosto,
			VmdImporte,
			
			AlmId,
			VmdFecha,			
			VmdEstado,
			VmdTiempoCreacion,
			VmdTiempoModificacion
			) 
			VALUES (
			N_TedId, 
			P_VmvIdIngreso, 
			
			NEW.TvdId,
			
			NEW.EinId,
			NEW.VehId,
			NEW.UmeId,
			
			NEW.TvdCantidad,
			
			NEW.TvdCosto,
			NEW.TvdImporte,
			
			P_AlmIdIngreso,
			P_VmvFechaIngreso,
			P_VmvEstadoIngreso,
			NOW(), 				
			NOW());

	ELSE	SET P_TsdId = P_TsdId + 1; 
		
		UPDATE tblvmdvehiculomovimientodetalle SET
		
		EinId = NEW.EinId,
		VehId = NEW.VehId,
		UmeId = NEW.UmeId,

		VmdCantidad = NEW.TvdCantidad,
		
		VmdCosto = NEW.TvdCosto,	
		VmdImporte = NEW.TvdImporte,
		VmdEstado = P_VmvEstadoIngreso,
		
		AlmId = P_AlmIdIngreso,
		VmdFecha = P_VmvFechaIngreso,		
		VmdTiempoModificacion = NOW()
		WHERE VmdId = P_VmdIdIngreso;

	END IF;
	
	IF P_VmdIdSalida IS NULL OR P_VmdIdSalida = "" THEN	

		SELECT MAX(CONVERT(SUBSTR(VmdId,5),unsigned)) INTO P_TsdId	FROM tblvmdvehiculomovimientodetalle;
			IF P_TsdId IS NULL OR P_TsdId = "" THEN	SET N_TsdId = "VMD-10000"; ELSE	SET P_TsdId = P_TsdId + 1; SET N_TsdId = CONCAT("VMD-",P_TsdId); END IF;

			INSERT INTO tblvmdvehiculomovimientodetalle (
			VmdId,
			VmvId, 
			
			TvdId,
			
			EinId,
			VehId,
			UmeId,			

			VmdCantidad,	

			VmdCosto,
			VmdImporte,
			
			AlmId,
			VmdFecha,
			VmdEstado,
			VmdTiempoCreacion,
			VmdTiempoModificacion
			) 
			VALUES (
			N_TsdId, 
			P_VmvIdSalida, 
			
			NEW.TvdId,
			
			NEW.EinId,
			NEW.VehId,
			NEW.UmeId,
			
			NEW.TvdCantidad,
			
			NEW.TvdCosto,
			NEW.TvdImporte,
			
			P_AlmIdSalida,
			P_VmvFechaSalida,
			P_VmvEstadoSalida,
			NOW(), 				
			NOW());			

	ELSE	SET P_TsdId = P_TsdId + 1; 
		
		UPDATE tblvmdvehiculomovimientodetalle SET

		EinId = NEW.EinId,
		VehId = NEW.VehId,
		UmeId = NEW.UmeId,

		VmdCantidad = NEW.TvdCantidad,
		VmdCosto = NEW.TvdCosto,	
		VmdImporte = NEW.TvdImporte,
		
		AlmId = P_AlmIdSalida,
		VmdFecha = P_VmvFechaSalida,
		VmdEstado = P_VmvEstadoSalida,		
		VmdTiempoModificacion = NOW()
		WHERE VmdId = P_VmdIdSalida;

	END IF;

	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltvetrasladovehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_TVE`;
delimiter ;;
CREATE TRIGGER `TRG_I_TVE` AFTER INSERT ON `tbltvetrasladovehiculo` FOR EACH ROW BEGIN

DECLARE P_TaeId VARCHAR(20);
DECLARE N_TaeId VARCHAR(20);

DECLARE P_TasId VARCHAR(20);
DECLARE N_TasId VARCHAR(20);

DECLARE P_TveEstado TINYINT(1);
DECLARE P_TveFechaLlegada VARCHAR(10);

	IF NEW.TveFechaLlegada IS NULL  THEN	
	
		SET  P_TveEstado = 1;
		SET  P_TveFechaLlegada = NEW.TveFecha;
		
	ELSE
		
		SET P_TveEstado = NEW.TveEstado;
		SET P_TveFechaLlegada = NEW.TveFechaLlegada;
		
	END IF;
	
		SELECT MAX(CONVERT(SUBSTR(VmvId,5),unsigned)) INTO P_TaeId	FROM tblvmvvehiculomovimiento;
		IF P_TaeId IS NULL OR P_TaeId = "" THEN	SET N_TaeId = "VME-10000"; ELSE	SET P_TaeId = P_TaeId + 1; SET N_TaeId = CONCAT("VME-",P_TaeId); END IF;

		
		INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("SucId: ",NEW.SucId," SucIdDestino: ",NEW.SucIdDestino) ,NOW());
		 
		INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("TRG_I_TVE:::","N_TaeId: ",N_TaeId) ,NOW());
		
		
		
		INSERT INTO tblvmvvehiculomovimiento (
		VmvId,
		SucId,
		
		TveId,
		
		PerId, 
		PrvId,
		AlmId,
		
		TopId,
		CtiId,
		
		VmvComprobanteNumero,
		VmvComprobanteFecha,
		
		VmvFecha,
		VmvPorcentajeImpuestoVenta,
		VmvIncluyeImpuesto,
		
		VmvSubTotal,
		VmvImpuesto,
		VmvTotal,		
		
		VmvObservacion,
		
		MonId,
		VmvTipoCambio,	
		
		VmvFoto,
		VmvEstado,
		
		VmvTipo,
		VmvSubTipo,
		
		VmvTiempoCreacion,
		VmvTiempoModificacion
		
		) 
		VALUES (
		N_TaeId, 
		NEW.SucIdDestino,
		
		NEW.TveId, 
		
		NEW.PerId,
		NEW.PrvId,
		NEW.AlmIdDestino,
		
		NEW.TopId,
		NEW.CtiId,
		
		
		NEW.TveComprobanteNumero,
		NEW.TveComprobanteFecha,
		
		P_TveFechaLlegada,
		NEW.TvePorcentajeImpuestoVenta,
		NEW.TveIncluyeImpuesto,

		0,
		0,
		0,
		
		CONCAT(IFNULL(NEW.TveObservacionInterna,"")," ","Registro automatico de entrada vehicular"),

		NEW.MonId,
		NEW.TveTipoCambio,

		NEW.TveFoto,
		P_TveEstado,
		
		1,
		6,
		
		NOW(), 
		NOW());
	
		SELECT MAX(CONVERT(SUBSTR(VmvId,5),unsigned)) INTO P_TasId	FROM tblvmvvehiculomovimiento;
		IF P_TasId IS NULL OR P_TasId = "" THEN	SET N_TasId = "VMS-10000"; ELSE	SET P_TasId = P_TasId + 1; SET N_TasId = CONCAT("VMS-",P_TasId); END IF;

		INSERT INTO aux666(descripcion,tiempo) VALUES( CONCAT("TRG_I_TVE:::","N_TasId: ",N_TasId) ,NOW());
		
		INSERT INTO tblvmvvehiculomovimiento (
		VmvId,
		SucId,
		
		TveId,
		
		PerId, 
		CliId,
		AlmId,
		
		TopId,
		CtiId,
	
		VmvComprobanteNumero,
		VmvComprobanteFecha,
		
		VmvFecha,
		VmvPorcentajeImpuestoVenta,
		VmvIncluyeImpuesto,
		
		VmvSubTotal,
		VmvImpuesto,
		VmvTotal,		
		
		VmvObservacion,
		
		MonId,
		VmvTipoCambio,	
		
		VmvFoto,
		VmvEstado,

		VmvTipo,
		VmvSubTipo,
		
		VmvTiempoCreacion,
		VmvTiempoModificacion

		) 
		VALUES (
		N_TasId, 
		NEW.SucId, 
	
		NEW.TveId, 
	
		NEW.PerId,
		NEW.CliId,
		NEW.AlmId,

		NEW.TopId,
		NEW.CtiId,


		NEW.TveComprobanteNumero,
		NEW.TveComprobanteFecha,

		NEW.TveFecha,
		NEW.TvePorcentajeImpuestoVenta,

		NEW.TveIncluyeImpuesto,

		0,
		0,
		0,

		CONCAT(IFNULL(NEW.TveObservacionInterna,"")," ","Registro automatico de salida vehicular"),
		
		NEW.MonId,
		NEW.TveTipoCambio,

		NEW.TveFoto,
		NEW.TveEstado,

		2,
		6,

		NOW(), 
		NOW());
		
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltvetrasladovehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_TVE`;
delimiter ;;
CREATE TRIGGER `TRG_U_TVE` AFTER UPDATE ON `tbltvetrasladovehiculo` FOR EACH ROW BEGIN

DECLARE P_VmvIdIngreso VARCHAR(20);
DECLARE P_VmvIdSalida VARCHAR(20);

DECLARE P_TveEstado TINYINT(1);
DECLARE P_TveFechaLlegada VARCHAR(10);

SELECT VmvId INTO P_VmvIdIngreso FROM tblvmvvehiculomovimiento WHERE TveId = OLD.TveId AND VmvTipo = 1 ORDER BY VmvTiempoCreacion DESC LIMIT 1;
SELECT VmvId INTO P_VmvIdSalida FROM tblvmvvehiculomovimiento WHERE TveId = OLD.TveId AND VmvTipo = 2  ORDER BY VmvTiempoCreacion DESC LIMIT 1;

	IF OLD.TveFechaLlegada IS NULL AND NEW.TveFechaLlegada IS NOT NULL THEN	
	
		SET P_TveEstado = 3;
		SET P_TveFechaLlegada = NEW.TveFechaLlegada;
		
	ELSE
		
		IF OLD.TveFechaLlegada IS NOT NULL AND NEW.TveFechaLlegada IS NULL  THEN
		
			SET P_TveEstado = 1;
			SET P_TveFechaLlegada = NEW.TveFecha;
			
		ELSE
		
			SET P_TveEstado = NEW.TveEstado;
			SET P_TveFechaLlegada = NEW.TveFechaLlegada;
			
		END IF;
		
		
	END IF;
	
	
	UPDATE tblvmvvehiculomovimiento SET 
				
	PerId = NEW.PerId,

	PrvId = NEW.PrvId,
	AlmId = NEW.AlmIdDestino,
	
	VmvComprobanteNumero = NEW.TveComprobanteNumero,
	VmvComprobanteFecha = NEW.TveComprobanteFecha,
	
	VmvFecha = P_TveFechaLlegada,
	VmvPorcentajeImpuestoVenta = NEW.TvePorcentajeImpuestoVenta,
	
	MonId = NEW.MonId,
	VmvTipoCambio = NEW.TveTipoCambio,
	
	VmvIncluyeImpuesto = NEW.TveIncluyeImpuesto,
	
	VmvFoto = NEW.TveFoto,
	VmvSubTotal = 0,
	VmvImpuesto = 0,
	VmvTotal = 0,
	VmvObservacion = IFNULL(NEW.TveObservacionInterna,""),
	
	VmvEstado = P_TveEstado,
	VmvTiempoModificacion = NOW()			
	
	WHERE VmvId = P_VmvIdIngreso;

	
	UPDATE tblvmvvehiculomovimiento SET 

	PerId = NEW.PerId,
			
	CliId = NEW.CliId,
	AlmId = NEW.AlmId,
			
	VmvComprobanteNumero = NEW.TveComprobanteNumero,
	VmvComprobanteFecha = NEW.TveComprobanteFecha,
			
	VmvFecha = NEW.TveFecha,
	
			
	MonId = NEW.MonId,
	VmvTipoCambio = NEW.TveTipoCambio,
			
	VmvIncluyeImpuesto = NEW.TveIncluyeImpuesto,
	VmvPorcentajeImpuestoVenta = NEW.TvePorcentajeImpuestoVenta,
	
	VmvFoto = NEW.TveFoto,
	VmvSubTotal = 0,
	VmvImpuesto = 0,
	VmvTotal = 0,
	VmvObservacion = IFNULL(NEW.TveObservacionInterna,""),

	VmvEstado = NEW.TveEstado,
	VmvTiempoModificacion = NOW()			

	WHERE VmvId = P_VmvIdSalida;

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tbltvetrasladovehiculo
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_TVE`;
delimiter ;;
CREATE TRIGGER `TRG_D_TVE` BEFORE DELETE ON `tbltvetrasladovehiculo` FOR EACH ROW BEGIN

DECLARE P_VmvIdIngreso VARCHAR(20);
DECLARE P_VmvIdSalida VARCHAR(20);

SELECT VmvId INTO P_VmvIdIngreso FROM tblvmvvehiculomovimiento WHERE TveId = OLD.TveId AND VmvTipo = 1 ORDER BY VmvTiempoCreacion DESC LIMIT 1;
SELECT VmvId INTO P_VmvIdSalida FROM tblvmvvehiculomovimiento WHERE TveId = OLD.TveId AND VmvTipo = 2 ORDER BY VmvTiempoCreacion DESC LIMIT 1;
	
	DELETE FROM tblvmdvehiculomovimientodetalle WHERE VmvId = P_VmvIdSalida;
	DELETE FROM tblvmdvehiculomovimientodetalle WHERE VmvId = P_VmvIdIngreso;
		
	DELETE FROM tblvmvvehiculomovimiento WHERE VmvId = P_VmvIdSalida;
	DELETE FROM tblvmvvehiculomovimiento WHERE VmvId = P_VmvIdIngreso;	
	
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblvicvehiculoingresocliente
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_I_VIC`;
delimiter ;;
CREATE TRIGGER `TRG_I_VIC` AFTER INSERT ON `tblvicvehiculoingresocliente` FOR EACH ROW BEGIN

DECLARE P_CliId VARCHAR(20);

SELECT  
vic.CliId
INTO P_CliId FROM tblvicvehiculoingresocliente vic 
WHERE vic.EinId = NEW.EinId 
AND vic.VicEstado = 1
ORDER BY vic.VicFecha DESC,vic.VicEstado ASC LIMIT 1;
					
		UPDATE tbleinvehiculoingreso
		SET CliId = P_CliId
		WHERE EinId = NEW.EinId;
	

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblvicvehiculoingresocliente
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_U_VIC`;
delimiter ;;
CREATE TRIGGER `TRG_U_VIC` BEFORE UPDATE ON `tblvicvehiculoingresocliente` FOR EACH ROW BEGIN

DECLARE P_CliId VARCHAR(20);

SELECT  
vic.CliId
INTO P_CliId FROM tblvicvehiculoingresocliente vic 
WHERE vic.EinId = OLD.EinId 
AND vic.VicEstado = 1 ORDER BY vic.VicFecha DESC, vic.VicEstado ASC LIMIT 1;
					



		UPDATE tbleinvehiculoingreso
		SET CliId = P_CliId
		WHERE EinId = OLD.EinId;

END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table tblvicvehiculoingresocliente
-- ----------------------------
DROP TRIGGER IF EXISTS `TRG_D_VIC`;
delimiter ;;
CREATE TRIGGER `TRG_D_VIC` AFTER DELETE ON `tblvicvehiculoingresocliente` FOR EACH ROW BEGIN

DECLARE P_CliId VARCHAR(20);

SELECT  
vic.CliId
INTO P_CliId FROM tblvicvehiculoingresocliente vic 
WHERE vic.EinId = OLD.EinId ORDER BY vic.VicFecha DESC,vic.VicEstado ASC LIMIT 1;

		UPDATE tbleinvehiculoingreso
		SET CliId = P_CliId
		WHERE EinId = OLD.EinId;

END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
