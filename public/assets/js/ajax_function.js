//========AJAX DELETING ALL DATA EACH TABLE HANDLING Start=========//
$(document).on('click', '.delete_btn', function(e){
    e.preventDefault(); // Prevent the default form submission


    var id = $(this).data('id');
    var id_type = $(this).data('id_type');
    var tablename = $(this).data('tablename');
    var functions = $(this).data('tablename');

    $.ajax({
        type: 'POST',
        url: 'class/delete_data.php',
        data: {id:id, id_type:id_type, tablename:tablename, functions:functions},
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {

            	var deletedRow = $('.delete_btn[data-id="' + id + '"]').closest('tr');
				deletedRow.remove();
            	
            	Swal.fire({
				  position: "center",
				  icon: "success",
				  html: "<b>"+response.message+"</b>",
				  showConfirmButton: false,
				  timer: 2000,
				  timerProgressBar: true,
				  width: '400px', // Set your desired width here
				  didOpen: (popup) => {
				    popup.onmouseenter = Swal.stopTimer;
				    popup.onmouseleave = Swal.resumeTimer;
				  }
				});


            } else {

            	Swal.fire({
				  position: "center",
				  icon: "error",
				  html: "<b>"+response.message+"</b>",
				  showConfirmButton: false,
				  timer: 2000,
				  timerProgressBar: true,
				  width: '400px',
				  didOpen: (popup) => {
				    // Pause/resume timer on hover
				    popup.onmouseenter = Swal.stopTimer;
                    popup.onmouseleave = Swal.resumeTimer;
				  }
				});

            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.error('AJAX Error:', textStatus, errorThrown);
            console.log('Response text:', jqXHR.responseText);
            $('#response').html('An error occurred: ' + textStatus + ' - ' + errorThrown);
        }
    });
});

//========AJAX DELETING ALL DATA EACH TABLE HANDLING End=========//

$("#add_new_collector").on("submit", function(e){
	e.preventDefault();

	$.ajax({
		url: "add-new-collector.php",
		method: "POST",
		data: $(this).serialize(),
		dataType: 'json',
		success: function(response){

			if(response.status === 'success'){
				var icon = "success";
			}else{
				var icon = "failed";
			};

			Swal.fire({
				position: "center",
				icon: icon,
				html: "<b>"+response.message+"</b>",
				showConfirmButton: false,
				timer: 2000,
				timerProgressBar: true,
				width: '400px', // Set your desired width here
				didOpen: (popup) => {
				popup.onmouseenter = Swal.stopTimer;
				popup.onmouseleave = Swal.resumeTimer;
				}
			});
			
		}
	});
});



