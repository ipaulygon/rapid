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
			border-bottom: 1px solid #ddd;
		}
		tr:nth-child(even) {background-color: #f2f2f2}
		th {
		background-color: #4CAF50;
		color: white;
		border: 1px solid black
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
		<center><h3>PURCHASE ORDER</h3></center>
		<?php
			$total = 0;
			$created = new DateTime($order[0]->created_at);
			$created = $created->format("F d, Y");
		?>
		<table width="100%">
			<tr height="10%">
				<td width="15%">
					No. {{$order[0]->purchaseHId}}
				</td>
				<td width="60%">
					
				</td>
				<td width="25%">
					{{$created}}
				</td>
			</tr>
		</table>
		<h4>Supplier: {{$order[0]->supplier->supplierName}}</h4>
		<p>Description: {{$order[0]->purchaseHDesc}}</p>
		<table width="100%">
			<thead>
				<tr>
					<th class="td">Quantity</th>
					<th class="td">Product</th>
					<th class="td">Description</th>
					<th class="td">Unit Price(PhP)</th>
					<th class="td">Total Cost(PhP)</th>
				</tr>
			</thead>
			<tbody>
				@foreach($order[0]->detail as $prods)
					<tr>
						<td class="td">{{$prods->purchaseDQty}}</td>
						<td class="td">{{$prods->variance->product->brand->brandName}} - {{$prods->variance->product->productName}}| {{$prods->variance->variance->varianceSize}} - {{$prods->variance->variance->unit->unitName}}| {{$prods->variance->product->types->typeName}}</td>
						<td class="td">{{$prods->purchaseDRemarks}}</td>
						<td class="td">{{$prods->variance->pvCost}}</td>
						<?php
							$totalCost = $prods->variance->pvCost*$prods->purchaseDQty;
							$total += $totalCost;
						?>
						<td class="td">{{$totalCost}}</td>
					</tr>
				@endforeach
				<?php 
					$price = number_format($total,2);
				?>
				<tr>
					<td class="td"><span style="font-weight: bold">Total Cost:</span></td>
					<td class="td"></td>
					<td class="td"></td>
					<td class="td"></td>
					<td class="td"><span style="font-weight: bold">{{$price}}</span></td>
				</tr>
			</tbody>
		</table>
	</body>  
</html>