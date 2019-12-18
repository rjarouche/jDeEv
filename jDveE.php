<?php
require_once './Colors.php';
require_once './ColorDecorator.php';


$f_create_file = function (): void {

    $content =
<<<'EOD'
{
    "php7" : "",
    "php5" : "",
    "apache5" : "",
    "apache7" : "",
    "live-server" : "",
    "browser" : "",
    "OS" : ""
}
EOD;

    file_put_contents("jDveE.json", $content);

};

//Load configs
if (file_exists("JDveE.json")):
    $configs = json_decode(file_get_contents("JDveE.json"));
else:
    echo textFail("File JDveE.json not found",'white','red');
    $f_create_file();
    echo textSucess("File JDveE.json created");
    echo textWarning("Please config it");
    exit;
endif;

// windows commands
if ($configs->OS == 'win'):
    $start = 'start /MIN ""';
    $_1 = ["{$start} {$configs->apache5}",  "{$start} {$configs->browser}"];
    $_2 = ["{$start} {$configs->apache7}",  "{$start} {$configs->browser}"];
    $_3 = ["{$start} {$configs->{'live-server'}}",
        "{$start} {$configs->php5} -S localhost:80",
        "{$configs->browser}"];
    $_4 = ["{$start} {$configs->{'live-server'}}",
        "{$start} {$configs->php7} -S localhost:80",
        "{$configs->browser}"];

    $_5 = ["{$start} {$configs->{'live-server'}}",
        "{$start} {$configs->apache5}",
        "{$configs->browser}"];
    $_6 = ["{$start} {$configs->{'live-server'}}",
        "{$start} {$configs->apache7}",
        "{$configs->browser}"];
else:
    //Linux commands
    $_1 = "";
    $_2 = "";
    $_3 = "";
    $_4 = "";
    $_5 = "";
    $_6 = "";
endif;

//bootstrap
$options_menu = [
    1 => ["text" => "Run Apache with php5", "cmd" => $_1],
    2 => ["text" => "Run Apache with php7", "cmd" => $_2],
    3 => ["text" => "Run inside php5 server and live server", "cmd" => $_3],
    4 => ["text" => "Run inside php7 server and live server", "cmd" => $_4],
    5 => ["text" => "Run apache with php5 and live server", "cmd" => $_5],
    6 => ["text" => "Run apache with php7 and live server", "cmd" => $_6],
];

if (!(isset($argv[1])) || $argv[1] == "menu" ):
    $extra_args = array_slice($argv, 2);
    do {
        $sel_opt = menu($options_menu);
        $v_option = in_array($sel_opt, array_keys($options_menu));
    } while (!$v_option);
else:
    $sel_opt = $argv[1];
    if (!in_array($sel_opt, array_keys($options_menu))):
        echo textFail("Invalid Option!");
        exit;
    endif;
    if ($argc > 2):
        $extra_args = array_slice($argv, 2);
    endif;
endif;

//exec comands
$cmd = $options_menu[$sel_opt]['cmd'];
//$cmd = "{$cmd} {$extra_args}";
$i=0;
foreach ($cmd as $c) {
    //vprintf("%s %s".PHP_EOL,[$c,$extra_args[$i] ?? ""]);
    popen(sprintf("%s %s", $c, $extra_args[$i] ?? ""), "r");
    $i++;
}

/*Auxiliar functions*/

function readln()
{
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    return trim($line);
}

//functions
function menu($menu): int
{
    global $extra_args;
    echo <<<'EOL'
################################################################################
            Jarouche DeVElopment Environment Configurator
            Choose your option and be happy!

                    |¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨¨...‡
                    |                  |||"|""\__
                    |__________________|||_|___|)<
                    !(@)'(@)""""**!(@)(@)****!(@)
################################################################################



EOL;
    echo PHP_EOL;
    foreach ($menu as $key => $opt):
        text(vsprintf('%s - %s', [$key, $opt['text']]));
        $i = 0;
        foreach($opt['cmd'] as $t):
            textSubMenu($t,$extra_args[$i] ?? "");
            $i++;
        endforeach;
    endforeach;
    textSucess("Type your option: ");
    return readln();

};


