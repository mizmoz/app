<?php

if (! function_exists('d')) {
    // function for printing stuff
    function d(): void
    {
        if (!in_array(\Mizmoz\App\App::getInstance()->platform(), ['development', 'testing'])) {
            // Only show messages on development platform in case any get left in the code on production... as if?! :|
            return;
        }

        $e = new Exception();
        $trace = $e->getTrace();
        $cli = (php_sapi_name() === 'cli');

        if (isset($trace[2]) && ($trace[2]['function'] == 'dt')) {
            var_dump($trace);
        } else {
            $trace = (isset($trace[1]['file']) ? $trace[1] : $trace[2]);

            echo ($cli
                    ? ' ' . $trace['file'] . ':' . $trace['line']
                    : "<pre><font color='#55aaaa'>" . $trace['file'] . ':' . $trace['line'] . "</font></pre>"
                ) . PHP_EOL;
        }

        if (!$cli) {
            echo '<pre>';
        }

        call_user_func_array('var_dump', func_get_args());

        if (!$cli) {
            echo '</pre><hr />';
        }
    }
}

if (! function_exists('ds')) {
    // dump trace as string with variables
    function ds(): void
    {
        $args = func_get_args();
        $e = new Exception();
        array_unshift($args, $e->getTraceAsString());
        call_user_func_array('d', $args);
        exit;
    }
}

if (! function_exists('dt')) {
    // dump with trace and exit
    function dt(): void
    {
        call_user_func_array('d', func_get_args());
        exit;
    }
}

if (! function_exists('de')) {
    // dump variable and exit
    function de(): void
    {
        call_user_func_array('d', func_get_args());
        exit;
    }
}

if (! function_exists('dm')) {
    // dump memory usage
    function dm(): void
    {
        $args = func_get_args();
        $args[] = number_format(memory_get_usage());
        call_user_func_array('d', $args);
    }
}
