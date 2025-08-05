<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteVentaResumen
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteVentaResumen {

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}



    public function MtdObtenerReporteVentaResumenes($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'RveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAno=NULL,$oMes=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
				$sucursalb = ' AND DATE(bol.SucId) = "'.$oSucursal.'"';	
				$sucursalf = ' AND DATE(fac.SucId) = "'.$oSucursal.'"';		
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

0 AS "RvrAsesorAccesorio",

bde.BdeCodigo AS "RvrCodigo",
bde.BdeDescripcion AS "RvrDescripcion",
ROUND(bde.BdeCantidad,2) AS "RvrCantidad",

@CostoDolares:=ROUND(IFNULL((
SELECT 
plp.PlpPrecioReal
FROM tblplpproductolistaprecio plp
WHERE plp.PlpCodigo = bde.BdeCodigo
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
)

,0)),2) AS "RvrCostoUs",

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

@CostoIGVSoles:=ROUND((IFNULL(
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

,0)),2) AS "RvrCostoIGVSoles",

@CostoTotal2:=ROUND( (@CostoIGVSoles * bde.BdeCantidad) ,2)AS "RvrCostoTotal2",

ROUND((IF(@CostoTotal1>@CostoTotal2,@CostoTotal1,@CostoTotal2)),2) AS "RvrCostoGeneral",

ROUND((IF(bol.MonId="MON-10001",bde.BdePrecio/bol.BolTipoCambio,0)),2) AS "RvrPrecioUs",

@PrecioSoles:=((IF(bol.MonId="MON-10000",bde.BdePrecio,0))) AS "RvrPrecioS",

ROUND(@PrecioUnitarioSoles:=(IF(bol.MonId="MON-10001",(bde.BdePrecio/bol.BolTipoCambio)*@TipoCambio,0)),2) AS "RvrPrecioUnitario",

ROUND((IF(@PrecioSoles>@PrecioUnitarioSoles,@PrecioSoles,@PrecioUnitarioSoles)),2) AS "RvrPrecioCliente",

0 AS "RvrGanancia",
0 AS "RvrMargen"


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

WHERE 1 = 1 AND bol.BolEstado <> 6 '.$fechab.$sucursalb.'

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

0 AS "RvrAsesorAccesorio",

fde.FdeCodigo AS "RvrCodigo",
fde.FdeDescripcion AS "RvrDescripcion",
ROUND(fde.FdeCantidad,2) AS "RvrCantidad",

@CostoDolares:=ROUND(IFNULL((
SELECT 
plp.PlpPrecioReal
FROM tblplpproductolistaprecio plp
WHERE plp.PlpCodigo = fde.FdeCodigo
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
)

,0)),2) AS "RvrCostoUs",

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

@CostoIGVSoles:=ROUND((IFNULL(
(
SELECT 
ede.precio_compra
FROM entradas_detalle ede
LEFT JOIN entradas ent
ON ede.id_entrada = ent.id_entrada
WHERE 

REPLACE(REPLACE(REPLACE(ede.id_articulo, " ", ""), "-", ""), ":", "") = REPLACE(fde.FdeCodigo,"-", "")
AND ent.moneda = "01 - S/  - SOLES"
ORDER BY ent.id_entrada DESC
LIMIT 1
)

,0)),2) AS "RvrCostoIGVSoles",

@CostoTotal2:=ROUND( (@CostoIGVSoles * fde.FdeCantidad) ,2)AS "RvrCostoTotal2",

ROUND((IF(@CostoTotal1>@CostoTotal2,@CostoTotal1,@CostoTotal2)),2) AS "RvrCostoGeneral",

ROUND((IF(fac.MonId="MON-10001",fde.FdePrecio/fac.FacTipoCambio,0)),2) AS "RvrPrecioUs",

@PrecioSoles:=((IF(fac.MonId="MON-10000",fde.FdePrecio,0))) AS "RvrPrecioS",

ROUND(@PrecioUnitarioSoles:=(IF(fac.MonId="MON-10001",(fde.FdePrecio/fac.FacTipoCambio)*@TipoCambio,0)),2) AS "RvrPrecioUnitario",

ROUND((IF(@PrecioSoles>@PrecioUnitarioSoles,@PrecioSoles,@PrecioUnitarioSoles)),2) AS "RvrPrecioCliente",

