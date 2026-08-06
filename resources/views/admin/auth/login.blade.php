<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login | Best4You</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #696cff;
            --bs-body-bg: #f5f5f9;
            --bs-body-font-family: 'Public Sans', sans-serif;
        }
        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--bs-body-bg);
            color: #566a7f;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh;
        }
        .login-card { 
            width: 100%; 
            max-width: 400px; 
            padding: 40px; 
            border-radius: 0.5rem; 
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12); 
            background: #fff; 
        }
        .app-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: #566a7f;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .app-brand-logo { color: var(--bs-primary); margin-right: 0.5rem; }
        
        .btn-primary {
            color: #fff;
            background-color: #696cff;
            border-color: #696cff;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(105, 108, 255, 0.4);
            padding: 0.6rem;
        }
        .btn-primary:hover {
            background-color: #5f61e6;
            border-color: #5f61e6;
            transform: translateY(-1px);
        }
        .form-control {
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            padding: 0.6rem 0.875rem;
            color: #697a8d;
        }
        .form-control:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <a href="#" class="app-brand">
            <span class="app-brand-logo">
                <svg width="32" viewBox="0 0 464 295" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M117.892 278.49L72.2356 226.476L164.711 123.003L120.245 42.0298L171.218 20.3703L237.525 141.28L117.892 278.49Z" fill="currentColor" />
                    <path d="M237.525 141.28L305.617 26.6874L364.577 6.46781L299.882 121.365L418.964 263.303L363.308 284.154L237.525 141.28Z" fill="currentColor" fill-opacity="0.8" />
                </svg>
            </span>
            <span class="app-brand-text">Admin</span>
        </a>
        
        <h4 class="mb-2 fw-semibold">Welcome to Best4You! 👋</h4>
        <p class="mb-4 text-muted">Please sign in to your account and start the adventure</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="adminLoginForm">
            @csrf
            <div class="mb-3">
                <label class="form-label text-uppercase" style="font-size: 0.75rem;">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required autofocus />
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label text-uppercase" style="font-size: 0.75rem;">Password</label>
                </div>
                <input type="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me">
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
            </div>
            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#adminLoginForm').on('submit', function(e) {
            e.preventDefault();
            var $btn = $(this).find('button[type="submit"]');
            var originalText = $btn.text();
            
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Signing in...').prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                headers: { 'Accept': 'application/json' },
                success: function(response) {
                    window.location.href = "{{ route('admin.dashboard') }}";
                },
                error: function(xhr) {
                    $btn.text(originalText).prop('disabled', false);
                    $('.alert-danger').remove();
                    var msg = xhr.responseJSON?.message || 'Invalid credentials';
                    $('#adminLoginForm').before('<div class="alert alert-danger p-2">' + msg + '</div>');
                }
            });
        });
    });
    </script>
</body>
</html>
