<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توثيق API - النظام المركزي UIMP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f8f9fa; }
        .sidebar { position: fixed; top: 0; right: 0; width: 280px; height: 100vh; background: #1e3d59; z-index: 100; overflow-y: auto; }
        .sidebar .nav-link { color: rgba(255,255,255,0.75); padding: 10px 20px; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .sidebar .section-title { color: rgba(255,255,255,0.4); font-size: 0.75rem; padding: 20px 20px 8px; text-transform: uppercase; }
        .main-content { margin-right: 280px; min-height: 100vh; }
        .endpoint { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 1rem; overflow: hidden; }
        .endpoint-header { padding: 1rem; display: flex; align-items: center; gap: 0.75rem; border-bottom: 1px solid #eee; }
        .method { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; color: #fff; min-width: 60px; text-align: center; }
        .method-get { background: #28a745; }
        .method-post { background: #007bff; }
        .method-put { background: #ffc107; color: #000; }
        .method-delete { background: #dc3545; }
        .endpoint-body { padding: 1rem; }
        .endpoint-body pre { background: #f4f6f9; padding: 1rem; border-radius: 6px; font-size: 0.85rem; }
        code { background: #e9ecef; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="sidebar d-none d-md-block">
        <div class="p-3 text-center border-bottom border-light border-opacity-10">
            <h5 class="text-white fw-bold mb-0">UIMP API</h5>
            <small class="text-white-50">توثيق واجهة التكامل</small>
        </div>
        <div class="section-title">المصادقة</div>
        <a href="#auth" class="nav-link">المصادقة والتوكن</a>
        <div class="section-title">البيانات المشتركة</div>
        <a href="#users" class="nav-link">المستخدمين</a>
        <a href="#students" class="nav-link">الطلاب</a>
        <a href="#employees" class="nav-link">الموظفين</a>
        <a href="#buildings" class="nav-link">المباني</a>
        <a href="#rooms" class="nav-link">القاعات</a>
        <a href="#laboratories" class="nav-link">المعامل</a>
        <div class="section-title">النظام</div>
        <a href="#health" class="nav-link">فحص الصحة</a>
        <a href="#register" class="nav-link">تسجيل نظام فرعي</a>
    </div>

    <div class="main-content p-4">
        <div class="mb-4">
            <h1 class="fw-bold">توثيق API - النظام المركزي UIMP</h1>
            <p class="text-muted">واجهة برمجة التطبيقات للأنظمة الفرعية — الإصدار 1.0</p>
            <div class="alert alert-info">
                <strong>المصادقة:</strong> جميع نقاط API المحمية تتطلب مفتاح API (X-API-Key) + توكن Sanctum.
                يجب أولاً تسجيل النظام الفرعي واستلام مفتاح API، ثم استخدامه لإصدار توكن.
            </div>
        </div>

        <h2 id="auth" class="fw-bold mb-3">المصادقة وإدارة التوكن</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-post">POST</span>
                <code>/api/auth/token</code>
                <span class="text-muted small">إصدار توكن Sanctum للوصول إلى API</span>
            </div>
            <div class="endpoint-body">
                <strong>الترويسات المطلوبة:</strong>
                <pre>Content-Type: application/json
X-API-Key: {مفتاح API الخاص بالنظام الفرعي}</pre>
                <strong>جسم الطلب (JSON):</strong>
                <pre>{
  "email": "admin@uimp.edu",
  "password": "password"
}</pre>
                <strong>الاستجابة:</strong>
                <pre>{
  "token": "1|abc123...plainTextToken",
  "user": {
    "id": 1,
    "name": "مدير النظام",
    "email": "admin@uimp.edu",
    "roles": ["sys_admin"]
  }
}</pre>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/auth/verify</code>
                <span class="text-muted small">التحقق من صحة التوكن</span>
            </div>
            <div class="endpoint-body">
                <strong>الترويسات المطلوبة:</strong>
                <pre>Authorization: Bearer {sanctum_token}
X-API-Key: {مفتاح API}</pre>
                <strong>الاستجابة:</strong>
                <pre>{
  "valid": true,
  "user": {
    "id": 1,
    "name": "مدير النظام",
    "email": "admin@uimp.edu",
    "roles": ["sys_admin"]
  }
}</pre>
            </div>
        </div>

        <h2 id="users" class="fw-bold mb-3 mt-5">المستخدمين</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/users</code>
                <span class="text-muted small">قائمة المستخدمين</span>
            </div>
            <div class="endpoint-body">
                <strong>الترويسات المطلوبة:</strong>
                <pre>Authorization: Bearer {sanctum_token}
X-API-Key: {مفتاح API}</pre>
                <strong>معلّمات اختيارية:</strong>
                <pre>?role=sys_admin|lab_supervisor|student
&search=اسم_أو_بريد
&per_page=50</pre>
                <strong>الصلاحية المطلوبة:</strong> <code>users.read</code>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/users/{id}</code>
                <span class="text-muted small">تفاصيل مستخدم مع الملف الشخصي</span>
            </div>
            <div class="endpoint-body">
                <strong>الاستجابة:</strong>
                <pre>{
  "user": { "id": 1, "name": "...", "email": "...", "roles": [...] },
  "profile": { "student_code": "...", "department": {...} }
}</pre>
                <strong>الصلاحية المطلوبة:</strong> <code>users.read</code>
            </div>
        </div>

        <h2 id="students" class="fw-bold mb-3 mt-5">الطلاب (للنظام الفرعي)</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/students</code>
                <span class="text-muted small">قائمة الطلاب</span>
            </div>
            <div class="endpoint-body">
                <strong>معلّمات اختيارية:</strong>
                <pre>?department_id=1&academic_year=3&per_page=50</pre>
                <strong>الصلاحية المطلوبة:</strong> <code>students.read</code>
            </div>
        </div>

        <h2 id="employees" class="fw-bold mb-3 mt-5">الموظفين</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/employees</code>
                <span class="text-muted small">قائمة الموظفين والأكاديميين</span>
            </div>
            <div class="endpoint-body">
                <strong>معلّمات اختيارية:</strong>
                <pre>?department_id=1&per_page=50</pre>
                <strong>الصلاحية المطلوبة:</strong> <code>employees.read</code>
            </div>
        </div>

        <h2 id="buildings" class="fw-bold mb-3 mt-5">المباني</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/buildings</code>
                <span class="text-muted small">قائمة المباني مع عدد القاعات</span>
            </div>
            <div class="endpoint-body">
                <strong>الصلاحية المطلوبة:</strong> <code>buildings.read</code>
            </div>
        </div>

        <h2 id="rooms" class="fw-bold mb-3 mt-5">القاعات (جوهرية لنظام المعامل)</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/rooms</code>
                <span class="text-muted small">قائمة القاعات مع فلترة</span>
            </div>
            <div class="endpoint-body">
                <strong>معلّمات اختيارية:</strong>
                <pre>?building_id=1
&type=lecture|lab|office|meeting|auditorium
&is_lab=true|false
&min_capacity=30
&per_page=50</pre>
                <strong>الصلاحية المطلوبة:</strong> <code>rooms.read</code>
                <div class="alert alert-warning mt-2 mb-0 py-2">
                    <small>نظام حجز المعامل يستخدم هذه النقطة لجلب القاعات المتاحة.</small>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/rooms/{id}</code>
                <span class="text-muted small">تفاصيل قاعة</span>
            </div>
            <div class="endpoint-body">
                <strong>الصلاحية المطلوبة:</strong> <code>rooms.read</code>
            </div>
        </div>

        <h2 id="laboratories" class="fw-bold mb-3 mt-5">المعامل</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/laboratories</code>
                <span class="text-muted small">قائمة المعامل</span>
            </div>
            <div class="endpoint-body">
                <strong>معلّمات اختيارية:</strong>
                <pre>?department_id=1&is_active=true&per_page=50</pre>
                <strong>الصلاحية المطلوبة:</strong> <code>laboratories.read</code>
            </div>
        </div>

        <h2 id="register" class="fw-bold mb-3 mt-5">تسجيل نظام فرعي جديد</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-post">POST</span>
                <code>/api/subsystems/register</code>
                <span class="text-muted small">تسجيل نظام فرعي جديد (نقطة عامة)</span>
            </div>
            <div class="endpoint-body">
                <strong>جسم الطلب (JSON):</strong>
                <pre>{
  "name": "نظام حجز المعامل",
  "slug": "lab-booking",
  "description": "نظام إدارة وحجز المعامل",
  "contact_email": "admin@lab.uimp.edu",
  "webhook_url": "https://lab.uimp.edu/webhook"
}</pre>
                <strong>الاستجابة:</strong>
                <pre>{
  "message": "Subsystem registered successfully",
  "subsystem": { "id": 1, "name": "نظام حجز المعامل", "slug": "lab-booking", ... },
  "api_key": "qwerty12345..."
}</pre>
                <div class="alert alert-success mt-2 mb-0 py-2">
                    <small>احتفظ بـ API Key — يُستخدم في جميع الطلبات اللاحقة.</small>
                </div>
            </div>
        </div>

        <h2 id="health" class="fw-bold mb-3 mt-5">فحص صحة النظام</h2>

        <div class="endpoint">
            <div class="endpoint-header">
                <span class="method method-get">GET</span>
                <code>/api/health</code>
                <span class="text-muted small">حالة النظام المركزي</span>
            </div>
            <div class="endpoint-body">
                <strong>الاستجابة:</strong>
                <pre>{
  "status": "ok",
  "timestamp": "2026-06-17T12:00:00Z",
  "version": "1.0.0",
  "name": "UIMP-Core"
}</pre>
            </div>
        </div>

        <hr class="my-5">
        <p class="text-muted text-center">
            UIMP Core Platform v1.0 — API Docs
            <br><a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm mt-2">العودة للوحة التحكم</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
