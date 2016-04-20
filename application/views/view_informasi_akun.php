
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
        <article class="col-md-8">
                    <?php foreach($artikel->result() as $row_artikel):?>
            <div class="panel panel-default">    
                <div class="panel-heading">
                    <h1><a href="<?php echo base_url('home/artikel')."/".$row_artikel->id_artikel?>"><?php echo $row_artikel->judul ?></a></h1>
                
                </div>
                <div class="panel-body">
                    <span><b>Diterbitkan pada: </b><?php echo $row_artikel->tanggal?></span><br>
                    <span><b>Status: </b><?php echo $row_artikel->status?></span><br>
                    <li>
                        <a href="<?php echo base_url('user/edit_artikel')."/".$row_artikel->id_artikel?>">Edit</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('user/hapus_artikel')."/".$row_artikel->id_artikel?>">Hapus</a>
                    </li>
                    
                </div>
            </div>
                    <?php endforeach ?>
                
        </article><!-- ./Artikel -->
        
        <!-- Sidebar -->
        <aside class="col-md-4">
            <div class="text-center">
                <a href="<?php echo base_url('user/buat_artikel') ?>">
                    <button class="btn btn-primary">Buat Artikel</button>
                </a>
            </div>
            <br>
            <!-- Informasi Akun -->
            <div class="panel panel-default">
                <div class="panel-heading text-center">Profile</div>
                <div class="panel-body">
                    <?php foreach($user->result() as $row_user):?>
                    <span><b>Nama: </b><?php echo $row_user->nama?></span><br>
                    <span><b>Username: </b><?php echo $row_user->username ?></span><br>
                    <span><b>Email: </b><?php echo $row_user->email ?></span><br>
                    <span><b>Status sebagai: </b><?php echo $row_user->tipe_akun ?></span><br>
                    <?php endforeach?>
                    <span><a href="<?php echo base_url('user/edit_akun')?>">Edit Akun</a></span>
                </div>
                
            </div><!-- ./Informasi Akun -->
            
        </aside><!-- Sidebar -->
        
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
