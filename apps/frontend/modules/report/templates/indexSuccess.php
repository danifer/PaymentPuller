<h1>Recent Transactions</h1>
<hr />
<h2>PayPal</h2>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <th>timestamp</th>
    <th>type</th>
    <th>email</th>
    <th>name</th>
    <th>transaction_id</th>
    <th>amount</th>
    <th>fee_amount</th>
    <th>net_amount</th>
    <th>created_at</th>
  </tr>
  <?php foreach ($paypal as $key => $paypal): ?>
    <tr>
      <td><?php echo $paypal['timestamp'] ?></td>
      <td><?php echo $paypal['type'] ?></td>
      <td><?php echo $paypal['email'] ?></td>
      <td><?php echo $paypal['name'] ?></td>
      <td><?php echo $paypal['transaction_id'] ?></td>
      <td><?php echo $paypal['amount'] ?></td>
      <td><?php echo $paypal['fee_amount'] ?></td>
      <td><?php echo $paypal['net_amount'] ?></td>
      <td><?php echo $paypal['created_at'] ?></td>
    </tr>
  <?php endforeach ?>
</table>

<h2>Authorize.net</h2>
<table class="table table-striped table-bordered table-condensed">
  <tr>
    <th>trans_id</th>
    <th>batch_id</th>
    <th>submit_time_utc</th>
    <th>transaction_status</th>
    <th>name</th>
    <th>account_type</th>
    <th>settle_amount</th>
    <th>created_at</th>
  </tr>
  <?php foreach ($auth_net as $key => $auth_net): ?>
    <tr>
      <td><?php echo $auth_net['trans_id'] ?></td>
      <td><?php echo $auth_net['batch_id'] ?></td>
      <td><?php echo $auth_net['submit_time_utc'] ?></td>
      <td><?php echo $auth_net['transaction_status'] ?></td>
      <td><?php echo trim($auth_net['first_name'].' '.$auth_net['last_name']) ?></td>
      <td><?php echo $auth_net['account_type'] ?></td>
      <td><?php echo $auth_net['settle_amount'] ?></td>
      <td><?php echo $auth_net['created_at'] ?></td>
    </tr>
  <?php endforeach ?>
</table>