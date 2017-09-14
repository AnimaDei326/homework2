<a class="myButton" href="/catalog/add">Добавить новый раздел каталога</a><br/>

<?php
if($this->params['catalogs']){
    foreach ($this->params['catalogs'] as $item){
        echo '<div><a class="detail" href=/catalog/detail?id=' . $item['id'] . '>' . $item['catalog_name'] . '</a><br/>';
        echo '<a class="myButton" href=/catalog/delete?id=' . $item['id'] . '>удалить </a>';
        echo '<a class="myButton" href=/catalog/rename?id=' . $item['id'] . '>переименовать</a></div><br/>';
    }
}else{
    echo "Нет ни одного каталога";
}
