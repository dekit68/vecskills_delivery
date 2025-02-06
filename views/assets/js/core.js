$(document).ready(function () {
    // Content Section Navigation
    let lastContent = localStorage.getItem('lastContent');
    if (lastContent) {
        $('.contents').hide();
        $('#' + lastContent).fadeIn();
    } else {
        $('.contents').hide();
        $('.contents').first().fadeIn();
    }

    $('.nav-content').on('click', function (e) {
        e.preventDefault();
        let show = $(this).data('content');
        $('.contents').hide();
        $('#' + show).fadeIn();
        localStorage.setItem('lastContent', show);
    });

    function SetFilter() {
        let Getserach = $('#serach').val().toLowerCase();
        let GetfilterShop = $('#filtershop').val();
        let Getfilterfood = $('#filterfood').val();

        $('.food-item').each(function () {
            let serachTitle = $(this).find('.card-title').text().toLowerCase();
            let serachText = $(this).find('.card-text').text().toLowerCase();
            let serach = serachTitle + ' ' + serachText;
            let filtershop = $(this).data('shopname').toString();
            let filterfood = $(this).data('foodtype').toString();
            if (
                (Getserach === '' || serach.includes(Getserach)) &&
                (GetfilterShop === '' || GetfilterShop === filtershop) &&
                (Getfilterfood === '' || Getfilterfood === filterfood)
            ) {
                $(this).fadeIn(310);
            } else {
                $(this).hide(100);
            }
        });
    }

    function SetFilter2() {
        var searchValue = $('#search2').val().toLowerCase(); 
        var selectedRole = $('#filterrole').val(); 
        var selectedStatus = $('#filteraccess').val(); 

        $('#userTable tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase(); 
            var rowRole = $(this).data('role'); 
            var rowStatus = $(this).data('status'); 

            var isSearchMatch = rowText.indexOf(searchValue) > -1;
            var isRoleMatch = selectedRole ? rowRole === selectedRole : true; 
            var isStatusMatch = selectedStatus ? rowStatus == selectedStatus : true; 
            if (isSearchMatch && isRoleMatch && isStatusMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    function SetFilter3() {
        var searchValue = $('#search3').val().toLowerCase(); 
        $('#userTable tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase(); 
            var isSearchMatch = rowText.indexOf(searchValue) > -1;
    
            if (isSearchMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    $('#serach').on('input', SetFilter);
    $('#filtershop').on('change', SetFilter);
    $('#filterfood').on('change', SetFilter);
    $('#search2').on('input', SetFilter2);
    $('#filterrole').on('change', SetFilter2);
    $('#filteraccess').on('change', SetFilter2);
    $('#search3').on('input', SetFilter3);

    var toastEl = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastEl, {
        autohide: true,
        delay: 5000
    });
    toast.show();
});
