<?php

/** * Cette classe sert de "Vue" à votre application, * vous pouvez y développer votre application comme bon vous semble : * HTML, créér et appeler une fonction "private" dans une fonction "public", faire appel à des classes exterieures ... * @author LEGAGNEUR Matthieu <legagneur.matthieu@gmail.com> */
class pages { /** * Cette classe sert de "Vue" à votre application, * vous pouvez y développer votre application comme bon vous semble : * HTML, créé et appelle une fonction "private" dans une fonction "public", faire appel à des classes exterieures ... */

    private $_ct;

    public function __construct() {
        new robotstxt();
        $this->_ct = new ct();
    }

    /**     * Entete des pages */
    public function header() {
        ?> 
        <script type="text/javascript">
            $(document).ready(function () {
                $("header").css("background", "linear-gradient(to right, red, orange, yellow, yellowgreen, green, blue, indigo, violet)");
                $("header small").css("text-shadow", "0 0 15px black");
            }
            );
        </script>
        <header class="page-header label-info">
            <h1>Convertisseur de températures <br /><small>Kelvin (°K), Celsius (°C), Fahrenheit (°F), Benamran (°B, humoristique)</small></h1> 
        </header>
        <?php
    }

    /**     * Pied des pages */
    public function footer() {
        ?> <footer> <hr /> <p> 2017-<?php echo date("Y"); ?> D&eacute;velopp&eacute; par <?= html_structures::a_link("../legagneur-matthieu/", "LEGAGNEUR Matthieu", "", "LEGAGNEUR Matthieu, lien externe", true) ?></p>
                <!--[if (IE 6)|(IE 7)]> <p><big>Ce site n'est pas compatible avec votre version d'internet explorer !</big></p> <![endif]--> 
        </footer> <?php
    }

    /**     * Fonction par défaut / page d'accueil */
    public function index() {
        $this->_ct->convertisseur();
        echo html_structures::hr();
        $this->_ct->definition();
    }

    public function api() {
        $this->_ct->api();
    }

    public function your_own() {
        $this->_ct->your_own();
    }

    public function apk() {
        $this->_ct->apk();
    }

}
