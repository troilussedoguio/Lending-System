<!-- add client modal -->

<div class="modal fade" id="create-loan-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" >
  	<div class="modal-dialog">
    	<div class="modal-content border-0 shadow">
      		<div class="modal-body">
                <div class="position-relative px-4 py-2">
                    <div class="modal-title">Create New Loan</div>
              		<div role="button" class="position-absolute top-0 end-0 text-danger" 
                    data-bs-dismiss="modal">
              			<svg style="width: 30px; height: 30px;" class="icon-size" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>
              		</div>
                </div>
    	        <form id="create-loan-form" method="POST" class="row row-gap-3 mx-0 p-4">
                    <input type="hidden" name="l_total_loan_id" id="l_total_loan_id" class=" form-control rounded-1" placeholder="enter here">

                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating">
                            <select name="lending_client_id" id="lending_client_id" class="form-select  rounded-1" placeholder="enter here">
                                <option selected hidden>Select Client</option>
                                <?php
                                foreach ($clients as $client) {
                                   echo '<option value="'.$client['lending_client_id'].'">'.$client['l_client_name'].'</option>';
                                }
                                ?>
                            </select>
                            <label class="form-label" for="lending_client_id">Client Name</label>
                        </div>
                    </div>
                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating">
                            <select name="lending_agent_id" id="lending_agent_id" class="form-select  rounded-1" placeholder="enter here">
                                <option selected hidden>Select Agent</option>
                                <?php
                                foreach ($agents as $agent) {
                                   echo '<option value="'.$agent['lending_agent_id'].'">'.$agent['l_agent_name'].'</option>';
                                }
                                ?>
                            </select>
                            <label class="form-label" for="lending_agent_id">Agent Name</label>
                        </div>
                    </div>

                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating px-0">
                            <input type="number" name="l_amount" id="l_amount" class=" form-control rounded-1" placeholder="enter here">
                            <label class="form-label" for="l_amount">Total Loan</label>
                        </div>
                    </div>  
                    
                    <div class="col-11 col-lg-12 px-0">
                        <div class="form-floating px-0">
                            <input type="date" name="created_date" id="created_date" class=" form-control rounded-1" placeholder="enter here">
                            <label class="form-label" for="created_date">Loan Date</label>
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







