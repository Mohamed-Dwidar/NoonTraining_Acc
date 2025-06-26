<table>
    <thead>
        <tr>
            <td colspan="17">بيانات الطالب</td>
        </tr>
        <tr class="head">
            <th>الطالب</th>
            <th>البريد الألكتروني</th>
            <th>التليفون</th>
            <th>الجوال</th>
            <th>تاريخ الميلاد</th>
            <th>محل الميلاد</th>
            <th>رقم الحفيظة</th>
            <th>الجنسية</th>
            <th>العنوان</th>
            <th>رقم البطاقة / الإقامة</th>
            <th>المؤهل الدراسي</th>
            <th>الوظيفة</th>
            <th>التكلفة</th>
            <th>المدفوع</th>
            <th>الباقي</th>
            <th>تم اصدار الشهادة</th>
            <th>استلم الشهادة</th>
        </tr>
    </thead>
    <tbody>


        <tr>
            <td>{{$student->name}}</td>
            <td>{{$student->email}}</td>
            <td>{{$student->phone}}</td>
            <td>{{$student->mobile}}</td>
            <td>{{$student->birthdate}}</td>
            <td>{{$student->birthblace}}</td>
            <td>{{$student->hafiza_nu}}</td>
            <td>{{$student->nationality}}</td>
            <td>{{$student->address}}</td>
            <td>{{$student->id_nu}}</td>
            <td>{{$student->qualification}}</td>
            <td>{{$student->occupation}}</td>
        </tr>

    </tbody>
</table>




<table class="table mb-0">
    <thead>

        <tr>
            <td colspan="17">الدورات</td>
        </tr>
        <tr>
            <th>الدورة</th>
            <th>تاريخ الدورة</th>
            <th>التكلفة </th>
            <th>المدفوعات</th>
            <th>الباقي</th>
            <th>تم اصدار الشهادة</th>
            <th>استلم الشهادة</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($student->courses_regs))
        @foreach ($student->courses_regs as $reg)

        <tr>
            <td>{{$reg->coursesDate->course->name}}</td>
            <td>{{$reg->coursesDate->start_at}}</td>
            <td>
                {{$reg->price}}
            </td>
            <td>{{number_format($reg->payments->sum('amount'),2)}}</td>
            <td>{{number_format($reg->price - $reg->payments->sum('amount'),2)}}</td>

            <td>
                @if($reg->certificate)
                نعم
                @else
                لا
                @endif
            </td>

            <td>
                @if($reg->is_recive_cert == 1)
                نعم
                @else
                لا
                @endif
            </td>


        </tr>
        @endforeach
        @endif
    </tbody>
</table>