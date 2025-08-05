<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteResumenVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteResumenVenta {

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}



    public function MtdObtenerReporteResumenVentas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVehiculoMarca=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

			
	
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oAno)){
			$ano = ' AND rve.RveAno = "'.$oAno.'"';
		}
		
		if(!empty($oMes)){
			$mes = ' AND rve.RveMes = "'.$oMes.'"';
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fechab = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
				$fechaf = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'" AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fechab = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
				$fechaf = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fechab = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';	
				$fechab = ' AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}

			if(!empty($oSucursal)){
				$sucursalb = ' AND (bol.SucId) = "'.$oSucursal.'"';	
				$sucursalf = ' AND (fac.SucId) = "'.$oSucursal.'"';		
			}	


		if(!empty($oVehiculoMarca)){
				$vmarcab = ' AND (vmo.VmaId) = "'.$oVehiculoMarca.'"';	
				$vmarcaf = ' AND (vmo.VmaId) = "'.$oVehiculoMarca.'"';		
			}	


			
			$sql = 'SELECT
bde.BdeId AS "RvrId",
CONCAT(bta.BtaNumero,"-",bol.BolId) AS "RvrDoc",
bol.BolFechaEmision AS "RvrFecha",
mon.MonSigla AS "RvrTipoMoneda",

IFNULL((
SELECT 
fim.FinId
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
	

WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),
IFNULL(

(
SELECT 
amo.VdiId
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblvdiventadirecta vdi
		ON amo.VdiId = vdi.VdiId
WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
)
,"")
) AS "RvrOrdenTrabajo",

CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS "RvrCliente",

suc.SucNombre AS "RvrLocal",


IFNULL((
SELECT 
vma.VmaNombre
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
				LEFT JOIN tblfinfichaingreso fin
				ON fim.FinId = fin.FinId
					LEFT JOIN tbleinvehiculoingreso ein
					ON fin.EinId = ein.EinId	
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId

WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),
IFNULL(

(
SELECT 
vma.VmaNombre
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblvdiventadirecta vdi
		ON amo.VdiId = vdi.VdiId
			LEFT JOIN tbleinvehiculoingreso ein
			ON vdi.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId

WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
)
,"")
) AS "RvrMarca",

CASE
WHEN bde.BdeTipo = "S" THEN "MANO DE OBRA"
WHEN bde.BdeTipo = "R" THEN "REPUESTOS"
ELSE "-"
END AS "RvrResumen",


CASE
WHEN bde.BdeTipo = "S" THEN "MANO DE OBRA"
ELSE IFNULL(rti.RtiNombre,"")
END AS "RvrTipo",


CASE
WHEN bde.BdeTipo = "S" THEN "MANO DE OBRA"
ELSE "-"
END AS "RvrServicios",

CASE
WHEN bde.BdeTipo = "S" THEN "MANO DE OBRA"
ELSE "-"
END AS "RvrTipoDetalle",



IFNULL((
SELECT 
usu.UsuUsuario
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
					LEFT JOIN tblfinfichaingreso fin
					ON fim.FinId =  fin.FinId
			LEFT JOIN tblperpersonal per
				ON fin.PerIdAsesor = per.PerId
					LEFT JOIN tblusuusuario usu
					ON per.UsuId = usu.UsuId
WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
) ,
IFNULL(

(
SELECT 
usu.UsuUsuario
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblvdiventadirecta vdi
		ON amo.VdiId = vdi.VdiId		
			LEFT JOIN tblperpersonal per
				ON vdi.PerId = per.PerId
					LEFT JOIN tblusuusuario usu
					ON per.UsuId = usu.UsuId
WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
)

,"")) AS "RvrVendedor",

(
IFNULL(
(
SELECT 
CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoMaterno,"")," ",IFNULL(per.PerApellidoPaterno,""))
FROM tblbamboletaalmacenmovimiento bam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON bam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId			
			LEFT JOIN tblperpersonal per
				ON fcc.PerId = per.PerId

WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),"")
) AS "RvrAsesorAccesorio",

bde.BdeCodigo AS "RvrCodigo",
bde.BdeDescripcion AS "RvrDescripcion",
ROUND(bde.BdeCantidad,2) AS "RvrCantidad",

