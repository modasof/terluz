<?php 
if ($RolSesion==1) {
    # =======================================================
    # =           Sección Tabla General de Obras (Vista Súper Admin)           =
        # OK - Cronogramas
        # OK - Edición de Obra
        # OK - Frentes
        # OK - Personal
        # OK - Informe
        # OK - Personal
        # OK - Valor Final
        # OK - Modificaciones
        # OK - Avance
        # OK - Vr. Avance 
        # OK - Vr. Gastos 
        # OK - Resultados 
    
    # =======================================================

 ?>
 <div class="col-md-12">
     <div class="box">

      
            <div class="box-body">
              <a href="?controller=obras&&action=nueva_obra" class="btn btn-app">
                <i class="fa fa-plus-square"></i> Nueva Obra
              </a>
              <a href="?controller=listame&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-ME
              </a>
               <a href="?controller=listamo&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-MO
              </a>
               <a href="?controller=insumos&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-INS
              </a>
               <a href="?controller=personalextra&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-PEX
              </a>
            </div>
            <!-- /.box-body -->
          </div>
</div>

<div class="col-md-12">

    <div class="box box-warning">
<div class="box-header with-border">
<h3 class="box-title">Total Obras</h3>
<div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

<div class="box-body">
   <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
    </div>
              <div class="">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
          <thead>
              <tr style="background-color: #4f5962;color: white;">
               
            <th>Id</th>
            <th>Obra</th>
            <th>Frentes</th>
            <th>R. Humano</th>
            <th>Informe</th>
            <th>Valor Final</th>
            <th>Modificaciones</th>
            <th>% Avance</th>
            <th>Vr. Avance</th>
            <th>Vr. Gastos </th>
            <th>Resultado</th>
            
            </tr>
          </thead>
       <tbody>
      <?php 


if ($RolSesion!=1) {
    $res    = Obras::misobras($IdSesion);
}else{
    $res    = Obras::todos();
}
$campos = $res->getcampos();

foreach ($campos as $campo) {


if ($RolSesion!=1) {
    $id_obra          = $campo['obra_id_obra'];
}else{
    $id_obra          = $campo['id_obra'];
}




    $nombre_obra      = Obras::obtenernombreobra($id_obra);
    $valororiginal= Valorinicialobra($id_obra);
    $valoravance = Obras::sqlavancesporobra($id_obra);
    $valormayores = Obras::sqlvalormayoresporobra($id_obra);
    $valormenores = Obras::sqlvalormenoresporobra($id_obra);
    $valormodificaciones=$valormayores-$valormenores;

$cxp = Obras::sqlvalorgastoporobra($id_obra);
$inv = Obras::sqlvalorinventarioobra($id_obra);

$totalgastos = $cxp+$inv;

    if ($valormodificaciones < 0) {
        $valorfinalobra = $valororiginal+$valormodificaciones;
    }else{
         $valorfinalobra = $valororiginal+$valormodificaciones;
    }

     $porcentaje_obra = formulaporcentaje($valoravance,$valorfinalobra);


       ?>


        <tr>
    <td>

        <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
                          Cronogramas
                          <span class="ace-icon fa fa-caret-down icon-on-left"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-info dropdown-menu-left">

         
        <li>
            <a href="?controller=obras&&action=proyecciones&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Actividades">
                <i class="fa fa-calendar bigger-110 "> Actividades</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccioneslme&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Equipos">
                <i class="fa fa-truck bigger-110 "> Equipos</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccionesins&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Materiales">
                <i class="fa  fa-area-chart bigger-110 "> Materiales</i>
            </a>
        </li>
        <li>
             <a href="?controller=proyeccioneslmo&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Mano de Obra">
                <i class="fa fa-street-view bigger-110 "> Mano de Obra</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccionesadm&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Administración">
                <i class="fa fa-dollar bigger-110 "> Administración</i>
            </a>
            
        </li>
            

                        </ul>
                      </div>

        <?php 
        if ($RolSesion==1) {
            ?>

            <a style="display: none;" href="#" onclick="eliminar(<?php echo $id_obra; ?>);" class="tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar Obra">
                <i class="fa fa-trash bigger-110 "></i>
            </a>

            <?php
        }

         ?>
               

          </td>
<td>
    <a href="?controller=obras&&action=detalle_obra&&id=<?php echo($id_obra); ?>"><?php echo utf8_decode($nombre_obra); ?> 
    </a>
</td>

          
    <td><a href="?controller=frentes&&action=todosobra&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-external-link-square"> Frentes <?php 
            $contadorfrente = Frentes::cantidadporobra($id_obra);
            echo ("(".$contadorfrente.")");
             ?></i></a>
    </td>
       <td>
        <a href="?controller=personalobras&&action=todosobranomina&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-users"> Personal <?php 
            $contadorpersonal = Personalobras::cantidadporobra($id_obra);
            echo ("(".$contadorpersonal.")");
             ?></i></a>
         </td>
     <td><a href="?controller=rangos&&action=todosobra&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-dashboard"> Informe </i></a>
    </td>
        <td><a href=""><i class="fa fa-external-link-square"> 
            <?php echo ("$" . number_format($valorfinalobra,0)); ?>
          </i></a>
      </td>
<td><a href="?controller=obras&&action=modificaciones&&id=<?php echo($id_obra); ?>">
    <?php 
    if ($valormodificaciones>0) {
        echo ("<span class='text-success'> $" . number_format($valormodificaciones,0)." <i class='fa fa-arrow-circle-up'></i></span>");
    }elseif($valormodificaciones<0)
    {
        echo ("<strong class='text-danger'> $" . number_format($valormodificaciones,0)." <i class='fa fa-arrow-circle-down'></i></strong>");   
    }
    else{
        echo ("<strong class='text-info'> $" . number_format($valormodificaciones,0)." <i class='fa  fa-arrow-circle-right'></i></strong>");   
    }

     ?>

</a></td>
        <td><a href="?controller=obras&&action=avance_obra&&id=<?php echo($id_obra); ?>"><span class="badge bg-yellow"> <?php echo($porcentaje_obra) ?>%</span></a></td>
        <td><a href="?controller=obras&&action=avance_obra&&id=<?php echo($id_obra); ?>"><i class="fa fa-external-link-square">   <?php echo ("$" . number_format($valoravance,0)); ?></i></a></td>
        <td><a href=""><i class="fa fa-external-link-square"> $<?php echo(number_format($totalgastos,0)) ?></i></a></td>
         <td><a href=""><i class="fa fa-external-link-square"> $ 0</i></a></td>
        
        </tr>
  <?php 
}
   ?>
       </tbody>
     </table>
   </div>

</div>

</div>

</div>

<?php 

}
    # ======  Final Sección Tabla Perfil Super Admin  =======

