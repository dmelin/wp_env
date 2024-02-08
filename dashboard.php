<?php
if (!ABSPATH) die();

$env = $this->env();

$functionName = ($this->hasEnv) ? 'env' : 'wpEnv';
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
        white-space: wordwrap;
    }
</style>
<form action="" method="post" id="wp_environment_code">
    <h1>Environment</h1>
    <textarea id="wp_environment_content" name="wp_environment_content"><?= $env ?></textarea>
    <p><button type="submit" class="button button-primary">Save</button></p>
    <p>Usage:</p>
    <pre><?= $functionName ?>()      // Returns all variables</pre>
    <pre><?= $functionName ?>('KEY') // Returns key value</pre>
    <p><strong>Important</strong></p>
    <?php
    if ($this->hasEnv) {
    ?>
        <pre>You can disable env() and instead use wpEnv() if needed by adding USE_ENV=false to .env</pre>
    <?php
    } else {
    ?>
        <pre>env() has been disabled
Reason: <?= $this->envDisabledReason ?></pre>
    <?php
    }
    ?>
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