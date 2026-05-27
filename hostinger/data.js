/**
 * ═══════════════════════════════════════════════════════
 *  data.js  —  Bina App v5.4  |  Hostinger / MySQL
 *  plantaslb.com
 * ═══════════════════════════════════════════════════════
 */

/* ── Constants ─────────────────────────────────────── */
const SESSION_KEY   = 'bina_sess_v5';
const BACKUP_PREFIX = 'bina_bk_';
const BACKUP_DAYS   = 30;
const API_URL       = 'api.php';

/* ── Low-level API ─────────────────────────────────── */
async function _api(action, body = {}) {
  try {
    const r = await fetch(`${API_URL}?action=${encodeURIComponent(action)}`, {
      method      : 'POST',
      credentials : 'same-origin',
      headers     : { 'Content-Type': 'application/json' },
      body        : JSON.stringify(body)
    });
    if (!r.ok) return null;
    return await r.json();
  } catch (err) {
    console.warn('[Bina] API error:', action, err);
    return null;
  }
}

/* Generic serverGet used by inline backup handlers */
async function serverGet(action, params = {}) {
  return _api(action, params);
}

/* ── Auth ──────────────────────────────────────────── */
async function getServerSession() {
  return _api('getSession');
}

async function getAuthStatus() {
  const r = await _api('getAuthStatus');
  return r ? r.hasUsers : false;
}

async function bootstrapAdmin(user, pass) {
  return _api('bootstrapAdmin', { user, pass });
}

async function loginUser(user, pass) {
  return _api('login', { user, pass });
}

function logoutUser() {
  _api('logout');
  sessionStorage.removeItem(SESSION_KEY);
}

/* ── Users ─────────────────────────────────────────── */
let _cachedUsers = [];

async function syncUsers() {
  const r = await _api('getUsers');
  if (r && r.ok && Array.isArray(r.users)) {
    _cachedUsers = r.users;
  }
  return r;
}

function getUsers() {
  return _cachedUsers;
}

function isAdmin(username) {
  const u = _cachedUsers.find(x => (x.user || x.username) === username);
  return u ? u.role === 'admin' : false;
}

async function changeMyPassword(curPass, newPass) {
  return _api('changePassword', { curPass, newPass });
}

async function createUserOnServer(user, pass, role) {
  return _api('createUser', { user, pass, role });
}

async function deleteUserOnServer(user) {
  return _api('deleteUser', { user });
}

async function setUserPasswordOnServer(user, pass) {
  return _api('setUserPassword', { user, pass });
}

/* ── Contact ───────────────────────────────────────── */
let _cachedContact = { whatsapp: '', email: '' };

async function syncContact() {
  const r = await _api('getContact');
  if (r && r.ok && r.contact) _cachedContact = r.contact;
}

function getContact() {
  return { ..._cachedContact };
}

function saveContact(data) {
  _cachedContact = { ...data };
  _api('saveContact', data);
}

/* ── State ─────────────────────────────────────────── */
let _state = null;
let _persistTimer = null;

/**
 * يُعيد الحالة من الذاكرة (أو حالة فارغة عند أول تشغيل).
 * syncState() يُحدّثها من السيرفر لاحقاً.
 */
function loadState() {
  if (!_state) {
    _state = { jobs: [], payments: [], activityLog: [] };
  }
  return _state;
}

/**
 * يحفظ الحالة على السيرفر.
 * يستخدم debounce (300ms) لتجنب حفظ متعدد متتالي.
 */
function persist() {
  if (!_state) return;
  clearTimeout(_persistTimer);
  _persistTimer = setTimeout(() => {
    _api('saveState', {
      jobs        : _state.jobs,
      payments    : _state.payments,
      activityLog : _state.activityLog
    }).catch(err => console.warn('[Bina] persist failed:', err));
  }, 300);
}

/**
 * يجلب أحدث البيانات من السيرفر ويحدّث الحالة ثم يُعيد الرسم.
 */
async function syncState() {
  const r = await _api('getState');
  if (r && r.ok) {
    if (!_state) _state = {};
    _state.jobs        = Array.isArray(r.jobs)        ? r.jobs        : [];
    _state.payments    = Array.isArray(r.payments)    ? r.payments    : [];
    _state.activityLog = Array.isArray(r.activityLog) ? r.activityLog : [];
    if (typeof render === 'function') render();
  }
}

/* ── Backups ───────────────────────────────────────── */
let cachedBackups = [];

async function listBackups() {
  const r = await _api('listBackups');
  if (Array.isArray(r)) {
    cachedBackups = r;
    return r;
  }
  return cachedBackups;
}

/* ── Migration (no-op — no old localStorage auth) ─── */
function migrateOldAuth() {
  // لا يوجد بيانات قديمة للترحيل على هذا السيرفر
}
