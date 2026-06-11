<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - الإدارة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">بوابة الإدارة المركزية</h2>
            <p class="text-gray-500 mt-2">يرجى إدخال بيانات الاعتماد للوصول</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">كلمة المرور</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-blue-500">
                    <span class="ml-2 text-gray-700 text-sm mr-2">تذكرني</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                تسجيل الدخول
            </button>
        </form>
    </div>

</body>
</html>