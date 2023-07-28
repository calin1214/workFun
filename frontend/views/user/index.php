<?php

/**
 * @var $model
 */

?>

<link rel="stylesheet" type="text/css" href="../../web/css/user.css">

<div class="user-form">
    <div>
        <h2>User Form</h2>
        <form method="post" action="<?php echo '/user/index' ?>" enctype="multipart/form-data">
            <div class="form-div required">
                <label class="control-label" for="name">Name</label>
                <input placeholder="Enter your name" type="text" name="name" id="name" class="form-control"
                       aria-required="true" value="<?php echo $model->name ?? '' ?>" required>
            </div>

            <div class="form-div required">
                <label class="control-label" for="email">Email</label>
                <input placeholder="Enter your email address" type="email" name="email" class="form-control"
                       id="email" value="<?php echo $model->email ?? '' ?>" required>
            </div>

            <div class="form-div">
                <label class="control-label" for="image_field">Upload a image</label>
                <input type="file" id="image_field" name="image" class="form-control" accept="image/*">
            </div>

            <div class="form-div">
                <label>
                    <input type="checkbox" name="acceptTerms"> I accept the <a href="#">Terms of Service</a>
                </label>
            </div>

            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</div>
