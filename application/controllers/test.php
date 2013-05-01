<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php                       
            //Mendapatkan rekomendasi
            require_once 'ItemBased.php';
            $result = mysql_query(
                    "SELECT `id_user`, `rating`,`nama_mk` 
                    FROM `rs_review`,`rs_matakuliah`
                    WHERE `rs_matakuliah`.`id_mk` = `rs_review`.`id_mk` and `rating` > 0 
                    ORDER BY `rs_review`.`id_user` ASC;");
            $ratings = array();
            while ($row = mysql_fetch_array($result)) 
            {
                $userID = $row{'id_user'};
                $ratings[$userID][$row{'nama_mk'}] =  $row{'rating'};               
            }
            //print_r($ratings);
            //echo "<br>";
            $recommend = new ItemBased();
            $transform = $recommend->transformPreferences($ratings);                    
            $similiarity = $recommend->generateSimilarities($transform);
            $recom = $recommend->recommend(1, $transform, $similiarity,10);
            print_r($recom);
            //$data['recom'] = $recom;
            //$this->load->view('header');
            //$this->load->view('user/user_view_rekomendasi', $data);
            //$this->load->view('footer');
        ?>
    </body>
</html>
