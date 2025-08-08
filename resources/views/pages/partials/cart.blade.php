@extends('layouts.guest.index')
@section('title', 'KERANJANG-PT.RAJAWALI PRIMA ANDALAS')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary rounded-circle p-3 me-3">
                    <i class="bi bi-cart3 fs-3 text-white"></i>
                </div>
                <div>
                    <h1 class="mb-0 fw-bold text-dark">Keranjang Belanja</h1>
                    <p class="mb-0 text-muted">Kelola item belanja Anda</p>
                </div>
            </div>

            @if ($cartItems->isEmpty())
            <!-- Empty Cart State -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                    </div>
                    <h3 class="text-muted mb-3">Keranjang Anda Kosong</h3>
                    <p class="text-muted mb-4">Silakan tambahkan produk ke keranjang untuk melanjutkan belanja</p>
                    <a href="{{ route('product') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Mulai Belanja
                    </a>
                </div>
            </div>
            @else
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h5 class="mb-0 fw-semibold">Item dalam Keranjang</h5>
                        <small class="text-muted">{{ $cartItems->count() }} item tersedia</small>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="select-all-btn">
                        <i class="bi bi-check-all me-1"></i>Pilih Semua
                    </button>
                </div>
                <div class="card-body p-0">
                    @php $grandTotal = 0; @endphp
                    @foreach ($cartItems as $item)
                    @php
                    $subtotal = $item->produk->harga * $item->quantity;
                    $grandTotal += $subtotal;
                    @endphp
                    <div class="cart-item border-bottom" data-item-id="{{ $item->id }}"
                        data-price="{{ $item->produk->harga }}">
                        <div class="row align-items-center p-4 d-flex flex-wrap">
                            <!-- Checkbox -->
                            <div class="col-md-1 col-2">
                                <div class="form-check">
                                    <input class="form-check-input item-checkbox" type="checkbox"
                                        name="checkout_items[]" value="{{ $item->id }}" data-stock="{{ $item->produk->stok }}"
                                        data-quantity="{{ $item->quantity }}"
                                        id="item-{{ $item->id }}">
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="col-md-4 col-10">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3">
                                        <i class="bi bi-box-seam text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $item->produk->nama }}</h6>
                                        <small class="text-muted">ID: #{{ $item->produk_id }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-md-2 col-6 text-center">
                                <label class="form-label small text-muted mb-1">Harga</label>
                                <div class="fw-bold text-dark">{{ rupiah($item->produk->harga) }} / 500 Kg</div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-2 col-6">
                                <label class="form-label small text-muted mb-1">Jumlah</label>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary qty-btn qty-minus"
                                        type="button"><i class="bi bi-dash"></i></button>
                                    <input type="number" class="form-control text-center quantity-input"
                                        value="{{ $item->quantity }}" min="1" readonly>
                                    <button class="btn btn-outline-secondary qty-btn qty-plus" type="button"><i
                                            class="bi bi-plus"></i></button>
                                </div>
                            </div>

                            <!-- Berat -->
                            <div class="col-md-1 col-6 text-center">
                                <label class="form-label small text-muted mb-1">Berat</label>
                                <div class="fw-bold text-primary berat" data-base-weight="500">
                                    {{ format_stok(500 * $item->quantity) }}
                                </div>
                            </div>

                            <!-- Subtotal + Trash (Flexbox) -->
                            <div class="col-md-2 col-6 d-flex justify-content-between align-items-center">
                                <div>
                                    <label class="form-label small text-muted mb-1">Subtotal</label>
                                    <div class="fw-bold text-primary subtotal">{{ rupiah($subtotal) }}</div>
                                </div>
                                <form action="{{ route('cart.remove') }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus barang ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $item->produk_id }}">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Summary Section -->
            <div class="row">
                <div class="col-lg-4 ms-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 fw-semibold">
                                <i class="bi bi-receipt me-2"></i>Ringkasan Belanja
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Item Dipilih:</span>
                                <span class="fw-semibold" id="selected-count">0</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Berat:</span>
                                <span class="fw-semibold" id="total-weight">0 kg</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-semibold" id="subtotal-amount">Rp 0</span>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between mb-4">
                                <h6 class="mb-0">Total Pembayaran:</h6>
                                <h5 class="mb-0 text-primary fw-bold" id="total-amount">Rp 0</h5>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold"
                                id="checkout-btn" disabled>
                                <i class="bi bi-credit-card me-2"></i>Checkout Sekarang
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Transaksi aman dan terpercaya
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="bi bi-trash"></i> Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus item ini dari keranjang?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" id="deleteProductId">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .cart-item {
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        background-color: #f8f9fa;
    }

    .qty-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
    }

    .qty-btn:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    .quantity-input {
        border-left: 0;
        border-right: 0;
        font-weight: 600;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .card {
        transition: all 0.3s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .alert {
        border-left: 4px solid #198754;
    }

    @media (max-width: 768px) {
        .cart-item .row>div {
            margin-bottom: 0.5rem;
        }
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format currency function
        const formatRupiah = (number) => {
            return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        };

const validateStockPerItem = (cartItem) => {
    const checkbox = cartItem.querySelector('.item-checkbox');
    const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
    const stock = parseInt(checkbox.dataset.stock);

    const existingWarning = cartItem.querySelector('.stock-warning');

    if (quantity * 500 > stock) {
        checkbox.disabled = true;

        if (!existingWarning) {
            const warning = document.createElement('div');
            warning.textContent = 'Jumlah barang yang dibeli melebihi stok!';
            warning.style.color = 'red';
            warning.classList.add('stock-warning');
            cartItem.appendChild(warning);
        }
    } else {
        checkbox.disabled = false;

        if (existingWarning) {
            existingWarning.remove();
        }
    }
};

document.querySelectorAll('.cart-item').forEach(cartItem => {
    validateStockPerItem(cartItem); // validasi saat load
});

        document.getElementById('checkout-btn').addEventListener('click', function(event) {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedItems.length > 0) {
                const url = "{{ route('checkout.form') }}?items=" + selectedItems.join(',');
                window.location.href = url;
            }
        });

        // Update cart item quantity on server
        const updateQuantityOnServer = async (itemId, quantity) => {
            console.log('Sending update for item:', itemId, 'with quantity:', quantity);
            console.log('bisa')
            try {
                const response = await fetch('{{ route('cart.updateQty') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            item_id: itemId,
                            quantity: quantity
                        })
                    });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                console.log('Server response:', data); // ← log hasil dari server

                return data;
            } catch (error) {
                console.error('Error updating quantity:', error);
                showAlert('Gagal mengupdate jumlah item', 'danger');
            }
        };


        // Remove item from cart

        // Show alert message
        const showAlert = (message, type = 'success') => {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'} fs-5 me-2"></i>
                    <span>${message}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const container = document.querySelector('.container');
            const header = container.querySelector('.d-flex.align-items-center.mb-4');
            container.insertBefore(alertDiv, header.nextSibling);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        };

        // Update subtotal for specific item
        const updateItemSubtotal = (cartItem) => {
            const price = parseInt(cartItem.dataset.price);
            const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
            const subtotal = price * quantity;

            // Update subtotal display
            const subtotalElement = cartItem.querySelector('.subtotal');
            subtotalElement.textContent = formatRupiah(subtotal);

            console.log('Updated subtotal:', {
                price: price,
                quantity: quantity,
                subtotal: subtotal,
                formatted: formatRupiah(subtotal)
            });
        };

        // Fungsi update berat per item
        const formatWeight = (kg) => {
            if (kg >= 1000) {
                const ton = kg / 1000;
                return ton.toLocaleString('id-ID') + ' ton';
            }
            return kg.toLocaleString('id-ID') + ' kg';
        };

        const updateItemWeight = (cartItem) => {
            const baseWeight = parseInt(cartItem.querySelector('.berat').dataset.baseWeight);
            const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
            const totalWeight = baseWeight * quantity;
            const weightElement = cartItem.querySelector('.berat');
            weightElement.textContent = formatWeight(totalWeight);
        };

        // Calculate and update total
        const updateTotals = () => {
            let selectedCount = 0;
            let totalAmount = 0;
            let totalWeight = 0;

            document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                selectedCount++;
                const cartItem = checkbox.closest('.cart-item');
                const price = parseInt(cartItem.dataset.price);
                const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
                const baseWeight = parseInt(cartItem.querySelector('.berat').dataset.baseWeight);

                const itemSubtotal = price * quantity;
                totalAmount += itemSubtotal;
                totalWeight += baseWeight * quantity;
            });

            // Update UI jumlah item & total harga
            document.getElementById('selected-count').textContent = selectedCount;
            document.getElementById('subtotal-amount').textContent = formatRupiah(totalAmount);
            document.getElementById('total-amount').textContent = formatRupiah(totalAmount);
            document.getElementById('total-weight').textContent = formatWeight(totalWeight);

            // Enable/disable checkout button
            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.disabled = selectedCount === 0;
            checkoutBtn.classList.toggle('btn-success', selectedCount > 0);
            checkoutBtn.classList.toggle('btn-secondary', selectedCount === 0);
        };


        // Quantity control handlers
        document.querySelectorAll('.qty-minus').forEach(btn => {
            btn.addEventListener('click', async function() {
                const cartItem = this.closest('.cart-item');
                const quantityInput = cartItem.querySelector('.quantity-input');
                const currentQty = parseInt(quantityInput.value);

                if (currentQty > 1) {
                    const newQty = currentQty - 1;
                    quantityInput.value = newQty;

                    // Update subtotal & berat
                    updateItemSubtotal(cartItem);
                    updateItemWeight(cartItem);
                    validateStockPerItem(cartItem);
                    updateTotals();

                    // Update ke server
                    const itemId = cartItem.dataset.itemId;
                    await updateQuantityOnServer(itemId, newQty);
                }
            });
        });

        document.querySelectorAll('.qty-plus').forEach(btn => {
            btn.addEventListener('click', async function() {
                const cartItem = this.closest('.cart-item');
                const quantityInput = cartItem.querySelector('.quantity-input');
                const currentQty = parseInt(quantityInput.value);
                const newQty = currentQty + 1;
                quantityInput.value = newQty;

                // Update subtotal & berat
                updateItemSubtotal(cartItem);
                updateItemWeight(cartItem);
                validateStockPerItem(cartItem);
                updateTotals();

                // Update ke server
                const itemId = cartItem.dataset.itemId;
                await updateQuantityOnServer(itemId, newQty);
            });
        });

        // Checkbox change handlers
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateTotals);
        });

        // Select all button
        document.getElementById('select-all-btn')?.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(cb => {
                cb.checked = !allChecked;
            });

            this.innerHTML = allChecked ?
                '<i class="bi bi-check-all me-1"></i>Pilih Semua' :
                '<i class="bi bi-x-square me-1"></i>Batal Pilih';

            updateTotals();
        });


        document.getElementById('checkout-btn').addEventListener('click', function(event) {
            const form = document.getElementById('checkout-form');

            // Hapus input lama
            form.querySelectorAll('input[name="checkout_items[]"]').forEach(el => el.remove());

            // Tambah input baru untuk item yang dicentang
            document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'checkout_items[]';
                input.value = cb.value;
                form.appendChild(input);
            });
        });

        // Initialize totals on page load
        updateTotals();
    });
</script>
@endsection
