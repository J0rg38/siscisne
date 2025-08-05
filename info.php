








<!-- gwm 10.0 PROD NPO revision:27818 11122015 -->
<html>
    <HEAD>
        <link href="css/ie.css" type=text/css rel=stylesheet>
        <link href="css/iegtn.css" type=text/css rel=stylesheet>
        <link type="text/css" rel="stylesheet" href="css/gmvisIIShort.css" />
		<link type="text/css" rel="stylesheet" href="css/ext/ext-all.css?cacheversion=3.3.1" />
        <link type="text/css" rel="stylesheet" href="css/ext/xtheme-gray.css?cacheversion=3.3.1" />
        <link type="text/css" rel="stylesheet" href="css/ext/gwm-ext.css" />
        <link type="text/css" rel="stylesheet" href="css/calendar/calendar.css" />
        <script language=javascript src="js/global_gtn.js"></script>
        <script language="JavaScript" src="js/global.js?v=3"></script>
        <script type="text/javascript" src="js/translatedValues.jsp" charset="UTF-8"></script>
<!-- Begin fix for IE11 compatibility Chris Wessel Jan 2016 -->       
        <script language="JavaScript" src="js/common.js?v=6"></script>
<!-- End fix for IE11 compatibility Chris Wessel Jan 2016 -->    
        <script language="JavaScript" src="js/menu.js"></script>
        <script language="JavaScript" src="js/ext-base.js?cacheversion=3.3.1"></script>
        <script language="JavaScript" src="js/ext-all.js?cacheversion=3.3.1"></script>
        <script language="JavaScript" src="js/gwm-ext.js"></script>
        <script type="text/javascript" src="js/calendar/calendar.merged.min.js"></script>
        <script type="text/javascript" src="js/calendar/gwmcal.js"></script>
        <title>Administración Global de Garantía</title>
    </HEAD>
<script type="text/javaScript" language="javaScript">function checkBAC(){ if(getCookie('bac')!='6f666339776c3155414c704b744261347734452f385931786a4d6f3d'){alert('Su BAC ha sido cambiado desde otra ventana. Con el fin de prevenir errores usted será reenviado al mapa del sitio.');window.onfocus='';window.location='./sitemap.do';}}window.onfocus=checkBAC;</script>
    <body style="background-color:#e5eaf7; margin:0px;">
    	<div id="throbber" style="position:absolute;display:none;width:100%;">
    	<iframe style="height:100%;width:100%;opacity:0.4;filter:alpha(opacity=40);position:fixed;z-index:5;" frameborder="0"></iframe>
    	<img src="./images/loader.gif" style="position:absolute;top:50%;left:50%;z-index=6"/>
    	</div>
    	

	<script type="text/javascript">Ext.onReady(function(){setTimeoutCookie();});</script>
	<div id="timeout-win" class="x-hidden">
	  <div class="x-window-header">Inactividad de Sesión</div>
	    <p class="x-window-body" id="javascript_countdown_time"></p>
	</div>

<div id="loading_message" class="h02" style="position: absolute; float: right; top: 0; right: 0; display: none; background-color: #FED27F">Espere, por favor.</div>
        <table style="width:100%;" cellspacing='0' cellpadding='0'>
            <tr>
                <td>











<!-- Banner with GM logo -->
 

<!-- Update to latest DW 10/14/2007  Matt Brown -->
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD colSpan=7><IMG height=4 alt=""
      src="en_US/images/orange.gif" width="100%"></TD></TR>
  <TR>
    <TD class=DWhead noWrap width=380 bgColor=#9da9c0 height=41 rowSpan=3><A
      href="https://www.autopartners.net/apps/gcportal/portal/dt?provider=HomeContainer"><IMG
      height=41 alt="General Motors"
      src="en_US/images/global_connect-1.gif" width=380 border=0></A></TD>
    <TD noWrap bgColor=#9da9c0 colSpan=6></TD></TR>
  <TR>
    <TD class=DWh01 noWrap width="45%" bgColor=#9da9c0>&nbsp; Ivan&nbsp;Quezada
      <BR>&nbsp; <!-- TODO find user description --><BR><SPAN class=DWh01a>&nbsp; 19 de abril de 2016 </SPAN></TD>
    <TD align=middle width=1 bgColor=#032a8e height=43></TD>
    <TD width=9 bgColor=#9da9c0></TD>
    <TD class=DWh01 vAlign=top noWrap bgColor=#9da9c0>
      <P><A class=DWh05 onmouseover="DWMM_preloadMouseOver('pedit')"
      onmouseout="DWMM_preloadMouseOut('pedit')"
      href="https://www.autopartners.net/apps/gcportal/portal/dt?provider=EditProfileContainer"><IMG
      height=9 alt="" src="en_US/images/i-edit.gif" width=7
      border=0 name=pedit>&nbsp;&nbsp;Actualizar Mi Perfil</A><BR>
      <SCRIPT language=javascript>
function KillAllSession()
{if(confirm('¿Está seguro de que desea cerrar sesión?') == true){KillWebSealSession();}}
function pause(numberMillis) {
var now = new Date();
var exitTime = now.getTime() + numberMillis;
while (true) {
now = new Date();
if (now.getTime() > exitTime)
{return;}
}
}

function KillWebSealSession()
{
showLoading();
urlList=new Array("./Logout.do","/pkmslogout");
procAjaxLogout();
}
var lgtrqst=false;
var urlList;
function procAjaxLogout()
{
	lgtrqst=false;
	if(urlList.length > 1)
	{
	var url = urlList.shift();
	if (window.XMLHttpRequest)
    {
		lgtrqst = new XMLHttpRequest();
		lgtrqst.onreadystatechange =  procAjaxLogoutResponse;
        try
        {
        	lgtrqst.open("GET", url, true); //was get
        } catch (e) {
        }
        lgtrqst.send(null);
    }
    else if (window.ActiveXObject)
    {
    	lgtrqst = new ActiveXObject("Microsoft.XMLHTTP");
        if (lgtrqst)
        {
        	lgtrqst.onreadystatechange = procAjaxLogoutResponse;
        	lgtrqst.open("GET", url, true);
        	lgtrqst.send();
        }
    }
    }
    else if(urlList.length > 0)
    {
    	window.location=urlList.shift();
    }
}

function procAjaxLogoutResponse()
{
    if (lgtrqst.readyState == 4)
    {
        procAjaxLogout(urlList);
    }
}
</SCRIPT>

      <A class=DWh05 onmouseover="DWMM_LogoutpreloadMouseOver('logout')"
      onmouseout="DWMM_LogoutpreloadMouseOut('logout')"
      href="javascript:KillAllSession();"><IMG height=9 alt=""
      src="en_US/images/i-logout.gif" width=7 border=0
      name=logout>&nbsp;&nbsp;Cerrar Sesión</A>

<BR></P></TD></TR></TBODY></TABLE>

</td>
            </tr>
            <tr>
                <td>
                    
                    
                    
                    
                    
                        
                        
                        
                    









<!-- Begin Breadcrumb -->
<table width="100%" height="18" border="0" cellspacing="0" cellpadding="0" bgcolor="#828789">
	<tbody>
		<tr>
			<td width="84" class="h01" align="left">
				<nobr>&nbsp;Administración Global de Garantía:&nbsp;</nobr>
			</td>
			<td nowrap>
				<a href="sitemap.do" class="bread">Principal</a>
				
					
						<span class="bread">
							&nbsp;&gt;&nbsp; <a href="sitemap.do?processArea=prepare" class="bread">TRANSACCIONES</a>
							&nbsp;&gt;&nbsp;
						</span>
						<span class="breadStaticText" >
							Crear Nueva Transacción
						</span>
					
					
				
			</td>
		</tr>
	</tbody>
</table>
<!-- End Breadcrumb -->

                </td>
            </tr>
            <tr>
                <td>
                    
                        
                        
                    











