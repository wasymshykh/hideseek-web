<?php

class Profile
{
    private $db;
    private $user_id;

    public function __construct(PDO $db, $user_id) {
        $this->db = $db;
        $this->user_id = $user_id;
    }

    public function get_all_teams () {

        $q = "SELECT * FROM `teams` WHERE `team_user_id` = '$this->user_id'";

        $s = $this->db->prepare($q);
        
        if ($s->execute()) {
            if ($s->rowCount() > 0) {
                return $s->fetchAll();
            }
        }
        return [];
    }

    public function get_team_by ($column, $value, $multiple = false)
    {
        $s = $this->db->prepare("SELECT * FROM `teams` WHERE `$column` = :v AND `team_user_id` = '$this->user_id'");
        $s->bindParam(":v", $value);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }


    public function get_game_by ($column, $value, $multiple = false)
    {
        $s = $this->db->prepare("SELECT * FROM `games` JOIN `teams` ON `game_team_id`=`team_id` WHERE `$column` = :v AND `team_user_id` = '$this->user_id'");
        $s->bindParam(":v", $value);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }



    public function get_team_players ($team_id)
    {
        $s = $this->db->prepare("SELECT * FROM `players` WHERE `player_team_id` = :t");
        $s->bindParam(":t", $team_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function add_round($game_id, $round_number, $players)
    {
        
        $s = $this->db->prepare("INSERT INTO `rounds` (`round_game_id`, `round_number`, `round_created`) VALUE (:g, :r, :dt)");

        $s->bindParam(":g", $game_id);
        $s->bindParam(":r", $round_number);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);

        if ($s->execute()) {

            $player_values = " ";
            foreach ($players as $key => $player) {
                if ($key > 0) {
                    $player_values .= ", ";
                }
                $player_values .= "(:r, '".$player['player_id']."',:dt)";
            }

            $round_id = $this->db->lastInsertId();

            $q = "INSERT INTO `results` (`result_round_id`, `result_player_id`, `result_created`) VALUES";
            $q .= $player_values;

            $s = $this->db->prepare($q);
            $s->bindParam(":r", $round_id);
            $datetime = current_date();
            $s->bindParam(":dt", $datetime);

            if ($s->execute()) {
                return $this->result(true, "Round have been added!");
            } else {
                return $this->result(true, "Round added, couldn't add players");
            }

        }

        return $this->result(false);

    }

    public function add_team($name, $members)
    {

        $team = $this->get_team_by("team_name", $name);

        if ($team && !empty($team)) {
            return $this->result(false, "Team name already exists");
        }

        $valid = false;
        $member_values = "";
        foreach ($members as $member) {
            if (!empty(normal_text($member))) {
                if ($valid) {
                    $member_values .= ", ";
                }
                $valid = true;
                $member_values .= "(:t, '".normal_text($member)."', '".current_date()."')";
            }
        }
        if (!$valid) {
            return $this->result(false, "Provide at least one team member");
        }

        
        $s = $this->db->prepare("INSERT INTO `teams` (`team_name`, `team_user_id`, `team_created`) VALUE (:n, :i, :c)");
        $s->bindParam(":n", $name);
        $s->bindParam(":i", $this->user_id);
        $datetime = current_date();
        $s->bindParam(":c", $datetime);

        if ($s->execute()) {
            $team_id = $this->db->lastInsertId();

            $q = "INSERT INTO `players` (`player_team_id`, `player_name`, `player_created`) VALUES ";
            $q .= $member_values;

            $s = $this->db->prepare($q);
            $s->bindParam(":t", $team_id);

            if ($s->execute()) {
                return $this->result(true, "Team have been added!");
            } else {
                return $this->result(true, "Team added, but members couldn't be added.");
            }

        }

    }

    public function get_all_games_rounds($team_id)
    {
        $games = $this->get_all_games($team_id);

        foreach ($games as $key => $game) {
            $games[$key]['rounds'] = $this->get_round_by('round_game_id', $game['game_id'], true);
        }
        
        return $games;
    }

    public function get_round_by ($column, $value, $multiple = false)  {
        $s = $this->db->prepare("SELECT * FROM `rounds` WHERE `$column` = :v");
        $s->bindParam(":v", $value);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }

    public function get_all_games($team_id)
    {
        $s = $this->db->prepare("SELECT * FROM `games` WHERE `game_team_id` = :t");
        $s->bindParam(":t", $team_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function add_game($team_id)
    {
        $s = $this->db->prepare("INSERT INTO `games` (`game_team_id`, `game_created`) VALUE (:t, :dt)");
        $s->bindParam(":t", $team_id);
        $current_date = current_date();
        $s->bindParam(":dt", $current_date);

        if ($s->execute()) {
            return $this->result(true, $this->db->lastInsertId());
        }

        return $this->result(false);
    }

    private function result($status, $message = "")
    {
        return ['status' => $status, 'message' => $message];
    }

}
