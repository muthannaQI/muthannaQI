# الطائر الأخضر للسفر والسياحة - نظام المبيعات v2.1

نظام مبيعات متكامل لشركة سفر وسياحة. يعمل على الشبكة المحلية (LAN) ويدعم أجهزة متعددة في وقت واحد عبر WebSocket.

## التقنيات المستخدمة

- **Backend**: Python / FastAPI + SQLite + WebSocket
- **Frontend**: HTML/CSS/JS (ملف واحد، بدون framework)
- **Auth**: JWT (Bearer token، صلاحية 12 ساعة)
- **Port**: 8000

## هيكل المشروع

```
altaer/
├── backend/
│   ├── main.py              ← السيرفر + قاعدة البيانات + المصادقة + النسخ الاحتياطي
│   ├── routes/
│   │   ├── __init__.py      ← جميع المسارات: auth, sales, payments, reports, admin, loans, buses
│   │   └── invoices.py      ← مسارات الفواتير (منفصل بسبب شعار base64 الكبير)
│   ├── backups/             ← نسخ احتياطية تلقائية (.db)
│   ├── altaer.db            ← قاعدة البيانات SQLite
│   └── requirements.txt
├── frontend/
│   ├── index.html           ← واجهة المستخدم الكاملة (SPA)
│   └── user-guide.html      ← دليل المستخدم
├── start.bat                ← تشغيل على Windows
├── start.sh                 ← تشغيل على Linux/Mac
└── CLAUDE.md
```

## تشغيل المشروع

```bash
cd backend
pip install -r requirements.txt
python main.py
# يعمل على http://localhost:8000
```

## قاعدة البيانات (SQLite)

جداول `backend/altaer.db`:

| الجدول | الغرض |
|--------|--------|
| `users` | المستخدمون (اسم، كلمة مرور bcrypt، الدور، رقم الحاسبة، نسبة العمولة) |
| `exchange_rates` | أسعار صرف العملات إلى IQD |
| `sales` | عمليات البيع (رقم الفاتورة، العميل، الخدمة، السعر، التكلفة، الربح، الحالة) |
| `payments` | دفعات القبض لكل عملية بيع |
| `commissions` | عمولات الموظفين (0.5% من الربح، عدا الباقات) |
| `loans` | سلف الموظفين |
| `loan_repayments` | سداد السلف |
| `buses` | رحلات الحافلات (المسار، التاريخ، المقاعد، السعر) |
| `bus_costs` | تكاليف الحافلات التفصيلية |
| `audit_log` | سجل جميع العمليات (من فعل ماذا ومتى) |

### حالات البيع (sales.status)
- `pending` — لم يُقبض بعد
- `partial` — قُبض جزئياً
- `confirmed` — مدفوع بالكامل
- `cancelled` — ملغي

### العملات المدعومة
`IQD` (دينار عراقي) · `USD` (دولار) · `TMN` (تومان إيراني) · `SAR` (ريال سعودي)

يتم تحويل كل مبلغ تلقائياً إلى IQD عند التسجيل باستخدام `exchange_rates.rate_to_iqd`.

### ترقيم الفواتير
التنسيق: `ALT-YYYY-NNNN` (مثال: `ALT-2025-0001`) — يُولَّد تلقائياً في `generate_invoice_number()`.

## أدوار المستخدمين والصلاحيات

| الدور | username | الوصف |
|-------|----------|-------|
| `sales` | cashier1–8 | موظف مبيعات: يسجّل العمليات، يرى مبيعاته ومبيعات الجميع، يطبع فواتير. لا يقبض مبالغ. |
| `accountant` | accounts | المحاسب: يقبض المبالغ، يرى جميع العمليات، التقارير الكاملة، يحدّث أسعار الصرف. |
| `admin` | admin | المدير: صلاحيات كاملة + إدارة المستخدمين + تعديل العمولات + audit log + النسخ الاحتياطي. |

## نقاط الـ API

### المصادقة (`/api/auth`)
- `POST /api/auth/login` — تسجيل الدخول، يرجع JWT token
- `GET /api/auth/me` — بيانات المستخدم الحالي

### المبيعات (`/api/sales`)
- `POST /api/sales/` — إضافة عملية بيع جديدة (sales/admin فقط)
- `GET /api/sales/` — قائمة المبيعات (فلترة: status, currency, service_type, date_from, date_to, search, page, limit)
- `GET /api/sales/{id}` — تفاصيل عملية بيع
- `PUT /api/sales/{id}` — تعديل بيع (admin أو صاحب العملية قبل القبض)
- `DELETE /api/sales/{id}` — إلغاء بيع (admin فقط)

### القبض والمدفوعات (`/api/payments`)
- `POST /api/payments/` — تسجيل دفعة قبض (accountant/admin فقط)
- `GET /api/payments/{sale_id}` — دفعات عملية بيع محددة
- `DELETE /api/payments/{id}` — حذف دفعة (admin فقط)

