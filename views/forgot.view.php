<div class="row">
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h3 class="text-center font-weight-light">
                Forgot Password? <strong>Not a problem!</strong>
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

                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$_POST['email']??''?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Send Link</button>
                </form>

            </div>
        </div>

    </div>
</div>

