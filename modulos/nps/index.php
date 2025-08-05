<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src='chart/Chart.js'></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    </head>
    <body>

        <div class="container"><br>
            <h3>Modulo NPS Ventas <span class="badge badge-warning">Nuevo</span></h3>
                <div class="row justify-content-md">
                    <!-- <div class="col col-lg-1" style='background-color: red'>
                    Sucursal:
                    </div> -->
                    <div class="col-md-auto">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Marca</label>
                            <select class="form-control" name='marca' id="selectMarca">
                                <option value='todosMarca'>TODOS</option>
                                <option value='VMA-10017'>CHEVROLET</option>
                                <option value='VMA-10018'>ISUZU</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-auto" id='sucursalData'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Sucursal</label>
                            <select class="form-control" name='sucursal' id="selectSucursal">
                                <option value="todosSucursal">TODOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-auto" id='asesorData'>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Asesor</label>
                            <select class="form-control" name='asesor' id="selectAsesor">
                                <option value="todosAsesor">TODOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Fecha Inicio</label>
                            <input class='form-control' type="date" id='fechaIni'>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Fecha Fin</label>
                            <input class='form-control' type="date" id='fechaTerm'>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">-</label><br>
                            <button type="button" class="btn btn-primary" id='enviar'>A por el NPS</button>
                        </div>
                    </div>
                    
                </div>
        </div><br>

        <div class='container' id='data'></div>
        <div class='container' id='loader' style='display:none'>
            <div class='row'>
                <div class='col-md-12' style='text-align:center'>
                    <img src="img/progress.gif" alt="" style='width: 20%'>
                </div>
            </div>
        </div>

        <script>
              // OBTENER EL CAMBIO DE VALOR DE MARCA
                $('#selectMarca').change(function(){
                    let IdMarca = $('option:selected',this).val();
                    // let idMarca    = $(, this).attr('idsuc');
                    var rutaSucursal="IdMarca="+IdMarca;

                    $.ajax({
                        url: 'config/sucursales.php',
                        type: 'POST',
                        data: rutaSucursal,
                    })
                    .done(function(res){
                        $('#sucursalData').html(res)
                        $('#asesorData').html(res)
                    })
                    
                    console.log(IdMarca)
                    // console.log(idSucursal)
                });
        </script>

        <script>
            //Creado por Jorgito

                $('#enviar').click(function(){
                    var esperar = 2000;
                    var Marca=$('#selectMarca').val()
                    var Sucursal=$('#selectSucursal').val()
                    var Asesor=$('#selectAsesor').val()
                    var FechaIni=$('#fechaIni').val()
                    var FechaTerm=$('#fechaTerm').val()
                    var ruta="Mar="+Marca+"&Suc="+Sucursal+"&Ase="+Asesor+"&FecIni="+FechaIni+"&FecTerm="+FechaTerm;

                    $.ajax({
                    url: 'grafico1.php',
                    type: 'POST',
                    data: ruta,
                    beforeSend: function(){
                        $('#data').css("display", "none");
                        $('#loader').css("display", "block");
                    }
                    })
                    .done(function(res){
                        $('#data').css("display", "block");
                        $('#data').html(res)
                        $('#loader').css("display", "none")
                    })
                    .fail(function(){
                    console.log("error");
                    })
                    .always(function(){
                    console.log("complete");
                    
                    });

                });
        
        </script>
        

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>