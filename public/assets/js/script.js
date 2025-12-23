$(document).ready(function() {
    // Get the current URL path 
    var currentPath = window.location.pathname.split("/").pop();
    
    // Loop through each sidebar menu item
    $('.sidebar-menu-item a').each(function() {
        // Get the href attribute of the link
        var linkHref = $(this).attr('href');

        // Check if the href of the link matches the current path
        if (currentPath === linkHref) {
            // Add 'active' class to the matching link
            $(this).addClass('active');
        } else {
            // Optionally, remove 'active' class if it's not the current link
            $(this).removeClass('active');
        }
    });

    // Only run this code if viewport is 1200px or wider
    if ($(window).width() >= 1199) {
        let allowHoverExpand = false;
        let hoverTimer;

        // Cache elements outside the event listeners for performance
        const sidebar = $('.sidebar-container');
        const content = $('.content-container');

        
        $('.sidebar-menu-icon').html(`<i class="ri-menu-fill menu-icon"></i>`);


        // Menu icon click
        $('.sidebar-menu-icon').click(function () {

            // Toggle sidebar-expanded ONLY by menu icon
            sidebar.toggleClass('sidebar-expanded');

            // When expanded by click → also collapse initially
            if (sidebar.hasClass('sidebar-expanded')) {
                sidebar.addClass('sidebar-collapsed');
                content.addClass('content-collapsed');
            } else {
                // Removed expanded → also remove collapsed
                sidebar.removeClass('sidebar-collapsed');
                content.removeClass('content-collapsed');
            }

            // Delay hover activation
            allowHoverExpand = false;
            clearTimeout(hoverTimer);

            hoverTimer = setTimeout(function () {
                allowHoverExpand = true;
            }, 100);
        });

        // Hover works ONLY if sidebar-expanded exists
        sidebar.hover(
            function () {
                if (allowHoverExpand && sidebar.hasClass('sidebar-expanded')) {
                    sidebar.removeClass('sidebar-collapsed');
                    content.removeClass('content-collapsed');
                }
            },
            function () {
                if (allowHoverExpand && sidebar.hasClass('sidebar-expanded')) {
                    sidebar.addClass('sidebar-collapsed');
                    content.addClass('content-collapsed');
                }
            }
        );

    }else{
        $('.sidebar-menu-icon').html(`<i class="ri-arrow-left-long-line menu-icon"></i>`);
        $('.content-menu-icon').click(function () {
            $('.sidebar-container').toggleClass('sidebar-collapsed-mobile');
            $('.content-container').toggleClass('content-collapsed-mobile');

        })

        $('.sidebar-menu-icon').click(function () {
            $('.sidebar-container').removeClass('sidebar-collapsed-mobile');
            $('.content-container').removeClass('content-collapsed-mobile');

        })

    }

    //---------------------------------
    //------------SELECT2--------------
    //---------------------------------
    $("select").select2({
        tags: false
    });
    
    //---------------------------------
    //------------DATABLE--------------
    //---------------------------------
    // show placeholder "Search…" on max width 600
    function setDTPlaceholder(){
    let input = $('.dt-search input');

    if (window.innerWidth <= 600) {
            input.attr('placeholder', 'Search…');
        } else {
            input.attr('placeholder', '');
        }
    }

    $('#Datatable-format').DataTable({
        info: false,
        initComplete: function(){
            setDTPlaceholder();
            $(window).on('resize', setDTPlaceholder); 
        },
        responsive: {
            breakpoints: [
                { name: 'desktop', width: Infinity },
                { name: 'tablet',  width: 1024 },
                { name: 'mobile',  width: 600 }
            ]
        },
        order: [],  // remove default sorting completely
        columnDefs: [
            {
                targets: 0,     // first column
                orderable: false //  disable sorting on it
            },
            {
                targets: 'no-sort', // by class
                orderable: false
            }
        ],
        language: {
            lengthMenu: 'Show <select class="dt-length-0" id="dt-length-0">'+
                        '<option value="10">10</option>'+
                        '<option value="25">25</option>'+
                        '<option value="50">50</option>'+
                        '<option value="100">100</option>'+
                        '</select>',
            emptyTable: '<div style="text-align:center; font-weight:bold; color:#555;">No records found</div>',
            paginate: {       // moved inside language
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous"
        }
        },
    });



});
