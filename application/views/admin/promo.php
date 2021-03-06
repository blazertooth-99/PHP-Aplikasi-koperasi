<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?= $title ?><small> KPRI SEHAT DKK</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-image"></i> <?= $title ?></a></li>
        </ol>
    </section>
    <section class="content">    
        <div class="row">
            <div class='col-md-12'>
                <div class='panel panel-white' id="header">
                    <div class='panel-heading clearfix'>
                        <div class='col-md-10'>
                            <h4 id="warna">Selamat datang di <b>KPRI SEHAT DKK</b></h4>
                        </div>
                        <div id="tgl-login">
                            <h4><strong><?= tanggal_indo(date('Y-m-d')) ?></strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <center><p><?php  echo $this->session->flashdata('message'); ?></p></center>
            </div>
            <div class="col-md-12">                
                <div class="box">
                    <div class="box-header with-border">
                        <h2 class="box-title"><b><i class="fa fa-image"></i> Data Promo KPRI SEHAT DKK</b></h2>
                    </div>
                    <div class="col-lg-12 pull-right">
                        <a href="admin/promo/tambah" class="btn btn-success"><i class="fa fa-plus-square"></i> Tambah Promo</a>
                    </div><hr>
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="40">No</th>
                                    <th>Foto Promo</th>
                                    <th>Kode Promo</th>
                                    <th>Nama Promo</th>
                                    <th>Status</th>
                                    <th>urutan Slide</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($promo as $a) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src="<?= base_url('img/'.$a->foto) ?>" alt="" height="150"></td>
                                    <td><?= $a->kd_promo ?></td>
                                    <td><?= $a->nama ?></td>
                                    <td>
                                        <?php if($a->status == 1){
                                            echo 'ENABLE';
                                        }else{
                                            echo 'DISABLE';
                                        } ?>
                                    </td>
                                    <td><?= $a->no_urut ?></td>
                                    <td>
                                        <a href="admin/promo/detail/<?= $a->id ?>" class="btn btn-warning" title="Detail produk promo"><i class="fa fa-list"></i></a>
                                        <a href="admin/promo/edit/<?= $a->id ?>" class="btn btn-success" title="Edit promo"><i class="fa fa-edit"></i></a>
                                        <a href="admin/promo/hapus/<?= $a->id ?>" onClick='return confirm("Apakah anda yakin akan menghapus data ini ?")' class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>  
</div>