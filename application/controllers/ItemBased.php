<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ItemBased {

    function cosineSimilarity($item1ratings, $item2ratings) {

        $n = $sum1 = $similarity = $sumSq1 = $sumSq2 = $product = 0;
        foreach ($item1ratings as $user => $score) {
            if (!isset($item2ratings[$user])) {
                continue;
            }
            $n++;
            $sum1 += $score * $item2ratings[$user];
            $sumSq1 += pow($score, 2);
            $sumSq2 += pow($item2ratings[$user], 2);
            //echo "<br>user ".$user." score ".$score." score $item2ratings[$user]";
        }
        $product = sqrt($sumSq1) * sqrt($sumSq2);
        if ($sum1 > 0)
            $similarity = $sum1 / $product;

        return $similarity;
    }

    function pearson($item1ratings, $item2ratings) {
        $n = $sum1 = $sum2 = $sumSq1 = $sumSq2 = $product = 0;

        foreach ($item1ratings as $user => $score) {
            if (!isset($item2ratings[$user])) {
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
        if ($n == 0) {
            return 0;
        }

        // Work out the actual score
        $num = $product - (($sum1 * $sum2) / $n);
        $den = sqrt(($sumSq1 - pow($sum1, 2) / $n) * ($sumSq2 - pow($sum2, 2) / $n));

        if ($den == 0) {
            return 0;
        }

        return $num / $den;
    }

    public function transformPreferences($preferences) {
        $result = array();
        foreach ($preferences as $otherPerson => $values) {
            foreach ($values as $key => $value) {
                $result[$key][$otherPerson] = $value;
            }
        }

        return $result;
    }

    function generateSimilarities($data) {
        $similarities = array();
        foreach ($data as $item => $scores) {
            $similarities[$item] = array();

            foreach ($data as $item2 => $scores2) {
                if ($item2 == $item || isset($similarities[$item][$item2])) {
                    continue;
                }
                //echo "<br> mk1 : $item mk2 : $item2";
                $sim = $this->cosineSimilarity($scores, $scores2);
                if ($sim > 0) {
                    // minimal similarity
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

    function getUserByMK($mk) {
        $query = "SELECT id_user FROM `rs_review` WHERE id_mk = (SELECT id_mk FROM rs_matakuliah WHERE nama_mk = \"" . $mk . "\")";
        $result = mysql_query($query);
        $users = array();
        while ($row = mysql_fetch_array($result)) {
            $users[] = $row{'id_user'};
        }
        //echo "<br> Ini pengguna";
        //print_r($users);

        return $users;
    }

    function getRatingByUserMK($user, $mk) {
        $query = "SELECT rating FROM `rs_review` WHERE id_mk = (SELECT id_mk FROM rs_matakuliah WHERE nama_mk = \"" . $mk . "\") AND id_user = " . $user;
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
        /* Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach ($data as $item => $scores) {
            if (isset($scores[$user])) {
                if ($item == $mk) {
                    continue;
                } else {
                    $items[$item] = $scores[$user];
                }
            }
        }
        //print_r($items);

        foreach ($items as $item => $score) {
            foreach ($similarities[$item] as $sim_item => $sim) {
                //echo "<br>";
                //echo $sim_item." ".$sim." ".$item;
                if (isset($items[$sim_item])) {
                    continue; // they already rated this
                }

                if (!array_key_exists($sim_item, $out)) {
                    /* error */ $out[$sim_item] == 0;
                }
                /* error */ $out[$sim_item] += $sim * $score;
                /* error */ $sims[$sim_item] += $sim;
            }
        }
        foreach ($out as $item => $score) {
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
        /* Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach ($data as $item => $scores) {
            if (isset($scores[$user])) {
                $items[$item] = $scores[$user];
            }
        }
        //print_r($items);
        //echo "<table border=\"1px\">";
        /*
         * mencari similarities antara item yang sudah dirating         
         */
        foreach ($items as $item => $score) {
            //echo "<tr><td></td><td>".$item."</td></tr>";
            foreach ($similarities[$item] as $sim_item => $sim) {

                //echo "<tr><td>".$sim_item."</td><td> ".$sim."</td></tr>";
                if (isset($items[$sim_item])) {
                    continue; // jika sudah dirating
                }

                if (!array_key_exists($sim_item, $out)) {
                    /* error */ $out[$sim_item] == 0;
                }
                /* error */ $out[$sim_item] += $sim * $score;
                /* error */ $sims[$sim_item] += $sim;
            }
        }
        //echo "</table>";        
        foreach ($out as $item => $score) {
            $out[$item] = $score / $sims[$item];
        }

        arsort($out);
        //print_r($out);
        return array_slice($out, 0, $top); // return top n
    }

    function user_full_filter_recommend($user, $data, $similarities, $top) {
        //echo "FULL FILYTER";
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $out = array();
        $items = array();
        $sims = array();
        /* Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach ($data as $item => $scores) {
            if (isset($scores[$user])) {
                $items[$item] = $scores[$user];
            }
        }
        //print_r($items);
        //echo "<table border=\"1px\">";
        /*
         * mencari similarities antara item yang sudah dirating         
         */
        foreach ($items as $item => $score) {
            //echo "<tr><td></td><td>".$item."</td></tr>";
            foreach ($similarities[$item] as $sim_item => $sim) {

                //echo "<tr><td>".$sim_item."</td><td> ".$sim."</td></tr>";
                /* if (isset($items[$sim_item])) {
                  continue; // jika sudah dirating
                  } */

                if (!array_key_exists($sim_item, $out)) {
                    /* error */ $out[$sim_item] == 0;
                }
                /* error */ $out[$sim_item] += $sim * $score;
                /* error */ $sims[$sim_item] += $sim;
            }
        }
        //echo "</table>";        
        foreach ($out as $item => $score) {
            $out[$item] = $score / $sims[$item];
        }
        //$prereq = array();
        foreach ($out as $item => $score) {
            $query = "SELECT DISTINCT `prereq`, MAX(rs_histori_nilai.rating) rating
                    FROM `rs_matakuliah`, rs_histori_nilai 
                    WHERE rs_matakuliah.`nama_mk`= '" . $item . "' 
                    AND rs_histori_nilai.id_user=" . $user . " 
                    AND rs_matakuliah.prereq = rs_histori_nilai.id_mk";
            //$out[$item] = $score / $sims[$item];
            $result = mysql_query($query);
            while ($row = mysql_fetch_array($result)) {
                //$prereq[$item] = $row{'rating'};
                if ($row{'rating'} >= 3 || $row{'rating'} == NULL) {
                    //echo "AMAN";

                    $out[$item] = array('status' => "lulus", 'score' => $score, 'rekomendasi' => NULL);
                    //$out[$item]['status']="aman";
                    if ($row{'rating'} >= 4) {
                        $out[$item]['rekomendasi'] = "direkomendasikan";
                    }
                } else {
                    $out[$item] = array('status' => "belum lulus", 'score' => $score, 'rekomendasi' => NULL);
                    //$out[$item]['status']="tidak aman";
                }
                //echo "<br>TEST ".$out[$item];
            }
        }
        arsort($out, SORT_REGULAR);

        //print_r($out);
        //echo "<br><br>";
        //print_r($prereq);
        return array_slice($out, 0, $top); // return top n
    }

    function filter_mk($out,$user)
    {
        foreach ($out as $item => $score) {
            $query = "SELECT DISTINCT (SELECT `prereq`
                    FROM `rs_matakuliah`
                    WHERE rs_matakuliah.`nama_mk`= '".$item."') prereq, MAX(rs_histori_nilai.rating) rating
                    FROM `rs_matakuliah`, rs_histori_nilai 
                    WHERE rs_matakuliah.`nama_mk`= '".$item."' 
                    AND rs_histori_nilai.id_user=".$user."
                    AND rs_matakuliah.prereq = rs_histori_nilai.id_mk";
            //$out[$item] = $score / $sims[$item];
            $result = mysql_query($query);
            while ($row = mysql_fetch_array($result)) {
                //$prereq[$item] = $row{'rating'};
                if ($row{'rating'} >= 4 && $row{'prereq'} != NULL) {
                    //echo "AMAN";
                    $out[$item] = array('status' => "lulus", 'score' => $score, 'rekomendasi' => "direkomendasikan");
                    //$out[$item]['status']="aman";                        
                    //$out[$item]['rekomendasi'] = "direkomendasikan";
                } else
                if ($row{'rating'} < 4 && $row{'prereq'} != NULL) {
                    $out[$item] = array('status' => "lulus", 'score' => $score, 'rekomendasi' => NULL);
                    //$out[$item]['status']="tidak aman";
                } else
                if ($row{'rating'} == null && $row{'prereq'} != NULL) {
                    $out[$item] = array('status' => "belum lulus", 'score' => $score, 'rekomendasi' => NULL);
                }
                else if($row{'prereq'} == NULL)
                {
                    $out[$item] = array('status' => "kosong", 'score' => $score, 'rekomendasi' => NULL);
                }
                //echo "<br>TEST ".$out[$item];
            }
        }
        return $out;
    }


    function filter_recommend($user, $data, $similarities, $top) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $out = array();
        $items = array();
        $sims = array();
        /* Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach ($data as $item => $scores) {
            if (isset($scores[$user])) {
                $items[$item] = $scores[$user];
            }
        }
        //print_r($items);
        //echo "<table border=\"1px\">";
        /*
         * mencari similarities antara item yang sudah dirating         
         */
        foreach ($items as $item => $score) {
            //echo "<tr><td></td><td>".$item."</td></tr>";
            foreach ($similarities[$item] as $sim_item => $sim) {

                //echo "<tr><td>".$sim_item."</td><td> ".$sim."</td></tr>";
                if (isset($items[$sim_item])) {
                    continue; // jika sudah dirating
                }

                if (!array_key_exists($sim_item, $out)) {
                    /* error */ $out[$sim_item] == 0;
                }
                /* error */ $out[$sim_item] += $sim * $score;
                /* error */ $sims[$sim_item] += $sim;
            }
        }
        //echo "</table>";        
        foreach ($out as $item => $score) {
            $out[$item] = $score / $sims[$item];
        }
        //$prereq = array();
        $outie = $this->filter_mk($out, $user);
        arsort($outie, SORT_REGULAR);
        //print_r($out);
        //echo "<br><br>";
        //print_r($prereq);
        return array_slice($outie, 0, $top); // return top n
    }

    function full_filter_recommend($user, $data, $similarities, $top) {
        /*
         * Untuk akurasi
         */
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $out = array();
        $items = array();
        $sims = array();
        /* Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach ($data as $item => $scores) {
            if (isset($scores[$user])) {
                $items[$item] = $scores[$user];
            }
        }
        //print_r($items);
        //echo "<table border=\"1px\">";
        /*
         * mencari similarities antara item yang sudah dirating         
         */
        foreach ($items as $item => $score) {
            //echo "<tr><td></td><td>".$item."</td></tr>";
            foreach ($similarities[$item] as $sim_item => $sim) {

                //echo "<tr><td>".$sim_item."</td><td> ".$sim."</td></tr>";
                /* if (isset($items[$sim_item])) {
                  continue; // jika sudah dirating
                  } */

                if (!array_key_exists($sim_item, $out)) {
                    /* error */ $out[$sim_item] == 0;
                }
                /* error */ $out[$sim_item] += $sim * $score;
                /* error */ $sims[$sim_item] += $sim;
            }
        }
        //echo "</table>";        
        foreach ($out as $item => $score) {
            $out[$item] = $score / $sims[$item];
        }
        //$prereq = array();
        $outie=$this->filter_mk($out, $user);
        arsort($outie, SORT_REGULAR);

        //echo "<br>$user<br>";
        //print_r($out);        
        //print_r($prereq);$key_out = array();
        foreach ($outie as $item => $score) {
            $key_out[] = $item;
        }
        //echo "<br>$user<br>";
        //print_r($key_out);
        //arsort($key_out);
        return array_slice($key_out, 0, $top);
    }

    function full_recommend($user, $data, $similarities, $top) {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $out = array();
        $items = array();
        $sims = array();
        /* Mencari item yang telah dirating oleh pengguna
         * dan memasukkannya ke dalam array items[]
         */
        foreach ($data as $item => $scores) {
            if (isset($scores[$user])) {
                $items[$item] = $scores[$user];
            }
        }
        //print_r($items);
        foreach ($items as $item => $score) {
            foreach ($similarities[$item] as $sim_item => $sim) {
                /*
                 * echo "<br>";                        
                 * echo $sim_item." ".$sim." ".$item; */
                if (!array_key_exists($sim_item, $out)) {
                    /* error */ $out[$sim_item] == 0;
                }
                /* error */ $out[$sim_item] += $sim * $score;
                /* error */ $sims[$sim_item] += $sim;
            }
        }
        $key_out = array();
        foreach ($out as $item => $score) {
            $key_out[] = $item;
        }

        arsort($key_out);
        return array_slice($key_out, 0, $top); // return top n
    }

}

?>
