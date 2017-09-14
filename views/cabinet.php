<p>Вы недавно смотрели</p>
<ul>
<?php

foreach ($this->params['arrayCookie'] as $item) {
    $arrayCookieTitle = explode('$', $item);
    echo "<li><a class=\"history\" href='{$arrayCookieTitle[0]}'>$arrayCookieTitle[1]</a>";
}

?>
</ul>
