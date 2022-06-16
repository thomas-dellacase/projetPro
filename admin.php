<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
</head>
<body>
    <main>
        <article>
            <form>
                <input type="text" name="prodName"></input>
                <textarea name='description' style="resize: none;" placeholder='Description du produit'></textarea>
                <select name='idCat'>
                    <option value='' disabled selected>Choisiez une sous categories</option>
                    <?php
                    $option = new Categorie;
                    $option->displayNameCat();
                    ?>
                </select>
                <input class='inputProd' type='text' name='prix' placeholder="Prix du produit"></input>
                <input class='inputProd' type='file' name='image'></input>
                <input type='submit' name='addProd'></input>
            </form>
        </article>
        <article>
            <form>
                <input type='text' name='nameCat'></input>
                <input type='submit' name='addProd'></input>
            </form>
        </article>
    </main>
</body>
</html>