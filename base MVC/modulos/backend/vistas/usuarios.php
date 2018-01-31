<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Cotizador Derco</title>
        <link type="image/x-icon" rel="shortcut icon" href="<?= $this->vista->globales['rutaVistasModulo'] ?>js/favicon.ico" /> 
        <!-- css -->
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/reset.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/default.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>font/font.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/print.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/style.css"/>
        <!--[if IE]>
        <script src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/html5.js"></script>
        <![endif]-->
        <!--[if IE 7]>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/style7.css?=<?php echo time(); ?>" />
        <![endif]-->
        <?php
        $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
        if (!empty($isiPad)) { //detecta si el navegador es iPad  
            ?>
            <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/ipad.css?=<?php echo time(); ?>"/>
        <?php } ?>
        <!-- /css -->
        <!-- jQuery -->
        <script type="text/javascript" src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/jquery-1.8.3.min.js"></script>
        <!-- /jQuery -->
        <script type="text/javascript">
<?
//if (isset($_GET['buscar'])) {
?>
            $(document).ready(function() {

                //asignar urls a los accesorios
                var posicionAccesorios = "";

                $("table#resultados").find("th").each(function(k) {

                    //obtener la posición de la columna que corresponde a los accesorios
                    if ($(this).html().match(/accesorios/i)) {
                        posicionAccesorios = k;
                        return true;
                    }
                });

                if (posicionAccesorios != "") {

                    var valorAccesorios = "";
                    var valorFinalAccesorios = "";

                    $("table#resultados").find("tr").find("td:eq(" + posicionAccesorios + ")").each(function() {

                        valorAccesorios = "";
                        valorFinalAccesorios = "";

                        if ($(this).html() != "") {

                            if ($(this).html().match(",")) {

                                valorAccesorios = $(this).html().split(",");

                                $(valorAccesorios).each(function(k, v) {

                                    if (valorFinalAccesorios != "") {
                                        valorFinalAccesorios += ",";
                                    }

                                    valorFinalAccesorios += "<a href='http://www.dercoaccesorios.cl/catalogo/product.php?id_product=" + v + "' target='_blank' >" + v + "</a>";
                                });

                                $(this).html(valorFinalAccesorios);

                            } else {

                                valorFinalAccesorios += "<a href='http://www.dercoaccesorios.cl/catalogo/product.php?id_product=" + $(this).html() + "' target='_blank' >" + $(this).html() + "</a>";
                                $(this).html(valorFinalAccesorios);
                            }
                        }
                    });
                }
                //fin asignación de links a los accesorios

                var host = "";
                var peticiones = "<?= "?" . $_SERVER['QUERY_STRING'] ?>";
                var pag = 1;
<?
if (isset($_GET['pag'])) {
    ?>
                    pag = parseInt("<?= $_GET['pag'] ?>");
    <?
}
?>
                $("input[name='inicio']").click(function(e) {

                    e.preventDefault();

                    location.href = "<?= $this->vista->globales['actionForm'] ?>";
                });

                $("select[name='secciones']").change(function() {

                    location.href = "index.php?m=<?= $_GET['m'] ?>&seccion=" + $(this).find("option:selected").val();
                });

                $("#formFiltro").find("input[name='mostrarTodosCotizaciones']").click(function(e) {
                    e.preventDefault();

                    location.href = "<?= $this->vista->globales['actionForm'] ?>";
                });
                $("#formFiltro").find("input[name='mostrarTodosContactos']").click(function(e) {
                    e.preventDefault();

                    location.href = "index.php?m=<?= $_GET['m'] ?>&inicioContacto=contacto";
                });

                $(".paginas").find("a#pagSig").click(function(e) {

                    e.preventDefault();
                    if (peticiones == "?") {
                        location.href = peticiones + "pag=" + (pag + 1);
                    } else {
                        if (peticiones.match(/\?pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("?pag="));
                            location.href = peticiones + "?pag=" + (pag + 1);
                        } else
                        if (peticiones.match(/\&pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("&pag="));
                            location.href = peticiones + "&pag=" + (pag + 1);
                        } else {
                            location.href = peticiones + "&pag=" + (pag + 1);
                        }
                    }
                });

                $(".paginas").find("a#pagAnt").click(function(e) {

                    e.preventDefault();

                    if (peticiones == "?") {
                        location.href = peticiones + "pag=" + (pag + 1);
                    } else {
                        if (peticiones.match(/\?pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("?pag="));
                            location.href = peticiones + "?pag=" + (pag - 1);
                        } else
                        if (peticiones.match(/\&pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("&pag="));
                            location.href = peticiones + "&pag=" + (pag - 1);
                        } else {
                            location.href = peticiones + "&pag=" + (pag - 1);
                        }
                        //                        alert(peticiones);
                    }
                });

                $("select[name='selectPag']").change(function() {

                    if (peticiones == "?") {
                        location.href = peticiones + "pag=" + $(this).val();
                    } else {
                        if (peticiones.match(/\?pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("?pag="));
                            location.href = peticiones + "?pag=" + $(this).val();
                        } else
                        if (peticiones.match(/\&pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("&pag="));
                            location.href = peticiones + "&pag=" + $(this).val();
                        } else {
                            location.href = peticiones + "&pag=" + $(this).val();
                        }
                    }
                });

                $(".btn_xls").click(function(e) {

                    e.preventDefault();

                    peticiones.replace(/\?genExcel\=Generar\+Excel/gi, "");
                    peticiones.replace(/\&genExcel\=Generar\+Excel/gi, "");

                    location.href = peticiones + "&genExcel=1";
                });

                $(".marcaTabla").click(function(e) {
                    e.preventDefault();

                    filtrar(true, $(this));
                });

                $("#tipoUsuario").find("option").each(function() {
                    $(this).html($(this).html().replace("1", "Administrador"));
                    $(this).html($(this).html().replace("2", "Normal"));
                });
            });
