	<div class="container p-full">
        <div class="container-profile">
		<!-- Start Tab Content -->
          <div class="navbar navbar-default profile-menu-top">
            <div class="row">
              <div class="col-md-12">
                <ul class="nav nav-tabs">
                  <li><a data-toggle="tab" href="#acc">Quản lý tài khoản</a></li>
                  <li><a data-toggle="tab" href="#buy">Quản lý mua hàng</a></li>
                  <li><a data-toggle="tab" href="#bank">Tài khoản trả trước</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="profile clearfix">
            <div id="#acc" class="tab-pane active"> 
				<div class="col-xs-3">
				 <ul class="profile-menu-left nav nav-tabs horizontal-tab">
					<li class="user"><i class="glyphicon glyphicon-user"></i>Xin chào,<br>dendimon    </li>
					<li class="active"><a data-toggle="tab" href="#profile" onclick="loadAjax('<?php echo site_url('customer/profile'); ?>','profile')" >Thông tin tài khoản</a></li>
					<li ><a data-toggle="tab" href="#address-book" onclick="loadAjax('<?php echo site_url('customer/address_book'); ?>','address_book')"  >Sổ địa chỉ</a></li>
					<li ><a data-toggle="tab" href="#changepass" onclick="loadAjax('<?php echo site_url('customer/changepass'); ?>','changepass')">Đổi mật khẩu</a></li>
					<li ><a data-toggle="tab" href="#favousrite_product" onclick="loadAjax('<?php echo site_url('customer/favousrite_product'); ?>','favousrite_product')">Sản phẩm yêu thích</a></li>
					<li ><a data-toggle="tab" href="#favousrite_shop" onclick="loadAjax('<?php echo site_url('customer/favousrite_shop'); ?>','favousrite_shop')">Shop yêu thích</a></li>
					<li ><a data-toggle="tab" href="#complain" onclick="loadAjax('<?php echo site_url('customer/complain'); ?>','complain')">Danh sách góp ý</a></li>
					<li ><a data-toggle="tab" href="#notification" onclick="loadAjax('<?php echo site_url('customer/notification'); ?>','notification')">Danh sách thông báo</a></li>
					<li ><a data-toggle="tab" href="#logout">Thoát</a></li>
				  </ul>
				</div>
				<div class="col-xs-9 profile-content" id="customer">
				  <div id="profile"  class="tab-pane active customer_div">
				  </div>
				</div>
			</div>
		 </div>
	   </div>
    </div>