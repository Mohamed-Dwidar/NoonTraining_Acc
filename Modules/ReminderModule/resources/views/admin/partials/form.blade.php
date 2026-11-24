{{-- Create / edit fields. $reminder is null on create --}}
@php
    use Modules\ReminderModule\app\Http\Models\ReminderTime;

    $units = ['minute' => 'دقيقة', 'hour' => 'ساعة', 'day' => 'يوم', 'week' => 'أسبوع'];

    if (session()->hasOldInput()) {
        $befores = array_values((array) old('before', []));
    } elseif ($reminder) {
        $befores = $reminder->times->where('before_minutes', '>', 0)->map(function ($time) {
            [$value, $unit] = ReminderTime::splitMinutes($time->before_minutes);
            return compact('value', 'unit');
        })->values()->all();
    } else {
        $befores = [['value' => 1, 'unit' => 'day']];
    }
    $isForAll = old('is_for_all', $reminder ? (int) $reminder->is_for_all : 0);
@endphp

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <label for="title">عنوان الإشعار <span class="hint">*</span></label>
        <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" maxlength="191"
                value="{{ old('title', $reminder->title ?? '') }}" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <label for="details">التفاصيل</label>
        <div class="form-group">
            <textarea class="form-control" id="details" name="details" rows="4" maxlength="5000">{{ old('details', $reminder->details ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <label for="remind_date">التاريخ <span class="hint">*</span></label>
        <div class="form-group">
            <input type="date" class="form-control" id="remind_date" name="remind_date"
                value="{{ old('remind_date', $reminder ? $reminder->remind_at->format('Y-m-d') : '') }}" required>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <label for="remind_time">الوقت <span class="hint">*</span></label>
        <div class="form-group">
            <input type="time" class="form-control" id="remind_time" name="remind_time"
                value="{{ old('remind_time', $reminder ? $reminder->remind_at->format('H:i') : '') }}" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <label>أوقات التذكير</label>
        <p class="reminder-hint">يظهر الإشعار في موعده، وأيضا في الأوقات التالية قبل الموعد:</p>

        <div id="reminder-times" data-next="{{ count($befores) }}">
            @foreach ($befores as $i => $before)
                @include('remindermodule::admin.partials.time_row', ['i' => $i, 'value' => $before['value'] ?? '', 'unit' => $before['unit'] ?? 'day'])
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary btn-sm" id="reminder-time-add">
            <i class="fa fa-plus"></i> أضف وقت تذكير
        </button>

        <template id="reminder-time-template">
            @include('remindermodule::admin.partials.time_row', ['i' => '__i__', 'value' => 1, 'unit' => 'day'])
        </template>
    </div>
</div>

<div class="row reminder-audience">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <label>يظهر الإشعار لـ <span class="hint">*</span></label>
        <div class="input-group">
            <label class="display-inline-block custom-control custom-radio ml-1">
                <input type="radio" name="is_for_all" class="custom-control-input" value="0" @checked($isForAll == 0)>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description ml-0">
                    {{ $reminder && !$reminder->isOwnedBy(Auth::user()) ? 'صاحب الإشعار فقط' : 'لي فقط' }}
                </span>
            </label>
            <label class="display-inline-block custom-control custom-radio">
                <input type="radio" name="is_for_all" class="custom-control-input" value="1" @checked($isForAll == 1)>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description ml-0">
                    {{-- follows the creator: admin's reminder → all branches --}}
                    @if ($reminder ? is_null($reminder->branch_id) : Auth::getDefaultDriver() == 'admin')
                        الكل (الإدارة وجميع المستخدمين في كل الفروع)
                    @else
                        الكل (الإدارة وجميع مستخدمي الفرع)
                    @endif
                </span>
            </label>
        </div>
    </div>
</div>

<div class="col-12 clearfix">
    <button type="submit" class="btn btn-primary">حفظ</button>
</div>

@push('scripts')
    <script>
        $(function() {
            var $times = $('#reminder-times');
            var next = parseInt($times.data('next'));

            function toggleAdd() {
                $('#reminder-time-add').toggle($times.children().length < 10);
            }
            $('#reminder-time-add').on('click', function() {
                $times.append($('#reminder-time-template').html().replace(/__i__/g, next++));
                toggleAdd();
            });
            $times.on('click', '.reminder-time-remove', function() {
                $(this).closest('.reminder-time-row').remove();
                toggleAdd();
            });
            toggleAdd();
        });
    </script>
@endpush