@CostoDolares:=ROUND(IFNULL(
	(
		SELECT
		lpr.costo
		FROM listaprecios lpr
		WHERE lpr.codigo = REPLACE(bde.BdeCodigo,"-", "")
		LIMIT 1
	)
,IFNULL(
	(
		SELECT 
		plp.PlpPrecioReal
		FROM tblplpproductolistaprecio plp
		WHERE plp.PlpCodigo = REPLACE(bde.BdeCodigo,"-", "")
		ORDER BY plp.PlpTiempoCreacion DESC
		LIMIT 1
	),IFNULL(
		(
			SELECT 
			ede.precio_compra
			FROM entradas_detalle ede
			LEFT JOIN entradas ent
			ON ede.id_entrada = ent.id_entrada
			WHERE ede.id_articulo = bde.BdeCodigo
			AND ent.moneda = "02 - US$ - DOLARES AMERICANOS"
			ORDER BY ent.id_entrada DESC
			LIMIT 1
		),0)
	)

),2) AS "RvrCostoUs",

@CostoIGVDolares:=ROUND((
@CostoDolares*1.18
),2) AS "RvrCostoIGV",

@TipoCambio:=IFNULL((
SELECT
tca.TcaMontoVenta
FROM tbltcatipocambio tca
WHERE tca.TcaFecha = bol.BolFechaEmision
AND tca.MonId = "MON-10001"
LIMIT 1
),
IFNULL(
(
SELECT
tca.TcaMontoVenta
FROM tbltcatipocambio tca
WHERE 1 = 1
AND tca.MonId = "MON-10001"
AND tca.TcaFecha <= bol.BolFechaEmision
ORDER BY tca.TcaFecha DESC
LIMIT 1
)
,0)
) AS "RvrTipoCambio",

@CostoTotal1:=(ROUND((@CostoIGVDolares * @TipoCambio * bde.BdeCantidad),2)) AS "RvrCostoTotal1",

@CostoIGVSoles:=ROUND(

(
IFNULL(
	(
		SELECT 
		amd.AmdCosto
		FROM tblamdalmacenmovimientodetalle amd
			LEFT JOIN tblamoalmacenmovimiento amo
			ON amd.AmoId = amo.AmoId
			LEFT JOIN tblproproducto pro
			ON amd.ProId = pro.ProId
		WHERE REPLACE(pro.ProCodigoOriginal,"-", "") = REPLACE(bde.BdeCodigo,"-", "")
		AND amo.AmoTipo = 1
		AND amd.AmdCosto > 0
		ORDER BY amd.AmdFecha DESC
		LIMIT 1

	),
	
	IFNULL(
	
	(
		SELECT 
		ede.precio_compra
		FROM entradas_detalle ede
		LEFT JOIN entradas ent
		ON ede.id_entrada = ent.id_entrada
		WHERE 
		
		REPLACE(REPLACE(REPLACE(ede.id_articulo, " ", ""), "-", ""), ":", "") = REPLACE(bde.BdeCodigo,"-", "")
		AND ent.moneda = "01 - S/  - SOLES"
		ORDER BY ent.id_entrada DESC
		LIMIT 1
	)
	
	,0)
	)

),2) AS "RvrCostoIGVSoles",

@CostoTotal2:=ROUND( (@CostoIGVSoles * bde.BdeCantidad) ,2)AS "RvrCostoTotal2",

ROUND((IF(@CostoTotal1>@CostoTotal2,@CostoTotal1,@CostoTotal2)),2) AS "RvrCostoGeneral",

ROUND((IF(bol.MonId="MON-10001",bde.BdePrecio/bol.BolTipoCambio,0)),2) AS "RvrPrecioUs",

@PrecioSoles:=((IF(bol.MonId="MON-10000",bde.BdePrecio,0))) AS "RvrPrecioS",

ROUND(@PrecioUnitarioSoles:=(IF(bol.MonId="MON-10001",(bde.BdePrecio/bol.BolTipoCambio)*@TipoCambio,0)),2) AS "RvrPrecioUnitario",

ROUND((IF(@PrecioSoles>@PrecioUnitarioSoles,@PrecioSoles,@PrecioUnitarioSoles)),2) AS "RvrPrecioCliente",

0 AS "RvrGanancia",
0 AS "RvrMargen",