0 AS "RvrGanancia",
0 AS "RvrMargen"

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
WHERE 1 = 1 AND fac.FacEstado <> 6  '.$fechaf.$sucursalf.'


				 '.$orden.$paginacion; //.$filtrar.$fecha.$estado.$vmarca.$vmodelo.$ano.$mes.$cvin.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteVentaResumen = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteVentaResumen = new $InsReporteVentaResumen();
                    $ReporteVentaResumen->RvrId = $fila['RvrId'];
					$ReporteVentaResumen->RvrDoc = $fila['RvrDoc'];					
					$ReporteVentaResumen->RvrFecha = $fila['RvrFecha'];
					$ReporteVentaResumen->RvrTipoMoneda = $fila['RvrTipoMoneda'];					
					$ReporteVentaResumen->RvrOrdenTrabajo = $fila['RvrOrdenTrabajo'];
					$ReporteVentaResumen->RvrCliente = $fila['RvrCliente'];
					
					$ReporteVentaResumen->RvrLocal = $fila['RvrLocal'];
					$ReporteVentaResumen->RvrMarca = $fila['RvrMarca'];
					$ReporteVentaResumen->RvrResumen = $fila['RvrResumen'];
					$ReporteVentaResumen->RvrTipo = $fila['RvrTipo'];
					$ReporteVentaResumen->RvrServicios = $fila['RvrServicios'];
					$ReporteVentaResumen->RvrTipoDetalle = $fila['RvrTipoDetalle'];
					
					$ReporteVentaResumen->RvrVendedor = $fila['RvrVendedor'];
					$ReporteVentaResumen->RvrAsesorAccesorio = $fila['RvrAsesorAccesorio'];
					$ReporteVentaResumen->RvrCodigo = $fila['RvrCodigo'];
					$ReporteVentaResumen->RvrDescripcion = $fila['RvrDescripcion'];
					
					$ReporteVentaResumen->RvrCantidad = $fila['RvrCantidad'];
					$ReporteVentaResumen->RvrCostoUs = $fila['RvrCostoUs'];
					$ReporteVentaResumen->RvrCostoIgv = $fila['RvrCostoIgv'];
					$ReporteVentaResumen->RvrTipoCambio = $fila['RvrTipoCambio'];
					$ReporteVentaResumen->RvrCostoTotal1 = $fila['RvrCostoTotal1'];
					$ReporteVentaResumen->RvrCostoIGVSoles = $fila['RvrCostoIGVSoles'];
					
					$ReporteVentaResumen->RvrCostoTotal2 = $fila['RvrCostoTotal2'];
					$ReporteVentaResumen->RvrCostoGeneral = $fila['RvrCostoGeneral'];
					$ReporteVentaResumen->RvrPrecioUs = $fila['RvrPrecioUs'];
					$ReporteVentaResumen->RvvrPrecioS = $fila['RvvrPrecioS'];
			
					$ReporteVentaResumen->RvrPrecioUnitario = $fila['RvrPrecioUnitario'];
					$ReporteVentaResumen->RvrPrecioCliente = $fila['RvrPrecioCliente'];
					$ReporteVentaResumen->RvrGanancia = $fila['RvrGanancia'];
					$ReporteVentaResumen->RvrMargen = $fila['RvrMargen'];
							
							
                    $ReporteVentaResumen->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteVentaResumen;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	/*
	//Accion eliminar	 
	public function MtdEliminarReporteVentaResumen($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsReporteVentaResumenVehiculo = new ClsReporteVentaResumenVehiculo();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					
						$sql = 'DELETE FROM tmprveresumenventa WHERE  (RveId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
//							//$this->MtdAuditarReporteVentaResumen(3,"Se elimino la ReporteVentaResumen",$elemento);		
						}
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	*/
	/*
	//Accion eliminar	 
	public function MtdActualizarEstadoReporteVentaResumen($oElementos,$oEstado,$oTransaccion=true) {

		$error = false;

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$sql = 'UPDATE tmprveresumenventa SET RveEstado = '.$oEstado.' WHERE RveId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						
						$Auditoria = "Se actualizo el Estado de la ReporteVentaResumen";

						$this->RveId = $elemento;						
						//$this->MtdAuditarReporteVentaResumen(2,$Auditoria,$elemento);

					}
				}
			$i++;
	
			}

		if($error){
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionDeshacer();			
			}
			return false;
		}else{	
			if($oTransaccion){	
				$this->InsMysql->MtdTransaccionHacer();			
			}
			return true;
		}									
	}*/
	
	
	public function MtdRegistrarReporteVentaResumen() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarReporteVentaResumenId();
		
		$this->InsMysql->MtdTransaccionIniciar();		
					
			$sql = 'INSERT INTO tmprveresumenventa (
			RveId,
			VmaId,
			
			RveVentaTallerMarca,
			RveVentaPPMarca,
			RveVentaMesonMarca,
			RveVentaRetailMarca,
			RveVentaRetailLubricantes,
			RveTotalVentasRetail,
			RveMargenAporte,
			RveAno,
			RveMes,
			RveTiempoCreacion
			) 
			VALUES (
			"'.($this->RveId).'", 
			"'.($this->VmaId).'", 
			
			"'.($this->RveVentaTallerMarca).'", 
			"'.($this->RveVentaPPMarca).'", 
			"'.($this->RveVentaMesonMarca).'",
			"'.($this->RveVentaRetailMarca).'",
			"'.($this->RveVentaRetailLubricantes).'",
			"'.($this->RveTotalVentasRetail).'",
			"'.($this->RveMargenAporte).'",
			"'.($this->RveAno).'",
			"'.($this->RveMes).'",
			"'.($this->RveTiempoCreacion).'");';			

			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
				if(!$resultado) {							
					$error = true;
				} 
			}

		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();		
			//$this->MtdAuditarReporteVentaResumen(1,"Se registro la ReporteVentaResumen",$this);			
			return true;
		}
					
	}
	/*
	public function MtdEditarReporteVentaResumen() {

		global $Resultado;
		$error = false;
	
			$this->InsMysql->MtdTransaccionIniciar();
	
			$sql = 'UPDATE tmprveresumenventa SET
			RveVentaTallerMarca = "'.($this->RveVentaTallerMarca).'",
			RveVentaPPMarca = "'.($this->RveVentaPPMarca).'",
			RveVentaMesonMarca = "'.($this->RveVentaMesonMarca).'",
			RveVentaRetailMarca = "'.($this->RveVentaRetailMarca).'",
			RveVentaRetailLubricantes = "'.($this->RveVentaRetailLubricantes).'",	
			RveTotalVentasRetail = "'.($this->RveTotalVentasRetail).'",	
			RveAno = "'.($this->RveAno).'",
			RveMes = "'.($this->RveMes).'"

			WHERE RveId = "'.($this->RveId).'";';			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				//$this->MtdAuditarReporteVentaResumen(2,"Se edito la ReporteVentaResumen",$this);		
				return true;
			}	
				
		}	
		
	*/
	
	/*	private function MtdAuditarReporteVentaResumen($oAccion,$oDescripcion,$oDatos){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->RveId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		*/

}
?>