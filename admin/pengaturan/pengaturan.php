<?php
require_once('../../config.php');

?>

<!DOCTYPE html>
<html>
  <head>
    <title>TPQ</title>
    <link rel="shortcut icon" href="\tpq-annuur\assets\image\logo-annur-bulat.png">
    <!-- style css -->
    <link rel="stylesheet" href="\tpq-annuur\admin\layout\style.css" />
    <style>
    </style>
  </head>

  <body>
    <!-- sidebar & navbar -->
    <?php
      include('../layout/sidebar.php');
    ?>

    <!-- konten -->
    <main>
      <div class="container-fluid content transition">
        <h3>Pengaturan</h3>
        
        <!-- card content -->
        <div class="card border shadow">
          <div class="card-body m-3">

            <!-- form input -->
            <form method="post">

              <!-- Nama -->
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <input type="text" name="nama" class="form-control" id="nama" required>
                </div>
              </div><br>

              <!-- Username -->
              <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                  <input type="text" name="username" class="form-control" id="username" required>
                </div>
              </div><hr>

              <!-- Password -->
              <div class="form-group row">
                <label for="passwdBaru" class="col-sm-2 col-form-label">Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" name="passwd" class="form-control" id="passwdBaru">
                </div>
              </div><br>
              <!-- Ulang Password -->
              <div class="form-group row">
                <label for="passwdBaruUlang" class="col-sm-2 col-form-label">Ulangi Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" name="passwdulang" class="form-control" id="passwdBaruUlang">
                </div>
              </div><hr>
              
              <!-- Button -->
              <div class="form-group row mt-2">
                <label for="button" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col col-md-6 d-grid gap-2">
                    </div>
                    <div class="col col-md-6 d-grid gap-2">
                      <button type="submit" name="ubah" class="btn btn-success btn-block">
                        <span><i class="bi bi-pencil"></i></span>
                        <span>Update</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            
            <!-- Modal Danger -->
            <div class="modal fade" tabindex="-1" id="modalDanger" aria-hidden="true" >
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p><?=$setDangerText?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>