<!-- Tabs -->
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0"
	class="owbbar">
	<tbody>
		<tr>
			<TD style="padding: 0px;">
				<table style="" cellpadding="0" cellspacing="0">
					<TR>
						
						
						
						<!-- interface -->
						
							<TD
								class="mainTab mainTabOff"
								onClick="followLink('./sitemap.do?processArea=interface');"
								onMouseOver="showDropMenu(this, 0);">Consulta General</TD>
							<TD>
								<table width="1" height="32" border="0" cellspacing="0"
									cellpadding="0">
									<tr>
										<td bgcolor=#8e8f91 height=3></td>
									</tr>
									<tr>
										<td height="28" bgcolor="#000000"></td>
									</tr>
								</table>
							</TD>
						
						
							<TD
								class="mainTab mainTabOn"
								onClick="followLink('./sitemap.do?processArea=prepare');"
								onMouseOver="showDropMenu(this, 1);">TRANSACCIONES</TD>
							<TD>
								<table width="1" height="32" border="0" cellspacing="0"
									cellpadding="0">
									<tr>
										<td bgcolor=#8e8f91 height=3></td>
									</tr>
									<tr>
										<td height="28" bgcolor="#000000"></td>
									</tr>
								</table>
							</TD>
						
						<!-- reconcile -->
						
							
								<TD
									class="mainTab mainTabOff"
									onClick="followLink('./sitemap.do?processArea=reconcile');"
									onMouseOver="showDropMenu(this, 2);">Consulta de Resultados</TD>
								<TD>
									<table width="1" height="32" border="0" cellspacing="0"
										cellpadding="0">
										<tr>
											<td bgcolor=#8e8f91 height=3></td>
										</tr>
										<tr>
											<td height="28" bgcolor="#000000"></td>
										</tr>
									</table>
								</TD>
							
						
						<!-- analyze -->
						
							<TD
								class="mainTab mainTabOff"
								onClick="followLink('./sitemap.do?processArea=analyze');"
								onMouseOver="showDropMenu(this, 3);">Análisis de Garantía</TD>
							<TD>
								<table width="1" height="32" border="0" cellspacing="0"
									cellpadding="0">
									<tr>
										<td bgcolor=#8e8f91 height=3></td>
									</tr>
									<tr>
										<td height="28" bgcolor="#000000"></td>
									</tr>
								</table>
							</TD>
						
						<!-- Management Planning -->
						
							<TD
								class="mainTab mainTabOff"
								onClick="followLink('./sitemap.do?processArea=planning');"
								onMouseOver="showDropMenu(this, 5);">Planificación de Administración</TD>
							<TD>
								<table width="1" height="32" border="0" cellspacing="0"
									cellpadding="0">
									<tr>
										<td bgcolor=#8e8f91 height=3></td>
									</tr>
									<tr>
										<td height="28" bgcolor="#000000"></td>
									</tr>
								</table>
							</TD>
						
						<!-- parts -->
						
							<TD
								class="mainTab mainTabOff"
								onClick="followLink('./sitemap.do?processArea=parts');"
								onMouseOver="showDropMenu(this, 6);">Retorno de Partes</TD>
							<TD>
								<table width="1" height="32" border="0" cellspacing="0"
									cellpadding="0">
									<tr>
										<td bgcolor=#8e8f91 height=3></td>
									</tr>
									<tr>
										<td height="28" bgcolor="#000000"></td>
									</tr>
								</table>
							</TD>
						

						<!-- options -->
						
							<TD
								class="mainTab mainTabOff"
								onClick="followLink('./sitemap.do?processArea=options');"
								onMouseOver="showDropMenu(this, 7);">Opciones del Usuario</TD>
							<TD>
								<table width="1" height="32" border="0" cellspacing="0"
									cellpadding="0">
									<tr>
										<td bgcolor=#8e8f91 height=3></td>
									</tr>
									<tr>
										<td height="28" bgcolor="#000000"></td>
									</tr>
								</table>
							</TD>
						


						
							
						
						
						<!--End Main Menu-->
					</TR>
				</table>
			</TD>
		</tr>
	</tbody>
</table>
<iFrame id="frmFrame" style="position: absolute; display: none;"
	src="images/spacer.gif"></iFrame>
<div id="dropMenu_0" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>
		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);">
						<a href="initVehicleHistoryEntry.do" class="link07" onclick="showLoading();">Consulta Historico de Vehiculo</a>
					 </TD>
			</TR>
		

		
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="initMajorAssemblyEntry.do" class="link07" onclick="showLoading();">Consulta Historial de Conjunto Mayor</a></TD>
				</TR>
			
		

		
	</table>
</div>
<div id="dropMenu_1" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>

		
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="transactionForm.do" class="link07" onclick="showLoading();">Crear Nueva Transacción</a></TD>
				</TR>
			

			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="prepareDrafts.do" class="link07" onclick="showLoading();">Ver Borrador de Transacción</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="prepareAll.do" class="link07" onclick="showLoading();">Ver Transacciones Procesadas</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="preparePending.do" class="link07" onclick="showLoading();">Ver Transacciones Pendientes</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="prepareApproved.do" class="link07" onclick="showLoading();">Ver Transacciones Aceptadas</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="prepareByJobCard.do" class="link07" onclick="showLoading();">Ver Transacciones por Orden Reparación</a></TD>
				</TR>
			
			
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="prepareRejected.do" class="link07" onclick="showLoading();">Corregir una Transacción Rechazada</a></TD>
				</TR>
			
		
		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);"><a href="SearchPreApproval.do" class="link07" onclick="showLoading();">Buscar/Crear un Documento de Pre-Autorización</a></TD>
			</TR>
		
	</table>
</div>

	<div id="dropMenu_2" class="dropDownMenus"
		onMouseOver="dropMenu_onMouseOver(this);">
		<table style="margin: 5px 0px 5px 0px;" cellpadding="2"
			cellspacing='0'>
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="reconcilePrepareRejected.do" class="link07" onclick="showLoading();">Corregir una Transacción Rechazada</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="reconcilePrepareApproved.do" class="link07" onclick="showLoading();">Ver Transacciones Aceptadas</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="reconcileInitVehicleHistoryEntry.do" class="link07" onclick="showLoading();">Consulta Historico de Vehiculo</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="reconcileInitMajorAssemblyEntry.do" class="link07" onclick="showLoading();">Consulta Historial de Conjunto Mayor</a></TD>
				</TR>
			



			
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="sai-dispositionReport.do" class="link07" onclick="showLoading();">Ver Reporte Resumen de Transacciones</a></TD>
				</TR>
			
			
			
		</table>
	</div>



<div id="dropMenu_3" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>
		
		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitSAEmpowerment.do" class="link07" onclick="showLoading();">Ver Perfil del Agente de Servicio</a></TD>
			</TR>
		
		

		
		
			
		
		
			
		

		
		
			
		
		
		
		<TR>
			<TD class="menuItemsArr">&#8594;</TD> 
			<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitTransSearchLiteSA.do" class="link07" onclick="showLoading();">Buscar Transacciones</a></TD>
		</TR>
		

		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitQueuedTransSearch.do" class="link07" onclick="showLoading();">Lista de Busqueda de Transacciones</a></TD>
			</TR>
		
		
		
		
<!--  Start EDW Cognos link fix -- Kevin S. -->				
				
 				 
				





<!-- 				<TR> -->

<!-- 					<TD class="menuItemsArr">&#8594;</TD> -->





<!-- 				</TR> -->



<!-- 				<TR> -->
<!-- 					<TD class="menuItemsArr">&#8594;</TD> -->





<!-- 				</TR> -->