ume.UmeNombre AS "RvrUnidadMedida",
((IF(bol.MonId="MON-10000",bde.BdePrecio,0))) AS "RvrPrecioSFinal",




((IF(bol.MonId="MON-10000",( (bde.BdeDescuento/bde.BdeCantidad)* ((bol.BolPorcentajeImpuestoVenta/100)+1) ) ,0))) AS "RvrDescuentoSFinal",
((IF(bol.MonId="MON-10000",bde.BdeImporte,0))) AS "RvrImporteSFinal",
((IF(bol.MonId="MON-10001",bde.BdePrecio/bol.BolTipoCambio,0))) AS "RvrPrecioUSFinal",
((IF(bol.MonId="MON-10001",( (bde.BdeDescuento/bde.BdeCantidad)* ((bol.BolPorcentajeImpuestoVenta/100)+1) ) /bol.BolTipoCambio,0))) AS "RvrDescuentoUSFinal",
((IF(bol.MonId="MON-10001",bde.BdeImporte/bol.BolTipoCambio,0))) AS "RvrImporteUSFinal",
min.MinNombre AS "RvrModalidad",

(
SELECT 
CONCAT(nct.NctNumero,"-",ncr.NcrId)
FROM tblncrnotacredito ncr
LEFT JOIN tblnctnotacreditotalonario nct
ON ncr.NctId = nct.NctId
WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
AND ncr.NcrEstado <> 6
LIMIT 1
) AS RvrNotaCredito,


(
SELECT 
( ncr.NcrTotal/IFNULL(ncr.NcrTipoCambio,1) )
FROM tblncrnotacredito ncr
LEFT JOIN tblnctnotacreditotalonario nct
ON ncr.NctId = nct.NctId
WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
AND ncr.NcrEstado <> 6
LIMIT 1
) AS RvrNotaCreditoTotal,

vma.VmaNombre

FROM tblbdeboletadetalle bde
	LEFT JOIN tblbolboleta bol
	ON (bde.BolId = bol.BolId AND  bde.BtaId = bol.BtaId)
		LEFT JOIN tblbtaboletatalonario bta
		ON bol.BtaId = bta.BtaId

			LEFT JOIN tblclicliente cli
			ON bol.CliId = cli.CliId
				LEFT JOIN tblmonmoneda mon
				ON bol.MonId = mon.MonId
					LEFT  JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
						LEFT JOIN tblamdalmacenmovimientodetalle amd
						ON bde.AmdId = amd.AmdId
							LEFT JOIN tblproproducto pro
							ON amd.ProId =  pro .ProId
							LEFT JOIN tblumeunidadmedida ume
							ON amd.UmeId = ume.UmeId
								LEFT JOIN tblrtiproductotipo rti
								ON pro.RtiId = rti.RtiId
								LEFT JOIN tblamoalmacenmovimiento amo
									ON amd.AmoId = amo.AmoId
									
									LEFT JOIN tblfccfichaaccion fcc
									ON amo.FccId = fcc.FccId
										LEFT JOIN tblfimfichaingresomodalidad fim
										ON fcc.FimId = fim.FimId
											LEFT JOIN tblminmodalidadingreso min
											ON fim.MinId = min.MinId
												LEFT JOIN tblfinfichaingreso fin
												ON fim.FinId = fin.FinId
													LEFT JOIN tbleinvehiculoingreso ein
													ON fin.EinId = ein.EinId
														LEFT JOIN tblvvevehiculoversion vve
														ON ein.VveId = vve.VveId
															LEFT JOIN tblvmovehiculomodelo vmo
															ON vve.VmoId = vmo.VmoId
																LEFT JOIN tblvmavehiculomarca vma
																ON vmo.VmaId = vma.VmaId
																
WHERE 1 = 1 AND bol.BolEstado <> 6 AND bol.OvvId IS NULL '.$fechab.$vmarcab.$sucursalb.'






UNION ALL 






SELECT
fde.FdeId AS "RvrId",

CONCAT(fta.FtaNumero,"-",fac.FacId) AS "RvrDoc",
fac.FacFechaEmision AS "RvrFecha",
mon.MonSigla AS "RvrTipoMoneda",

