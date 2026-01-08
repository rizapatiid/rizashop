<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root{
            --primary: #0ea5e9;
            --dark: #0f172a;
            --muted: #64748b;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            margin: 0;
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-box {
            background: #ffffff;
            max-width: 420px;
            width: 100%;
            padding: 40px 32px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,.08);
        }

        .error-code {
            font-size: 96px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .error-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .error-desc {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 28px;
            line-height: 1.6;
        }
        .error-seller {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 10px;
            line-height: 1.6;
        }

       .btn-home {
            display: inline-block;
            background-color: #0ea5e9;
            color: #ffffff;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color .2s ease, transform .1s ease;
        }

        .btn-home:hover {
            background-color: #0284c7;
        }

        .btn-home:active {
            transform: scale(0.98);
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .title {
        font-weight: 700; /* bold */
    }


    </style>
</head>
<body>

    <div class="error-box">
        <div class="error-code">403</div>
        <div class="error-title text-bold"><strong>AKSES DITOLAK</strong></div>
        <div class="error-seller">
         <strong>Seller Center</strong>
        </div>
        <div class="error-desc">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            Silakan kembali ke beranda.
        </div>

        <a href="{{ url('/') }}" class="btn-home">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 10.5L12 3l9 7.5"/>
                <path d="M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10"/>
            </svg>
            BERANDA
        </a>
    </div>

</body>
</html>
