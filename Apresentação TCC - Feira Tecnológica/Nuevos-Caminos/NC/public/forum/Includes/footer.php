<style>
/* Estilos principais do footer */
.footer {
    background-color: #212529; /* Fundo preto elegante */
    color: #f5f5f5; /* Texto em cinza claro */
    padding: 40px 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fonte mais elegante */
    text-align: center;
    letter-spacing: 0.5px;
}

.footer .footer-heading {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 2px solid #fff; /* Linha sutil abaixo dos títulos */
    padding-bottom: 5px;
}

.footer p {
    font-size: 15px;
    line-height: 1.6;
    color: #ccc;
    margin-bottom: 20px;
}

.footer .footer-links {
    list-style: none;
    padding-left: 0;
}

.footer .footer-links li {
    margin-bottom: 12px;
}

.footer .footer-links a {
    text-decoration: none;
    color: #bbb; /* Links em tom suave de cinza */
    font-size: 16px;
    transition: color 0.3s ease, padding-left 0.3s ease;
}

.footer .footer-links a:hover {
    color: #fff; /* Destaque para links */
    padding-left: 5px; /* Efeito de deslocamento ao passar o mouse */
}

.footer .social-icons {
    display: flex;
    justify-content: center; /* Centraliza os ícones sociais */
    gap: 18px;
    margin-top: 15px;
}

.footer .social-icon {
    color: #bbb;
    font-size: 22px;
    transition: color 0.3s ease, transform 0.3s ease;
}

.footer .social-icon:hover {
    color: #fff;
    transform: scale(1.1); /* Leve aumento de tamanho no hover */
}

.footer-divider {
    border-color: #fff;
    margin-top: 40px;
    width: 60%;
    margin-left: auto;
    margin-right: auto;
}

.footer .footer-copyright {
    font-size: 14px;
    color: #bbb;
    margin-top: 20px;
}

/* Estilos para os alinhamentos das colunas */
.footer-left, .footer-center, .footer-right {
    margin-bottom: 30px;
}

/* Responsividade */
@media (max-width: 768px) {
    .footer {
        padding: 30px 15px;
    }
    .footer .footer-heading {
        font-size: 18px;
    }
    .footer p {
        font-size: 14px;
    }
    .footer .footer-links a {
        font-size: 14px;
    }
    .footer .social-icon {
        font-size: 18px;
    }
}

@media (min-width: 1571px) {
    .footer .footer-center {
        text-align: center;
    }
    .footer .footer-left,
    .footer .footer-right {
        text-align: right;
    }
}



</style>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Sección Izquierda: Información sobre el sitio -->
            <div class="col-md-4 footer-left">
                <h5 class="footer-heading">Sobre el sitio</h5>
                <p>Espacio para que los inmigrantes compartan experiencias, resuelvan dudas y discutan temas como vivienda y empleo.</p>
            </div>
            
            <!-- Sección Central: Enlaces rápidos -->
            <div class="col-md-4 footer-center">
                <h5 class="footer-heading">Enlaces rápidos</h5>
                <ul class="footer-links">
                    <li><a href="../../index.php">Página de inicio</a></li>
                    <li><a href="../sobre.php">Sobre nosotros</a></li>
                    <li><a href="mailto:nuevoscaminos02@gmail.com?">Contacto</a></li>
                    <li><a href="./Politica.php">Política de privacidad</a></li>
                </ul>
            </div>
            
            <!-- Sección Derecha: Redes sociales -->
            <div class="col-md-4 footer-right">
                <h5 class="footer-heading">Síguenos</h5>
                <div class="social-icons">
                    <a href="https://x.com/Nuevos_Caminos0" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/tcc_nuevoscaminos/" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <!-- Sección de Derechos de Autor -->
        <div class="row text-center">
            <div class="col">
                <p class="footer-copyright">© 2024 Nuevos Caminos. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</footer>

