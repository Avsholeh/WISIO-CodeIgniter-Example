
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
                <li><a href="<?php echo base_url('home/daftar')?>">Daftar</a></li>
                <li><a href="<?php echo base_url('home/login')?>">Login</a></li>
            </ul>
        </div>
    </nav><!-- ./Navigasi -->
    
    <!-- Login form -->
    <section class="container-fluid">
        <div id="daftar">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar</div>
                <span>
                    <?php 
                    if (validation_errors() !== NULL && !empty(validation_errors())){
                        echo "<span>".validation_errors()."</span>";
                    } 
                    ?>
                </span>
                <div class="panel-body">
                    <form action="<?php echo base_url('home/validasi')?>" method="post">
                        <div class="form-group">
                            <label>Nama:</label>
                            <input name="nama" type="text" class="form-control" required autofocus title="Nama tidak boleh kosong">
                        </div>    
                        <div class="form-group">
                            <label>Username:</label>
                            <input name="username" type="text" class="form-control" required title="Username tidak boleh kosong">
                        </div>
                        
                        <div class="form-group">
                            <label>Password:</label>
                            <input name="password" type="password" class="form-control" required pattern=".{6,}" title="Password harus lebih dari 6 digit">
                        </div>
                        
                        <div class="form-group">
                            <label>Konfirmasi Password:</label>
                            <input name="re-password" type="password" class="form-control" required pattern=".{6,}" title="Password harus lebih dari 6 digit">
                        </div>
                            
                        <div class="form-group">
                            <label>Email:</label>
                            <input name="email" type="email" class="form-control" required title="E-mail tidak boleh kosong">
                        </div>
                            
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary">Daftar</button><br><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- ./Login form -->
        
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
