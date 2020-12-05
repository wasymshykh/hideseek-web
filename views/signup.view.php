<div class="row">
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h3 class="text-center font-weight-light">
                Create a new <strong>account</strong>
            </h3>
        </div>
    </div>

    <div class="col-12 py-4">

        <div class="row">
            <div class="col-lg-4 offset-lg-4">

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?=$error?>
                    </div>
                <?php endif; ?>

                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <div class="mb-3">
                        <label for="name">Full Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Full name" value="<?=$_POST['name']??''?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$_POST['email']??''?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=$_POST['password']??''?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="c_password">Confirm Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="c_password" id="c_password" placeholder="Confirm password" value="<?=$_POST['c_password']??''?>">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-block">Signup</button>
                </form>

            </div>
        </div>

    </div>
</div>

