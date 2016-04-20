
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
        
        <!-- Artikel -->
        <article class="col-md-8 col-md-push-2">

            <!-- Kotak komentar -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="<?php echo base_url('home/update_komentar')."/".$this->uri->segment(3, 0)."/".$this->uri->segment(4, 0); ?>" method="POST"> 
                        <div class="form-group">
                        <label>Komentar: </label>
                        <?php foreach($komentar as $row_komentar) ?>
                        <textarea class="form-control" name="isi-komentar"><?php echo $row_komentar->isi_komentar ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Komentar</button>
                    </form>
                </div>
            </div><!-- ./Kotak komentar -->
            
        </article><!-- ./Artikel -->
        
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
