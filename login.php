<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-cover bg-center h-screen" style="background-image: url('../images/ctu1.png');">
    <div class="login-container flex items-center justify-center h-full">
        <div class="bg-blue-900 bg-opacity-80 p-10 rounded-lg w-full h-full max-h-96 max-w-sm text-white">
            <div class="header flex items-center justify-center mb-6 relative">
                <img src="../images/ctulogo.png" alt="Logo 1" class="w-12 h-12 mr-2">
                <h1 class="text-2xl font-bold text-gold mx-2">IPAMIS</h1>
                <img src="../images/pilipinaslogo.png" alt="Logo 2" class="w-14 h-14 ml-2">
                <span class="border-line absolute left-0"></span>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-4">
                <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-gold">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-gold">
                <div class="flex justify-between items-center text-sm">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="text-gold focus:ring-gold">
                        <span class="ml-2">Remember me</span>
                    </label>
                    <a href="#" class="text-lightblue hover:underline">Forgot Password?</a>
                </div>
                <button type="submit" class="w-full py-2 bg-gold text-blue-900 font-semibold rounded-lg hover:bg-orange-600 focus:outline-none">LOGIN</button>
            </form>
            <p class="mt-4 text-center text-xs">Need assistance? Contact us at <a href="mailto:support@example.com" class="text-lightblue hover:underline">support@example.com</a></p>
        </div>
    </div>
</body>
</html>
