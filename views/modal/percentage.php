

<div class="modal fade" id="percentage-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" >
  	<div class="modal-dialog">
    	<div class="modal-content border-0 shadow">
            <div class="modal-header d-flex justify-content-between align-items-center py-3">
                <div class="modal-title">
                    <i class="ri-percent-line text-info fs-1"></i>Percentage Rate
                </div>
                <div role="button" class="close-modal " data-bs-dismiss="modal">
                    <i class="ri-close-line fs-3"></i>
                </div>
            </div>
                <div class="modal-body">
                    <div class="row row-gap-3 mx-0">
                        <input type="hidden" name="users_id" id="users_id" class=" form-control rounded-1" placeholder="enter here">
                        <input type="hidden" name="method" id="role">
                        <!-- <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" > -->
                        <div class="col-12 col-lg-6 px-0 px-lg-1">
                            <small class="form-label" for="p_interest">Weekly Interest</small>
                            <div class="input-group mt-2">
                                <input disabled type="number" class="p_interest form-control form-control-sm" placeholder="Interest" value="<?= number_format($p['p_interest'], 2); ?>">
                                <span class="input-group-text d-none d-lg-block"><small>%</small></span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 px-0 px-lg-1">
                            <small class="form-label" for="p_penalty">Weekly Penalty</small>
                            <div class="input-group mt-2">
                                <input disabled type="number" class="p_penalty form-control form-control-sm" placeholder="Interest" value="<?= number_format($p['p_penalty'], 2); ?>">
                                <span class="input-group-text d-none d-lg-block"><small>%</small></span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 px-0 px-lg-1">
                            <small class="form-label" for="sm_interest">Semi-Monthly Interest</small>
                            <div class="input-group mt-2">
                                <input disabled type="number" class="sm_interest form-control form-control-sm" placeholder="Interest" value="<?= number_format($p['sm_interest'], 2); ?>">
                                <span class="input-group-text d-none d-lg-block"><small>%</small></span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 px-0 px-lg-1">
                            <small class="form-label" for="sm_penalty">Semi-Monthly Penalty</small>
                            <div class="input-group mt-2">
                                <input disabled type="number" class="sm_penalty form-control form-control-sm" placeholder="Interest" value="<?= number_format($p['sm_penalty'], 2); ?>">
                                <span class="input-group-text d-none d-lg-block"><small>%</small></span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 px-0 px-lg-1">
                            <small class="form-label" for="p_collector">Collector</small>
                            <div class="input-group mt-2">
                                <input disabled type="number" class="p_collector form-control form-control-sm" placeholder="Interest" value="<?= number_format($p['p_collector'], 2); ?>">
                                <span class="input-group-text d-none d-lg-block"><small>%</small></span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 px-0 px-lg-1">
                            <small class="form-label" for="capital">Capital</small>
                            <div class="input-group mt-2">
                                <span class="input-group-text d-none d-lg-block"><small>₱</small></span>
                                <input disabled type="text" class="capital form-control form-control-sm" placeholder="Interest" value="<?= number_format($p['capital'], 2); ?>">
                            </div>
                        </div>
                        
                                
                    </div>
                </div>
                <div class="modal-footer py-3 d-flex justify-content-between align-items-center">
                    
                    <button type="button" class="edit_percent btn btn-custom-edit"><i class="ri-pencil-line me-1"></i>Edit</button>

                    <div>
                        <button type="button" class="btn btn-custom-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="save_percent btn btn-custom-save">Save Changes</button>
                    </div>
                </div>
  		</div>
	</div>
</div>







