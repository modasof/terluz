<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Usuarios</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
            <li class="breadcrumb-item active">Usuarios</li>
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
		<div class="card card-primary">
			<div class="card-body">
				  <a href="?controller=usuarios&&action=nuevo" class="btn btn-success" style="float: right;"><i class="fa fa-file-text-o bigger-110 "></i> Crear Usuario</a>
				  <br><br>
			<div class="card-header">
			  <h3 class="card-title">Marcas</h3>
			</div>
				  <table id="cotizaciones" class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
						  <th>ID</th>
						  <th>Foto</th>
						  <th>Marca</th>
						  <th>Acción</th>
						</tr>
					</thead>
				  <tbody>
					  <?php
					  $campos = $campos->getCampos();
					  foreach ($campos as $campo){
						$imagen = $campo['imagen'];
						$id_usuario = $campo['id_usuario'];
						$nombre_usuario = $campo['nombre_usuario'];
            $telefono = $campo['telefono'];
            $email = $campo['email'];
             $celular = $campo['celular'];
             $documento = $campo['documento'];
             $rol_id_rol = $campo['rol_id_rol'];
             $username = $campo['username'];
             $pass = $campo['pass'];
             $estado_usuario = $campo['estado_usuario'];
						?>
						<tr>
							<td class="text-center"><?php echo $id_usuario; ?> </td>
							<td><img src="<?php echo $imagen; ?>" height="50" width="50"></td>
							<td><?php echo utf8_encode($nombre_usuario); ?></td>
							<td>
							<a href="?controller=usuarios&&action=editar&&id=<?php echo $id_usuario; ?>" class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Editar Usuario">
								<i class="fa fa-edit bigger-110 "></i>
							</a>
							<a href="#" onclick="eliminar(<?php echo $id_usuario; ?>);" class="tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar Testimonio">
								<i class="fa fa-trash bigger-110 "></i>
							</a>
							</td>
						</tr>
						<?php
						  }
					  ?>
					</tbody>
					</table>
			  </div> <!-- Fin Row -->
		  </div> <!-- Fin card -->
		</div>
		</div>



      </div> <!-- Fin Row -->
    </div> <!-- Fin Container -->
  </div> <!-- Fin Content -->
</div> <!-- Fin Content-Wrapper -->

<script>
function eliminar(id){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=marcasu&&action=eliminar&&id="+id;
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>


<!-- page script -->
<script>
  $(function () {
    $('#cotizaciones').DataTable({
      "paging": true,
      "lengthChange": true,
      "lengthMenu": [[25, 50, 150, -1], [25, 50, 150, "All"]],
      "searching": true,
      "order": [[ 0, "asc" ]],
      "ordering": true,
      "info": true,
      "autoWidth": false,
    language: {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}

    });
  });
</script>

