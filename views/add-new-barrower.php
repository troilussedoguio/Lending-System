<?php include '../views/layouts/plugins-header.php'; 

use models\Images;?>

<div class="main-div">
	<!-- sidebar div -->
	<?php include "../views/layouts/sidebar.php";  ?>

	<!-- content div -->
	<div class="content-container">
		<!-- topbar div -->
		<?php include "../views/layouts/topbar.php";  ?>

        <div class="content-bottom">
			<div class="content-title">
				<h5 class="mb-3">Add New Barrower</h5>
                <small aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="barrower">Barrower</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New Barrower</li>
                    </ol>
                </small>
			</div>
			<div class="row mx-0">
				<div class="col-12 col-xxl-6 px-0 pe-lg-2">
					<div class="form-main-div px-3 pb-3">
                        <form class="add_new_user" method="POST" enctype="multipart/form-data">
                            <div class="row mx-0 row-gap-4">
                                <div class="col-12 pt-4">
                                    <strong class="text-secondary">Barrower Form Information</strong>
                                    <hr>
                                </div>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" >
                                <input type="hidden" name="role" class="role" value="1">
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?? ''; ?>" readonly>
                                <div class="col-12 col-lg-6">   
                                    <div class="form-floating">
                                        <input value="<?= $edit['user']['full_name'] ?? ''; ?>" type="text" name="full_name" class="form-control" id="full_name" placeholder="input here">
                                        <label for="full_name">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating">
                                        <input value="<?= $edit['user']['email'] ?? ''; ?>" type="email" name="email" class="form-control" id="email" placeholder="input here">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating">
                                        <input value="<?= $edit['user']['phonenumber'] ?? ''; ?>" type="number" name="phonenumber" class="form-control" id="phonenumber" placeholder="input here">
                                        <label for="phonenumber">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="user_imgs[]" class="form-control" id="collector_imgs" placeholder="Choose images" accept="image/jpeg, image/png, image/gif" multiple>
                                        <label for="upload_imgs">Upload Images</label>
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center justify-content-end gap-2">
                                    <a href="loans" class="btn btn-secondary">
                                        <i class="ri-close-circle-line me-1"></i>Cancel
                                    </a>

                                    <button class="secondary_btn">
                                        <i class="ri-checkbox-circle-line me-1"></i>Create Collector
                                    </button>
                                </div>
                            </div>
                        </form>
					</div>
				</div>
                <div class="img_main_div col-12 col-xxl-6 px-0 ps-lg-2 bg-white rounded-2 ">
                    <div class="row mx-0 p-4 row-gap-3">
                        
                        <?php 
                        if (!empty($edit['images'])):
                        foreach ($edit['images'] as $images):?>
                        <div class="col-6 col-md-6 col-lg-4 px-1">
                            <div class="img_card_div position-relative border border-2 overflow-hidden rounded-2 border-warning">
                                <img src="upload_files/user_imgs/<?= $images['img_file']; ?>" alt="add_barrower" class="img-fluid rounded-2">
                                <div class="img_actions position-absolute top-50 start-50 translate-middle align-items-center justify-content-center gap-4">
                                    <div class="delete_user_img" data-id="<?= $images['id']; ?>" type="button">
                                        <i class="ri-delete-bin-2-line text-danger fs-3"></i>
                                    </div>
                                    <a target="_blank" href="upload_files/user_imgs/<?= $images['img_file']; ?>" class="text-decoration-none">
                                        <i class="ri-search-eye-line text-primary fs-3"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;
                        else:
                            echo "No Images Found";
                        endif;?>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<?php include '../views/layouts/plugins-footer.php'; ?>
