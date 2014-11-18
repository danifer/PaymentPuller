<h1>Check Paypal Recurring Payment Profiles</h1>
<hr />

<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<form action="" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> name="recurring_ids">
  <?php echo $form ?>
  <br>
  <button class="btn btn-large btn-warning confirm" type="submit">Check Now</button>
</form>

<?php if (count($results)): ?>
  <h2>Results</h2>
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <th>Profile id</th>
      <th>Status</th>
      <th>Aggregate amount</th>
      <th>Last payment date</th>
      <th>Last payment amount</th>
      <th>Outstanding balance</th>
      <th>Cycles completed</th>
      <th>Description</th>
    </tr>

    <?php
      $i=0;
      $aggregate = 0;
    ?>

    <?php foreach ($results as $id => $result): ?>
      <tr>
        <td nowrap><?php echo $id ?></td>
        <td nowrap><?php echo $result['status'] ?></td>
        <td nowrap><?php echo $result['aggregate_amount'] ?></td>
        <td nowrap><?php echo $result['last_payment_date'] ?></td>
        <td nowrap><?php echo $result['last_payment_amount'] ?></td>
        <td nowrap><?php echo $result['outstanding_balance'] ?></td>
        <td nowrap><?php echo $result['cycles_completed'] ?></td>
        <td><?php echo ($result['desc']) ?: 'Not Found' ?></td>
      </tr>
      <?php
        $i++;
        $aggregate += $result['aggregate_amount'];
       ?>
    <?php endforeach ?>

      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th><?php echo number_format($aggregate,2) ?></th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
  </table>
<?php endif ?>

