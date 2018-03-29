<?php

if (! function_exists('app')) {
    /**
     * Get the globally registered app
     *
     * @return \Mizmoz\App\Contract\AppInterface
     */
    function app(): \Mizmoz\App\Contract\AppInterface {
        return Mizmoz\App\App::getInstance();
    }
}

if (! function_exists('config')) {
    /**
     * Get the config for the global app. If no $key is provided then the config container is returned.
     *
     * @param string|null $name
     * @param string|null $defaultValue
     * @return mixed|\Mizmoz\Config\Contract\ConfigInterface
     */
    function config() {
        // get the config
        $config = Mizmoz\App\App::getInstance()->config();

        // either return the config if no arguments have been passed otherwise call the get method
        return (func_num_args() == 0 ? $config : call_user_func_array([$config, 'get'], func_get_args()));
    }
}

if (! function_exists('container')) {
    /**
     * Get the globally registered app container
     *
     * @param string|null $name
     * @return mixed|\Mizmoz\Container\Contract\ContainerInterface
     */
    function container() {
        // get the container
        $container = Mizmoz\App\App::getInstance()->container();

        // either return the container if no arguments have been passed otherwise call the get method
        return (func_num_args() == 0 ? $container : call_user_func_array([$container, 'get'], func_get_args()));
    }
}
