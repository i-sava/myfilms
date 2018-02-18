<?php


function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}


function similarity_distance($matrix,$person1,$person2)
{
    $similar=array();
    $sum=0;

    foreach ($matrix[$person1] as $key=>$value)
    {
        if(array_key_exists($key,$matrix[$person2]))
        {
            $similar[$key]=1;
        }
    }

    if(empty($similar))
    {
        return 0;
    }

    foreach ($matrix[$person1] as $key=>$value)
    {
        if(array_key_exists($key,$matrix[$person2]))
        {
            $sum=$sum+pow($value-$matrix[$person2][$key],2);
        }
    }
    return 1/(1+sqrt($sum));
}


/**
 * @param $matrix
 * @param $person
 * @return array
 */


function getMatrixKNN($matrix, $person, $k)
{
    $user_KNN=getSimilar($matrix, $person, $k);
    $result=array_intersect_key($matrix,$user_KNN);
    $result[$person]=$matrix[$person];

    return $result;
}







function getRecommendation($matrix, $person, $m)
{
    $total=array();
    $simsums=array();
    $ranks=array();

    foreach ($matrix as $otherPerson=>$value)
    {
        if($otherPerson!=$person)
        {
            $sim=similarity_distance($matrix,$person,$otherPerson);
            $sim=round($sim,3);
            //var_dump($sim);

            foreach ($matrix[$otherPerson] as $key=>$value)
            {
                if(!array_key_exists($key,$matrix[$person]))
                {

                    if(!array_key_exists($key,$total))
                    {
                        $total[$key]=0;
                    }
                    $total[$key]+=$matrix[$otherPerson][$key]*$sim;

                    if(!array_key_exists($key,$simsums))
                    {
                        $simsums[$key]=0;
                    }
                    $simsums[$key]+=$sim;

                }
            }
        }
    }

    //print_r($total);
    //echo '<br>';
    //print_r($simsums);
    //echo '<br>';

    foreach ($total as $key=>$value)
    {
        if($simsums[$key] != 0)
        {
            $ranks[$key]= round(  $value/$simsums[$key], 3);
        }


    }
    //array_multisort($ranks,SORT_DESC);

    uasort($ranks, 'cmp');

    $recom_film = array_slice($ranks, 0, $m, true);

    echo '<table class="table table-bordered table-striped">';
        echo '<thead class="text-danger">';
        echo '<th class="text-uppercase text-center"> Title film  </th>' .  '<th class="text-uppercase text-center"> Predicted score </th>';
        echo '</thead>';
        foreach ($recom_film as $film=>$value) {
            echo '<tr>';
            echo '<td class="text-uppercase text-center">' . $film . '</td>' .  '<td class="text-uppercase text-center">' . $value . '</td>';
            echo '</tr>';
        }

    echo '</table>';

    echo '<br>';
    //print_r($recom_film);
    echo '<br>';


    return $recom_film;

}



function getSimilar($matrix, $person, $k)
{

    $similarity=array();
    foreach ($matrix as $otherPerson=>$value)
    {
        if($otherPerson!=$person)
        {
            $sim=similarity_distance($matrix,$person,$otherPerson);
            $sim=round($sim,3);
            $similarity[$otherPerson]=$sim;
        }


    }
    uasort($similarity, 'cmp');
    $similarity_users = array_slice($similarity, 0, $k, true);
    return $similarity_users;
}



?>