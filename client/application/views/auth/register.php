<div class="container p-full">
    <div class="row">
    <div class="col-xs-12">
	<?php $this->load->view('_base/message'); ?>
<div class="segment-box fd-clr" style="margin-top:15px;">
  <div class="segment layout layout-s5m0">
    <div class="div-clear fl page-container">
      <div class="content-wrap div-clear fl">
        <div class="register-page div-clear fl">
          <div class="register-block ele-inline fl customize-field">
            <strong class="text-center text-lg"><span>Đăng ký</span></strong>
            <form id="form-register" action="<?php echo site_url('auth/register');?>" method="post">
              <div class="form-group input-username field-registerform-username required">
                <label class="control-label" for="username">Tên đăng nhập</label>
				<input autocomplete="off" placeholder="Tên đăng nhập" class="form-control"  name="username" id="CustomerRegisterForm_customer_username" type="text">                        

              </div>
              <div class="form-group input-username field-registerform-fullname">
                <label class="control-label" for="fullname">Họ và tên</label>
				<input autocomplete="off" placeholder="Tên đầy đủ" class="form-control"  name="fullname" id="CustomerRegisterForm_customer_fullname" type="text"> 			
              </div>
              <div class="form-group input-phone field-registerform-phone">
                <label class="control-label" for="phone">Số di động</label>
				<input autocomplete="off" placeholder="Điện thoại" class="form-control"  name="phone" id="CustomerRegisterForm_customer_phone" type="text">                        

				
              </div>
              <div class="form-group input-email field-registerform-email required">
                <label class="control-label" for="email">Email</label>
				<input autocomplete="off" placeholder="Email" class="form-control"  name="email" id="CustomerRegisterForm_customer_email" type="text">                        

              </div>
              <div class="form-group input-password field-registerform-password required">
                <label class="control-label" for="password">Mật khẩu</label>
				<input autocomplete="off" placeholder="Mật khẩu" class="form-control"  name="password" id="CustomerRegisterForm_customer_password" type="password">                        

              </div>
              <div class="form-group input-password field-registerform-confirmpassword">
                <label class="control-label" for="confirmpassword">Xác nhận mật khẩu</label>
				<input autocomplete="off" placeholder="Xác nhận mật khẩu" class="form-control"  name="passconf" id="CustomerRegisterForm_customer_password_confirmation" type="password">                        
            
              </div>
			  <div class="form-group form-control-submit">
              <input type="submit" class="login-btn" name="save" value="Đăng ký tài khoản"/> 
			  </div>
            </form>
          </div>
          <div class="register-hint-block ele-inline fr">
            <strong>
            <span>Lợi ích khi đăng ký thành viên</span>
            </strong>
            <ul>
              <li>
                <img src="static/images/key.jpg">
                <p>Bảo mật thông tin giao dịch</p>
              </li>
              <li>
                <img src="static/images/car.jpg">
                <p>Vận chuyển nhanh toàn quốc và giá tốt nhất</p>
              </li>
              <li>
                <img src="static/images/list.jpg">
                <p>Hệ thống quản lý đơn hàng chuyên nghiệp dễ dàng</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  </div>
  </div>
</div>

