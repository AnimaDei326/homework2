<a href="/good/add" class="myButton">Добавить новый товар</a><br/>

<?php
if($this->params['goods']){
    foreach ($this->params['goods'] as $item){
        echo '<div class="good"><h2><a class="detail" href="\good\detail?id='. $item['id'] .'"\>' . $item['good_name'] . '</a></h2><h3 class="price">US $ ' . $item['price'] . ' / шт.</h3><img src="/images/' . $item['path'] . '" /><br/>';
        echo '<a class="myButton" href="/good/rename?id=' . $item['id'] . '">редактировать</a>';
        echo '<a class="myButton" href="/good/delete?id=' . $item['id'] . '">удалить </a></div><br/>';
    }
}else{
    echo "Нет ни одного товара";
}
