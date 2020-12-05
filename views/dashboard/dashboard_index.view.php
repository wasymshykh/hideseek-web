<div class="row">
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h3 class="text-center font-weight-light">
                Welcome back! <strong><?= $logged['user_name'] ?></strong>
            </h3>
        </div>
    </div>

    <div class="col-12 py-4">

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

        <div class="row mb-3 text-center">

            <div class="col-lg-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h6 class="my-0 font-weight-bolder text-uppercase"><i class="fa fa-users"></i> Teams</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 border py-2">
                                <h3><?=count($teams)?></h3>
                                <p class="mb-0">Teams</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group d-flex align-items-center mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <label for="team" class="my-0 ml-1">Select Team</label>
                                </div>
                                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                    <select class="form-control" name="select_team" id="team" onchange="this.form.submit()">
                                        <option value="">-- select --</option>
                                        <?php foreach($teams as $team): ?>
                                        <option value="<?=$team['team_id']?>"><?=$team['team_name']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12 mt-4 text-center">
                                <a href="<?=URL?>/dashboard/create_team" class="btn btn-outline-primary font-weight-bold">Create New <i class="ml-1 fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#team').select2();
    });
</script>