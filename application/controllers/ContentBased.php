<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContentBased
 *
 * @author Herdi Naufal
 */
define("DOC_ID", 0);
define("TERM_POSITION", 1);

class ContentBased {

    function getHistory($userID) {
        //$userID = 31;
        $query = "SELECT deskripsi FROM `rs_histori_nilai`, `rs_mk_wajib` WHERE `id_user` = " . $userID . " AND `rating` >= 4 AND `rs_histori_nilai`.`id_mk` = `rs_mk_wajib`.`id_mk`";
        $result = mysql_query($query) or die("<br/><br/>" . mysql_error());
        $historyMK = array();
        while ($row = mysql_fetch_array($result)) {
            $historyMK[] = $row{'deskripsi'};
        }
        if ($historyMK == NULL) {
            return $queryMK = NULL;
        } else {
            $joint = implode(" ", $historyMK);
            $merge = explode(" ", $joint);
            $queryMK = array_values(array_unique($merge));

            return $queryMK;
        }
    }

    function getHistoryA($userID) {
        //$userID = 31;
        $query = "SELECT deskripsi FROM `rs_histori_nilai`, `rs_mk_wajib` WHERE `id_user` = " . $userID . " AND `rating` > 4 AND `rs_histori_nilai`.`id_mk` = `rs_mk_wajib`.`id_mk`";
        $result = mysql_query($query) or die("<br/><br/>" . mysql_error());
        $historyMK = array();
        while ($row = mysql_fetch_array($result)) {
            $historyMK[] = $row{'deskripsi'};
        }
        if ($historyMK == NULL) {
            return $queryMK = NULL;
        } else {
            $joint = implode(" ", $historyMK);
            $merge = explode(" ", $joint);
            $queryMK = array_values(array_unique($merge));

            return $queryMK;
        }
    }
    
    function normalise($doc) {
        foreach ($doc as $entry) {
            $total += $entry * $entry;
        }
        $total = sqrt($total);
        foreach ($doc as &$entry) {
            $entry = $entry / $total;
        }
        return $doc;
    }

    function getIndexTest() {
        $collection = array(
            1 => 'this string is a short string but a good string',
            2 => 'this one isn\'t quite like the rest but is here',
            3 => 'this is a different short string that\' not as short'
        );

        $dictionary = array();
        $docCount = array();

        foreach ($collection as $docID => $doc) {
            $terms = explode(' ', $doc);
            $docCount[$docID] = count($terms);

            foreach ($terms as $term) {
                if (!isset($dictionary[$term])) {
                    $dictionary[$term] = array('df' => 0, 'postings' => array());
                }
                if (!isset($dictionary[$term]['postings'][$docID])) {
                    $dictionary[$term]['df']++;
                    $dictionary[$term]['postings'][$docID] = array('tf' => 0);
                }

                $dictionary[$term]['postings'][$docID]['tf']++;
            }
        }

        return array('docCount' => $docCount, 'dictionary' => $dictionary);
    }

    function getIndex($collection) {

        $dictionary = array();
        $docCount = array();

        foreach ($collection as $docID => $doc) {
            $terms = explode(' ', $doc);
            $docCount[$docID] = count($terms);

            foreach ($terms as $term) {
                if (!isset($dictionary[$term])) {
                    $dictionary[$term] = array('df' => 0, 'postings' => array());
                }
                if (!isset($dictionary[$term]['postings'][$docID])) {
                    $dictionary[$term]['df']++;
                    $dictionary[$term]['postings'][$docID] = array('tf' => 0);
                }

                $dictionary[$term]['postings'][$docID]['tf']++;
            }
        }

        return array('docCount' => $docCount, 'dictionary' => $dictionary);
    }

    function getuserMkRating($userID) {
        $string_query = "SELECT `nama_mk`, `rating`, `deskripsi` FROM `rs_review`,`rs_matakuliah` WHERE `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk` AND `rs_review`.`id_user` = " . $userID;
        $result = mysql_query($string_query) or die("<br/><br/>" . mysql_error());
        $rating = array();
        while ($row = mysql_fetch_array($result)) {
            //$mkID = $row{'nama_mk'};
            //$rating[$mkID] = $row{'deskripsi'};
            $rating[] = $row{'nama_mk'};
        }
        return $rating;
    }

