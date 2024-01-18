
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="<?php echo ADMIN_URL;?>css/styles.css" rel="stylesheet">
    <title>Dashboard - A Fondo</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../img/logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">A Fondo</span>
                    <span class="profession">Con Andreina</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo ADMIN_URL;?>entradas">
                            <i class='bx bx-news icon'></i>
                            <span class="text nav-text">Entradas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo ADMIN_URL;?>relevantes">
                        <i class='bx bx-notepad icon'></i>
                            <span class="text nav-text">Relevantes</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo ADMIN_URL;?>categorias">
                        <i class='bx bx-category-alt icon'></i>
                            <span class="text nav-text">Categorías</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo ADMIN_URL;?>miniaturas">
                        <i class='bx bx-image-alt icon'></i>
                            <span class="text nav-text">Miniaturas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='bx bx-slideshow icon'></i>
                            <span class="text nav-text">Publicidad</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='bx bx-chat icon'></i>
                            <span class="text nav-text">Comentarios</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo ADMIN_URL;?>autor">
                            <i class='bx bx-user-circle icon'></i>
                            <span class="text nav-text">Autor</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Cerrar sesión</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>
    </nav>
    
    <script src="js/scripts.js"></script>
</body>
</html>