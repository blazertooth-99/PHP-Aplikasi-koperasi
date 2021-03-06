<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?= $title ?><small> KPRI SEHAT DKK</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> <?= $title ?></a></li>
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
                  <h4><strong><?= tanggal_indo(date("Y-m-d")) ?></strong></h4>
              </div>
          </div>
        </div>
      </div>
    </div>
      
          <div class="row">
            <div class='col-md-12'>
            <div class="col-md-6 " style="background:white;">
               <div class="x_panel">
                 <div class="x_title">
                  
                   <div class="clearfix"></div>
                 </div>
                 <div class="x_content">
                   <h3 style="padding-bottom: 10px">Laporan Laba Kotor</h3>
                   <form class="form-horizontal" method="post" action="admin/pelaporan/report_laba_rugi">
                     <div class="form-group">
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <label for="">Tanggal Awal :</label>
                         <input type="date" id="tgl1" class="form-control datepicker" name="tgl1" required=""> 
                       </div>
                       <div class="col-md-6 col-sm-6 col-xs-12">
                         <label for="">Tanggal Akhir :</label>
                         <input type="date" id="tgl2" class="form-control datepicker" name="tgl2" required=""> 
                       </div>
                     </div>
                     <div class="form-group">
                       <div class="col-md-12 col-sm-6 col-xs-12">
                         <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
                       </div>
                     </div>
                   </form>
                 </div>
               </div>
             </div>
             <div class="col-md-6  " style="background:white;">
              <div class="x_title"> 
                  <div class="x_content">
                    <h3 style="padding-bottom: 10px">Laporan Laba Bersih</h3>
                    <form class="form-horizontal" method="post" action="http://localhost/pos/pos/report/laba_bersih">
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label for="">Tanggal Awal :</label>
                          <input type="date" id="awal" class="form-control datepicker" name="awal" required="">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label for="">Tanggal Akhir :</label>
                          <input type="date" id="akhir" class="form-control datepicker" name="akhir" required="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label for="">Biaya Lain :</label>
                          <input type="text" id="lain_lain" class="form-control" name="lain_lain" required="">
                          <small><i>Biaya listrik, produksi, dan lain-lain.</i></small>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12">
                          <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
            </div>
             
          </div>
  </section>  
</div>