    function getIndexAcc() {
        /* $collection = array(
          1 => 'this string is a short string but a good string',
          2 => 'this one isn\'t quite like the rest but is here',
          3 => 'this is a different short string that\' not as short'
          ); */
        //$userID = 31;
        $string_query = "SELECT * FROM `rs_matakuliah`";
        $result = mysql_query($string_query) or die("<br/><br/>" . mysql_error());
        $collection = array();
        while ($row = mysql_fetch_array($result)) {
            $mkID = $row{'nama_mk'};
            $collection[$mkID] = $row{'deskripsi'};
        }
        //print_r($collection);

        $dictionary = array();
        $docCount = array();

        foreach ($collection as $docID => $doc) {
            $terms = explode(' ', $doc);
            $docCount[$docID] = count($terms);

            foreach ($terms as $term) {
                if (!isset($dictionary[$term])) {
                    $dictionary[$term] = array('df' => 0, 'postings' => array());
                }
                if (!isset($dictionary[$term]['postings'][$docID])) {
                    $dictionary[$term]['df']++;
                    $dictionary[$term]['postings'][$docID] = array('tf' => 0);
                }

                $dictionary[$term]['postings'][$docID]['tf']++;
            }
        }

        return array('docCount' => $docCount, 'dictionary' => $dictionary);
    }

    function getIndexCol($userID) {
        /*
         * Mendapatkan daftar index mata kuliah pilihan, 
         * Fungsi ini yang digunakan pada proses rekomendasi.
         */
        //$userID = 31;
        // ambil data mata kuliah pilihan
        $string_query = "SELECT * FROM `rs_matakuliah` WHERE `id_mk` NOT IN (SELECT `id_mk` FROM `rs_review` WHERE `rs_review`.`id_user` = " . $userID . " AND `rs_review`.`id_mk` = `rs_matakuliah`.`id_mk`)";
        $result = mysql_query($string_query) or die("<br/><br/>" . mysql_error());
        $collection = array();
        //memasukkan hanya nama matakuliah dan deskripsi
        while ($row = mysql_fetch_array($result)) {
            $mkID = $row{'nama_mk'};
            $collection[$mkID] = $row{'deskripsi'};
        }
        //print_r($collection);

        //kamus
        $dictionary = array();
        //jumlah dokumen
        $docCount = array();

        // mata kuliah => nama mk & deskripsi
        foreach ($collection as $docID => $doc) {
            //memecah deskripsi jadi array
            $terms = explode(' ', $doc);
            //menghitung jumlah terms pada deskripsi
            //nama_mk = jumlah terms
            $docCount[$docID] = count($terms);

            foreach ($terms as $term) {
                if (!isset($dictionary[$term])) {
                    //masukkan tiap2 term ke dictionari, kalau belum ada
                    $dictionary[$term] = array('df' => 0, 'postings' => array());
                }
                if (!isset($dictionary[$term]['postings'][$docID])) {
                    //jika [term][posting][docID] belum di set
                    //jika term belum ada pada mk tertentu
                    //df untuk term ditambah
                    $dictionary[$term]['df']++;
                    //tf untuk mata kuliah tersenut diset 0
                    $dictionary[$term]['postings'][$docID] = array('tf' => 0);
                }
                //tf untuk setiap mata kuliah dan term ditambah
                $dictionary[$term]['postings'][$docID]['tf']++;
            }
        }
        //print_r($dictionary);
        return array('docCount' => $docCount, 'dictionary' => $dictionary);
    }

    function getTfidf($term, $collection) {
        $index = $this->getIndex($collection);
        $docCount = count($index['docCount']);
        if (array_key_exists($term, $index['dictionary'])) {
            $entry = $index['dictionary'][$term];
            foreach ($entry['postings'] as $docID => $postings) {
                echo "Document $docID and term $term give TFIDF: " .
                ($postings['tf'] * log($docCount / $entry['df'], 2));
                echo "\n <br>";
            }
        } else {
            echo "doesnt exists <br>";
        }
    }

}

?>