IFNULL((
SELECT 
fim.FinId
FROM tblfamfacturaalmacenmovimiento fam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON fam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
	

WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),
IFNULL(

	(
	SELECT 
	amo.VdiId
	FROM tblfamfacturaalmacenmovimiento fam
		LEFT JOIN tblamoalmacenmovimiento amo
		ON fam.AmoId = amo.AmoId
			LEFT JOIN tblvdiventadirecta vdi
			ON amo.VdiId = vdi.VdiId
	WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

	ORDER BY amo.AmoFecha DESC
	LIMIT 1
	)

,"")
) AS "RvrOrdenTrabajo",

CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS "RvrCliente",

suc.SucNombre AS "RvrLocal",




IFNULL((
SELECT 
vma.VmaNombre
FROM tblfamfacturaalmacenmovimiento fam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON fam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
				LEFT JOIN tblfinfichaingreso fin
				ON fim.FinId = fin.FinId
					LEFT JOIN tbleinvehiculoingreso ein
					ON fin.EinId = ein.EinId	
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId


WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),
IFNULL(

	(
	SELECT 
	vma.VmaNombre
	FROM tblfamfacturaalmacenmovimiento fam
		LEFT JOIN tblamoalmacenmovimiento amo
		ON fam.AmoId = amo.AmoId
			LEFT JOIN tblvdiventadirecta vdi
			ON amo.VdiId = vdi.VdiId

				LEFT JOIN tbleinvehiculoingreso ein
				ON vdi.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId


	WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

	ORDER BY amo.AmoFecha DESC
	LIMIT 1
	)

,"")
) AS "RvrMarca",


CASE
WHEN fde.FdeTipo = "S" THEN "MANO DE OBRA"
WHEN fde.FdeTipo = "R" THEN "REPUESTOS"
ELSE "-"
END AS "RvrResumen",


CASE
WHEN fde.FdeTipo = "S" THEN "MANO DE OBRA"
ELSE IFNULL(rti.RtiNombre,"")
END AS "RvrTipo",


CASE
WHEN fde.FdeTipo = "S" THEN "MANO DE OBRA"
ELSE "-"
END AS "RvrServicios",

CASE
WHEN fde.FdeTipo = "S" THEN "MANO DE OBRA"
ELSE "-"
END AS "RvrTipoDetalle",


IFNULL((
SELECT 
usu.UsuUsuario
FROM tblfamfacturaalmacenmovimiento fam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON fam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fcc.FimId = fim.FimId
					LEFT JOIN tblfinfichaingreso fin
					ON fim.FinId =  fin.FinId
			LEFT JOIN tblperpersonal per
				ON fin.PerIdAsesor = per.PerId
					LEFT JOIN tblusuusuario usu
					ON per.UsuId = usu.UsuId
WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),
IFNULL(

(
SELECT 
usu.UsuUsuario
FROM tblfamfacturaalmacenmovimiento fam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON fam.AmoId = amo.AmoId
			LEFT JOIN tblvdiventadirecta vdi
			ON amo.VdiId = vdi.VdiId
			LEFT JOIN tblperpersonal per
				ON vdi.PerId = per.PerId
					LEFT JOIN tblusuusuario usu
					ON per.UsuId = usu.UsuId
WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
)

,""))  AS "RvrVendedor",

(
IFNULL(
(
SELECT 
CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoMaterno,"")," ",IFNULL(per.PerApellidoPaterno,""))
FROM tblfamfacturaalmacenmovimiento fam
	LEFT JOIN tblamoalmacenmovimiento amo
	ON fam.AmoId = amo.AmoId
		LEFT JOIN tblfccfichaaccion fcc
		ON amo.FccId = fcc.FccId			
			LEFT JOIN tblperpersonal per
				ON fcc.PerId = per.PerId

WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId

ORDER BY amo.AmoFecha DESC
LIMIT 1
),"")
) AS "RvrAsesorAccesorio",

fde.FdeCodigo AS "RvrCodigo",
fde.FdeDescripcion AS "RvrDescripcion",
ROUND(fde.FdeCantidad,2) AS "RvrCantidad",

