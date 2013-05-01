<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ItemBased {
    
    function cosineSimilarity($item1ratings, $item2ratings)
    {
        $n = $sum1 = $similarity = $sumSq1 = $sumSq2 = $product = 0;
        foreach($item1ratings as $user => $score) {
                if(!isset($item2ratings[$user])) {
                        continue;
                }
                
                $n++;
                $sum1 += $score * $item2ratings[$user];                
                $sumSq1 += pow($score, 2);
                $sumSq2 += pow($item2ratings[$user], 2); 
                
        }
        $product = sqrt($sumSq1) * sqrt($sumSq2);
        if($sum1>0)
            $similarity = $sum1 / $product;
        
        return $similarity;
    }
    
    function pearson($item1ratings, $item2ratings) {
        $n = $sum1 = $sum2 = $sumSq1 = $sumSq2 = $product = 0;

        foreach($item1ratings as $user => $score) {
                if(!isset($item2ratings[$user])) {
                        continue;
                }
                
                $n++;
                $sum1 += $score;
                $sum2 += $item2ratings[$user];
                $sumSq1 += pow($score, 2);
                $sumSq2 += pow($item2ratings[$user], 2); 
                $product += $score * $item2ratings[$user];
        }

        // No shared ratings, so the similarity is 0
        // May want to tweak this to have a different minimum
        if($n == 0) {
                return 0;
        }

        // Work out the actual score
        $num = $product - (($sum1* $sum2)/$n);
        $den = sqrt(($sumSq1-pow($sum1, 2) / $n) * ($sumSq2 - pow($sum2, 2)/$n));

        if($den == 0) {
                return 0;
        }

        return $num/$den;
    }
    
    public function transformPreferences($preferences)
    {
        $result = array();        
        foreach($preferences as $otherPerson => $values)
        {
            foreach($values as $key => $value)
            {
                $result[$key][$otherPerson] = $value;
            }
        }
        
        return $result;
    }


    function generateSimilarities($data) {
        $similarities = array();
        foreach($data as $item => $scores) {
                $similarities[$item] = array();

                foreach($data as $item2 => $scores2) {
                        if($item2 == $item || isset($similarities[$item][$item2])) {
                                continue;
                        }

                        $sim = $this->cosineSimilarity($scores, $scores2);
                        if($sim > 0) { // minimum similarity 
                                $similarities[$item][$item2] = $sim;
                                $similarities[$item2][$item] = $sim;
                        }
                }
                arsort($similarities[$item]);
        }
        return $similarities;
    }
    
    function getSimilar($item, $similarities) {
                $val = each($similarities[$item]);
                return $val['key'];
    }    
    
    function getUserByMK($mk)
    {
        $query = "SELECT id_user FROM `rs_review` WHERE id_mk = (SELECT id_mk FROM rs_matakuliah WHERE nama_mk = \"".$mk."\")";
        $result = mysql_query($query);
        $users = array();
        while ($row = mysql_fetch_array($result)) 
        {
            $users[] = $row{'id_user'};            
        }
        //echo "<br> Ini pengguna";
        //print_r($users);
        
        return $users;
    }
    
    function getRatingByUserMK($user,$mk)
    {
        $query = "SELECT rating FROM `rs_review` WHERE id_mk = (SELECT id_mk FROM rs_matakuliah WHERE nama_mk = \"".$mk."\") AND id_user = ".$user;
        $result = mysql_query($query);
        $ratings = mysql_fetch_array($result);
        $rating = $ratings{'rating'};
        return $rating;
    }
    
    function accuration($user, $data, $similarities, $mk) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $out = array();
        $items = array();
        $sims = array();
        /*Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach($data as $item => $scores) {
                if(isset($scores[$user])) {
                    if($item == $mk)
                    {
                        continue;
                    }else
                    {
                        $items[$item] = $scores[$user];
                    }
                }
        }
        //print_r($items);
        foreach($items as $item => $score) {
            foreach($similarities[$item] as $sim_item => $sim) {                    
               // echo "<br>";
                //echo $sim_item." ".$sim." ".$item;
                if(isset($items[$sim_item])) {
                        continue; // they already rated this
                }

                if(!array_key_exists($sim_item,$out)) {
   /*error*/                     $out[$sim_item] == 0;
                }
  /*error*/             $out[$sim_item] += $sim * $score;                                                                                          
  /*error*/             $sims[$sim_item] += $sim;
                }
        }
        
        foreach($out as $item => $score) {
                $out[$item] = $score / $sims[$item];
        }

        arsort($out);
        return $out[$mk]; // return top n
    }
    
    function recommend($user, $data, $similarities, $top) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $out = array();
        $items = array();
        $sims = array();
        /*Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach($data as $item => $scores) {
                if(isset($scores[$user])) {
                        $items[$item] = $scores[$user];
                }
        }
        print_r($items);
        foreach($items as $item => $score) {
                foreach($similarities[$item] as $sim_item => $sim) {                    
                        echo "<br>";
                        echo $sim_item." ".$sim." ".$item;
                        if(isset($items[$sim_item])) {
                                continue; // they already rated this
                        }
                        
                        if(!array_key_exists($sim_item,$out)) {
           /*error*/                     $out[$sim_item] == 0;
                        }
          /*error*/             $out[$sim_item] += $sim * $score;                                                                                          
          /*error*/             $sims[$sim_item] += $sim;
                }
        }
        
        foreach($out as $item => $score) {
                $out[$item] = $score / $sims[$item];
        }

        arsort($out);
        return array_slice($out, 0, $top); // return top n
    }
}


?>
