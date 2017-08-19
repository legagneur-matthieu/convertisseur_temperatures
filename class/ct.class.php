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
            <div class="col-xs-2"> </div>
            <div class="col-xs-4">
                <?php
                form::new_form();
                form::input("Température", "t", "text", "0", false);
                form::select("Unité à convertir", "from", [
                        ["K", "Kelvin (°K)"],
                        ["C", "Celsius (°C)"],
                        ["F", "Fahrenheit (°F)"],
                        ["B", "Benamran (°B)"],
                ]);
                form::submit("btn-default", "Calculer");
                form::close_form();
                ?>
            </div>
            <div class="col-xs-1"> </div>
            <div class="col-xs-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p>Resultats</p>
                    </div>
                    <div class="panel-body">
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
            <div class="col-xs-2"> </div>
        </div>
        <?php
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                function convert() {
                    $.post("./services/index.php", {service: "s_ct", t: $("#t").val(), from: $("#from").val()}, function (data) {
                        $.each(data, function (k, v) {
                            $("#result>#" + k).text(v);
                        });
                    }, "json");
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
            <div class="col-xs-6">
                <p>
                    Le degré Benamran a été inventé à titre d'exemple humoristique par Bruce Benamran dans une vidéo sur sa chaine Youtube "e-penser".
                    Vidéo qui avais pour thèmes les échelles de températures.<br />
                    Il définit le zéro de son échelle de température comme étant la température de son frigo à un moment T (4.2°C) et 
                    définit la température haute de son échelle comme étant la température d'ébullition du mercure (356.7°C). <br />
                    Il gradue son échelle en 17 subdivisions elles-mêmes divisé en 11 subdivisions,<br />
                    <em>"parce que oui, j'aime les nombres premiers"</em> a-t-il déclaré.<br />
                    Ainsi le degré Benamran se définit tel que 0 °B. = 4.2 °C et 187 °B. = 356.7 °C <br />
                    soit : °C = 1.8850267379679144 * °B + 4.2 <br />
                    ou : °B = (°C - 4.2) / 1.8850267379679144
                </p>
            </div>
            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p>Details des calculs pour trouver la constante "1.8850267379679144"</p>
                    </div>
                    <div class="panel-body">                        
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
        <div class="center-block" style="width: 600px;">
            <p class="text-center">Source : <strong>Le Kelvin, c'est chaud - SI - 04 | e-penser (Bruce Benamran)</strong></p>
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
        <div class="panel panel-default">
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt>URL :</dt>
                    <dd>
                        <p><?php echo $url = "http://" . $_SERVER["SERVER_NAME"] . strtr($_SERVER["SCRIPT_NAME"], ["index.php" => "services/index.php"]); ?></p>
                    </dd>
                    <dt>Methodes : </dt>
                    <dd>
                        <p>GET et POST sont tout deux supporté</p>
                    </dd>
                    <dt>Paramètres :</dt>
                    <dd>
                        <?=
                        html_structures::table(["Clé", "Description", "Valeur"], [
                                ["service", "Nom du service", '"s_ct"'],
                                ["t", "Température à convertir", "<em>Nombre entier ou décimal</em>"],
                                ["from", "Unité de la temperature à convertir", '"K", "C", "F" ou "B"'],
                        ]);
                        ?>
                    </dd>
                    <dt>Resultat en retour (JSON) :</dt>
                    <dd>
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
                        '    {service: "s_ct", t: 37, from: C},' . "\n" .
                        '    function (data) {' . "\n" .
                        '        //use data' . "\n" .
                        '    }, "json");')
                ?>
                <p>JQuery (GET)</p>
                <?=
                js::syntaxhighlighter('$.get("' . $url . '",' . "\n" .
                        '    {service: "s_ct", t: 37, from: C},' . "\n" .
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
        <p class="text-center">Le degré Benamran vous a faire sourir ? vous voulez essayer avec d'autres valeurs ? allez-y ! <br />
            <small>pour les calculs, votre échelle portera le nom "Own" et est noté °OWN</small></p>
        <?php form::new_form(); ?>
        <div class="row">
            <div class="col-xs-6">
                <?php
                form::new_fieldset("1 - Definisez votre échelle");
                form::input("Le zéro de votre échelle en °C", "c", "text", "0");
                form::input("La valeur haute de votre échelle en °OWN", "own", "text", "100");
                form::input("La valeur haute de votre échelle en °C", "cown", "text", "100");
                form::close_fieldset();
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p>Equations de votre echelle :</p>
                    </div>
                    <div class="panel-body">
                        <p>°C = <span class="x"></span> * °OWN + (<span class="zero"></span>)<br />
                            °OWN = (°C - (<span class="zero"></span>)) / <span class="x"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <?php
                form::new_fieldset("2 - Testez votre échelle");
                form::input("Température", "t", "text", "0", false);
                form::select("Unité à convertir", "from", [
                        ["OWN", "Own (°OWN)"],
                        ["K", "Kelvin (°K)"],
                        ["C", "Celsius (°C)"],
                        ["F", "Fahrenheit (°F)"],
                        ["B", "Benamran (°B)"],
                ]);
                form::close_fieldset();
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p>Resultats</p>
                    </div>
                    <div class="panel-body">
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
        form::close_form();
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("form").css("width", "100%");
                function cown() {
                    own = parseFloat($("#own").val());
                    c = parseFloat($("#c").val());
                    x = parseFloat(1 / (own / ($("#cown").val() - c)));
                    $(".x").text(x);
                    $(".zero").text(c);
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

}
