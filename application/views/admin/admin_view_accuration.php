<div class="container-fluid">
    <script type="text/javascript" src="<?php echo base_url() ?>js/highcharts.js"> </script>
    <script type="text/javascript" src="<?php echo base_url() ?>js/exporting.js"> </script>
    <script type="text/javascript">
        $(function () {
            $('#mae').highcharts({
                chart: {
                    type: 'line',
                    marginRight: 50,
                    marginBottom: 100
                },
                title: {
                    text: 'Akurasi Mean Absolute Error',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Collaborative Filtering',
                    x: -20
                },
                xAxis: {
                    title: {
                        text: 'ID User'
                    },
                    categories: [
                        <?php
                            foreach ($prediksi as $key => $value):
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
                    valueSuffix: ' ',
                    shared: true,
                    crosshairs:true
                },                
                series: [{                                                
                        name: 'Prediksi Rating',
                        data: [
                            <?php
                            foreach ($prediksi as $key => $value):
                                echo $value.",";
                            endforeach;
                            ?>]
                    }, 
                    {
                        
                        name: 'Aktual Rating',
                        data: [
                            <?php
                            foreach ($prediksi as $key => $value):
                                echo $aktual[$key].",";
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
            Akurasi Sistem Collaborative Filtering                               
        </h3>
        <div id="mae" style="min-width: 400px; height: 400px; margin: 0 auto;"></div>	                
        <span class="label label-info">Mean Absolute Error : <?php echo $accuration; ?></span>
        <span class="label label-info">Mata Kuliah : <?php echo $mk; ?></span>
        <div class="span8">
            <div id="dataMK">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Prediksi Rating</th>                                                                                
                            <th>Aktual Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($prediksi as $key => $value):
                            ?>
                            <tr>                                
                                <td><?php echo $key;
                        ?></td>
                                <td><?php echo $value;
                        ?></td>
                                <td><?php echo $aktual[$key];
                        ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>                                
            </div>
            <span class="label label-info">Mean Absolute Error : <?php echo $accuration; ?></span>
            <span class="label label-info">Mata Kuliah : <?php echo $mk; ?></span>
        </div>           
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
    </script>
</div>