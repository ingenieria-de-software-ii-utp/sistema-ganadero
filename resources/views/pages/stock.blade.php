@extends('master')
@section('content')
<style media="screen">
.info th
{
  text-align: center;
  vertical-align: middle !important;
}
</style>
<div class="row">

  <div class="col-md-12">
    <h1><strong>Inventario de ganado</strong></h1>
    <hr class="colorgraph-01"><br>
    <div class="container">
      <div class="col-md-4">
        <form class="form-group has-feedback">
          <input type="text" id="buscar" class="form-control" placeholder="Buscar inventario por...">
          <i class="glyphicon glyphicon-search form-control-feedback"></i>
        </form>
      </div>
      <div class="col-md-4">
        <a href="/create"><button type="submit" class="btn btn-success"><strong>Agregar</strong> &nbsp;&nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button></a>
      </div>
    </div>
    <table class="table table-bordered table-responsive" id="tabla">
      <tr class="info">
        <th>ID</th>
        <th>Tipo de ganado</th>
        <th>Raza</th>
        <th>Código</th>
        <th>Color</th>
        <th>Sexo</th>
        <th>Código del padre</th>
        <th>Código de la madre</th>
        <th>Fecha de nacimiento</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Modificar</th>
        <th>Eliminar</th>
      </tr>
      <?php
      $stock = DB::table('inventario_ganado')->paginate(6);
      $tiposDeGanado = DB::table('tipos_ganados')->get();
      $razas = DB::table('tipos_razas')->get();
      $estados = DB::table('status')->get();
      ?>
      @foreach($stock as $stocks)
      <tr>
        <td>{{$stocks->idinventario_ganado}}</td>
        @foreach($tiposDeGanado as $tipo)
        <?php if($stocks->tipos_ganados_idtipos_ganados == $tipo->idtipos_ganados) echo '<td>', $tipo->tipo, '</td>'; ?>
        @endforeach
        @foreach($razas as $raza)
        <?php if($stocks->tipos_razas_idtipos_razas == $raza->idtipos_razas) echo '<td>', $raza->raza, '</td>'; ?>
        @endforeach
        <td>{{$stocks->cod_ganado}}</td>
        <td>{{$stocks->color}}</td>
        <td><?php echo ($stocks->sexo == "M" ? "Macho" : "Hembra"); ?></td>
        <td>{{$stocks->cod_padre}}</td>
        <td>{{$stocks->cod_madre}}</td>
        <td>{{$stocks->fecha_nacimiento}}</td>
        <td>{{$stocks->descripcion}}</td>
        @foreach($estados as $estado)
        <?php if($stocks->status_idstatus == $estado->idstatus) echo '<td>', $estado->status, '</td>'; ?>
        @endforeach
        <td><a class="btn btn-success" href="/modify?id={{$stocks->idinventario_ganado}}">Modificar</a></td>
        <td><a class="btn btn-danger" href="/delete?id={{$stocks->idinventario_ganado}}">Eliminar</a></td>
        @endforeach
      </table>
      <?php echo $stock->render(); ?>
    </div>
  </div>

  @endsection
  @section('footer')
  <script type="text/javascript">
  $(document).ready(function()
  {
    $('#buscar').keyup(function()
    {
      searchTable($(this).val());
    });
  });

  function searchTable(inputVal)
  {
    var table = $('#tabla');
    table.find('tr').each(function(index, row)
    {
      var allCells = $(row).find('td');
      if(allCells.length > 0)
      {
        var found = false;
        allCells.each(function(index, td)
        {
          var regExp = new RegExp(inputVal, 'i');
          if(regExp.test($(td).text()))
          {
            found = true;
            return false;
          }
        });
        if(found == true)$(row).show();else $(row).hide();
      }
    });
  }
  </script>
  @endsection
