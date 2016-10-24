<div class="container p-full">
	  <div class="container-profile">
		<nav class="navbar navbar-default profile-menu-top">
		  <div class="row">
			<div class="col-md-12">
			  <ul class="nav navbar-nav">
				<li class=" default "><a href="#">Quản lý tài khoản</a></li>
				<li class=" active "><a href="#">Quản lý mua hàng</a></li>
				<li class=" default "><a href="#">Tài khoản trả trước</a></li>
			
			  </ul>
			</div>
		  </div>
		</nav>
		<div class="profile clearfix">
		  <div class="col-xs-3">
			<ul class="profile-menu-left">
			  <li class="user"><i class="glyphicon glyphicon-user"></i>Xin chào,<br>dendimon    </li>
			  <li class="active"><a href="list.html">Danh sách đơn hàng</a></li>
			  <li ><a href="list.html">Danh sách khiếu nại</a></li>
			  <li ><a href="list.html">Danh sách hoàn tiền</a></li>
			  <li><a href="#" data-method="post">Thoát</a></li>
			</ul>
		  </div>
		  <div class="col-xs-9 profile-content">
			<div class="profile-title">Danh sách đơn đặt hàng</div>
			<div>
			  <div class="my-account-orders">
				<div>
				  <div class="clearfix">
					<div class="box-search-order">
					  <form id="w0" class="order-search" action="/my-order/index" method="get">
						<div class="clearfix">
						  <div class="form-group field-searchorderform-order_id">
							<label class="control-label" for="searchorderform-order_id">Mã đơn hàng</label>
							<input type="text" id="searchorderform-order_id" class="form-control" name="SearchOrderForm[order_id]" maxlength="99" placeholder="Mã đơn hàng">
							<div class="help-block"></div>
						  </div>
						  <div class="form-group field-searchorderform-order_status">
							<label class="control-label" for="searchorderform-order_status">Trạng thái</label>
							<select id="searchorderform-order_status" class="form-control" name="SearchOrderForm[order_status]">
							  <option value="">--Tất cả--</option>
							  <option value="1">Chờ thanh toán</option>
							  <option value="2">Đã thanh toán</option>
							  <option value="3">Người mua hủy</option>
							  <option value="4">Hệ thống hủy</option>
							</select>
							<div class="help-block"></div>
						  </div>
						  <div class="form-group field-searchorderform-order_type">
							<label class="control-label" for="searchorderform-order_type">Loại thanh toán</label>
							<select id="searchorderform-order_type" class="form-control" name="SearchOrderForm[order_type]">
							  <option value="0">Thanh toán ngay</option>
							  <option value="1">Thanh toán khi nhận hàng</option>
							  <option value="" selected>Tất cả</option>
							</select>
							<div class="help-block"></div>
						  </div>
						  <div class="form-group">
							<label class="control-label">Thời gian đặt hàng</label>
							<div class="filter-date">
							  <div class="form-group field-searchorderform-begin_date">
								<div><input type="text" id="searchorderform-begin_date" class="form-control" name="SearchOrderForm[begin_date]" placeholder="Từ ngày"></div>
							  </div>
							  <div class="form-group field-searchorderform-end_date">
								<div><input type="text" id="searchorderform-end_date" class="form-control" name="SearchOrderForm[end_date]" placeholder="đến ngày"></div>
							  </div>
							</div>
						  </div>
						</div>
						<div>
						  <input type="hidden" name="SearchOrderForm[show_order_drop]" value="0"><input type="checkbox" id="searchorderform-show_order_drop" name="SearchOrderForm[show_order_drop]" value="1" style="height: auto;">                        <label for="searchorderform-show_order_drop" style="margin-left: 10px; cursor: pointer;">Đơn
						  hàng đã
						  hủy</label>
						</div>
						<button type="submit" class="btn btn-primary searching">Lọc đơn hàng</button>                    
					  </form>
					</div>
				  </div>
				  <div class="alert alert-info">Sau 7 ngày kể từ khi thanh toán, nếu quý khách chưa nhận được hàng hãy liên hệ
					với
					Luuthong.vn để được hỗ trợ: 04.7303 1999
				  </div>
				  <div id="w1" class="list-view-orders list-view">
					<div class="item-view" data-key="1004979">
					  <div class="order-item">
						<div class="order-item-header item-header">
						  ĐH: <a href="#"><span class="order-id">1004979</span></a> <span
							class="order-time-created">11/10/2016 16:16:29</span>
						  Gian
						  hàng: <a class="shop-name" href="http://mpttshop.luuthong.vn" target="_blank">Mỹ phẩm thời trang</a>                    
						  <div class="pull-right">Chờ thanh toán</div>
						</div>
						<div class="order-item-middle item-middle">
						  <table class="order-detail full-width">
							<thead>
							  <tr class="bg-order-item">
								<th>STT</th>
								<th class="text-center" style="width: 15%;">Mã đơn</th>
								<th class="text-center" style="width: 10%;">Số lượng</th>
								<th class="text-center" style="width: 15%;">Thành tiền</th>
							  </tr>
							</thead>
							<tbody>
							  <tr class="">
								<td class="order-detail-image">
								  <!-- image -->
								  <a class="thumbs-product-image responsive-img" href="#" target="_blank">
								  <img src="../images/494b826e6dfcecb71d9bda0c8e7efd46.100x100.jpg" alt=""></a>                            
								</td>
								<td class="oder-detail-product-info">
								  <a class="product-name" href="#" target="_blank">Quần Legging nữ khóa kéo hiện đại</a>                                                                                
								  <p style="margin-top: 5px; margin-bottom: 5px; font-weight: bold;">
									<label>size</label>&nbsp;:<label>M</label>
								  </p>
								  <p style="margin-top: 5px; margin-bottom: 5px; font-weight: bold;">
									<label>Màu sắc</label>&nbsp;:<label>xám- trơn</label>
								  </p>
								</td>
								<td class="order-detail-price text-price text-bold">
								  <span>55.000 đ</span>
								</td>
								<td class="order-detail-quantity">
								  <span>1</span>
								</td>
								<td class="order-detail-total text-price">
								  <span>55.000 đ</span>
								</td>
							  </tr>
							  <tr class="">
								<td class="order-detail-image">
								  <!-- image -->
								  <a class="thumbs-product-image responsive-img" href="#" target="_blank">
								  <img src="../images/a6eb15abdb2d71fa744a125eac77e888.100x100.jpg" alt=""></a>                            
								</td>
								<td class="oder-detail-product-info">
								  <a class="product-name" href="#" target="_blank">Áo khoác nữ nỉ bông, họa tiết ô vuông hiện đại</a>                                                                                
								  <p style="margin-top: 5px; margin-bottom: 5px; font-weight: bold;">
									<label>màu sắc</label>&nbsp;:<label>đen</label>
								  </p>
								</td>
								<td class="order-detail-price text-price text-bold">
								  <span>99.000 đ</span>
								</td>
								<td class="order-detail-quantity">
								  <span>1</span>
								</td>
								<td class="order-detail-total text-price">
								  <span>99.000 đ</span>
								</td>
							  </tr>
							</tbody>
						  </table>
						</div>
						<div class="order-item-footer clearfix">
						  <ul class="pull-right">
							<li class="label-title">Tiền hàng:</li>
							<li class="value">
							  <span
								class="total-money text-bold text-price">154.000đ</span>
							</li>
							<li class="label-title">Phí vận chuyển:</li>
							<li class="value">
							  <span
								class="total-transporting">23.000đ</span>
							</li>
							<li class="label-title">Thành tiền:</li>
							<li class="value">
							  <span
								class="final-money text-bold text-price">177.000đ</span>
							</li>
						  </ul>
						</div>
						<div class="text-right button-checkout">
						  <a class="btn btn-danger" href="#" style="margin-right: 5px;">Hủy đơn hàng</a>
						  <a class="btn btn-primary" href="/my-order/payment?id=1004979" data-method="post">Thanh toán đơn hàng</a>                                            
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
				<div class="modal-dialog" role="document" style="width: 400px;">
				  <div class="modal-content">
				  </div>
				  <!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			  </div>
			  <!-- /.modal -->
			</div>
		  </div>
		</div>
	  </div>
	</div>