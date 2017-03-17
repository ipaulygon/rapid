<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title></title>
	</head>
	<body>
	<style type="text/css">

		.img-left {

			float: left;
		}
		.img-right {

			float: right;
		}

		/*h4 {

			float: right;
			margin-left: 200px;
		}*/
		
		.td {
			border: 1px solid black;
		}
		tr:nth-child(even) {background-color: #f2f2f2}
		th {
		background-color: black/*#4CAF50*/;
		color: yellow;
		border: 1px solid white
		}
	</style>
		<table width="100%">
			<tr height="10%">
				<td width="15%">
				<!--<img class="img-left" src="pics/logo.png" style="max-width: 90px;">-->
				</td>
				<td width="70%">
					<br>
					<p>
			
						<span style="font-size:20px;font-family:helvetica;"><center>Rapide Auto Service Experts<br><span style="font-size: 12px">Golden Point Auto Care</span></center></span>
					</p>
				</td>
				<td width="15%">
					<!-- <img src="assets/images/systemlogo.png" style="max-width: 90px;"> -->
				</td>
			</tr>
		</table>
		<center><h3>DELIVERY</h3></center>
		<?php
			$total = 0;
			$created = new DateTime($delivery->created_at);
			$created = $created->format("F d, Y");
		?>
		<table width="100%">
			<tr height="10%">
				<td width="20%">
					No. {{$delivery->deliveryHId}}
				</td>
				<td width="55%">
					
				</td>
				<td width="25%">
					{{$created}}
				</td>
			</tr>
		</table>
		<h4>Supplier: {{$delivery->supplier->supplierName}}</h4>
		<table width="100%">
			<thead>
				<tr>
					<th class="td">Product</th>
					<th class="td">Description</th>
					<th class="td">Received</th>
				</tr>
			</thead>
			<tbody>
				@foreach($delivery->detail as $prods)
					<tr>
						<td class="td">{{$prods->variance->product->brand->brandName}} - {{$prods->variance->product->productName}}| {{$prods->variance->variance->varianceSize}} - {{$prods->variance->variance->unit->unitName}}| {{$prods->variance->product->types->typeName}}</td>
						<td class="td">{{$prods->deliveryDRemarks}}</td>
						<td style="text-align: right" class="td">{{$prods->deliveryDQty}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</body>  
</html>