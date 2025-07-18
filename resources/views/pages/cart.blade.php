@extends('user.index')
@section('title', 'CONTACT-PT.RAJAWALI PRIMA ANDALAS')
@section('content')

<style>
    .cart-item {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s;
    }

    .cart-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .cart-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    .product-name {
        color: var(--dark-green);
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .product-price {
        color: var(--primary-green);
        font-weight: bold;
        font-size: 1.2rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .quantity-btn:hover {
        background: var(--light-green);
        border-color: var(--primary-green);
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0.5rem;
    }

    .cart-summary {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 100px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
        font-weight: bold;
        font-size: 1.2rem;
        color: var(--dark-green);
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .empty-cart i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
</style>
<div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
    <div class="container position-relative">
        <h1>Cart</h1>
        <p>
            Home
            /
            Cart
        </p>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.html">Home</a></li>
                <li class="current">Blog</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
                <h3>Produk dalam Keranjang</h3>
                <button class="btn btn-outline-secondary" onclick="clearCart()">
                    <i class="bi bi-trash"></i> Kosongkan Keranjang
                </button>
            </div>

            <div id="cartItems">
                <!-- Cart Item 1 -->
                <div class="cart-item" data-product-id="1">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><rect fill='%23FFD700' width='200' height='200'/><text x='100' y='100' text-anchor='middle' fill='%23333' font-size='14'>CPO</text></svg>" alt="Crude Palm Oil" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <div class="product-name">Crude Palm Oil (CPO)</div>
                            <div class="text-muted">Minyak kelapa sawit mentah berkualitas tinggi</div>
                            <div class="text-muted">Kemasan: 1 Ton</div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-price">Rp 12.500.000</div>
                            <div class="text-muted small">per ton</div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(1, -1)">-</button>
                                <input type="number" class="quantity-input" value="2" min="1" onchange="updateQuantity(1, this.value, true)">
                                <button class="quantity-btn" onclick="updateQuantity(1, 1)">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="fw-bold" id="itemTotal1">Rp 25.000.000</div>
                            <button class="btn btn-outline-danger btn-sm mt-2" onclick="removeItem(1)">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="cart-item" data-product-id="2">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><rect fill='%23F4A460' width='200' height='200'/><text x='100' y='100' text-anchor='middle' fill='%23333' font-size='14'>PKO</text></svg>" alt="Palm Kernel Oil" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <div class="product-name">Palm Kernel Oil</div>
                            <div class="text-muted">Minyak inti kelapa sawit premium</div>
                            <div class="text-muted">Kemasan: 1 Ton</div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-price">Rp 18.000.000</div>
                            <div class="text-muted small">per ton</div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(2, -1)">-</button>
                                <input type="number" class="quantity-input" value="1" min="1" onchange="updateQuantity(2, this.value, true)">
                                <button class="quantity-btn" onclick="updateQuantity(2, 1)">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="fw-bold" id="itemTotal2">Rp 18.000.000</div>
                            <button class="btn btn-outline-danger btn-sm mt-2" onclick="removeItem(2)">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cart Item 3 -->
                <div class="cart-item" data-product-id="3">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><rect fill='%23DEB887' width='200' height='200'/><text x='100' y='100' text-anchor='middle' fill='%23333' font-size='14'>PKM</text></svg>" alt="Palm Kernel Meal" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <div class="product-name">Palm Kernel Meal</div>
                            <div class="text-muted">Bungkil inti kelapa sawit untuk pakan ternak</div>
                            <div class="text-muted">Kemasan: 1 Ton</div>
                        </div>
                        <div class="col-md-2">
                            <div class="product-price">Rp 3.500.000</div>
                            <div class="text-muted small">per ton</div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(3, -1)">-</button>
                                <input type="number" class="quantity-input" value="5" min="1" onchange="updateQuantity(3, this.value, true)">
                                <button class="quantity-btn" onclick="updateQuantity(3, 1)">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="fw-bold" id="itemTotal3">Rp 17.500.000</div>
                            <button class="btn btn-outline-danger btn-sm mt-2" onclick="removeItem(3)">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Cart Message (Hidden by default) -->
            <div id="emptyCart" class="empty-cart" style="display: none;">
                <i class="bi bi-cart-x"></i>
                <h4>Keranjang Belanja Kosong</h4>
                <p>Belum ada produk dalam keranjang belanja Anda.</p>
                <a href="#product" class="btn btn-primary">Mulai Belanja</a>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="cart-summary">
                <h4 class="mb-3">Ringkasan Pesanan</h4>

                <div class="summary-row">
                    <span>Subtotal (<span id="totalItems">3</span> produk)</span>
                    <span id="subtotal">Rp 60.500.000</span>
                </div>

                <div class="summary-row">
                    <span>Biaya Pengiriman</span>
                    <span id="shipping">Rp 500.000</span>
                </div>

                <div class="summary-row">
                    <span>Pajak (10%)</span>
                    <span id="tax">Rp 6.100.000</span>
                </div>

                <div class="summary-row">
                    <span>Total</span>
                    <span id="total">Rp 67.100.000</span>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary w-100 mb-2" onclick="checkout()">
                        <i class="bi bi-credit-card"></i> Checkout
                    </button>
                    <button class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Lanjut Belanja
                    </button>
                </div>

                <div class="mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Kode Voucher" id="voucherCode">
                        <button class="btn btn-outline-secondary" onclick="applyVoucher()">Gunakan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Cart data
    let cartData = {
        1: {
            name: "Crude Palm Oil (CPO)",
            price: 12500000,
            quantity: 2
        },
        2: {
            name: "Palm Kernel Oil",
            price: 18000000,
            quantity: 1
        },
        3: {
            name: "Palm Kernel Meal",
            price: 3500000,
            quantity: 5
        }
    };

    // Update quantity
    function updateQuantity(productId, change, isAbsolute = false) {
        if (isAbsolute) {
            cartData[productId].quantity = parseInt(change);
        } else {
            cartData[productId].quantity += change;
        }

        if (cartData[productId].quantity < 1) {
            cartData[productId].quantity = 1;
        }

        // Update UI
        const quantityInput = document.querySelector(`[data-product-id="${productId}"] .quantity-input`);
        quantityInput.value = cartData[productId].quantity;

        // Update item total
        const itemTotal = cartData[productId].price * cartData[productId].quantity;
        document.getElementById(`itemTotal${productId}`).textContent = formatCurrency(itemTotal);

        updateSummary();
    }

    // Remove item from cart
    function removeItem(productId) {
        if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
            delete cartData[productId];
            document.querySelector(`[data-product-id="${productId}"]`).remove();
            updateSummary();

            // Check if cart is empty
            if (Object.keys(cartData).length === 0) {
                document.getElementById('cartItems').style.display = 'none';
                document.getElementById('emptyCart').style.display = 'block';
            }
        }
    }

    // Clear entire cart
    function clearCart() {
        if (confirm('Apakah Anda yakin ingin mengosongkan keranjang belanja?')) {
            cartData = {};
            document.getElementById('cartItems').style.display = 'none';
            document.getElementById('emptyCart').style.display = 'block';
            updateSummary();
        }
    }

    // Update summary
    function updateSummary() {
        let subtotal = 0;
        let totalItems = 0;

        Object.values(cartData).forEach(item => {
            subtotal += item.price * item.quantity;
            totalItems += item.quantity;
        });

        const shipping = totalItems > 0 ? 500000 : 0;
        const tax = subtotal * 0.1;
        const total = subtotal + shipping + tax;

        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('shipping').textContent = formatCurrency(shipping);
        document.getElementById('tax').textContent = formatCurrency(tax);
        document.getElementById('total').textContent = formatCurrency(total);
        document.getElementById('cartBadge').textContent = totalItems;
    }

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Apply voucher
    function applyVoucher() {
        const voucherCode = document.getElementById('voucherCode').value;
        if (voucherCode) {
            // Simulate voucher application
            if (voucherCode === 'DISKON10') {
                alert('Voucher berhasil diterapkan! Anda mendapat diskon 10%');
            } else {
                alert('Kode voucher tidak valid');
            }
        }
    }

    // Checkout
    function checkout() {
        if (Object.keys(cartData).length === 0) {
            alert('Keranjang belanja kosong');
            return;
        }

        alert('Mengarahkan ke halaman checkout...');
        // Here you would typically redirect to checkout page
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            navbar.style.backdropFilter = 'blur(10px)';
        } else {
            navbar.style.backgroundColor = 'white';
            navbar.style.backdropFilter = 'none';
        }
    });

    // Initialize
    updateSummary();
</script>
@endsection