<table class="table mb-0">
    <thead>
        <tr class="head">
            <th style="font-weight: bold;text-align: right">المستخدم</th>
            <th style="font-weight: bold;text-align: right">الوقت / التاريخ</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($logs as $log)
        <tr>
            <td class="strong" style="text-align: right">
                {{ $log->loggable->name }}
            </td>
            <td style="text-align: right">
                {{ $log->login_time }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
