<div class="container p-full">
    <div class="row">
	
    <div class="col-xs-12">
    <!-- BEGIN: .steps -->
    <!-- END: .steps -->
    <h2 class="text-center page-title text-success"><i class="glyphicon glyphicon-log-in"></i> Đăng nhập vào website</h2>
    <div class="content">
    <div class="site-signup">
      <form id="form-login" class="form-horizontal" action="<?php echo site_url('auth/login'); ?>" method="post">
		<div class="text-center">
		<?php $this->load->view('_base/message'); ?>
		</div>
        <div class="sign-up-form-control field-loginform-username required">
          <div class="row">
            <div class="col-xs-4 text-right"><label class="control-label" for="username">Tên đăng nhập</label></div>
            <div class="col-xs-4">
			<input type="text" id="loginform-username" class="form-control" name="username">
			</div>
          </div>
        </div>
        <div class="sign-up-form-control field-loginform-password required">
          <div class="row">
            <div class="col-xs-4 text-right"><label class="control-label" for="password">Mật khẩu</label></div>
            <div class="col-xs-4">
			<input type="password" id="loginform-password" class="form-control" name="password">
			</div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-4">
            <input type="submit" class="btn btn-red col-xs-12" name="login" value="Đăng nhập" />            
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-4 col-xs-offset-4">
            <a href="<?php echo site_url('auth/resgister');?>">Đăng ký tài khoản</a>                
			<a class="pull-right" href="<?php echo site_url('auth/forgotpass');?>">Quên mật khẩu?</a>            
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-6 col-xs-offset-3">
            <p class="separator">
              <span>Hoặc đăng nhập bằng tài khoản</span>
            </p>
            <div class="row">
              <div class="col-md-6">
                <a class="facebook-login" href="#">
                <span>
                <strong>Facebook</strong>
                </span>
                </a>
              </div>
              <div class="col-md-6">
                <a class="google-login" href="#">
                <span>
                <strong>Google+</strong>
                </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    </div>
    </div>
    </div>
    </div>