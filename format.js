const input = document.getElementById('input');
const editor = CodeMirror.fromTextArea(input, {
    mode: 'ini',
    lineNumbers: true,
    tabSize: 2,
    styleActiveLine: true,
    gutters: ['CodeMirror-lint-markers'],
    lint: true,
    lintGutter: true,
});

// Set the editor's value to the initial content
editor.setValue(input.value);

// Set up a "change" listener to format the content automatically
editor.on('change', function () {
    const envContent = editor.getValue();
    const lines = envContent.trim().split('\n');
    const formattedLines = lines.map(line => {
        const parts = line.split('=');
        if (parts.length === 2) {
            return `${parts[0].trim()}=${parts[1].trim()}`;
        } else {
            return line;
        }
    });
    const formattedContent = formattedLines.join('\n');
    editor.setValue(formattedContent);
});

// Set up a "blur" listener to update the textarea's value when the editor loses focus
input.addEventListener('blur', function () {
    input.value = editor.getValue();
});