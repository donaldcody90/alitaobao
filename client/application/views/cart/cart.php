<div class="container p-full">
  <div class="shopping-cart-index">
    <div class="row">
      <div class="col-md-1 col-lg-1 col-sm-1"></div>
      <div class="cart-content">
        <div class="alert alert-success"><strong>Lưu ý: </strong>
          Người bán cam kết và sẽ chịu trách nhiệm về chất lượng sản phẩm.
        </div>
        <div class="product-shop-cart">
          <h3 style="font-weight: bold">Giỏ hàng của bạn</h3>
          <h4>(2 sản phẩm)</h4>
        </div>
        <div class="boder-shop-cart">
          <div class="title-shop">
            <div class="bg-title">Được bán bởi: <a href="#" target="_blank">Shop name</a><a
              name="s1001907"></a></div>
            <div class="bg-dv">
              Dịch vụ của shop:
              <div class="tooltips">
                <i class="hz-icon icon-24h"></i> Giao hàng trong 24h
              </div>
              <div class="tooltips-free">
                <i class="hz-icon icon-shipping"></i> Miễn phí vận chuyển
              </div>
            </div>
          </div>
		  <?php $this->load->view('_base/message'); ?>
		  <form id="frm-checkout" action="<?php echo site_url('cart/checkout');?>" method="post">
          <table class="table table-shopping-cart" id="item-shop-cart-1001907" data-shop-id="1001907">
            <thead>
              <tr class="bg-warning">
                <th><input type="checkbox"  value="all"></th>
                <th>Thông tin sản phẩm</th>
                <th style="width: 22%;" class="">Giá bán</th>
                <th style="width: 20%;" class="">Số lượng</th>
                <th style="width: 10%;" class=""></th>
              </tr>
            </thead>
			
            <tbody>
			<?php foreach($array_product as $key=>$value){ ?>
			  <tr class="tr_seller">
				<td colspan="5">
					<span>Người Bán:</span>
					<?php echo $value['sid']; ?>
				</td>
			  </tr>
			  <?php foreach($value['item'] as $k=>$v){?>	
			  
              <tr class="sku-items">
				<td>
					<input type="checkbox" name="checkbox[]" value="<?php echo $value['sid'].'{:::}'.$v['id'];?>">
				</td>
                <td>
                  <div class="media">
                    <div class="media-left">
                      <div class="cart-product-img">
                        <a href="<?php echo $v['link']; ?>" class="responsive-img"
                          target="_blank">
                        <img src="<?php echo $v['image']; ?>" width="100" height="100" alt="">
						</a>
                      </div>
                    </div>
                    <div class="media-body">
                      <strong class="media-heading clearfix">
                      <a href="<?php echo $v['link']; ?>" target="_blank"><?php echo $v['name']; ?></a>
					  </strong>
                      <div class="p-info clearfix">
                        <div class="property-list">
                          <div class="f">
                            <span class="pfl">màu sắc:</span>
                            <strong
                              class="pfv">đen</strong>
                          </div>
                          <div class="f">
                            <span class="pfl">size:</span>
                            <strong
                              class="pfv">35</strong>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
				  <div class="losers">
                    <input type="text" class="form-losers" placeholder="Nhập mã giảm giá">
                    <button type="button" class="btn btn-danger btn-losers">Xác nhận</button>
                    <div class="text-losers">
                      <p style="color: #00aa00">MÃ GIÁM GIÁ ĐƯỢC ÁP DỤNG.</p>
                      Giảm: <samp style="color: #C40000;font-weight: bold">-10.000đ</samp>
                    </div>
                  </div>
                </td>
                <td class="sku-price">
                  <div class="price-range p-info price-range-select-1055999">
                    <div class="f"  data-price="189000">
                      <span class="pfv">
						<?php echo $v['price']; ?>
                      </span>
                    </div>
                  </div>
                </td>
                <td >
                  <input type="number" style="width: 50px;" name="quantity" min="1" value="<?php echo $v['qty']?>">
                </td>
                <td class="text-right">
                  <a class="cart-remove btn-remove" href="#" data-id="1224995" data-level="sku">Xóa sản phẩm</a>                    
                </td>
              </tr>
			  <?php } ?>
			<?php } ?>
            </tbody>
			</form>
            <tfoot>
              <tr>
                <td colspan="2">
                  <a class="cart-remove btn-remove" href="#" data-id="1001907" data-level="shop">
				  <i class="glyphicon glyphicon-remove"></i> Xóa tất cả</a>                
				  <a class="btn-summary" href="#" target="_blank">
				  <i class="glyphicon glyphicon-folder-close"></i> Chọn thêm sản phẩm khác</a>                                
                  <div class="protection pull-right">
                    <div class="hz-icon icon-protection protection-img">
                    </div>
                    <div class="protection-text">
                      <p style="font-size: 25px;font-weight: bold; color: #558b2f">Bảo hộ người  mua</p>
                      <p><i class="glyphicon glyphicon-check"></i> Hoàn tiền nếu không nhận được hàng hoặc thiếu hàng</p>
                      <p><i class="glyphicon glyphicon-check"></i> Bồi thường nếu sản phẩm không đúng theo mô tả</p>
                      <p><i class="glyphicon glyphicon-check"></i> Trả lại hàng khi sản phẩm không đúng theo mô tả</p>
                    </div>
                  </div>
                </td>
                <td colspan="2" class="text-right">
                  <div class="shopping-total">
                    <div class="shopping-total-cart">
                      <div class="order-amount" style="background: none;">
                        <ul>
                          <li class="text-plain ">Giảm:</li>
                          <li class="value"><span class="final-total-price">đ</span></li>
                          <li class="text-plain ">Phí vận chuyển:</li>
                          <li class="value"><span class="final-total-transport">0</li>
                          <li class="text-plain ">Tổng tiền:</li>
                          <li class="value"><span class="price">414.000</span><span class="price">đ</span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="shopping-button-right">
                      <button type="button" class="btn-update-cart btn btn-primary"> Cập nhật giỏ hàng</button>                                                    
					  <input type="submit" name="confirm_order" class="btn btn-danger btn-update" value="Đặt hàng">                                          
                    </div>
                  </div>
                </td>
              </tr>
            </tfoot>
          </table>
		  </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>