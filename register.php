<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-sm p-6 sm:p-8 rounded-3xl shadow-xl">

        <!-- Back -->
        <div class="mb-8">
            <a href="javascript:history.back()" class="text-gray-600 hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-center text-blue-900 mb-6">
            Register
        </h1>

        <!-- Error Box -->
        <div id="errorBox" class="hidden text-red-500 text-sm text-center mb-4">
            Terjadi kesalahan saat registrasi
        </div>

        <form method="POST" action="modules/auth/register.php" class="space-y-5">

            <!-- Name -->
            <div>
                <label class="text-sm text-gray-600">Nama</label>
                <input 
                    type="text" 
                    name="name" 
                    required
                    placeholder="Nama lengkap"
                    class="w-full px-4 py-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    required
                    autocomplete="email"
                    placeholder="Email"
                    class="w-full px-4 py-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Password -->
            <div class="relative">
                <label class="text-sm text-gray-600">Password</label>

                <input 
                    id="password"
                    type="password" 
                    name="password" 
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                    class="w-full px-4 py-3 mt-1 bg-blue-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <span 
                    onclick="togglePassword()"
                    class="absolute right-4 top-10 text-gray-500 cursor-pointer"
                >
                    <i id="eyeIcon" class="fa-regular fa-eye"></i>
                </span>
            </div>

            <!-- Button -->
            <button 
                id="registerBtn"
                type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg shadow-md hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] transition"
            >
                Register
            </button>

        </form>

        <!-- Login link -->
        <div class="mt-6 text-center text-gray-700 text-sm">
            Already have an account?
            <a href="login.php" class="text-blue-800 font-bold hover:underline">
                Login
            </a>
        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        // toggle password
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // loading state
        document.querySelector("form").addEventListener("submit", function () {
            const btn = document.getElementById("registerBtn");
            btn.innerText = "Creating account...";
            btn.disabled = true;
        });
    </script>

</body>
</html>
