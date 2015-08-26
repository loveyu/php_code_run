<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>PHP 代码运行</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="jquery-1.11.0.js" type="application/javascript"></script>
    <script src="edit_area/edit_area_full.js" type="application/javascript"></script>
</head>
<body>
<div class="content">
    <div class="left">
        <div id="EditBox"></div>
    </div>
    <div class="right">
        <pre><code id="Output"></code></pre>
    </div>
    <div class="clear"></div>
</div>
<script>
    var RUN_FLAG = true;
    function FixWidth() {
        var height = $(window).height();
        $(".content").height(height - 5);
        $("#frame_EditBox").css("height", "100%").css("width", "100%");
    }
    function CodeSave(id, value) {
        $.post('run.php<?php
        $i = strpos($_SERVER['REQUEST_URI'],'?');
        if($i>0){
         echo substr($_SERVER['REQUEST_URI'],$i);
        }
        ?>', {code: value, flag: RUN_FLAG}, function (data) {
            if (data.length < 1) {
                $("#Output").html("执行结果为空");
            } else {
                $("#Output").html(data);
            }
        });
    }
    function toggle_mode() {
        RUN_FLAG = !RUN_FLAG;
    }
    function PageLoad() {
        FixWidth();
        editAreaLoader.openFile('EditBox', {id: 'NowCode', syntax: 'php', title: "运行代码", text: ""});
        $(window.frames["frame_EditBox"].document).keydown(function () {
            var event = document.frame_EditBox.event;
            if (event.ctrlKey && event.keyCode == 13) {
                CodeSave('EditBox', this.activeElement.value);
            } else if (event.altKey && event.keyCode == 13) {
                toggle_mode();
            }
        });
    }

    function ReOpenFile() {
        setTimeout(PageLoad, 200);
    }
    $(function () {
        FixWidth();
        $(window).resize(FixWidth);
        editAreaLoader.init({
            id: "EditBox",
            font_size: "22",
            start_highlight: true,
            allow_toggle: false,
            language: "zh",
            syntax: "html",
            toolbar: "fullscreen, search, save ,go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help",
            syntax_selection_allow: "css,html,js,php,python,vb,xml,c,cpp,sql,basic,pas,brainfuck",
            is_multi_files: true,
            EA_load_callback: "PageLoad",
            save_callback: "CodeSave",
            EA_file_close_callback: "ReOpenFile",
            show_line_colors: true
        });
    });
</script>
</body>
</html>