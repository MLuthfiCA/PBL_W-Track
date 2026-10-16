<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="W-Track - Sistem Manajemen Equipment Workshop">
    <title>@yield('title', 'W-Track') | Sistem Manajemen Equipment</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #00BCD4;
            --primary-dark: #0097A7;
            --primary-light: #B2EBF2;
            --primary-glow: rgba(0, 188, 212, 0.25);
            --sidebar-bg: #0D1B2A;
            --sidebar-hover: #1a2d42;
            --sidebar-active: #00BCD4;
            --dark-bg: #0a1628;
            --card-bg: #ffffff;
            --body-bg: #f0f4f8;
            --text-primary: #1a202c;
            --text-secondary: #718096;
            --text-muted: #a0aec0;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.10);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.14);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
            --status-used: #F59E0B;
            --status-available: #10B981;
            --status-repair: #EF4444;
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
        }
    </style>

    @yield('styles')
</head>
<body>
    @yield('content')
    @yield('scripts')
</body>
</html>
