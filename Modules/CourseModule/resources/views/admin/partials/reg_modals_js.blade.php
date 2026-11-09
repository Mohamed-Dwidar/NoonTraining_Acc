{{-- JS for coursemodule::admin.partials.reg_modals + reg_actions (rows need id="reg{id}" with .paid_status_id / .paid_exam_id for نسخ البيانات). Include once, inside @push('scripts'). --}}
        <script>
            $(document).ready(function() {
                var actvRegID = 0;
                var actvPayID = 0;

                ///Reg Details
                $('.one-reg').click(function() {
                    actvRegID = this.id;
                    $('#modal-reg-info div.modal-content').html($('#reg-' + actvRegID + '-info').html());
                });

                $('.reg-modal .changeRegDate').click(function() {
                    $('#reg-' + actvRegID + '-info .regDateDV').hide();
                    $('#reg-' + actvRegID + '-info .chooseNewDateDV').show();
                    $('#reg-' + actvRegID + '-info #chngDate').val(1);
                });

                /////////////////
                //changePrice
                $('.reg-modal .changePrice').click(function() {
                    $('#reg-' + actvRegID + '-info .mainCost').hide();
                    $('#reg-' + actvRegID + '-info .newPrice').show();
                    //  $('#reg-'+actvRegID+'-info .savePrice').hide();
                    $('#reg-' + actvRegID + '-info #new_price').val();

                });

                $('.reg-modal .savePrice').on('click', function() {
                    // alert('hello');
                    var reg_id = $(this).attr('reg_id');
                    var new_price = $(`#new_price[reg_id="${reg_id}"]`).val();
                    var paid_amount = $(`#paid_amount[reg_id="${reg_id}"]`).val();
                    var main_price = $(`#main_price[reg_id="${reg_id}"]`).val();
                    var remain_amount = new_price - paid_amount;
                    var disc_perc = new_price == main_price ? 0 : Math.round((100 - (new_price / main_price * 100)) * 100) / 100;

                    $.ajax({
                        type: 'POST',
                        url: '{{ route(Auth::getDefaultDriver().'.ChangePriceForOneStudent') }}',
                        data: {
                            'new_price': new_price,
                            'reg_id': reg_id,
                            '_token': '<?php echo csrf_token(); ?>'
                        },
                        success: (result) => {
                            // console.log(result)
                            $('#reg-' + actvRegID + '-info .mainCost').show();
                            $('#reg-' + actvRegID + '-info .changePrice').show();
                            $('#reg-' + actvRegID + '-info .newPrice').hide();
                            //console.log($(`.mainCost[reg_id="${$('#reg_id').val()}"] .price`).length,$('#reg_id').val(),`.mainCost[reg_id="${$('#reg_id').val()}"] .price`);
                            $(`.mainCost[reg_id="${reg_id}"] .student_price`).text(result['new_price']);
                            $(`.finalPrice[reg_id="${reg_id}"] .price`).text(result['new_price']);
                            $(`.discountPrice[reg_id="${reg_id}"] .discount-value-text`).text(0 + '  ر.س');
                            $(`.regprice[reg_id="${reg_id}"]`).text(result['new_price']);
                            $(`.remaining_amount[reg_id="${reg_id}"]`).text(remain_amount);

                        },
                        error: function(jqXHR, exception) {
                            console.log('Uncaught Error.\n' + jqXHR.responseText);
                        }
                    });
                    return false;
                });


                $('.reg-modal .resetSave').click(function() {
                    $('#reg-' + actvRegID + '-info .newPrice').hide();
                    $('#reg-' + actvRegID + '-info .mainCost').show();
                    $('#reg-' + actvRegID + '-info .changePrice').show();
                    $('#reg-' + actvRegID + '-info #new_price').val(0);
                });

                $('input[name=new_price]').change(function(event) {
                    $('#reg-' + actvRegID + '-info .mainCost').hide();
                });
                ///////////////////////////


                //update discount
                $('.reg-modal .edit-discount-btn').click(function() {
                    $('#reg-' + actvRegID + '-info .discount-value-text').hide();
                    $('#reg-' + actvRegID + '-info .edit-discount-btn').hide();
                    $('#reg-' + actvRegID + '-info .discount-input').show();
                    $('#reg-' + actvRegID + '-info .save-discount-btn').show();
                    $('#reg-' + actvRegID + '-info .cancel-discount-btn').show();
                    $('#reg-' + actvRegID + '-info #new_discount').val();
                });

                $('.reg-modal .save-discount-btn').on('click', function() {
                    var reg_id = $(this).attr('reg_id');
                    var new_discount = $(`#discount-input[reg_id="${reg_id}"]`).val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route(Auth::getDefaultDriver().'.UpdateDiscountForOneStudent') }}',
                        data: {
                            'new_discount': new_discount,
                            'reg_id': reg_id,
                            '_token': '<?php echo csrf_token(); ?>'
                        },
                        success: (result) => {
                            // console.log(result)
                            $('#reg-' + actvRegID + '-info .discount-value-text').show();
                            $('#reg-' + actvRegID + '-info .edit-discount-btn').show();
                            $('#reg-' + actvRegID + '-info .discount-input').hide();
                            $('#reg-' + actvRegID + '-info .save-discount-btn').hide();
                            $('#reg-' + actvRegID + '-info .cancel-discount-btn').hide();
                            $(`.discount-value-text[reg_id="${reg_id}"]`).text(new_discount + '  ر.س');
                            // تحديث السعر النهائي
                            var priceElem = document.querySelector('.mainCost[reg_id="' + reg_id + '"] .student_price');
                            var finalPriceElem = document.querySelector('.price[reg_id="' + reg_id + '"]');
                            var price = priceElem ? parseFloat(priceElem.textContent) : 0;
                            var finalPrice = price - new_discount;
                            if (finalPriceElem) {
                                finalPriceElem.textContent = finalPrice.toFixed(2);
                            }
                            // تحديث المتبقي
                            var paidAmountElem = document.querySelector('.paid_amount[reg_id="' + reg_id + '"]');
                            var remainingAmountElem = document.querySelector('.remaining_amount[reg_id="' + reg_id + '"]');
                            var paidAmount = paidAmountElem ? parseFloat(paidAmountElem.textContent) : 0;
                            var remainingAmount = finalPrice - paidAmount;
                            if (remainingAmountElem) {
                                remainingAmountElem.textContent = remainingAmount.toFixed(2);
                            }
                        },
                        error: function(jqXHR, exception) {
                            console.log('Uncaught Error.\n' + jqXHR.responseText);
                        }
                    });
                    return false;
                });


                /////////////////

                //changeExamPrice
                $('.reg-modal .changeExamPrice').click(function() {
                    $('#reg-' + actvRegID + '-info .mainExamFees').hide();
                    $('#reg-' + actvRegID + '-info .newExamPrice').show();
                    $('#reg-' + actvRegID + '-info #new_exam_price').val();

                });

                $('.reg-modal .saveExamPrice').on('click', function() {
                    // alert('hello');
                    var reg_id = $(this).attr('reg_id');
                    var new_exam_price = $(`#new_exam_price[reg_id="${reg_id}"]`).val();
                    var paid_exam_amount = $(`#paid_exam_amount[reg_id="${reg_id}"]`).val();
                    var main_exam_price = $(`#main_exam_price[reg_id="${reg_id}"]`).val();
                    var remain_exam_amount = new_exam_price - paid_exam_amount;

                    $.ajax({
                        type: 'POST',
                        url: '{{ route(Auth::getDefaultDriver().'.ChangeExamPriceForOneStudent') }}',
                        data: {
                            'new_exam_price': new_exam_price,
                            'reg_id': reg_id,
                            '_token': '<?php echo csrf_token(); ?>'
                        },
                        success: (result) => {
                            // console.log(result)
                            $('#reg-' + actvRegID + '-info .mainExamFees').show();
                            $('#reg-' + actvRegID + '-info .changeExamPrice').show();
                            $('#reg-' + actvRegID + '-info .newExamPrice').hide();
                            $(`.mainExamFees[reg_id="${reg_id}"] .exam_fees`).text(result['new_exam_price']);
                            $(`.regexamprice[reg_id="${reg_id}"]`).text(result['new_exam_price']);
                            $(`.remaining_exam_amount[reg_id="${reg_id}"]`).text(remain_exam_amount);
                        },
                        error: function(jqXHR, exception) {
                            console.log('Uncaught Error.\n' + jqXHR.responseText);
                        }
                    });
                    return false;
                });


                $('.reg-modal .resetExamSave').click(function() {
                    $('#reg-' + actvRegID + '-info .newExamPrice').hide();
                    $('#reg-' + actvRegID + '-info .mainExamFees').show();
                    $('#reg-' + actvRegID + '-info .changeExamPrice').show();
                    $('#reg-' + actvRegID + '-info #new_exam_price').val(0);
                });

                $('input[name=new_exam_price]').change(function(event) {
                    $('#reg-' + actvRegID + '-info .mainExamCost').hide();
                });
                ///////////////////////////

                //changeRegBy
                // "تم التسجيل عن طريق" dropdown → Select2 (RTL, searchable)
                function initRegBySelect($el, $parent) {
                    if ($el.data('select2')) {
                        $el.select2('destroy');
                    }
                    $el.select2({
                        dir: 'rtl',
                        width: 'style',
                        placeholder: '-- اختر الموظف --',
                        dropdownParent: $parent,
                        language: {
                            noResults: function() {
                                return 'لا توجد نتائج';
                            }
                        }
                    });
                }

                $('.reg-modal .changeRegBy').click(function() {
                    $('#reg-' + actvRegID + '-info .regByText').hide();
                    $('#reg-' + actvRegID + '-info .newRegBy').show();
                    initRegBySelect($('#reg-' + actvRegID + '-info .newRegBy #reg_by'), $('#modal-reg-' + actvRegID));
                });

                $('.reg-modal .saveRegBy').on('click', function() {
                    var reg_id = $(this).attr('reg_id');
                    var $select = $('#reg-' + reg_id + '-info .newRegBy #reg_by');
                    var reg_by = $select.val();
                    if (!reg_by) {
                        alert('يجب اختيار الموظف');
                        return false;
                    }
                    $.ajax({
                        type: 'POST',
                        url: '{{ route(Auth::getDefaultDriver().'.updateRegBy') }}',
                        data: {
                            'reg_by': reg_by,
                            'reg_id': reg_id,
                            '_token': '<?php echo csrf_token(); ?>'
                        },
                        success: (result) => {
                            var $info = $('#reg-' + reg_id + '-info');
                            $info.find('.regByName').text(result.new_reg_by || '----');
                            var $sel = $info.find('.newRegBy #reg_by');
                            $sel.find('option').removeAttr('selected');
                            $sel.find('option[value="' + result.new_reg_by_id + '"]').attr('selected', 'selected');
                            $sel.val(result.new_reg_by_id).trigger('change');
                            $info.find('.regByText').show();
                            $info.find('.newRegBy').hide();
                        },
                        error: function(jqXHR, exception) {
                            var msg = (jqXHR.responseJSON && jqXHR.responseJSON.message) ? jqXHR.responseJSON.message : 'حدث خطأ أثناء الحفظ';
                            alert(msg);
                        }
                    });
                    return false;
                });


                $('.reg-modal .resetRegBy').click(function() {
                    var $info = $('#reg-' + actvRegID + '-info');
                    $info.find('.regByText').show();
                    $info.find('.newRegBy').hide();
                    // restore the saved employee in the list
                    var $select = $info.find('.newRegBy #reg_by');
                    $select.val($select.find('option[selected]').val() || '').trigger('change');
                });
                ///////////////////////////


                //Pay
                $('.one-pay').click(function() {
                    actvRegID = this.id;
                    $('#modal-pay-info div.modal-content').html($('#pay-' + actvRegID + '-info').html());
                });
                $('.pay-modal .pay').click(function() {;
                    var regPriceRest = parseFloat($('#pay-' + actvRegID + '-info #price_rest').val()) ;
                    var regExamFeesRest = parseFloat($('#pay-' + actvRegID + '-info #exam_fees_rest').val()) ;
                    var payType = $('#pay-' + actvRegID + '-info  #pay_type').find(":selected").val();
                    var payAmount = parseFloat($('#pay-' + actvRegID + '-info #pay_amount').val());
                    var payDate = $('#pay-' + actvRegID + '-info #paid_at').val();
                    //  console.log();
                    //  return false;

                    if($('#pay-' + actvRegID + '-info #pay_amount').val() == ''){
                        showPayAlert('يجب ادخال القيمة المدفوعة');
                        return false;
                    }else if(payDate == ''){
                        showPayAlert('يجب ادخال تاريخ الدفع');
                        return false;
                    }else if(payType == 'دفعة للدورة'){
                        if(payAmount > regPriceRest){       //if paid more than the rest price
                            showPayAlert('القيمة المدفوعة اكبر من المبلغ المتبقي لقيمة الدورة');
                            return false;
                        }
                    }else if(payType == 'رسوم الاختبار'){
                        if(payAmount > regExamFeesRest){       //if paid more than the rest price
                            showPayAlert('القيمة المدفوعة اكبر من المبلغ المتبقي لرسوم الاختبار');
                            return false;
                        }
                    }
                    $('#pay-' + actvRegID + '-info #payActionForm').submit();
                    return false;
                });

                function showPayAlert(msg){
                    $('#pay-' + actvRegID + '-info .alert li').html(msg);
                    $('#pay-' + actvRegID + '-info .alert').show().delay(4000).fadeOut('slow');
                }

                //Status
                $('.one-status').click(function() {
                    actvRegID = this.id;
                   // $('#modal-pay-info div.modal-content').html($('#pay-' + actvRegID + '-info').html());
                });
                $('.status-modal .changeStatus').click(function() {
                    console.log(actvRegID);
                    $('#status-' + actvRegID + '-info #updateRegStatusForm').submit();
                    return;
                });
            });
        </script>
        <script>
            // "تم التسجيل عن طريق" in copied text: admins, or users with 'show_reg_by_in_copy'
            const showRegByInCopy = @json(Auth::guard('admin')->check() || Auth::guard('user')->user()?->can('show_reg_by_in_copy'));

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[id^="copy-button-"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const regId = this.id.split('-')[2];


                        // const courseName = $('#modal-reg-'+regId+' .course-name').html();
                        // const studentName = studentNameElement ? studentNameElement.innerText : 'N/A';
                        // const idNumber = idNumberElement ? idNumberElement.innerText : 'N/A';
                        // const phone = phoneElement ? phoneElement.innerText : 'N/A';
                        // const totalAmount = totalAmountElement ? totalAmountElement.innerText : 'N/A';
                        // const paidAmount = paidAmountElement ? paidAmountElement.innerText : 'N/A';
                        // const remainingAmount = remainingAmountElement ? remainingAmountElement
                        //     .innerText : 'N/A';
                        // const status = statusElement ? statusElement.innerText : 'N/A';


                        const courseNameElement = document.querySelector('#modal-reg-'+regId+' .course-name');
                        const studentNameElement = document.querySelector('#modal-reg-'+regId+' .student-name');
                        const idNumberElement = document.querySelector('#modal-reg-'+regId+' .id-number');
                        const phoneElement = document.querySelector('#modal-reg-'+regId+' .phone');
                        const totalAmountElement = document.querySelector('#modal-pay-'+regId+' .price');
                        const paidAmountElement = document.querySelector('#modal-pay-'+regId+' .paid_amount');
                        const remainingAmountElement = document.querySelector('#modal-pay-'+regId+' .remaining_amount');
                        const statusElement = document.querySelector('#reg'+regId+' .paid_status_id');
                        const validStatuses = [3, 4, 5, 6, 7, 9];
                        const examPaidStatusElement = document.querySelector('#reg'+regId+' .paid_exam_id');
                        const regByElement = document.querySelector('#modal-reg-'+regId+' .regByName');

                        const courseName = courseNameElement ? courseNameElement.innerText : 'N/A';
                        const studentName = studentNameElement ? studentNameElement.innerText : 'N/A';
                        const idNumber = idNumberElement ? idNumberElement.innerText : 'N/A';
                        const phone = phoneElement ? phoneElement.innerText : 'N/A';
                        const totalAmount = totalAmountElement ? totalAmountElement.innerText.replace(/\s+/g, ' ').trim() : 'N/A';
                        const paidAmount = paidAmountElement ? paidAmountElement.innerText.replace(/\s+/g, ' ').trim() : 'N/A';
                        const remainingAmount = remainingAmountElement ? remainingAmountElement.innerText.replace(/\s+/g, ' ').trim() : 'N/A';
                        //const status = validStatuses.includes(Number(statusElement.innerText)) ? 'نعم' : 'لا';
                        const examPaidStatus = examPaidStatusElement.innerText == 1 ? 'نعم' : 'لا';
                        const regBy = regByElement ? regByElement.innerText.replace(/\s+/g, ' ').trim() : '----';

                        const copyText =
                            'اسم الدورة: '+courseName+'\nاسم الطالب: '+studentName+'\nرقم الهوية: '+idNumber+'\nرقم الجوال: '+phone+'\nالمبلغ كامل : '+totalAmount+'\nمدفوع  : '+paidAmount+'\nمتبقي :'+remainingAmount+'\nسدد رسوم الاختبار ؟: '+examPaidStatus
                            +(showRegByInCopy ? '\nتم التسجيل عن طريق : '+regBy : '');
                        // console.log(copyText);

                        navigator.clipboard.writeText(copyText).then(() => {
                            alert('تم نسخ المعلومات بنجاح');
                        }).catch(err => {
                            alert(
                                'فشل في نسخ المعلومات! تأكد من دعم المتصفح لاستخدام Clipboard API.');
                        });
                    });
                });
            });
        </script>
