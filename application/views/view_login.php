
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
        <div id="login">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                <div><?php if(isset($error)) {echo $error;} ?></div>
                    <form action="<?php echo base_url('home/auth')?>" method="post">
                        <span>Username:</span>
                        <input name="username" type="text" class="form-control" required autofocus><br>
                        <span>Password:</span>
                        <input name="password" type="password" class="form-control" required pattern=".{6,}" title="Password harus lebih dari 6 digit"><br>
                        <button class="btn btn-primary">Login</button>
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
