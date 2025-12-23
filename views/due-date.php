<?php include '../views/layouts/plugins-header.php'; ?>

<div class="main-div">
	<!-- sidebar div -->
	<?php include "../views/layouts/sidebar.php";  ?>

	<!-- content div -->
	<div class="content-container">
		<!-- topbar div -->
		<?php include "../views/layouts/topbar.php";  ?>

        <div class="content-bottom">
			<div class="content-title">
				<h5>Due Date</h5>
			</div>
			<div class="row mx-0">
				<div class="col-12 px-0">
					<div class="table-main-div">
						<div class="table-header">
							<div>
                                <strong class="header-title text-secondary">Unpaid Barrower List</strong>
                            </div>
						</div>
						<div class="datatable-div">
							<table id="Datatable-format" class="display responsive" width="100%">
								<thead>
									<tr>
										<th class="desktop">ID</th>
										<th class="all">Barrower</th>
										<th class="min-phone-l">Collector</th>
										<th class="min-tablet">Amount</th>
										<th class="min-tablet">Penalty</th>
										<th class="min-tablet">Total</th>
										<th class="desktop">Deadline Date</th>
									</tr>
								</thead>
								<tbody>
									<?php 
                                    

										foreach($fetchCollector as $fdd): 
                                            
                                            if (empty(array_filter($fdd))) {
                                                continue;
                                            }
										
										$current_date = date('Y-m-d');

										 // Create DateTime objects for both dates
										$deadlineDateTime = new DateTime($fdd['deadline_date']);
										$currentDateTime = new DateTime($current_date);
										
										// Calculate the difference between the two dates
										$interval = $deadlineDateTime->diff($currentDateTime);
										$daysDifference = $interval->days;

										$penalty_val = $fdd['l_amount'] * (	$fdd['rate_penalty'] / 100 );		
                                        $total_penalty = $daysDifference * $penalty_val;
										

										$total_return = $total_penalty + $fdd['l_amount'];
                                        
										?>
										
										<tr>
											<td><?= $fdd['id'] ?></td>
											<td class="text-nowrap"><?= htmlspecialchars($fdd['b_fn']) ?></td>
											<td class="text-nowrap"><?= htmlspecialchars($fdd['c_fn']) ?></td>
											<td><?= number_format($fdd['amount'], 2); ?></td>
											<td><?= number_format($total_penalty, 2); ?></td>
											<td><?= number_format($total_return, 2); ?></td>
											<td><?= date("F d Y", strtotime($fdd['deadline_date'])) ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Barrower</th>
										<th>Collector</th>
										<th>Amount</th>
										<th>Penalty</th>
										<th>Total</th>
										<th>Deadline Date</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../views/layouts/plugins-footer.php'; ?>
