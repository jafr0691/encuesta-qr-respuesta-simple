<aside id="left-panel" class="left-panel">
	<nav class="navbar navbar-expand-sm navbar-default">

		<div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><h3 class="text-primary">BR<img src="img/logo2.png" alt="Logo" width="30px" height="30px">CKETS</h3></a>
                <a class="navbar-brand hidden" href="./"><img src="img/logo2.png" alt="Logo"></a>
            </div>

		<div id="main-menu" class="main-menu collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li>
					<a href="#"> <i class="menu-icon fa fa-list-ul"></i>Lista de Espera </a>
				</li>

				<li>
					<a href="#"> <i class="menu-icon fa fa-youtube-play"></i>Vista en sala de espera </a>
				</li>
				<li>
					<a href="#"> <i class="menu-icon fa fa-users"></i>Usuarios </a>
				</li>
				<li>
					<a href="index.php"> <i class="menu-icon fa fa-file-text-o"></i>Encuestas </a>
				</li>
				<h3 class="menu-title"></h3><!-- /.menu-title -->
				<li>
					<a href="#" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-sign-out"></i>Cerrar Sesion</a>
				</li>

			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>
</aside><!-- /#left-panel -->
<div id="right-panel" class="right-panel">

	<!-- Header-->
	<header id="header" class="header">

		<div class="header-menu">

			<div class="col-sm-7">
				<a id="menuToggle" class="menutoggle pull-left"><img src="img/logo2.png" alt="Logo" width="30px" height="30px"></a>
				<div class="header-left">
					<button class="search-trigger"><i class="fa fa-search"></i></button>
					<div class="form-inline">
						<form class="search-form">
							<input class="form-control mr-sm-2" type="text" placeholder="Buscar ..." aria-label="Buscar">
							<button class=" -close" type="submit"><i class="fa fa-close"></i></button>
						</form>
					</div>



					<div class="dropdown for-message">
						<button class="btn btn-secondary dropdown-toggle" type="button"
						id="message"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="ti-email"></i>
						<span class="count bg-primary">0</span>
					</button>
				</div>
			</div>
		</div>

		<div class="col-sm-5">
			<div class="user-area dropdown float-right">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="user-avatar rounded-circle" src="img/logo2.png" alt="User Avatar">
				</a>

				<div class="user-menu dropdown-menu">
					<a class="nav-link" href="#"><i class="fa fa-user"></i> My Profile</a>

					<a class="nav-link" href="#"><i class="fa fa-user"></i> Notifications <span class="count">13</span></a>

					<a class="nav-link" href="#"><i class="fa fa-cog"></i> Settings</a>

					<a class="nav-link" href="#"><i class="fa fa-power-off"></i> Logout</a>
				</div>
			</div>

			<div class="language-select dropdown" id="language-select">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
					<i class="flag-icon flag-icon-ve"></i>
				</a>
				<div class="dropdown-menu" aria-labelledby="language">
					<div class="dropdown-item">
						<span class="flag-icon flag-icon-fr"></span>
					</div>
					<div class="dropdown-item">
						<i class="flag-icon flag-icon-es"></i>
					</div>
					<div class="dropdown-item">
						<i class="flag-icon flag-icon-us"></i>
					</div>
					<div class="dropdown-item">
						<i class="flag-icon flag-icon-it"></i>
					</div>
				</div>
			</div>

		</div>
	</div>

</header><!-- /header -->
<!-- Header-->