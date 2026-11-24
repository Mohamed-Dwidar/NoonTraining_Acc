<div class="reminder-time-row">
    <span>قبل</span>
    <input type="number" class="form-control" name="before[{{ $i }}][value]" value="{{ $value }}" min="1" max="365" required>
    <select class="form-control" name="before[{{ $i }}][unit]">
        @foreach ($units as $key => $name)
            <option value="{{ $key }}" @selected($unit == $key)>{{ $name }}</option>
        @endforeach
    </select>
    <button type="button" class="btn btn-danger btn-sm reminder-time-remove" title="حذف" aria-label="حذف">
        <i class="fa fa-times"></i>
    </button>
</div>
