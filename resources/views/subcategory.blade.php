<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeadowKart | Home</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-md py-4 px-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-green-600">MeadowKart</h1>
        <nav class="space-x-6">
            <a href="#" class="hover:text-green-600">Home</a>
            <a href="#" class="hover:text-green-600">Shop</a>
            <a href="#" class="hover:text-green-600">Categories</a>
            <a href="#" class="hover:text-green-600">Contact</a>
        </nav>
    </header>

    <!-- Hero Banner -->
    <section class="relative bg-green-100 py-16 px-8 text-center">
        <h2 class="text-4xl font-bold text-green-800 mb-3">Welcome to MeadowKart</h2>
        <p class="text-gray-700 text-lg">Discover the best categories and latest products for you</p>
    </section>

    <!-- Categories Section -->
    <section class="px-8 py-12">
        <h3 class="text-2xl font-semibold mb-6 border-b-4 border-green-500 inline-block">Top Categories</h3>

        <!-- jBoxes (Horizontal scroll) -->
        <div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
            @foreach($sub_category as $c)
                <a href="/product/{{ encrypt($c->id) }}" 
                   class="min-w-[250px] bg-white shadow-md rounded-2xl overflow-hidden transform hover:scale-105 transition duration-300 block">
                    <img src="{{ $c->image ?? 'https://via.placeholder.com/300x200?text=SubCategory' }}" 
                         alt="{{ $c->sub_subcategory }}" 
                         class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h4 class="font-semibold text-lg text-gray-800">{{ $c->sub_subcategory }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Explore our {{ strtolower($c->sub_subcategory) }} collection</p>
                        {{-- <span class="mt-3 inline-block bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">
                            Shop Now →
                        </span> --}}
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 text-center">
        <p>&copy; {{ date('Y') }} MeadowKart. All rights reserved.</p>
    </footer>

</body>
</html>