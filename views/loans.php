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
				<h5>Loan List</h5>
			</div>
			<div class="row mx-0">
				<div class="col-12 px-0">
					<div class="table-main-div">
						<div class="table-header">
							<div class="d-flex justify-content-between row-gap-3">
                                <strong class="header-title text-secondary">Barrower Deadline</strong>
                                <a href="create-new-loan.php" class="btn btn-primary btn-sm">
									<i class="ri-add-line"></i>   
									<span class="d-none d-lg-inline-block">Create New Loan</span>
								</a>
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
										<th class="min-tablet">Interest</th>
										<th class="min-tablet">Return</th>
										<th class="desktop">Barrow Date</th>
										<th class="all no-sort" width="5px"></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($fetchLoans as $l): 
										?>
										
										<tr>
											<td><?= $l['id'] ?></td>
											<td class="text-nowrap"><?= htmlspecialchars($l['b_fn']) ?></td>
											<td class="text-nowrap"><?= htmlspecialchars($l['c_fn']) ?></td>
											<td>₱<?= number_format($l['amount'], 2) ?></td>
											<td>₱<?= number_format($l['interest'], 2) ?></td>
											<td>₱<?= number_format($l['return_amount'], 2) ?></td>
											<td><?= date("F d Y", strtotime($l['barrow_date'])) ?></td>
											<td >
												<div class="dropstart">
													<div role="button" data-bs-toggle="dropdown">
														<i class="ri-more-2-fill text-primary"></i>
													</div>
													<ul class="dropdown-menu border-0 shadow py-0">

														<?php
														switch ($l['loan_option']) {
															case '1':
																$loan_option_text = 'Weekly Payment';
																break;
															case '2':
																$loan_option_text = 'Semi Monthly';
																break;
														}
														?>
														<li class="dropdown-list">
															<button data-id="<?= $l['id']; ?>" data-option="<?= $l['loan_option']; ?>" class="payment_history dropdown-item py-3">
																<i class="ri-bill-line me-2"></i>
																<span><?= $loan_option_text ?></span>	
															</button>
														</li>
														<div class="dropdown-divider my-0"></div>
														<li class="dropdown-list">
															<a class="dropdown-item py-3" href="create-new-loan?id=<?= $l['id']; ?>">
																<i class="ri-pencil-line me-2"></i>
																<span>Edit</span>	
															</a>
														</li>
														<div class="dropdown-divider my-0"></div>
														<li class="dropdown-list">
															<a data-id="<?= $l['id']; ?>" class="delete_loans dropdown-item py-3" href="#">
																<i class="ri-delete-bin-line me-2"></i>
																<span>Delete</span>
															</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Barrower</th>
										<th>Collector</th>
										<th>Amount</th>
										<th>Interest</th>
										<th>Return</th>
										<th>Barrow Date</th>
										<th></th>
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
<?php include '../views/modal/weekly-payment-modal.php'; ?>
<?php include '../views/modal/delete-loan.php'; ?>