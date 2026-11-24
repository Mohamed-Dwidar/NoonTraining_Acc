{{-- Read state of $reminder for the logged in person + "مقروء" button (AJAX, public/admin-assets/js/reminders.js) --}}
@if ($reminder->read_status == 'upcoming')
    <span class="tag tag-info">قادم</span>
@elseif ($reminder->read_status == 'unread')
    <span class="reminder-status" data-id="{{ $reminder->id }}">
        <button type="button" class="btn btn-success reminder-read-btn" data-id="{{ $reminder->id }}">تحديد كمقروء</button>
    </span>
@else
    <span class="tag tag-success">مقروء</span>
    <div class="reminder-read-at"><span class="reminder-dt">{{ $reminder->last_read_at->format('Y-m-d H:i') }}</span></div>
@endif
