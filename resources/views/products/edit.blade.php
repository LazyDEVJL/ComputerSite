<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!--Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

  </head>
  <body>
    <h3 class="text-center mt-5">Sửa danh mục</h3> <hr>
    <p class="text-center">
        <a href="<?=action('CategoryController@index')?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Trở lại danh sách danh mục</a>
    </p>
    <div align="center" class="table-responsive">
        <form action="<?=action('CategoryController@editSave')?>" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="txt_id" value="<?=$editCategory->id?>">
            <table class="table w-50">
                <tr>
                <th>Category Name</th>
                <td><input type="text" class="form-control" name="txt_name" value="<?=$editCategory->name?>"></td>
                </tr>
                <tr>
                <th>Position</th>
                <td><input type="number" class="form-control" name="txt_position" value="<?=$editCategory->position?>"></td>
                </tr>
                <tr>
                <th>Show/Hide</th>
                <td>
                    Show: <input type="radio" value="1" name="rd_active" <?=$editCategory->active == 1 ? 'checked' : '' ?>>
                    Hide: <input type="radio" value="0" name="rd_active" <?=$editCategory->active == 0 ? 'checked' : '' ?>>
                </td>
                </tr>
                <tr>
                <th>Slug</th>
                <td><input type="text" class="form-control" name="txt_slug" value="<?=$editCategory->slug?>"></td>
                </tr>
                <tr>
                <th>Parent Category</th>
                <td>
                    <select class="form-control" name="sl_parent_id">
                    <option value="0">Highest grade</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?=$category->id?>" 
                            <?=$category->id == $editCategory->id ? 'selected' : '' ?>
                        >
                        <?=$category->name?>
                        </option>
                    <?php endforeach;?>
                    </select>
                </td>
                </tr>
                <tr class="text-center">
                <td colspan="2">
                    <input type="submit" value="Edit" class="btn btn-primary">
                    <input type="reset" value="Reset" class="btn btn-secondary">
                </td>
                </tr>
            </table>
        </form>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>