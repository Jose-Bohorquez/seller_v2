
		<!-- Page content -->
		<section class="full-box page-content">
			<nav class="full-box navbar-info">
				<a href="#" class="float-left show-nav-lateral">
					<i class="fas fa-exchange-alt"></i>
				</a>
				<a href="index.php?c=AuthController&a=logout">
					<i class="fas fa-power-off"></i>
				</a>
			</nav>

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-user-cog"></i> &nbsp; Editar Perfil
				</h3>
				<p class="text-justify">
					Actualiza tu información personal.
				</p>
			</div>

			<!-- Formulario de edición -->
			<div class="container-fluid">
				<div class="card mx-auto" style="max-width: 800px;">
					<div class="card-header bg-primary text-white text-center">
						<h4 class="mb-0">Información Personal</h4>
					</div>
					<div class="card-body">
						<form action="index.php?c=ProfileController&a=updateProfile" method="POST" class="form-neon">
							<input type="hidden" name="id_user" value="<?= htmlspecialchars($user->getIdUser() ?? '') ?>">

							<div class="form-group">
								<label for="name" class="bmd-label-floating">Nombre</label>
								<input type="text" id="name" name="name" class="form-control" 
									   value="<?= htmlspecialchars($user->getName() ?? '') ?>" required>
							</div>

							<div class="form-group">
								<label for="lastname" class="bmd-label-floating">Apellidos</label>
								<input type="text" id="lastname" name="lastname" class="form-control" 
									   value="<?= htmlspecialchars($user->getLastname() ?? '') ?>" required>
							</div>

							<div class="form-group">
								<label for="id_number" class="bmd-label-floating">Número de Identificación</label>
								<input type="text" id="id_number" name="id_number" class="form-control" 
									   value="<?= htmlspecialchars($user->getIdNumber() ?? '') ?>" required>
							</div>

							<div class="form-group">
								<label for="cel" class="bmd-label-floating">Teléfono</label>
								<input type="text" id="cel" name="cel" class="form-control" 
									   value="<?= htmlspecialchars($user->getCel() ?? '') ?>">
							</div>

							<div class="form-group">
								<label for="email" class="bmd-label-floating">Correo Electrónico</label>
								<input type="email" id="email" name="email" class="form-control" 
									   value="<?= htmlspecialchars($user->getEmail() ?? '') ?>" required>
							</div>

							<div class="form-group">
								<label for="image_profile" class="bmd-label-floating">Imagen de Perfil (URL)</label>
								<input type="text" id="image_profile" name="image_profile" class="form-control" 
									   value="<?= htmlspecialchars($user->getImageProfile() ?? '') ?>">
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-raised btn-info btn-sm">
									<i class="fas fa-save"></i> Guardar Cambios
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
        <br>
        <br>
        <br>
        <br>