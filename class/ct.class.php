<?php

/**
 * Classe métier ct
 *
 * @author LEGAGNEUR Matthieu <legagneur.matthieu@gmail.com> 
 */
class ct {

    public function convertisseur() {
        ?>
        <h1 class="text-center">Convertisseur</h1>
        <div class="row">
            <div class="col-sm-2"> </div>
            <div class="col-sm-4">
                <?php
                $form = new form();
                $form->input("Température", "t", "text", "0", false);
                $form->select("Unité à convertir", "from", [
                    ["K", "Kelvin (°K)"],
                    ["C", "Celsius (°C)"],
                    ["F", "Fahrenheit (°F)"],
                    ["B", "Benamran (°B)"],
                ]);
                $form->submit("btn-default", "Calculer");
                echo $form->render();
                ?>
            </div>
            <div class="col-sm-1"> </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <p>Resultats</p>
                    </div>
                    <div class="card-body">
                        <p id="result">
                            <span id="K"></span> °K
                            <br />
                            <span id="C"></span> °C
                            <br />
                            <span id="F"></span> °F
                            <br />
                            <span id="B"></span> °B
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"> </div>
        </div>
        <?php
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                function convert() {
                    t = parseFloat($("#t").val());
                    switch ($("#from").val()) {
                        case "K":
                            t -= 273.16;
                            break;
                        case "F":
                            t = (t - 32) / 1.8;
                            break;
                        case "B":
                            t = 1.8850267379679144 * t + 4.2;
                            break;
                    }
                    $("#K").text(t + 273.16);
                    $("#C").text(t);
                    $("#F").text(t * 1.8 + 32);
                    $("#B").text((t - 4.2) / 1.8850267379679144);
        //                    $.post("./services/index.php", {service: "s_ct", t: $("#t").val(), from: $("#from").val()}, function (data) {
        //                        $.each(data, function (k, v) {
        //                            $("#result>#" + k).text(v);
        //                        });
        //                    }, "json");
                }
                $("#t, #from").change(function () {
                    convert();
                });
                $("form").submit(function (e) {
                    e.preventDefault();
                });
                convert();
            });
        </script>
        <?php
    }

    public function definition() {
        ?>
        <h1 class="text-center">Precisions sur le degré Benamran</h1>
        <div class="row">
            <div class="col-sm-6">
                <p>
                    Le degré Benamran a été inventé à titre d'exemple humoristique par Bruce Benamran dans une vidéo sur sa chaine Youtube "e-penser".
                    Vidéo qui avais pour thème les échelles de températures.<br />
                    Il définit le zéro de son échelle de température comme étant la température de son frigo à un moment T (4.2°C) et 
                    définit la température haute de son échelle comme étant la température d'ébullition du mercure (356.7°C). <br />
                    Il gradue son échelle en 17 subdivisions elles-mêmes divisé en 11 subdivisions,<br />
                    <em>"parce que oui, j'aime les nombres premiers"</em> a-t-il déclaré.<br />
                    Ainsi le degré Benamran se définit tel que 0 °B. = 4.2 °C et 187 °B. = 356.7 °C <br />
                    soit : °C = 1.8850267379679144 * °B + 4.2 <br />
                    ou : °B = (°C - 4.2) / 1.8850267379679144
                </p>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <p>Details des calculs pour trouver la constante "1.8850267379679144"</p>
                    </div>
                    <div class="card-body">                        
                        <p>
                            °C = X * °B + 4.2 <br />
                            X = 1 / (°B / (°C - 4.2)) <br />
                            X = 1 / (187 / (356.7 - 4.2)) <br />
                            X = 1.8850267379679144
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 600px; margin: 0 auto">
            <p class="text-center">Source : <strong><?= html_structures::a_link("https://www.youtube.com/watch?v=OqcqsUaEqUk", "Le Kelvin, c'est chaud - SI - 04 | e-penser (Bruce Benamran)", "", "YouTube, lien externe", true); ?></strong></p>
            <iframe width="600" height="340" src="https://www.youtube.com/embed/OqcqsUaEqUk" frameborder="0" allowfullscreen></iframe>
        </div>
        <?php
    }

    public function api() {
        ?>
        <style type="text/css">
            .dl-horizontal dt {
                width: 200px;
            }
            .dl-horizontal dd {
                margin-left: 210px;
            }
        </style>
        <h1 class="text-center">API</h1>
        <p class="text-center">Vous désirez utiliser l'API de ce convertisseur dans un projet ? c'est simple, efficace, libre et gratuit !</p>
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-2">URL :</dt>
                    <dd class="col-sm-10">
                        <p><?php echo $url = "http://" . $_SERVER["SERVER_NAME"] . strtr($_SERVER["SCRIPT_NAME"], ["index.php" => "services/index.php"]); ?></p>
                    </dd>
                    <dt class="col-sm-2">Methodes : </dt>
                    <dd class="col-sm-10">
                        <p>GET et POST sont tout deux supporté</p>
                    </dd>
                    <dt class="col-sm-2">Paramètres :</dt>
                    <dd class="col-sm-10">
                        <?=
                        html_structures::table(["Clé", "Description", "Valeur"], [
                            ["service", "Nom du service", '"s_ct"'],
                            ["t", "Température à convertir", "<em>Nombre entier ou décimal</em>"],
                            ["from", "Unité de la temperature à convertir", '"K", "C", "F" ou "B"'],
                        ]);
                        ?>
                    </dd>
                    <dt class="col-sm-2">Resultat (JSON) :</dt>
                    <dd class="col-sm-10">
                        <p>{"C":0,"K":273.16,"F":32,"B":-2.2280851063805}</p>
                    </dd>
                </dl>
                <h2 class="text-center">Exemple d'utilisation</h2>
                <p>GET, URL directe : <br />
                    <?= html_structures::a_link($url . ($param = "?service=s_ct&t=37&from=C"), $url . $param, "", "", true); ?>
                </p>
                <p>JQuery (POST)</p>
                <?=
                js::syntaxhighlighter('$.post("' . $url . '",' . "\n" .
                        '    {service: "s_ct", t: 37, from: "C"},' . "\n" .
                        '    function (data) {' . "\n" .
                        '        //use data' . "\n" .
                        '    }, "json");')
                ?>
                <p>JQuery (GET)</p>
                <?=
                js::syntaxhighlighter('$.get("' . $url . '",' . "\n" .
                        '    {service: "s_ct", t: 37, from: "C"},' . "\n" .
                        '    function (data) {' . "\n" .
                        '        //use data' . "\n" .
                        '    }, "json");')
                ?>
            </div>
        </div>
        <?php
    }

    public function your_own() {
        ?>
        <h1 class="text-center">Créez votre échelle de température</h1>
        <p class="text-center">Le degré Benamran vous a fait sourir ? vous voulez essayer avec d'autres valeurs ? allez-y ! <br />
            <small>pour les calculs, votre échelle portera le nom "Own" et est noté °OWN</small></p>
        <?php
        $form = new form();
        echo $form->get_open_form();
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $form->open_fieldset("1 - Definisez votre échelle") .
                $form->input("Le zéro de votre échelle en °C", "c", "text", "0") .
                $form->input("La valeur haute de votre échelle en °OWN", "own", "text", "100") .
                $form->input("La valeur haute de votre échelle en °C", "cown", "text", "100") .
                $form->close_fieldset();
                ?>
                <div class="card">
                    <div class="card-header">
                        <p>Equations de votre echelle :</p>
                    </div>
                    <div class="card-body">
                        <p>°C = <span class="x">0</span> * °OWN + (<span class="zero">0</span>)<br />
                            °OWN = (°C - (<span class="zero">0</span>)) / <span class="x">0</span></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php
                echo $form->open_fieldset("2 - Testez votre échelle") .
                $form->input("Température", "t", "text", "0", false) .
                $form->select("Unité à convertir", "from", [
                    ["OWN", "Own (°OWN)"],
                    ["K", "Kelvin (°K)"],
                    ["C", "Celsius (°C)"],
                    ["F", "Fahrenheit (°F)"],
                    ["B", "Benamran (°B)"],
                ]) .
                $form->close_fieldset();
                ?>
                <div class="card">
                    <div class="card-header">
                        <p>Resultats</p>
                    </div>
                    <div class="card-body">
                        <p id="result">
                            <span id="r_own"></span> °OWN
                            <br />
                            <span id="r_k"></span> °K
                            <br />
                            <span id="r_c"></span> °C
                            <br />
                            <span id="r_f"></span> °F
                            <br />
                            <span id="r_b"></span> °B
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo $form->get_close_form();
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("form").css("width", "100%");
                function cown() {
                    own = parseFloat($("#own").val());
                    c = parseFloat($("#c").val());
                    x = parseFloat(1 / (own / ($("#cown").val() - c)));
                    $(".x").text(x.toString());
                    $(".zero").text(c.toString());
                    t = parseFloat($("#t").val());
                    switch ($("#from").val()) {
                        case "OWN":
                            t = x * t + c;
                            break;
                        case "K":
                            t -= 273.16;
                            break;
                        case "F":
                            t = (t - 32) / 1.8;
                            break;
                        case "B":
                            t = 1.8850267379679144 * t + 4.2;
                            break;
                    }
                    $("#r_own").text((t - c) / x);
                    $("#r_k").text(t + 273.16);
                    $("#r_c").text(t);
                    $("#r_f").text(t * 1.8 + 32);
                    $("#r_b").text((t - 4.2) / 1.8850267379679144);
                }
                $("form").submit(function (e) {
                    e.preventDefault();
                    cown();
                });
                $("form input, form select").change(function () {
                    cown();
                });
                cown();
            });
        </script>
        <?php
    }

    public function apk() {
        ?>
        <h2>Le convertisseur de températures sur mobile</h2>
        <p>
            Le convertisseur est disponible sur android ! <br />
            Développé avec <?= html_structures::a_link("https://cordova.apache.org/", "Cordova", "", "Cordova, lien externe", true); ?>
            sous <?= html_structures::a_link("https://www.gnu.org/licenses/gpl-3.0.fr.html", "licence GNU/GPL v3", "", "licence GNU/GPL v3, lien externe", true); ?>
        </p>
        <?=
        html_structures::ul([
            html_structures::a_link("apk/convertisseur_temperatures.apk", "Télécharger .APK"),
            html_structures::a_link("https://github.com/legagneur-matthieu/cdv_convertisseur_temperatures/", "GitHub", "", "Convertisseur de temperatures, lien externe Github", true)
        ]);
        ?>
        <div class="alert alert-warning">
            <p>Cette application mobile n'est pas une application officielle, <br />
                votre appareil mobile (ou son antivirus) est donc susceptible de vous afficher des alertes de sécurité. 
            </p>
            <p>
                Il s'agit d'un faux positif.
            </p>
            <p>                
                <strong>Cependant</strong>, si vous avez un doute ( ce qui est légitime), l'auteur vous invite à suivre la procédure suivante :
            </p>
            <?=
            html_structures::ol([
                html_structures::a_link("https://github.com/legagneur-matthieu/cdv_convertisseur_temperatures/", "Téléchargez le projet sur Github", "", "lien externe Github", true),
                "Vérifiez par vous même le code",
                html_structures::a_link("https://cordova.apache.org/docs/fr/latest/guide/cli/index.html", "Compilez le projet avec Cordova", "", "", true),
                "Installez l'APK que vous avez compilé sur votre appareil"
            ]);
            ?>
            <p>L'application sera disponible sur le Google Play Store dans un proche avenir !</p>
        </div>
        <?php
    }

}
