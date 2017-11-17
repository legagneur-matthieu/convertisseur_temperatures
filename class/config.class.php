<?php

/** * Cette classe sert de fichier de configuration, <br /> * elle contient: * <ul> * <li>les variables de connexion à la base de données</li> * <li>l 'algo utilisé pour les hash</li> * <li>les routes de l 'aplication</li> * </ul> * * mais vous pouvez également y ajouter des variables diverses qui vous seront utile */
class config { /* PDO */

    public static $_PDO_type = "mysql";
    public static $_PDO_host = "localhost";
    public static $_PDO_dbname = "ct";
    public static $_PDO_login = "root";
    public static $_PDO_psw = ""; /* hash */
    public static $_hash_algo = "sha256"; /* routes */
    public static $_route_auth = array();
    public static $_route_unauth = array(); /* Data */
    public static $_title = "Convertisseur Temperatures";
    public static $_favicon = "";
    public static $_debug = true;
    public static $_prefix = "CT_KCFB";
    public static $_theme = "default";
    public static $_SMTP_host = "localhost";
    public static $_SMTP_auth = false;
    public static $_SMTP_login = "";
    public static $_SMTP_psw = "";
    public static $_sitemap = false;
    public static $_statistiques = false;

    public static function onbdd_connected() {
        self::$_route_auth = array(
            array("page" => "index", "title" => "Page d'accueil", "text" => "ACCUEIL", "description" => "Index de devwebframework", "keyword" => "Index, devwebframework, DWF"),
            array("page" => "deco", "title" => "Deconnexion", "text" => "DECONNEXION"),
        );
        $keyword = "converteur, temperatures, Kelvin, Celcius, Fahrenheit, Benamran, DWF";
        self::$_route_unauth = array(
            array("page" => "index", "title" => "Page d'accueil", "text" => "Accueil", "description" => "Converssion de temperatures : Kelvin, Celcius, Fahrenheit et Benamran (humoristique)",
                "keyword" => $keyword),
            array("page" => "api", "title" => "API", "text" => "API", "description" => "API convertisseur de temperatures °K, °C, °F, °B",
                "keyword" => "API, " . $keyword),
            array("page" => "your_own", "title" => "créez votre echelle", "text" => "Votre Échelle", "description" => "API convertisseur de temperatures °K, °C, °F, °B",
                "keyword" => $keyword),
            array("page" => "apk", "title" => "Le convertisseur de temperatures sur mobile", "text" => "APK", "description" => "APK Convertisseur de temperatures °K, °C, °F, °B",
                "keyword" => $keyword),
        );
    }

}
