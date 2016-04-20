
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
            <?php foreach($artikel as $row_artikel):?>
            
            <div class="panel panel-default">    
                <div class="panel-heading">                    
                    <a href=" <?php echo base_url('user/artikel_seleksi'). "/" . $row_artikel->id_artikel ?>"><h1><?php echo $row_artikel->judul ?></h1></a>
                    
                </div>
                <div class="panel-body">
                    <div>   
                        <em><small>Diterbitkan pada: <?php echo $row_artikel->tanggal ?></small></em>
                        <div>
                        <?php 
                            echo substr($row_artikel->isi_artikel, 0, 150);
                            echo "...<br><br>";
                            echo "<small><a href=". 
                                base_url('user/artikel_seleksi') ."/". $row_artikel->id_artikel.">Baca Selengkapnya...</a></small>";
                        ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
                
        </article><!-- ./Artikel -->
        
        <!-- Sidebar -->
        <aside class="container-fluid col-md-4 text-center">
            
            <!-- Kotak pencarian -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" method="get" action="<?php echo base_url('home/cari_kata_kunci')?>">
                        <input name="q" type="text" class="form-control" placeholder="Cari artikel disini...">
                        <input value="Cari" type="submit" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <?php if (isset($_SESSION['username'])): ?>
            
            <!-- User's profile -->
            <div class="panel panel-default">
                <?php foreach($user->result() as $row_user):?>
                
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    <?php if ($row_user->tipe_akun == "Admin"): ?>
                    
                    <img src="<?php echo base_url('assets/images/admin.png')?>">
                    <br><br>
                    <?php else: ?>
                
                    <img src="<?php echo base_url('assets/images/member.png')?>">
                    <br><br>
                    <?php endif ?>
                    
                    <p><?php echo $row_user->nama; ?></p>
                    <p><?php echo $row_user->tipe_akun; ?></p>
                </div>
                <?php endforeach ?>
                
            </div><!-- ./User's profile -->
            
            <?php endif ?>
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
