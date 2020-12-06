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
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPlayer"><i class="fa fa-plus"></i> Add player</button>

                        <table class="table table-bordered mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Added</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($players as $player) : ?>
                                    <tr>
                                        <td><input class="rplayer-radio" type="radio" name="player-action" value="<?= $player['player_id'] ?>"></td>
                                        <td><?= $player['player_name'] ?></td>
                                        <td><small><?= normal_date($player['player_created']) ?></small></td>
                                        <td><?= $profile->player_score($player['player_id']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <button class="btn btn-sm btn-primary" id="renamePlayerBtn"><i class="fa fa-pencil"></i> Rename</button>
                                        <button class="btn btn-sm btn-danger" id="deletePlayerBtn"><i class="fa fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-lg-8">
                <?php if ($success) : ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                <?php if ($error) : ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
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
                        <?php foreach ($games as $game) : ?>
                            <div class="col-12 p-4 border mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="my-0">Game-ID #<?= $game['game_id'] ?></h5>
                                    <h6 class="my-0">
                                        <?php if($game['game_status'] === 'E'): ?>
                                            <span class="badge badge-secondary">Ended</span>
                                        <?php else: ?>                                            
                                            <form class="my-0" action="" method="post">
                                                <input type="hidden" name="end_game" value="<?=$game['game_id']?>">
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> End Game</button>
                                            </form>
                                        <?php endif; ?>
                                    </h6>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="my-0"><span class="badge badge-dark">Rounds</span></h5>
                                    <div>
                                    <?php if($game['game_status'] === 'A'): ?>
                                        <form action="" class="my-0" method="post">
                                            <button class="btn btn-sm btn-success">
                                                <i class="fa fa-plus"></i> add a round
                                            </button>
                                            <input type="hidden" name="add_round" value="<?= $game['game_id'] ?>">
                                        </form>
                                    <?php endif; ?>
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
                                        <?php if (!empty($game['rounds'])) : ?>
                                            <?php foreach ($game['rounds'] as $round) : ?>
                                                <tr>
                                                    <td><?= $round['round_number'] ?></td>
                                                    <td><?= normal_date(current_date()) ?></td>
                                                    <td>
                                                        <h6>
                                                            <?php if ($round['round_status'] === 'A') : ?>
                                                                <span class="badge badge-danger">Active</span>
                                                            <?php else : ?>
                                                                <span class="badge badge-secondary">Ended</span>
                                                            <?php endif; ?>
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <a href="<?= URL ?>/dashboard/round?round=<?= $round['round_id'] ?>" class="btn btn-sm btn-<?= ($round['round_status'] === 'A') ? 'warning' : 'secondary' ?>">Go to <?= ($round['round_status'] === 'A') ? "round" : "result" ?> <i class="fa fa-arrow-right"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
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


<div class="modal fade" id="addPlayer" tabindex="-1" role="dialog" aria-labelledby="addPlayerCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlayerLongTitle">Add a new player</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="create_player">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="player" id="player" placeholder="Player name" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add player</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="renamePlayer" tabindex="-1" role="dialog" aria-labelledby="renamePlayerCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renamePlayerLongTitle">Rename player - <strong id="rplayer-name"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="rename_player" id="rename_player">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="rplayer" id="rplayer" placeholder="Player name" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Rename player</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="deletePlayer" tabindex="-1" role="dialog" aria-labelledby="deletePlayerCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="post" action="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePlayerLongTitle">Confirm Deleting - <strong id="dplayer-name"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delete_player" id="delete_player">
                <p>Are you sure about deleting the user?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>

<script>

    $("#renamePlayerBtn").on('click', (e) => {
        _checked = $(".rplayer-radio:checked");
        if (_checked.length > 0) {
            _player_id = _checked.val();
            _player_name = _checked.parent().next().text();
            $("#rplayer").val(_player_name);
            $("#rename_player").val(_player_id);
            $("#rplayer-name").text(_player_name);
            $('#renamePlayer').modal('show')
        }
    })

    $("#deletePlayerBtn").on('click', (e) => {
        _checked = $(".rplayer-radio:checked");
        if (_checked.length > 0) {
            _player_id = _checked.val();
            _player_name = _checked.parent().next().text();
            $("#dplayer").val(_player_name);
            $("#delete_player").val(_player_id);
            $("#dplayer-name").text(_player_name);
            $('#deletePlayer').modal('show')
        }
    })
</script>