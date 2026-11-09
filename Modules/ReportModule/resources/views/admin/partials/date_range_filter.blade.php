{{-- Date range filter for reports — same look as the users log report (.fltr-date-range-reg / .drnge-icon-reg),
     placed inline in the filters column before "تصدير ملف اكسل".
     Sends dateRngFrm / dateRngTo (yyyy-mm-dd); JS in public/admin-assets/js/custom.js --}}
<div class="fltr-date-range-reg rpt-date-filter">
    <label>{{ $label ?? 'الفترة' }}:</label>
    من
    <input value="{{ app('request')->dateRngFrm }}" id="rpt_date_from" class="pickadate rpt-date-range" autocomplete="off" />
    &nbsp;
    الي
    <input value="{{ app('request')->dateRngTo }}" id="rpt_date_to" class="pickadate rpt-date-range" autocomplete="off" />

    <button class="drnge-icon-reg rpt-drange-apply" type="button">
        <i class="icon-search7"></i>
    </button>
    <a href="#" class="rpt-drange-clear">إلغاء</a>
</div>
