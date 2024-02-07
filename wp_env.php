<?php

/**
 * Plugin Name: WP Environment
 * Description: Plugin to allow Environment settings
 * Author: Daniel Melin
 * Author URI: http://dmelin.se
 * Version: 1.0.0
 */

class wp_env
{
    private $envFile;

    public function __construct()
    {
        $envPath = realpath(dirname(ABSPATH));
        $this->envFile = $envPath . '/.env';
        add_action('admin_menu', array($this, 'admin_menu'));
    }
    public function save()
    {
        try {
            $env = file_put_contents($this->envFile, $_POST['wp_environment_content']);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function env($key = false)
    {
        try {
            $env = file_get_contents($this->envFile);

            if (!$key) return $env;

            $rows = explode("\n", $env);
            foreach ($rows as $row) {
                $parts = explode("=", $row);
                if (strtolower($parts[0]) === strtolower($key)) {
                    array_shift($parts);

                    $return = implode("=", $parts);

                    $encrypt = false;
                    if (substr($return, 0, 4) == 'md5:') {
                        $encrypt = 'md5';
                        $return = substr($return, 4);
                    }
                    if (substr($return, 0, 7) == 'base64:') {
                        $encrypt = 'base64';
                        $return = substr($return, 7);
                    }

                    if (substr($return, 0, 1) === '"' && substr($return, -1) === '"' || substr($return, 0, 1) === "'" && substr($return, -1) === "'") {
                        $return = substr($return, 1, -1);
                    }

                    if ($return == (float)$return) return (float)$return;

                    if ($encrypt) {
                        switch ($encrypt) {
                            case 'base64':
                                $return = base64_decode($return);
                                break;
                        }
                    }
                    return $return;
                }
            }
            return false;
        } catch (\Exception $e) {
            return 'Unable to read .env';
        }
    }
    public function admin_menu()
    {
        // Enqueue CodeMirror scripts and styles
        wp_enqueue_script('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.js', array(), '5.59.4', true);
        wp_enqueue_style('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.css', array(), '5.59.4');
        wp_enqueue_script('codemirror-javascript', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/mode/javascript/javascript.min.js', array(), '5.59.4', true);
        wp_enqueue_style('codemirror-theme-dracula', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/theme/dracula.min.css', array(), '5.59.4');
        add_editor_style();

        add_options_page(
            __('Environment', 'textdomain'),
            __('Environment', 'textdomain'),
            'manage_options',
            'wp_environment',
            array(
                $this,
                'dashboard'
            )
        );
    }

    public function dashboard()
    {
        require_once(__DIR__ . '/dashboard.php');
    }
}

global $wpEnv;
$wpEnv = new wp_env();

if (isset($_POST['wp_environment_content'])) {
    if ($wpEnv->save()) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
    } else {
    }
}

function wpEnv($key = false)
{
    global $wpEnv;
    return $wpEnv->env($key);
}
