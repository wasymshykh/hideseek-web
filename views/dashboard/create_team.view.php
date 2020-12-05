<div class="row">
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h3 class="text-center font-weight-light">
                Create a <strong>new team</strong>
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
                        <label for="name">Team Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                            </div>
                            <input type="text" class="form-control" name="name" id="name" placeholder="name" value="<?=$_POST['name']??''?>">
                        </div>
                    </div>

                    <hr class="my-2">

                    <div id="members">
                        <?php if (isset($_POST['team_members']) && is_array($_POST['team_members']) && !empty($_POST['team_members'])): ?>
                            <?php foreach($_POST['team_members'] as $key => $member): ?>
                                <div class="mb-3">
                                    <label for="team_members_<?=$key+1?>">Member <?=$key+1?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="team_members[]" id="team_members_<?=$key+1?>" placeholder="Member name" value="<?=$member?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div class="mb-3">
                            <label for="team_members_1">Member 1</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="team_members[]" id="team_members_1" placeholder="Member name" value="">
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <button type="button" id="addmember" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add more</button>
                    </div>

                    <hr class="my-2">

                    <button type="submit" class="btn btn-primary btn-block">Create</button>
                </form>

            </div>
        </div>

    </div>
</div>


<script>
    <?php if (isset($_POST['team_members']) && is_array($_POST['team_members']) && !empty($_POST['team_members'])): ?>
        let total_members = <?=count($_POST['team_members'])?>;
    <?php else: ?>
        let total_members = 1;
    <?php endif; ?>
    $('#addmember').on('click', (e)=>{
        
        total_members++;
        let html = `<div class="mb-3"><label for="team_members_1">Member ${total_members}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="team_members[]" id="team_members_${total_members}" placeholder="Member name">
                    </div>
                </div>`;
        $("#members").append(html);


    })
</script>