<?
//}
?>
            function filtrar(marca, obj) {

                var msjeError = "";

                switch ($("#selectFiltro").val()) {

                    case "nombre":
                        if ($("#nombre").find("input").val() == "") {
                            msjeError = "Debe ingresar un Nombre";
                        } else {
                            $("input[name='nombre']").val(($("input[name='nombre']").val().replace(/\./g, "")));
                        }
                        break;
                    case "apellido":
                        if ($("#apellido").find("input").val() == "") {
                            msjeError = "Debe ingresar un Apellido";
                        } else {
                            $("input[name='apellido']").val(($("input[name='apellido']").val().replace(/\./g, "")));
                        }
                        break;
                    case "email":
                        if ($("#email").find("input").val() == "") {
                            msjeError = "Debe ingresar un Email";
                        }
                        break;
                }

                if (msjeError != "") {
                    alert(msjeError);
                } else {

                    var urlHref = "";

                    var nomFiltro = $("#selectFiltro").val();

                    //comenzar a armar la petición según el filtro
                    urlHref += "<?= $this->vista->globales['actionForm'] ?>&filtro=" + nomFiltro + "&buscar=Buscar";

                    //verificar si se está usando el buscador. Si es así, preparar los select con el valor buscado. Sino, dejar los select con un option vacío

                    var contenedorFiltro = $("#" + nomFiltro);

                    if ($("#" + $("#selectFiltro").val()).children("form").serialize() != "") {
                        urlHref += "&" + $("#" + $("#selectFiltro").val()).children("form").serialize();
                    }
                    if ($("form#formMarcas").serialize() != "") {
                        urlHref += "&" + $("form#formMarcas").serialize();
                    }

                    if (marca) {
                        location.href = urlHref + "&marcaTabla=" + obj.attr("id").replace("marca_", "");
                    } else {
                        location.href = urlHref;
                    }
                }
            }

            $(document).ready(function() {
                $("#selectFiltro").change(function() {
                    //                    alert($(this).val());

                    $("div#formFiltro").children(".row").each(function() {
                        if ($(this).attr("id") != "") {
                            $(this).addClass("hidden");
                        }
                    });

                    switch ($(this).val()) {
<?
//iterar e imprimir la lista de filtros para seleccionar
foreach ($this->vista->masterArray['campos'] as $key => $value) {

    if (isset($value['nomFiltro']) && !empty($value['nomFiltro'])) {

        //imprimir combobox con listado de filtros para seleccionar
        ?>
                                case "<?= $value['idFiltro'] ?>":
                                    $("#<?= $value['idFiltro'] ?>").removeClass("hidden");
                                    break;
        <?
    }
}
?>
                    }
                });

                $(".row-filtrosMarca").find("input").change(function() {
                    if ($(this).attr("checked") == "checked") {
                        $(this).parent().parent().children("figure").addClass("seleccionado");
                    } else {
                        $(this).parent().parent().children("figure").removeClass("seleccionado");
                    }
                });

                $(".btn-buscar").children("a").click(function(e) {
                    e.preventDefault();

                    filtrar(false);
                });
            });
        </script>
        <?php include('inc/header_elements.php'); ?>
        <script src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/scripts.js" type="text/javascript"></script>
    </head>
    <body id="proceso">
        <!-- header -->
        <? include("header.php"); ?>
        <!-- /header -->
        <!-- Contenido -->
        <section id="contenido">
            <!-- titulo -->
            <div class="row">
                <h2>FILTROS DE B&Uacute;SQUEDA</h2>
            </div>
            <!-- /titulo -->
            <!-- filtro datos registrados -->
            <div class="row">
                <h4>POR DATOS REGISTRADOS</h4>
                <div class="row fnd-gris caja-filtros modulo">
                    <?
                    $this->vista->modeloBackend->filtrado($_GET[nomParamControlador], $this->vista->masterArray, $this->vista->stringTablas, $this->vista->stringCampos, $this->vista->condicionFiltro);
                    ?>

                    <!-- btn buscar -->
                    <div class="row row-buscar modulo btn-buscar-usuario">
                        <div class="btn-buscar"><a href="#"><img src="<?= $this->vista->globales['rutaVistasModulo'] ?>img/btn_buscar.gif" width="151" height="35" alt="Buscar"></a></div>
                    </div>
                    <!-- /btn buscar -->

                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <!-- /filtro datos registrados -->
            <!-- filtro  marcas -->
            <? /* ?>
              <div class="row">
              <form id="formMarcas">
              <h4>POR MARCA</h4>
              <ul class=" row row-filtrosMarca modulo">
              <?
              foreach ($this->vista->listaMarcas as $datosMarca) {
              if (preg_match("/" . $datosMarca[0] . "/", $this->vista->datosCliente[0]['marcasAsignadas'])) {
              ?>
              <li>
              <label>
              <figure class="<?= $datosMarca[0] ?>_marca<?
              if (in_array($datosMarca[0], $_GET['marcaSel'])) {
              echo " seleccionado";
              }
              ?>"></figure>
              <div class="sel">
              <input name="marcaSel[]" type="checkbox" value="<?= $datosMarca[0] ?>" <?
              if (in_array($datosMarca[0], $_GET['marcaSel'])) {
              echo "checked='checked'";
              }
              ?>>
              <span>Seleccionar</span>
              </label>
              <div class="clear"></div>

              </div>
              <div class="clear"></div>
              </li>
              <?
              }
              }
              ?>
              <div class="clear"></div>
              </ul>
              <div class="clear"></div>
              </form>
              </div>
              <? */ ?>
            <!-- /filtro marcas -->

            <?
