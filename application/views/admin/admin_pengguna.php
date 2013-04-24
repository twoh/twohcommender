<div class="container-fluid">
    <?php include 'admin_db.php'; ?>
    <div class="row">
        <div class="span6">
            <h3>
                <a class="btn" href="<?php echo base_url() . 'admin/index/' ?>" ><i id="back" class="icon-backward"></i></a>
                Daftar Pengguna 
                <a class="btn" onClick="insertUser()" href="#!insert_user"><i id="addUser" class="icon-plus"></i></a>
            </h3>
            <div id="dataUser">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results->result() as $users): ?>
                            <tr>
                                <td><span class="label label-inverse"><?php echo $users->id_user; ?></span></td>
                                <td><?php echo $users->user_name; ?></td>
                                <td><?php echo $users->email; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-small btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <input id="fieldEdit<?php echo $users->id_user ?>" type="hidden" name="edit_user" value="<?php echo $users->id_user ?>"/>
                                            <li class="" id="linkEdit<?php echo $users->id_user ?>"><a href="#edit/#!/user<?php echo $users->id_user ?>" onclick="editUser(<?php echo $users->id_user ?>)"><i class="icon-pencil"></i> Edit</a></li>
                                            <li class="" id="linkDelete<?php echo $users->id_user ?>"><a href="#delete/#!/user<?php echo $users->id_user ?>" onclick="hapusUser(<?php echo $users->id_user ?>)"><i class="icon-trash"></i> Hapus</a></li>
                                            <li class="" id="linkView<?php echo $users->id_user ?>"><a href="#view/#!/user<?php echo $users->id_user ?>" onclick="viewUser(<?php echo $users->id_user ?>)"><i class="icon-file"></i> Lihat Data</a></li>
                                            <li class="" id="linkRec<?php echo $users->id_user ?>"><a href="<?php echo base_url().'admin/get_recommendation.twh?id='.$users->id_user?>"><i class="icon-user"></i> Lihat Rekomendasi</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php echo $links; ?>
                </div>
            </div>
        </div><!-- span6 -->
        <div class="span4" id="insertUser" toggle="no">

        </div>
    </div><!-- row -->
    <script>
        function insertUser(){
            if($("#insertUser").attr("toggle")=="no")
            {
                $("#insertUser").load("<?php echo base_url() ?>admin/insert_user.twh");
                $('#insertUser').attr('toggle','yes');
                $("#addUser").attr('class','icon-minus');
            }
            else if($("#insertUser").attr("toggle")=="yes")
            {
                $("#insertUser").empty();
                $('#insertUser').attr('toggle','no');
                $("#addUser").attr('class','icon-plus');
            }
                                    
        }
        
        function editUser($id_us, event)
        {
            if($("#insertUser").attr("toggle")=="no")
            {
                $("#insertUser").load("<?php echo base_url() ?>admin/edit_user.twh",{
                    edit_user: $("#fieldEdit"+$id_us).val()
                });
                $('#insertUser').attr('toggle','yes');
                $('#linkEdit'+$id_us).attr('class','disabled');
                event.preventDefault();
            }
            else if($("#insertUser").attr("toggle")=="yes")
            {
                $("#insertUser").empty();
                $('#insertUser').attr('toggle','no');
                $('#linkEdit'+$id_us).attr('class','');
                event.preventDefault();
            }
        }
        
        function hapusUser($id_us, event)
        {
            $("#insertUser").load("<?php echo base_url() ?>admin/delete_user.twh",{
                edit_user: $("#fieldEdit"+$id_us).val()
            });
            $("#dataUser").load("<?php echo base_url() . 'admin/lihat_pengguna' ?> #dataUser");
            event.preventDefault();
        }
        
        function viewUser($id_us)
        {
            
        }
    </script>

</div>
