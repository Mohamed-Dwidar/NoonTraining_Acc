@extends('layoutmodule::admin.main')

@section('title')
    تسجيل طالب جديد
@endsection

@push('styles')
<link href="{{url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/css/bootstrap-datetimepicker.css?v2')}}"
    rel="stylesheet" />
@endpush

@section('content')

    <div class="content-wrapper container-fluid">
        <div class="content-header">
            <div class="content-header-left mb-2 breadcrumb-new">
                <h3>
                    تسجيل طالب جديد
                </h3>
            </div>
        </div>

        @include('layoutmodule::admin.flash')

        <div class="content-body">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                        <div class="row">
                            <div class="col-5">
                                <h2> Student Information</h2>
                            </div>
                        </div>
                    </div> --}}
                        <div class="card-content">
                            <div class="row">
                                <div class="col-lg-12 col-12 profile">
                                    <form class="card-form side-form" method="POST"
                                        action='{{ route(Auth::getDefaultDriver().'.students.store') }}' enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-5 col-sm-12 col-xs-12 col-6">
                                                <label for="name">الاسم بالكامل <span class="hint">*</span></label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ old('name') }}">
                                                </div>
                                            </div>
                                        </div>

                                        @if (Auth::guard('admin')->check())
                                            <div class="row">
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-2">
                                                    <label for="branch_id">الفرع <span class="hint">*</span></label>
                                                    <div class="form-group">
                                                        <select class="form-control" id="branch_id" name="branch_id">
                                                            @if (!empty($branches))
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->id }}"
                                                                        @if (old('branch_id') == $branch->id) selected @endif>
                                                                        {{ $branch->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-lg-3 col-sm-12 col-xs-12 col-6">
                                                <label for="id_nu">رقم الهوية / الإقامة <span
                                                        class="hint">*</span></label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="id_nu" name="id_nu"
                                                        minlength="10" maxlength="10" value="{{ old('id_nu') }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-2">
                                                <label for="id_expire_date">تاريخ الانتهاء</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control hijri-datepicker" id="id_expire_date"
                                                        name="id_expire_date" value="{{ old('id_expire_date') }}">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-6">
                                                <label for="phone1">الجوال <span class="hint">*</span></label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="phone1" name="phone1"
                                                        value="{{ old('phone1') }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-6">
                                                <label for="phone2">جوال آخر للتواصل</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="phone2" name="phone2"
                                                        value="{{ old('phone2') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-2">
                                                <label for="city_id">المدينة <span class="hint">*</span></label>
                                                <div class="form-group">
                                                    <select class="form-control" id="city_id" name="city_id">
                                                        @if (!empty($cities))
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}"
                                                                    @if (old('city_id') == $city->id) selected @endif>
                                                                    {{ $city->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-5 col-sm-12 col-xs-12 col-6">
                                                <label for="company">قطاع العمل <span class="hint">*</span></label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="company" name="company"
                                                        value="{{ old('company') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-sm-12 col-xs-12 col-6">
                                                <label for="email">البريد الإلكتروني</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="email" name="email"
                                                        value="{{ old('email') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-2">
                                                <label for="birthdate">تاريخ الميلاد</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control hijri-datepicker" id="birthdate"
                                                        name="birthdate" value="{{ old('birthdate') }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-12 col-xs-12 col-2">
                                                <label for="nationality">الجنسية</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nationality"
                                                        name="nationality" value="{{ old('nationality') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-xs-6 col-6">
                                                <label>النوع</label>
                                                <div class="input-group">
                                                    <label class="display-inline-block custom-control custom-radio ml-1">
                                                        <input type="radio" name="gender" class="custom-control-input"
                                                            value="male"
                                                            @if (old('gender') != 'female') checked @endif>
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description ml-0">ذكر</span>
                                                    </label>
                                                    <label class="display-inline-block custom-control custom-radio">
                                                        <input type="radio" name="gender" class="custom-control-input"
                                                            value="female"
                                                            @if (old('gender') == 'female') checked @endif>
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description ml-0">انثي</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">حفظ</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-1 col-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {

                $('.pickadate').pickadate({
                    weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    format: 'dd-mm-yyyy',
                    formatSubmit: 'yyyy-mm-dd',
                    showMonthsShort: true,
                    today: false,
                    close: 'Close',
                    // clear: '[All]',
                    // onSet: function (context) {
                    //     getInvoicesByDate();
                    // }
                });
            });
        </script>
       <script>
        $(document).ready(function() {
            $('#city_id').select2({
                placeholder: 'ابحث هنا...',
                allowClear: true 
            });
        });
        </script>


        <script src="{{url('/admin-assets/vendors/js/pickers/hijri-date-picker/dist/js/bootstrap-hijri-datetimepicker.min.js?v2')}}"> </script>

        <script type="text/javascript">
            $(document).ready(function () {
                    initHijrDatePickerDefault();
            });
            function initHijrDatePickerDefault() {
                $(".hijri-datepicker").hijriDatePicker({
                    locale: "ar-sa",
                    format: "DD-MM-YYYY",
                    actualFormat: "DD-MM-YY",
                    hijriFormat: "iYYYY-iMM-iDD",
                    dayViewHeaderFormat: "MMMM YYYY",
                    hijriDayViewHeaderFormat: "iMMMM iYYYY",
                    showSwitcher: false,
                    allowInputToggle: true,
                    useCurrent: true,
                    isRTL: true,
                    viewMode: 'days',
                    keepOpen: false,
                    hijri: true,
                    debug: true,
                    showClear: false,
                    showTodayButton: false,
                    showClose: false,
                });
            }
        </script>
    
        
    @endpush
@endsection
