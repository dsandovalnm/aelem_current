<?php 
	$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
?>
<section class="mis-compras-section">
	<div class="header-content">
		<h5 class="col-10 title text-center">Mis Compras Pendientes</h5>
	</div>
	<div class="search-box">
		<form id="mis-compras-search-form" class="form-inline">
			<div class="input-group">
					<input id="search-argument-pago" name="search-argument-pago" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
					<button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
			</div>
		</form>
	</div>
	<div class="mis-compras-container">
		<div class="tipos-mis-compras-container">
			<table class="table table-striped table-responsive-md">
					<thead class="thead-primary">
						<tr class="bg-info">
							<td>Artículo</td>
							<td>Precio</td>
							<td>Acciones</td>
						</tr>
					</thead>
					<tbody>
						<?php if(!is_null($cart) && count($cart) > 1) :
							$money = $cart['country'] === 'Argentina' ? 'ARS' : 'USD';
							var_dump($cart); ?>
								<tr>
									<td><?php echo $cart['name'] ?></td>
									<td><?php echo $cart['price'] . ' ' . $money ?></td>
									<td style="display: flex; justify-content: center;">
										<a href="/my_cart.php" class="btn" data-content="Continuar con la Compra" data-toggle="popover" data-trigger="hover" title="Continuar">
											<i class="far fa-hand-point-right icons-md icon-btn mx-2"></i>
										</a>
										<form action="/cart.php" method="post">
											<button style="padding: 5px" class="btn" type="submit" name="submit_form" id="submit_form" value="remove_course" data-content="Eliminar esta compra" data-toggle="popover" data-trigger="hover" title="Eliminar!">
												<i class="fas fa-times icons-md icon-btn mx-2"></i>
											</button>
										</form>
									</td>
								</tr>
						<?php else : ?>
							<tr>
									<td colspan="6">
										<p class="title">No hay compras pendientes</p>
									</td>
							</tr>
						<?php endif; ?>
					</tbody>
			</table>
		</div>
	</div>
</section>