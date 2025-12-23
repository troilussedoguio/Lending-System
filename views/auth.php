<?php include '../views/layouts/plugins-header.php'; ?>

<div class="login row mx-0 d-flex align-items-center justify-content-center" style="height: 100vh; width: 100vw;">
    <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4 col-xxl-3"> 
        <div class="py-3 mb-4 text-center">
            <img class="mb-5" src="images/logo-text.png" alt="logo" width="auto" height="35px">
            <h4 class="mb-3 d-block fw-bold">Login to Your Account</h4>
            <small class="text-secondary">Enter your email and password below to log in</small>
        </div>
        <div>
            
            <div>
                <form class="loginForm" method="POST">
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="email" id="email" placeholder="email" autocomplete="off">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ri-mail-line fs-4 text-muted"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="password">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ri-lock-line fs-4 text-muted"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="RememberMe">
                            <label class="form-check-label" for="RememberMe" role="button">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-dark col-12 py-2">Log in</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../views/layouts/plugins-footer.php'; ?>
