<!-- Left Panel -->
    <?php
        
        require_once (__DIR__ . "/classes/User.php");
        session_start();

    ?>
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php"> <i class="menu-icon fa fa-dashboard"></i>Meus materiais</a>
                    </li>
                    <li>
                        <a href="new_material.php"> <i class="menu-icon fa fa-plus-circle"></i>Novo material</a>
                    </li>
                    <li>
                        <a href="shared_materials.php"> <i class="menu-icon fa fa-share-alt-square "></i>Compartilhados comigo</a>
                    </li>
                    <?php if(isset($_SESSION['logged']) && $_SESSION['user']->getRole() == "admin"){ ?>
                        <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Usuários</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-puzzle-piece"></i><a href="new_user.php">Adicionar</a></li>
                                <li><i class="fa fa-list-ol"></i><a href="list_users.php">Listar</a></li>
                            </ul>
                        </li>
                    <?php } ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </aside>