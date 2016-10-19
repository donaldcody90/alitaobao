
<div class="profile-title">Thông tin tài khoản</div>
<div>
  <table id="w0" class="table table-striped table-bordered detail-view">
    <tr>
      <th>Tên đăng nhập</th>
      <td><?php echo $customer['username']?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?php echo $customer['email']?></td>
    </tr>
    <tr>
      <th>Số điện thoại</th>
      <td><?php echo $customer['phone']?></td>
    </tr>
    <tr>
      <th>Thời gian tạo</th>
      <td><?php echo $customer['create_date']?></td>
    </tr>
  </table>
  <a class="btn btn-primary" href="/my-account/create-profile">Tạo thông tin hồ sơ</a>
</div>
</div>