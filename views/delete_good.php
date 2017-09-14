<h2>Вы уверены, что хотите удалить товар "<?=$this->params['item'][0]['good_name']?>" ?</h2>
<form action="/good/deleting" method="POST">
    <input name="id" type="hidden" value="<?=$this->params['item'][0]['id']?>">
    <input name="good_name" type="hidden" value="<?=$this->params['item'][0]['good_name']?>">
    <label>Удалить фото товара<input name="delete_old_file" type="checkbox" checked></label><br/>
    <button type="submit" class="myButton">Да</button>
</form>