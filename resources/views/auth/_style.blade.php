<style>
    :root { --green:#059669; --navy:#111827; --bg:#fefaf0; }
    * { box-sizing:border-box; }
    body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
           background:var(--bg); font-family:'Segoe UI',Arial,sans-serif; color:var(--navy); padding:16px; }
    .card { width:100%; max-width:420px; background:#fff; border-radius:24px; padding:36px;
            box-shadow:0 10px 40px rgba(0,0,0,.08); }
    .logo { font-weight:800; font-size:26px; color:var(--navy); text-decoration:none; }
    .logo .g { color:var(--green); }
    .eyebrow { margin:24px 0 4px; font-size:12px; font-weight:700; letter-spacing:.3em; color:#b45309; }
    h1 { margin:0 0 6px; font-size:32px; font-weight:800; }
    .sub { margin:0 0 20px; color:#4b5563; font-size:14px; }
    label { display:block; margin:14px 0 6px; font-size:14px; font-weight:600; }
    input[type=email], input[type=password], input[type=text] {
        width:100%; padding:12px 16px; border:1px solid #e5e7eb; border-radius:999px;
        font-size:15px; outline:none; background:#f9fafb; }
    input:focus { border-color:var(--green); background:#fff; }
    .check { display:flex; gap:8px; align-items:center; font-weight:400; }
    .btn { width:100%; margin-top:22px; padding:13px; border:0; border-radius:999px;
           background:var(--green); color:#fff; font-size:16px; font-weight:700; cursor:pointer; }
    .btn:hover { background:#047857; }
    .error { color:#dc2626; font-size:13px; margin-top:6px; }
    .foot { text-align:center; margin-top:20px; font-size:14px; color:#4b5563; }
    .foot a { color:var(--green); font-weight:700; text-decoration:none; }
</style>