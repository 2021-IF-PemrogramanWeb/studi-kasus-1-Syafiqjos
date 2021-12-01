<?php
    // https://stackoverflow.com/questions/1996122/how-to-prevent-xss-with-html-php
    function normalize_html($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
?>