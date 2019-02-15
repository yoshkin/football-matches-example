<?php
require_once __DIR__.'/data.php';

/**
 * @param int $min
 * @param int $max
 * @return float|int
 */
function randomFloat($min = 0, $max = 1) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

/**
 * @param array $team_1
 * @param array $team_2
 * @param float $rand_coef
 * @param bool $round
 * @return array
 */
function match(array $team_1, array $team_2, $rand_coef = 0.3, $round = true)
{
    $game_goals_1 = $team_1['goals']['scored'] / $team_1['games']
        * $team_2['goals']['skiped'] / $team_2['games'] ;
    $game_goals_2 = $team_2['goals']['scored'] / $team_2['games']
        * $team_1['goals']['skiped'] / $team_1['games'] ;

    //lucky ?
    $game_score_1 = $game_goals_1 * (1 + randomFloat(-$rand_coef, $rand_coef));
    $game_score_2 = $game_goals_2 * (1 + randomFloat(-$rand_coef, $rand_coef));

    //ext. time, penalti
    if (round($game_score_1) == round($game_score_2)) {
        $team = rand(0,2); // 1/3
        switch ($team) {// +/-1: do not change score balance
            case 1:
                $game_score_1 += rand(0, 1)? 1 : -1;
                break;
            case 2:
                $game_score_2 += rand(0, 1)? 1 : -1;
                break;
        }
    }

    return [
        $game_score_1 > 0 ? ($round ? (int)round($game_score_1) : $game_score_1) : 0,
        $game_score_2 > 0 ? ($round ? (int)round($game_score_2) : $game_score_2) : 0,
    ];
}
//var_dump(match($data[0], $data[2]));
//var_dump(match($data[0], $data[2]));
//var_dump(match($data[0], $data[2]));
//var_dump(match($data[0], $data[2]));