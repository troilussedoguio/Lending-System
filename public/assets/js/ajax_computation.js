

$(document).on("click", ".btn_delete_user", function () {
    var id = $(this).data("id");
    $("#delete-users-modal").modal("show");
    $("#users_id").val(id);
    $("#role").val($(this).data("role"));
});

$(document).on("click", ".delete_loans", function () {
    var id = $(this).data("id");
    $("#delete-loan-modal").modal("show");
    $("#loan_id").val(id);
});

$(document).on("click", ".btn_paid", function(e){
    e.preventDefault();
   var penalty = $(this).data('penalty');
   var id = $(this).data('id');

   $.ajax({
    url: "ajax/update-weekly-payment.php",
    method: "POST",
    data: { penalty:penalty, id:id },
    dataType: 'json',
    success: function(response){
        Alert.close();
        Alert.handleResponse(response);
    },
    error: function(xhr, status, error) {
        console.log(xhr.responseText, status, error);
        Alert.close();
        Alert.handleResponse({status: 'error', message: xhr.responseText});
    }

   })
});

$(document).on("submit", "#delete-user-form", function(e){
        e.preventDefault();

        var method = $('#method').val();
        var url = (method == 1) ? 'add-new-barrower.php' : 'add-new-collector.php';

        $.ajax({
            url: url,
            method: "POST",
            data: $(this).serialize(),
            dataType: 'json',  // Expecting a JSON response
            success: function(response) {
                
                Alert.close();
                Alert.handleResponse(response).then(() => {
                    if (response.status === 'success') {
                        location.reload();
                    }
                });
            
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        });
    });

$(document).on("submit", "#delete-loan-form", function(e){
    e.preventDefault();


    $.ajax({
        url: "loans.php",
        method: "POST",
        data: $(this).serialize(),
        dataType: 'json',  // Expecting a JSON response
        success: function(response) {

            console.log(response);
            Alert.close();
            Alert.handleResponse(response).then(() => {
                if (response.status === 'success') {
                    location.reload();
                }
            });

        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText, status, error);
            Alert.close();
            Alert.handleResponse({status: 'error', message: xhr.responseText});
        }
    });
});

