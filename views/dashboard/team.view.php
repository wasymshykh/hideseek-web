<div class="row">
    
    <div class="col-12">
        <div class="border-bottom pt-2 pb-2 mb-2">
            <h3 class="text-center font-weight-light">
                Team - <strong><?= $team['team_name'] ?></strong>
            </h3>
        </div>
    </div>

    <div class="col-12 py-4">


    <div class="row mb-3">

        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h6 class="my-0 font-weight-bolder text-uppercase"><i class="fa fa-users"></i> Players</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>Name</th>
                            <th>Added</th>
                            <th>Score</th>
                        </thead>
                        <tbody>
                            <?php $row = 1; foreach($players as $player): ?>
                                <tr>
                                    <td><?=$row?></td>
                                    <td><?=$player['player_name']?></td>
                                    <td><small><?=normal_date($player['player_created'])?></small></td>
                                    <td><?=$profile->player_score($player['player_id'])?></td>
                                </tr>
                            <?php $row++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-lg-8">
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

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <h6 class="my-0 text-left font-weight-bolder text-uppercase"><i class="fa fa-gamepad"></i> Games</h6>
                        </div>
                        <div>
                            <form action="" class="my-0" method="post">
                                <button class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> Add a new game
                                </button>
                                <input type="hidden" name="add_game">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($games as $game): ?>
                    <div class="col-12 p-4 border mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="my-0">Game-ID #<?=$game['game_id']?></h5>
                            <h6 class="my-0"><span class="badge badge-danger">Active</span></h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="my-0"><span class="badge badge-dark">Rounds</span></h5>
                            <div>
                                <form action="" class="my-0" method="post">
                                    <button class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i> add a round
                                    </button>
                                    <input type="hidden" name="add_round" value="<?=$game['game_id']?>">
                                </form>
                            </div>
                        </div>
                        
                        <table class="table table-striped table-bordered mt-4">
                            <thead class="thead-light">
                                <tr>
                                    <th>Round #</th>
                                    <th>Round Started</th>
                                    <th>Round Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($game['rounds'])): ?>
                                    <?php foreach($game['rounds'] as $round): ?>
                                    <tr>
                                        <td><?=$round['round_number']?></td>
                                        <td><?=normal_date(current_date())?></td>
                                        <td>
                                            <h6>
                                                <?php if($round['round_status'] === 'A'): ?>
                                                    <span class="badge badge-danger">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Ended</span>
                                                <?php endif; ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <a href="<?=URL?>/dashboard/round?round=<?=$round['round_id']?>" class="btn btn-sm btn-<?=($round['round_status']==='A')?'warning':'secondary'?>">Go to <?= ($round['round_status'] === 'A') ? "round" : "result"?> <i class="fa fa-arrow-right"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4"><small><i>no rounds found, please add new</i></small></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endforeach; ?>
                
                </div>
            </div>
        </div>

    </div>


    </div>
</div>
