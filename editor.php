<?php

// configuration
$url = 'http://anwarulislam.tk/editor.php?name='.$_POST['filename'];
$file = $_GET['name'];
$filename = $_POST['filename'];

// check if form has been submitted
if (isset($_POST['text']))
{
    // save the text contents
    file_put_contents($filename, $_POST['text']);

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

// read the textfile
$text = file_get_contents($file);

?>
<!-- HTML form -->
<form action="editor.php" method="post">
    <input type="hidden" name="filename" value="<?php echo $file ?>">

<label for="editor">Editor</label>

    <textarea name="text" style="height:100%; width:100%"><?php echo htmlspecialchars($text) ?> </textarea>
    
    <div id="editor" style="height:100%; width:100%"><?php echo htmlspecialchars($text) ?> </div>



<input type="hidden" id="text" name="text0" style="display: none;">
<input type="submit">
<input type="reset">
</form>

<script src="https://ace.c9.io/build/src/ace.js"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");
    
     var input = $('#text');
        editor.getSession().on("change", function () {
        input.val(editor.getSession().getValue());
});
    
</script>