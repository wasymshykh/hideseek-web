<div class="row">
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h3 class="text-center font-weight-light">
                Reset Your <strong>Password</strong>
            </h3>
        </div>
    </div>

    <div class="col-12 py-4">

        <div class="row">
            <div class="col-lg-4 offset-lg-4">

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?=$success?>
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?=$error?>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="password">New Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="New Password" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword">Confirm Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password" value="">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </form>

            </div>
        </div>

    </div>
</div>