@CostoDolares:=ROUND(IFNULL(
	(
		SELECT
		lpr.costo
		FROM listaprecios lpr
		WHERE lpr.codigo = REPLACE(fde.FdeCodigo,"-", "")
		LIMIT 1
	)
,IFNULL(
	(
		SELECT 
		plp.PlpPrecioReal
		FROM tblplpproductolistaprecio plp
		WHERE plp.PlpCodigo = REPLACE(fde.FdeCodigo,"-", "")
		ORDER BY plp.PlpTiempoCreacion DESC
		LIMIT 1
	),IFNULL(
		(
			SELECT 
			ede.precio_compra
			FROM entradas_detalle ede
			LEFT JOIN entradas ent
			ON ede.id_entrada = ent.id_entrada
			WHERE ede.id_articulo = fde.FdeCodigo
			AND ent.moneda = "02 - US$ - DOLARES AMERICANOS"
			ORDER BY ent.id_entrada DESC
			LIMIT 1
		),0)
	)

),2) AS "RvrCostoUs",



@CostoIGVDolares:=ROUND((
@CostoDolares*1.18
),2) AS "RvrCostoIGV",

@TipoCambio:=IFNULL((
SELECT
tca.TcaMontoVenta
FROM tbltcatipocambio tca
WHERE tca.TcaFecha = fac.FacFechaEmision
AND tca.MonId = "MON-10001"
LIMIT 1
),
IFNULL(
(
SELECT
tca.TcaMontoVenta
FROM tbltcatipocambio tca
WHERE 1 = 1
AND tca.MonId = "MON-10001"
AND tca.TcaFecha <= fac.FacFechaEmision
ORDER BY tca.TcaFecha DESC
LIMIT 1
)
,0)
) AS "RvrTipoCambio",

@CostoTotal1:=(ROUND((@CostoIGVDolares * @TipoCambio * fde.FdeCantidad),2)) AS "RvrCostoTotal1",

@CostoIGVSoles:=ROUND((

	IFNULL(
	
		(
			SELECT 
			amd.AmdCosto
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
			WHERE REPLACE(pro.ProCodigoOriginal,"-", "") = REPLACE(fde.FdeCodigo,"-", "")
			AND amo.AmoTipo = 1
			AND amd.AmdCosto > 0
			ORDER BY amd.AmdFecha DESC
			LIMIT 1
		)
	
	,IFNULL(
	
		(
			SELECT 
			ede.precio_compra
			FROM entradas_detalle ede
			LEFT JOIN entradas ent
			ON ede.id_entrada = ent.id_entrada
			WHERE  REPLACE(REPLACE(REPLACE(ede.id_articulo, " ", ""), "-", ""), ":", "") = REPLACE(fde.FdeCodigo,"-", "")
			AND ent.moneda = "01 - S/  - SOLES"
			ORDER BY ent.id_entrada DESC
			LIMIT 1
		),0)
		
	)


)


,2) AS "RvrCostoIGVSoles",

@CostoTotal2:=ROUND( (@CostoIGVSoles * fde.FdeCantidad) ,2)AS "RvrCostoTotal2",

ROUND((IF(@CostoTotal1>@CostoTotal2,@CostoTotal1,@CostoTotal2)),2) AS "RvrCostoGeneral",

ROUND((IF(fac.MonId="MON-10001",fde.FdePrecio/fac.FacTipoCambio,0)),2) AS "RvrPrecioUs",

@PrecioSoles:=((IF(fac.MonId="MON-10000",fde.FdePrecio,0))) AS "RvrPrecioS",

ROUND(@PrecioUnitarioSoles:=(IF(fac.MonId="MON-10001",(fde.FdePrecio/fac.FacTipoCambio)*@TipoCambio,0)),2) AS "RvrPrecioUnitario",

ROUND((IF(@PrecioSoles>@PrecioUnitarioSoles,@PrecioSoles,@PrecioUnitarioSoles)),2) AS "RvrPrecioCliente",

0 AS "RvrGanancia",
0 AS "RvrMargen",

ume.UmeNombre AS "RvrUnidadMedida",
((IF(fac.MonId="MON-10000",fde.FdePrecio,0))) AS "RvrPrecioSFinal",