$(document).ready(function(){


	//========Adding Client Start=========//
    $('#add-client-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: 'class/cu_controller_data.php',
            data: $(this).serialize() + '&functions=lending_client_01',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                	$.ajax({
			              url: 'class/fetch_data.php',
			              method: 'POST',
			              data: {
			                  functions: 'lending_client_01'
			              },
			              success: function(updateData) {
			                  $('#tableData').html(updateData);
			              }
		          	});
				    Swal.fire({
				        position: "center",
				        icon: "success",
				        html: `
				            <b>${response.message}</b>
				            <br>
				            <br>
				            <button 
					            class="swal-btn btn btn-primary btn-sm px-3 py-2">
					            ${response.sql_type === 'insert' ? 'Add New' : 'Done'}
					        </button>
				            <button class="close-modal btn btn-secondary btn-sm px-3 py-2">Close</button>
				        `,
				        showConfirmButton: false, // Hide default confirm button
				        didRender: () => {

				        	$('.close-modal').on('click', function () {
					            Swal.close(); 
					            $('#add-client').modal('hide');
					        });

				        	switch(response.sql_type){
				        		case 'insert':
				        			$('.swal-btn').on('click', function () {
							            Swal.close(); 
							            $('#add-client-form')[0].reset();
							        });
				        		;
				        		break; 
				        	case 'update':
				        			$('.swal-btn').on('click', function () {
							            Swal.close(); 
							            $('#add-client').modal('hide');
							        });
				        		;
				        		break; 

				        	}


				        }
				    });

                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $('#response').html('An error occurred: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
    //========Adding Client End=========//

    //========Adding Agent Start=========//
    $('#add-agent-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: 'class/cu_controller_data.php',
            data: $(this).serialize() + '&functions=lending_agent_01',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                	$.ajax({
			              url: 'class/fetch_data.php',
			              method: 'POST',
			              data: {
			                  functions: 'lending_agent_01'
			              },
			              success: function(updateData) {
			                  $('#tableData').html(updateData);
			              }
		          	});
				    Swal.fire({
				        position: "center",
				        icon: "success",
				        html: `
				            <b>${response.message}</b>
				            <br>
				            <br>
				            <button 
					            class="swal-btn btn btn-primary btn-sm px-3 py-2">
					            ${response.sql_type === 'insert' ? 'Add New' : 'Done'}
					        </button>
				            <button class="close-modal btn btn-secondary btn-sm px-3 py-2">Close</button>
				        `,
				        showConfirmButton: false, // Hide default confirm button
				        didRender: () => {

				        	$('.close-modal').on('click', function () {
					            Swal.close(); 
					            $('#add-agent').modal('hide');
					        });

				        	switch(response.sql_type){
				        		case 'insert':
				        			$('.swal-btn').on('click', function () {
							            Swal.close(); 
							            $('#add-agent-form')[0].reset();
							        });
				        		;
				        		break; 
				        	case 'update':
				        			$('.swal-btn').on('click', function () {
							            Swal.close(); 
							            $('#add-agent').modal('hide');
							        });
				        		;
				        		break; 

				        	}


				        }
				    });

                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $('#response').html('An error occurred: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
    //========Adding Agent End=========//


    //========Create Loan Start=========//
    $('#create-loan-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: 'POST',
            url: 'class/cu_controller_data.php',
            data: $(this).serialize() + '&functions=total_loan_01',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                	$.ajax({
			              url: 'class/fetch_data.php',
			              method: 'POST',
			              data: {
			                  functions: 'total_loan_01'
			              },
			              success: function(updateData) {
			                  $('#tableData').html(updateData);
			              }
		          	});
				    Swal.fire({
				        position: "center",
				        icon: "success",
				        html: `
				            <b>${response.message}</b>
				            <br>
				            <br>
				            <button 
					            class="swal-btn btn btn-primary btn-sm px-3 py-2">
					            ${response.sql_type === 'insert' ? 'Create New' : 'Done'}
					        </button>
				            <button class="close-modal btn btn-secondary btn-sm px-3 py-2">Close</button>
				        `,
				        showConfirmButton: false, // Hide default confirm button
				        didRender: () => {

				        	$('.close-modal').on('click', function () {
					            Swal.close(); 
					            $('#create-loan-modal').modal('hide');
					        });

				        	switch(response.sql_type){
				        		case 'insert':
				        			$('.swal-btn').on('click', function () {
							            Swal.close(); 
							            $('#reate-loan-form')[0].reset();
							        });
				        		;
				        		break; 
				        	case 'update':
				        			$('.swal-btn').on('click', function () {
							            Swal.close(); 
							            $('#create-loan-modal').modal('hide');
							        });
				        		;
				        		break; 

				        	}


				        }
				    });

                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $('#response').html('An error occurred: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
    //========Create Loan End=========//


	//========For Payment Start=========//
	$('.payment-button').click(async function(e) {
	    var total_loan_id = $(this).data('total_loan_id');
	    var id = $(this).data('id');
	    var row = $(this).closest('tr');
	    var numericText01 = row.find('.td_penalty').text();
	    var penalty = parseFloat(numericText01.replace(/[^0-9.]/g, ''));

	    var numericText02 = row.find('.td_total').text();
	    var total_amount = parseFloat(numericText02.replace(/[^0-9.]/g, ''));

	    const { value: formValues } = await Swal.fire({
	        text: 'Payment Details!',
	        html:
	        	'<div>Exact Amount<div>' +
	            '<input id="swal-input-amount" value="'+total_amount+'" type="number" step="0.01" class="w-50 swal2-input" placeholder="Amount" value="${total_amount}" readonly>' +
	            '<input id="swal-input-date" type="date" class="w-50 swal2-input" placeholder="Select date">',
	        focusConfirm: false,
	        showCancelButton: true,
	        confirmButtonText: 'Pay Now',
	        preConfirm: () => {
	            const date = document.getElementById('swal-input-date').value;
	            const amount = document.getElementById('swal-input-amount').value;
	            if (!date) {
	                Swal.showValidationMessage(`Please select a payment date`);
	                return false;
	            }
	            return { date, amount };
	        }
	    });

	    if (formValues) {
	        $.ajax({
	            url: 'class/cu_controller_data.php',
	            method: 'POST',
	            data: {
	                functions: 'payment_history_01',
	                weekly_amount: formValues.amount,
	                payment_date: formValues.date,
	                penalty: penalty,
	                total_loan_id: total_loan_id,
	                id: id
	            },
	            success: function(response) {
	                console.log(response);
	                $.ajax({
	                    url: 'class/fetch_data.php',
	                    method: 'POST',
	                    data: {
	                        functions: 'payment_01',
	                        total_loan_id: total_loan_id
	                    },
	                    success: function(display_data) {
	                        console.log(display_data);
	                        $('#tableData').html(display_data);
	                    },
	                    error: function(jqXHR, textStatus, errorThrown){
	                        console.error('AJAX Error:', textStatus, errorThrown);
	                        console.log('Response text:', jqXHR.responseText);
	                    }
	                });
	            },
	            error: function(jqXHR, textStatus, errorThrown){
	                console.error('AJAX Error:', textStatus, errorThrown);
	                console.log('Response text:', jqXHR.responseText);
	            }
	        });
	    }
	});

	//========For Payment End=========//
});