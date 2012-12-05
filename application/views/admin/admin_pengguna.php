<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="container-fluid">
<div class="row">
    <div class="span6">
        <h3>Daftar Pengguna <a class="btn" onClick="insertUser()" href="#!insert_user"><i id="addUser" class="icon-plus"></i></a></h3>
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
                <?php foreach($user->result() as $users):?>
                <tr>
                    <td><span class="label label-inverse"><?php echo $users->id_user;?></span></td>
                    <td><?php echo $users->user_name;?></td>
                    <td><?php echo $users->email;?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small btn-info dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                              <li><a href="#"><i class="icon-trash"></i> Hapus</a></li>
                              <li><a href="#"><i class="icon-file"></i> Lihat Data</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        </div>
    <div class="span4" id="insertUser" toggle="no">

        </div>
    </div>
    <script>
function insertUser(){
                        if($("#insertUser").attr("toggle")=="no")
                            {
                                $("#insertUser").load("<?php echo base_url()?>admin/insert_user");
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
</script>
</div>
