<div dir="rtl" style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2>🚨 إشعار بطلب جديد من مستشفى</h2>
    <p>تم استلام طلب جديد عبر الكتالوج الأعمى. التفاصيل:</p>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr>
            <td style="background: #f4f4f4;"><strong>اسم المستشفى:</strong></td>
            <td>{{ $hospitalName }}</td>
        </tr>
        <tr>
            <td style="background: #f4f4f4;"><strong>مسؤول التوظيف:</strong></td>
            <td>{{ $hrName }}</td>
        </tr>
        <tr>
            <td style="background: #f4f4f4;"><strong>الإيميل:</strong></td>
            <td><a href="mailto:{{ $hrEmail }}">{{ $hrEmail }}</a></td>
        </tr>
    </table>
    
    <h3>الأكواد المطلوبة:</h3>
    <ul>
        @foreach($requestedCodes as $code)
            <li>{{ $code }}</li>
        @endforeach
    </ul>
    
    <p>يرجى التواصل مع المستشفى في أقرب وقت لإتمام الإجراءات.</p>
</div>