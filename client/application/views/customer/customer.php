	<div class="container p-full">
        <div class="container-profile">
		<!-- Start Tab Content -->
          <div class="navbar navbar-default profile-menu-top">
            <div class="row">
              <div class="col-md-12">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#acc">Quản lý tài khoản</a></li>
                  <li><a data-toggle="tab" href="#buy">Quản lý mua hàng</a></li>
                  <li><a data-toggle="tab" href="#bank">Tài khoản trả trước</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="profile clearfix">
            <div id="#acc" class="tab-pane fade in active"> 
				<div class="col-xs-3">
				 <ul class="profile-menu-left nav nav-tabs horizontal-tab">
					<li class="user"><i class="glyphicon glyphicon-user"></i>Xin chào,<br>dendimon    </li>
					<li ><a data-toggle="tab" href="#profile" onclick="AjaxProfile('<?php echo site_url('customer/profile'); ?>')">Thông tin tài khoản</a></li>
					<li ><a data-toggle="tab" href="#address-book">Sổ địa chỉ</a></li>
					<li > <a data-toggle="tab" href="#changepass">Đổi mật khẩu</a></li>
					<li ><a data-toggle="tab" href="#favousrite-product">Sản phẩm yêu thích</a></li>
					<li ><a data-toggle="tab" href="#favousrite-shop">Shop yêu thích</a></li>
					<li ><a data-toggle="tab" href="#complain">Danh sách góp ý</a></li>
					<li ><a data-toggle="tab" href="#notification">Danh sách thông báo</a></li>
					<li><a data-toggle="tab" href="#logout">Thoát</a></li>
				  </ul>
				</div>
				<div class="col-xs-9 profile-content">
				  <div id="profile" class="tab-pane fade in">
					<?php $this->load->view('customer/profile'); ?>
				  </div>
				  <div id="changepass" class="tab-pane fade in ">	
					<?php $this->load->view('customer/changepass'); ?>
				  </div>
				</div>
			</div>
		 </div>
	   </div>
    </div>