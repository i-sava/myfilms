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

    if($similar==0)
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
function getRecommendation($matrix, $person)
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

    print_r($total);
    echo '<br>';
    print_r($simsums);
    echo '<br>';

    foreach ($total as $key=>$value)
    {
        $ranks[$key]= round(  $value/$simsums[$key], 3);
    }
    //array_multisort($ranks,SORT_DESC);

    uasort($ranks, 'cmp');
    //print_r($ranks);


    return $ranks;

}

?>