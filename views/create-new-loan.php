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
                <h5 class="mb-3">Create New Loan</h5>
                <small aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="loans">Loans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create New Loan</li>
                    </ol>
                </small>
			</div>
			<div class="row mx-0">
				<div class="col-12 px-0">
					<div class="form-main-div px-3 pb-3">
                        <div>
                            <div class="row mx-0">
                                <div class="pt-3 pb-0 py-lg-3 col-12 px-3 mb-4 mb-lg-2 d-flex align-items-center justify-content-between">
                                    <strong class="text-secondary text-nowrap">Loan Form Information</strong>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#percentage-modal">
                                            <i class="ri-percent-line me-1"></i>Percent Rate
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                            <form class="create-new-loan row mx-0 row-gap-3" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" >
                                <input type="hidden" name="id" id="loan_id" value="<?= $editLoans['id'] ?? ''; ?>">
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating form-floating-select">
                                        <label for="barrower">Select Barrower Name</label>
                                        <select required name="barrower_id" class="dropdown-select2 form-select" id="barrower" aria-label="Floating label select example">
                                            <option selected hidden Disabled value="">Borrower Name</option>
                                            <?php foreach ($fetchBarrower as $b):?>
                                            <option <?= (isset($editLoans['id']) && $editLoans['barrower_id'] == $b['id']) ? 'selected' : ''; ?> value="<?= $b['id']; ?>"><?= htmlspecialchars($b['full_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating form-floating-select">
                                        <label for="collector">Select Collector Name</label>
                                        <select required name="collector_id" class="dropdown-select2 form-select" id="collector" aria-label="Floating label select example">
                                            <option selected hidden Disabled value="">Collector Name</option>
                                            <?php foreach ($fetchCollector as $c):?>
                                            <option <?= (isset($editLoans['id']) && $editLoans['collector_id'] == $c['id']) ? 'selected' : ''; ?> value="<?= $c['id']; ?>"><?= htmlspecialchars($c['full_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 px-0 row mx-0 row-gap-4 mb-2 mb-lg-0">
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating">
                                            <input value="<?= $editLoans['amount'] ?? ''; ?>" required type="number" name="amount" class="form-control" id="amount" placeholder="input here">
                                            <label for="amount">Loan Amount</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating">
                                            <input value="<?= $editLoans['barrow_date'] ?? ''; ?>" required type="date" name="barrow_date" class="form-control" id="barrow_date" placeholder="input here">
                                            <label for="barrow_date">Barrowed Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 px-0 row mx-0 row-gap-4">
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-select">
                                            <label for="loan_option">Payment Option</label>
                                            <select required name="loan_option" class="dropdown-select2 form-select" id="loan_option" aria-label="Floating label select example">
                                                <option selected hidden Disabled value="">Choose Payment Option</option>
                                                <option <?= (isset($editLoans['id']) && $editLoans['loan_option'] == '1') ? 'selected' : ''; ?> value="1">Weekly Payment</option>
                                                <option <?= (isset($editLoans['id']) && $editLoans['loan_option'] == '2') ? 'selected' : ''; ?> value="2">Semi-Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="file" name="loans_imgs" accept="image/jpeg, image/jpg, image/png, image/webp" class="form-control" id="proof_img" placeholder="input here">
                                            <label for="proof_img">Loan Images</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-secondary border-0 rounded-0 p-4">
                                        <strong class="text-secondary">
                                            <i class="ri-calculator-line me-2"></i>Loan Summary Preview
                                        </strong>
                                        <div class="row mx-0 row-gap-3 justify-content-lg-between mt-3">
                                            <div class="col-12 col-lg-3 px-0 ps-lg-0">
                                                <div class="bg-white rounded-2 p-3 d-flex flex-column align-items-center shadow-sm">
                                                    <small>Loan Amount</small>
                                                    <div class="fw-bold text-primary">
                                                        ₱<span class="display_loan">
                                                            <?= $editLoans['amount'] ?? '0.00'; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 px-0">
                                                <div class="bg-white rounded-2 p-3 d-flex flex-column align-items-center shadow-sm">
                                                    <small>Interest</small>
                                                    <div class="fw-bold text-danger">
                                                         ₱<span class="display_interest">
                                                            <?= $editLoans['interest'] ?? '0.00'; ?>
                                                         </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 px-0">
                                                <div class="bg-white rounded-2 p-3 d-flex flex-column align-items-center shadow-sm">
                                                    <small>Total to Return</small>
                                                    <div class="fw-bold text-success">
                                                        ₱<span class="display_return">
                                                            <?= $editLoans['return_amount'] ?? '0.00'; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                    <a href="loans" class="btn btn-secondary">
                                        <i class="ri-close-circle-line me-1"></i>Cancel
                                    </a>

                                    <button class="secondary_btn">
                                        <i class="ri-checkbox-circle-line me-1"></i>Create Loan
                                    </button>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include '../views/layouts/plugins-footer.php'; ?>
<?php include '../views/modal/percentage.php'; ?>