//            if (isset($_GET['filtro'])) {
            ?>
            <!-- filtros utilizados -->
            <div class="row">
                <h4>FILTRO DE B&Uacute;SQUEDA UTILIZADO</h4>
                <div class="row row-filtrosUtilizados modulo">
                    <div class="criterio">
                        <?
                        switch ($_GET['filtro']) {
                            case "nombre":
                                ?>
                                NOMBRE: <?= $_GET['nombre'] ?>
                                <?
                                break;
                            case "apellido":
                                ?>
                                APELLIDO: <?= $_GET['apellido'] ?>
                                <?
                                break;
                            case "email":
                                ?>
                                E-MAIL: <?= $_GET['email'] ?>
                                <?
                                break;
                        }
                        ?>
                    </div>
                    <?php /* ?>                <div class="otraBusqueda"><a href="#" class="btn-otra-cot"><img src="<?=$this->vista->globales['rutaVistasModulo']?>img/btn_modificar.gif" width="196" height="26" alt="Modificar datos de b&uacute;squeda"></a></div>
                      <?php */ ?>          	</div>
                <div class="clear"></div>
            </div>
            <!-- /filtros utilizados -->
            <? /*
              <!-- mensaje resultado -->
              <div class="row row-nombreresultado modulo">
              <?= $this->vista->datosCliente[0]['nombres'] ?>, seg&uacute;n tu b&uacute;squeda hemos encontrado los siguientes resultados:
              <div class="clear"></div>
              </div>
              <!-- /mensaje resultado -->
             */ ?>
            <!-- detalle resultados -->
            <div class="row row-resultados modulo">
                <div class="row lineaAzulFondo">
                    <h3>DETALLE DE RESULTADOS</h3>
                    <div class="mas-info">
                        <span>Para m&aacute;s informaci&oacute;n:</span>
                        <a href="#" class="btn_xls"><img src="<?= $this->vista->globales['rutaVistasModulo'] ?>img/btn_desc_xls.gif" width="231" height="33" alt="Exportar .xls"></a>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="row">
                    <div class="mensaje">
                        <?
                        if (isset($_GET['estado']) && $_GET['estado'] == "borrado") {
                            echo "Elemento Borrado";
                        }
                        ?>
                        <span class="texto-usuarios">USUARIOS <?= $marcaTablaSel ?> REGISTRADOS</span>
                        <span class="nuevousuario"><a href="<?= $this->vista->globales['actionForm'] ?>&accion=nuevo">CREAR NUEVO</a></span>
                        <div class="clear"></div>
                    </div>
                    <?
                    $maxPorPag = 25;

                    $pagina = 1;

                    if (isset($_GET['pag']) && $_GET['pag']) {
                        $pagina = (int) $_GET['pag'];
                    }

                    $totalResultados = 0;

                    if ($result = mysql_query("select count(*) as total from " . $this->vista->stringTablas . " " . preg_replace("/order by .+ (desc|asc)/i", "", $this->vista->condicionTabla), $this->vista->modeloBackend->link)) {
                        if (mysql_num_rows($result) > 0) {
                            if ($row = mysql_fetch_array($result)) {
                                $totalResultados = $row['total'];
                            }
                        }
                    }

                    if ($totalResultados > 0) {
                        $totalPaginas = ceil($totalResultados / $maxPorPag);
                    }

                    if ($pagina < 2) {
                        $pagDesde = 0;
                    } else {
                        $pagDesde = ($pagina - 1) * $maxPorPag;
                    }