<!--  End EDW Cognos link fix -- Kevin S. -->	

		
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitTransactionActivityLogSA.do" class="link07" onclick="showLoading();">Ver Registro de Actividades de Transacciones</a></TD>
				</TR>
			
			
		
		
			
				
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitSAServiceAgentDetail.do" class="link07" onclick="showLoading();">Informe de Analisis  Resumido del Agente de Servicio</a></TD>
				</TR>
				
			
		
		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);"><a href="sitemap.do?processArea=report" class="link07" onclick="showLoading();">Ver Reportes de Análisis de Garantías</a></TD>
			</TR>
		
		
		
			
		
		
			
		
		
			
		
		
		
			
		
		
			
		
		
			
		

		
		<TR>
			<TD class="menuItemsArr">&#8594;</TD>
			<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitReportGenerator.do" class="link07" onclick="showLoading();">Generador de Reporte</a></TD>
		</TR>
		
		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitServiceAgentSelfReviewReport.do" class="link07" onclick="showLoading();">Ver Reportes de Auto-Revisión del Agente de Servicio</a></TD>
			</TR>
		
		
		
	</table>
</div>
<div id="dropMenu_5" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>
		
			

				
					<TR>
						<TD class="menuItemsArr">&#8594;</TD>
						<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitContactDocumentListSA.do" class="link07" onclick="showLoading();">Desarrollar/Ver Documentos de Contactos</a></TD>
					</TR>
				
				

			
			
				
				
					<TR>
						<TD class="menuItemsArr">&#8594;</TD>
						<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitServiceAgentGoalsSA.do" class="link07" onclick="showLoading();">Desarrollar/Revisar Metas</a></TD>
					</TR>
				
			
			
				
				
					<TR>
						<TD class="menuItemsArr">&#8594;</TD>
						<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitServiceAgentActionPlansSA.do" class="link07" onclick="showLoading();">Desarrollar/Ver Planes de Acción</a></TD>
					</TR>
				
			
		
	</table>
</div>

<div id="dropMenu_6" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>
		
			<TR>
				<TD class="menuItemsArr">&#8594;</TD>
				<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitSummaryServiceAgentPartsReturn.do" class="link07" onclick="showLoading();">Revisar Requerimientos del Retorno de Partes Abiertas del Agente de Servicio</a></TD>
			</TR>
		
		
		
			
			
			
			
			
			
			
			
			
			
			
			
			
		
	</table>
</div>

<div id="dropMenu_7" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>
		
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="MyToolkitOptions.do" class="link07" onclick="showLoading();">Opciones del Usuario</a></TD>
				</TR>
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="InitTransactionResultsChooseColumns.do" class="link07" onclick="showLoading();">Personalizar Columnas de Resultados de Transacciones</a></TD>
				</TR>
			
			
			
				<TR>
					<TD class="menuItemsArr">&#8594;</TD>
					<TD class="menuItems" onmouseover="menuLink(this);"><a href="ViewTransactionFlags.do" class="link07" onclick="showLoading();">Ver Señales</a></TD>
				</TR>
			
			

				

				
			


		
	</table>
</div>
<!-- end TABS -->

<div id="dropMenu_8" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>
		
			
		


	</table>
</div>

<div id="dropMenu_9" class="dropDownMenus"
	onMouseOver="dropMenu_onMouseOver(this);">
	<table style="margin: 5px 0px 5px 0px;" cellpadding="2" cellspacing='0'>



		
		

	</table>
</div>

<!-- jspname: menu.jsp -->


                </td>
            </tr>
            <tr>
                <td style="padding:6px;">
                
                    
                    
                    
                    
                    
                    
                    
                












<!-- Default Page Header.  Overrite me with a page specific header. -->

<!-- start Screen Title -->
<table style="width:580px;" cellspacing="0" cellpadding="0">
	<TR>
		<td class="head2">
            

			Crear Nueva Transacción


		</td>
		<TD style="text-align:right;">
			
							<!--  Icon thing  -->
							<table style='width:250px;' cellpadding=0 cellspacing=0>
								<TR>
									<TD style="text-align:right; vertical-align:middle;width:185px">
										<div id="divIconMessageHeader" class="msgBox">&nbsp;</div>
									</TD>
									<TD style="text-align:right; vertical-align:middle;width:65px">
                                    
                                    
                                   
                                     
										<img 
											class="icon" 
											src="images/help_up.gif" 
											onMouseOver="icon_onMouseOver(this, 
																		'help_down.gif', 
																		'divIconMessageHeader',
																		'ayuda para esta página', 
																		'javascript:showHelp(\'html/help/sai/es/transactionformpage.htm\')')">
                                    
                                    
                                   	
                                   	</TD>
								</TR>
							</table>
							<!-- end of Icon thing -->																
						
		</TD>
	</TR>
  <TR>
    <TD style="BACKGROUND-COLOR:8d9095" colspan="3"></TD>
  </TR>
  <!-- page description -->
  
        
  <TR>
    <TD style="padding:10px; height:30px;" colspan="5">
    Esta pantalla permite al usuario crear una nueva transacción
    </TD>
  </TR>
  
</table>
<!-- End Screen Title -->
                
                </td>
            </tr>

            <tr>
                <td>
                <div id="common_calDiv"  style="display:none;position:absolute"></div>
                    <table style="margin-left:6px; vertical-align:top; width:760px;" border="0" cellspacing="0" cellpadding="0">
                        <TR>
                            <TD>
                                




<!-- Begin fix for IE11 compatibility Chris Wessel Jan 2016 -->    
<script type="text/javaScript" language="javaScript" src="js/common.js?v=6"></script>
<!-- Begin fix for IE11 compatibility Chris Wessel Jan 2016 -->    
<script type="text/javaScript" language="javaScript" src="js/menu.js"></script>





<!-- BAC Selctor -->
<form name="BacSelectorFormBean" method="post" action="SetBACSessionSelector.do" onsubmit="return evalAction();">

	

	<input type="hidden" name="selectedBacId" value="260815">
	<input type="hidden" name="selectedBusinessUnit" value="7360">
	<input type="hidden" name="selectedServiceAgentId" value="1500086315">
	<input type="hidden" name="selectedRepairingBacId" value="260815">

	<table class="tblBlock" style="background-color: E9EAD9;" cellspacing=0 cellpadding=0>
		<tbody>
			<TR>
				<Td>
				<table border="0" cellpadding="0" cellspacing="0" height="20">
					<tbody>
						<tr valign="middle">
							<td colspan="2"><b>Unidad de Negocio</b></td>
							<td colspan="2"><b>BAC</b></td>
							<td colspan="2"><b>Nombre</b></td>
						</tr>
						<tr>
							<td width="6"></td>
							<td colspan="4" class="red14"><span id="errors" style="color: #ff0000;"></span></td>
						</tr>
						<tr>
							<td width="100">
							    <select name="businessUnitId" onchange="retrieveBACs(this.value)" id="buidSelectSA"><option value="" selected="selected"></option>
								<option value="7360">Perú</option></select>
						    </td>
							<td width="6"></td>
							<td>
							     <div id="bacIdARCBACSelector"><input type="text" name="bacId" size="11" value="" onkeyup="processseKey(this.value);" id="bacTextSA"></div>
							</td>
							<td class="black" align="center" width="40">
							     <div id="bacOrARCBACSelector">or</div>
							</td>
							<td>
							     <div id="bacARCBACSelector">
							         <span id="userBacs"> 
							             <select name="bacId" onchange="setBacId(this.value);" id="bacIdSelectSA"><option value="" selected="selected"></option>
								         <option value="260815">260815 | CYC TACNA</option></select> 
							         </span>
							     </div>
							</td>
							<td width="6"></td>
						</tr>
						<tr valign="middle">
							<td class="gray14" colspan=2><span style="white-space:nowrap;"><b>Unidad de Negocio:</b> Perú&nbsp;</span></td>
							
							<td class="gray14"><b>BAC:</b>260815</td>
							<TD></TD>
							<td class="gray14" ><b>Nombre:</b>
							CYC TACNA</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><b>Agente de Servicio Reparador:</b></td>
							<td>
							     <span id="repairBACList"> 
							         <select name="repairingBacId" onchange="setRepairingBacId(this.value);" id="repairBACSelected"><option value="260815" selected="selected">260815-CYC TACNA</option></select> 
							     </span>
				            </td>
				            <td>
                                                        
                                 <div id="goARCBACSelector"><input type="button" class="menubutton" onmouseover="showcolor(this);"
                                        onclick="validateBac(document.forms['BacSelectorFormBean'].bacId[0].value, document.forms['BacSelectorFormBean'].repairingBacId[0].value);" value="Ir">
                                 </div>
                               
                            </td>
						</tr>
						<tr>
							<td colspan="4" align="right"><b>Dirección: </b></td>
							<td><span id="serviceAgentAddress">AV.MANUEL ODRIA S/N, URB.LOS CEDROS, TACNA, </span></td>
						</tr>
					</tbody>
				</table>
				</Td>
			</TR>
		</tbody>
	</table>
