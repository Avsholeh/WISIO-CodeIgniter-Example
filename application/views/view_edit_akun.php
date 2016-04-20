
<body>

    <!-- Navigasi -->
    <nav class="navbar navbar-default col-md-12">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".mydata">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url()?>">WISIO</a>
        </div>
        <div class="collapse navbar-collapse mydata">
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['username'])): ?>
                
                <?php if ($this->session->userdata('tipe_akun') == "Admin"): ?>
                
                <li><a href="<?php echo base_url('user/seleksi') ?>">Seleksi Artikel</a></li>
                <?php endif ?>
                
                <li><a href="<?php echo base_url('user/informasi_akun')?>">Informasi Akun</a></li>
                
                <li><a href="<?php echo base_url('home/logout')?>">Logout</a></li>
                <?php else: ?>
                
                <li><a href="<?php echo base_url('home/daftar')?>">Daftar</a></li>
                <li><a href="<?php echo base_url('home/login')?>">Login</a></li>
                <?php endif ?>
                
            </ul>
        </div>
    </nav><!-- ./Navigasi -->
    
    <!-- Konten utama -->
    <section class="container-fluid" id="main">
        
        <!-- Edit Akun -->
        <article class="col-md-8 col-md-push-2">

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php foreach($user->result() as $row_user):?>
                    
                    <form method="POST" action="<?php echo base_url('user/simpan_perubahan')?>">
                        <div class="form-group">
                            <label>Nama:</label>
                            <input name="nama" class="form-control"
                                   type="text" value="<?php echo $row_user->nama ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Username:</label>
                            <input name="username" class="form-control"
                                   type="text" value="<?php echo $row_user->username ?>" readonly>
                        </div>
                        <!--<div class="form-group">
                            <label>Password lama:</label>
                            <input name="pwd-lama" class="form-control"
                                type="password" value="<?php //echo $row_user->password ?>" required>
                        </div>-->
                        <div class="form-group">
                            <label>Password baru:</label>
                            <input name="pwd-baru" class="form-control"
                                   type="password" value="">
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input name="email" class="form-control"
                                   type="email" value="<?php echo $row_user->email ?>">
                        </div><br>
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        <button class="btn btn-danger" formaction="<?php echo base_url('user/hapus_akun')?>">Hapus Akun</button>
                    </form>
                    <?php endforeach ?>
                    
                </div>
            </div>
            
        </article><!-- ./Edit Akun -->
        
    </section><!-- ./Konten utama -->

    <footer class="container text-center">
        <hr>
        <li><a href="">Home</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Contact</a></li>
        <p>&copy; 2015 WISIO - Wisata Online Indonesia (<i> dalam tahap pengembangan </i>)</p>
    </footer>
    
</body>
<script src="<?php echo base_url("/assets/js/jquery-2.1.4.min.js")?>"></script>
<script src="<?php echo base_url("/assets/js/bootstrap.min.js")?>"></script>

</html>
