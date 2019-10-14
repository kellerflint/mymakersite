<form action="progression_edit.php" METHOD="POST">
    <?php $category = find_category_by_id($_GET["category_id"]); ?>
    <div class="form-group">
        <label for="category-name">Name</label>
        <input type="text" class="form-control" id="category-name" value="<?php echo $category["category_name"]; ?>">
    </div>
    <div class="form-group">
        <label for="category-description">Description</label>
        <textarea class="form-control" id="category-description" rows="3"><?php echo $category["category_description"]; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>