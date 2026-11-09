{{-- Registration modals (details / payments / payment status) for one \$reg; needs \$employees and \$paymentMethods. JS: coursemodule::admin.partials.reg_modals_js --}}
                                                <div class="modal fade text-xs-left reg-modal"
                                                    id="modal-reg-{{ $reg->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel90" aria-hidden="true">
                                                    <div class="modal-dialog" role="document" style="max-width: 800px;">
                                                        <div class="modal-content">
                                                            <div id="reg-{{ $reg->id }}-info" style="">
                                                                <div class="modal-body content-reports reg-modal"
                                                                    style="padding:0">
                                                                    <div class="statistic-table custom-bar">
                                                                        <div class="content-body">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h4 class="card-title mb-0">
                                                                                        الطالب :
                                                                                        <span class="student-name">{{ $reg->student->name }}</span>
                                                                                    </h4>
                                                                                    <div class="buttoms icons">
                                                                                        <div id="copy-button-{{ $reg->id }}" class=" d-flex align-items-center mr-2">
                                                                                            <i class="fa fa-copy" title="Copy Info"></i><span class="ml-1">نسخ البيانات</span>
                                                                                        </div>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="card-block reg-template">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12 align-center" style="padding:10px 0;margin-top:-15px;margin-bottom: 25px;font-weight:bold; background-color: {{$reg->status->color}} ">
                                                                                                @if ($reg->is_leave == 1)
                                                                                                [ مغادر ] &nbsp;&nbsp;&nbsp;
                                                                                                @endif
                                                                                                {{$reg->status->status}}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row content-header">
                                                                                            <div
                                                                                                class="content-header-left col-md-12 col-xs-12 mb-1">
                                                                                                <h4 class="form-section">
                                                                                                    <i
                                                                                                        class="icon-desktop"></i>
                                                                                                    بيانات الدورة
                                                                                                </h4>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    الدورة
                                                                                                </div>
                                                                                                <div class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col course-name">
                                                                                                    {{ $reg->course->FullName }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تبدأ في</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->course->start_at }}
                                                                                                </div>

                                                                                                <div
                                                                                                    class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تنتهي في</div>
                                                                                                <div
                                                                                                    class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ $reg->course->end_at }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <input type="hidden" id="main_price" value="{{$reg->main_price}}" reg_id="{{ $reg->id }}"/>
                                                                                                <input type="hidden" id="paid_amount" value="{{$reg->coursePaidAmount}}" reg_id="{{ $reg->id }}"/>
                                                                                                <div class="col-lg-5 col-md-3 col-sm-12 col-xs-12 col label font-bold">السعر الأساسي</div>
                                                                                                <div class="col-lg-7 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    <span>
                                                                                                         <span>{{ $reg->main_price }}</span>
                                                                                                        ر.س
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6 newPrice" style="display: none">
                                                                                                <input type="hidden" id="reg_id" name="reg_id" value="{{ $reg->id }}" />
                                                                                                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col label font-bold"> السعر الجديد</div>
                                                                                                <div class="col-lg-8 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    <span>
                                                                                                        <input type="text" id="new_price" name="new_price" value="" reg_id="{{ $reg->id }}" style="width: 63px" />
                                                                                                    </span>

                                                                                                    <a class="btn btn-green savePrice" reg_id="{{ $reg->id }}">حفظ </a>
                                                                                                    <a class="btn btn-red resetSave">إلغاء التغير </a>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6 mainCost" reg_id="{{ $reg->id }}">
                                                                                                <div class="col-lg-5 col-md-3 col-sm-12 col-xs-12 col label font-bold">السعر المتفق عليه</div>
                                                                                                <div class="col-lg-7 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    <span class="student_price">{{ $reg->student_price }}</span>
                                                                                                    ر.س
                                                                                                    @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                                                                                    <a class="btn btn-blue changePrice">تغير السعر</a>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-6 discountPrice" reg_id="{{ $reg->id }}">
                                                                                                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col label font-bold">قيمة الخصم</div>
                                                                                                <div class="col-lg-8 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    <span class="discount-value-text" reg_id="{{ $reg->id }}">{{ number_format($reg->DiscountAmount ?? 0, 2) }} ر.س</span>
                                                                                                    @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                                                                                    <button type="button" class="btn btn-blue btn-sm edit-discount-btn" reg_id="{{ $reg->id }}">تغيير</button>
                                                                                                    <span class="discount-edit-group" reg_id="{{ $reg->id }}" style="display:none;">
                                                                                                        <input type="number" min="0" step="0.01" id="discount-input" class="discount-input" reg_id="{{ $reg->id }}" value="{{ $reg->DiscountAmount ?? 0 }}" style="width: 80px; display: inline-block;" />
                                                                                                        <button type="button" class="btn btn-green btn-sm save-discount-btn save-btn" reg_id="{{ $reg->id }}">حفظ</button>
                                                                                                        <button type="button" class="btn btn-red btn-sm cancel-discount-btn cancel-btn" reg_id="{{ $reg->id }}">إلغاء</button>
                                                                                                    </span>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6 finalPrice" reg_id="{{ $reg->id }}">
                                                                                                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col label font-bold">السعر النهائي</div>
                                                                                                <div class="col-lg-8 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    <span class="price" reg_id="{{ $reg->id }}">{{ number_format($reg->price, 2) }}</span>
                                                                                                    ر.س
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <script>
                                                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                                                document.querySelectorAll('.edit-discount-btn').forEach(function(btn) {
                                                                                                    btn.addEventListener('click', function() {
                                                                                                        var regId = this.getAttribute('reg_id');
                                                                                                        document.querySelector('.discount-value-text[reg_id="' + regId + '"]').style.display = 'none';
                                                                                                        this.style.display = 'none';
                                                                                                        document.querySelector('.discount-edit-group[reg_id="' + regId + '"]').style.display = 'inline-block';
                                                                                                    });
                                                                                                });
                                                                                                document.querySelectorAll('.cancel-discount-btn').forEach(function(btn) {
                                                                                                    btn.addEventListener('click', function() {
                                                                                                        var regId = this.getAttribute('reg_id');
                                                                                                        document.querySelector('.discount-edit-group[reg_id="' + regId + '"]').style.display = 'none';
                                                                                                        document.querySelector('.discount-value-text[reg_id="' + regId + '"]').style.display = 'inline';
                                                                                                        document.querySelector('.edit-discount-btn[reg_id="' + regId + '"]').style.display = 'inline-block';
                                                                                                    });
                                                                                                });
                                                                                                document.querySelectorAll('.save-discount-btn').forEach(function(btn) {
                                                                                                    btn.addEventListener('click', function() {
                                                                                                        var regId = this.getAttribute('reg_id');
                                                                                                        var input = document.querySelector('.discount-input[reg_id="' + regId + '"]');
                                                                                                        var value = parseFloat(input.value) || 0;
                                                                                                        document.querySelector('.discount-value-text[reg_id="' + regId + '"]').textContent = value.toFixed(2);
                                                                                                        document.querySelector('.discount-edit-group[reg_id="' + regId + '"]').style.display = 'none';
                                                                                                        document.querySelector('.discount-value-text[reg_id="' + regId + '"]').style.display = 'inline';
                                                                                                        document.querySelector('.edit-discount-btn[reg_id="' + regId + '"]').style.display = 'inline-block';
                                                                                                        // تحديث السعر النهائي
                                                                                                        var priceElem = document.querySelector('.mainCost[reg_id="' + regId + '"] .student_price');
                                                                                                        var finalPriceElem = document.querySelector('.price[reg_id="' + regId + '"]');
                                                                                                        var price = priceElem ? parseFloat(priceElem.textContent) : 0;
                                                                                                        var finalPrice = price - value;
                                                                                                        if(finalPriceElem) {
                                                                                                            finalPriceElem.textContent = finalPrice.toFixed(2);
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                            });
                                                                                        </script>
                                                                                        <script>
                                                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                                                document.querySelectorAll('.discount-input').forEach(function(input) {
                                                                                                    input.addEventListener('input', function() {
                                                                                                        var regId = this.getAttribute('reg_id');
                                                                                                        var priceElem = document.querySelector('.mainCost[reg_id="' + regId + '"] .price');
                                                                                                        var finalPriceElem = document.querySelector('.price[reg_id="' + regId + '"]');
                                                                                                        var price = priceElem ? parseFloat(priceElem.textContent) : 0;
                                                                                                        var discount = parseFloat(this.value) || 0;
                                                                                                        var finalPrice = price - (price * discount / 100);
                                                                                                        if(finalPriceElem) {
                                                                                                            finalPriceElem.textContent = finalPrice.toFixed(2);
                                                                                                        }
                                                                                                    });
                                                                                                });
                                                                                            });
                                                                                        </script>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12 mainExamFees" reg_id="{{ $reg->id }}">
                                                                                                <input type="hidden" id="main_exam_price" value="{{$reg->exam_fees}}" reg_id="{{ $reg->id }}"/>
                                                                                                <input type="hidden" id="paid_exam_amount" value="{{$reg->examPaidAmount}}" reg_id="{{ $reg->id }}"/>
                                                                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col label font-bold">رسوم الاختبار</div>
                                                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col">
                                                                                                    <span class="exam_fees">{{ $reg->exam_fees }}</span>
                                                                                                    ر.س


                                                                                                    @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                                                                                    <a class="btn btn-blue changeExamPrice">تغير السعر</a>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-12 newExamPrice" style="display: none">
                                                                                                <input type="hidden" id="reg_id" name="reg_id" value="{{ $reg->id }}" />
                                                                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col label font-bold"> الرسوم الجديدة</div>
                                                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col">
                                                                                                    <span>
                                                                                                        <input type="text" id="new_exam_price" name="new_exam_price" value="" reg_id="{{ $reg->id }}" style="width: 63px" />
                                                                                                    </span>

                                                                                                    <a class="btn btn-green save-btn saveExamPrice" reg_id="{{ $reg->id }}"> حفظ </a>
                                                                                                    <a class="btn btn-red cancel-btn resetExamSave">إلغاء التغير </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-md-12 regBy" reg_id="{{ $reg->id }}">
                                                                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تم التسجيل عن طريق
                                                                                                </div>
                                                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col regByText">
                                                                                                    <span class="regByName">
                                                                                                        @if ($reg->registered_by_name)
                                                                                                            {{ $reg->registered_by_name }}
                                                                                                        @else
                                                                                                            ----
                                                                                                        @endif
                                                                                                    </span>
                                                                                                    @if (Auth::guard('admin')->check() || Auth::user()->can('can_change_regby'))
                                                                                                        <a class="btn btn-blue changeRegBy">تغير</a>
                                                                                                    @endif
                                                                                                </div>

                                                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col newRegBy" style="display: none">
                                                                                                    <input type="hidden" id="reg_id" name="reg_id" value="{{ $reg->id }}" />
                                                                                                    <span>
                                                                                                        <select id="reg_by" name="reg_by" reg_id="{{ $reg->id }}" class="regby-select" dir="rtl" style="width: 180px">
                                                                                                            <option value="">-- اختر --</option>
                                                                                                            @foreach ($employees as $employee)
                                                                                                                <option value="{{ $employee->id }}" @selected($reg->reg_by_employee_id == $employee->id)>{{ $employee->name }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </span>

                                                                                                    <a class="btn btn-green save-btn saveRegBy" reg_id="{{ $reg->id }}"> حفظ </a>
                                                                                                    <a class="btn btn-red cancel-btn resetRegBy">إلغاء التغير </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12 regDate" reg_id="{{ $reg->id }}">
                                                                                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col label font-bold">تاريخ التقديم</div>
                                                                                                <div class="col-lg-4 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    {{ \Carbon\Carbon::parse($reg->created_at)->format('d-m-Y') }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col label font-bold">
                                                                                                    تم استلام الشهادة </div>
                                                                                                <div
                                                                                                    class="col-lg-9 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                    @if ($reg->is_recive_cert == 1)
                                                                                                        نعم
                                                                                                    @else
                                                                                                        لا
                                                                                                    @endif
                                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                                                                                    @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                                                                                    @if ($reg->is_recive_cert == 0)
                                                                                                        <a class="btn btn-blue cert"
                                                                                                            href="{{ route(Auth::getDefaultDriver().'.courses.set_cert_as_delivered', $reg->id) }}">
                                                                                                            تسجيل استلام
                                                                                                            الشهاده
                                                                                                        </a>
                                                                                                    @else
                                                                                                        <a class="btn btn-blue cert"
                                                                                                            href="{{ route(Auth::getDefaultDriver().'.courses.set_cert_as_not_delivered', $reg->id) }}"
                                                                                                            onclick="return confirm('هل انت متأكد انك تريد تسجيل عدم استلام الشهاده ؟')">
                                                                                                            تسجيل عدم استلام
                                                                                                            الشهاده
                                                                                                        </a>
                                                                                                    @endif
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>

                                                                                <div>
                                                                                    <hr>
                                                                                </div>

                                                                                <div class="card-block reg-template">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row content-header">
                                                                                            <div
                                                                                                class="content-header-left col-md-12 col-xs-12 mb-1">
                                                                                                <h4 class="form-section">
                                                                                                    <i class="icon-head"></i>
                                                                                                    بيانات الطالب
                                                                                                </h4>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                الاسم
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col">
                                                                                                {{ $reg->student->name }}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row" style="display: none">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                الفرع
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col">
                                                                                                {{ $reg->student->branch->name }}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                رقم الهوية / الإقامة
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col id-number">
                                                                                                {{ $reg->student->id_nu }}
                                                                                            </div>


                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                تاريخ الانتهاء
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                {{ $reg->student->id_expire_date }}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                الجوال
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col phone">
                                                                                                @if ($reg->student->phone1)
                                                                                                    {{ $reg->student->phone1 }}
                                                                                                @else
                                                                                                    ---
                                                                                                @endif
                                                                                            </div>

                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                جوال آخر للتواصل
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col">
                                                                                                @if ($reg->student->phone2)
                                                                                                    {{ $reg->student->phone2 }}
                                                                                                @else
                                                                                                    ---
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                المدينة
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col">
                                                                                                {{ $reg->student->city->name }}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                قطاع العمل
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-8 col-md-4 col-sm-12 col-xs-12 col">
                                                                                                {{ $reg->student->company }}
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                البريد الألكتروني
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col">
                                                                                                {{ $reg->student->email }}
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                تاريخ الميلاد
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col">
                                                                                                @if ($reg->student->birthdate)
                                                                                                    {{ $reg->student->birthdate }}
                                                                                                @else
                                                                                                    ---
                                                                                                @endif
                                                                                            </div>

                                                                                            <div
                                                                                                class="col-lg-1 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                الجنسية
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-2 col-md-3 col-sm-12 col-xs-12 col">
                                                                                                @if ($reg->student->nationality)
                                                                                                    {{ $reg->student->nationality }}
                                                                                                @else
                                                                                                    ---
                                                                                                @endif
                                                                                            </div>

                                                                                            <div
                                                                                                class="col-lg-1 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                النوع
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-1 col-md-3 col-sm-12 col-xs-12 col">
                                                                                                @if ($reg->student->gender == 'male')
                                                                                                    ذكر
                                                                                                @else
                                                                                                    أنثي
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-lg-3 col-md-2 col-sm-12 col-xs-12 col label font-bold">
                                                                                                ملاحظات
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-9 col-md-4 col-sm-12 col-xs-12 col">
                                                                                                @if ($reg->student->notes)
                                                                                                    {{ $reg->student->notes }}
                                                                                                @else
                                                                                                    ---
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- </div> --}}

                                                <div class="modal fade text-xs-left pay-modal" id="modal-pay-{{ $reg->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel90" aria-hidden="true">
                                                    <div class="modal-dialog" role="document" style="max-width: 800px;">
                                                        <div class="modal-content">
                                                            <div id="pay-{{ $reg->id }}-info" style="">
                                                                <div class="modal-body content-reports pay-modal" style="padding:0">
                                                                        <div class="statistic-table custom-bar">
                                                                            <div class="content-body">
                                                                                <div class="card-header">
                                                                                    <h4 class="card-title" style="float: right;">
                                                                                        الدفعات للطالب :
                                                                                        {{ $reg->student->name }}
                                                                                    </h4>

                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>

                                                                                <div class="card-block pay-template">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <label><b>سعر الدورة :</b></label>
                                                                                                <span class="price">
                                                                                                    <span class="regprice" reg_id="{{ $reg->id }}">{{ number_format($reg->price, 2) }}</span>
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label><b>المدفوع :</b></label>
                                                                                                <span style="color:green" class="paid_amount">
                                                                                                    {{ number_format($reg->coursePaidAmount, 2) }}
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-3">
                                                                                                <label><b>المتبقي :</b></label>
                                                                                                <span style="color:red" class="remaining_amount" reg_id="{{ $reg->id }}">
                                                                                                    @if(in_array($reg->status_id,[8,9]))
                                                                                                    0.00

                                                                                                    @else
                                                                                                    {{ number_format($reg->price - $reg->coursePaidAmount, 2) }}

                                                                                                    @endif
                                                                                                </span>
                                                                                                <span style="color:red" >ر.س</span>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                @if($reg->is_course_paid == 1)
                                                                                                <i class="fa fa-check green list-boolean-icon"></i>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <label><b>رسوم الاختبار :</b></label>
                                                                                                <span class="price">
                                                                                                    <span class="regexamprice" reg_id="{{ $reg->id }}">{{ number_format($reg->exam_fees, 2) }}</span>
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label><b>المدفوع :</b></label>
                                                                                                <span style="color:green">
                                                                                                    {{ number_format($reg->examPaidAmount, 2) }}
                                                                                                    ر.س
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-3">
                                                                                                <label><b>المتبقي :</b></label>
                                                                                                <span style="color:red" class="remaining_exam_amount" reg_id="{{ $reg->id }}">
                                                                                                    {{ number_format($reg->exam_fees - $reg->examPaidAmount, 2) }}
                                                                                                </span>
                                                                                                <span style="color:red">ر.س</span>
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                @if($reg->is_exam_paid == 1)
                                                                                                <i class="fa fa-check green list-boolean-icon"></i>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="card-block pay-template">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <h4 class="card-title" style="float: right;">الدفعات</h4>
                                                                                            </div>

                                                                                            @if($reg->payments->count() > 0)
                                                                                            @foreach ($reg->payments as $payment)
                                                                                                <div class="col-md-3">
                                                                                                    <b>- ( {{$payment->pay_type}} )</b>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    {{$payment->paid_at}}
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <b>{{$payment->amount}}  ر.س </b>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    [ {{$payment->payment_method_name}} ]
                                                                                                </div>
                                                                                            @endforeach
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                                                                <div class="card-block pay-template" style="margin-bottom: 20px">
                                                                                    <form class="card-form" id="payActionForm" method="POST" action="{{ route(Auth::getDefaultDriver().'.courses.pay_action') }}">
                                                                                        @csrf
                                                                                        <input type="hidden" id="id" name="id" value="{{ $reg->id }}" />
                                                                                        <input type="hidden" id="price_rest" class="remaining_amount" reg_id="{{$reg->id}}" value="{{ $reg->price - $reg->coursePaidAmount}}" />
                                                                                        <input type="hidden" id="exam_fees_rest" value="{{ $reg->exam_fees - $reg->examPaidAmount }}" />
                                                                                        <div class="card-text col-md-12">
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <h4 class="card-title" style="float: right;">تسجيل دفع جديد</h4>
                                                                                                </div>

                                                                                                <div class="col-md-3">
                                                                                                    <label for="pay_type">نوع الدفع :</label>
                                                                                                    <span>
                                                                                                        <select id="pay_type" name="pay_type" class="form-control">
                                                                                                            @if(!in_array($reg->status_id,[8,9]))
                                                                                                            <option value="دفعة للدورة">دفعة للدورة</option>
                                                                                                            @endif
                                                                                                            <option value="رسوم الاختبار">رسوم الاختبار</option>
                                                                                                            <option value="رسوم إعادة الاختبار">رسوم إعادة الاختبار</option>
                                                                                                        </select>
                                                                                                    </span>
                                                                                                </div>


                                                                                                <div class="col-md-2">
                                                                                                    <label for="amount">القيمة :</label>
                                                                                                    <span>
                                                                                                        <input type="text" id="pay_amount" class="form-control" name="amount" />
                                                                                                    </span>
                                                                                                </div>

                                                                                                <div class="col-md-4">
                                                                                                    <label for="paid_at">تاريخ الدفع :</label>
                                                                                                    <span>
                                                                                                        <input type="date" id="paid_at" class="form-control" name="paid_at" />
                                                                                                    </span>
                                                                                                </div>

                                                                                                <div class="col-md-2">
                                                                                                    <label for="payment_method_id">طريقة الدفع :</label>
                                                                                                    <span>
                                                                                                        <select id="payment_method_id" name="payment_method_id" class="form-control">
                                                                                                                {{-- "طرق الدفع" list from system settings (SettingModule) --}}
                                                                                                                @foreach ($paymentMethods as $paymentMethod)
                                                                                                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                    </span>
                                                                                                </div>

                                                                                                <div class="col-md-1" style="text-align: center">
                                                                                                    <label>&nbsp;</label>
                                                                                                    <span>
                                                                                                        <br />
                                                                                                        <a class="btn btn-success pay" data-id="{{$reg->id}}" href="#">دفع</a>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="alert alert-danger" style="display: none">
                                                                                                    <strong>خطأ!</strong>
                                                                                                    <ul>
                                                                                                        <li></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal fade text-xs-left status-modal" id="modal-status-{{ $reg->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel90" aria-hidden="true">
                                                    <div class="modal-dialog" role="document" style="max-width: 500px;">
                                                        <div class="modal-content">
                                                            <div id="status-{{ $reg->id }}-info" style="">
                                                                <div class="modal-body content-reports status-modal" style="padding:0">
                                                                    <div class="statistic-table custom-bar">
                                                                        <form class="card-form" id="updateRegStatusForm" method="POST" action='{{ route(Auth::getDefaultDriver().'.courses.updatePaymentType') }}'>
                                                                            @csrf
                                                                            <input type="hidden" id="reg_id" name="reg_id" value="{{ $reg->id }}" />
                                                                            <div class="content-body">
                                                                                <div class="card-header">
                                                                                    <h4 class="card-title" style="float: right;">
                                                                                        تغيير حالة الدفع للطالب :
                                                                                        {{ $reg->student->name }}
                                                                                    </h4>
                                                                                </div>

                                                                                <div class="card-block status-template" style="margin-bottom: 20px">
                                                                                    <div class="card-text col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <label for="status">الحالة :</label>
                                                                                                <span>
                                                                                                    <select id="status" name="status" class="form-control">
                                                                                                        <option value="normal" selected>افتراضي</option>
                                                                                                        <option value="free" @if(in_array($reg->status_id,[8,9])) selected @endif>الدورة مجانا</option>
                                                                                                        <option value="nopaying" @if($reg->status_id == 10) selected @endif>ممتنع عن السداد</option>
                                                                                                        <option value="leave" @if($reg->is_leave == 1) selected @endif>مغادر</option>
                                                                                                        {{-- @foreach ($statuses as $status)
                                                                                                        <option value="{{$status->id}}" @if($reg->status_id == $status->id) selected @endif>{{$status->status}}</option>
                                                                                                        @endforeach --}}
                                                                                                    </select>
                                                                                                </span>
                                                                                            </div>

                                                                                            <div class="col-md-12" style="text-align: center">
                                                                                                <label>&nbsp;</label>
                                                                                                <span>
                                                                                                    <br />
                                                                                                    <a class="btn btn-success changeStatus" href="#">تغيير الحالة</a>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