<INPUT TYPE="HIDDEN" NAME="_SEC_TOKEN_" VALUE="6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d"></form>

<script language="javascript">
function validateBac(bacId, repairingBacId){
	if(submitReady) {
	    objBac = document.forms['BacSelectorFormBean'].bacId[1];  
	   	
		if (bacId == ""){
			bacId = 260815;
		}
	
	    var bacFound = 0; 
	    if(bacId){ 
		    for (var i = 0; i < objBac.length && bacFound ==0; i++){
		        if (bacId == objBac.options[i].value){
		            bacFound++;
		        }
		    } 
		}
	
		if (bacId == "" || bacFound == 0){
	        document.getElementById('errors').innerHTML = 'Ha ingresado un BAC no válido o no tiene acceso a ese Cód. de Asoc. Comercial.';
	    }else if (repairingBacId == null || repairingBacId == ""){
	       	document.getElementById('errors').innerHTML = 'Por Favor seleccione un BAC Reparador';
	    }else{
	       	document.BacSelectorFormBean.selectedBacId.value = bacId;
	       	document.BacSelectorFormBean.selectedRepairingBacId.value = repairingBacId;
	       	document.getElementById('errors').innerHTML = "";
	       	document.BacSelectorFormBean.action = "SetBACSessionSelector.do";
	       	eval(document.forms['BacSelectorFormBean'].submit());
	    }
	} else {
		setTimeout("validateBac(document.forms['BacSelectorFormBean'].bacId[0].value, document.forms['BacSelectorFormBean'].repairingBacId[0].value);",200);
	}
}

var submitReady = true;
var entKeyPressed = false;  

function resubmit() {
	if(submitReady) {
		document.BacSelectorFormBean.submit();
	} else {
		setTimeout("resubmit()",200);
	}
}

function evalAction(){
	setTimeout("validateBac(document.forms['BacSelectorFormBean'].bacId[0].value, document.forms['BacSelectorFormBean'].repairingBacId[0].value);",200);
	return false;
}

function processStateChangeBACs(response){ 
     var txtOption = "<select name='bacId' onchange='setBacId(this.value);'><option></option>"+response+"</select>";
     txtOption=txtOption.replace(/\r/g,"<OPTION VALUE=\"");
     txtOption=txtOption.replace(/\t/g,"\">");
     txtOption=txtOption.replace(/\n/g,"</OPTION>");
     document.getElementById('userBacs').innerHTML = txtOption;
     if(document.getElementById('bacTextSA').value.length>=6) {
     	document.BacSelectorFormBean.bacId.value=document.getElementById('bacTextSA').value;
     	setBacId(document.getElementById('bacTextSA').value);
     } else {
     	submitReady=true;
     }
     hideLoading();
}

function retrieveBACs(businessUnitId){
	submitReady=false;
    document.BacSelectorFormBean.selectedBusinessUnit.value = businessUnitId;
    if (businessUnitId != ""){
        showLoading();
        
        url="LoadUserBAC.do";
        params="businessUnitId=" + businessUnitId+"&_SEC_TOKEN_=6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d";
        performAjaxPost(url,params,processStateChangeBACs);
        
    }
}

function processStateChangeRepairingBAC(response){   
     var txtOption = "<select id='repairBACSelected' name='repairingBacId' onchange='setRepairingBacId(this.value);'><option></option>"+response+"</select>";
     txtOption=txtOption.replace(/\r/g,"<OPTION VALUE=\"");
     txtOption=txtOption.replace(/\t/g,"\">");
     txtOption=txtOption.replace(/\n/g,"</OPTION>");
     document.getElementById('repairBACList').innerHTML = txtOption;  
     
     var repairBacs = document.getElementById('repairBACSelected');
     var bacId = document.forms['BacSelectorFormBean'].bacId[0].value;
     for(var i = 0; i< repairBacs.length; i++){ 
         if (repairBacs.options[i].value == bacId){
             repairBacs.options[i].selected = true;
             setRepairingBacId(bacId);
         }
    }  
	submitReady=true;
   hideLoading();
}
function setBacId(bacId){
    document.forms['BacSelectorFormBean'].bacId[0].value = bacId;
    if (bacId != ""){
    	submitReady=false;
        document.getElementById('errors').innerHTML = '';
        showLoading();

        url="LoadRepairingBac.do";
        params="bacId=" + bacId+"&selectedBusinessUnit="+document.BacSelectorFormBean.selectedBusinessUnit.value+"&_SEC_TOKEN_=6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d";
        performAjaxPost(url, params, processStateChangeRepairingBAC);
    } 
}

function processStateChangeAddress(response){
	var txtOption = response;
	document.getElementById('serviceAgentAddress').innerHTML = txtOption;
	submitReady=true;
	hideLoading();	
}
function setRepairingBacId(bacId){
	submitReady=false;
    document.forms['BacSelectorFormBean'].repairingBacId[0].value = bacId;
    if (bacId != ""){ 
        showLoading();
       
        url="LoadServiceAgentAddress.do";
        params="bacId=" + bacId+"&_SEC_TOKEN_=6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d";
        performAjaxPost(url,params,processStateChangeAddress);
    } else {
    	submitReady=true;
    }
}

function processseKey(bacId){
	if(submitReady) {
	    if(bacId.length  >= 6){
	       objBac = document.forms['BacSelectorFormBean'].bacId[1];
	       var bacFound = 0;   
	       for (var i = 0; i < objBac.length; i++){
	           if (bacId == objBac.options[i].value){
	        	   objBac.options[i].selected = true;
	               bacFound++;
	           }
	       }
	       if (bacFound == 0 || bacId == ""){
	           objBac.options[0].selected = true;
	           document.getElementById('errors').innerHTML = 'Ha ingresado un BAC no válido o no tiene acceso a ese Cód. de Asoc. Comercial.';
	       }else{
	           document.getElementById('errors').innerHTML = '';
	           setBacId(bacId);
	       } 
	   }
	} else {
		if(bacId) {
			var cmd="processseKey('"+bacId+"')";
			setTimeout(cmd,200);
		}
	}
}
</script>
                            </TD>
                        </TR>
                        <TR>
                            <TD>
                                 
 
 
 
                            </TD>
                        </TR>
                        <TR>
                            <TD>
                                
                                    
                                 
 
 
 
                            </TD>
                        </TR>
                        <TR>
                            <TD valign="top">
                                
                                    
                                    
                                


















<script src="./js/transactionHeaderUtil.js?v=3"></script>

<body onLoad="javascript:formatter.changeForm(document.forms['transaction_form'].formType.value);">

<!-- start screen description -->
<table style="vertical-align:top; width:580px;" border="0" cellspacing="0" cellpadding="0">
	<TR>
		<TD></TD>
        <TD>
            <a><font color="blue">
           Encabezado
            </font></a> 
            <a>Detalles</a> 
            <a> Resultado</a>
        </TD>
	</TR>
</table>
<!-- end screen description -->
<p/>
<script type="text/javaScript" language="javaScript">
    setTimeout('showTimeAlert()', 3720000);
    function showTimeAlert() {
        alert('Your session timed out');
        document.location='sitemap.do';
    }
