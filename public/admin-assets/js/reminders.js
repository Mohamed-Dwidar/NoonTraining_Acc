/* Reminders ("الأشعارات"): header bell icon + "مقروء" buttons (header menu, reminders list, reminder page) */
$(function () {
    var $icon = $('.header-reminders');
    if (!$icon.length) {
        return;
    }

    var latestUrl = $icon.data('latest-url');
    var readUrl = $icon.data('read-url');
    var polling = null;

    function refreshHeader(data) {
        $icon.find('.reminders-count').text(data.count > 99 ? '99+' : data.count).toggle(data.count > 0);
        $icon.find('.reminders-list').html(data.html);
    }

    function readAt(data) {
        return $('<span class="reminder-dt"></span>').text(data.read_at || '');
    }

    function markRead($btn) {
        var id = $btn.data('id');
        $btn.prop('disabled', true);

        $.ajax({
            url: readUrl,
            type: 'POST',
            dataType: 'json',
            data: { id: id, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (data) {
                refreshHeader(data);

                // same reminder in the page itself (list / reminder page)
                $('.reminder-status[data-id="' + id + '"]').empty()
                    .append('<span class="tag tag-success">مقروء</span>')
                    .append($('<div class="reminder-read-at"></div>').append(readAt(data)));
                $('.reminder-card[data-reminder="' + id + '"]').removeClass('reminder-unread');
                $('.reminder-time-read[data-unread="' + id + '"]').empty().append(readAt(data)).removeAttr('data-unread');
            },
            error: function () {
                $btn.prop('disabled', false);
                alert('حدث خطأ، حاول مرة أخرى');
            }
        });
    }

    // keep the menu open when a button inside it is clicked (the click must not reach document)
    $icon.find('.reminders-menu').on('click', function (e) {
        e.stopPropagation();
        var $btn = $(e.target).closest('.reminder-read-btn');
        if ($btn.length) {
            markRead($btn);
        }
    });

    $('.content').on('click', '.reminder-read-btn', function () {
        markRead($(this));
    });

    // new reminders become due while the page is open
    polling = setInterval(function () {
        if (document.hidden) {
            return;
        }
        $.ajax({ url: latestUrl, dataType: 'json' }).done(refreshHeader).fail(function (xhr) {
            if (xhr.status === 401) { // logged out
                clearInterval(polling);
            }
        });
    }, 60000);
});
