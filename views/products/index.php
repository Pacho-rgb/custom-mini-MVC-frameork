<h1>Products CRUD</h1>
<p>
<a type="button" class="btn btn-outline-primary btn-sm" href="/products/create" role="button">Create product</a>
</p>

<div>
<form action="">
    <div class="input-group mb-3">
    <span class="input-group-text" id="basic-addon1">Search</span>
    <input type="text" class="form-control" placeholder="search for products" name="search" value="<?php echo $search ? $search : ''; ?>">
    <!-- <div class="input-group-append">
        <button type="submit" class="btn btn-outline-seondary">Search</button>
    </div> -->
    </div>
</form>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Index</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create date</th> 
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $i => $product): ?>
      <tr>
        <th scope="row"><?php echo $i + 1 ?></th>
        <td><img class="thumbnail" src="<?php echo $product['image'] ?>" alt="product image"></td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>
          <a href="/products/update?id=<?php echo $product['id'] ?>" type="button" class="btn btn-outline-secondary btn-sm">Edit</a>
          <form style="display: inline;" method="post" action="/products/delete">
            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>