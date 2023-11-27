/*
Navicat MySQL Data Transfer

Source Server         : conex 3306
Source Server Version : 50733
Source Host           : 127.0.0.1:3306
Source Database       : sis_apafa

Target Server Type    : MYSQL
Target Server Version : 50733
File Encoding         : 65001

Date: 2023-11-13 14:02:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for aporte
-- ----------------------------
DROP TABLE IF EXISTS `aporte`;
CREATE TABLE `aporte` (
  `id_aporte` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `monto` decimal(10,0) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id_aporte`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of aporte
-- ----------------------------
INSERT INTO `aporte` VALUES ('3', 'aporte de prueba', 'prueba de descripcion', '50', '2023-10-18 00:00:00');
INSERT INTO `aporte` VALUES ('4', 'QALI WARMA - MES DICIEMBRE 2023', 'Aporte por qali warma del mes de diciembre 2023', '50', '2023-12-20 00:00:00');
INSERT INTO `aporte` VALUES ('5', 'QALI WARMA', 'AQUI VA LA DESCRIPCION', '80', '2023-11-02 00:00:00');
INSERT INTO `aporte` VALUES ('6', 'PAGO PENSION', 'DES-****', '50', '2023-11-10 00:00:00');

-- ----------------------------
-- Table structure for aporte_padres
-- ----------------------------
DROP TABLE IF EXISTS `aporte_padres`;
CREATE TABLE `aporte_padres` (
  `id_aporte_padres` int(11) NOT NULL AUTO_INCREMENT,
  `id_aporte` int(11) DEFAULT NULL,
  `id_padre_familia` int(11) DEFAULT NULL,
  `monto_aporte` decimal(10,0) DEFAULT NULL,
  `monto_aportado` decimal(10,0) DEFAULT NULL,
  `debe` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id_aporte_padres`),
  KEY `aporte_id_aporte` (`id_aporte`),
  KEY `aporte_id_padre_familia` (`id_padre_familia`),
  CONSTRAINT `aporte_id_aporte` FOREIGN KEY (`id_aporte`) REFERENCES `aporte` (`id_aporte`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `aporte_id_padre_familia` FOREIGN KEY (`id_padre_familia`) REFERENCES `padre_familia` (`id_padre_familia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=539 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of aporte_padres
-- ----------------------------
INSERT INTO `aporte_padres` VALUES ('452', '4', '183', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('453', '4', '170', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('454', '4', '171', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('455', '4', '172', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('456', '4', '173', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('457', '4', '174', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('458', '4', '175', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('459', '4', '176', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('460', '4', '177', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('461', '4', '178', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('462', '4', '179', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('463', '4', '180', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('464', '4', '181', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('465', '4', '182', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('466', '4', '184', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('467', '4', '185', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('468', '4', '186', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('469', '4', '187', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('470', '4', '188', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('471', '4', '189', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('472', '4', '190', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('473', '4', '191', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('474', '4', '192', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('475', '4', '193', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('476', '4', '194', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('477', '4', '195', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('478', '4', '196', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('479', '4', '197', '100', '0', null);
INSERT INTO `aporte_padres` VALUES ('480', '4', '199', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('481', '3', '183', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('482', '3', '170', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('483', '3', '171', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('484', '3', '172', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('485', '3', '173', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('486', '3', '174', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('487', '3', '175', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('488', '3', '176', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('489', '3', '177', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('490', '3', '178', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('491', '3', '179', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('492', '3', '180', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('493', '3', '181', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('494', '3', '182', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('495', '3', '184', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('496', '3', '185', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('497', '3', '186', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('498', '3', '187', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('499', '3', '188', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('500', '3', '189', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('501', '3', '190', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('502', '3', '191', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('503', '3', '192', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('504', '3', '193', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('505', '3', '194', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('506', '3', '195', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('507', '3', '196', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('508', '3', '197', '100', '100', '0');
INSERT INTO `aporte_padres` VALUES ('509', '3', '199', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('510', '6', '183', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('511', '6', '170', '50', '50', '0');
INSERT INTO `aporte_padres` VALUES ('512', '6', '171', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('513', '6', '172', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('514', '6', '173', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('515', '6', '174', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('516', '6', '175', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('517', '6', '176', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('518', '6', '177', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('519', '6', '178', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('520', '6', '179', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('521', '6', '180', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('522', '6', '181', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('523', '6', '182', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('524', '6', '184', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('525', '6', '185', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('526', '6', '186', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('527', '6', '187', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('528', '6', '188', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('529', '6', '189', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('530', '6', '190', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('531', '6', '191', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('532', '6', '192', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('533', '6', '193', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('534', '6', '194', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('535', '6', '195', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('536', '6', '196', '50', '0', null);
INSERT INTO `aporte_padres` VALUES ('537', '6', '197', '100', '0', null);
INSERT INTO `aporte_padres` VALUES ('538', '6', '199', '50', '0', null);

-- ----------------------------
-- Table structure for cargo
-- ----------------------------
DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cargo
-- ----------------------------
INSERT INTO `cargo` VALUES ('1', 'PADRE DE FAMILIA');
INSERT INTO `cargo` VALUES ('2', 'PRESIDENTE DE APAFA');
INSERT INTO `cargo` VALUES ('3', 'TESORERO(A)');
INSERT INTO `cargo` VALUES ('4', 'SECRETARIO(A)');

-- ----------------------------
-- Table structure for empresa
-- ----------------------------
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `cod_modular` varchar(20) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `foto_institucion` varchar(100) DEFAULT NULL,
  `foto_ugel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of empresa
-- ----------------------------
INSERT INTO `empresa` VALUES ('1', 'I.E. NERY GARCIA ZARATE', '0574319', 'ANCHIHUAY - LA MAR', '987456321', 'NERYGARCIAZARATE@GMAIL.COM', 'logo-ngz.png', 'logougel-unnamed.jpg');

-- ----------------------------
-- Table structure for estado_reunion
-- ----------------------------
DROP TABLE IF EXISTS `estado_reunion`;
CREATE TABLE `estado_reunion` (
  `id_estado_reunion` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_reunion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estado_reunion
-- ----------------------------
INSERT INTO `estado_reunion` VALUES ('1', 'ACTIVO');
INSERT INTO `estado_reunion` VALUES ('2', 'CULMINADO');

-- ----------------------------
-- Table structure for estudiante
-- ----------------------------
DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `id_padre_familia` int(11) DEFAULT NULL,
  `dni` varchar(255) DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `ape_pat` varchar(255) DEFAULT NULL,
  `ape_mat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `fk_estudiante_padreFamilia` (`id_padre_familia`),
  CONSTRAINT `fk_estudiante_padreFamilia` FOREIGN KEY (`id_padre_familia`) REFERENCES `padre_familia` (`id_padre_familia`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estudiante
-- ----------------------------
INSERT INTO `estudiante` VALUES ('256', '170', '60376420', 'PRESLEY ELVIS', 'ALLCCA', 'GUTIERREZ');
INSERT INTO `estudiante` VALUES ('257', '171', '60376421', 'SANDY KIHOMI', 'BORDA', 'SANCHEZ');
INSERT INTO `estudiante` VALUES ('258', '172', '60376422', 'CLEYDA MARICIELA', 'CALDERON', 'ALLCCA');
INSERT INTO `estudiante` VALUES ('259', '173', '60376423', 'FLOR NELIDA', 'CARDENAS', 'ESCALANTE');
INSERT INTO `estudiante` VALUES ('260', '174', '60376424', 'JHOAN KENNET', 'CUBA', 'CASAVILCA');
INSERT INTO `estudiante` VALUES ('261', '175', '60376425', 'YAVEL GABRIEL', 'ESCALANTE', 'SULCA');
INSERT INTO `estudiante` VALUES ('262', '176', '60376426', 'LUZ REYNA', 'HUALLPA', 'AGUILAR');
INSERT INTO `estudiante` VALUES ('263', '177', '60376427', 'REYNA EZABETH', 'LAPA', 'CURO');
INSERT INTO `estudiante` VALUES ('264', '178', '60376428', 'JOSE GABRIEL', 'MARQUINA', 'AMORIN');
INSERT INTO `estudiante` VALUES ('265', '179', '60376429', 'DAVID WILKERZON', 'MEDINA', 'ESCALANTE');
INSERT INTO `estudiante` VALUES ('266', '180', '60376430', 'SARA HELEN', 'MUCHA', 'DE LA CRUZ');
INSERT INTO `estudiante` VALUES ('267', '181', '60376431', 'JENIFER DANIELA', 'RIVERA', 'LEDESMA');
INSERT INTO `estudiante` VALUES ('268', '182', '60376432', 'ROBERT WILLIAMS', 'RIVERA', 'PEREZ');
INSERT INTO `estudiante` VALUES ('269', '183', '60376433', 'MELISSA SYNTIA', 'YARANGA', 'TORRES');
INSERT INTO `estudiante` VALUES ('270', '184', '60376434', 'MYLEIDE', 'BORDA', 'LLACCTAHUAMAN');
INSERT INTO `estudiante` VALUES ('271', '185', '60376435', 'MAREYLA', 'DURAND', 'AGUILAR');
INSERT INTO `estudiante` VALUES ('272', '186', '60376436', 'BENJAMIN', 'ESCALANTE', 'AGUILAR');
INSERT INTO `estudiante` VALUES ('273', '187', '60376437', 'ELMER GEORGE', 'ESPINO', 'PEREZ');
INSERT INTO `estudiante` VALUES ('274', '188', '60376438', 'BELTRAN', 'HUALLPA', 'AGUILAR');
INSERT INTO `estudiante` VALUES ('275', '189', '60376439', 'JOSEPH ANTONY', 'HUARCAYA', 'TAIPE');
INSERT INTO `estudiante` VALUES ('276', '190', '60376440', 'LIZETH', 'HUICAÑA', 'AGUILAR');
INSERT INTO `estudiante` VALUES ('277', '191', '60376441', 'EVELYN', 'LLAMOCURI', 'GALVEZ');
INSERT INTO `estudiante` VALUES ('278', '192', '60376442', 'BONNEY YHONATAN', 'LUDEÑA', 'TORRES');
INSERT INTO `estudiante` VALUES ('279', '193', '60376443', 'HERNAN MAXIMO', 'QUISPE', 'ALLCCA');
INSERT INTO `estudiante` VALUES ('280', '194', '60376444', 'DIONICIA', 'QUISPE', 'CARDENAS');
INSERT INTO `estudiante` VALUES ('281', '195', '60376445', 'NILDA', 'QUISPE', 'DURAND');
INSERT INTO `estudiante` VALUES ('282', '196', '60376446', 'CINTHIA', 'QUISPE', 'HUAMAN');
INSERT INTO `estudiante` VALUES ('283', '197', '60376447', 'FRANS ANGEL', 'SANCHEZ', 'BORDA');
INSERT INTO `estudiante` VALUES ('284', '197', '60376448', 'YOMER', 'SULCA', 'JERI');
INSERT INTO `estudiante` VALUES ('285', '199', '456', 'A', 'A', 'A');

-- ----------------------------
-- Table structure for padre_familia
-- ----------------------------
DROP TABLE IF EXISTS `padre_familia`;
CREATE TABLE `padre_familia` (
  `id_padre_familia` int(11) NOT NULL AUTO_INCREMENT,
  `id_cargo` int(11) DEFAULT NULL,
  `tipo_consanguinidad` int(11) DEFAULT NULL,
  `padre_dni` varchar(255) DEFAULT NULL,
  `padre_nombres` varchar(255) DEFAULT NULL,
  `padre_ape_pat` varchar(255) DEFAULT NULL,
  `padre_ape_mat` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_padre_familia`),
  KEY `fk_padreFamilia_consanguinidad` (`tipo_consanguinidad`),
  KEY `fk_padreFamilia_cargo` (`id_cargo`),
  CONSTRAINT `fk_padreFamilia_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  CONSTRAINT `fk_padreFamilia_consanguinidad` FOREIGN KEY (`tipo_consanguinidad`) REFERENCES `tipo_consanguinidad` (`id_tipo_consanguinidad`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of padre_familia
-- ----------------------------
INSERT INTO `padre_familia` VALUES ('170', null, null, '62295715', 'XIOMARA KIARA', 'BAÑICO', 'XIOMARA', null, null, null);
INSERT INTO `padre_familia` VALUES ('171', null, null, '62190845', 'JHON', 'CASTILLO', 'DURAND', null, null, null);
INSERT INTO `padre_familia` VALUES ('172', null, null, '62190802', 'MARITZA', 'CASTILLO', 'TAIPE', null, null, null);
INSERT INTO `padre_familia` VALUES ('173', null, null, '62295702', 'TRILCE', 'CORAS', 'TORRES', null, null, null);
INSERT INTO `padre_familia` VALUES ('174', null, null, '62190805', 'MOISES', 'DE', 'PALOMINO', null, null, null);
INSERT INTO `padre_familia` VALUES ('175', null, null, '62295711', 'JHON', 'ESCALANTE', 'GUEVARA', null, null, null);
INSERT INTO `padre_familia` VALUES ('176', null, null, '76704240', 'YUSSEI', 'ESCALANTE', 'GUTIERREZ', null, null, null);
INSERT INTO `padre_familia` VALUES ('177', null, null, '61600207', 'LUCY', 'ESCRIBA', 'DURAND', null, null, null);
INSERT INTO `padre_familia` VALUES ('178', null, null, '61600235', 'JHON', 'HUAMANI', 'HUICAÑA', null, null, null);
INSERT INTO `padre_familia` VALUES ('179', null, null, '62295708', 'MAIDIT', 'HUICAÑA', 'SUAREZ', null, null, null);
INSERT INTO `padre_familia` VALUES ('180', null, null, '62295745', 'GUIDO', 'LUDEÑA', 'TORRES', null, null, null);
INSERT INTO `padre_familia` VALUES ('181', null, null, '63389507', 'MIGUEL', 'MUÑOZ', 'BORDA', null, null, null);
INSERT INTO `padre_familia` VALUES ('182', null, null, '62295744', 'ANDERSON', 'ROJAS', 'MENDEZ', null, null, null);
INSERT INTO `padre_familia` VALUES ('183', '3', '4', '62097551', 'MAX KEI', 'ROJAS', 'MAX', null, null, null);
INSERT INTO `padre_familia` VALUES ('184', null, null, '62190813', 'NAYSA', 'SANCHEZ', 'FLORES', null, null, null);
INSERT INTO `padre_familia` VALUES ('185', null, null, '62236653', 'ANALIZ', 'SERNA', 'BORDA', null, null, null);
INSERT INTO `padre_familia` VALUES ('186', null, null, '62295729', 'ELIAZAR', 'TINEO', 'CASTILLO', null, null, null);
INSERT INTO `padre_familia` VALUES ('187', null, null, '62295703', 'KATY', 'TINEO', 'QUISPE', null, null, null);
INSERT INTO `padre_familia` VALUES ('188', null, null, '81334589', 'DIEGO', 'TORRES', 'TINEO', null, null, null);
INSERT INTO `padre_familia` VALUES ('189', null, null, '61708985', 'FLOR NAYBETH', 'CASTILLO', 'DURAND', null, null, null);
INSERT INTO `padre_familia` VALUES ('190', null, null, '63577490', 'ROY BRECHMAN', 'CATUNGO', 'TAIPE', null, null, null);
INSERT INTO `padre_familia` VALUES ('191', null, null, '60405765', 'NIVER', 'DURAN', 'CURO', null, null, null);
INSERT INTO `padre_familia` VALUES ('192', null, null, '61709043', 'JESUS MELDRIN', 'ESCALANTE', 'AGUILAR', null, null, null);
INSERT INTO `padre_familia` VALUES ('193', null, null, '61709012', 'MARILU', 'ESCALANTE', 'LAPA', null, null, null);
INSERT INTO `padre_familia` VALUES ('194', null, null, '62579338', 'CARMEN LOANA', 'ESPINOZA', 'HERRERA', null, null, null);
INSERT INTO `padre_familia` VALUES ('195', null, null, '61709037', 'REYKO JHAMPIER', 'GUZMAN', 'QUISPE', null, null, null);
INSERT INTO `padre_familia` VALUES ('196', null, null, '74103046', 'AIMAR YUMIRA', 'HUAMAN', 'CURO', null, null, null);
INSERT INTO `padre_familia` VALUES ('197', null, null, '61667292', 'WENDY ESTEFANI', 'LAPA', 'CURO', null, null, null);
INSERT INTO `padre_familia` VALUES ('198', null, null, '62262739', 'YEFERSON', 'MEDINA', 'AGUILAR', null, null, null);
INSERT INTO `padre_familia` VALUES ('199', null, null, '123', 'A', 'A', 'A', null, null, null);
INSERT INTO `padre_familia` VALUES ('201', '1', '2', '70602367', 'Rosa María', 'Suárez', 'Sánchez', '987654340', 'Calle Cusco 893, Lima', null);
INSERT INTO `padre_familia` VALUES ('202', '1', '3', '70602368', 'Pablo José', 'Ramírez', 'Rodríguez', '987654341', 'Pasaje Lima 1115, Lima', null);
INSERT INTO `padre_familia` VALUES ('203', '1', '4', '70602369', 'Sofía', 'González', 'Rodríguez', '987654342', 'Av. Lima 1239, Lima', null);
INSERT INTO `padre_familia` VALUES ('204', '1', '5', '70602370', 'Juan Carlos', 'Montero', 'Pérez', '987654343', 'Jr. Arequipa 571, Lima', null);
INSERT INTO `padre_familia` VALUES ('205', '2', '6', '70602371', 'María José', 'Pérez', 'Sánchez', '987654344', 'Calle Cusco 894, Lima', null);
INSERT INTO `padre_familia` VALUES ('206', '2', '7', '70602372', 'José Luis', 'García', 'Rodríguez', '987654345', 'Pasaje Lima 1116, Lima', null);
INSERT INTO `padre_familia` VALUES ('207', '2', '8', '70602373', 'Ana María', 'Flores', 'Pérez', '987654346', 'Av. Lima 1240, Lima', null);
INSERT INTO `padre_familia` VALUES ('208', '2', '9', '77889900', 'Pedro Pablo', 'Gómez', 'Sánchez', '987654347', 'Jr. Arequipa 572, Lima', null);
INSERT INTO `padre_familia` VALUES ('209', '1', '2', '11111111', 'fulanito', 'fulanito', 'fulanito', 'fulanito', 'fulanito', '2023-10-07 18:40:18');
INSERT INTO `padre_familia` VALUES ('214', '1', '1', '70602366', 'Luis Miguel', 'Castillo', 'Pérez', '987654339', 'Jr. Arequipa 570, Lima', '2023-10-07 18:49:52');
INSERT INTO `padre_familia` VALUES ('215', '2', '2', '123456', 'A', 'A', 'A', '123', '123', '2023-10-07 18:49:52');

-- ----------------------------
-- Table structure for pago
-- ----------------------------
DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_padre_familia` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `pago_concepto` varchar(255) DEFAULT NULL,
  `monto_pago` decimal(10,0) DEFAULT NULL,
  `debe` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id_pago`),
  KEY `fk_pago_aporte` (`pago_concepto`),
  KEY `fk_pago_padreFamilia` (`id_padre_familia`),
  KEY `fk_pago_usuario` (`id_usuario`),
  CONSTRAINT `fk_pago_padreFamilia` FOREIGN KEY (`id_padre_familia`) REFERENCES `padre_familia` (`id_padre_familia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pago
-- ----------------------------
INSERT INTO `pago` VALUES ('14', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '2000', '0');
INSERT INTO `pago` VALUES ('15', '197', '2', 'APORTE: s', '50', '50');
INSERT INTO `pago` VALUES ('16', '197', '2', 'APORTE: s', '99', '1');
INSERT INTO `pago` VALUES ('17', '197', '2', 'APORTE: s', '1', '0');
INSERT INTO `pago` VALUES ('18', '197', '2', 'APORTE: s', '100', '0');
INSERT INTO `pago` VALUES ('19', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '2000', '0');
INSERT INTO `pago` VALUES ('20', '197', '2', 'MULTA REUNION: REU', '50', '0');
INSERT INTO `pago` VALUES ('21', '197', '2', 'MULTA REUNION: GRAN RIFA', '10', '0');
INSERT INTO `pago` VALUES ('22', '197', '2', 'MULTA REUNION: GRAN RIFA', '10', '0');
INSERT INTO `pago` VALUES ('23', '197', '2', 'MULTA REUNION: prueba', '100', '0');
INSERT INTO `pago` VALUES ('24', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1499');
INSERT INTO `pago` VALUES ('25', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1498');
INSERT INTO `pago` VALUES ('26', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1497');
INSERT INTO `pago` VALUES ('27', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1496');
INSERT INTO `pago` VALUES ('28', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1495');
INSERT INTO `pago` VALUES ('29', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1494');
INSERT INTO `pago` VALUES ('30', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1493');
INSERT INTO `pago` VALUES ('31', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1492');
INSERT INTO `pago` VALUES ('32', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1491');
INSERT INTO `pago` VALUES ('33', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1490');
INSERT INTO `pago` VALUES ('34', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1489');
INSERT INTO `pago` VALUES ('35', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1', '1488');
INSERT INTO `pago` VALUES ('36', '197', '2', 'MULTA REUNION: EJEMPLO DE REUNION2', '1002', '0');
INSERT INTO `pago` VALUES ('37', '197', '2', 'APORTE: s', '50', '50');
INSERT INTO `pago` VALUES ('38', '197', '2', 'APORTE: EJEMPLO DE APORTEs', '1488', '0');
INSERT INTO `pago` VALUES ('39', '197', '2', 'APORTE: aporte de prueba', '100', '0');
INSERT INTO `pago` VALUES ('40', '197', '2', 'MULTA REUNION: REUNION - ENTREGA DE LIBRETAS', '100', '0');
INSERT INTO `pago` VALUES ('41', '170', '2', 'APORTE: PAGO PENSION', '50', '0');

-- ----------------------------
-- Table structure for reunion
-- ----------------------------
DROP TABLE IF EXISTS `reunion`;
CREATE TABLE `reunion` (
  `id_reunion` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado_reunion` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `multa_precio` decimal(10,0) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id_reunion`),
  KEY `fk_actividad_estadoActividad` (`id_estado_reunion`),
  CONSTRAINT `fk_actividad_estadoActividad` FOREIGN KEY (`id_estado_reunion`) REFERENCES `estado_reunion` (`id_estado_reunion`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reunion
-- ----------------------------
INSERT INTO `reunion` VALUES ('12', '2', 'REU', 'Aqui va la descripc', '50', '2023-10-15', '09:59:32');
INSERT INTO `reunion` VALUES ('14', '2', 'GRAN RIFA', 'Aqui va la descripcion de la r', '10', '2023-10-15', '21:59:32');
INSERT INTO `reunion` VALUES ('15', '2', 'EJEMPLO DE REUNION2', 'a  v la descripcion de la reunion Aqui va la descripcion de la reunion Aqui va la', '1002', '2023-11-08', '10:30:00');
INSERT INTO `reunion` VALUES ('16', '2', 'REUNION - ENTREGA DE LIBRETAS', 'a la descripc la descripcion de la reunion Aqui va la descripcion de la reunion Aqui va la descri la descr', '100', '2023-11-05', '15:17:00');
INSERT INTO `reunion` VALUES ('17', '1', 'CLAUSURA', 'EJEMPLO', '120', '2023-11-17', '12:42:00');

-- ----------------------------
-- Table structure for reunion_padres
-- ----------------------------
DROP TABLE IF EXISTS `reunion_padres`;
CREATE TABLE `reunion_padres` (
  `id_reunion_padres` int(11) NOT NULL AUTO_INCREMENT,
  `id_reunion` int(11) DEFAULT NULL,
  `id_padre_familia` int(11) DEFAULT NULL,
  `asistencia` datetime DEFAULT NULL,
  `asistencia_salida` datetime DEFAULT NULL,
  `detalles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_reunion_padres`),
  KEY `fk_reunion_padres_padre_familia` (`id_padre_familia`),
  KEY `fk_reunion_padres_reunion` (`id_reunion`),
  CONSTRAINT `fk_reunion_padres_padre_familia` FOREIGN KEY (`id_padre_familia`) REFERENCES `padre_familia` (`id_padre_familia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reunion_padres_reunion` FOREIGN KEY (`id_reunion`) REFERENCES `reunion` (`id_reunion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=488 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reunion_padres
-- ----------------------------
INSERT INTO `reunion_padres` VALUES ('372', '16', '183', null, null, null);
INSERT INTO `reunion_padres` VALUES ('373', '16', '170', null, null, null);
INSERT INTO `reunion_padres` VALUES ('374', '16', '171', null, null, null);
INSERT INTO `reunion_padres` VALUES ('375', '16', '172', null, null, null);
INSERT INTO `reunion_padres` VALUES ('376', '16', '173', null, null, null);
INSERT INTO `reunion_padres` VALUES ('377', '16', '174', null, null, null);
INSERT INTO `reunion_padres` VALUES ('378', '16', '175', null, null, null);
INSERT INTO `reunion_padres` VALUES ('379', '16', '176', null, null, null);
INSERT INTO `reunion_padres` VALUES ('380', '16', '177', null, null, null);
INSERT INTO `reunion_padres` VALUES ('381', '16', '178', null, null, null);
INSERT INTO `reunion_padres` VALUES ('382', '16', '179', null, null, null);
INSERT INTO `reunion_padres` VALUES ('383', '16', '180', null, null, null);
INSERT INTO `reunion_padres` VALUES ('384', '16', '181', null, null, null);
INSERT INTO `reunion_padres` VALUES ('385', '16', '182', null, null, null);
INSERT INTO `reunion_padres` VALUES ('386', '16', '184', null, null, null);
INSERT INTO `reunion_padres` VALUES ('387', '16', '185', null, null, null);
INSERT INTO `reunion_padres` VALUES ('388', '16', '186', null, null, null);
INSERT INTO `reunion_padres` VALUES ('389', '16', '187', null, null, null);
INSERT INTO `reunion_padres` VALUES ('390', '16', '188', null, null, null);
INSERT INTO `reunion_padres` VALUES ('391', '16', '189', null, null, null);
INSERT INTO `reunion_padres` VALUES ('392', '16', '190', null, null, null);
INSERT INTO `reunion_padres` VALUES ('393', '16', '191', null, null, null);
INSERT INTO `reunion_padres` VALUES ('394', '16', '192', null, null, null);
INSERT INTO `reunion_padres` VALUES ('395', '16', '193', null, null, null);
INSERT INTO `reunion_padres` VALUES ('396', '16', '194', null, null, null);
INSERT INTO `reunion_padres` VALUES ('397', '16', '195', null, null, null);
INSERT INTO `reunion_padres` VALUES ('398', '16', '196', null, null, null);
INSERT INTO `reunion_padres` VALUES ('399', '16', '197', null, null, 'MULTA PAGADA');
INSERT INTO `reunion_padres` VALUES ('400', '16', '199', null, null, null);
INSERT INTO `reunion_padres` VALUES ('401', '15', '183', null, null, null);
INSERT INTO `reunion_padres` VALUES ('402', '15', '170', '2023-11-01 12:24:17', null, null);
INSERT INTO `reunion_padres` VALUES ('403', '15', '171', null, null, null);
INSERT INTO `reunion_padres` VALUES ('404', '15', '172', null, null, null);
INSERT INTO `reunion_padres` VALUES ('405', '15', '173', null, null, null);
INSERT INTO `reunion_padres` VALUES ('406', '15', '174', null, null, null);
INSERT INTO `reunion_padres` VALUES ('407', '15', '175', null, null, null);
INSERT INTO `reunion_padres` VALUES ('408', '15', '176', null, null, null);
INSERT INTO `reunion_padres` VALUES ('409', '15', '177', null, null, null);
INSERT INTO `reunion_padres` VALUES ('410', '15', '178', null, null, null);
INSERT INTO `reunion_padres` VALUES ('411', '15', '179', null, null, null);
INSERT INTO `reunion_padres` VALUES ('412', '15', '180', null, null, null);
INSERT INTO `reunion_padres` VALUES ('413', '15', '181', null, null, null);
INSERT INTO `reunion_padres` VALUES ('414', '15', '182', null, null, null);
INSERT INTO `reunion_padres` VALUES ('415', '15', '184', null, null, null);
INSERT INTO `reunion_padres` VALUES ('416', '15', '185', null, null, null);
INSERT INTO `reunion_padres` VALUES ('417', '15', '186', null, null, null);
INSERT INTO `reunion_padres` VALUES ('418', '15', '187', null, null, null);
INSERT INTO `reunion_padres` VALUES ('419', '15', '188', null, null, null);
INSERT INTO `reunion_padres` VALUES ('420', '15', '189', null, null, null);
INSERT INTO `reunion_padres` VALUES ('421', '15', '190', null, null, null);
INSERT INTO `reunion_padres` VALUES ('422', '15', '191', null, null, null);
INSERT INTO `reunion_padres` VALUES ('423', '15', '192', null, null, null);
INSERT INTO `reunion_padres` VALUES ('424', '15', '193', null, null, null);
INSERT INTO `reunion_padres` VALUES ('425', '15', '194', null, null, null);
INSERT INTO `reunion_padres` VALUES ('426', '15', '195', null, null, null);
INSERT INTO `reunion_padres` VALUES ('427', '15', '196', null, null, null);
INSERT INTO `reunion_padres` VALUES ('428', '15', '197', '2023-10-30 10:51:19', null, null);
INSERT INTO `reunion_padres` VALUES ('429', '15', '199', null, null, null);
INSERT INTO `reunion_padres` VALUES ('459', '17', '183', null, null, null);
INSERT INTO `reunion_padres` VALUES ('460', '17', '170', '2023-11-01 12:52:29', null, null);
INSERT INTO `reunion_padres` VALUES ('461', '17', '171', null, null, null);
INSERT INTO `reunion_padres` VALUES ('462', '17', '172', null, null, null);
INSERT INTO `reunion_padres` VALUES ('463', '17', '173', null, null, null);
INSERT INTO `reunion_padres` VALUES ('464', '17', '174', null, null, null);
INSERT INTO `reunion_padres` VALUES ('465', '17', '175', null, null, null);
INSERT INTO `reunion_padres` VALUES ('466', '17', '176', null, null, null);
INSERT INTO `reunion_padres` VALUES ('467', '17', '177', null, null, null);
INSERT INTO `reunion_padres` VALUES ('468', '17', '178', null, null, null);
INSERT INTO `reunion_padres` VALUES ('469', '17', '179', null, null, null);
INSERT INTO `reunion_padres` VALUES ('470', '17', '180', null, null, null);
INSERT INTO `reunion_padres` VALUES ('471', '17', '181', null, null, null);
INSERT INTO `reunion_padres` VALUES ('472', '17', '182', null, null, null);
INSERT INTO `reunion_padres` VALUES ('473', '17', '184', null, null, null);
INSERT INTO `reunion_padres` VALUES ('474', '17', '185', null, null, null);
INSERT INTO `reunion_padres` VALUES ('475', '17', '186', null, null, null);
INSERT INTO `reunion_padres` VALUES ('476', '17', '187', null, null, null);
INSERT INTO `reunion_padres` VALUES ('477', '17', '188', null, null, null);
INSERT INTO `reunion_padres` VALUES ('478', '17', '189', null, null, null);
INSERT INTO `reunion_padres` VALUES ('479', '17', '190', null, null, null);
INSERT INTO `reunion_padres` VALUES ('480', '17', '191', null, null, null);
INSERT INTO `reunion_padres` VALUES ('481', '17', '192', null, null, null);
INSERT INTO `reunion_padres` VALUES ('482', '17', '193', null, null, null);
INSERT INTO `reunion_padres` VALUES ('483', '17', '194', null, null, null);
INSERT INTO `reunion_padres` VALUES ('484', '17', '195', null, null, null);
INSERT INTO `reunion_padres` VALUES ('485', '17', '196', null, null, null);
INSERT INTO `reunion_padres` VALUES ('486', '17', '197', null, null, null);
INSERT INTO `reunion_padres` VALUES ('487', '17', '199', null, null, null);

-- ----------------------------
-- Table structure for tipo_consanguinidad
-- ----------------------------
DROP TABLE IF EXISTS `tipo_consanguinidad`;
CREATE TABLE `tipo_consanguinidad` (
  `id_tipo_consanguinidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_consanguinidad`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tipo_consanguinidad
-- ----------------------------
INSERT INTO `tipo_consanguinidad` VALUES ('1', 'PADRE');
INSERT INTO `tipo_consanguinidad` VALUES ('2', 'MADRE');
INSERT INTO `tipo_consanguinidad` VALUES ('3', 'TÍO');
INSERT INTO `tipo_consanguinidad` VALUES ('4', 'TÍA');
INSERT INTO `tipo_consanguinidad` VALUES ('5', 'HERMANO');
INSERT INTO `tipo_consanguinidad` VALUES ('6', 'HERMANA');
INSERT INTO `tipo_consanguinidad` VALUES ('7', 'CUÑADO');
INSERT INTO `tipo_consanguinidad` VALUES ('8', 'CUÑADA');
INSERT INTO `tipo_consanguinidad` VALUES ('9', 'ABUELO');
INSERT INTO `tipo_consanguinidad` VALUES ('10', 'ABUELA');
INSERT INTO `tipo_consanguinidad` VALUES ('11', 'SOBRINO');
INSERT INTO `tipo_consanguinidad` VALUES ('12', 'SOBRINA');
INSERT INTO `tipo_consanguinidad` VALUES ('13', 'PADRASTRO');
INSERT INTO `tipo_consanguinidad` VALUES ('14', 'MADRASTRA');
INSERT INTO `tipo_consanguinidad` VALUES ('15', 'OTRO');

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('2', 'Isai Ismael Sandoval Ccaccro', 'isai', '202cb962ac59075b964b07152d234b70', 'isai.ismael1999@gmail.com', '1', '013645');
