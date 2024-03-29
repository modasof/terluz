<?php
ini_set('display_errors', '0');
include_once 'modelos/cuentas.php';
include_once 'controladores/cuentasController.php';

include_once 'modelos/subrubros.php';
include_once 'controladores/subrubrosController.php';

require_once 'vistas/index/header-formdate.php';
  $CuentaSel=$_GET['id_cuenta'];
   $SubrubroSel=$_GET['id_subrubro'];
   $nombresubrubro=Subrubros::obtenerNombreSubrubro($SubrubroSel);
  $cuentas = Egresoscuenta::obtenerCuentapor($CuentaSel);
      
foreach($cuentas as $caja){
      $id_cuenta = $caja['id_cuenta'];
      $nombre_cuenta = $caja['nombre_cuenta'];
      }
  $Acuentas="Movimiento a cuenta";
  $ACajas="Cuenta";
  $AOtros="Otro tipo de egreso";
  
  $egresosacuentas=Egresoscuenta::EgresosPortipo($CuentaSel,$Acuentas);
  $egresosacajas=Egresoscuenta::EgresosPortipo($CuentaSel,$ACajas);
  $egresosaotros=Egresoscuenta::EgresosPortipo($CuentaSel,$AOtros);

  $totalegresos=$egresosacuentas+$egresosacajas+$egresosaotros;
 ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Egresos <?php echo utf8_encode($nombre_cuenta) ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
             <li class="breadcrumb-item"><a href="?controller=informes&&action=cuentas">Cuentas</a></li>
             <li class="breadcrumb-item"><a href="?controller=informes&&action=movimientoscuentas&&id_cuenta=<?php echo($CuentaSel); ?>">Movimientos <?php echo($nombrecuenta); ?></a></li>
            
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
    <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">

    <div class="container-fluid">
      <div class="row">
    <div class="col-lg-12">
      <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Lista Egresos por <?php echo($nombresubrubro); ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <form action="?controller=egresoscuenta&&action=egresosporfechasubrubro&&id_cuenta=<?php echo($CuentaSel); ?>" method="post" id="FormFechas" autocomplete="off">
         <div class="col-12">
                        <div class="form-group">
                          <label>Seleccione el Rango de Fecha<span>*</span></label>
                          <input type="text"  name="daterange" class="form-control" required value="">
                        </div>
                      </div>
          <div class="form-group">
            <div class="col-xs-12 col-sm-12">
              <button class="btn btn-primary btn-sm" type="Submit">Realizar Consulta</button>           
          </div>    
          </div>
        </form>
        <script type="text/javascript">
  $('input[name="daterange"]').daterangepicker({
    ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este Mes': [moment().startOf('month'), moment().endOf('month')],
        'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "desde",
        "toLabel": "hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    //"startDate": "03/24/2019",
    //"endDate": "03/30/2019",
    "opens": "left"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script>

 <?php 
        if ($fechaform!="") {
          ?>
           <h3 class="m-0 text-dark">Reporte Egresos del <?php echo(fechalarga($datofechain)) ?> al <?php echo (fechalarga($datofechafinal)) ?></h3>
          <?php
        }
        else
        {
          ?>
           <h3 class="m-0 text-dark">Reporte Total Egresos </h3>
          <?php
        }
         ?>

          <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
                    </div>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table display-compact table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
           <tfoot style="display: table-header-group;">
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>
                                    <th style="background-color: #dff0d8" class="success"></th>    
                            </tfoot>
          <thead>
            <tr style="background-color: #4f5962;color: white;">
             
              <th>Fecha</th>
              <th>Valor</th>
              <th>Tipo Egreso</th>
              <th>Beneficiario</th>
              <th>Rubro</th>
              <th>Subrubro</th>
              <th>Detalle</th>
               <th>Acciones</th>
              
              
             
            </tr>
            <tr>
               
              <th>Fecha</th>
              <th>Valor</th>
              <th>Tipo Egreso</th>
              <th>Beneficiario</th>
              <th>Rubro</th>
              <th>Subrubro</th>
              <th>Detalle</th>
              <th>Acciones</th>
             
            </tr>
          </thead>
          <tbody>
            <?php

           if ($fechaform!="") {
              $res=Egresoscuenta::obtenerEgresosporfechasubrubro($CuentaSel,$FechaStart,$FechaEnd,$SubrubroSel);
              $campos = $res->getCampos();
            }
            else
            {
              $campos = $campos->getCampos();
            }

            foreach ($campos as $campo){
            $id_egreso_cuenta = $campo['id_egreso_cuenta'];
            $tipo_egreso = $campo['tipo_egreso'];
            $beneficiario = $campo['beneficiario'];
            $caja_beneficiada= $campo['caja_beneficiada'];
            $cuenta_beneficiada = $campo['cuenta_beneficiada'];
            $cuenta_id_cuenta = $campo['cuenta_id_cuenta'];
            $imagen = $campo['imagen'];
            $fecha_egreso = $campo['fecha_egreso'];
            $valor_egreso = $campo['valor_egreso'];
            $observaciones = $campo['observaciones'];
            $id_rubro = $campo['id_rubro'];
            $marca_temporal = $campo['marca_temporal'];
            

            //************************************************************************************************
            // VALIDAMOS QUE TIPO DE EGRESO ES 
            //************************************************************************************************
            if ($caja_beneficiada!=0) {
              $nombrebeneficiario=Egresoscuenta::ObtenerNombrecaja($caja_beneficiada);
            }
           elseif ($cuenta_beneficiada!=0) {
              $nombrebeneficiario=Egresoscuenta::ObtenerNombrecuenta($cuenta_beneficiada);
            }
            elseif ($id_rubro!=0) {
              $nombrebeneficiario=$beneficiario;
            }
            else
            {
              $nombrebeneficiario="";
            }
            
            //************************************************************************************************

            
            
            $id_subrubro = $campo['id_subrubro'];
            if ($id_rubro!=0) {
              $nombrerubro=Egresoscuenta::ObtenerRubropor($id_rubro);
            }
            else
            {
              $nombrerubro="";
            }
           
            
            
            if ($tipo_egreso=="Cuenta") {
              $tipo_egreso="Movimiento a Caja";
            }
            
            
            ?>
            <tr>
              
              <td><?php echo utf8_encode($fecha_egreso) ?></td>
              <td><?php Echo utf8_encode("$ ".number_format($valor_egreso));  ?></td>
              <td><?php echo utf8_encode($tipo_egreso) ?></td>
             <td><?php echo utf8_encode($nombrebeneficiario) ?></td>
               <td><?php 
                if ($id_subrubro!=0) {
              $nombresubrubro=Egresoscuenta::ObtenersubRubropor($id_subrubro);
            }
            else
            {
              $nombresubrubro="";
            }
               echo utf8_encode($nombrerubro) 
               ?></td>
             <td><?php echo utf8_encode($nombresubrubro) ?></td>
             <td><?php echo utf8_encode($observaciones) ?></td>
            
              
             
              <td>
                 <div class="btn-group">

              <?php 
              if ($tipo_egreso=="Movimiento a Caja") {

                $id_ingreso_caja=Egresoscuenta::obtenerIdingresocaja($id_egreso_cuenta);
               ?>
               <button type="button" class="btn btn-default btn-flat"><a href="?controller=egresoscuenta&&action=editarcm&&id=<?php echo $id_egreso_cuenta; ?>&&id_cuenta=<?php echo($id_cuenta); ?>" class="tooltip-primary text-success" title="Editar Egreso">
                <i class="fa fa-edit bigger-110 "></i>
              </a>
             </button>

             <button  type="button" class="btn btn-default btn-flat"> <a href="#" onclick="eliminarcm(<?php echo $id_egreso_cuenta; ?>,<?php echo($id_ingreso_caja); ?>,<?php echo($CuentaSel); ?>);" class="tooltip-primary text-danger" title="Eliminar Egreso">
                <i class="fa fa-trash bigger-110 "></i>
              </a>
            </button>
               <?php
              }elseif ($tipo_egreso=="Movimiento a cuenta") {

                 $Idingresoasocio=Egresoscuenta::obtenerIdingresocuenta($id_egreso_cuenta);
               ?>
                 <button type="button" class="btn btn-default btn-flat"><a href="?controller=egresoscuenta&&action=editarcu&&id=<?php echo $id_egreso_cuenta; ?>&&id_cuenta=<?php echo($id_cuenta); ?>" class="tooltip-primary text-success" title="Editar Egreso">
                <i class="fa fa-edit bigger-110 "></i>
              </a>
             </button>
              <button  type="button" class="btn btn-default btn-flat"> <a href="#" onclick="eliminarmvs(<?php echo $id_egreso_cuenta; ?>,<?php echo($Idingresoasocio); ?>,<?php echo($CuentaSel); ?>);" class="tooltip-primary text-danger" title="Eliminar Egreso">
                <i class="fa fa-trash bigger-110 "></i>
              </a>
            </button>
               <?php
              }elseif ($tipo_egreso=="Otro tipo de egreso") {
                ?>
                <button type="button" class="btn btn-default btn-flat"><a href="?controller=egresoscuenta&&action=editarot&&id=<?php echo $id_egreso_cuenta; ?>&&id_cuenta=<?php echo($id_cuenta); ?>" class="tooltip-primary text-success" title="Editar Egreso">
                <i class="fa fa-edit bigger-110 "></i>
              </a>
             </button>
              <button  type="button" class="btn btn-default btn-flat"> <a href="#" onclick="eliminarot(<?php echo $id_egreso_cuenta; ?>,<?php echo($CuentaSel) ?>);" class="tooltip-primary text-danger" title="Eliminar Egreso">
                <i class="fa fa-trash bigger-110 "></i>
              </a>
            </button>

                <?php
              }


               ?>
              
             
             <button type="button" class="btn btn-default btn-flat"> <a target="_blank" href="<?php echo($imagen); ?>"  class="tooltip-primary text-primary" title="Ver Soporte">
                <i class="fa fa-eye bigger-110 "></i>
              </a>
            </button>
             <button type="button" class="btn btn-default btn-flat"> <a download="Soporte" href="<?php echo($imagen); ?>"  class="tooltip-primary text-dark" title="Descargar Soporte">
                <i class="fa fa-cloud-download bigger-110 "></i>
              </a>
            </button>




                    </div>
             
              </td>
              
            </tr>
            <?php
              }
            ?>
          </tbody>
          </table>
        </div> <!-- Fin Row -->



              </div>
              <!-- /.card-body -->
            </div>


   
    </div>


      </div> <!-- Fin Row -->
    </div> <!-- Fin Container -->
  </div> <!-- Fin Content -->
</div> <!-- Fin Content-Wrapper -->

<script>
function eliminarcm(idegreso,idingreso,cuentasel){
   eliminar=confirm("¿Deseas eliminar este registro?");
   
   if (eliminar)
    
  window.location.href="?controller=egresoscuenta&&action=eliminarcm&&idegreso="+idegreso+"&&idingreso="+idingreso+"&&id_cuenta="+cuentasel+"";

else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>

<script>
function eliminarmvs(idegreso,idingreso,cuentasel){
   eliminar=confirm("¿Deseas eliminar este registro?");
   
   if (eliminar)
    
  window.location.href="?controller=egresoscuenta&&action=eliminarmvs&&idegreso="+idegreso+"&&idingreso="+idingreso+"&&id_cuenta="+cuentasel+"";

else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>

<script>
function eliminarot(idegreso,$CuentaSel){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
window.location.href="?controller=egresoscuenta&&action=eliminarot&&idegreso="+idegreso+"&&id_cuenta="+$CuentaSel+"";
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>


<script>
   function format2(n, currency) {
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
        $(document).ready(function() {
    $('#example').DataTable( {
         "searching": true,
        "ordering": true,
        "paging":   true,
        "info":     true,
        "aLengthMenu": [[100, 200, 300, -1], [100, 200, 300, "Todas"]],
    "pageLength": 100,
       
       
    } );
} );
    </script>

<!-- page script -->

<script type="text/javascript">
      jQuery(function($) {
      
$('#cotizaciones thead tr:eq(1) th').each( function () {
        var title = $('#cotizaciones thead tr:eq(0) th').eq( $(this).index() ).text();
        $(this).html( '<input style="width:100%;border:black solid 1px;" type="text" placeholder="Buscar '+title+'" />' );
    } ); 
  
    var table = $('#cotizaciones').DataTable({
       responsive:true,
      //"order": true,
       "ordering": true,
       "lengthChange": false,
        "order": [[ 0, "desc" ]],
        orderCellsTop: true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se ha encontrado nada - Lo sentimos",
            "info": "Mostrar página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
           },
      
    "lengthMenu": [[5000, 7000, 10000, -1], [5000, 7000, 10000, "All"]],

          select: {
            style: 'multi'
          },
           "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

 
            // Total over all pages
           
           
            pageTotal7 = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
           
             // Update footer
           
             // Update footer
            $( api.column( 1 ).footer() ).html(
                '$'+format2(pageTotal7,'' )
            );  
            
        },

    });
  
    // Apply the search
    table.columns().every(function (index) {
        $('#cotizaciones thead tr:eq(1) th:eq(' + index + ') input').on('keyup change', function () {
            table.column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();    
        });
    });

        var myTable = 
        $('#cotizaciones')
        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
        .DataTable( {
retrieve: true,

          
          "aoColumns": [
            { "bSortable": false },
            null, null,null, null,null,null,null,null, null,null, null,null,null,null,null, null,null, null,null,null,null,
            { "bSortable": false }
          ],
          "aaSorting": [],
          "scrollX": true,
          
         
      
          } );
      
        
    

        
        $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
        
        new $.fn.dataTable.Buttons( myTable, {
         "buttons": ["copy","csv","excel","pdf","print","colvis"]
        } );
        myTable.buttons().container().appendTo( $('.tableTools-container') );
        
        // style the message box
        // var defaultCopyAction = myTable.button(1).action();
        // myTable.button(1).action(function (e, dt, button, config) {
        //   defaultCopyAction(e, dt, button, config);
        //   $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        // });
        


        
        // var defaultColvisAction = myTable.button(0).action();
        // myTable.button(0).action(function (e, dt, button, config) {
          
        //   defaultColvisAction(e, dt, button, config);
          
          
        //   if($('.dt-button-collection > .dropdown-menu').length == 0) {
        //     $('.dt-button-collection')
        //     .wrapInner('<ul class="dropdown-menu dropdown-light " />')
        //     .find('a').attr('href', '#').wrap("<li />")
        //   }
        //   $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
        // });
      
        //
      
        setTimeout(function() {
          $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
          });
        }, 500);
        
        
        
        
        
        myTable.on( 'select', function ( e, dt, type, index ) {
          if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
          }
        } );
        myTable.on( 'deselect', function ( e, dt, type, index ) {
          if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
          }
        } );
      
      
      
      
      
      
        /////////////////////////////////
        //table checkboxes
        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
        
        //select/deselect all rows according to table header checkbox
        $('#cotizaciones > thead > tr > th input[type=checkbox], #cotizaciones_wrapper input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header
          
          $('#cotizaciones').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable.row(row).select();
            else  myTable.row(row).deselect();
          });
        });
        
        //select/deselect a row when the checkbox is checked/unchecked
        $('#cotizaciones').on('click', 'td input[type=checkbox]' , function(){
          var row = $(this).closest('tr').get(0);
          if(this.checked) myTable.row(row).deselect();
          else myTable.row(row).select();
        });
      
      
      
        $(document).on('click', '#cotizaciones .dropdown-toggle', function(e) {
          e.stopImmediatePropagation();
          e.stopPropagation();
          e.preventDefault();
        });
        
        
        
        //And for the first simple table, which doesn't have TableTools or dataTables
        //select/deselect all rows according to table header checkbox
        var active_class = 'active';
        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header
          
          $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
          });
        });
        
        //select/deselect a row when the checkbox is checked/unchecked
        $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
          var $row = $(this).closest('tr');
          if($row.is('.detail-row ')) return;
          if(this.checked) $row.addClass(active_class);
          else $row.removeClass(active_class);
        });
      
        
      
        /********************************/
        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        
        //tooltip placement on right or left
        function tooltip_placement(context, source) {
          var $source = $(source);
          var $parent = $source.closest('table')
          var off1 = $parent.offset();
          var w1 = $parent.width();
      
          var off2 = $source.offset();
          //var w2 = $source.width();
      
          if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
          return 'left';
        }
        
        
        
        
        /***************/
        $('.show-details-btn').on('click', function(e) {
          e.preventDefault();
          $(this).closest('tr').next().toggleClass('open');
          $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
        });
        /***************/
    
      
      })
    </script>