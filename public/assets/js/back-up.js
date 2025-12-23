//========TABLE SEARCHBAR AND FILTER FUNCTION Start=========//
$(document).ready(function() {

  $('#search-query').on('keyup', function() {
      var functions = $(this).data('functions');
      let search_query = $(this).val();

      $.ajax({
          url: 'class/fetch_data.php',
          method: 'POST',
          data: {
              functions: functions,
              search_query: search_query
          },
          success: function(response) {
              $('#tableData').html(response);
          }
      });
  });
  $('.date-filter-btn').click(function(e) {
    e.preventDefault(); 
    
    var start_date_filter = $('#start_date_filter').val();
    var end_date_filter = $('#end_date_filter').val();

    $.ajax({
      url: 'class/fetch_data.php',
      method: 'POST',
      data: {
        functions: 'total_loan_01',
        start_date_filter: start_date_filter,
        end_date_filter: end_date_filter
      },
      success: function(response) {
        $('#tableData').html(response);
      }
    });
  });


})
//========End=========//

$(document).ready(function() {

      $('#showPassword').on('change', function () {
          const passwordField = $('#password');
          if ($(this).is(':checked')) {
              passwordField.attr('type', 'text');
          } else {
              passwordField.attr('type', 'password');
          }
      });


      var currentPage = window.location.pathname.split('/').pop() + window.location.search;

      $('.sidebar a').each(function() {
          if ($(this).attr('href') === currentPage) {
              $(this).addClass('sidebar-active-page');

              var collapseParent = $(this).closest('.collapse');
              if (collapseParent.length) {
                  collapseParent.addClass('show');
              }

          }
      });

      $('#menu-icon').click(function() {
          $('.sidebar').toggleClass('sidebar-toggle');
          $('.content-div').toggleClass('content-div-toggle');
      });
  });


$(document).ready(function () {

  // Only run this code if viewport is 1200px or wider
  if ($(window).width() >= 1200) {


    $("#menu-icon-mobile").addClass("d-none");

    let isSidebarCollapsed = false;

  
    // Toggle sidebar on menu icon click
    $("#menu-icon").click(function () {

      if (isSidebarCollapsed) {
        expandSidebar(); 
      } else {
        collapseSidebar();
      }
      isSidebarCollapsed = !isSidebarCollapsed;
    });

    // Expand sidebar on hover if collapsed
    $(".sidebar").mouseenter(function () {
      if (isSidebarCollapsed) {
        expandSidebar();
      }
    });

    $(".sidebar").mouseleave(function () {
      if (isSidebarCollapsed) {
        collapseSidebar();
      }
    });

    // Collapse Sidebar Function
    function collapseSidebar() {
      $(".sidebar").css("width", "87px");
      $(".nav-item .sidebar-label").css("opacity", "0");
      $(".nav-item .nav-link small").css("display", "none");
      $(".nav-item .collapse").css("height", "0");
    
      $("#logo-div #menu-icon").css("display", "none");
      $(".content-div").css({
        width: "calc(100% - 87px)",
        left: "87px"
      });
      $("#logo-div")
        .addClass("justify-content-center")
        .removeClass("justify-content-between");

      $("#sidebar-logo").html("<img src='<?= $_SESSION['data']['primary_logo'] === null ? 'images/logo.png' : 'upload/' . $_SESSION['data']['primary_logo'] ?>' width='35px' height='100%'>");
    }

    // Expand Sidebar Function
    function expandSidebar() {
      $(".sidebar").css("width", "290px");
      $(".nav-item .sidebar-label").css("opacity", "1");
      $(".nav-item .nav-link small").css("display", "flex");
      $("#logo-div #menu-icon").css("display", "block");
      $(".content-div").css({
        width: "calc(100% - 290px)",
        left: "290px"
      });
      $("#logo-div")
        .addClass("justify-content-between")
        .removeClass("justify-content-center");

      $("#filepages").css("height", "184px");
      $("#listpages, #reportspages, #customerpages").css("height", "96px");
      $("#companypages, #vendorspages").css("height", "144px");

      $("#sidebar-logo").html("<img src='<?= $_SESSION['data']['secondary_logo'] === null ? 'images/logo-text.png' : 'upload/' . $_SESSION['data']['secondary_logo'] ?>' width='200px' height='100%'>");
    }
  }




  // Only run this code if viewport is below 1199 width
  if ($(window).width() <= 1199) {
    
    $(".dropdown-toggles").addClass("d-none");
    $("#menu-icon-mobile").removeClass("d-none").addClass("d-flex align-items-center justify-content-center column-gap-3");

    let isSidebarCollapsed = false;

    // Smooth transition for sidebar
    $(".sidebar").css({
      transition: "left 0.8s ease"
    });

    // Toggle sidebar on menu icon click
    $(".menutoggle").click(function () {
      if (isSidebarCollapsed) {
        expandSidebar();
      } else {
        collapseSidebar();
      }
      isSidebarCollapsed = !isSidebarCollapsed;
    });


    // Collapse Sidebar Function
    function collapseSidebar() {
      $(".sidebar").css("left", "0px");
      setTimeout(function () {
        $(".sidebar-after").css({
          display: "block",
          transition: "all 2s ease"
        });
      }, 200);
      $("#menu-icon").html(`
        <svg class="icon-size" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M22.0003 13.0001L22.0004 11.0002L5.82845 11.0002L9.77817 7.05044L8.36396 5.63623L2 12.0002L8.36396 18.3642L9.77817 16.9499L5.8284 13.0002L22.0003 13.0001Z"></path></svg>
        `);

    }

    // Expand Sidebar Function
    function expandSidebar() {
      $(".sidebar").css("left", "-580px");
      setTimeout(function () {
        $(".sidebar-after").css({
          display: "none",
          transition: "all 1s ease"
        });
      }, 100);
    }
  }
});


// tool tips for bootstrap
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))