<?php include 'include/header.php' ?>
<div class="content-wrapper">
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pelanggan
        <small>Management System</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Layout</a></li>
        <li class="active">Top Navigation</li>
      </ol>
    </section>

    <?php
    define('DEBUG', false);
    define('PS_SHOP_PATH', 'http://wahyualfar.pe.hu');
    define('PS_WS_AUTH_KEY','NPIXR9Z8I7PRXHAGJRAWVJQLNP33C36G');
    require('./PSWebServiceLibrary.php');

    try {
      $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);
      $opt['resource'] = 'customers';
      if(isset($_GET['id']) ){
        $opt['id'] = (int)$_GET['id'];
      }

      $xml = $webService->get($opt);
      $resources = $xml->children()->children();
    }
     catch (PrestaShopWebserviceException $e) {
       $trace = $e->getTrace();
       if($trace[0]['args'][0] == 404) echo 'Bad ID';
       else if($trace[0]['args'][0] == 401 ) echo 'Bad Auth Key';
       else echo 'Other Error <br />'.$e->getMessage();
    }
    ?>
    <br>
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id Pelanggan</th>
                  <th>Nama Depan</th>
                  <th>Nama Belakang</th>
                  <th>Email</th>
                  <th>Details</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($resources as $key ){
                    $opt['id'] = $key->attributes();
                    $xml = $webService->get($opt);
                    $r = $xml->children()->children();

                    echo '<tr>';
                    echo '<td>'.$r->id.'</td>';
                    echo '<td>'.$r->firstname.'</td>';
                    echo '<td>'.$r->lastname.'</td>';
                    echo '<td>'.$r->email.'</td>';
                  }





                   ?>

                </tbody>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>



  </div>
  <!-- /.container -->
</div>
<?php include 'include/footer.php' ?>