((IF(fac.MonId="MON-10000",( (fde.FdeDescuento/fde.FdeCantidad)* ((fac.FacPorcentajeImpuestoVenta/100)+1) ) ,0))) AS "RvrDescuentoSFinal",
((IF(fac.MonId="MON-10000",fde.FdeImporte,0))) AS "RvrImporteSFinal",
((IF(fac.MonId="MON-10001",fde.FdePrecio/fac.FacTipoCambio,0))) AS "RvrPrecioUSFinal",
((IF(fac.MonId="MON-10001",( (fde.FdeDescuento/fde.FdeCantidad)* ((fac.FacPorcentajeImpuestoVenta/100)+1) ) /fac.FacTipoCambio,0))) AS "RvrDescuentoUSFinal",
((IF(fac.MonId="MON-10001",fde.FdeImporte/fac.FacTipoCambio,0))) AS "RvrImporteUSFinal",

min.MinNombre AS "RvrModalidad",


(
SELECT 
CONCAT(nct.NctNumero,"-",ncr.NcrId)
FROM tblncrnotacredito ncr
LEFT JOIN tblnctnotacreditotalonario nct
ON ncr.NctId = nct.NctId
WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
AND ncr.NcrEstado <> 6
LIMIT 1
) AS RvrNotaCredito,

(
SELECT 
( ncr.NcrTotal/IFNULL(ncr.NcrTipoCambio,1) )
FROM tblncrnotacredito ncr
LEFT JOIN tblnctnotacreditotalonario nct
ON ncr.NctId = nct.NctId
WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
AND ncr.NcrEstado <> 6
LIMIT 1
) AS RvrNotaCreditoTotal,



vma.VmaNombre

FROM tblfdefacturadetalle fde
	LEFT JOIN tblfacfactura fac
	ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
		LEFT JOIN tblftafacturatalonario fta
		ON fac.FtaId = fta.FtaId
			LEFT JOIN tblclicliente cli
			ON fac.CliId = cli.CliId
				LEFT JOIN tblmonmoneda mon
				ON fac.MonId = mon.MonId
					LEFT  JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
						LEFT JOIN tblamdalmacenmovimientodetalle amd
						ON fde.AmdId = amd.AmdId
							LEFT JOIN tblproproducto pro
							ON amd.ProId =  pro .ProId
							LEFT JOIN tblumeunidadmedida ume
							ON amd.UmeId = ume.UmeId
								LEFT JOIN tblrtiproductotipo rti
								ON pro.RtiId = rti.RtiId
									LEFT JOIN tblamoalmacenmovimiento amo
									ON amd.AmoId = amo.AmoId
									LEFT JOIN tblfccfichaaccion fcc
									ON amo.FccId = fcc.FccId
										LEFT JOIN tblfimfichaingresomodalidad fim
										ON fcc.FimId = fim.FimId
											
											LEFT JOIN tblminmodalidadingreso min
											ON fim.MinId = min.MinId
												LEFT JOIN tblfinfichaingreso fin
												ON fim.FinId = fin.FinId
													LEFT JOIN tbleinvehiculoingreso ein
													ON fin.EinId = ein.EinId
														LEFT JOIN tblvvevehiculoversion vve
														ON ein.VveId = vve.VveId
															LEFT JOIN tblvmovehiculomodelo vmo
															ON vve.VmoId = vmo.VmoId
																LEFT JOIN tblvmavehiculomarca vma
																ON vmo.VmaId = vma.VmaId
																
