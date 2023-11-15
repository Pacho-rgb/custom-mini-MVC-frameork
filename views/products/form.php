

<?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
        <?php foreach($errors as $error): 
            echo "<p>$error</p>";
        endforeach; ?>
        </div>
    <?php endif; ?>

<!-- Here, we're going to submit the form to this current file, so the value of the action will remain blank  -->
<form action="" method="post" enctype="multipart/form-data">

        <?php if ($product['image']): ?>
            <img src="<?php echo $product['image']; ?>" alt="product image">
        <?php endif; ?>

    <div class="form-group mb-3"> 
        <label for="image" class="form-label">Product image</label><br>
        <input type="file" name="image" id="image">
    </div>
    <div class="form-group mb-3"> 
        <label for="title" class="form-label">Product title</label>
        <input type="text" name="title" class="form-control" id="title" value="<?php echo $product['title'] ?>">
    </div>
    <div class="form-group mb-3"> 
        <label for="description" class="form-label">Product description</label>
        <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?php echo $product['description'] ?></textarea>
    </div>
    <div class="form-group mb-3"> 
        <label for="price" class="form-label">Product price</label>
        <input type="number" step=".01" name="price" class="form-control" id="price" value="<?php echo $product['price'] ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>