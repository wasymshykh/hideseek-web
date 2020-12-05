<div class="row">
    
    <div class="col-12">
        <div class="d-flex justify-content-between border-bottom pt-2 pb-2 mb-2">
            <div>
                <a href="<?=URL?>/dashboard" class="btn btn-sm btn-outline-dark"><i class="fa fa-arrow-left mr-1"></i> Go Back</a>
            </div>
            <h3 class="text-center font-weight-light">
                Settings
            </h3>
        </div>
    </div>

    <div class="col-12">

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

        <div class="row mb-3">

            <div class="col-lg-5 offset-lg-1">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h6 class="my-0 font-weight-bolder text-uppercase"><i class="fa fa-id-card"></i> Profile Settings</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                            <input type="hidden" name="profile-save">
                            <div class="mb-3">
                                <label for="name">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Full name" value="<?=$_POST['name']?? $logged['user_name'] ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$_POST['email']??$logged['user_email']?>">
                                </div>
                            </div>

                            <div class="row text-center">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 offset-lg-1">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h6 class="my-0 font-weight-bolder text-uppercase"><i class="fa fa-id-card"></i> Security Settings</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                            <input type="hidden" name="security-save">
                            <div class="mb-3">
                                <label for="new_password">New Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New password" value="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="newc_password">Confirm new password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="newc_password" id="newc_password" placeholder="Confirm new password" value="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password">Current Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Current password" value="">
                                </div>
                            </div>

                            <div class="row text-center">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

    