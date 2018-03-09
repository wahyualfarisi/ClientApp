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
    define('PS_SHOP_PATH', 'http://localhost/prodapur/');
    define('PS_WS_AUTH_KEY','74AXMLJC84Y9SYIAPHQ9I2WK53B8M7G9');
    require('./PSWebServiceLibrary.php');

    try {
      $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);
      $opt['resource'] = 'products';
      //$opt = array('resource' => 'products','display' => 'full');
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
                  <th>Id Produk</th>
                  <th>Manufature</th>
                  <th>Date Add</th>
                  <th>Date Update</th>
                  <th>Nama Produk</th>
                  <th>Stok Tersedia</th>

                </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($resources as $key ){
                    $opt['id'] = $key->attributes();
                    $xml = $webService->get($opt);
                    $r = $xml->children()->children();
                    //print_r($r);

                    echo '<tr>';
                    echo '<td>'.$r->id.'</td>';
                    echo '<td>'.$r->manufacturer_name.'</td>';
                    echo '<td>'.$r->date_add.'</td>';
                    echo '<td>'.$r->date_upd.'</td>';
                    echo '<td>'.$r->name.'</td>';
                  //  echo '<td>'.$r1->stock_available.'</td>';
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
