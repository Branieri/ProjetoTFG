<!-- Top container -->
<div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
    <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
    <span class="w3-right">UNIFEI</span>
</div>

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
    <div class="w3-container w3-row w3-center">
        <div class="w3-col s8">
            <span>Welcome, <strong><?php echo $nome?></strong></span><br>
            <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
            <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Menu</h5>
    </div>
    <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="<?=base_url('homeadmin')?>" class="<?=($this->router->fetch_class() == 'Admin' && $this->router->fetch_method() == 'HomeAdmin') ? 'w3-padding w3-blue' : null; ?>"><i class="fa fa-home fa-fw"></i>  Home</a>
    <a href="<?=base_url('usuarios')?>" class="<?=($this->router->fetch_class() == 'Admin' && $this->router->fetch_method() == 'CadUsuario') ? 'w3-padding w3-blue' : null; ?>"><i class="fa fa-users fa-fw"></i>  Usuários</a>
    <a href="<?=base_url('cursos')?>" class="w3-padding"><i class="fa fa-book fa-fw"></i>  Cursos</a>
    <a href="<?=base_url()?>" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Configurações</a>
    <a href="<?=base_url('logout')?>" class="w3-padding"><i class="fa fa-remove fa-fw"></i>  Sair</a><br><br>
</nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>