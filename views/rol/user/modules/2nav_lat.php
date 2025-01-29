<!-- Nav lateral -->
<section class="full-box nav-lateral">
	<div class="full-box nav-lateral-bg show-nav-lateral"></div>
	<div class="full-box nav-lateral-content">
		<figure class="full-box nav-lateral-avatar">
			<i class="far fa-times-circle show-nav-lateral"></i>
			<img src="assets/plantilla/dashboard/assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
			<figcaption class="roboto-medium text-center">

<span class="text-white roboto-medium">
    <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?> <br>
    <small class="roboto-condensed-light">
        Rol: <?= ['1' => 'Super Admin', '2' => 'Admin', '3' => 'Seller', '4' => 'Usuario'][$_SESSION['user_rol'] ?? 0] ?? 'Desconocido' ?>
    </small>
</span>


			</figcaption>
		</figure>
		<div class="full-box nav-lateral-bar"></div>
		<nav class="full-box nav-lateral-menu">
			<ul>
				<li>
					<a href="?c=ProfileController&a=main"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Mi Perfil</a>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-users fa-fw"></i> &nbsp; Datos <i
							class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="?c=ProfileController&a=main"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ver mis datos</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-box fa-fw"></i> &nbsp; Compras <i
							class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="?c=ProductController&a=main"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ver mis compras</a>
						</li>
					</ul>
				</li>


			</ul>
		</nav>
	</div>
</section>