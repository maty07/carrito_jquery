<!DOCTYPE html>
<html>
<head>
	<title>Mi carrito</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

</head>
<body>

<div class="container mt-5">
	<div class="row">
		<div class="col-md-3">
			<div class="form-inline mb-3">
				<div class="d-flex justify-content-start">
					<select name="productos" id="productos" class="selectpicker" data-live-search="true" title="--Seleccione--" >
						<?php include_once('proceso.php'); ?>
							<?php while ($row = $query->fetch_array()):?>
							<option value="<?php echo $row['id'] ;?>"><?php echo $row['id'] ?> - <?php echo $row['name'];?></option>
						<?php endwhile; ?>
					</select>

					<input type="button" class="btn btn-outline-primary" name="boton" id="boton" value="Agregar">
				</div>
			</div>		
		</div>
	</div>
	<table class="table table-striped" id="tabla">
	<thead>
		<tr>
			<td>ID</td>
			<td>Nombre</td>
			<td>Precio</td>
			<td>Stock</td>
			<td>Cantidad</td>
			<td>Subtotal</td>
		</tr>
	</thead>
	<tbody id="proAgregados">
	</tbody>
</table>
<div class="text-right text-primary my-3">Total: <input type="number" value="0" id="total" readonly></div>
<div class="text-right">
	<button type="button" class="btn-sm btn-success" id="btnVenta">Realizar Venta</button>
</div>
<div class="venta">
	
</div>

</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>

<script>

$(function(){

	$('#boton').click(function(){
		carritoCompra();
	});

	function carritoCompra(){
		var sel = $('#productos').val();
		data = {"id": sel};
		$.ajax({
			url: "proceso2.php",
			data: data,
			type: "GET",
			dataType: "json"
		})
		.done(function(response){
			var txt = "<tr class='dato'>";
			$.each(response, function(index, producto){
				txt += "<td>" + producto.id + "</td>";
				txt += "<td>" + producto.name + "</td>";
				txt += "<td id='precio'>" + producto.price + "</td>";
				txt += "<td>" + producto.stock + "</td>";
				txt += "<td> <input type='number' id='cantidad'></td>";
				txt += "<td id='subTotal'><td>";
				txt += '<td><input type="button" class="btn-sm btn-danger" id="eliminar" value="Quitar"></td>';
			});
			txt += "</tr>";
			$('#proAgregados').append(txt);

				$('#proAgregados').on('click', '#eliminar' ,function(){
					$(this).parents('tr').remove();
					calcularTotal();
 
				});
				$('#proAgregados').on('input', '#cantidad', calcularSubTotal);
				$('#proAgregados').on('input', '#cantidad', calcularTotal);

		})
		.fail(function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR + textStatus + errorThrown)
		});
	}

	

	function calcularSubTotal(){	
		$('#tabla tbody tr').each(function(){
			var tr = $(this);
			var cantidad = parseInt(tr.find('#cantidad').val());
			
			var precio = parseInt(tr.find('#precio').text());
			var r = cantidad * precio;
			var subTotal = parseInt(tr.find('#subTotal').text(r));		
		});

	}

	function calcularTotal(){
		suma= 0;
		$('#tabla tbody tr').each(function(){
			var tr = $(this);
			suma += parseInt(tr.find('td').eq(5).text());		
		});
		$('#total').val(suma);
		
	}

	
}); //Fin document.ready

</script>