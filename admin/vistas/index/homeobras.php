 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Terluz Obras
      </h1>
     
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    

    <!-- Main content -->
<div class="col-md-12">
     <div class="box">

       

            <div class="box-body">
            
              
            </div>
            <!-- /.box-body -->
          </div>
</div>
<div class="col-md-6">
  <form action="">
    <input type="text" value="" name="campo1">
  </form>
</div>
<div class="col-md-6">
   <input type="text" id="plugins4_q" class="" value="" name="campo">

    <div id="jstree">
     
<ul>
<li>OBRA 1
<ul>
<li><strong>EXPLANACIONES</strong>
  <ul>
    <li>
      <td class="bg bg-gren">hola</td>
      <td class="success">chao</td>
      <td>kiuvo</td>
    </li>
    <li><a href="?controller=index&&action=index"><i class="fa fa-dashboard"> </i>EEEExcavación en material común de la explanación y canales</a>  
    </li>
  </ul>
</li>
<li> PAVIMENTOS ,AFIRMADO, SUBBASES Y BASES 
    <ul>
      <li> <span class="badge bg-red">55%</span> Subbase Granular Clase C.</li>
      <li>  <span class="badge bg-red">55%</span> Afirmado (Material para Mejoramiento) </li>
      <li>  <span class="badge bg-red">55%</span> Pavimento de concreto hidraulico módulo de rotura 38 MPa  </li>
      <li>  <span class="badge bg-red">55%</span> Acero de refuerzo de FY = 4.200 Kg/cm 2 (60.000 PSI). </li>
      <li>  <span class="badge bg-red">55%</span> Bordillo de Piezas Prefabricadas de Concreto; incluye la preparacion de la superficie de apoyo </li>
    </ul>
</li>
</ul>
</li>

</ul>
</div>





</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
     $("#jstree").jstree({
    "plugins" : [ "search" ],

  });
  var to = false;
  $('#plugins4_q').keyup(function () {
    if(to) { clearTimeout(to); }
    to = setTimeout(function () {
      var v = $('#plugins4_q').val();
      $('#jstree').jstree(true).search(v);
    }, 250);
  });
  $("#jstree").jstree("open_all");

  //$("#jstree li").on("click", "a", 
    //    function() {
    //        document.location.href = this;
    //    }
    //);
});
</script>








  <!-- /.content-wrapper -->


