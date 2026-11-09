{{-- Registration row buttons (التفاصيل / الدفعات / تغيير حالة الدفع / حذف). Needs \$reg. Used by course + student show pages. --}}
                                                        <a class="btn-sm btn-blue one-reg" href="#"
                                                            id="{{ $reg->id }}" role="button" data-toggle="modal"
                                                            data-target="#modal-reg-{{ $reg->id }}">التفاصيل</a>

                                                        <a class="btn-sm btn-primary one-pay" href="#"
                                                            id="{{ $reg->id }}" role="button" data-toggle="modal"
                                                            data-target="#modal-pay-{{ $reg->id }}">الدفعات</a>


                                                       @cannot('view_only')
                                                            @if (Auth::guard('admin')->check() || Auth::user()->can('can_edit'))
                                                                <a class="btn-sm btn-warning one-status" href="#"
                                                                id="{{ $reg->id }}" role="button" data-toggle="modal"
                                                                data-target="#modal-status-{{ $reg->id }}">تغيير حالة الدفع</a>
                                                            @endif

                                                            @if (Auth::guard('admin')->check() || Auth::user()->can('can_delete'))
                                                                <a class="btn-sm btn-danger"
                                                                    href="{{ route(Auth::getDefaultDriver().'.courses.delete_reg', $reg->id) }}"
                                                                    onclick="return confirm('هل انت متأكد انك تريد حذف هذا الطلب ؟')"
                                                                    role="button">حذف</a>
                                                            @endif
                                                        @endcannot