$(document).on("click", ".toggle-collapsed", function () {
    $(this).find("i").each(function () {
        const icon = $(this);

        if (icon.hasClass("ri-arrow-right-s-line") || icon.hasClass("ri-arrow-up-s-line")) {
            // Expand → show “down arrow”
            icon
                .removeClass("ri-arrow-right-s-line ri-arrow-up-s-line")
                .addClass("ri-arrow-down-s-line");
        } else {
            // Collapse → restore original icons
            if (icon.hasClass("d-lg-inline-block")) {
                // Desktop icon
                icon
                    .removeClass("ri-arrow-down-s-line")
                    .addClass("ri-arrow-right-s-line");
            } else {
                // Mobile icon
                icon
                    .removeClass("ri-arrow-down-s-line")
                    .addClass("ri-arrow-up-s-line");
            }
        }
    });
});



    $(document).ready(function(){

    function moneyFormat(num) {
    return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }


    $(".loginForm").on("submit", function(e){
        e.preventDefault();

        $.ajax({
            url: "auth.php",
            method: "POST",
            data: $(this).serialize(),
            dataType: 'json',  // Expecting a JSON response
            success: function(response) {
                
                if (response.status === 'error') {
                    Alert.close();
                    Alert.handleResponse(response);
                }else{
                    window.location.href = response.message
                }
                

                console.log(response)
                
            
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        });
    });

    $(".delete_user_img").on("click", function(e){
        e.preventDefault();

        var methods = 'delete';
        var id = $(this).data('id');


        $.ajax({
            url: "add-new-barrower.php",
            method: "POST",
            data: { methods: methods, id: id },
            dataType: 'json',  // Expecting a JSON response
            success: function(response) {
                
                Alert.close();
                Alert.handleResponse(response).then(() => {
                    if (response.status === 'success') {
                        location.reload();
                    }
                });

                console.log(response)
                
            
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        });
    });

    $(".add_new_user").on("submit", function(e){
        e.preventDefault();

        var role = $('.role').val();
        var url = (role == 1) ? 'add-new-barrower.php' : 'add-new-collector.php';

        var formElem = $(this)[0];
        var formData = new FormData(formElem);

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',  // Expecting a JSON response
            success: function(response) {
                
                Alert.close();
                Alert.handleResponse(response).then(() => {
                    if (response.status === 'success') {
                        location.reload();
                    }
                });

                console.log(response)
                
            
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        });
    });

    $(".create-new-loan").on("submit", function(e){
        e.preventDefault();
        // Use FormData so file inputs (proof_img) are included in the request
        var formElem = $(this)[0];
        var formData = new FormData(formElem);

        $.ajax({
            url: "create-new-loan.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',  // Expecting a JSON response
            success: function(response) {
                console.log(response)
                Alert.handleResponse(response).then(() => {
                    if (response.status === 'success') {
                        if ($('#loan_id').val() === "") {
                            $('.create-new-loan')[0].reset();
                            $('.display_loan, .display_interest, .display_return').text("0.00");
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        });
    });

    $(".payment_history").on("click", function(e){
        e.preventDefault();
        $("#weekly-payment-modal").modal('show');

        
        if(!$(this).data('option') == 1){
            $('.modal-semi-title').text("Weekly Payment Date");
        }else{
            $('.modal-semi-title').text("Semi-Monthly Payment Date");
        }
        $.ajax({
            url: "fetch_weekly.php",
            method: "POST",
            data: {loan_id : $(this).data('id'), loan_option: $(this).data('option')},
            dataType: 'json',  // Expecting a JSON response
            success: function(response) {

                $('.weekly-payment-div').html("");
                let html = "";
            
                    response.forEach(r => {

                        let bg = "";

                        console.log(r);
                        var daily_penalty = r.daily_penalty;

                        // convert jquery number format 
                        var daily_penalty_num = Number(daily_penalty.replace(/,/g, ''));
                        var r_amount_num = Number(r.amount.toString().replace(/,/g, ''));


                        var startDate = new Date(r.deadline_date);
                                           
                        if (r.paid_date === null || r.status === 1) {
                            var today = new Date();
                        }else{
                            var today = new Date(r.paid_date);
                        }
                        var timeDiff = today - startDate; 
                        var daysPassed = Math.floor(timeDiff / (1000 * 60 * 60 * 24)); 
                        if(daysPassed < 0) daysPassed = 0;
            

                        // Calculate total
                        var total_penalty = daily_penalty_num * daysPassed;

                        var total_amount = total_penalty + r_amount_num;

                        let paid_date = r.paid_date ? new Date(r.paid_date).toLocaleDateString("en-US", {
                            year: "numeric",
                            month: "long",
                            day: "numeric"
                        }) : "unpaid";

                        switch (r.status) {
                            case 1:
                                bg = "badge text-bg-danger"
                                break;
                    
                            case 2:
                                bg = "text-success";
                                break;
                        }
                        
                        let deadline_date = new Date(r.deadline_date).toLocaleDateString("en-US", {
                            year: "numeric",
                            month: "long",
                            day: "numeric"
                        });

                        
                        html += `
                            <div>
                                <div class="collapse-btn collapsed row mx-0 row-gap-2 py-3 d-flex flex-column flex-xl-row">
                                    <div class="col-auto d-flex">
                                        <span class="text-secondary fw-bold d-flex align-items-center justify-content-between w-100 mb-2 mb-xl-0">
                                            <div class="toggle-collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week_${r.id}" aria-expanded="false" aria-controls="week_${r.id}">
                                                <i class="ri-arrow-right-s-line d-none d-xl-inline-block"></i>
                                                <i class="ri-arrow-up-s-line d-xl-none"></i>
                                            </div>
                                            <div class="d-xl-none">
                                                <button data-penalty="${moneyFormat(total_penalty)}"
                                                        data-id="${r.id}"
                                                        class="btn_paid btn btn-success btn-sm"><i class="ri-check-line"></i></button>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="col-2 d-flex align-items-center text-nowrap" >
                                        <span class="d-xl-none fw-bold text-secondary me-2">Deadline: </span>${deadline_date}
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <span class="d-xl-none fw-bold text-secondary me-2">Penalty: </span> ₱${moneyFormat(total_penalty)}
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <span class="d-xl-none fw-bold text-secondary me-2">Amount: </span> ₱${r.amount}
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <span class="d-xl-none fw-bold text-secondary me-2">Total: </span> ₱${moneyFormat(total_amount)}
                                    </div>
                                    <div class="col-2 d-flex align-items-center text-nowrap">
                                        <span class="d-xl-none fw-bold text-secondary me-2">Paid Date: </span> <span class="${bg}">${paid_date}</span>
                                    </div>
                                    <div class="col-1 d-none d-xl-inline-block">
                                        <button data-penalty="${moneyFormat(total_penalty)}" 
                                                data-id="${r.id}"
                                                class="btn_paid btn btn-success btn-sm"><i class="ri-check-line"></i></button>
                                    </div>
                                    
                                </div>
                                <div class="collapse" id="week_${r.id}">
                                `
                            
                            if (startDate < today) {
                                
                                for (let i = 0; i < daysPassed; i++) {
                                    
                                    
                                    let currentDate = new Date(startDate);
                                    currentDate.setDate(startDate.getDate() + i);

                                    // Format the date as you want
                                    let formattedDate = currentDate.toLocaleDateString("en-US", {
                                        year: "numeric",
                                        month: "long",
                                        day: "numeric"
                                    });
                                    html += `
                                    <ul
                                    class="m-0 p-2 d-flex border border-1 border-bottom-0">
                                        <i class="ri-corner-right-up-fill" style="transform: rotate(90deg);"></i>
                                        <li class="d-flex align-items-center justify-content-between w-100 px-3">
                                            <span>₱${daily_penalty}</span>
                                            <span>${formattedDate}</span>
                                        </li>
                                    </ul>
                                    `;
                                };
                            } else {
                                html += `
                                <ul class="m-0 p-2 d-flex border border-1 border-bottom-0">
                                    <li class="d-flex align-items-center justify-content-center w-100 px-3">
                                        <span>no penalty</span>
                                    </li>
                                </ul>
                                `;
                            }


                            html +=	`
                                </div>
                            </div>
                            <hr class="m-0">
                        
                        `
                    });
                $('.weekly-payment-div').append(html);

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        });
    });

    $(".edit_percent").on("click", function(e){
        $('.p_interest, .p_penalty, .capital, .p_collector, .sm_penalty, .sm_interest').each(function() {
            // Toggle the disabled property
            $(this).prop('disabled', !$(this).prop('disabled'));
        });
    });

    
    $(".save_percent").on("click", function(e){

        let p_interest = parseFloat($('.p_interest').val());
        let p_penalty = parseFloat($('.p_penalty').val());
        let sm_penalty = parseFloat($('.sm_penalty').val());
        let sm_interest = parseFloat($('.sm_interest').val());
        let p_collector = parseFloat($('.p_collector').val());
        let capital = $('.capital').val();
            
        $.ajax({
            url: "ajax/save-percentage.php",
            method: "POST",
            data: {
                    p_interest: p_interest,
                    p_penalty: p_penalty,
                    sm_interest: sm_interest,
                    sm_penalty: sm_penalty,
                    p_collector: p_collector,
                    capital: capital
            },
            dataType: 'json',
            success: function(response){
                // Close loading and show response

                $('#percentage-modal').modal('hide');
                Alert.close();
                Alert.handleResponse(response).then(() => {
                    
                    if (response.status === 'success') {
                        // Disable inputs
                        $('.p_interest, .p_penalty, .sm_penalty, .sm_interest, .capital, .p_collector').prop('disabled', true);

                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
                Alert.close();
                Alert.handleResponse({status: 'error', message: xhr.responseText});
            }
        })
    });




});

   function computeLoan() {
        let loan = parseFloat($('#amount').val()) || 0;
        let loan_option = $('#loan_option').val();
        
        switch (loan_option) {
            case "1":
                var rate_interest = parseFloat($('.p_interest').val());
                break;
            case "2":
                var rate_interest = parseFloat($('.sm_interest').val());
                break;
        
            default:
                var rate_interest = 0;
                break;
        }

        let display_interest = (rate_interest / 100) * loan;
        let display_return = loan + display_interest;

        $('.display_loan').text(loan.toFixed(2));
        $('.display_interest').text(display_interest.toFixed(2));
        $('.display_return').text(display_return.toFixed(2));
    }

    // loan option change
    $(document).on("change", "#loan_option", computeLoan);
    // amount input
    $(document).on("keyup", "#amount", computeLoan);
