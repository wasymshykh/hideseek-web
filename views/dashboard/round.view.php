<div class="row">
    
    <div class="col-12">
        <div class="d-flex justify-content-between border-bottom pt-2 pb-2 mb-2">
            <div>
                <a href="<?=URL?>/dashboard/team?team=<?=$round['team_id']?>" class="btn btn-sm btn-outline-dark"><i class="fa fa-arrow-left mr-1"></i> Go Back</a>
            </div>
            <h3 class="text-center font-weight-light">
                Game
            </h3>
        </div>
    </div>


    <div class="col-12 py-4">
        <div class="row mb-3">

            <div class="col-lg-3">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h6 class="my-0 font-weight-bolder text-uppercase"><i class="fa fa-question-circle"></i> Game</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Game-ID - <strong><?=$round['game_id']?></strong></li>
                            <li class="list-group-item">Team Name - <strong><?=$round['team_name']?></strong></li>
                            <li class="list-group-item">Round # - <strong><?=$round['round_number']?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-lg-9">
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
                        <h6 class="my-0 font-weight-bolder text-uppercase"><i class="fa fa-users"></i> Players</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <?php foreach ($results as $player): ?>
                            <div class="col-lg-4 my-2">
                                <div class="p-2 border text-center <?=$player['result_found'] === 'N' ? '' : 'bg-success text-white'?>">
                                    <p class="my-0"><small>Player Name</small></p>
                                    <h5 class="my-0"><?=$player['player_name']?></h5>
                                    <hr class="mt-1 mb-2">
                                    <div>
                                        <?php if ($player['round_status'] == 'A' && $player['result_found'] === 'N'): ?>
                                        <form action="" class="my-0" method="post">
                                            <button class="btn btn-sm btn-dark">
                                                <i class="fa fa-check"></i> Found
                                            </button>
                                            <input type="hidden" name="found" value="<?=$player['result_id']?>">
                                        </form>
                                        <?php else: ?>
                                            <?php if ($player['result_found'] === 'Y'): ?>
                                                <p class="my-0">Found: <strong><?=normal_date($player['result_found_on'])?></strong></p>
                                                <p class="my-0">Score: <strong>+<?=$player['result_score']?></strong> &nbsp; Position: <strong><?=$player['result_position']?></strong></p>
                                            <?php else: ?>
                                                <p class="my-0 text-muted font-weight-light">Player wasn't found.</p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
