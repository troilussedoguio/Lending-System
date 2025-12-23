<!-- add client modal -->

<div class="modal fade" id="add-client" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" >
  	<div class="modal-dialog">
    	<div class="modal-content border-0 shadow">
      		<div class="modal-body">
                <div class="position-relative px-4 py-2">
                    <div class="modal-title">Add New Client</div>
              		<div role="button" class="position-absolute top-0 end-0 text-danger" 
                    data-bs-dismiss="modal">
              			<svg style="width: 30px; height: 30px;" class="icon-size" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>
              		</div>
                </div>
    	        <form id="add-client-form" method="POST" class="row row-gap-3 mx-0 p-4">
                    <input type="hidden" name="lending_client_id" id="lending_client_id" class=" form-control rounded-1" placeholder="enter here">

                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating px-0">
                            <input type="text" name="l_client_name" id="l_client_name" class=" form-control rounded-1" placeholder="enter here">
                            <label class="form-label" for="l_client_name">Client Name</label>
                        </div>
                    </div>  
                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating px-0">
                            <input type="number" name="l_contact_number" id="l_contact_number" class=" form-control rounded-1" placeholder="enter here">
                            <label class="form-label" for="l_contact_number">Contact Number</label>
                        </div>
                    </div>
                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating">
                            <select name="l_gender" id="l_gender" class="form-select  rounded-1" placeholder="enter here">
                                <option selected hidden>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label class="form-label" for="l_gender">Gender</label>
                        </div>
                    </div>
                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating px-0">
                            <input type="text" name="l_work" id="l_work" class=" form-control rounded-1" placeholder="enter here">
                            <label class="form-label" for="l_work">Work</label>
                        </div>
                    </div>

                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating px-0">
                            <input type="text" name="l_address" id="l_address" class=" form-control rounded-1" placeholder="enter here">
                            <label class="form-label" for="l_address">Address</label>
                        </div>
                    </div>
                    <div class="col-11 col-lg-12 px-0">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
      		</div>
  		</div>
	</div>
</div>