//                        echo "select " . $this->vista->stringCampos . " from " . $this->vista->stringTablas . " " . $this->vista->condicionTabla . " limit " . $pagDesde . "," . $maxPorPag;
                    if ($result = mysql_query("select " . $this->vista->stringCampos . " from " . $this->vista->stringTablas . " " . $this->vista->condicionTabla . " limit " . $pagDesde . "," . $maxPorPag, $this->vista->modeloBackend->link)) {
                        if (mysql_num_rows($result) > 0) {
                            ?>
                            <div class="tablacont">
                                <table width="940" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <?
                                        foreach ($this->vista->masterArray['campos'] as $key => $value) { //Recorro los campos
                                            if (isset($value['reporteTabla'])) {
                                                ?>
                                                <th scope="col"><?= $value['reporteTabla'] ?></th>
                                                <?
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <?
                                    $contFondo = 1;
                                    while ($row = mysql_fetch_array($result)) {
//                                            if ($marcaTabla[0] == $row['marca']) {

                                        $row = $this->vista->modeloBackend->limpiarEscapes($row);
                                        ?>
                                        <tr <?
                                        if ($contFondo % 2 == 0) {
                                            echo 'class="fnd-gris"';
                                        }
                                        ?>>
                                                <?
                                                foreach ($this->vista->masterArray['campos'] as $key => $value) { //Recorro los campos
                                                    if (isset($value['reporteTabla'])) {
                                                        ?>
                                                    <td>
                                                        <?
                                                        if ($value['reporteTabla'] == "editar") {
                                                            ?>
                                                            <a class="linkeditar" href="<?= $this->vista->globales['actionForm'] ?>&accion=editar&id=<?= $row['id'] ?>">Editar</a>
                                                            <?
                                                        } else if ($value['reporteTabla'] == "borrar") {
                                                            ?>
                                                            <a class="borrarFicha" href="<?= $this->vista->globales['actionForm'] ?>&accion=borrar&id=<?= $row['id'] ?>">Borrar</a>
                                                            <?
                                                        } else {

                                                            if (isset($value['alias']) && !empty($value['alias'])) {
                                                                $valorCampo = $value['alias'];
                                                            } else {
                                                                $valorCampo = $value['bd'];
                                                            }

                                                            if (isset($row[$valorCampo])) {

                                                                if (preg_match("/precio/i", $valorCampo) || preg_match("/valor/i", $valorCampo)) {
                                                                    echo $this->vista->objForm->formatoPrecio($row[$valorCampo]);
                                                                } else {
                                                                    echo $row[$valorCampo];
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <?
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <?
//                                            }
                                        $contFondo++;
                                    }
                                    ?>
                                </table>
                                <div class="clear"></div>
                            </div>
                            <?
                        }
                    }
                    ?>

                    <div class="clear"></div>
                </div>
                <div class="row paginador">
                    <div class="pag">
                        <div class="txt-pag">P&Aacute;GINA</div>
                        <div class="sel-cont">
                            <select name="selectPag">
                                <?
                                for ($i = 1; $i <= $totalPaginas; $i++) {
                                    ?>
                                    <option <?
                                    if ($i == $pagina) {
                                        echo "selected='selected'";
                                    }
                                    ?>><?= $i ?></option>
                                        <?
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="txt-pag">DE <?= $totalPaginas ?></div>
                        <div class="clear"></div>
                    </div>
                    <? /*
                      <div class="mas-info">
                      <span>Para m&aacute;s informaci&oacute;n:</span>
                      <a href="#" class="btn_xls"><img src="<?=$this->vista->globales['rutaVistasModulo']?>img/btn_desc_xls.gif" width="231" height="33" alt="Exportar .xls"></a>
                      <div class="clear"></div>
                      </div>
                     */ ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <!-- /detalle resultados -->
            <?
//            }
            ?>
            <div class="clear"></div>
        </section>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".borrarFicha").click(function(e) {
                    if (!confirm("¿Desea eliminar este usuario?")) {
                        e.preventDefault();
                    }
                });
            });
        </script>
        <!-- /Contenido -->
    </body>
</html>