</script>

<script type="text/javaScript" language="javascript">
	var formatter = new FormFormatter();
</script>


<table class="tblBlock"><tbody><tr><td>


	<table style="width:100%">
		<tr>
            <td style="text-align:left;">Encabezado de Orden de Trabajo</td>
			<td style="text-align:right;">* Campos Obligatorios</td>
		</tr>
	</table>

<form name="transactionForm" method="post" action="submitTransaction.do" enctype="multipart/form-data" id="transaction_form">

<style>
	div {margin-bottom:10px; display:block;}
	div.netItem {margin-bottom:1px; margin-top:1px; display:block;}
	div.grouping {height:0px;width:100%;margin:0px;padding:0px;clear:left;line-height:0em;font-size:0px;}
    div.section {width:100%;margin:0px;padding:0px;clear:left;}
</style>



 








<input type="hidden" name="serviceAgentCode" value="">


<input type="hidden" name="draftSeqId" value="">
<input type="hidden" name="currency" value="">
<input type="hidden" name="trxid" value="-1">
<input type="hidden" name="sapTransactionNo" value="">
<input type="hidden" name="wasSubmitted" value="null">


	
<div class="grouping"></div>

<div id="transactionType" class="h03" style="width:100%;clear:left">
	Tipo de Transacción:<span id="transacationTypeCode.req">*</span><span style="color:#ff0000; font-weight:bold;"></span><br>
	<select name="formType" tabindex="1" onchange="javascript:formatter.changeForm(document.forms['transaction_form'].formType.value)" id="formType.in"><option value="ZREG">ZREG -- Transacción Normal de Vehículo</option>
<option value="ZFAT">ZFAT -- Campaña</option>
<option value="ZPDI">ZPDI -- Inspeccion Pre-entrega</option>
<option value="ZPTI">ZPTI -- Transacción Pieza - Montaje en RA</option>
<option value="ZSET">ZSET -- Eventos Servicio pagados por Cliente</option>
<option value="ZSSP">ZSSP -- Programas Especiales de Ventas</option></select>
	<input type="hidden" id="transactionTypeCode.in" name="transactionTypeCode" value=""/>
</div>



<div id="serviceAdvisorNo" class="h03" style="width:50%;clear:left;float:right" >
	Asesor de Servicio:
    <span id="serviceAdvisorNo.req"> *</span>
    <span style="color:#ff0000; font-weight:bold;"></span><br/>
	<input type="text" name="serviceAdvisorNo" maxlength="10" tabindex="3" value="" onkeyup="validAlphNum(this)" style="text-align:right;" id="serviceAdvisorNo.in">		
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('serviceAdvisorNo', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,true);
</script>





<div id="jobCardNo" class="h03" style="width:50%;float:left;clear:left;" >
	Número de Orden de Reparación:<span id="jobCardNo.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
	
    
		<input type="text" name="jobCardNo" maxlength="20" tabindex="2" value="" id="jobCardNo.in">
    
    

</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('jobCardNo', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),true,true);
</script>

<div class="grouping"></div>


<div id="vin" class="h03" style="width:50%;clear:left;float:left;" >
	N° de Serie del Vehículo:<span id="vin.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
	<input type="text" name="vin" maxlength="20" tabindex="4" value="" onkeyup="validAlphNum(this)" id="vin.in">			
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('vin', new Array('R','R','R','R','R','R','R','O','R','R','N','N','N'),false,true);
</script>



<div id="jobCardOpenDateDiv" class="h03" style="width:50%;float:left;float:right" >
    Fecha de Apertura de la Orden de Reparación:<span id="jobCardOpenDate.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
    <input type="text" name="jobCardOpenDate" maxlength="11" tabindex="5" value="" onblur="javascript:syncTextField('jobCardOpenDate.in', 'transactionRepairCompleteDate.in');" id="jobCardOpenDate.in">(DD/MM/YYYY)
</div>
<script type="text/javaScript" language="javaScript">
    formatter.registerElement('jobCardOpenDateDiv', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,true);
    
    function syncTextField(masterField, slaveField) {
        var master = document.getElementById(masterField);
        var slave = document.getElementById(slaveField);
        if (slave && master) {
            slave.value = master.value;
        }
    }
</script>
<div class="grouping"></div>


<div id="odometer" class="h03" style="width:50%;clear:left;float:left;" >
	Kilometraje:<span id="odometer.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
	<input type="text" name="odometer" maxlength="7" tabindex="6" value="" onkeyup="valid(this)" style="text-align:right;" id="odometer.in">			
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('odometer', new Array('R','R','R','R','R','R','R','O','R','R','N','N','N'),false,true);
</script>


<div id="referenceNo" class="h03" style="width:30%;float:left;" >
	Número de Referencia (orden de reparación interna):
    <span style="color:#ff0000; font-weight:bold;"></span><br />
	<input type="text" name="referenceNo" maxlength="25" tabindex="7" value="" style="text-align:right;" id="referenceNo.in">				
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('referenceNo', new Array('O','O','O','O','N','O','O','O','O','N','N','N','N'),false,true);
</script>

<div class="grouping"></div>

<div id="nonGMVehicleFlag" class="h03" style="width:25%;float:left;" >
	<br/>
	<input type="checkbox" name="nonGMVehicleFlag" tabindex="8" value="on" id="nonGMVehicleFlag.in">
	VIN no Encontrado en GWM			
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('nonGMVehicleFlag', new Array('O','O','O','O','N','N','O','O','O','O','N','N','N'),false,true);
</script>



<div id="reciprocalTransactionFlag" class="h03" style="width:40%;float:left;" >
    <br/>
	<input type="checkbox" name="reciprocalTransactionFlag" tabindex="9" value="on" id="reciprocalTransactionFlag.in">
    <span id="reciprocalTransactionFlag.req"></span>
	VIN Turista
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('reciprocalTransactionFlag', new Array('O','O','O','O','N','N','N','O','O','O','N','N','N'),false,true);
</script>
        <table style="width:100%" id="horizRule">
		<tr>
            <td colspan="1" ><HR style="color: #828789"></td>
		</tr>
        <tr>
            <td colspan="1"></td>
        </tr>
	    </table>
<script type="text/javaScript" language="javaScript">
    formatter.registerElement('horizRule', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,false);
</script>
						

<div id="transactionLineNumber" class="h03" style="width:50%;clear:left;float:left;" >
	N°. de Línea:<span id="transactionLineNumber.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
	<input type="text" name="transactionLineNumber" maxlength="2" tabindex="10" value="" onkeyup="valid(this)" style="text-align:right;" id="transactionLineNumber.in">			
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('transactionLineNumber', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,true);
</script>	



<div id="laborOpDependentInfo2" class="h03" style="width:50%;float:right;visibility:hidden;" >
	<span id="spDependentLaborOpCodeLabel"></span>:
    <span id="laborOpDependentInfo.req"> *</span>
    <span style="color:#ff0000; font-weight:bold;"></span><br />
	<input type="text" name="laborOpDependentInfo" maxlength="20" value="">
	<input type="hidden" name="laborOpDependentInfoType" value="">
    <input type="hidden" name="laborOpDependentLabel" value=""/>
</div>


<div id="laborOperationCode" class="h03" style="width:50%;clear:left;float:left">
	Operación:<span id="laborOperationCode.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
	<input type="text" name="laborOperationCode" maxlength="20" tabindex="11" value="" onkeyup="laborOpCodeCheck();" onblur="laborOpCodeCheck();" id="laborOperationCode.in">

</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('laborOperationCode', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,true);
</script>


<div id="transactionRepairCompleteDateDiv" class="h03" style="width:50%;float:right;" >
	Fecha de Cierre de Orden de Reparación:<span id="transactionRepairCompleteDate.req"> *</span><span style="color:#ff0000; font-weight:bold;"></span><br/>
	<input type="text" name="transactionRepairCompleteDate" maxlength="20" tabindex="12" value="" id="transactionRepairCompleteDate.in">(DD/MM/YYYY)