WHERE 1 = 1 AND fac.FacEstado <> 6 AND fac.OvvId IS NULL '.$fechaf.$vmarcaf.$sucursalf.'


				 '.$orden.$paginacion; //.$filtrar.$fecha.$estado.$vmarca.$vmodelo.$ano.$mes.$cvin.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteResumenVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteResumenVenta = new $InsReporteResumenVenta();
                    $ReporteResumenVenta->RvrId = $fila['RvrId'];
					$ReporteResumenVenta->RvrDoc = $fila['RvrDoc'];					
					$ReporteResumenVenta->RvrFecha = $fila['RvrFecha'];
					$ReporteResumenVenta->RvrTipoMoneda = $fila['RvrTipoMoneda'];					
					$ReporteResumenVenta->RvrOrdenTrabajo = $fila['RvrOrdenTrabajo'];
					$ReporteResumenVenta->RvrCliente = $fila['RvrCliente'];
					
					$ReporteResumenVenta->RvrLocal = $fila['RvrLocal'];
					$ReporteResumenVenta->RvrMarca = $fila['RvrMarca'];
					$ReporteResumenVenta->RvrResumen = $fila['RvrResumen'];
					$ReporteResumenVenta->RvrTipo = $fila['RvrTipo'];
					$ReporteResumenVenta->RvrServicios = $fila['RvrServicios'];
					$ReporteResumenVenta->RvrTipoDetalle = $fila['RvrTipoDetalle'];
					
					$ReporteResumenVenta->RvrVendedor = $fila['RvrVendedor'];
					$ReporteResumenVenta->RvrAsesorAccesorio = $fila['RvrAsesorAccesorio'];
					$ReporteResumenVenta->RvrCodigo = $fila['RvrCodigo'];
					$ReporteResumenVenta->RvrDescripcion = $fila['RvrDescripcion'];
					
					$ReporteResumenVenta->RvrCantidad = $fila['RvrCantidad'];
					$ReporteResumenVenta->RvrCostoUs = $fila['RvrCostoUs'];
					$ReporteResumenVenta->RvrCostoIgv = $fila['RvrCostoIgv'];
					$ReporteResumenVenta->RvrTipoCambio = $fila['RvrTipoCambio'];
					$ReporteResumenVenta->RvrCostoTotal1 = $fila['RvrCostoTotal1'];
					$ReporteResumenVenta->RvrCostoIGVSoles = $fila['RvrCostoIGVSoles'];
					
					$ReporteResumenVenta->RvrCostoTotal2 = $fila['RvrCostoTotal2'];
					$ReporteResumenVenta->RvrCostoGeneral = $fila['RvrCostoGeneral'];
					$ReporteResumenVenta->RvrPrecioUs = $fila['RvrPrecioUs'];
					$ReporteResumenVenta->RvvrPrecioS = $fila['RvvrPrecioS'];
			
					$ReporteResumenVenta->RvrPrecioUnitario = $fila['RvrPrecioUnitario'];
					$ReporteResumenVenta->RvrPrecioCliente = $fila['RvrPrecioCliente'];
					$ReporteResumenVenta->RvrGanancia = $fila['RvrGanancia'];
					$ReporteResumenVenta->RvrMargen = $fila['RvrMargen'];
					
					$ReporteResumenVenta->RvrUnidadMedida = $fila['RvrUnidadMedida'];
					
					$ReporteResumenVenta->RvrPrecioSFinal = $fila['RvrPrecioSFinal'];
					$ReporteResumenVenta->RvrDescuentoSFinal = $fila['RvrDescuentoSFinal'];
					$ReporteResumenVenta->RvrPrecioDescuentoSFinal = $ReporteResumenVenta->RvrPrecioSFinal - $ReporteResumenVenta->RvrDescuentoSFinal;
					
					$ReporteResumenVenta->RvrImporteSFinal = $fila['RvrImporteSFinal'];
					$ReporteResumenVenta->RvrImporteDescuentoSFinal = $ReporteResumenVenta->RvrImporteSFinal - ($ReporteResumenVenta->RvrDescuentoSFinal*$ReporteResumenVenta->RvrCantidad);
					
					$ReporteResumenVenta->RvrPrecioUSFinal = $fila['RvrPrecioUSFinal'];
					$ReporteResumenVenta->RvrDescuentoUSFinal = $fila['RvrDescuentoUSFinal'];
					$ReporteResumenVenta->RvrPrecioDescuentoUSFinal = $ReporteResumenVenta->RvrPrecioUSFinal - $ReporteResumenVenta->RvrDescuentoUSFinal;
					
					$ReporteResumenVenta->RvrImporteUSFinal = $fila['RvrImporteUSFinal'];
					$ReporteResumenVenta->RvrImporteDescuentoUSFinal = $ReporteResumenVenta->RvrImporteUSFinal - ($ReporteResumenVenta->RvrDescuentoUSFinal*$ReporteResumenVenta->RvrCantidad);
					
					
					
					$ReporteResumenVenta->RvrModalidad = $fila['RvrModalidad'];
					$ReporteResumenVenta->RvrNotaCredito = $fila['RvrNotaCredito'];		
					$ReporteResumenVenta->RvrNotaCreditoTotal = $fila['RvrNotaCreditoTotal'];		
							
                    $ReporteResumenVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteResumenVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


}
?>