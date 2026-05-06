<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Digital Church</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-base:    #020617;
            --bg-surface: #0f172a;
            --bg-card:    #1e293b;
            --bg-hover:   #263348;
            --border:     rgba(255,255,255,0.06);
            --border-md:  rgba(255,255,255,0.1);
            --text-1:     #f8fafc;
            --text-2:     #94a3b8;
            --text-3:     #475569;
            --accent:     #6366f1;
            --accent-2:   #8b5cf6;
            --green:      #22c55e;
            --sidebar-w:  240px;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--bg-base);
            color: var(--text-1);
            overflow-x: hidden;
        }

        /* ── TOPBAR ── */
        .u-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 60px;
            background: rgba(2,6,23,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px 0 calc(var(--sidebar-w) + 24px);
            z-index: 100;
        }
        .u-topbar .page-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-1);
        }
        .u-topbar .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-card);
            border: 1px solid var(--border-md);
            border-radius: 40px;
            padding: 6px 14px 6px 8px;
            font-size: 13px;
            font-weight: 500;
        }
        .u-topbar .user-pill .avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            flex-shrink: 0;
        }

        /* ── SIDEBAR ── */
        .u-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: rgba(2,6,23,0.95);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 0;
            z-index: 200;
            backdrop-filter: blur(20px);
        }
        .u-sidebar .brand {
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid var(--border);
            font-size: 16px;
            font-weight: 800;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            flex-shrink: 0;
        }
        .u-sidebar nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }
        .u-sidebar nav a {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            margin-bottom: 2px;
            border-radius: 10px;
            color: var(--text-2);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.18s;
        }
        .u-sidebar nav a .icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            background: rgba(255,255,255,0.04);
            flex-shrink: 0;
            transition: 0.18s;
        }
        .u-sidebar nav a:hover {
            background: var(--bg-hover);
            color: var(--text-1);
        }
        .u-sidebar nav a:hover .icon {
            background: rgba(99,102,241,0.15);
        }
        .u-sidebar nav a.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.15));
            color: #a5b4fc;
            border: 1px solid rgba(99,102,241,0.25);
        }
        .u-sidebar nav a.active .icon {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: white;
        }
        .u-sidebar .sidebar-footer {
            padding: 12px;
            border-top: 1px solid var(--border);
        }
        .u-sidebar .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #f87171;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            background: rgba(239,68,68,0.06);
            border: 1px solid rgba(239,68,68,0.1);
            transition: 0.18s;
        }
        .u-sidebar .sidebar-footer a:hover {
            background: rgba(239,68,68,0.12);
        }

        /* ── MAIN CONTENT ── */
        .u-main {
            margin-left: var(--sidebar-w);
            padding-top: 60px;
            min-height: 100vh;
        }
        .u-page {
            padding: 28px 32px 60px;
        }

        /* ── PAGE HEADER ── */
        .u-page-header {
            margin-bottom: 28px;
        }
        .u-page-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-1);
            margin-bottom: 4px;
        }
        .u-page-header p {
            font-size: 14px;
            color: var(--text-2);
        }

        /* ── ALERT ── */
        .u-alert-success {
            background: rgba(34,197,94,0.12);
            color: #86efac;
            border: 1px solid rgba(34,197,94,0.25);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .u-alert-error {
            background: rgba(239,68,68,0.12);
            color: #fca5a5;
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* ── CARD ── */
        .u-card {
            background: var(--bg-card);
            border: 1px solid var(--border-md);
            border-radius: 16px;
        }

        /* ── FORM CONTROLS ── */
        .u-input {
            background: var(--bg-surface);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-1);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            width: 100%;
            transition: 0.15s;
            outline: none;
        }
        .u-input::placeholder { color: var(--text-3); }
        .u-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .u-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 6px;
        }

        /* ── BUTTONS ── */
        .u-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.18s;
            text-decoration: none;
        }
        .u-btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: white;
        }
        .u-btn-primary:hover { opacity: 0.9; color: white; transform: translateY(-1px); }
        .u-btn-green {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }
        .u-btn-green:hover { opacity: 0.9; color: white; transform: translateY(-1px); }
        .u-btn-ghost {
            background: rgba(255,255,255,0.05);
            color: var(--text-2);
            border: 1px solid var(--border-md);
        }
        .u-btn-ghost:hover { background: var(--bg-hover); color: var(--text-1); }
        .u-btn-danger-ghost {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
        }
        .u-btn-danger-ghost:hover { background: rgba(239,68,68,0.2); }
        .u-btn-sm { padding: 6px 14px; font-size: 13px; }
        .u-btn-full { width: 100%; }

        /* ── BADGE ── */
        .u-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .u-badge-green  { background: rgba(34,197,94,0.15);  color: #86efac; border: 1px solid rgba(34,197,94,0.3); }
        .u-badge-red    { background: rgba(239,68,68,0.15);  color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }
        .u-badge-indigo { background: rgba(99,102,241,0.15); color: #a5b4fc; border: 1px solid rgba(99,102,241,0.3); }
        .u-badge-gray   { background: rgba(100,116,139,0.15);color: #64748b; border: 1px solid rgba(100,116,139,0.2); }

        /* ── MOBILE SIDEBAR TOGGLE ── */
        .u-hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text-1);
            font-size: 20px;
            cursor: pointer;
            padding: 4px 8px;
        }
        .u-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 150;
        }
        .u-overlay.show { display: block; }

        @media (max-width: 768px) {
            .u-sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }
            .u-sidebar.open { transform: translateX(0); }
            .u-topbar { padding-left: 16px; }
            .u-main { margin-left: 0; }
            .u-page { padding: 20px 16px 60px; }
            .u-hamburger { display: block; }
        }
    </style>
</head>
<body>

{{-- OVERLAY (mobile) --}}
<div class="u-overlay" id="overlay" onclick="closeSidebar()"></div>

{{-- SIDEBAR --}}
<aside class="u-sidebar" id="sidebar">
    <div class="brand">⛪ Digital Church</div>
    <nav>
        <a href="{{ route('user.home') }}"
            class="{{ request()->routeIs('user.home') ? 'active' : '' }}">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('user.services') }}"
            class="{{ request()->routeIs('user.services') ? 'active' : '' }}">
            <span class="icon">📅</span> Jadwal Ibadah
        </a>
        <a href="{{ route('user.pelayanan') }}"
            class="{{ request()->routeIs('user.pelayanan') ? 'active' : '' }}">
            <span class="icon">🙌</span> Pelayanan
        </a>
        <a href="{{ route('user.donation') }}"
            class="{{ request()->routeIs('user.donation') ? 'active' : '' }}">
            <span class="icon">💖</span> Donasi
        </a>
        <a href="{{ route('user.counseling') }}"
            class="{{ request()->routeIs('user.counseling') ? 'active' : '' }}">
            <span class="icon">🧠</span> Konseling
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="/auto-logout">
            <span>🚪</span> Logout
        </a>
    </div>
</aside>

{{-- TOPBAR --}}
<header class="u-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="u-hamburger" onclick="toggleSidebar()">☰</button>
        <span class="page-title" id="topbar-title">Digital Church</span>
    </div>
    <div class="user-pill">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        {{ auth()->user()->name }}
    </div>
</header>

{{-- MAIN --}}
<main class="u-main">
    <div class="u-page">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('show');
    }
    // Set topbar title from page
    document.addEventListener('DOMContentLoaded', () => {
        const h2 = document.querySelector('.u-page-header h2');
        if (h2) document.getElementById('topbar-title').textContent = h2.textContent.trim();
    });
</script>
</body>
</html>
