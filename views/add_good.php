<form action="/good/adding" method="POST" enctype="multipart/form-data">
    <select name="id_category">
        <?php
        foreach ($this->params['catalogs'] as $item){
            echo '<option value='. $item['id']. '>' . $item['catalog_name']. '</option>';
        }
        ?>
    </select><br/>
    <input name="name" placeholder="Наименование" required><br/>
    <input name="price" type="number" placeholder="Цена" required><br/>
    <textarea name="description" placeholder="Описание"></textarea><br/>
    <input name="userfile" type="file"/><br/>
    <button class="myButton">Добавить</button>
</form>