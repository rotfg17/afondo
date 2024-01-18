<?php

require '../config/config.php';
require '../../php/database.php';
?>

<style>
        .container-fluid {
            padding: 20px;
        }

        .card-autor {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: #f8f9fa; /* Color de fondo */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .head {
            margin-top: 20px;
        }

        .head img {
            border-radius: 50%; /* Forma la imagen en un círculo */
            margin-bottom: 10px;
        }

        h2 {
            color: #007bff; /* Color del encabezado */
            margin-bottom: 5px;
        }

        h4 {
            color: #6c757d; /* Color del subencabezado */
            margin-bottom: 20px;
        }

        .descripcion {
            padding: 20px;
        }

        p {
            color: #495057; /* Color del texto principal */
            font-size: 16px;
            line-height: 1.6;
        }

        .social {
            margin-top: 15px;
        }

        .social a {
            margin-right: 10px;
            color: #007bff; /* Color de los íconos sociales */
            text-decoration: none;
            font-size: 24px;
        }

        /* Puedes añadir más estilos según tus preferencias */
    </style>

<?php require '../header.php'; ?>

<div class="container-fluid px-4">
    <div class="card-autor">
        <div class="head">
            <a href="">
                <img src="../img/autor.jpeg" alt="Foto del autor" width="150px" height="180px">
            </a>
            <h2>Andreina Chalas</h2>
            <h4>Periodista, Locutora y Relacionista Público.</h4>
        </div>
        <div class="descripcion">
            <p>Periodista egresada de la Universidad Autónoma de Santo Domingo (UASD), con un postgrado en Relaciones Pùblicas. Locutora, productora y presentadora de TV.</p>
            <div class="social">
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-instagram'></i></a>
            </div>
        </div>
    </div>
</div>


<script src="../js/scripts.js"></script>
    
<?php include '../footer.php'?>