<form action="/good/renaming" method="POST" enctype="multipart/form-data">
    <select name="id_category">
        <?php
        foreach ($this->params['catalogs'] as $item){
            echo '<option value='. $item['id']. '>' . $item['catalog_name']. '</option>';
        }
        ?>
    </select><br/>
    <input name="name" value="<?=$this->params['item'][0]['good_name']?>" required><br/>
    <input name="price" type="number" value="<?=$this->params['item'][0]['price']?>" required><br/>
    <input name="description" value="<?=$this->params['item'][0]['description']?>" required><br/>
    <input name="id" type="hidden" value="<?=$this->params['item'][0]['id']?>"><br/>
    <label>Удалить старое фото товара<input name="delete_old_file" type="checkbox" checked></label><br/>
    <input name="userfile" type="file"/><br/>
    <button class="myButton" type="submit">Изменить</button>
</form>