### التقارير (`/api/reports`)
- `GET /api/reports/daily` — تقرير يومي
- `GET /api/reports/monthly` — تقرير شهري
- `GET /api/reports/cashier` — أداء كل حاسبة
- `GET /api/reports/commissions` — عمولات الموظفين الشهرية
- `GET /api/reports/export` — تصدير CSV

### الإدارة (`/api/admin`)
- `GET/POST/PUT/DELETE /api/admin/users` — إدارة المستخدمين
- `GET/PUT /api/admin/exchange-rates` — أسعار الصرف
- `GET /api/admin/audit-log` — سجل العمليات
- `PUT /api/admin/commissions/{id}/pay` — دفع عمولة

### السلف (`/api/loans`)
- `POST /api/loans/` — إضافة سلفة
- `GET /api/loans/` — قائمة السلف
- `POST /api/loans/{id}/repayment` — تسجيل سداد
- `GET /api/loans/{id}` — تفاصيل سلفة

### الحافلات (`/api/buses`)
- `POST /api/buses/` — إضافة رحلة
- `GET /api/buses/` — قائمة الرحلات
- `GET /api/buses/{id}` — تفاصيل رحلة
- `PUT /api/buses/{id}` — تعديل رحلة
- `DELETE /api/buses/{id}` — حذف رحلة
- `POST /api/buses/{id}/costs` — إضافة تكلفة لرحلة

### الفواتير (`/api/invoices`)
- `GET /api/invoices/{sale_id}` — فاتورة HTML احترافية جاهزة للطباعة

### النسخ الاحتياطي (`/api/backup`) — admin فقط
- `POST /api/backup` — إنشاء وتنزيل نسخة فورية
- `GET /api/backup/list` — قائمة النسخ المحفوظة
- `GET /api/backup/download/{filename}` — تنزيل نسخة محددة
- `POST /api/backup/restore` — استعادة من ملف (يعيد تشغيل التطبيق)

## نمط الكود

### إضافة route جديد في `routes/__init__.py`

```python
new_router = APIRouter()

class NewModel(BaseModel):
    field: str

@new_router.post("/")
async def create_item(data: NewModel, db=Depends(get_db),
                      user=Depends(require_role("admin"))):
    cursor = db.cursor()
    cursor.execute("INSERT INTO table (field) VALUES (?)", (data.field,))
    item_id = cursor.lastrowid
    log_action(db, user["user_id"], user["username"], "CREATE_ITEM", "table", item_id)
    db.commit()
    return {"id": item_id}
```

ثم في `main.py`:
```python
from routes import new_router
app.include_router(new_router, prefix="/api/new", tags=["new"])
```

### قراءة نموذجية من قاعدة البيانات

```python
cursor = db.cursor()
cursor.execute("SELECT * FROM sales WHERE id = ?", (sale_id,))
row = cursor.fetchone()
if not row:
    raise HTTPException(status_code=404, detail="غير موجود")
return dict(row)
```

### إرسال إشعار WebSocket

```python
try:
    mgr = request.app.state.manager
    await mgr.broadcast({
        "type": "event_type",
        "key": "value",
        "timestamp": datetime.now().isoformat(),
    })
except Exception:
    pass
```

## النسخ الاحتياطي التلقائي

- يعمل في خيط خلفي (daemon thread) كل **24 ساعة**
- يحفظ الملفات في `backend/backups/` بصيغة `altaer_backup_YYYYMMDD_HHMMSS.db`
- يحتفظ بآخر **30 نسخة** فقط (يحذف الأقدم تلقائياً)
- نسخ الاستعادة تُحفظ باسم `pre_restore_*.db`
- يستخدم SQLite Backup API (آمن مع WAL mode)

## WebSocket

الاتصال: `ws://localhost:8000/ws/{client_id}`

أنواع الرسائل المُبثّة:
- `user_connected` — عند اتصال مستخدم جديد
- `new_sale` — عند تسجيل عملية بيع (invoice, client, amount, currency, cashier)
- `payment_confirmed` — عند تأكيد قبض (يُبث من مسارات الدفعات)

## اعتبارات مهمة

- **لا تعدّل `profit`** في جدول `sales` مباشرةً — هو عمود `GENERATED ALWAYS AS (sell_price - cost_price)`.
- **العمولة لا تُحسب للباقات**: أي خدمة يحتوي اسمها على "باقة" تُعطى عمولة صفر.
- **كلمات المرور**: مخزّنة بـ bcrypt، وتُرقَّى تلقائياً من SHA256 عند أول تسجيل دخول.
- **`details_only=true`** في `SaleUpdate`: يسمح بتعديل تفاصيل الخدمة والملاحظات فقط دون المساس بالمبالغ.
- **الفواتير** في `routes/invoices.py` منفصلة بسبب شعار base64 ضخم — لا تدمجها في `__init__.py`.
- **CORS** مقيّد بـ `ALTAER_ALLOWED_ORIGINS` env var (افتراضي: localhost:8000 فقط).
