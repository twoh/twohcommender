<?php
$precgraph = $recgraph =0;
?>
<div class="container-fluid">
    <script type="text/javascript" src="<?php echo base_url() ?>js/highcharts.js"> </script>
    <script type="text/javascript" src="<?php echo base_url() ?>js/exporting.js"> </script>
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'line',
                    marginRight: 50,
                    marginBottom: 100
                },
                title: {
                    text: 'Akurasi Klasifikasi Content-based Filtering',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Pengujian <?php echo $jenis;?>',
                    x: -20
                },
                xAxis: {
                    title: {
                        text: 'ID User'
                    },
                    categories: [
                        <?php
                            foreach ($precision as $key => $value):
                                echo $key.",";
                            endforeach;
                            ?>
                    ]
                },
                yAxis: {
                    min : 0,
                    title: {
                        text: 'Jumlah'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    valueSuffix: ' doc',
                    shared: true,
                    crosshairs:true
                },                
                series: [{                        
                        color:'#3FCC4B',
                        name: 'Relevan',
                        data: [
                            <?php
                            foreach ($precision as $key => $value):
                                echo $similar[$key].",";
                            endforeach;
                            ?>]
                    }, {
                        color:'#CC3F3F',
                        name: 'Dokumen Total',
                        data: [
                            <?php
                            foreach ($precision as $key => $value):
                                echo $total[$key].",";
                            endforeach;
                            ?>
                        ]
                    }, {
                        
                        name: 'Relevan Total',
                        data: [
                            <?php
                            foreach ($precision as $key => $value):
                                echo $relevan[$key].",";
                            endforeach;
                            ?>
                        ]
                    }
                ]
            });
        });
        
        $(function () {
            $('#pr').highcharts({
                chart: {
                    type: 'line',
                    marginRight: 50,
                    marginBottom: 100
                },
                title: {
                    text: 'Akurasi Precision-recall Content-based Filtering',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Pengujian <?php echo $jenis;?>',
                    x: -20
                },                
                xAxis: {
                    title: {
                        text: 'ID User'
                    },
                    categories: [
                        <?php
                            foreach ($precision as $key => $value):
                                echo $key.",";
                            endforeach;
                            ?>
                    ]
                },
                yAxis: {
                    min : 0,
                    title: {
                        text: 'Nilai'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    valueSuffix: ' ',
                    shared: true,
                    crosshairs:true
                },                
                series: [{                        
                        color:'#3FCC4B',
                        name: 'Precision',
                        data: [
                            <?php
                            foreach ($precision as $key => $value):
                                if($value==null)
                                {
                                    echo "0,";
                                }
                                else
                                {
                                    echo $value.",";
                                }                                
                            endforeach;
                            ?>]
                    }, {                        
                        name: 'Recall',
                        data: [
                            <?php
                            foreach ($precision as $key => $value):
                                echo $recall[$key].",";
                            endforeach;
                            ?>
                        ]
                    }
                ]
            });
        });                
    </script>
    <?php include 'admin_db.php'; ?>
    <div class="row-fluid">        
        <h3>
            <a class="btn" href="<?php echo base_url() . 'admin/index.twh' ?>" ><i id="back" class="icon-backward"></i></a>
            Akurasi Sistem Content Based                
        </h3>            
        <div id="container" style="min-width: 400px; max-width: 1000px; height: 400px; margin: 0px"></div>	        
        
        <div id="pr" style="min-width: 400px; max-width: 1000px; height: 400px; margin: 0px"></div>	        
        <div class="span8">
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Relevan</th>
                            <th>Dokumen Total</th>
                            <th>Relevan Total</th>
                            <th>Precision</th>
                            <th>Recall</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $precTotal = $reccTotal = 0;
                        foreach ($precision as $key => $value):
                            ?>
                            <tr>                                
                                <td><?php echo $key;
                            ?></td>
                                <td><?php echo $similar[$key];
                            ?></td>
                                <td><?php echo $total[$key];
                            ?></td>
                                <td><?php echo $relevan[$key];
                            ?></td>                                
                                <td><?php
                                echo $value; //." = ".(round($value,4)*100)."%";
                                $precTotal += $value;
                                ?></td>
                                <td><?php
                                echo $recall[$key]; //." = ".(round($recall[$key],4)*100)."%";
                                $reccTotal += $recall[$key];
                            ?></td>
                            </tr>
<?php endforeach; ?>
                    </tbody>
                </table>                                
            </div>
            <span class="label label-info">Precision Total : <?php echo (round($precTotal / count($precision), 4) * 100) . "%"; 
            $precgraph = (round($precTotal / count($precision), 4) * 100);?></span>
            <span class="label label-info">Recall Total : <?php echo (round($reccTotal / count($recall), 4) * 100) . "%"; 
            $recgraph = (round($reccTotal / count($recall), 4) * 100); ?></span>                
        </div>        
        <div id="bar" style="max-width: 600px; height: 400px; margin: 0px"></div>
    </div> <!--row-->
    <script>                                
        function addRating($id_mk,event)
        {
            if($("#insertMK").attr("toggle")=="no")
            {
                $("#insertMK").load("<?php echo base_url() ?>user/addRating.twh",{
                    edit_mk: $("#fieldEdit"+$id_mk).val()
                });
                $('#insertMK').attr('toggle','yes');                
                $("#addRating"+$id_mk).attr('class','icon-white icon-minus');
                event.preventDefault();
            }
            else if($("#insertMK").attr("toggle")=="yes")
            {
                $("#insertMK").empty();
                $('#insertMK').attr('toggle','no');                
                $("#addRating"+$id_mk).attr('class','icon-white icon-plus');
                event.preventDefault();
            }
        }     
        
        $(function () {
        $('#bar').highcharts({
            chart: {
                type: 'column'
            },
            tooltip: {
                    valueSuffix: ' %'}
                ,
            title: {
                text: 'Perbandingan Precision Recall'
            },
            subtitle: {
                text: 'Pengujian <?php echo $jenis;?>'
            },
            xAxis: {
                categories: [
                    'Precision',
                    'Recall'                    
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
                }
            },            
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Nilai',
                data: [<?php echo $precgraph.",".$recgraph;?>]
    
            }]
        });
    });
    </script>
</div>