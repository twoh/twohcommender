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
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        include "ContentBased.php";

        //document yang sebagai percobaan        
        /* $D[0] = "this is a different short string that not as short";
          $D[1] = "this string is a short string but a good string";

          $key = 'this string is a short string but a good string';

          $collection = array(
          1 => 'this is a different short string that not as short',
          2 => 'this one isn\'t quite like the rest but is here',
          3 => 'this string is a short string but a good string'
          );

          $pieces1 = explode(" ", $key);
          //$pieces2 = explode(" ", $D[1]);
          //$results = array_intersect($pieces1, $pieces2);
          $result = array_values(array_unique($pieces1));
          $i = count($result);
          print_r($result);
          $ir = new ContentBased();
          for($j=0;$j<$i;$j++)
          {
          $ir->getTfidf($result[$j],$collection);
          }
         */

        
        //this string is a short string but a good string
        $query = array('this','short','string');
        $ir = new ContentBased();
        $index = $ir->getIndexTest();
        $matchDocs = array();
        $docCount = count($index['docCount']);

        foreach ($query as $qterm) {
            $entry = $index['dictionary'][$qterm];
            //echo $entry['dictionary'][$qterm];
            foreach ($entry['postings'] as $docID => $posting) {
                //if(!isset($matchDocs[$docID]))
                echo $qterm . "<br>";
                echo " (1) DocID : $docID tf :" . $posting['tf'] . " df " . $entry['df'] . " tfidf: " . $matchDocs[$docID] . "<br>";
                $matchDocs[$docID] +=
                        $posting['tf'] *
                        log($docCount/ $entry['df'], 2);                
                echo " (2) DocID : $docID tf :" . $posting['tf'] . " df " . $entry['df'] . " tfidf: " . $matchDocs[$docID] . "<br>";
            }
        }
        
         
        
        $matchDocs2= $ir->normalise($matchDocs);
        
        
        print_r($matchDocs2);
        // length normalise
        foreach ($matchDocs as $docID => $score) {
            $matchDocs[$docID] = $score / $index['docCount'][$docID];
            echo "<br>doccount: $docCount docID: $docID score : $score index : " . $index['docCount'][$docID] . "";
        }
        echo "<br>";
        arsort($matchDocs); // high to low

        var_dump($matchDocs);

        /* echo "<p><b>Corpus:</b></p>";
          $ir->show_docs($D);

          $ir->create_index($D);

          echo "<p><b>Inverted Index:</b></p>";
          $ir->show_index();

          $term = $result;
          $i= count($term);

          echo "$i <br/>";
          print_r($term);

          for($j=0; $j<$i; $j++)
          {
          $tf=$ndw=$idf=$tfidf=0;
          $tf = $ir->tf($term[$j]);
          $ndw = $ir->ndw($term[$j]);
          $idf = $ir->idf($term[$j]);
          $tfidf = $tf * $idf;
          echo "<p>";
          echo "Term Frequency of $term[$j] is $tf <br />";
          echo "Number Of Documents with $term[$j] is $ndw<br />";
          echo "Inverse Document Frequency of $term[$j] is $idf <br/>";
          echo "TF/IDF $term[$j] = $tfidf<br />";
          echo "</p>";
          } */


        /* $var_x = "Depending structure object-oriented";
          $var_y = "Depending on the structure of your array object-oriented";

          $pieces1 = explode(" ", $var_x);
          $pieces2 = explode(" ", $var_y);
          $result = array_intersect($pieces1, $pieces2);
          print_r($result); */
        ?>
    </body>
</html>
