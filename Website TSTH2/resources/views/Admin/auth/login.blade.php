<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/assets_login/images/icons/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_login/css/main.css') }}">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('assets/assets_login/images/img-01.png') }}" alt="IMG">
                </div>

                <form class="login100-form validate-form" id="loginForm">
                    <span class="login100-form-title">
                        Member Login
                    </span>

                    <!-- Alert Error dengan Auto-hide -->
                    <div id="error-message" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <span id="error-text"></span>
                        <button type="button" class="close" onclick="closeAlert()">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="username" id="username" placeholder="Username" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="password" name="password" id="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/assets_login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/assets_login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/assets_login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/assets_login/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/assets_login/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        });
    </script>
    <script src="{{ asset('assets/assets_login/js/main.js') }}"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            let username = document.getElementById('username').value;
            let password = document.getElementById('password').value;
            let errorMessageDiv = document.getElementById('error-message');
            let errorText = document.getElementById('error-text');

            try {
                let response = await fetch("{{ url('http://127.0.0.1:8000/api/auth/login') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password
                    })
                });

                let data = await response.json();

                if (!response.ok) {
                    // Handle validation errors
                    if (data.errors) {
                        let errorMsg = Object.values(data.errors).join('\n');
                        throw new Error(errorMsg);
                    }
                    throw new Error(data.message || "Login gagal. Periksa kembali username dan password Anda.");
                }

                // Simpan token di localStorage
                localStorage.setItem("access_token", data.data.token);
                // Redirect ke dashboard
                window.location.href = "{{ url('/dashboard') }}";

            } catch (error) {
                errorText.textContent = error.message;
                errorMessageDiv.style.display = "block";

                // Auto-hide alert setelah 5 detik
                setTimeout(() => {
                    errorMessageDiv.style.display = "none";
                }, 5000);
            }
        });

        function closeAlert() {
            document.getElementById('error-message').style.display = "none";
        }
    </script>
</body>
</html>