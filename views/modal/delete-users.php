

<div class="modal fade" id="delete-users-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" >
  	<div class="modal-dialog">
    	<div class="modal-content border-0 shadow">
            <div class="modal-header d-flex justify-content-between align-items-center py-3">
                <div class="modal-title">
                    <i class="ri-error-warning-fill text-danger fs-1"></i>Confirm Deletion
                </div>
                <div role="button" class="close-modal " data-bs-dismiss="modal">
                    <i class="ri-close-line fs-3"></i>
                </div>
            </div>
            <form id="delete-user-form" method="POST">
                <div class="modal-body">
                    <div class="row row-gap-3 mx-0">
                        <input type="hidden" name="users_id" id="users_id" class=" form-control rounded-1" placeholder="enter here">
                        <input type="hidden" name="method" id="role">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" >
                        <div class="col-lg-12 px-0">
                            <div class="warning-text alert alert-warning" role="alert">
                                <strong class="fw-bold">
                                    <i class="ri-information-2-line me-3"></i>Warning
                                </strong>
                                <div>
                                    You are about to permanently delete this item. This action cannot be undone and all associated data will be lost.
                                </div>
                            </div>
                        </div>
                                    
                    </div>
                </div>
                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-custom-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-custom-delete">Delete Permanently</button>
                </div>
            </form>
  		</div>
	</div>
</div>







