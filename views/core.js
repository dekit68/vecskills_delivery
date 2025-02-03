$(document).ready(function () {
    let lastContent = localStorage.getItem('lastContent')

    if (lastContent) {
        $('.contents').hide();
        $('#' + lastContent).fadeIn();
    } else {
        $('.contents').hide();
        $('.contents').first().fadeIn();
    }

    $('.nav-content').on('click', function (e) {
        e.preventDefault();
        let show = $(this).data('content')
        $('.contents').hide();
        $('#' + show).fadeIn();
        localStorage.setItem('lastContent', show)
    })

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
        })
    }

    $('#serach').on('input', SetFilter)
    $('#filtershop').on('change', SetFilter)
    $('#filterfood').on('change', SetFilter)
})