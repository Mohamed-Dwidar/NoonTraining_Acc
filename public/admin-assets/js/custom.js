$(document).ready(function () {

    ////////Search &  Filter & Sort//////
    var searchSortFilterParams = '';
    $('#srchInput').keypress(function (e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            $('button[class="srch-icon"]').click();
            return false;
        }
    });

    $(".srch-icon").on('click', function () {
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });
    $(".header-search .clear").on('click', function () {
        $('#srchInput').val('');
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });

    $('.filter-item').click(function (event) {
        event.preventDefault();
        var e = $(this);
        $('#fltr_val').val(e.data('val'));
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });

    $('.filter-item-brnch').click(function (event) {
        event.preventDefault();
        var e = $(this);
        $('#fltr_brnch_val').val(e.data('val'));
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });

    // "تم التسجيل عن طريق" filter (reports)
    $('.filter-item-regby').click(function (event) {
        event.preventDefault();
        var e = $(this);
        $('#fltr_regby_val').val(e.data('val'));
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });


    // Report date range filter (partial reportmodule::admin.partials.date_range_filter)
    if ($('.rpt-date-range').length && $.fn.pickadate) {
        $('.rpt-date-range').pickadate({
            format: 'yyyy-mm-dd',
            today: false,
            close: 'Close',
        });
    }
    $('.rpt-drange-apply').click(function (event) {
        event.preventDefault();
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });
    $('.rpt-drange-clear').click(function (event) {
        event.preventDefault();
        $('#rpt_date_from').val('');
        $('#rpt_date_to').val('');
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });

    $('.sort-item').click(function (event) {
        event.preventDefault();
        var e = $(this);
        $('#sort_val').val(e.data('val'));
        searchSortFilterParams = collectSearchSortFilterParams();
        document.location.href = url + searchSortFilterParams;
    });



    $('#export-excel').click(function(){
        searchSortFilterParams = collectSearchSortFilterParams();
        // alert(url + searchSortFilterParams);
        if(searchSortFilterParams != ''){
            document.location.href = url + searchSortFilterParams + '&export=yes';
        }else{
            document.location.href = url + '?export=yes';
        }

    });

    function collectSearchSortFilterParams() {
        /////Search////
        var srchVal = $('#srchInput').val();
        var srchParam = srchVal != '' ? "srch=" + srchVal : "";
        /////////////

        ////Sort////
        var sortVal = $('#sort_val').val();
        var sortParam = (sortVal != '' && sortVal != 'no') ? "srt=" + sortVal : "";
        //////////

        ////Filter////
        var fltrVal = $('#fltr_val').val();
        var filterParam = (fltrVal != null && fltrVal != '' && fltrVal != 'no') ? "fltr=" + fltrVal : "";
        ////////// 

        ////Filter Branch////
        var fltrBranchVal = $('#fltr_brnch_val').val();
        var filterBranchParam = (fltrBranchVal != null && fltrBranchVal != '' && fltrBranchVal != 'no') ? "brnch=" + fltrBranchVal : "";
        ////////// 

        ////Filter "تم التسجيل عن طريق"////
        var fltrRegByVal = $('#fltr_regby_val').val();
        var filterRegByParam = (fltrRegByVal != null && fltrRegByVal != '' && fltrRegByVal != 'no') ? "regby=" + fltrRegByVal : "";
        //////////

        ////Filter date range (reports)////
        var dateFrmVal = $('#rpt_date_from').val();
        var dateFrmParam = (dateFrmVal != null && dateFrmVal != '') ? "dateRngFrm=" + encodeURIComponent(dateFrmVal) : "";
        var dateToVal = $('#rpt_date_to').val();
        var dateToParam = (dateToVal != null && dateToVal != '') ? "dateRngTo=" + encodeURIComponent(dateToVal) : "";
        //////////


        var finalParams = "";
        if (srchParam != "") {
            finalParams += (srchParam + "&");
        }
        if (sortParam != "") {
            finalParams += (sortParam + "&");
        }
        if (filterParam != "") {
            finalParams += (filterParam + "&");
        }
        if (filterBranchParam != "") {
            finalParams += (filterBranchParam + "&");
        }
        if (filterRegByParam != "") {
            finalParams += (filterRegByParam + "&");
        }
        if (dateFrmParam != "") {
            finalParams += (dateFrmParam + "&");
        }
        if (dateToParam != "") {
            finalParams += (dateToParam + "&");
        }

        finalParams = finalParams.replace(/&\s*$/, ""); //remove the last (&)
        return finalParams != "" ? "?" + finalParams : "";
    }

    ////////////////////
});

// Nav sub-menu (e.g. إعدادات النظام): open on tap — touch screens have no hover
$(document).on('click', '.top-menu .submenu-toggle', function (e) {
    e.preventDefault();
    var $li = $(this).closest('.has-submenu');
    $('.top-menu .has-submenu').not($li).removeClass('open');
    $li.toggleClass('open');
});
$(document).on('click', function (e) {
    if (!$(e.target).closest('.top-menu .has-submenu').length) {
        $('.top-menu .has-submenu').removeClass('open');
    }
});
