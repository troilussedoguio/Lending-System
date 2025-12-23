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
				<h5>Collector List</h5>
			</div>
			<div class="row mx-0">
				<div class="col-12 px-0">
					<div class="table-main-div">
						<div class="table-header">
							<div class="d-flex justify-content-between row-gap-3">
                                <strong class="header-title text-secondary">Collector Informations</strong>
                                <a href="add-new-collector.php" class="btn btn-primary btn-sm">
									<i class="ri-add-line"></i>   
									<span class="d-none d-lg-inline-block">Add New Collector</span>
								</a>
                            </div>
						</div>
						<div class="datatable-div">
							<table id="Datatable-format" class="display responsive" width="100%">
								<thead>
									<tr>
										<th class="desktop">ID</th>
										<th class="min-phone-l">Full Name</th>
										<th class="min-phone-l">Email</th>
										<th class="min-phone-l">Phone No.</th>
										<th class="min-phone-l">Date</th>
										<th class="all no-sort" width="5px"></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($fetchCollector as $c): 
										unset($c['password']); 
										?>
										
										<tr>
											<td><?= $c['id'] ?></td>
											<td class="text-nowrap"><?= htmlspecialchars($c['full_name']) ?></td>
											<td><?= htmlspecialchars($c['email']) ?></td>
											<td><?= htmlspecialchars($c['phonenumber']) ?></td>
											<td><?= date("F d Y", strtotime($c['added_date'])) ?></td>
											<td>
												<div class="user_actions d-flex align-items-center justify-content-center gap-3">
													<a href="add-new-collector?id=<?= $c['id'] ?>" class=" text-decoration-none text-info">
														<i class="ri-edit-box-line fs-4"></i>
													</a>
													<a href="#" type="button" class="btn_delete_user text-decoration-none text-danger" data-id="<?= $c['id'] ?>" data-role="<?= $c['role'] ?>">
														<i class="ri-delete-bin-6-line fs-4"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<th>ID</th>
										<th>Full Name</th>
										<th>Email</th>
										<th>Phone Number</th>
										<th>Date</th>
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
<?php include '../views/modal/delete-users.php'; ?>