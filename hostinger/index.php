<?php /* Bina App v5.4 — plantaslb.com */ ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>حساب عمل البناء</title>
  <style>
    /* ── Bina Design System v5.3 — tokens ── */
    @font-face {
      font-family:"Segoe UI Brand";
      src:url("design_system/fonts/segoeuib.ttf") format("truetype");
      font-weight:700; font-style:normal; font-display:swap;
    }
    @font-face {
      font-family:"Consolas";
      src:url("design_system/fonts/consolab.ttf") format("truetype");
      font-weight:700; font-style:normal; font-display:swap;
    }
    :root {
      /* ── Brand colors ── */
      --bina-green:        #227467;
      --bina-green-dark:   #17564b;
      --bina-blue:         #2f6478;
      --bina-amber:        #bb741f;
      --bina-rose:         #b74f47;
      --bina-whatsapp:     #25d366;
      /* ── Neutrals ── */
      --bina-ink:          #17201a;
      --bina-muted:        #68736d;
      --bina-line:         #d8ded7;
      --bina-surface:      #ffffff;
      --bina-page:         #f5f7f3;
      /* ── Soft tints ── */
      --bina-tint-green:   #e9f1ed;
      --bina-tint-green-2: #dff0e8;
      --bina-tint-green-3: #c8e6d6;
      --bina-tint-green-4: #eef4f0;
      --bina-tint-green-5: #cfd8d2;
      --bina-tint-blue:    #deeaf5;
      --bina-tint-table:   #f9faf8;
      --bina-tint-pill:    #f4f6f5;
      /* ── Effects ── */
      --bina-focus-ring:   rgba(34,116,103,.18);
      --bina-scrim:        rgba(0,0,0,.45);
      --bina-shadow:       0 14px 34px rgba(23,32,26,.08);
      --bina-shadow-modal: 0 24px 60px rgba(0,0,0,.25);
      /* ── Radii ── */
      --bina-r-sm:   6px;
      --bina-r-md:   7px;
      --bina-r-lg:   8px;
      --bina-r-xl:   12px;
      --bina-r-pill: 999px;
      /* ── Typography ── */
      --bina-font: "Segoe UI Brand","Segoe UI",Tahoma,"Cairo",Arial,sans-serif;
      --bina-font-mono: "Consolas",ui-monospace,monospace;
      /* ── Legacy aliases (keep JS untouched) ── */
      --ink:        var(--bina-ink);
      --muted:      var(--bina-muted);
      --line:       var(--bina-line);
      --surface:    var(--bina-surface);
      --page:       var(--bina-page);
      --green:      var(--bina-green);
      --green-dark: var(--bina-green-dark);
      --amber:      var(--bina-amber);
      --rose:       var(--bina-rose);
      --blue:       var(--bina-blue);
      --shadow:     var(--bina-shadow);
    }
    body { margin:0; }
    #bna-app *, #bna-app *::before, #bna-app *::after { box-sizing:border-box; }
    #bna-app { margin:0; min-height:100vh; font-family:var(--bina-font); background:var(--bina-page); color:var(--bina-ink); }
    #bna-app button, #bna-app input, #bna-app select { font:inherit; }
    #bna-app button { border:0; cursor:pointer; }

    /* ── شاشة تسجيل الدخول ── */
    #loginScreen {
      position:fixed; inset:0; background:var(--bina-page);
      display:flex; align-items:center; justify-content:center; z-index:9999;
    }
    #loginScreen.hidden { display:none; }
    .login-box {
      background:var(--bina-surface); border:1px solid var(--bina-line); border-radius:var(--bina-r-xl);
      box-shadow:var(--bina-shadow); padding:36px 32px; width:min(400px,92vw);
    }
    .login-box h2 { margin:0 0 6px; font-size:22px; font-weight:800; }
    .login-box p  { margin:0 0 24px; color:var(--bina-muted); font-size:13px; }
    .login-box label { display:flex; flex-direction:column; gap:6px; font-size:13px; font-weight:700; color:var(--bina-muted); margin-bottom:14px; }
    .login-box input { min-height:42px; border:1px solid var(--bina-line); border-radius:var(--bina-r-md); padding:8px 12px; font-size:14px; width:100%; }
    .login-box input:focus { outline:3px solid var(--bina-focus-ring); border-color:var(--bina-green); }
    .login-error { color:var(--bina-rose); font-size:13px; margin-bottom:12px; min-height:18px; }
    .login-footer { margin-top:16px; font-size:12px; color:var(--bina-muted); text-align:center; }

    /* ── هيدر ── */
    .app-header {
      display:flex; align-items:center; justify-content:space-between;
      gap:16px; padding:16px clamp(16px,4vw,40px);
      background:var(--bina-surface); border-bottom:1px solid var(--bina-line);
    }
    .app-header h1 { margin:0; font-size:clamp(18px,3vw,28px); font-weight:800; }
    .eyebrow { margin:0 0 3px; color:var(--bina-green-dark); font-size:11px; font-weight:700; }
    .header-actions { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
    .user-chip {
      font-size:12px; font-weight:700; color:var(--bina-green-dark);
      background:var(--bina-tint-green); border:1px solid #c8d8d1;
      border-radius:var(--bina-r-pill); padding:5px 12px;
    }

    /* ── تبويبات ── */
    .tabs-bar { display:flex; background:var(--bina-surface); border-bottom:2px solid var(--bina-line); padding:0 clamp(14px,3vw,32px); overflow-x:auto; }
    .tab-btn { padding:12px 20px; font-size:14px; font-weight:700; color:var(--bina-muted); background:none; border:none; border-bottom:3px solid transparent; margin-bottom:-2px; cursor:pointer; white-space:nowrap; transition:color .15s,border-color .15s; }
    .tab-btn:hover { color:var(--bina-green-dark); }
    .tab-btn.active { color:var(--bina-green-dark); border-bottom-color:var(--bina-green); }
    .tab-page { display:block; }
    .tab-page.hidden { display:none; }

    /* ── layout ── */
    .layout { width:min(1440px,100%); margin:0 auto; padding:20px clamp(14px,3vw,32px) 40px; }

    /* ── ملخص ── */
    .summary-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin-bottom:16px; }
    .metric { min-height:86px; padding:14px 16px; border-radius:var(--bina-r-lg); background:var(--bina-surface); border:1px solid var(--bina-line); box-shadow:var(--bina-shadow); }
    .metric span { display:block; color:var(--bina-muted); margin-bottom:5px; font-size:12px; }
    .metric strong { font-size:clamp(18px,2.5vw,28px); font-weight:800; }
    .metric-work    { border-top:4px solid var(--bina-green); }
    .metric-paid    { border-top:4px solid var(--bina-blue); }
    .metric-balance { border-top:4px solid var(--bina-amber); }
    .metric-count   { border-top:4px solid var(--bina-rose); }

    /* ── بانل ── */
    .panel { background:var(--bina-surface); border:1px solid var(--bina-line); border-radius:var(--bina-r-lg); box-shadow:var(--bina-shadow); padding:18px; margin-bottom:16px; }
    .panel-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px; }
    .panel-head h2 { margin:0; font-size:16px; font-weight:800; }

    /* ── هيدر النموذج ── */
    .work-header-grid { display:grid; grid-template-columns:repeat(4,minmax(120px,1fr)); gap:10px; padding:12px; background:var(--bina-tint-green-4); border:1px solid var(--bina-tint-green-5); border-radius:var(--bina-r-lg); margin-bottom:12px; }
    #bna-app label { display:flex; flex-direction:column; gap:5px; color:var(--bina-muted); font-size:13px; font-weight:700; }
    #bna-app input, #bna-app select { width:100%; min-height:40px; border:1px solid var(--bina-line); border-radius:var(--bina-r-md); padding:7px 10px; background:var(--bina-surface); color:var(--bina-ink); font-size:13px; }
    #bna-app input:focus, #bna-app select:focus { outline:3px solid var(--bina-focus-ring); border-color:var(--bina-green); }
    #bna-app input[readonly] { background:var(--bina-page); color:var(--bina-muted); }

    /* ── جدول صفوف القياسات ── */
    .rows-table-wrap { overflow-x:auto; border:1px solid var(--bina-line); border-radius:var(--bina-r-lg); margin-bottom:12px; }
    .rows-table { width:100%; min-width:900px; border-collapse:collapse; }
    .rows-table thead th { padding:9px 8px; background:var(--bina-tint-table); color:var(--bina-muted); font-size:12px; font-weight:700; text-align:right; border-bottom:1px solid var(--bina-line); white-space:nowrap; }
    .rows-table tbody tr:not(:last-child) td { border-bottom:1px solid var(--bina-line); }
    .rows-table td { padding:5px 5px; vertical-align:middle; }
    .rows-table td input, .rows-table td select { min-height:34px; padding:4px 7px; font-size:13px; }
    .rows-table td.check-cell { text-align:center; padding:2px 4px; width:40px; }
    .rows-table td.check-cell input[type="checkbox"],
    #bna-app .rows-table td.check-cell input[type="checkbox"] { width:16px !important; height:16px !important; min-height:16px !important; min-width:16px !important; accent-color:var(--bina-green); margin:0; padding:0; }
    .rows-table td.amount-cell { font-weight:800; color:var(--bina-green-dark); font-size:13px; white-space:nowrap; min-width:80px; }
    .row-del-btn { min-height:30px; padding:3px 10px; border-radius:var(--bina-r-sm); font-size:12px; font-weight:700; color:#fff; background:var(--bina-rose); }

    .work-footer { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
    .work-footer-total { font-size:15px; font-weight:700; color:var(--bina-green-dark); }
    .work-footer-total span { font-size:20px; }
    .work-footer-btns { display:flex; gap:8px; }

    /* ── أزرار ── */
    .btn-primary { min-height:40px; border-radius:var(--bina-r-md); padding:9px 18px; font-weight:800; color:#fff; background:var(--bina-green); }
    .btn-primary:hover { background:var(--bina-green-dark); }
    .btn-ghost { min-height:40px; border-radius:var(--bina-r-md); padding:9px 14px; font-weight:800; color:var(--bina-green-dark); background:var(--bina-tint-green); border:1px solid #c8d8d1; }
    .btn-danger { min-height:40px; border-radius:var(--bina-r-md); padding:9px 14px; font-weight:800; color:#fff; background:var(--bina-rose); }
    .btn-print { min-height:40px; border-radius:var(--bina-r-md); padding:9px 18px; font-weight:800; color:#fff; background:var(--bina-green-dark); }
    .btn-print:hover { background:var(--bina-green); }
    .btn-add-row { min-height:36px; border-radius:var(--bina-r-md); padding:7px 16px; font-weight:800; color:var(--bina-green-dark); background:var(--bina-tint-green-2); border:1px dashed var(--bina-green); width:100%; margin-bottom:10px; }
    .btn-add-row:hover { background:var(--bina-tint-green-3); }

    /* ── نموذج دفعة ── */
    .payment-form-grid { display:grid; grid-template-columns:repeat(5,minmax(110px,1fr)) auto; gap:10px; }

    /* ── تقارير ── */
    .report-filter-grid { display:grid; grid-template-columns:repeat(4,minmax(140px,1fr)); gap:10px; }
    .report-totals { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px; padding-top:12px; border-top:1px solid var(--bina-line); }
    .report-totals span { padding:7px 12px; border-radius:var(--bina-r-pill); background:var(--bina-tint-pill); white-space:nowrap; }
    .report-actions { display:flex; gap:8px; flex-wrap:wrap; }
    .report-tables { display:grid; grid-template-columns:minmax(0,1.4fr) minmax(320px,.8fr); gap:16px; }

    /* ── ملخص العمال ── */
    .workers-summary { margin-bottom:16px; }
    .workers-summary table { min-width:400px; }
    .bal-positive { color:var(--bina-rose); font-weight:800; }
    .bal-zero     { color:var(--bina-green-dark); font-weight:800; }

    /* ── جداول عامة ── */
    .table-card { background:var(--bina-surface); border:1px solid var(--bina-line); border-radius:var(--bina-r-lg); box-shadow:var(--bina-shadow); overflow:hidden; margin-bottom:16px; }
    .table-head { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid var(--bina-line); }
    .table-head h2 { margin:0; font-size:16px; font-weight:800; }
    .table-head span { color:var(--bina-muted); font-weight:700; font-size:13px; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; min-width:640px; border-collapse:collapse; }
    th,td { padding:9px 12px; border-bottom:1px solid var(--bina-line); text-align:right; vertical-align:middle; white-space:nowrap; }
    th { color:var(--bina-muted); background:var(--bina-tint-table); font-size:12px; font-weight:700; }
    th.sortable { cursor:pointer; user-select:none; }
    th.sortable:hover { color:var(--bina-ink); }
    th .sort-arrow { margin-right:4px; opacity:.4; }
    th.sort-asc .sort-arrow, th.sort-desc .sort-arrow { opacity:1; color:var(--bina-green-dark); }
    td { font-size:13px; }
    .amount { font-weight:800; color:var(--bina-green-dark); }
    .empty-state { text-align:center; color:var(--bina-muted); padding:24px 14px; }

    /* ── سجل الحركات ── */
    .activity-list { list-style:none; margin:0; padding:0; }
    .activity-item { display:flex; gap:12px; align-items:flex-start; padding:12px 16px; border-bottom:1px solid var(--bina-line); }
    .activity-item:last-child { border-bottom:none; }
    .activity-item:hover { background:var(--bina-tint-table); }
    .activity-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; margin-top:2px; }
    .activity-icon.work    { background:var(--bina-tint-green-2); color:var(--bina-green-dark); }
    .activity-icon.payment { background:var(--bina-tint-blue); color:var(--bina-blue); }
    .activity-body { flex:1; min-width:0; }
    .activity-title { font-weight:700; font-size:14px; margin-bottom:2px; }
    .activity-meta  { font-size:11px; color:var(--bina-muted); }
    .activity-amount { font-weight:800; font-size:14px; white-space:nowrap; align-self:center; }
    .activity-amount.work    { color:var(--bina-green-dark); }
    .activity-amount.payment { color:var(--bina-blue); }
    .activity-log-head { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid var(--bina-line); }
    .activity-log-head h2 { margin:0; font-size:16px; font-weight:800; }
    .badge { display:inline-flex; align-items:center; justify-content:center; min-width:20px; height:20px; border-radius:var(--bina-r-pill); background:var(--bina-green); color:#fff; font-size:11px; font-weight:800; padding:0 5px; margin-right:5px; }

    /* ── مودال ── */
    .modal-overlay { display:none; position:fixed; inset:0; background:var(--bina-scrim); z-index:1000; align-items:center; justify-content:center; }
    .modal-overlay.open { display:flex; }
    .modal { background:var(--bina-surface); border-radius:var(--bina-r-xl); box-shadow:var(--bina-shadow-modal); width:min(580px,94vw); max-height:85vh; display:flex; flex-direction:column; overflow:hidden; }
    .modal-header { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid var(--bina-line); }
    .modal-header h3 { margin:0; font-size:16px; font-weight:800; }
    .modal-close { width:30px; height:30px; border-radius:50%; background:#f0f0f0; font-size:18px; color:var(--bina-muted); display:flex; align-items:center; justify-content:center; }
    .modal-close:hover { background:#e0e0e0; }
    .modal-body { overflow-y:auto; padding:16px 20px; flex:1; }
    .modal-actions { display:flex; gap:8px; margin-bottom:14px; }
    .backup-list { list-style:none; margin:0; padding:0; }
    .backup-item { display:flex; align-items:center; justify-content:space-between; gap:10px; padding:10px 12px; border-radius:var(--bina-r-lg); border:1px solid var(--bina-line); margin-bottom:8px; }
    .backup-item:hover { background:var(--bina-tint-table); }
    .backup-info { flex:1; min-width:0; }
    .backup-time { font-weight:700; font-size:13px; }
    .backup-meta { font-size:11px; color:var(--bina-muted); margin-top:2px; }
    .backup-item-btns { display:flex; gap:6px; flex-shrink:0; }
    .btn-restore { min-height:30px; padding:4px 12px; border-radius:var(--bina-r-sm); font-size:12px; font-weight:700; color:#fff; background:var(--bina-green); }
    .btn-restore:hover { background:var(--bina-green-dark); }
    .btn-del-backup { min-height:30px; padding:4px 10px; border-radius:var(--bina-r-sm); font-size:12px; font-weight:700; color:var(--bina-muted); background:#f0f0f0; }
    .btn-del-backup:hover { background:#e0e0e0; }
    .empty-backups { text-align:center; color:var(--bina-muted); padding:26px 0; font-size:14px; }

    /* ── نسخ احتياطي ── */
    .backup-dot { width:7px; height:7px; border-radius:50%; background:#4caf50; display:inline-block; margin-left:5px; }

    /* ── responsive ── */
    @media (max-width:1100px) {
      .summary-grid { grid-template-columns:repeat(2,1fr); }
      .report-tables { grid-template-columns:1fr; }
      .work-header-grid { grid-template-columns:repeat(2,1fr); }
      .report-filter-grid { grid-template-columns:repeat(2,1fr); }
      .payment-form-grid { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:680px) {
      .app-header { flex-direction:column; align-items:stretch; }
      .summary-grid { grid-template-columns:repeat(2,1fr); }
      .work-header-grid,.payment-form-grid,.report-filter-grid { grid-template-columns:1fr; }
      .tab-btn { padding:10px 12px; font-size:13px; }
    }
  </style>
</head>
<body>

<!-- ══════════ شاشة تسجيل الدخول ══════════ -->
<div id="loginScreen">
  <div class="login-box">
    <h2>🔐 حساب عمل البناء</h2>
    <p id="loginSubtitle">أدخل بيانات الدخول للمتابعة</p>
    <div class="login-error" id="loginError"></div>
    <label>اسم المستخدم
      <input id="loginUser" type="text" autocomplete="username" placeholder="اسم المستخدم">
    </label>
    <label>كلمة المرور
      <input id="loginPass" type="password" autocomplete="current-password" placeholder="••••••••">
    </label>
    <button class="btn-primary" id="loginBtn" type="button" style="width:100%">دخول</button>
    <div class="login-footer" id="loginFooter"></div>
    <hr style="margin:16px 0; border-color:var(--line)">
    <button id="resetAuthBtn" type="button"
      style="background:none;border:none;color:#e57373;cursor:pointer;font-size:.85rem;text-decoration:underline;width:100%;text-align:center;">
      🔑 نسيت كلمة المرور؟
    </button>
    <div style="text-align:center;margin-top:12px;color:var(--bina-muted);font-size:11px;">الإصدار 5.4</div>
    <div id="resetChoices" style="display:none;margin-top:10px;gap:8px;flex-direction:column;">
      <button id="sendWhatsappBtn" type="button"
        style="min-height:38px;border-radius:7px;padding:8px 14px;font-weight:800;color:#fff;background:#25D366;border:none;cursor:pointer;font-size:13px;width:100%">
        💬 إرسال عبر واتساب
      </button>
      <button id="sendEmailBtn" type="button"
        style="min-height:38px;border-radius:7px;padding:8px 14px;font-weight:800;color:#fff;background:#2f6478;border:none;cursor:pointer;font-size:13px;width:100%">
        📧 إرسال عبر البريد الإلكتروني
      </button>
    </div>
  </div>
</div>

<!-- ══════════ التطبيق الرئيسي ══════════ -->
<div id="bna-app">
  <header class="app-header">
    <div>
      <p class="eyebrow">نظام الكيل والدفعات</p>
      <h1>حساب عمل البناء</h1>
    </div>
    <div class="header-actions">
      <span class="user-chip">👤 <span id="userLabel"></span></span>
      <span class="backup-dot" title="نسخ احتياطي نشط"></span>
      <button class="btn-ghost" id="backupBtn"    type="button">💾 النسخ الاحتياطية</button>
      <button class="btn-ghost"  id="settingsBtn" type="button">⚙️ الإعدادات</button>
      <button class="btn-danger" id="logoutBtn"   type="button">خروج</button>
    </div>
  </header>

  <nav class="tabs-bar">
    <button class="tab-btn active" data-tab="work"     type="button">تسجيل الأعمال</button>
    <button class="tab-btn"        data-tab="payment"  type="button">التسديدات</button>
    <button class="tab-btn"        data-tab="report"   type="button">التقارير</button>
    <button class="tab-btn"        data-tab="activity" type="button">سجل الحركات <span class="badge" id="activityBadge">0</span></button>
  </nav>

  <main class="layout">

    <!-- ══ تسجيل الأعمال ══ -->
    <div class="tab-page" id="tab-work">
      <section class="summary-grid">
        <article class="metric metric-work"><span>إجمالي الأعمال</span><strong id="totalDue">$0</strong></article>
        <article class="metric metric-paid"><span>إجمالي التسديد</span><strong id="totalPaid">$0</strong></article>
        <article class="metric metric-balance"><span>الباقي</span><strong id="totalBalance">$0</strong></article>
        <article class="metric metric-count"><span>عدد العمال</span><strong id="workerCount">0</strong></article>
      </section>

      <div class="panel">
        <div class="panel-head">
          <div><p class="eyebrow">إدخال يومي</p><h2>تسجيل عمل</h2></div>
        </div>
        <div class="work-header-grid">
          <label>اسم العامل
            <input id="workerName" autocomplete="off" list="workersList" placeholder="عامل 1">
          </label>
          <label>نوع العمل
            <input id="workName" autocomplete="off" list="worksList" placeholder="بلاط، حجر، صبغ">
          </label>
          <label>التاريخ
            <input id="workDate" type="date">
          </label>
          <label>الوقت
            <input id="workTime" type="time">
          </label>
          <label>المُدخِل
            <input id="enteredByDisplay" type="text" readonly style="background:#f5f7f3;color:var(--muted)">
          </label>
        </div>

        <div class="rows-table-wrap">
          <table class="rows-table">
            <thead>
              <tr>
                <th>#</th><th>الوصف</th><th>الطول</th><th>العرض</th>
                <th>طول الفراغ</th><th>عرض الفراغ</th>
                <th>فراغ ÷2</th><th>مضاعفة</th>
                <th>الوحدة</th><th>سعر المتر</th>
                <th>ملاحظة</th><th>المبلغ</th><th></th>
              </tr>
            </thead>
            <tbody id="workRowsBody"></tbody>
          </table>
        </div>

        <button class="btn-add-row" id="addRowBtn" type="button">+ إضافة صف قياس</button>

        <div class="work-footer">
          <div class="work-footer-total">إجمالي الأمتار: <span id="rowsMeters">0</span> &nbsp;|&nbsp; الإجمالي: <span id="rowsTotal">$0</span></div>
          <div class="work-footer-btns">
            <button class="btn-ghost"   id="clearRowsBtn" type="button">مسح الصفوف</button>
            <button class="btn-primary" id="saveWorkBtn"  type="button">حفظ الأعمال</button>
          </div>
        </div>
      </div>

      <div class="table-card">
        <div class="table-head"><h2>الأعمال المسجلة</h2><span id="workRowsCount">0 سجل</span></div>
        <div class="table-wrap">
          <table id="workTable">
            <thead>
              <tr>
                <th class="sortable" data-col="date"      data-tbl="work">التاريخ <span class="sort-arrow">↕</span></th>
                <th class="sortable" data-col="worker"    data-tbl="work">العامل <span class="sort-arrow">↕</span></th>
                <th>العمل</th>
                <th class="sortable" data-col="net"       data-tbl="work">الكمية <span class="sort-arrow">↕</span></th>
                <th>السعر</th>
                <th class="sortable" data-col="amount"    data-tbl="work">المبلغ <span class="sort-arrow">↕</span></th>
                <th>ملاحظة</th><th></th>
              </tr>
            </thead>
            <tbody id="workTableBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ══ التسديدات ══ -->
    <div class="tab-page hidden" id="tab-payment">
      <section class="summary-grid">
        <article class="metric metric-work"><span>إجمالي الأعمال</span><strong id="totalDue2">$0</strong></article>
        <article class="metric metric-paid"><span>إجمالي التسديد</span><strong id="totalPaid2">$0</strong></article>
        <article class="metric metric-balance"><span>الباقي</span><strong id="totalBalance2">$0</strong></article>
        <article class="metric metric-count"><span>عدد العمال</span><strong id="workerCount2">0</strong></article>
      </section>

      <div class="panel">
        <div class="panel-head"><div><p class="eyebrow">تسديدات</p><h2>إضافة دفعة</h2></div></div>
        <form id="paymentForm" class="payment-form-grid">
          <label>اسم العامل
            <input id="paymentWorker" required list="workersList" autocomplete="off">
          </label>
          <label>التاريخ
            <input id="paymentDate" type="date" required>
          </label>
          <label>الوقت
            <input id="paymentTime" type="time" required>
          </label>
          <label>مبلغ الدفعة ($)
            <input id="paymentAmount" type="number" min="0.01" step="0.01" required>
          </label>
          <label>ملاحظة
            <input id="paymentNote" autocomplete="off" placeholder="اختياري">
          </label>
          <label style="justify-content:flex-end">
            <button class="btn-primary" type="submit" style="align-self:end">إضافة الدفعة</button>
          </label>
        </form>
      </div>

      <div class="table-card">
        <div class="table-head"><h2>الدفعات</h2><span id="paymentRowsCount">0 دفعة</span></div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th class="sortable" data-col="date"   data-tbl="pay">التاريخ <span class="sort-arrow">↕</span></th>
                <th class="sortable" data-col="worker" data-tbl="pay">العامل <span class="sort-arrow">↕</span></th>
                <th class="sortable" data-col="amount" data-tbl="pay">المبلغ <span class="sort-arrow">↕</span></th>
                <th>ملاحظة</th><th></th>
              </tr>
            </thead>
            <tbody id="paymentTableBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ══ التقارير ══ -->
    <div class="tab-page hidden" id="tab-report">
      <div class="panel">
        <div class="panel-head">
          <div><p class="eyebrow">تقارير وكشف حساب</p><h2>بحث وطباعة</h2></div>
          <div class="report-actions">
            <button class="btn-ghost"  id="resetFiltersBtn"      type="button">إعادة التصفية</button>
            <button class="btn-print"  id="printWorksBtn"        type="button">🔨 كشف الأعمال</button>
            <button class="btn-print"  id="printPaymentsBtn"     type="button">💵 كشف الدفعات</button>
            <button class="btn-print"  id="printStatementBtn"    type="button">📄 كشف الحساب</button>
          </div>
        </div>
        <div class="report-filter-grid">
          <label>اسم العامل
            <input id="filterWorker" list="workersList" autocomplete="off" placeholder="كل العمال">
          </label>
          <label>نوع العمل
            <input id="filterWork" list="worksList" autocomplete="off" placeholder="كل الأعمال">
          </label>
          <label>من تاريخ<input id="fromDate" type="date"></label>
          <label>إلى تاريخ<input id="toDate"   type="date"></label>
        </div>
        <div class="report-totals">
          <span>الأعمال: <b id="reportDue">$0</b></span>
          <span>الدفعات: <b id="reportPaid">$0</b></span>
          <span>المتبقي: <b id="reportBalance">$0</b></span>
        </div>
      </div>

      <!-- ملخص رصيد العمال -->
      <div class="table-card workers-summary">
        <div class="table-head"><h2>رصيد العمال</h2></div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th class="sortable" data-col="worker" data-tbl="workers">العامل <span class="sort-arrow">↕</span></th>
                <th class="sortable" data-col="due"    data-tbl="workers">إجمالي الأعمال <span class="sort-arrow">↕</span></th>
                <th class="sortable" data-col="paid"   data-tbl="workers">إجمالي السداد <span class="sort-arrow">↕</span></th>
                <th class="sortable" data-col="bal"    data-tbl="workers">الرصيد <span class="sort-arrow">↕</span></th>
              </tr>
            </thead>
            <tbody id="workersSummaryBody"></tbody>
          </table>
        </div>
      </div>

      <div class="report-tables">
        <div class="table-card">
          <div class="table-head"><h2>الأعمال</h2><span id="reportWorkCount">0 سجل</span></div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>التاريخ</th><th>العامل</th><th>العمل</th>
                  <th>الكمية</th><th>ملاحظة</th>
                </tr>
              </thead>
              <tbody id="reportWorkBody"></tbody>
            </table>
          </div>
        </div>
        <div class="table-card">
          <div class="table-head"><h2>الدفعات</h2><span id="reportPaymentCount">0 دفعة</span></div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr><th>التاريخ</th><th>العامل</th><th>المبلغ</th><th>ملاحظة</th></tr>
              </thead>
              <tbody id="reportPaymentBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ══ سجل الحركات ══ -->
    <div class="tab-page hidden" id="tab-activity">
      <div class="table-card">
        <div class="activity-log-head">
          <h2>سجل الحركات</h2>
          <button class="btn-ghost" id="clearActivityBtn" type="button">مسح السجل</button>
        </div>
        <ul class="activity-list" id="activityLogBody">
          <li class="empty-state">لا توجد حركات مسجلة بعد</li>
        </ul>
      </div>
    </div>

  </main>
</div>

<datalist id="workersList"></datalist>
<datalist id="worksList"></datalist>

<!-- مودال الإعدادات -->
<div class="modal-overlay" id="settingsModal">
  <div class="modal">
    <div class="modal-header">
      <h3>⚙️ إعدادات الحساب</h3>
      <button class="modal-close" id="settingsModalClose" type="button">×</button>
    </div>
    <div class="modal-body">
      <div id="settingsError"   style="color:var(--rose);font-size:13px;min-height:18px;margin-bottom:6px"></div>
      <div id="settingsSuccess" style="color:var(--green-dark);font-size:13px;min-height:18px;margin-bottom:10px"></div>

      <p style="font-size:12px;color:var(--muted);margin:0 0 10px;font-weight:700">تغيير كلمة المرور</p>
      <label style="margin-bottom:12px">كلمة المرور الحالية
        <input id="settingsCurPass" type="password" autocomplete="current-password" placeholder="••••••••">
      </label>
      <label style="margin-bottom:12px">كلمة المرور الجديدة
        <input id="settingsNewPass" type="password" autocomplete="new-password" placeholder="••••••••">
      </label>
      <label style="margin-bottom:14px">تأكيد كلمة المرور الجديدة
        <input id="settingsConfPass" type="password" autocomplete="new-password" placeholder="••••••••">
      </label>
      <button class="btn-primary" id="settingsSaveBtn" type="button" style="width:100%">حفظ كلمة المرور</button>

      <hr style="margin:16px 0;border-color:var(--line)">
      <p style="font-size:12px;color:var(--muted);margin:0 0 10px;font-weight:700">بيانات التواصل (للاسترداد)</p>
      <label style="margin-bottom:12px">رقم الواتساب
        <input id="settingsWhatsapp" type="tel" autocomplete="off" placeholder="009647807385535">
      </label>
      <label style="margin-bottom:12px">البريد الإلكتروني
        <input id="settingsEmail" type="email" autocomplete="off" placeholder="example@gmail.com">
      </label>
      <button class="btn-ghost" id="settingsContactSaveBtn" type="button" style="width:100%">حفظ بيانات التواصل</button>

      <!-- إدارة المستخدمين — للمدير فقط -->
      <div id="adminUsersSection" style="display:none">
        <hr style="margin:16px 0;border-color:var(--line)">
        <p style="font-size:12px;color:var(--muted);margin:0 0 10px;font-weight:700">👑 إدارة المستخدمين</p>
        <ul id="usersList" style="list-style:none;margin:0 0 14px;padding:0"></ul>
        <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:8px;align-items:end;margin-bottom:8px">
          <label style="margin:0">اسم المستخدم<input id="newUserName" type="text" autocomplete="off" placeholder="اسم المستخدم"></label>
          <label style="margin:0">كلمة المرور<input id="newUserPass" type="password" placeholder="••••••••"></label>
          <button class="btn-primary" id="addUserBtn" type="button" style="align-self:end;min-height:40px">إضافة</button>
        </div>
        <label style="flex-direction:row;align-items:center;gap:8px;margin-bottom:4px">
          <input type="checkbox" id="newUserIsAdmin" style="width:auto;min-height:auto;accent-color:var(--green)"> صلاحية مدير
        </label>
      </div>
    </div>
  </div>
</div>

<!-- مودال النسخ الاحتياطية -->
<div class="modal-overlay" id="backupModal">
  <div class="modal">
    <div class="modal-header">
      <h3>💾 النسخ الاحتياطية</h3>
      <button class="modal-close" id="backupModalClose" type="button">×</button>
    </div>
    <div class="modal-body">
      <p style="font-size:13px;color:var(--muted);margin:0 0 12px">نسخة تلقائية بعد كل عملية </p>
      <div class="modal-actions">
        <button class="btn-ghost"  id="exportJsonBtn"        type="button">📤 تصدير JSON</button>
        <label  class="btn-ghost"  style="cursor:pointer;margin:0">
          📥 استيراد JSON
          <input id="importJsonInput" type="file" accept=".json" style="display:none">
        </label>
      </div>
      <button class="btn-danger" id="clearDataBtn" type="button" style="width:100%;margin-top:8px">مسح كل الأعمال والدفعات وسجل الحركات</button>
      <ul class="backup-list" id="backupList"></ul>
    </div>
  </div>
</div>

<script src="data.js"></script>
<script>

let currentUser = null;
let currentRole = null;

async function initAuth() {
  migrateOldAuth();
  const sub  = document.getElementById("loginSubtitle");
  const foot = document.getElementById("loginFooter");
  const err  = document.getElementById("loginError");
  err.textContent = "";

  const liveSession = await getServerSession();
  if (liveSession && liveSession.ok && liveSession.user) {
    enterApp(liveSession.user, liveSession.role || "user");
    return;
  }

  const hasUsers = await getAuthStatus();
  if (!hasUsers) {
    sub.textContent  = "أول مرة؟ أنشئ حساب المدير";
    foot.textContent = "أول حساب يُنشأ يكون مديراً تلقائياً";
  } else {
    sub.textContent  = "أدخل بيانات الدخول للمتابعة";
    foot.textContent = "استرداد كلمة المرور يتم عبر المدير أو قاعدة البيانات";
  }

  document.getElementById("loginBtn").onclick = doLogin;
  document.getElementById("loginPass").addEventListener("keydown", (e) => { if (e.key === "Enter") doLogin(); });
  document.getElementById("resetAuthBtn").onclick = function() {
    alert("لأسباب أمنية لا يمكن عرض كلمات المرور. تواصل مع المدير لإعادة تعيين كلمة المرور.");
  };
}

async function doLogin() {
  const u = document.getElementById("loginUser").value.trim();
  const p = document.getElementById("loginPass").value;
  const err = document.getElementById("loginError");
  if (!u || !p) { err.textContent = "أدخل اسم المستخدم وكلمة المرور"; return; }
  err.textContent = "";

  const hasUsers = await getAuthStatus();
  let res = null;
  if (!hasUsers) {
    res = await bootstrapAdmin(u, p);
  } else {
    res = await loginUser(u, p);
  }

  if (res && res.ok && res.user) {
    await syncUsers();
    enterApp(res.user, res.role || "user");
  } else {
    err.textContent = "اسم المستخدم أو كلمة المرور غير صحيحة";
    document.getElementById("loginPass").value = "";
  }
}

function enterApp(u, role) {
  currentUser = u;
  currentRole = role === "admin" ? "admin" : (isAdmin(u) ? "admin" : "user");
  sessionStorage.setItem(SESSION_KEY, JSON.stringify({ user: u }));
  document.getElementById("userLabel").textContent = u + (currentRole === "admin" ? " 👑" : "");
  document.getElementById("loginScreen").classList.add("hidden");
  initApp();
  if (els.enteredByDisplay) els.enteredByDisplay.value = currentUser;
}

function doLogout() {
  logoutUser();
  currentUser = null;
  currentRole = null;
  sessionStorage.removeItem(SESSION_KEY);
  document.getElementById("loginScreen").classList.remove("hidden");
  document.getElementById("loginUser").value = "";
  document.getElementById("loginPass").value = "";
  document.getElementById("loginError").textContent = "";
}

let state;
let workRows   = [];
const els      = {};
const sortState = { work:{ col:"date", dir:-1 }, pay:{ col:"date", dir:-1 }, workers:{ col:"worker", dir:1 } };

// loadState, persist, syncState → data.js

// ── تهيئة التطبيق ─────────────────────────────────────────
function initApp() {
  state    = loadState();
  workRows = [newRow()];
  bindEls();
  initDefaults();
  bindEvents();
  renderWorkRowsTable();
  render();
  // مزامنة مع السيرفر
  syncState();
  if (currentRole === "admin") syncUsers();
  syncContact();
}

function bindEls() {
  [
    "workerName","workName","workDate","workTime",
    "paymentForm","paymentWorker","paymentDate","paymentTime","paymentAmount","paymentNote",
    "addRowBtn","clearRowsBtn","saveWorkBtn","workRowsBody","rowsTotal","rowsMeters",
    "totalDue","totalPaid","totalBalance","workerCount",
    "totalDue2","totalPaid2","totalBalance2","workerCount2",
    "workTableBody","workRowsCount",
    "paymentTableBody","paymentRowsCount",
    "workersSummaryBody",
    "filterWorker","filterWork","fromDate","toDate",
    "reportDue","reportPaid","reportBalance",
    "reportWorkBody","reportPaymentBody",
    "reportWorkCount","reportPaymentCount",
    "activityLogBody","activityBadge","clearActivityBtn",
    "backupBtn","backupModalClose","backupList","exportJsonBtn","importJsonInput",
    "workersList","worksList",
    "resetFiltersBtn","printStatementBtn","printWorksBtn","printPaymentsBtn",
    "logoutBtn",
    "settingsBtn","settingsModalClose","settingsSaveBtn","settingsContactSaveBtn",
    "settingsCurPass","settingsNewPass","settingsConfPass",
    "settingsError","settingsSuccess",
    "settingsWhatsapp","settingsEmail",
    "adminUsersSection","usersList","newUserName","newUserPass","newUserIsAdmin","addUserBtn",
    "enteredByDisplay"
  ].forEach((id) => { els[id] = document.getElementById(id); });
}

function nowDT() {
  const n = new Date();
  const y = n.getFullYear();
  const m = String(n.getMonth()+1).padStart(2,"0");
  const d = String(n.getDate()).padStart(2,"0");
  return { date: `${y}-${m}-${d}`, time: n.toTimeString().slice(0,5) };
}

function initDefaults() {
  const { date, time } = nowDT();
  els.workDate.value = date;  els.workTime.value = time;
  els.paymentDate.value = date; els.paymentTime.value = time;
}

// ── أحداث ─────────────────────────────────────────────────
function bindEvents() {
  document.querySelectorAll(".tab-btn").forEach((b) =>
    b.addEventListener("click", () => switchTab(b.dataset.tab))
  );

  // تحديث الوقت عند اختيار اسم العامل
  els.workerName.addEventListener("change", () => {
    const { date, time } = nowDT();
    els.workDate.value = date; els.workTime.value = time;
  });
  els.paymentWorker.addEventListener("change", () => {
    const { date, time } = nowDT();
    els.paymentDate.value = date; els.paymentTime.value = time;
  });

  els.addRowBtn.addEventListener("click",   () => { workRows.push(newRow()); renderWorkRowsTable(); });
  els.clearRowsBtn.addEventListener("click",() => { workRows = [newRow()];   renderWorkRowsTable(); });
  els.saveWorkBtn.addEventListener("click", saveWork);
  els.paymentForm.addEventListener("submit", addPayment);

  document.getElementById("tab-report").addEventListener("input",  render);
  document.getElementById("tab-report").addEventListener("change", render);
  els.resetFiltersBtn.addEventListener("click", resetFilters);

  // حذف عمل
  els.workTableBody.addEventListener("click", (e) => {
    const b = e.target.closest("[data-del-work]");
    if (!b || !confirm("حذف هذا السجل؟")) return;
    const job = state.jobs.find((j) => j.id === b.dataset.delWork);
    if (job) logActivity("delete", job.worker, `حذف عمل: ${job.work}`, 0);
    state.jobs = state.jobs.filter((j) => j.id !== b.dataset.delWork);
    persist(); render();
  });

  // حذف دفعة
  els.paymentTableBody.addEventListener("click", (e) => {
    const b = e.target.closest("[data-del-pay]");
    if (!b || !confirm("حذف هذه الدفعة؟")) return;
    const pay = state.payments.find((p) => p.id === b.dataset.delPay);
    if (pay) logActivity("delete", pay.worker, `حذف دفعة`, pay.amount);
    state.payments = state.payments.filter((p) => p.id !== b.dataset.delPay);
    persist(); render();
  });

  // ترتيب الجداول
  document.querySelectorAll("th.sortable").forEach((th) =>
    th.addEventListener("click", () => handleSort(th))
  );

  // سجل الحركات
  els.clearActivityBtn.addEventListener("click", () => {
    if (!confirm("مسح كل سجل الحركات؟")) return;
    state.activityLog = []; persist(); renderActivityLog();
  });

  // النسخ الاحتياطية
  els.backupBtn.addEventListener("click", openBackupModal);
  els.backupModalClose.addEventListener("click", closeBackupModal);
  document.getElementById("backupModal").addEventListener("click", (e) => { if (e.target === e.currentTarget) closeBackupModal(); });
  els.exportJsonBtn.addEventListener("click", exportJson);
  els.importJsonInput.addEventListener("change", importJson);

  els.printWorksBtn.addEventListener("click", printWorksStatement);
  els.printPaymentsBtn.addEventListener("click", printPaymentsStatement);
  els.printStatementBtn.addEventListener("click", printStatement);
  els.logoutBtn.addEventListener("click", doLogout);

  els.settingsBtn.addEventListener("click", openSettingsModal);
  els.settingsModalClose.addEventListener("click", closeSettingsModal);
  document.getElementById("settingsModal").addEventListener("click", (e) => { if (e.target === e.currentTarget) closeSettingsModal(); });
  els.settingsSaveBtn.addEventListener("click", saveSettings);
  els.settingsContactSaveBtn.addEventListener("click", saveContactSettings);
  els.addUserBtn.addEventListener("click", handleAddUser);
  els.usersList.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-action][data-user]");
    if (!btn) return;
    const action = btn.dataset.action;
    const user = btn.dataset.user || "";
    if (action === "reset-pass") promptChangePass(user);
    if (action === "delete-user") confirmDeleteUser(user);
  });

  document.getElementById("clearDataBtn") && (document.getElementById("clearDataBtn").onclick = clearData);
}

function switchTab(name) {
  document.querySelectorAll(".tab-btn").forEach((b) => b.classList.toggle("active", b.dataset.tab === name));
  document.querySelectorAll(".tab-page").forEach((p) => p.classList.toggle("hidden", p.id !== `tab-${name}`));
}

// ── صفوف القياسات ─────────────────────────────────────────
function newRow() {
  return { id:uid(), desc:"", length:"", width:"", voidLength:"0", voidWidth:"0", halfVoid:false, doubleWork:false, unitType:"مربع", unitPrice:"", note:"" };
}

function renderWorkRowsTable() {
  els.workRowsBody.innerHTML = workRows.map((row, i) => `
    <tr>
      <td style="color:var(--muted);font-size:12px;padding:5px 8px">${i+1}</td>
      <td><input type="text" placeholder="وصف" value="${escHtml(row.desc||"")}" data-field="desc" data-row="${row.id}" style="min-width:90px"></td>
      <td><input type="number" min="0" step="0.01" placeholder="0" value="${row.length}"      data-field="length"     data-row="${row.id}" style="width:9ch"></td>
      <td><input type="number" min="0" step="0.01" placeholder="0" value="${row.width}"       data-field="width"      data-row="${row.id}" style="width:9ch"></td>
      <td><input type="number" min="0" step="0.01" placeholder="0" value="${row.voidLength}"  data-field="voidLength" data-row="${row.id}" style="width:9ch"></td>
      <td><input type="number" min="0" step="0.01" placeholder="0" value="${row.voidWidth}"   data-field="voidWidth"  data-row="${row.id}" style="width:9ch"></td>
      <td class="check-cell"><input type="checkbox" data-field="halfVoid"   data-row="${row.id}" ${row.halfVoid  ?"checked":""}></td>
      <td class="check-cell"><input type="checkbox" data-field="doubleWork" data-row="${row.id}" ${row.doubleWork?"checked":""}></td>
      <td><select data-field="unitType" data-row="${row.id}" style="min-height:34px;padding:3px 7px">
            <option value="مربع" ${row.unitType==="مربع"?"selected":""}>مربع</option>
            <option value="جر"   ${row.unitType==="جر"  ?"selected":""}>جر</option>
          </select></td>
      <td><input type="number" min="0" step="0.01" placeholder="0" value="${row.unitPrice}"   data-field="unitPrice"  data-row="${row.id}" style="width:9ch"></td>
      <td><input type="text"   placeholder="اختياري"               value="${escHtml(row.note)}" data-field="note"    data-row="${row.id}" style="min-width:85px"></td>
      <td class="amount-cell" id="row-amt-${row.id}">${calcRowAmt(row)}</td>
      <td>${workRows.length>1?`<button class="row-del-btn" data-del-row="${row.id}">×</button>`:""}</td>
    </tr>`).join("");

  updateRowsTotal();

  els.workRowsBody.querySelectorAll("input,select").forEach((el) => el.addEventListener("input", onRowInput));
  els.workRowsBody.querySelectorAll("[data-del-row]").forEach((b) =>
    b.addEventListener("click", () => { workRows = workRows.filter((r) => r.id !== b.dataset.delRow); renderWorkRowsTable(); })
  );
}

function onRowInput(e) {
  const { field, row: rowId } = e.target.dataset;
  const row = workRows.find((r) => r.id === rowId);
  if (!row) return;
  row[field] = e.target.type === "checkbox" ? e.target.checked : e.target.value;
  const amtEl = document.getElementById(`row-amt-${rowId}`);
  if (amtEl) amtEl.textContent = calcRowAmt(row);
  updateRowsTotal();
}

function calcRowAmt(row) {
  const base  = toNum(row.length) * toNum(row.width);
  const vArea = (toNum(row.voidLength) * toNum(row.voidWidth)) / (row.halfVoid ? 2 : 1);
  const net   = Math.max(0, base - vArea) * (row.doubleWork ? 2 : 1);
  return fmtCur(net * toNum(row.unitPrice));
}

function updateRowsTotal() {
  let total = 0, meters = 0;
  workRows.forEach((row) => {
    const base  = toNum(row.length) * toNum(row.width);
    const vArea = (toNum(row.voidLength) * toNum(row.voidWidth)) / (row.halfVoid ? 2 : 1);
    const net   = Math.max(0, base - vArea) * (row.doubleWork ? 2 : 1);
    meters += net;
    total  += net * toNum(row.unitPrice);
  });
  els.rowsTotal.textContent  = fmtCur(total);
  els.rowsMeters.textContent = fmtNum(meters);
}

// ── حفظ الأعمال ──────────────────────────────────────────
function saveWork() {
  const worker = els.workerName.value.trim();
  const work   = els.workName.value.trim();
  const date   = els.workDate.value;
  const time   = els.workTime.value;
  if (!worker || !work || !date) { alert("يرجى تعبئة: اسم العامل، نوع العمل، التاريخ"); return; }
  const valid = workRows.filter((r) => toNum(r.length)>0 && toNum(r.width)>0 && toNum(r.unitPrice)>0);
  if (!valid.length) { alert("أدخل قياسات صف واحد على الأقل (الطول، العرض، سعر المتر)"); return; }

  let total = 0;
  valid.forEach((row) => {
    const base  = toNum(row.length) * toNum(row.width);
    const vArea = (toNum(row.voidLength) * toNum(row.voidWidth)) / (row.halfVoid ? 2 : 1);
    const net   = Math.max(0, base - vArea) * (row.doubleWork ? 2 : 1);
    const amt   = net * toNum(row.unitPrice);
    total += amt;
    state.jobs.push({ id:uid(), worker, work, date, time, unitType:row.unitType||"مربع", unitPrice:toNum(row.unitPrice), length:toNum(row.length), width:toNum(row.width), voidLength:toNum(row.voidLength), voidWidth:toNum(row.voidWidth), halfVoid:row.halfVoid, doubleWork:row.doubleWork, note:row.note||"", enteredBy:currentUser });
  });

  persist();
  createBackup("work");
  logActivity("work", worker, `${valid.length} صف — ${work}`, total);
  workRows = [newRow()];
  renderWorkRowsTable();
  render();
}

// ── دفعة ──────────────────────────────────────────────────
function addPayment(e) {
  e.preventDefault();
  const worker = els.paymentWorker.value.trim();
  const amount = toNum(els.paymentAmount.value);
  if (!worker) { alert("يرجى إدخال اسم العامل"); return; }
  if (!Number.isFinite(amount) || amount <= 0) { alert("يرجى إدخال مبلغ دفعة صحيح أكبر من صفر"); return; }
  state.payments.push({ id:uid(), worker, date:els.paymentDate.value, time:els.paymentTime.value, amount, note:els.paymentNote.value.trim(), enteredBy:currentUser });
  persist();
  createBackup("payment");
  logActivity("payment", worker, "دفعة مالية", amount);
  els.paymentForm.reset();
  const { date, time } = nowDT();
  els.paymentDate.value = date; els.paymentTime.value = time;
  render();
}

// ── حسابات ────────────────────────────────────────────────
function calcJob(job) {
  const base  = job.length * job.width;
  const vArea = (job.voidLength * job.voidWidth) / (job.halfVoid ? 2 : 1);
  const net   = Math.max(0, base - vArea) * (job.doubleWork ? 2 : 1);
  return { vArea, net, amount: net * job.unitPrice };
}

// ── رندر ──────────────────────────────────────────────────
function render() {
  renderLists();
  renderSummary();
  renderJobsTable();
  renderPaymentsTable();
  renderWorkersSummary();
  const f    = getFilters();
  const jobs = filterJobs(state.jobs, f);
  const pays = filterPayments(state.payments, f);
  renderReportTotals(jobs, pays);
  renderReportTables(jobs, pays);
  renderActivityLog();
}

function renderLists() {
  const workers = uniq([...state.jobs.map((j)=>j.worker), ...state.payments.map((p)=>p.worker)]);
  const works   = uniq(state.jobs.map((j)=>j.work));
  els.workersList.innerHTML = workers.map((w)=>`<option value="${escHtml(w)}"></option>`).join("");
  els.worksList.innerHTML   = works.map((w)=>`<option value="${escHtml(w)}"></option>`).join("");
}

function renderSummary() {
  const due     = sumArr(state.jobs,     (j)=>calcJob(j).amount);
  const paid    = sumArr(state.payments, (p)=>p.amount);
  const workers = uniq([...state.jobs.map((j)=>j.worker), ...state.payments.map((p)=>p.worker)]);
  [[els.totalDue,els.totalDue2],[els.totalPaid,els.totalPaid2],[els.totalBalance,els.totalBalance2],[els.workerCount,els.workerCount2]]
    .forEach(([a,b],i)=>{ const v=[fmtCur(due),fmtCur(paid),fmtCur(due-paid),workers.length][i]; a.textContent=b.textContent=v; });
}

function sortedJobs() {
  const { col, dir } = sortState.work;
  return state.jobs.slice().sort((a, b) => {
    const va = col==="amount" ? calcJob(a).amount : col==="net" ? calcJob(a).net : (a[col]||"");
    const vb = col==="amount" ? calcJob(b).amount : col==="net" ? calcJob(b).net : (b[col]||"");
    return (va > vb ? 1 : va < vb ? -1 : 0) * dir;
  });
}

function sortedPayments() {
  const { col, dir } = sortState.pay;
  return state.payments.slice().sort((a, b) => {
    const va = a[col]||"", vb = b[col]||"";
    return (va > vb ? 1 : va < vb ? -1 : 0) * dir;
  });
}

function renderJobsTable() {
  els.workRowsCount.textContent = `${state.jobs.length} سجل`;
  els.workTableBody.innerHTML = sortedJobs().length
    ? sortedJobs().map((j) => {
        const c = calcJob(j);
        return `<tr>
          <td>${fmtDate(j.date)}${j.time?` <small style="color:var(--muted)">${j.time}</small>`:""}</td>
          <td>${escHtml(j.worker)}</td>
          <td>${escHtml(j.work)} / ${escHtml(j.unitType)}</td>
          <td>${fmtNum(c.net)}</td>
          <td>${fmtCur(j.unitPrice)}</td>
          <td class="amount">${fmtCur(c.amount)}</td>
          <td>${escHtml(j.note||"-")}</td>
          <td><button class="row-del-btn" data-del-work="${j.id}">حذف</button></td>
        </tr>`;
      }).join("")
    : `<tr><td colspan="8" class="empty-state">لا توجد أعمال</td></tr>`;
}

function renderPaymentsTable() {
  els.paymentRowsCount.textContent = `${state.payments.length} دفعة`;
  els.paymentTableBody.innerHTML = sortedPayments().length
    ? sortedPayments().map((p) => `
        <tr>
          <td>${fmtDate(p.date)}${p.time?` <small style="color:var(--muted)">${p.time}</small>`:""}</td>
          <td>${escHtml(p.worker)}</td>
          <td class="amount">${fmtCur(p.amount)}</td>
          <td>${escHtml(p.note||"-")}</td>
          <td><button class="row-del-btn" data-del-pay="${p.id}">حذف</button></td>
        </tr>`).join("")
    : `<tr><td colspan="5" class="empty-state">لا توجد دفعات</td></tr>`;
}

function renderWorkersSummary() {
  const { col, dir } = sortState.workers;
  const workers = uniq([...state.jobs.map((j)=>j.worker), ...state.payments.map((p)=>p.worker)]);
  let rows = workers.map((w) => {
    const due  = sumArr(state.jobs.filter((j)=>j.worker===w), (j)=>calcJob(j).amount);
    const paid = sumArr(state.payments.filter((p)=>p.worker===w), (p)=>p.amount);
    return { worker:w, due, paid, bal:due-paid };
  });
  rows.sort((a,b)=>(a[col]>b[col]?1:a[col]<b[col]?-1:0)*dir);
  els.workersSummaryBody.innerHTML = rows.length
    ? rows.map((r)=>`<tr>
        <td><b>${escHtml(r.worker)}</b></td>
        <td class="amount">${fmtCur(r.due)}</td>
        <td style="color:var(--blue);font-weight:800">${fmtCur(r.paid)}</td>
        <td class="${r.bal>0?"bal-positive":"bal-zero"}">${fmtCur(r.bal)}</td>
      </tr>`).join("")
    : `<tr><td colspan="4" class="empty-state">لا توجد بيانات</td></tr>`;
}

function renderReportTotals(jobs, pays) {
  const due = sumArr(jobs,(j)=>calcJob(j).amount), paid = sumArr(pays,(p)=>p.amount);
  els.reportDue.textContent=fmtCur(due); els.reportPaid.textContent=fmtCur(paid); els.reportBalance.textContent=fmtCur(due-paid);
}

function renderReportTables(jobs, pays) {
  els.reportWorkCount.textContent    = `${jobs.length} سجل`;
  els.reportPaymentCount.textContent = `${pays.length} دفعة`;
  els.reportWorkBody.innerHTML = jobs.length
    ? jobs.slice().sort(byDateDesc).map((j)=>{ const c=calcJob(j); return `<tr><td>${fmtDate(j.date)}</td><td>${escHtml(j.worker)}</td><td>${escHtml(j.work)} / ${escHtml(j.unitType)}</td><td>${fmtNum(c.net)}</td><td>${escHtml(j.note||"-")}</td></tr>`; }).join("")
    : `<tr><td colspan="5" class="empty-state">لا توجد أعمال ضمن التصفية</td></tr>`;
  els.reportPaymentBody.innerHTML = pays.length
    ? pays.slice().sort(byDateDesc).map((p)=>`<tr><td>${fmtDate(p.date)}</td><td>${escHtml(p.worker)}</td><td class="amount">${fmtCur(p.amount)}</td><td>${escHtml(p.note||"-")}</td></tr>`).join("")
    : `<tr><td colspan="4" class="empty-state">لا توجد دفعات ضمن التصفية</td></tr>`;
}

// ── سجل الحركات ──────────────────────────────────────────
function logActivity(type, worker, detail, amount) {
  state.activityLog.unshift({ id:uid(), type, worker, detail, amount, ts:new Date().toISOString(), enteredBy:currentUser });
  if (state.activityLog.length > 500) state.activityLog.length = 500;
  persist();
  renderActivityLog();
}

function renderActivityLog() {
  const log = state.activityLog || [];
  els.activityBadge.textContent = log.length;
  const iconMap = { work:"🔨", payment:"💵", delete:"🗑️" };
  els.activityLogBody.innerHTML = log.length
    ? log.map((e) => `
        <li class="activity-item">
          <div class="activity-icon ${e.type==="delete"?"work":e.type}">${iconMap[e.type]||"📋"}</div>
          <div class="activity-body">
            <div class="activity-title">${escHtml(e.worker)} — ${escHtml(e.detail)}</div>
            <div class="activity-meta">${fmtDateTime(e.ts)}${e.enteredBy ? ` · بواسطة: ${escHtml(e.enteredBy)}` : ""}</div>
          </div>
          ${e.amount ? `<div class="activity-amount ${e.type==="delete"?"payment":e.type}">${fmtCur(e.amount)}</div>` : ""}
        </li>`).join("")
    : `<li class="empty-state">لا توجد حركات مسجلة بعد</li>`;
}

// ── ترتيب الجداول ─────────────────────────────────────────
function handleSort(th) {
  const tbl = th.dataset.tbl, col = th.dataset.col;
  if (!tbl || !col) return;
  const s = sortState[tbl];
  s.dir = (s.col === col) ? -s.dir : 1;
  s.col = col;
  // تحديث السهام
  th.closest("table").querySelectorAll("th.sortable").forEach((t) => {
    t.classList.remove("sort-asc","sort-desc");
    const arrow = t.querySelector(".sort-arrow");
    if (arrow) arrow.textContent = "↕";
  });
  th.classList.add(s.dir === 1 ? "sort-asc" : "sort-desc");
  const arrow = th.querySelector(".sort-arrow");
  if (arrow) arrow.textContent = s.dir === 1 ? "↑" : "↓";
  // إعادة رسم الجدول المناسب
  if (tbl==="work")    renderJobsTable();
  if (tbl==="pay")     renderPaymentsTable();
  if (tbl==="workers") renderWorkersSummary();
}

// ── فلاتر ─────────────────────────────────────────────────
function getFilters() {
  return { worker:els.filterWorker.value.trim(), work:els.filterWork.value.trim(), fromDate:els.fromDate.value, toDate:els.toDate.value };
}
function filterJobs(jobs, f) {
  return jobs.filter((j)=>matchTxt(j.worker,f.worker)&&matchTxt(j.work,f.work)&&inRange(j.date,f.fromDate,f.toDate));
}
function filterPayments(pays, f) {
  return pays.filter((p)=>matchTxt(p.worker,f.worker)&&inRange(p.date,f.fromDate,f.toDate));
}
function resetFilters() {
  els.filterWorker.value=""; els.filterWork.value=""; els.fromDate.value=""; els.toDate.value="";
  render();
}

// ── طباعة كشف الحساب ──────────────────────────────────────
function printStatement() {
  const f=getFilters(), jobs=filterJobs(state.jobs,f), pays=filterPayments(state.payments,f);
  const workerLabel=f.worker||"جميع العمال";
  const dateLabel=(f.fromDate||f.toDate)?`${f.fromDate||"..."} — ${f.toDate||"..."}`:"كامل الفترة";
  const due=sumArr(jobs,(j)=>calcJob(j).amount), paid=sumArr(pays,(p)=>p.amount), bal=due-paid;
  const jRows=jobs.slice().sort(byDateDesc).map((j)=>{ const c=calcJob(j); return `<tr><td>${fmtDate(j.date)}</td><td>${escHtml(j.time||"-")}</td><td>${escHtml(j.worker)}</td><td>${escHtml(j.work)}/${escHtml(j.unitType)}</td><td>${fmtNum(c.net)}</td><td>${fmtCur(j.unitPrice)}</td><td class="amount">${fmtCur(c.amount)}</td><td>${escHtml(j.note||"-")}</td></tr>`; }).join("");
  const pRows=pays.slice().sort(byDateDesc).map((p)=>`<tr><td>${fmtDate(p.date)}</td><td>${escHtml(p.time||"-")}</td><td>${escHtml(p.worker)}</td><td class="amount">${fmtCur(p.amount)}</td><td>${escHtml(p.note||"-")}</td></tr>`).join("");
  const html=`<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>كشف حساب</title><style>*{box-sizing:border-box}body{font-family:Tahoma,Arial,sans-serif;margin:0;padding:28px 36px;color:#17201a;font-size:14px}h1{font-size:22px;margin:0 0 4px}.sub{color:#68736d;margin:0 0 20px;font-size:13px}.summary{display:flex;gap:14px;margin-bottom:24px;flex-wrap:wrap}.box{border:1px solid #d8ded7;border-radius:8px;padding:12px 18px;min-width:140px}.box span{display:block;color:#68736d;font-size:12px;margin-bottom:4px}.box strong{font-size:20px}.green{border-top:3px solid #227467}.blue{border-top:3px solid #2f6478}.amber{border-top:3px solid #bb741f}h2{font-size:15px;margin:22px 0 8px;border-bottom:2px solid #d8ded7;padding-bottom:5px}table{width:100%;border-collapse:collapse}th,td{padding:8px 10px;border-bottom:1px solid #d8ded7;text-align:right;white-space:nowrap}th{background:#f5f7f3;color:#68736d;font-size:12px}.amount{font-weight:800;color:#17564b}.footer{margin-top:28px;font-size:12px;color:#68736d;border-top:1px solid #d8ded7;padding-top:10px}@media print{body{padding:12px 16px}}</style></head><body>
  <h1>كشف حساب</h1><p class="sub">العامل: <b>${escHtml(workerLabel)}</b> &nbsp;|&nbsp; الفترة: <b>${escHtml(dateLabel)}</b></p>
  <div class="summary"><div class="box green"><span>إجمالي المستحق</span><strong>${fmtCur(due)}</strong></div><div class="box blue"><span>إجمالي التسديد</span><strong>${fmtCur(paid)}</strong></div><div class="box amber"><span>المتبقي</span><strong>${fmtCur(bal)}</strong></div></div>
  <h2>الأعمال (${jobs.length} سجل)</h2>${jobs.length?`<table><thead><tr><th>التاريخ</th><th>الوقت</th><th>العامل</th><th>العمل</th><th>الكمية</th><th>السعر</th><th>المبلغ</th><th>ملاحظة</th></tr></thead><tbody>${jRows}</tbody></table>`:"<p style='color:#68736d'>لا توجد أعمال</p>"}
  <h2>الدفعات (${pays.length} دفعة)</h2>${pays.length?`<table><thead><tr><th>التاريخ</th><th>الوقت</th><th>العامل</th><th>المبلغ</th><th>ملاحظة</th></tr></thead><tbody>${pRows}</tbody></table>`:"<p style='color:#68736d'>لا توجد دفعات</p>"}
  <div class="footer">تاريخ الإنشاء: ${new Date().toLocaleDateString("ar-IQ")} &nbsp;|&nbsp; حساب عمل البناء</div>
  <script>window.onload=()=>window.print()<\/script></body></html>`;
  const win=window.open("","_blank");
  if (!win) { alert("يرجى السماح بالنوافذ المنبثقة في المتصفح لطباعة الكشف"); return; }
  win.document.write(html); win.document.close();
}

// ── كشف الأعمال ───────────────────────────────────────────
function printWorksStatement() {
  const f=getFilters(), jobs=filterJobs(state.jobs,f);
  const workerLabel=f.worker||"جميع العمال";
  const dateLabel=(f.fromDate||f.toDate)?`${f.fromDate||"..."} — ${f.toDate||"..."}`:"كامل الفترة";
  const due=sumArr(jobs,(j)=>calcJob(j).amount);
  const totalMeters=jobs.reduce((t,j)=>t+calcJob(j).net,0);
  const jRows=jobs.slice().sort(byDateDesc).map((j)=>{ const c=calcJob(j); return `<tr><td>${fmtDate(j.date)}</td><td>${escHtml(j.time||"-")}</td><td>${escHtml(j.worker)}</td><td>${escHtml(j.work)} / ${escHtml(j.unitType)}</td><td>${fmtNum(c.net)}</td><td>${escHtml(j.note||"-")}</td></tr>`; }).join("");
  const html=`<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>كشف الأعمال</title><style>*{box-sizing:border-box}body{font-family:Tahoma,Arial,sans-serif;margin:0;padding:28px 36px;color:#17201a;font-size:14px}h1{font-size:22px;margin:0 0 4px}.sub{color:#68736d;margin:0 0 20px;font-size:13px}.summary{display:flex;gap:14px;margin-bottom:24px;flex-wrap:wrap}.box{border:1px solid #d8ded7;border-radius:8px;padding:12px 18px;min-width:140px}.box span{display:block;color:#68736d;font-size:12px;margin-bottom:4px}.box strong{font-size:20px}.green{border-top:3px solid #227467}.rose{border-top:3px solid #b74f47}h2{font-size:15px;margin:22px 0 8px;border-bottom:2px solid #d8ded7;padding-bottom:5px}table{width:100%;border-collapse:collapse}th,td{padding:8px 10px;border-bottom:1px solid #d8ded7;text-align:right;white-space:nowrap}th{background:#f5f7f3;color:#68736d;font-size:12px}.amount{font-weight:800;color:#17564b}.footer{margin-top:28px;font-size:12px;color:#68736d;border-top:1px solid #d8ded7;padding-top:10px}@media print{body{padding:12px 16px}}</style></head><body>
  <h1>🔨 كشف الأعمال</h1><p class="sub">العامل: <b>${escHtml(workerLabel)}</b> &nbsp;|&nbsp; الفترة: <b>${escHtml(dateLabel)}</b></p>
  <div class="summary"><div class="box rose"><span>عدد السجلات</span><strong>${jobs.length}</strong></div><div class="box green"><span>إجمالي الأمتار</span><strong>${fmtNum(totalMeters)}</strong></div></div>
  <h2>الأعمال (${jobs.length} سجل)</h2>${jobs.length?`<table><thead><tr><th>التاريخ</th><th>الوقت</th><th>العامل</th><th>العمل</th><th>الكمية</th><th>ملاحظة</th></tr></thead><tbody>${jRows}</tbody></table>`:"<p style='color:#68736d'>لا توجد أعمال</p>"}
  <div class="footer">تاريخ الإنشاء: ${new Date().toLocaleDateString("ar-IQ")} &nbsp;|&nbsp; حساب عمل البناء</div>
  <script>window.onload=()=>window.print()<\/script></body></html>`;
  const win=window.open("","_blank");
  if (!win) { alert("يرجى السماح بالنوافذ المنبثقة في المتصفح لطباعة الكشف"); return; }
  win.document.write(html); win.document.close();
}

// ── كشف الدفعات ───────────────────────────────────────────
function printPaymentsStatement() {
  const f=getFilters(), pays=filterPayments(state.payments,f);
  const workerLabel=f.worker||"جميع العمال";
  const dateLabel=(f.fromDate||f.toDate)?`${f.fromDate||"..."} — ${f.toDate||"..."}`:"كامل الفترة";
  const paid=sumArr(pays,(p)=>p.amount);
  const pRows=pays.slice().sort(byDateDesc).map((p)=>`<tr><td>${fmtDate(p.date)}</td><td>${escHtml(p.time||"-")}</td><td>${escHtml(p.worker)}</td><td class="amount">${fmtCur(p.amount)}</td><td>${escHtml(p.note||"-")}</td></tr>`).join("");
  const html=`<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>كشف الدفعات</title><style>*{box-sizing:border-box}body{font-family:Tahoma,Arial,sans-serif;margin:0;padding:28px 36px;color:#17201a;font-size:14px}h1{font-size:22px;margin:0 0 4px}.sub{color:#68736d;margin:0 0 20px;font-size:13px}.summary{display:flex;gap:14px;margin-bottom:24px;flex-wrap:wrap}.box{border:1px solid #d8ded7;border-radius:8px;padding:12px 18px;min-width:140px}.box span{display:block;color:#68736d;font-size:12px;margin-bottom:4px}.box strong{font-size:20px}.blue{border-top:3px solid #2f6478}.rose{border-top:3px solid #b74f47}h2{font-size:15px;margin:22px 0 8px;border-bottom:2px solid #d8ded7;padding-bottom:5px}table{width:100%;border-collapse:collapse}th,td{padding:8px 10px;border-bottom:1px solid #d8ded7;text-align:right;white-space:nowrap}th{background:#f5f7f3;color:#68736d;font-size:12px}.amount{font-weight:800;color:#2f6478}.footer{margin-top:28px;font-size:12px;color:#68736d;border-top:1px solid #d8ded7;padding-top:10px}@media print{body{padding:12px 16px}}</style></head><body>
  <h1>💵 كشف الدفعات</h1><p class="sub">العامل: <b>${escHtml(workerLabel)}</b> &nbsp;|&nbsp; الفترة: <b>${escHtml(dateLabel)}</b></p>
  <div class="summary"><div class="box blue"><span>إجمالي الدفعات</span><strong>${fmtCur(paid)}</strong></div><div class="box rose"><span>عدد الدفعات</span><strong>${pays.length}</strong></div></div>
  <h2>الدفعات (${pays.length} دفعة)</h2>${pays.length?`<table><thead><tr><th>التاريخ</th><th>الوقت</th><th>العامل</th><th>المبلغ</th><th>ملاحظة</th></tr></thead><tbody>${pRows}</tbody></table>`:"<p style='color:#68736d'>لا توجد دفعات</p>"}
  <div class="footer">تاريخ الإنشاء: ${new Date().toLocaleDateString("ar-IQ")} &nbsp;|&nbsp; حساب عمل البناء</div>
  <script>window.onload=()=>window.print()<\/script></body></html>`;
  const win=window.open("","_blank");
  if (!win) { alert("يرجى السماح بالنوافذ المنبثقة في المتصفح لطباعة الكشف"); return; }
  win.document.write(html); win.document.close();
}

// ── إعدادات الحساب ────────────────────────────────────────
function openSettingsModal() {
  const contact = getContact();
  els.settingsCurPass.value  = "";
  els.settingsNewPass.value  = "";
  els.settingsConfPass.value = "";
  els.settingsWhatsapp.value = contact.whatsapp || "";
  els.settingsEmail.value    = contact.email    || "";
  els.settingsError.textContent   = "";
  els.settingsSuccess.textContent = "";
  // إظهار قسم إدارة المستخدمين للمدير فقط
  els.adminUsersSection.style.display = currentRole === "admin" ? "block" : "none";
  if (currentRole === "admin") {
    syncUsers().finally(renderUsersList);
  }
  document.getElementById("settingsModal").classList.add("open");
}

function closeSettingsModal() {
  document.getElementById("settingsModal").classList.remove("open");
}

async function saveSettings() {
  const curPass    = els.settingsCurPass.value;
  const newPass    = els.settingsNewPass.value;
  const confPass   = els.settingsConfPass.value;
  const err        = els.settingsError;
  const suc        = els.settingsSuccess;
  err.textContent  = "";
  suc.textContent  = "";

  if (!curPass) { err.textContent = "أدخل كلمة المرور الحالية للتحقق"; return; }
  if (!newPass) { err.textContent = "أدخل كلمة المرور الجديدة"; return; }
  if (newPass !== confPass) { err.textContent = "كلمة المرور الجديدة وتأكيدها غير متطابقتين"; return; }
  if (newPass.length < 4)   { err.textContent = "كلمة المرور الجديدة قصيرة جداً (٤ أحرف على الأقل)"; return; }

  const res = await changeMyPassword(curPass, newPass);
  if (!res || !res.ok) { err.textContent = "كلمة المرور الحالية غير صحيحة أو تعذر الحفظ"; return; }
  suc.textContent = "✅ تم تغيير كلمة المرور بنجاح";
  els.settingsCurPass.value  = "";
  els.settingsNewPass.value  = "";
  els.settingsConfPass.value = "";
  setTimeout(closeSettingsModal, 1200);
}

// ── إدارة المستخدمين (للمدير) ───────────────────────────
function renderUsersList() {
  const users = getUsers();
  els.usersList.innerHTML = users.map((u) => `
    <li style="display:flex;align-items:center;justify-content:space-between;gap:8px;padding:8px 10px;border:1px solid var(--line);border-radius:7px;margin-bottom:6px">
      <div style="flex:1;min-width:0">
        <b>${escHtml(u.user)}</b>
        <span style="font-size:11px;color:var(--muted);margin-right:6px">${u.role==="admin"?"👑 مدير":"👤 مستخدم"}</span>
      </div>
      <div style="display:flex;gap:4px;flex-shrink:0">
        <button class="btn-ghost" style="min-height:30px;padding:3px 10px;font-size:12px" data-action="reset-pass" data-user="${escHtml(u.user)}">🔑</button>
        ${u.user !== currentUser ? `<button class="btn-danger" style="min-height:30px;padding:3px 10px;font-size:12px" data-action="delete-user" data-user="${escHtml(u.user)}">حذف</button>` : ""}
      </div>
    </li>`).join("");
}

async function handleAddUser() {
  const name = els.newUserName.value.trim();
  const pass = els.newUserPass.value;
  const role = els.newUserIsAdmin.checked ? "admin" : "user";
  const err  = els.settingsError;
  err.textContent = "";
  if (!name || !pass) { err.textContent = "أدخل اسم المستخدم وكلمة المرور"; return; }
  if (pass.length < 4) { err.textContent = "كلمة المرور قصيرة (٤ أحرف على الأقل)"; return; }
  const res = await createUserOnServer(name, pass, role);
  if (!res || !res.ok) { err.textContent = "تعذر إضافة المستخدم أو الاسم موجود بالفعل"; return; }
  await syncUsers();
  els.newUserName.value = "";
  els.newUserPass.value = "";
  els.newUserIsAdmin.checked = false;
  els.settingsSuccess.textContent = `✅ تمت إضافة ${name}`;
  renderUsersList();
}

async function confirmDeleteUser(name) {
  if (!confirm(`حذف المستخدم "${name}"؟\nلن يتمكن من تسجيل الدخول بعد الحذف.`)) return;
  const res = await deleteUserOnServer(name);
  if (!res || !res.ok) { alert("تعذر حذف المستخدم"); return; }
  await syncUsers();
  renderUsersList();
  els.settingsSuccess.textContent = `✅ تم حذف ${name}`;
}

async function promptChangePass(name) {
  const newPass = prompt(`كلمة مرور جديدة للمستخدم "${name}":`);
  if (!newPass) return;
  if (newPass.length < 4) { alert("كلمة المرور قصيرة (٤ أحرف على الأقل)"); return; }
  const res = await setUserPasswordOnServer(name, newPass);
  if (!res || !res.ok) { alert("تعذر تغيير كلمة المرور"); return; }
  els.settingsSuccess.textContent = `✅ تم تغيير كلمة مرور ${name}`;
}

function saveContactSettings() {
  const whatsapp = els.settingsWhatsapp.value.trim();
  const email    = els.settingsEmail.value.trim();
  saveContact({ whatsapp, email });
  els.settingsSuccess.textContent = "✅ تم حفظ بيانات التواصل";
  setTimeout(closeSettingsModal, 1200);
}

// ── نسخ احتياطي ──────────────────────────────────────────
function createBackup(trigger) {
  // أرسل للسيرفر (MySQL) — لا تعتمد على localStorage
  serverGet("createBackup", { trigger: trigger || "auto" })
    .catch(e => console.warn("[Bina] createBackup failed:", e));
}

// pruneBackups: لا يزال يُنظِّف أي بيانات localStorage قديمة
function pruneBackups() {
  const cutoff=Date.now()-BACKUP_DAYS*86400000;
  Object.keys(localStorage).filter((k)=>k.startsWith(BACKUP_PREFIX))
    .forEach((k)=>{ if(new Date(k.slice(BACKUP_PREFIX.length)).getTime()<cutoff) localStorage.removeItem(k); });
}

// cachedBackups مُعرَّف في data.js — لا تُعرِّفه هنا مرة ثانية

async function listBackups() {
  const d = await serverGet("listBackups");
  if (Array.isArray(d)) { cachedBackups = d; return d; }
  return cachedBackups;
}

async function restoreBackup(key) {
  if(!confirm("استعادة هذه النسخة؟\n\nسيتم استبدال البيانات الحالية.")) return;
  const d = await serverGet("restoreBackup", { key: key });
  // فحص صريح: يجب أن تحتوي الاستجابة على jobs كمصفوفة
  if (!d || !Array.isArray(d.jobs)) {
    alert("تعذر استعادة النسخة — البيانات غير صالحة أو الاتصال فشل");
    return;
  }
  state.jobs        = d.jobs;
  state.payments    = Array.isArray(d.payments)    ? d.payments    : [];
  state.activityLog = Array.isArray(d.activityLog) ? d.activityLog : state.activityLog;
  persist(); render(); closeBackupModal(); alert("✅ تمت الاستعادة بنجاح");
}

async function deleteBackup(key) {
  if(!confirm("حذف هذه النسخة الاحتياطية؟")) return;
  await serverGet("deleteBackup", { key: key });
  renderBackupList();
}

function openBackupModal()  { renderBackupList(); document.getElementById("backupModal").classList.add("open"); }
function closeBackupModal() { document.getElementById("backupModal").classList.remove("open"); }

async function renderBackupList() {
  const list = await listBackups();
  var el = els.backupList;
  el.innerHTML = list.length
    ? list.map(function(bk) {
        return '<li class="backup-item" data-bk-key="' + escHtml(bk.key) + '">'
          + '<div class="backup-info">'
          + '<div class="backup-time">' + fmtDateTime(bk.ts) + '</div>'
          + '<div class="backup-meta">' + (bk.size ? Math.round(bk.size/1024)+'KB' : '') + '</div>'
          + '</div>'
          + '<div class="backup-item-btns">'
          + '<button class="btn-restore"  data-bk-action="restore">استعادة</button>'
          + '<button class="btn-del-backup" data-bk-action="delete">حذف</button>'
          + '</div></li>';
      }).join("")
    : '<li class="empty-backups">لا توجد نسخ احتياطية محفوظة</li>';
  // تفويض الأحداث — آمن من XSS (لا inline JS)
  el.onclick = function(e) {
    const btn = e.target.closest("[data-bk-action]");
    if (!btn) return;
    const key = btn.closest("[data-bk-key]").dataset.bkKey;
    if (btn.dataset.bkAction === "restore") restoreBackup(key);
    if (btn.dataset.bkAction === "delete")  deleteBackup(key);
  };
}

// ── تصدير / استيراد JSON ─────────────────────────────────
function exportJson() {
  const data=JSON.stringify({ exported:new Date().toISOString(), jobs:state.jobs, payments:state.payments, activityLog:state.activityLog },null,2);
  const a=Object.assign(document.createElement("a"),{ href:"data:application/json;charset=utf-8,"+encodeURIComponent(data), download:`backup-${new Date().toISOString().slice(0,10)}.json` });
  a.click();
}

function importJson() {
  const file=els.importJsonInput.files[0]; if(!file) return;
  const reader=new FileReader();
  reader.onload=(e)=>{
    try {
      const d=JSON.parse(e.target.result);
      if(!Array.isArray(d.jobs)) throw new Error();
      if(!confirm(`استيراد ${d.jobs.length} عمل و${(d.payments||[]).length} دفعة؟\n\nسيتم استبدال البيانات الحالية.`)) return;
      state.jobs=d.jobs; state.payments=d.payments||[]; state.activityLog=d.activityLog||[];
      persist(); render(); closeBackupModal(); alert("✅ تم الاستيراد بنجاح");
    } catch(err) { alert("الملف غير صالح"); }
    els.importJsonInput.value="";
  };
  reader.readAsText(file);
}

function clearData() {
  if(!confirm("مسح كل الأعمال والدفعات وسجل الحركات؟")) return;
  state.jobs=[]; state.payments=[]; state.activityLog=[];
  persist(); render();
}

// ── مساعدات ───────────────────────────────────────────────
function uid()           { return 'xxxx-xxxx-xxxx'.replace(/x/g,()=>Math.floor(Math.random()*16).toString(16))+'-'+Date.now().toString(36); }
function toNum(v)        { const n=Number(v); return Number.isFinite(n)?n:0; }
function sumArr(a,fn)    { return a.reduce((t,i)=>t+fn(i),0); }
function uniq(arr)       { return [...new Set(arr.filter(Boolean))].sort((a,b)=>a.localeCompare(b,"ar")); }
function byDateDesc(a,b) { return b.date.localeCompare(a.date); }
function matchTxt(v,f)   { return !f||v.toLowerCase().includes(f.toLowerCase()); }
function inRange(d,f,t)  { return (!f||d>=f)&&(!t||d<=t); }
function fmtCur(v)       { return `$${fmtNum(v)}`; }
function fmtNum(v)       { return new Intl.NumberFormat("en-US",{maximumFractionDigits:2,minimumFractionDigits:Number.isInteger(v)?0:2}).format(v); }
function fmtDate(v)      { if(!v) return "-"; return new Intl.DateTimeFormat("ar-IQ-u-nu-latn",{year:"numeric",month:"2-digit",day:"2-digit"}).format(new Date(`${v}T00:00:00`)); }
function fmtDateTime(iso){ if(!iso) return "-"; return new Intl.DateTimeFormat("ar-IQ-u-nu-latn",{year:"numeric",month:"2-digit",day:"2-digit",hour:"2-digit",minute:"2-digit"}).format(new Date(iso)); }
function escHtml(v)      { return String(v).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;"); }

// ── بدء ───────────────────────────────────────────────────
document.addEventListener("DOMContentLoaded", () => {
  initAuth().catch(e => {
    console.warn("Auth init error:", e);
    document.getElementById("loginError").textContent = "تعذر الاتصال بالخادم";
  });
});
</script>
</body>
</html>
