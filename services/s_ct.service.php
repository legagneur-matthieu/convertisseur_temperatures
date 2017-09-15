<?php

/**
 * service ct
 *
 * @author LEGAGNEUR Matthieu <legagneur.matthieu@gmail.com> 
 */
class s_ct {

    public function __construct() {
        (new php_header())->content_type("json");
        if (isset($_REQUEST["t"]) and isset($_REQUEST["from"]) and
                math::is_float($_REQUEST["t"]) and
                in_array($_REQUEST["from"], ["K", "C", "F", "B"])
        ) {
            $t = (float) $_REQUEST["t"];
            switch ($_REQUEST["from"]) {
                case "K":
                    $t -= 273.16;
                    break;
                case "F":
                    $t = ($t - 32) / 1.8;
                    break;
                case "B":
                    $t = 1.8850267379679144 * $t + 4.2;
                    break;
            }
            ob_clean();
            echo json_encode([
                "C" => $t,
                "K" => ($t + 273.16),
                "F" => ($t * 1.8 + 32),
                "B" => (($t - 4.2) / 1.8850267379679144)
            ]);
        } else {
            ob_clean();
            echo json_encode(false);
        }
    }

}
