<div dir="rtl" style="font-family: Arial, sans-serif; color: #0a3d62; line-height: 1.6;">
    <h2 style="color: #bda065;">السيد/ة {{ $hrName }}،</h2>
    <p>نشكركم في <strong>{{ $hospitalName }}</strong> على استخدامكم الكتالوج الأعمى لمنصة روافد.</p>
    <p>لقد تم استلام طلبكم بنجاح للمرشحين أصحاب الأكواد التالية:</p>
    <ul>
        @foreach($requestedCodes as $code)
            <li><strong>{{ $code }}</strong></li>
        @endforeach
    </ul>
    <p>سيقوم فريق المطابقة والمبيعات لدينا بتجهيز السير الذاتية الأصلية وبيانات التواصل للمرشحين أعلاه، وسنقوم بالتواصل معكم قريباً جداً عبر هذا البريد الإلكتروني لتنسيق المقابلات.</p>
    <br>
    <p>مع خالص التحيات،<br>فريق علاقات الشركاء - منصة روافد</p>
</div>