</div>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('transactionRepairCompleteDateDiv', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,false);
</script>

<div class="grouping"></div>

<script type="text/javaScript" language="javaScript">
	//formatter.registerElement('formType', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),true,true);
</script>

<div id="submitSection" style="float:right;">
<div id="break"><br></div>

    <input type="button" name="" id="cancel.button" value="CANCELAR" class="menubutton" onclick="javascript:showLoading();cancelDraft();" onMouseOver="showcolor(this)" tabindex="13">



	        
    
   		<input type="button" name="continueButton" tabindex="14" value="CONTINUAR" onclick="javascript:showLoading();continueTransaction();" onmouseover="showcolor(this)" class="menubutton" id="continue.button">
        


<script type="text/javaScript" language="javaScript">
		var dependentLaborOp = [
		['8060252', 'A', 'Frenos']
,
['8070032', 'A', 'Frenos']
,
['8060213', 'A', 'Frenos']
,
['8060212', 'A', 'Frenos']
,
['8060272', 'A', 'Frenos']
,
['4041510', 'B', 'Código de prueba de la batería']

		];
		
		        
		function lookupDependentLbOpCode(lop){
			for (var i = 0; i < dependentLaborOp.length; i ++) {
				if (dependentLaborOp[i] != null && lop != null && dependentLaborOp[i][0].toUpperCase() == lop.toUpperCase()) return dependentLaborOp[i];
			}
			return null;
		}
		
		//check this upon loading the page
		laborOpCodeCheck();
	</script>


  
	<script type="text/javaScript" language="javaScript">
        function resetOnFullDebit(){
        
            document.getElementById("vin.in").value = '';
            document.getElementById("jobCardOpenDate.in").value = '';
            document.getElementById("jobCardNo.in").value = '';
            document.getElementById("odometer.in").value = '';
            document.getElementById("serviceAdvisorNo.in").value = ''; 
            document.getElementById("referenceNo.in").value = '';
             
              document.getElementById("nonGMVehicleFlag.in").checked = 'false'; 
            
             
              document.getElementById("reciprocalTransactionFlag.in").checked = 'false'; 
            
            document.getElementById("transactionLineNumber.in").value = '';                
            document.getElementById("transactionRepairCompleteDate.in").value = '';       
            document.getElementById("transactionTypeCode.in").value = ''; 
            document.getElementById("formType.in").value = '';  
            document.getElementById("laborOperationCode.in").value = '';
       }
    
        function continueTransaction(){
			document.transactionForm.action = "continueTransaction.do";
            submitForm();
		}
        
        function cancelDraft(){
            var referingUrl = "https://www.autopartners.net/apps/gwmlaam/gwm_web/prepareDrafts.do";
            if (referingUrl == "null"){
                referingUrl = "prepareDrafts.do";
            }
            document.location.href=referingUrl;
        }        
        
        function cancelNewACD(){
            var referingUrl = "sitemap.do";
            if (referingUrl == "null"){
                referingUrl = "prepareACDelcoByJobCard.do";
            }
            document.location.href=referingUrl;
        }
            
        function reDisableFields(){
            var isApproved = false;
            var isSubmitted = false;
            
            
            formatter.disableFields(isSubmitted, isApproved);

            // bdu 09/11/2006 BEGIN - When adding a new line, the following header data should NOT be allowed to be changed:
            // VIN, SA, JC No, JC Dt, Odometer , Repairing SA and Service Advisor

            
               
            
            // bdu 09/11/2006 END
        }

        
        //by Sabuj 06/25/07
        javascript:reDisableFields();
    </script>
    
</div>
<script type="text/javaScript" language="javaScript">
    formatter.registerElement('submitSection', new Array('R','R','R','R','R','R','R','R','R','R','N','N','R'),false,false);
</script>
<INPUT TYPE="HIDDEN" NAME="_SEC_TOKEN_" VALUE="6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d"></form>



<div id="acd_transactionForm">
<form name="acdelcoTransactionForm" method="post" action="submitACDelcoTransaction.do" enctype="multipart/form-data" id="acdelcoTransactionForm">
<input type="hidden" name="transactionType" id="acd_transactionType" value=""/>
<input type="hidden" name="acdelcoTxnCount" value="1" id="acd_acdelcoTxnCount">
<input type="hidden" name="debitReasonType" value="" id="acd_debitReasonType">


<table>
    <tbody>
    
        
       
        <tr>
            <td>
                <table>
                	<div id="acd_serviceAdvisorNo.in">
                    Asesor de Servicio: <br>                       
                    <input type="text" name="serviceAdvisorNo" maxlength="10" value="" onkeyup="validAlphNum(this)" style="text-align:right;">                            
                    </div>
                    <script type="text/javaScript" language="javaScript">
                                formatter.registerElement('acd_serviceAdvisorNo.in', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                    </script>
                </table>
            </td>
        </tr>
    </tbody>
</table>


<script type="text/javaScript" language="javaScript">
var laborOps=new Array();
var laborOp;
var labelValue;

</script>


<div id="acd_transactionForm.upload" style="display:none">
<table>
    <TR id="samplezacd">
        <TD>
			<a href="javascript:openSampleCSV('ExportExampleCSV.do',new Array('BAC que realizó la reparación *','Tipo de Transacción *','Número de Asesor de Servicio','Número de Cliente','Operación *','Número de Orden de Trabajo *','Fecha de Apertura - Orden de Reparación *','Cantidad de Partes *','No. de Parte *','Número de Referencia (orden de reparación interna)','Indicador de Solicitud de Autorización GM','Comentarios','Tipo de Importe Misceláneos Adicionales','Información Adicional'),new Array('Elimine los encabezados de columna Antes de Cargar','','','','','','','','','','','','','','','Cuando Guarde un archivo para cargar elija \"Guardar Como..\" y seleccione \"texto unicoide\" en el  combo de Tipo'),'Ejemplo de carga de archivo');">Ejemplo de carga de archivo</a><BR> 
        </TD>
    </TR>
    <TR id="samplezbat">
        <TD>
        	<a href="javascript:openSampleCSV('ExportExampleCSV.do',new Array('BAC que realizó la reparación *','Tipo de Transacción *','Número de Asesor de Servicio','Número de Serie de Batería','Operación *','Número de Orden de Trabajo *','Fecha de Apertura - Orden de Reparación *','Fecha Original de Compra','Número de Parte de Batería *','Código de fecha de Batería *','Código de Servicio *','Código de Transacción *','Número de Referencia (orden de reparación interna)','Indicador de Solicitud de Autorización GM','Descontinuado','Razones de Auto Autorización','Comentarios'),new Array('Elimine los encabezados de columna Antes de Cargar','','','','','','','','','','','','','','','','','Cuando Guarde un archivo para cargar elija \"Guardar Como..\" y seleccione \"texto unicoide\" en el  combo de Tipo'),'Ejemplo de carga de archivo');">Ejemplo de carga de archivo</a><BR>
          </TD>
    </TR>
    <TR>
    	<TD>
    		<input type="file" name="batchFile">
    	</TD>
    </TR>
    <TR>
    	<TD>
    		<span class="black"><b>Importante</b></span><br>
    		Para llevar a cabo el proceso de carga de archivos, el usuario debe descargar el archivo muestra .csv primero. Este archivo muestra, provee las columnas necesarias que deben ser llenadas. Es muy importante que cualquier campo de fecha sea completado utilizando el mm / dd / yyyy o dd / mm / aaaa (dependiendo de los requerimientos de formato de la Unidad de Negocio). Una vez que la información ha sido ingresada, el usuario debe "Guardar como" en Excel. Después, el usuario debe cambiar la opción "tipo" a "Texto Unicode (*. txt)". Después, guarde el archivo en el disco duro del usuario. Este archivo tendrá ahora un formato de archivo ".Txt".Este es el formato que se necesita para el proceso de carga de archivos. A continuación, seleccione la opción Examinar para seleccionar el archivo para la carga. Para más información, consulte la pantalla de ayuda. 
    	</TD>
    </TR>
</table>
<script type="text/javaScript" language="javaScript">
	formatter.registerElement('samplezacd', new Array('N','N','N','N','N','N','N','N','N','N','R','N','N'),true,true);
	formatter.registerElement('samplezbat', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),true,true);
