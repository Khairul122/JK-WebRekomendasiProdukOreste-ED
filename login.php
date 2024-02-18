<div class="page-header">
    <h1>Login</h1>
</div>
<div class="row">
    <div class="col-md-4">
        <form class="form-signin" method="post">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="user" autofocus />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="pass" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><span class="fa fa-sign-in-alt"></span> Masuk</button>
                <p class="help-block">User: admin, password: admin</p>
            </div>
        </form>
    </div>
</div>