```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3B82F6;
            --secondary-color: #10B981;
        }

        .featured-product {
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .featured-product::before {
            content: 'Featured';
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #FFD700;
            color: black;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            z-index: 10;
        }

        .featured-product:hover {
            transform: scale(1.05);
        }

        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 40;
            pointer-events: none;
        }

        .blurred-content {
            opacity: 0.4;
            filter: grayscale(50%) blur(4px);
            pointer-events: none;
        }

        .maintenance-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            max-width: 500px;
            width: 90%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2rem;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Main Content Area -->
    <div id="page-content" class="{{ isset($maintenance) && $maintenance ? 'blurred-content' : '' }}">
        <div class="container mx-auto px-4 py-8">
            <!-- Featured Products Section -->
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Featured Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $featuredProducts = [
                            [
                                'name' => 'Premium Wireless Headphones',
                                'price' => 249.99,
                                'image' => 'https://images.unsplash.com/photo-1505740420928-5e2f3e9ff12a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxfDB8MXxyYW5kb218MHx8aGVhZHBob25lc3x8fHx8fDE2ODY4MjQ5NTM&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1080'
                            ],
                            [
                                'name' => 'Smart Watch Pro',
                                'price' => 199.50,
                                'image' => 'https://images.unsplash.com/photo-1523860834782-a1f4dbe1c878?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxfDB8MXxyYW5kb218MHx8c21hcnR3YXRjaHx8fHx8fDE2ODY4MjUwMjM&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1080'
                            ],
                            [
                                'name' => 'Gaming Laptop Ultra',
                                'price' => 1299.00,
                                'image' => 'https://images.unsplash.com/photo-1588702547923-7093a6c3ba33?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxfDB8MXxyYW5kb218MHx8bGFwdG9wfHx8fHx8MTY4NjgyNTA4Nw&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1080'
                            ]
                        ];
                    @endphp

                    @foreach($featuredProducts as $product)
                        <div class="featured-product bg-white rounded-lg overflow-hidden shadow-lg">
                            <div class="relative">
                                <img 
                                    src="{{ $product['image'] }}" 
                                    alt="{{ $product['name'] }}" 
                                    class="w-full h-64 object-cover"
                                >
                            </div>
                            <div class="p-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $product['name'] }}</h3>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-lg font-bold text-green-600">${{ number_format($product['price'], 2) }}</span>
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- All Products Section -->
            <section>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">All Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="bg-white rounded-lg overflow-hidden shadow-md">
                            <img 
                                src="https://source.unsplash.com/random/400x300?product,{{ $i }}" 
                                alt="Product {{ $i }}" 
                                class="w-full h-48 object-cover"
                            >
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">Product {{ $i }}</h3>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-md font-bold text-green-600">${{ rand(50, 500) }}.{{ rand(10, 99) }}</span>
                                    <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </section>
        </div>
    </div>

    <!-- Maintenance Modal -->
    @if(isset($maintenance) && $maintenance)
    <div class="blur-overlay"></div>
    <div id="maintenance-modal" class="maintenance-modal">
        <div class="text-center">
            <i class="fas fa-tools text-6xl text-yellow-500 mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Site Under Maintenance</h2>
            <p class="text-gray-600 mb-6">
                We're currently upgrading our platform to serve you better. 
                We'll be back online shortly.
            </p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeModal()" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                    Understood
                </button>
            </div>
            <p class="mt-4 text-sm text-gray-500">Estimated time: 30 minutes</p>
        </div>
    </div>
    @endif

    <script>
        function closeModal() {
            document.getElementById('maintenance-modal').style.display = 'none';
            document.querySelector('.blur-overlay').style.display = 'none';
            document.getElementById('page-content').classList.remove('blurred-content');
        }
    </script>


<script type="text/javascript">
    (function(d, m){
        var kommunicateSettings = 
            {"appId":"3109e680a1d8e1076cca5b9992b54a064","popupWidget":true,"automaticChatOpenOnNavigation":true};
        var s = document.createElement("script"); s.type = "text/javascript"; s.async = true;
        s.src = "https://widget.kommunicate.io/v2/kommunicate.app";
        var h = document.getElementsByTagName("head")[0]; h.appendChild(s);
        window.kommunicate = m; m._globals = kommunicateSettings;
    })(document, window.kommunicate || {});
/* NOTE : Use web server to view HTML files as real-time update will not work if you directly open the HTML file in the browser. */
</script>
</body>
</html>