</script>
</div>
<table class="" style="margin-left:5px;">
    <tbody>            
        <tr>    
            <td>
                <div id="onScreenEntrySection">
                    <div id="acd_transactionForm.bluePrint" style="display:none" >
                        <input type="hidden" name="rownum" value="0">
                        <input type="hidden" name="comments" id="acd_comments" value="">
                    
                        <input type="hidden" name="commentType" value="" id="acd_commentType">
                        <input type="hidden" name="selfAuthReasons" value="" id="acd_selfAuthReasons">
                        <input type="hidden" name="miscNetItem" value="" id="acd_miscNetItem">
                        <input type="hidden" name="additionalInfo" value="" id="acd_additionalInfo">
                        <input type="hidden" name="sapTransactionNo" value="" id="acd_sapTransactionNo">
                        <INPUT TYPE="HIDDEN" NAME="_SEC_TOKEN_" VALUE="6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d">
                        
                        
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr><!-- Remedy Ticket: 162910, 163597 -->
                               <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_customerNumber">
                               	Número de Serie de Batería<span id="acd_customerNumber.req"> *</span>
                               </td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_laborOperation">Operación:<span id="acd_laborOperation.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_jobCardNumber">Número de Orden de Reparación:<span id="acd_jobCardNumber.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_jobCardDate">Fecha de Orden de Trabajo<span id="acd_jobCardDate.req">*</span>(DD/MM/YYYY)</td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_partQuantity">
                                    Cantidad de Partes<span id="acd_partQuantity.req"> *</span>
                                </td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_origPurchaseDate">
                                    Fecha Original de Compra<span id="acd_origPurchaseDate.req">*</span>(DD/MM/YYYY)
                                </td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_partNumber">
                                    No. de Parte<span id="acd_partNumber.req"> *</span>
                                </td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_batteryPartNumber">
                                    Número de Parte de Batería<span id="acd_batteryPartNumber.req"> *</span>
                                </td>
                                <script type="text/javaScript" language="javaScript">
									formatter.registerElement('acd_customerNumber', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),true,true);
                                    formatter.registerElement('acd_laborOperation', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                    formatter.registerElement('acd_jobCardNumber', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                    formatter.registerElement('acd_jobCardDate', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                    formatter.registerElement('acd_partQuantity', new Array('N','N','N','N','N','N','N','N','N','N','R','N','N'),false,true);
                                    formatter.registerElement('acd_origPurchaseDate', new Array('N','N','N','N','N','N','N','N','N','N','N','O','N'),true,true);
                                    formatter.registerElement('acd_partNumber', new Array('N','N','N','N','N','N','N','N','N','N','R','N','N'),true,true);
                                    formatter.registerElement('acd_batteryPartNumber', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),true,true);
                                </script>
                            </tr>
                            <tr><!-- Remedy Ticket: 162910, 163597 -->
                                <td style="padding: 0 5px 10px 5px;" Id="acd_customerNumber.in">
                                	<input type="text" name="customerNumber" value="" id="acd_customerNumber.in">
                                </td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_laborOperation.in">
                                    <select name="laborOperation" id="laborOpSelect"></select>                               
                                </td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_jobCardNumber.in"><input type="text" name="jobCardNumber" value="" style="width: 74px;" id="acd_jobCardNumber.in"></td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_jobCardDate.in"><input type="text" name="jobCardDate" value="" style="width: 74px;" id="acd_jobCardDate.in"></td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_partQuantity.in">
                                    <input type="text" name="partQty" maxlength="2" value="" onkeyup="valid(this);" style="width: 50px;" id="acd_partQuantity.in">
                                </td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_origPurchaseDate.in">
                                    <input type="text" name="origPurchaseDate" value="" style="width: 74px;" id="acd_origPurchaseDate.in">
                                </td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_partNumber.in">
                                    <input type="text" name="partNumber" value="" style="width: 74px;" id="acd_partNumber.in">
                                </td>
                                <td style="padding: 0 5px 10px 5px;" Id="acd_batteryPartNumber.in">
                                    <input type="text" name="batteryPartNumber" value="" style="width: 74px;" id="acd_batteryPartNumber.in">
                                </td>
                                <script type="text/javaScript" language="javaScript">
                                    formatter.registerElement('acd_customerNumber.in', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),true,true);
                                    formatter.registerElement('acd_laborOperation.in', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                    formatter.registerElement('acd_jobCardNumber.in', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                    formatter.registerElement('acd_jobCardDate.in', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                    formatter.registerElement('acd_partQuantity.in', new Array('N','N','N','N','N','N','N','N','N','N','R','N','N'),false,true);
                                    formatter.registerElement('acd_origPurchaseDate.in', new Array('N','N','N','N','N','N','N','N','N','N','N','O','N'),true,true);
                                    formatter.registerElement('acd_partNumber.in', new Array('N','N','N','N','N','N','N','N','N','N','R','N','N'),true,true);
                                    formatter.registerElement('acd_batteryPartNumber.in', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),true,true);
                                </script>
                            </tr>
                            <tr>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_discontinued">Descontinuado<span id="acd_discontinued.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_batteryDateCode">Código de fecha de Batería<span id="acd_batteryDateCode.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_serviceCode">Código de Servicio<span id="acd_serviceCode.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_transactionCode">Código de Transacción<span id="acd_transactionCode.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_referenceNumber">Número de Referencia (orden de reparación interna):<span id="acd_referenceNumber.req"> *</span></td>
                                <td style="padding: 0 5px 0 5px; vertical-align:bottom;" id="acd_reqGmAuth"></td>
                                <td style="padding: 0 5px 10px 5px;" colspan="4" id="acd_submissionSection_parts_labelRow"></td>
                                <script type="text/javaScript" language="javaScript">
                                    formatter.registerElement('acd_discontinued', new Array('N','N','N','N','N','N','N','N','N','N','N','O','N'),false,true);
                                    formatter.registerElement('acd_batteryDateCode', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_serviceCode', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_transactionCode', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_referenceNumber', new Array('N','N','N','N','N','N','N','N','N','N','O','O','N'),true,true);

                                    formatter.registerElement('acd_submissionSection_parts_labelRow', new Array('N','N','N','N','N','N','N','N','N','N','R','N','N'),false,true);
                                </script>                            
                            </tr>
                            <tr id="acd_discontinued.tr"> 
                                <td style="padding: 0 5px 10px 5px;" id="acd_discontinued.out"><div id="acd_discontinued.div"><input type="checkbox" name="discontinued" value="on" id="acd_discontinued.in"></div></td>                           
                                <td style="padding: 0 5px 10px 5px;" id="acd_batteryDateCode.out"><input type="text" name="batteryDateCode" value="" style="width: 75px; height: 20px;" id="acd_batteryDateCode.in"></td>
                                <td style="padding: 0 5px 10px 5px;" id="acd_serviceCode.out"><input type="text" name="serviceCode" value="" style="width: 75px; height: 20px;" id="acd_serviceCode.in"></td>
                                <td style="padding: 0 5px 10px 5px;" id="acd_transactionCode.out"><input type="text" name="transactionCode" value="" style="width: 75px; height: 20px;" id="acd_transactionCode.in"></td>
                                <td style="padding: 0 5px 10px 5px;" id="acd_referenceNumber.out"><input type="text" name="referenceNumber" value="" style="width: 75px; height: 20px;" id="acd_referenceNumber.in"></td>
                                <td style="padding: 0 5px 10px 5px;" id="acd_reqGmAuth.out"></td>
                             </tr>
							<!-- For SR PS-11-001079 -->
							
							 <TR>
                                <td style="padding: 0 5px 10px 5px;" colspan="8" id="acd_submissionSection_parts.out">
                                <br>
                                	<div style="float:right;"> 
                                        <div id="acd_button.batteryCalculator" style="float:left;">                                        
                                        <input class="menubutton" type="button" id="acdButton" value="Battery Calculator" onClick="javascript:batteryCalculator(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);" onMouseOver="showcolor(this);"/>
                                        </div>										                                        
                                    </div>
                                        &nbsp;                                    
                                </td>
                            </tr>
                            
                              <script type="text/javaScript" language="javaScript">                              
                              // For SR PS-11-001079
                               formatter.registerElement('acd_submissionSection_parts.out', new Array('N','N','N','N','N','N','N','N','N','N','N','N','N'),false,true);
                               function batteryCalculator(row)
							   {
									var newwindow;
									var rowid=-1;
								    var nodes = row.getElementsByTagName('input');
								    var paramString='';
								    var values = '';
								    for(var i=0;i<nodes.length;i++)
								    {
								    	var name='';
								        	if(nodes[i].id == 'acd_customerNumber.in')
								        	{
								        		name = 'custNo';
								        	}
								        	else if(nodes[i].id == 'acd_jobCardNumber.in')
								        	{
								        		name = 'jobCard';
								        	}
								        	else if(nodes[i].id == 'acd_jobCardDate.in')
								        	{
								        		name = 'jobCardDate';
								        	}
								        	else if(nodes[i].id == 'acd_origPurchaseDate.in')
								        	{
								        		name = 'orgPurDate';
								        	}
								        	else if(nodes[i].id == 'acd_batteryPartNumber.in')
								        	{
								        		name = 'battPartNo';
								        	}
								        	else if(nodes[i].id == 'acd_batteryDateCode.in')
								        	{
								        		name = 'battDateCode';
								        	}
								        	else if(nodes[i].id == 'acd_serviceCode.in')
								        	{
								        		name = 'servCode';
								        	}
								        	else if(nodes[i].id == 'acd_transactionCode.in')
								        	{
								        		name = 'transCode';
								        	}
								        	else if(nodes[i].id == 'acd_referenceNumber.in')
								        	{
								        		name = 'refNum';
								        	}
								        	else if (nodes[i].id == 'laborOpSelect')
								        	{
								        		name = 'labOpCode';
								        	}
								        	else if (nodes[i].id == 'acd_discontinued.in')
								        	{
								        		name = 'disCont';
								        		values += name + '=' + nodes[i].checked + '&';
								        	}
								        	if(nodes[i].type == 'text' && name != '')
								        	{
								        		values += name + '=' + nodes[i].value + '&';
								        	}
								        }		       	
								    
								    values=values.substring(0,values.length-1);
								    								    
								    var url = 'ACDelcoBatteryCalculator.do?'+values;
																											
									newwindow=window.open(url,'acdelcoBattery','left=180,top=180,width=450,height=255,toolbar=0,resizable=0,scrollbars=0');
									if (window.focus) {
										newwindow.focus();
									}
								}
							// End
                                </script>                                                                                              
                             <TR>
                             <!-- End -->
                                <td style="padding: 0 5px 10px 5px;" colspan="8" id="acd_submissionSection_parts.out">
                                    <div style="float:right;">        
                                        <div id="acd_button.additionalInfo_parts" style="float:left;"><input class="menubutton" type="button" value="Información Adicional" onClick="openAdditionalInfo(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);" onMouseOver="showcolor(this);" /></div>
                                        &nbsp;
                                        <input class="menubutton" type="button" id="addButton_0" value="+" onClick="javascript:createNewAcdelcoRow(this);" onMouseOver="showcolor(this);" />
                                    </div>
                                    <div style="clear:both"></div>

                                </td>
                         
                                <script type="text/javaScript" language="javaScript">
                                    formatter.registerElement('acd_discontinued.out', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_batteryDateCode.out', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_serviceCode.out', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_transactionCode.out', new Array('N','N','N','N','N','N','N','N','N','N','N','R','N'),false,true);
                                    formatter.registerElement('acd_referenceNumber.out', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
                                   
                                    formatter.registerElement('acd_submissionSection_parts.out', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),false,true);
                                </script>
                            </tr>


                        </table>
                    </div>
                    
                </div>
            </td>
        </tr>
    </tbody>
</table>


<!--insert rows below from the plus button being clicked.-->
<div id="acd_transactionForm.in">

</div>
<div>
    <div style="clear:both"></div>
    <div id="acd_submitSection" style="float:right;">
        <div id="acd_button.cancel" style="float:left;"><input type="button" value="CANCELAR" class="menubutton" onclick="cancelNewACD()" onMouseOver="showcolor(this)"></div>
        <div id="acd_button.submit" style="float:left;"><input class="menubutton" type="submit" value="ENVIAR" onClick="if(addInfoWindow){if(!addInfoWindow.closed){alert('La información adicional de la ventana emergente debe ser cerrada o guardada exitosamente antes de enviar.');return false;}}" onMouseOver="showcolor(this);"/></div>
    </div>
    <script type="text/JavaScript" language="javascript">
              formatter.registerElement('acd_submitSection', new Array('N','N','N','N','N','N','N','N','N','N','R','R','N'),true,true);
		</script>
</div>

<INPUT TYPE="HIDDEN" NAME="_SEC_TOKEN_" VALUE="6e486e526b6334667031426c665178416a6b6f2f6a3764383773493d"></form>
</div>
<script type="text/javaScript" language="javaScript">

function openSampleCSV(url, headers,values,filename)
{
	var tempForm = document.createElement('FORM');
	tempForm.method='POST';
	tempForm.action=url;
	for(var i=0;i<headers.length;i++)
	{
		var tempI = document.createElement('INPUT');
		tempI.name='headers';
		tempI.value=headers[i];
		tempForm.appendChild(tempI);
	}
	for(var i=0;i<values.length;i++)
	{
		var tempI = document.createElement('INPUT');
		tempI.name='c';
		tempI.value=values[i];
		tempForm.appendChild(tempI);
	}
	
	var tempI = document.createElement('INPUT');
	tempI.name='filename';
	tempI.value=filename;
	tempForm.appendChild(tempI);
	document.appendChild(tempForm);
	
	tempForm.submit();
	document.removeChild(tempForm);
}
</script>





</td></tr>
</tbody></table>
</body>

                            </TD>
                            <td valign="top" style="padding-left:10px">
                                
                                    
                                    
                                 
 
 
 
                            </td>
                        </TR>
                        <TR>
                            <TD>
                                 
 
 
 
                            </TD>
                        </TR>
                        <TR>
                            <TD>
                                 
 
 
 
                            </TD>
                        </TR>
                    </table>
                </td>
            </tr>
            <tr>
                <td>



<!--footer-->

<table>
<tr>
<td>
Administración Global de Garantía:&nbsp;<a href="sitemap.do" class="link07">Mapa del Sitio</a>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#B3C2E7" class="t01">
  <tbody>
    <tr>
      <td width="10" height="20"></td>
      <td nowrap><a class=foot href="https://www.autopartners.net/apps/gcportal/portal/dt?provider=PrivacyPolicyContainer&button_action=LOGIN">Política de Privacidad</a>&nbsp;&nbsp;
      <img src="images/v-dots.gif" alt="" width="1" height="13" border="0" align="absmiddle">&nbsp;&nbsp;
      <a class=foot href="https://www.autopartners.net/apps/gcportal/portal/dt?provider=TermOfUseContainer">Términos de Uso</a></td>
      <td class=foottext align=right>&copy; 2005 General Motors Corporation. Todos los derechos reservados.</td>
      <td width="10"></td>
    </tr>
  </tbody>
</table>
</td>
            </tr>
        </table>
    </body>
</html>
