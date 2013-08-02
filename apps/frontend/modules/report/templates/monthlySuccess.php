
<h1>Gross Revenue</h1>
<hr />
<h2><?php echo $summary['months'] ?> Month Average</h2>
<small>excludes current month</small>
<table class="table table-striped table-bordered">
  <tr>
    <th>PayPal</th>
    <th>Authorize.net</th>
    <th>Total</th>
  </tr>
    <tr>
      <td>$<?php echo number_format($summary['avg_paypal'],2) ?></td>
      <td>$<?php echo number_format($summary['avg_auth_net'],2) ?></td>
      <td>$<?php echo number_format($summary['avg_total'],2) ?></td>
    </tr>
</table>

<h2>Monthly Total</h2>
<table class="table table-striped table-bordered">
  <tr>
    <th>Month/Year</th>
    <th>PayPal</th>
    <th>Authorize.net</th>
    <th>Total</th>
  </tr>
  <?php foreach ($results as $key => $result): ?>
    <tr>
      <td><?php echo $key ?></td>
      <td>$<?php echo number_format($result['paypal'],2) ?></td>
      <td>$<?php echo number_format($result['auth_net'],2) ?></td>
      <td>$<?php echo number_format($result['auth_net']+$result['paypal'],2) ?></td>
    </tr>
  <?php endforeach ?>
</table>
