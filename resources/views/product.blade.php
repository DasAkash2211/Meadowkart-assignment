<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MeadowKart | Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
  </style>
</head>
<body class="text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow-md py-4 px-8 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-green-600">MeadowKart</h1>
    <nav class="space-x-6 flex items-center">
      <a href="#" class="hover:text-green-600">Home</a>
      <a href="#" class="hover:text-green-600">Shop</a>
      <a href="#" class="hover:text-green-600">Categories</a>
      <a href="#" class="hover:text-green-600">Contact</a>

      <!-- Cart -->
      <div class="relative ml-4">
        <button id="cart-btn" class="relative">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-green-700">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 3h1.386c.51 0 .955.343 1.09.835l.383 1.437m0 0L6.75 14.25h10.5l1.875-7.5H6.75m-1.5 0h16.5m-16.5 0L4.11 5.272A1.125 1.125 0 013.75 4.5H2.25M6 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zm12 0a.75.75 0 100-1.5.75.75 0 000 1.5z" />
          </svg>
          <span id="cart-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5">0</span>
        </button>
      </div>
    </nav>
  </header>

  <!-- Hero -->
  <section class="bg-green-100 py-12 text-center">
    <h2 class="text-4xl font-bold text-green-800 mb-3">Fresh From The Fields</h2>
    <p class="text-gray-700 text-lg">Browse our latest fruits, vegetables, and dairy products</p>
  </section>

  <!-- Product Grid -->
  <section class="px-8 py-12">
    <h3 class="text-2xl font-semibold mb-6 border-b-4 border-green-500 inline-block">Products</h3>
    <div id="product-grid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4"></div>
  </section>

  <!-- Cart Modal -->
  <div id="cart-modal" class="fixed inset-0 hidden bg-black bg-opacity-50 items-center justify-center z-50">
    <div class="bg-white rounded-xl w-[480px] max-h-[80vh] overflow-y-scroll shadow-xl p-6 relative flex flex-col">
        <h2 class="text-xl font-semibold mb-4">Your Cart</h2>
      <button id="close-cart" class="absolute top-3 right-4 text-gray-600 hover:text-black text-xl">&times;</button>
      <div id="cart-items" class="space-y-3"></div>
      <div class="border-t mt-4 pt-4 flex justify-between text-lg font-semibold">
        <span>Total:</span>
        <span id="cart-total">₹0.00</span>
      </div>
      <button id="checkout-btn" class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">
        Checkout
      </button>
          </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-6 text-center">
    <p>&copy; 2025 MeadowKart. All rights reserved.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const products = @json($product);
  
    const grid = document.getElementById('product-grid');
    const cartCount = document.getElementById('cart-count');
    const cartModal = document.getElementById('cart-modal');
    const closeCart = document.getElementById('close-cart');
    const cartBtn = document.getElementById('cart-btn');
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
  
    const MAX_QTY = 5; // 🔒 maximum quantity allowed per product
  
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
  
    // 🧩 Render product cards
    products.forEach(p => {
      const card = document.createElement('div');
      card.className = "bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:scale-105";
      card.innerHTML = `
        <img src="/${p.image ?? 'images/placeholder.jpg'}" alt="${p.product}" class="w-full h-48 object-cover">
        <div class="p-4">
          <h4 class="text-lg font-semibold">${p.product}</h4>
          <p class="text-gray-500 text-sm mb-1">MRP: <s>₹${parseFloat(p.mrp).toFixed(2)}</s></p>
          <p class="text-green-700 font-semibold text-xl mb-2">₹${parseFloat(p.selling_price).toFixed(2)}</p>
          <p class="text-sm text-red-500 mb-3">Save ${p.discount}%</p>
          <button 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md w-full add-to-cart" 
            data-id="${p.id}">
            Add to Cart
          </button>
        </div>
      `;
      grid.appendChild(card);
    });
  
    // 🛒 Add to Cart button
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', e => {
        const id = parseInt(e.target.dataset.id);
        const product = products.find(p => p.id === id);
        const existing = cart.find(i => i.id === id);
        if (existing) {
          if (existing.qty < MAX_QTY) existing.qty++;
        } else {
          cart.push({
            id: product.id,
            product: product.product,
            price: parseFloat(product.selling_price),
            image: product.image,
            qty: 1
          });
        }
        updateCart();
      });
    });
  
    function saveCart() {
      localStorage.setItem('cart', JSON.stringify(cart));
    }
  
    function updateCart() {
      cartCount.textContent = cart.reduce((sum, i) => sum + i.qty, 0);
      renderCartItems();
      saveCart();
    }
  
    // 🧾 Render cart modal
    function renderCartItems() {
      cartItems.innerHTML = '';
      let total = 0;
  
      if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-center text-gray-500 py-4">Your cart is empty</p>';
        cartTotal.textContent = '₹0.00';
        return;
      }
  
      cart.forEach((item, index) => {
        total += item.price * item.qty;
        const plusDisabled = item.qty >= MAX_QTY ? 'opacity-50 cursor-not-allowed' : '';
        const div = document.createElement('div');
        div.className = "flex justify-between items-start border-b pb-3";
        div.innerHTML = `
          <div class="flex-1 pr-3 overflow-hidden">
            <h4 class="font-semibold text-gray-800 leading-snug break-words">${item.product}</h4>
            <p class="text-sm text-gray-500 mt-1">₹${item.price.toFixed(2)} × ${item.qty}</p>
          </div>
          <div class="flex-shrink-0 flex items-center space-x-2">
            <button class="bg-gray-200 px-2 rounded hover:bg-gray-300" onclick="changeQty(${index}, -1)">−</button>
            <span>${item.qty}</span>
            <button class="bg-gray-200 px-2 rounded hover:bg-gray-300 ${plusDisabled}" ${item.qty >= MAX_QTY ? 'disabled' : ''} onclick="changeQty(${index}, 1)">+</button>
            <button class="text-red-600 hover:text-red-800 ml-1" onclick="removeItem(${index})">🗑️</button>
          </div>
        `;
        cartItems.appendChild(div);
      });
  
      cartTotal.textContent = '₹' + total.toFixed(2);
    }
  
    function changeQty(index, change) {
      cart[index].qty += change;
      if (cart[index].qty <= 0) cart.splice(index, 1);
      if (cart[index] && cart[index].qty > MAX_QTY) cart[index].qty = MAX_QTY;
      updateCart();
    }
  
    function removeItem(index) {
      cart.splice(index, 1);
      updateCart();
    }
  
    // 🛒 Modal toggle
    cartBtn.onclick = () => { cartModal.classList.remove('hidden'); cartModal.classList.add('flex'); };
    closeCart.onclick = () => { cartModal.classList.add('hidden'); };
    cartModal.onclick = e => { if (e.target === cartModal) cartModal.classList.add('hidden'); };
  
    // 🟢 Initialize
    updateCart();


    // 🛍️ Checkout click event
document.getElementById('checkout-btn').addEventListener('click', () => {
  if (cart.length === 0) {
    Swal.fire({
      icon: 'info',
      title: 'Your cart is empty',
      text: 'Please add some products before checking out!',
      confirmButtonColor: '#16a34a'
    });
    return;
  }

  const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0).toFixed(2);
  const productList = cart.map(item => `${item.product} (x${item.qty}) - ₹${(item.price * item.qty).toFixed(2)}`).join('<br>');

  Swal.fire({
    title: 'Thank you for your order! 🎉',
    html: `
      <div class="text-left">
        <p class="font-semibold mb-2">Your Order:</p>
        <div class="text-sm text-gray-700 mb-3">${productList}</div>
        <p class="text-lg font-semibold text-green-700 mt-2">Total: ₹${total}</p>
      </div>
    `,
    icon: 'success',
    confirmButtonText: 'Close',
    confirmButtonColor: '#16a34a',
    width: 500,
  });

  // 🧹 Optionally clear cart after checkout
  cart = [];
  updateCart();
});
  </script>
</body>
</html>