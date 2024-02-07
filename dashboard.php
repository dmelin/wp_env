<?php
if (!ABSPATH) die();

$env = $this->env();
?>
<style type="text/css">
    #wp_environment_code {
        margin: 20px auto;
        max-width: 800px;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    #wp_environment_code>h1 {
        margin: 0 0 10px 0;
    }

    #wp_environment_code>pre {
        padding: 10px;
        background: #eee;
    }
</style>
<form action="" method="post" id="wp_environment_code">
    <h1>Environment</h1>
    <textarea id="wp_environment_content" name="wp_environment_content"><?= $env ?></textarea>
    <p><button type="submit" class="button button-primary">Save</button></p>
    <p>Usage:</p>
    <pre>wpEnv()      // Returns all variables</pre>
    <pre>wpEnv('KEY') // Returns key value</pre>
    <p>.env location</p>
    <pre><?= $this->envFile ?></pre>
</form>
<script>
    jQuery(document).ready(function() {
        var editor = CodeMirror.fromTextArea(document.getElementById("wp_environment_content"), {
            lineNumbers: true,
            mode: "javascript",
            theme: "dracula"
        });
    });
</script>