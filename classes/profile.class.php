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
        $s = $this->db->prepare("SELECT * FROM `players` WHERE `player_team_id` = :t AND `player_status` = 'A'");
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
                return ['status' => true, 'message' => "Round has been started!", 'round_id' => $round_id];
            } else {
                return ['status' => true, 'message' => "Round added, couldn't add players", 'round_id' => $round_id];
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

    public function add_player($name, $team_id)
    {
        $q = "INSERT INTO `players` (`player_team_id`, `player_name`, `player_created`) VALUE (:t, :n, :dt)";
        $s = $this->db->prepare($q);
        $s->bindParam(":t", $team_id);
        $s->bindParam(":n", $name);
        $datetime = current_date();
        $s->bindParam(":dt", $datetime);
        if ($s->execute()) {
            return $this->result(true, "Player has been added!");
        }
        return $this->result(false, "Player cannot be added.");
    }

    public function rename_player($name, $player_id, $team_id)
    {
        $q = "UPDATE `players` SET `player_name` = :n WHERE `player_id` = :i AND `player_team_id` = :t";
        $s = $this->db->prepare($q);
        $s->bindParam(":n", $name);
        $s->bindParam(":i", $player_id);
        $s->bindParam(":t", $team_id);
        if ($s->execute()) {
            return $this->result(true, "Player name has been updated!");
        }
        return $this->result(false, "Player name cannot be updated.");
    }

    public function delete_player($player_id, $team_id)
    {
        $q = "UPDATE `players` SET `player_status` = 'D' WHERE `player_id` = :i AND `player_team_id` = :t";
        $s = $this->db->prepare($q);
        $s->bindParam(":i", $player_id);
        $s->bindParam(":t", $team_id);
        if ($s->execute()) {
            return $this->result(true, "Player has been deleted!");
        }
        return $this->result(false, "Player cannot be deleted.");
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
        $s = $this->db->prepare("SELECT * FROM `rounds` r JOIN `games` g ON r.round_game_id = g.game_id JOIN `teams` t ON g.game_team_id = t.team_id WHERE `$column` = :v");
        $s->bindParam(":v", $value);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }

    public function player_found($result_id, $results)
    {
        // calculating position
        $position = count($results);
        $available = false;
        foreach ($results as $result) {
            if ($result['result_id'] === $result_id) {
                if ($result['result_found'] === 'Y') {
                    return $this->result(false, "You already found this player.");
                }
                $available = true;
            } 
            if ($result['result_found'] === 'Y') {
                $position--;
            }
        }

        if (!$available) {
            return $this->result(false, "Player is not available.");
        }

        // assigning score
        $score = 0;
        if ($position === 1) {
            $score += 3;
        }
        if ($position === 2) {
            $score += 2;
        }
        if ($position === 3) {
            $score += 1;
        }

        $s = $this->db->prepare("UPDATE `results` SET `result_found` = 'Y', `result_position` = '$position', `result_score` = '$score', `result_found_on` = :dt WHERE `result_id` = :i");
        $current_date = current_date();
        $s->bindParam(":i", $result_id);
        $s->bindParam(":dt", $current_date);

        if ($s->execute()) {

            if ($position === 1) {
                $s = $this->db->prepare("UPDATE `rounds` SET `round_status` = 'E' WHERE `round_id` = :r");
                $s->bindParam(":r", $results[0]['round_id']);
                $s->execute();
                return $this->result(true, "Result has been updated and round is over!");
            }

            return $this->result(true, "Result has been updated");
        }

        return $this->result(false, "Couldn't update the result");
    }

    public function end_rounds($game_id)
    {
        $s = $this->db->prepare("UPDATE `rounds` SET `round_status` = 'E' WHERE `round_game_id` = :g AND `round_status` = 'A'");
        $s->bindParam(":g", $game_id);

        if ($s->execute()) {
            return $this->result(true);
        }
        return $this->result(false, "Rounds cannot be updated");
    }

    public function end_game($game_id)
    {
        $s = $this->db->prepare("UPDATE `games` SET `game_status` = 'E', `game_ended` = :dt WHERE `game_id` = :g AND `game_status` = 'A'");
        $current_date = current_date();
        $s->bindParam(":dt", $current_date);
        $s->bindParam(":g", $game_id);

        if ($s->execute()) {
            return $this->result(true, "Game-ID#".$game_id." has been updated");
        }
        return $this->result(false, "Game-ID#".$game_id." cannot be updated");
    }

    public function get_result_by ($column, $value, $multiple = false)  {
        $s = $this->db->prepare("SELECT * FROM `results` rs JOIN `rounds` ro ON rs.result_round_id = ro.round_id JOIN `players` pl ON rs.result_player_id = pl.player_id  WHERE `$column` = :v");
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
        $s = $this->db->prepare("SELECT * FROM `games` WHERE `game_team_id` = :t ORDER BY `game_id` DESC");
        $s->bindParam(":t", $team_id);
        if ($s->execute()) {
            return $s->fetchAll();
        }
        return [];
    }

    public function player_score($player_id)
    {
        $s = $this->db->prepare("SELECT * FROM `results` WHERE `result_player_id` = :pid");
        $s->bindParam(":pid", $player_id);

        if ($s->execute() && $s->rowCount() > 0) {
            
            $rows = $s->fetchAll();
            $score = 0;
            foreach ($rows as $row) {
                if ($row['result_score'] && $row['result_score'] > 0) {
                    $score += $row['result_score']; 
                }
            }
            return $score;
        }
        return 0;
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