elseif ($RolSesion==14) {
    # =======================================================
    # =           Sección Tabla General de Obras (Vista Ing. Residente)     =
        # OK - Personal
        # OK - Personal
        # OK - Avance
        # OK - Vr. Avance 
    # =======================================================

 ?>

 <div class="col-md-12">
     <div class="box">

      
            <div class="box-body">
           
               <a href="?controller=personalextra&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-PEX
              </a>
            </div>
            <!-- /.box-body -->
          </div>
</div>

 <div class="col-md-12">

    <div class="box box-warning">
<div class="box-header with-border">
<h3 class="box-title">Total Obras</h3>
<div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

<div class="box-body">

   <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
    </div>
              <div class="">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
          <thead>
              <tr style="background-color: #4f5962;color: white;">
            <th>Id</th>
            <th>Cronogramas</th>
            <th>Obra</th>
            <th>% Avance</th>
            <th>R. Humano</th>
            <th>Vr. Avance</th>
            </tr>
          </thead>
       <tbody>
      <?php 

$res    = Obras::misobras($IdSesion);

$campos = $res->getcampos();

foreach ($campos as $campo) {



    $id_obra          = $campo['obra_id_obra'];
    $nombre_obra      = Obras::obtenernombreobra($id_obra);
    $valororiginal= Valorinicialobra($id_obra);
    $valoravance = Obras::sqlavancesporobra($id_obra);
    $valormayores = Obras::sqlvalormayoresporobra($id_obra);
    $valormenores = Obras::sqlvalormenoresporobra($id_obra);
    $valormodificaciones=$valormayores-$valormenores;

    if ($valormodificaciones < 0) {
        $valorfinalobra = $valororiginal+$valormodificaciones;
    }else{
         $valorfinalobra = $valororiginal+$valormodificaciones;
    }

     $porcentaje_obra = formulaporcentaje($valoravance,$valorfinalobra);


       ?>


        <tr>
    <td>

        <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
                        Reportar
                          <span class="ace-icon fa fa-caret-down icon-on-left"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-info dropdown-menu-left">

         
        <li>
            <a href="?controller=horasmq&&action=horas&&id_obra=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Reportar Horas Máquina">
                <i class="fa fa-list bigger-110"> Reporte Horas</i>
            </a>
        </li>

         <li>
            <a href="?controller=agregadosobra&&action=agregados&&id_obra=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Recibir Material">
                <i class="fa fa-list bigger-110"> Recepción Materiales</i>
            </a>
        </li>

         <li>
            <a href="?controller=inconvenientes&&action=todos&&id_obra=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Reportar Inconveniente">
                <i class="fa fa-list bigger-110"> Reportar Inconveniente</i>
            </a>
        </li>
    
                        </ul>
                      </div>        

          </td>
              <td>

        <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
                          Cronogramas
                          <span class="ace-icon fa fa-caret-down icon-on-left"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-info dropdown-menu-left">

         
        <li>
            <a href="?controller=obras&&action=proyecciones&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Actividades">
                <i class="fa fa-calendar bigger-110 "> Actividades</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccioneslme&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Equipos">
                <i class="fa fa-truck bigger-110 "> Equipos</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccionesins&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Materiales">
                <i class="fa  fa-area-chart bigger-110 "> Materiales</i>
            </a>
        </li>
        <li>
             <a href="?controller=proyeccioneslmo&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Mano de Obra">
                <i class="fa fa-street-view bigger-110 "> Mano de Obra</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccionesadm&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Administración">
                <i class="fa fa-dollar bigger-110 "> Administración</i>
            </a>
            
        </li>
            

                        </ul>
                      </div>

        <?php 
        if ($RolSesion==1) {
            ?>

            <a style="display: none;" href="#" onclick="eliminar(<?php echo $id_obra; ?>);" class="tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar Obra">
                <i class="fa fa-trash bigger-110 "></i>
            </a>

            <?php
        }

         ?>
               

          </td>
    
<td>
    <a href="?controller=obras&&action=detalle_obra&&id=<?php echo($id_obra); ?>"><?php echo utf8_decode($nombre_obra); ?> 
    </a>
</td>
     <td><a href="?controller=obras&&action=avance_obra&&id=<?php echo($id_obra); ?>"><span class="badge bg-yellow"> <?php echo($porcentaje_obra) ?>%</span></a></td>
          
   
    <td>
        <a href="?controller=personalobras&&action=todosobranomina&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-users"> Personal <?php 
            $contadorpersonal = Personalobras::cantidadporobra($id_obra);
            echo ("(".$contadorpersonal.")");
             ?></i></a>
    </td>
    

       
        <td><a href="?controller=obras&&action=avance_obra&&id=<?php echo($id_obra); ?>"><i class="fa fa-external-link-square">   <?php echo ("$" . number_format($valoravance,0)); ?></i></a></td>
       
        </tr>
  <?php 
}
   ?>
       </tbody>
     </table>
   </div>

</div>

</div>

</div>

<?php 
}
    # ==========================================================
    # =           Final Sección Vista Ing. Director           =
    # ==========================================================

    elseif ($RolSesion==15) {
    # =======================================================
    # =           Sección Tabla General de Obras (Vista Ing. Residente)     =
        # OK - Cronogramas
        # OK - Edición de Obra
        # OK - Frentes
        # OK - Personal
        # NO - Informe
        # OK - Personal
        # OK - Valor Final
        # OK - Modificaciones
        # OK - Avance
        # OK - Vr. Avance 
        # OK - Vr. Gastos 
        # OK - Resultados 
    # =======================================================
 ?>

 <div class="col-md-12">
     <div class="box">

      
            <div class="box-body">
              <a href="?controller=obras&&action=nueva_obra" class="btn btn-app">
                <i class="fa fa-plus-square"></i> Nueva Obra
              </a>
              <a href="?controller=listame&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-ME
              </a>
               <a href="?controller=listamo&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-MO
              </a>
               <a href="?controller=insumos&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-INS
              </a>
               <a href="?controller=personalextra&&action=todos" class="btn btn-app">
                <i class="fa fa-list"></i> L-PEX
              </a>
            </div>
            <!-- /.box-body -->
          </div>
</div>


<div style="background-color:white;" class="col-md-12">

    <div class="box box-warning">
<div class="box-header with-border">
<h3 class="box-title">Total Obras</h3>
<div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

<div class="box-body">
   <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
    </div>
              <div class="">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
          <thead>
              <tr style="background-color: #4f5962;color: white;">
               
            <th>Id</th>
            <th>Reportes</th>
            <th>% Avance</th>
            <th>Obra</th>
            <th>Informe</th>
            <th>Frentes</th>
            <th>R. Humano</th>
            <th>Valor Final</th>
            <th>Modificaciones</th>
           
            <th>Vr. Avance</th>
          
            </tr>
          </thead>
       <tbody>
      <?php 


if ($RolSesion!=1) {
    $res    = Obras::misobras($IdSesion);
}else{
    $res    = Obras::todos();
}
$campos = $res->getcampos();

foreach ($campos as $campo) {


if ($RolSesion!=1) {
    $id_obra          = $campo['obra_id_obra'];
}else{
    $id_obra          = $campo['id_obra'];
}




    $nombre_obra      = Obras::obtenernombreobra($id_obra);
    $valororiginal= Valorinicialobra($id_obra);
    $valoravance = Obras::sqlavancesporobra($id_obra);
    $valormayores = Obras::sqlvalormayoresporobra($id_obra);
    $valormenores = Obras::sqlvalormenoresporobra($id_obra);
    $valormodificaciones=$valormayores-$valormenores;

    if ($valormodificaciones < 0) {
        $valorfinalobra = $valororiginal+$valormodificaciones;
    }else{
         $valorfinalobra = $valororiginal+$valormodificaciones;
    }

     $porcentaje_obra = formulaporcentaje($valoravance,$valorfinalobra);


       ?>


        <tr>
    <td>

        <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
                          Cronogramas
                          <span class="ace-icon fa fa-caret-down icon-on-left"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-info dropdown-menu-left">

         
        <li>
            <a href="?controller=obras&&action=proyecciones&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Actividades">
                <i class="fa fa-calendar bigger-110 "> Actividades</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccioneslme&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Equipos">
                <i class="fa fa-truck bigger-110 "> Equipos</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccionesins&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Materiales">
                <i class="fa  fa-area-chart bigger-110 "> Materiales</i>
            </a>
        </li>
        <li>
             <a href="?controller=proyeccioneslmo&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Cronograma Mano de Obra">
                <i class="fa fa-street-view bigger-110 "> Mano de Obra</i>
            </a>
        </li>
        <li>
            <a href="?controller=proyeccionesadm&&action=todosobra&&id=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Administración">
                <i class="fa fa-dollar bigger-110 "> Administración</i>
            </a>
            
        </li>
            

                        </ul>
                      </div>

        <?php 
        if ($RolSesion==1) {
            ?>

            <a style="display: none;" href="#" onclick="eliminar(<?php echo $id_obra; ?>);" class="tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar Obra">
                <i class="fa fa-trash bigger-110 "></i>
            </a>

            <?php
        }

         ?>
               

          </td>
             <td>

        <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
                        Reportar
                          <span class="ace-icon fa fa-caret-down icon-on-left"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-info dropdown-menu-left">

         
        <li>
            <a href="?controller=horasmq&&action=horas&&id_obra=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Reportar Horas Máquina">
                <i class="fa fa-list bigger-110"> Reporte Horas</i>
            </a>
        </li>

         <li>
            <a href="?controller=agregadosobra&&action=agregados&&id_obra=<?php echo($id_obra); ?>"  class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Recibir Material">
                <i class="fa fa-list bigger-110"> Recepción Materiales</i>
            </a>
        </li>
    
                        </ul>
                      </div>        

          </td>
           <td><a href="?controller=obras&&action=avance_obra&&id=<?php echo($id_obra); ?>"><span class="badge bg-yellow"> <?php echo($porcentaje_obra) ?>%</span></a></td>
<td>
    <a href="?controller=obras&&action=detalle_obra&&id=<?php echo($id_obra); ?>"><?php echo utf8_decode($nombre_obra); ?> 
    </a>
</td>
   <td><a href="?controller=rangos&&action=todosobra&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-dashboard"> Informe </i></a>
    </td>

          
    <td><a href="?controller=frentes&&action=todosobra&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-external-link-square"> Frentes <?php 
            $contadorfrente = Frentes::cantidadporobra($id_obra);
            echo ("(".$contadorfrente.")");
             ?></i></a>
    </td>
       <td>
        <a href="?controller=personalobras&&action=todosobranomina&&id_obra=<?php echo($id_obra); ?>"><i class="fa fa-users"> Personal <?php 
            $contadorpersonal = Personalobras::cantidadporobra($id_obra);
            echo ("(".$contadorpersonal.")");
             ?></i></a>
         </td>
    
        <td><a href=""><i class="fa fa-external-link-square"> 
            <?php echo ("$" . number_format($valorfinalobra,0)); ?>
          </i></a>
      </td>
<td><a href="?controller=obras&&action=modificaciones&&id=<?php echo($id_obra); ?>">
    <?php 
    if ($valormodificaciones>0) {
        echo ("<span class='text-success'> $" . number_format($valormodificaciones,0)." <i class='fa fa-arrow-circle-up'></i></span>");
    }elseif($valormodificaciones<0)
    {
        echo ("<strong class='text-danger'> $" . number_format($valormodificaciones,0)." <i class='fa fa-arrow-circle-down'></i></strong>");   
    }
    else{
        echo ("<strong class='text-info'> $" . number_format($valormodificaciones,0)." <i class='fa  fa-arrow-circle-right'></i></strong>");   
    }

     ?>

</a></td>
       
        <td><a href="?controller=obras&&action=avance_obra&&id=<?php echo($id_obra); ?>"><i class="fa fa-external-link-square">   <?php echo ("$" . number_format($valoravance,0)); ?></i></a></td>
      
        
        </tr>
  <?php 
}
   ?>
       </tbody>
     </table>
   </div>

</div>

</div>

</div>




 <?php 
}
    # ======  Final Sección Tabla Perfil Director  =======
 ?>

