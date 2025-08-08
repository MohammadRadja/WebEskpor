(function () {
    "use strict";

    /** === SCROLL EFFECTS === */
    function toggleScrolled() {
        const body = document.body;
        const header = document.querySelector("#header");
        if (
            !header?.classList.contains("scroll-up-sticky") &&
            !header?.classList.contains("sticky-top") &&
            !header?.classList.contains("fixed-top")
        )
            return;

        window.scrollY > 100
            ? body.classList.add("scrolled")
            : body.classList.remove("scrolled");
    }

    /** === STICKY HEADER === */
    function handleStickyHeader() {
        const header = document.querySelector("#header");
        if (!header?.classList.contains("scroll-up-sticky")) return;

        let lastScrollTop = 0;

        window.addEventListener("scroll", () => {
            const scrollTop =
                window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > header.offsetHeight) {
                header.style.top = `-${header.offsetHeight + 50}px`;
                header.style.position = "sticky";
            } else if (scrollTop > header.offsetHeight) {
                header.style.top = "0";
                header.style.position = "sticky";
            } else {
                header.style.removeProperty("top");
                header.style.removeProperty("position");
            }

            lastScrollTop = scrollTop;
        });
    }

    /** === MOBILE NAV TOGGLE === */
    function initMobileNavToggle() {
        const toggleBtn = document.querySelector(".mobile-nav-toggle");
        if (!toggleBtn) return;

        toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("mobile-nav-active");
            toggleBtn.classList.toggle("bi-list");
            toggleBtn.classList.toggle("bi-x");
        });

        document.querySelectorAll("#navmenu a").forEach((link) => {
            link.addEventListener("click", () => {
                if (document.body.classList.contains("mobile-nav-active")) {
                    document.body.classList.remove("mobile-nav-active");
                    toggleBtn.classList.add("bi-list");
                    toggleBtn.classList.remove("bi-x");
                }
            });
        });

        document
            .querySelectorAll(".navmenu .toggle-dropdown")
            .forEach((toggle) => {
                toggle.addEventListener("click", (e) => {
                    e.preventDefault();
                    const parent = toggle.parentNode;
                    parent.classList.toggle("active");
                    parent.nextElementSibling?.classList.toggle(
                        "dropdown-active"
                    );
                });
            });
    }

    /** === PRELOADER === */
    function removePreloader() {
        const preloader = document.querySelector("#preloader");
        if (preloader) {
            window.addEventListener("load", () => preloader.remove());
        }
    }

    /** === SCROLL TO TOP === */
    function setupScrollTopButton() {
        const scrollTopBtn = document.querySelector(".scroll-top");

        function toggleScrollTop() {
            if (scrollTopBtn) {
                scrollTopBtn.classList.toggle("active", window.scrollY > 100);
            }
        }

        if (scrollTopBtn) {
            scrollTopBtn.addEventListener("click", (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        }

        document.addEventListener("scroll", toggleScrollTop);
        window.addEventListener("load", toggleScrollTop);
    }

    /** === AOS === */
    function initAOS() {
        $(document).ready(function () {
            AOS.init({
                duration: 600,
                easing: "ease-in-out",
                once: true,
                mirror: false,
            });

            setTimeout(() => {
                AOS.refresh();
            }, 500);
        });
    }

    /** === GLIGHTBOX === */
    function initLightbox() {
        if (typeof GLightbox !== "undefined") {
            GLightbox({ selector: ".glightbox" });
        }
    }

    /** === SWIPER === */
    function initSwiper() {
        const wrappers = document.querySelectorAll(".swipper");

        wrappers.forEach(function (wrapper) {
            const sliderId = wrapper.dataset.sliderId;
            const swiperElement = wrapper.querySelector(".swiper");
            const baseId = sliderId?.replace("-slider", "");
            const prevButton = document.getElementById(`${baseId}-prev`);
            const nextButton = document.getElementById(`${baseId}-next`);
            const perPage = parseInt(wrapper.dataset.perPage) || 3;
            const rows = parseInt(wrapper.dataset.rows) || 2;

            if (!swiperElement) return;

            try {
                const swiper = new Swiper(swiperElement, {
                    slidesPerView: perPage,
                    slidesPerGroup: perPage * rows,
                    spaceBetween: 16,
                    loop: false,
                    grid: {
                        rows: rows,
                        fill: "row",
                    },
                    navigation: {
                        nextEl: nextButton,
                        prevEl: prevButton,
                    },
                    pagination: false,
                    breakpoints: {
                        992: {
                            slidesPerView: perPage,
                            grid: { rows: rows },
                            slidesPerGroup: perPage * rows,
                        },
                        768: {
                            slidesPerView: 1,
                            grid: { rows: rows },
                            slidesPerGroup: rows,
                        },
                        576: {
                            slidesPerView: 1,
                            grid: { rows: rows },
                            slidesPerGroup: rows,
                        },
                    },
                });

                const indicatorsContainer = wrapper.querySelector(
                    ".carousel-indicators-banner"
                );

                if (indicatorsContainer) {
                    indicatorsContainer.innerHTML = "";

                    const totalItems =
                        swiperElement.querySelectorAll(".swiper-slide").length;
                    const itemsPerPage = perPage * rows;
                    const totalPages = Math.ceil(totalItems / itemsPerPage);

                    for (let i = 0; i < totalPages; i++) {
                        const li = document.createElement("li");
                        li.classList.add("page-item");

                        const btn = document.createElement("button");
                        btn.classList.add("page-link");
                        btn.textContent = i + 1;

                        btn.addEventListener("click", () => {
                            swiper.slideTo(i * swiper.params.slidesPerGroup);
                            updateIndicators(
                                i,
                                indicatorsContainer.querySelectorAll("button")
                            );
                        });

                        li.appendChild(btn);
                        indicatorsContainer.appendChild(li);
                    }

                    const indicators =
                        indicatorsContainer.querySelectorAll("button");

                    swiper.on("slideChangeTransitionEnd", () => {
                        const activePage = Math.floor(
                            swiper.realIndex / swiper.params.slidesPerGroup
                        );
                        updateIndicators(activePage, indicators);
                    });

                    updateIndicators(0, indicators);
                }

                function updateIndicators(activeIndex, indicators) {
                    indicators.forEach((btn, idx) => {
                        btn.classList.toggle("active", idx === activeIndex);
                    });
                }
            } catch (err) {
                console.error(`[Swiper Error]`, err);
            }
        });
    }

    /** === CAROUSEL INDICATORS AUTO === */
    function autoCarouselIndicators() {
        document
            .querySelectorAll(".carousel-indicators")
            .forEach((indicators) => {
                const carousel = indicators.closest(".carousel");
                carousel
                    ?.querySelectorAll(".carousel-item")
                    .forEach((item, index) => {
                        indicators.innerHTML += `
                    <li data-bs-target="#${
                        carousel.id
                    }" data-bs-slide-to="${index}" ${
                            index === 0 ? 'class="active"' : ""
                        }></li>
                `;
                    });
            });
    }

    /** === UNIVERSAL MODAL CRUD === */
    function initUniversalModal() {
        const modalEl = document.getElementById("universalModal");
        const modalForm = document.getElementById("universalForm");
        const modalTitle = document.getElementById("modalTitle");
        const modalBody = document.getElementById("modalBody");

        if (!modalEl || !modalForm || !modalTitle || !modalBody) {
            console.warn("[initUniversalModal] Modal element not found.");
            return;
        }

        let currentUrl = "";
        let currentMethod = "POST";
        const modal = new bootstrap.Modal(modalEl);

        document.body.addEventListener("click", (e) => {
            const btn = e.target.closest("[data-crud]");
            if (!btn) return;

            const action = btn.dataset.crud;
            const url = btn.dataset.url;
            const title = btn.dataset.title || "Form";
            const method = btn.dataset.method || "POST";
            const fieldsRaw = btn.dataset.fields;

            console.log(
                `[Modal Trigger] Action: ${action}, URL: ${url}, Method: ${method}`
            );

            if (action === "add" || action === "edit") {
                modalTitle.textContent = title;
                modalBody.innerHTML = "";
                currentUrl = url;
                currentMethod = method;

                let fields = {};
                try {
                    fields = JSON.parse(fieldsRaw);
                    console.log("[Parsed Fields]", fields);
                } catch (err) {
                    console.error(
                        "[initUniversalModal] Failed to parse fields JSON:",
                        fieldsRaw,
                        err
                    );
                    return;
                }

                Object.entries(fields).forEach(([name, config]) => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "mb-3";

                    const label = document.createElement("label");
                    label.className = "form-label";
                    label.textContent = config.label;

                    let input;
                    if (config.type === "select" && config.options) {
                        input = document.createElement("select");
                        input.className = "form-control";
                        input.name = name;

                        let optionList = [];

                        if (Array.isArray(config.options)) {
                            optionList = config.options;
                        } else if (
                            typeof config.options === "string" &&
                            window[config.options]
                        ) {
                            optionList = window[config.options];
                        }

                        optionList.forEach((opt) => {
                            const option = document.createElement("option");
                            const val = opt.value ?? opt;
                            const label = opt.label ?? opt;

                            option.value = val;
                            option.textContent = label;

                            if (val == config.value) {
                                option.selected = true;
                            }

                            input.appendChild(option);
                        });
                    } else if (config.type === "textarea") {
                        input = document.createElement("textarea");
                        input.className = "form-control";
                        input.name = name;
                        input.textContent = config.value || "";
                    } else {
                        input = document.createElement("input");
                        input.type = config.type || "text";
                        input.className = "form-control";
                        input.name = name;
                        input.value = config.value || "";
                    }

                    wrapper.append(label, input);
                    modalBody.appendChild(wrapper);
                });

                const submitBtn = modalForm.querySelector(
                    "button[type='submit']"
                );
                submitBtn.textContent = "Simpan";
                submitBtn.classList.remove("btn-danger");
                submitBtn.classList.add("btn-success");

                console.log("[Modal Opened] Ready for form submission.");
                modal.show();
            }

            if (action === "delete") {
                Swal.fire({
                    title: "Yakin ingin menghapus?",
                    text: "Data yang dihapus tidak dapat dikembalikan.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log("[Delete Request] Sending DELETE to", url);
                        fetch(url, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content,
                                "Content-Type": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                            },
                            body: JSON.stringify({ _method: "DELETE" }),
                        })
                            .then((res) => {
                                if (!res.ok) throw res;
                                return res.text();
                            })
                            .then(() => {
                                console.log("[Delete Success]");
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: "Data berhasil dihapus.",
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                                setTimeout(() => location.reload(), 500);
                            })
                            .catch((err) => {
                                console.error("[Delete Error]", err);
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal",
                                    text: "Terjadi kesalahan saat menghapus data.",
                                });
                            });
                    }
                });
            }
        });

        modalForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            const formData = new FormData(modalForm);
            if (currentMethod !== "POST") {
                formData.append("_method", currentMethod);
            }

            console.log(
                `[Form Submit] URL: ${currentUrl}, Method: ${currentMethod}`
            );
            for (let [key, value] of formData.entries()) {
                console.log(` - ${key}:`, value);
            }

            try {
                const res = await fetch(currentUrl, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: formData,
                });

                const contentType = res.headers.get("Content-Type") || "";

                if (!res.ok) {
                    if (
                        res.status === 422 &&
                        contentType.includes("application/json")
                    ) {
                        const errorData = await res.json();
                        const errorMessages = Object.values(errorData.errors)
                            .flat()
                            .join("<br>");
                        console.warn("[Validation Failed]", errorData.errors);
                        throw { type: "validation", message: errorMessages };
                    } else {
                        const errorText = await res.text();
                        console.error("[Server Error]", errorText);
                        throw { type: "server", message: errorText };
                    }
                }

                console.log("[Form Success]");
                modal.hide();
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text:
                        currentMethod === "POST"
                            ? "Data berhasil ditambahkan."
                            : "Data berhasil diperbarui.",
                    timer: 2000,
                    showConfirmButton: false,
                });
                setTimeout(() => location.reload(), 500);
            } catch (err) {
                if (err.type === "validation") {
                    Swal.fire({
                        icon: "warning",
                        title: "Validasi Gagal",
                        html: err.message,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: err.message,
                    });
                }
            }
        });
    }

    /** === SUMMERNOTE INIT === */
    function initSummernote() {
        if (typeof $ !== "undefined" && $.fn.summernote) {
            $(".summernote").summernote({ height: 200 });
        }
    }

    /** === SIDEBAR TOGGLE === */
    function initSidebarToggle() {
        const toggleButton = document.getElementById("sidebarToggle");
        const body = document.body;

        // Saat halaman dimuat, cek preferensi
        if (localStorage.getItem("sb|sidebar-toggle") === "toggled") {
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.removeItem("sb|sidebar-toggle");
        }

        if (toggleButton) {
            toggleButton.addEventListener("click", function (e) {
                e.preventDefault();
                body.classList.toggle("sb-sidenav-toggled");
                // Simpan preferensi di localStorage
                if (body.classList.contains("sb-sidenav-toggled")) {
                    localStorage.setItem("sb|sidebar-toggle", "toggled");
                }
                if (!body.classList.contains("sb-sidenav-toggled")) {
                    localStorage.setItem("sb|sidebar-toggle", "toggled");
                }
            });
        }
    }

    /** === CHART KEUANGAN === */
    function initChartKeuangan() {
        const chartEl = document.getElementById("chartKeuangan");
        if (!chartEl) return;

        const rawData = chartEl.dataset.chart;
        if (!rawData) return;

        let chartData;
        try {
            chartData = JSON.parse(rawData);
        } catch (e) {
            console.error("[Chart Error] Gagal parse data chart:", e);
            return;
        }

        const labels = chartData.map((d) => d.bulan);
        const pendapatan = chartData.map((d) => d.pendapatan);
        const pengeluaran = chartData.map((d) => d.pengeluaran);
        const bersih = chartData.map((d) => d.bersih);

        const ctx = chartEl.getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Pendapatan",
                        data: pendapatan,
                        borderColor: "green",
                        backgroundColor: "rgba(0,128,0,0.05)",
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                    },
                    {
                        label: "Pengeluaran",
                        data: pengeluaran,
                        borderColor: "red",
                        backgroundColor: "rgba(255,0,0,0.05)",
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                    },
                    {
                        label: "Pendapatan Bersih",
                        data: bersih,
                        borderColor: "blue",
                        backgroundColor: "rgba(0,0,255,0.05)",
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                let val = ctx.raw ?? 0;
                                return (
                                    "Rp " + Number(val).toLocaleString("id-ID")
                                );
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function (val) {
                                return (
                                    "Rp " + Number(val).toLocaleString("id-ID")
                                );
                            },
                        },
                    },
                },
            },
        });
    }

    /** === CHART PANEN & TANAMAN === */
    function initChartPanenTanaman() {
        const chartEl = document.getElementById("chartPanenTanaman");
        if (!chartEl) return;

        let chartData;
        try {
            chartData = JSON.parse(chartEl.dataset.chart);
        } catch (e) {
            console.error(
                "[Chart Error] Gagal parse data chart Panen & Tanaman:",
                e
            );
            return;
        }

        const labels = chartData.map((d) => d.bulan);
        const dataPanen = chartData.map((d) => d.panen);
        const dataEksternal = chartData.map((d) => d.eksternal);
        const dataBibit = chartData.map((d) => d.bibit);

        new Chart(chartEl.getContext("2d"), {
            type: "line",
            data: {
                labels,
                datasets: [
                    {
                        label: "Jumlah Panen",
                        data: dataPanen,
                        borderColor: "#28a745",
                        backgroundColor: "rgba(40,167,69,0.2)",
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                    },
                    {
                        label: "Produk Eksternal",
                        data: dataEksternal,
                        borderColor: "#17a2b8",
                        backgroundColor: "rgba(23,162,184,0.2)",
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                    },
                    {
                        label: "Stok Bibit",
                        data: dataBibit,
                        borderColor: "#ffc107",
                        backgroundColor: "rgba(255,193,7,0.2)",
                        fill: false,
                        tension: 0.3,
                        borderWidth: 3,
                        pointRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                let val = ctx.raw;
                                if (
                                    ctx.dataset.label.includes("Panen") ||
                                    ctx.dataset.label.includes("Eksternal")
                                ) {
                                    return val >= 1000
                                        ? (val / 1000).toFixed(2) + " ton"
                                        : val + " kg";
                                } else if (
                                    ctx.dataset.label.includes("Bibit")
                                ) {
                                    return (
                                        val.toLocaleString("id-ID") + " batang"
                                    );
                                }
                                return val;
                            },
                        },
                    },
                },
                scales: {
                    y: { beginAtZero: true },
                },
            },
        });
    }

    /** === PENGIRIMAN KETENTUAN === */
    function initPengirimanKetentuan() {
        const selectPengiriman = document.getElementById("jenis_pengiriman");
        const infoPengiriman = document.getElementById("info_pengiriman");
        const infoHarga = document.getElementById("info_harga");

        if (!selectPengiriman || !infoPengiriman || !infoHarga) {
            console.warn("[initPengirimanKetentuan] Elemen tidak ditemukan.");
            return;
        }

        function updateKetentuan() {
            switch (selectPengiriman.value) {
                case "ditanggung_pembeli":
                    infoPengiriman.innerHTML =
                        "<strong>Ditanggung Pembeli:</strong> Pembeli bertanggung jawab sepenuhnya dalam mengatur ekspedisi dan menanggung seluruh biaya pengiriman.";
                    infoHarga.innerHTML =
                        "Catatan: Total harga yang tertera belum termasuk biaya pengiriman, karena seluruh biaya ongkos kirim menjadi tanggung jawab pembeli.";
                    break;
                case "ditanggung_penjual":
                    infoPengiriman.innerHTML =
                        "<strong>Ditanggung Penjual:</strong> Pengaturan ekspedisi, biaya pengiriman, dan nomor resi akan dikonfirmasi oleh pihak penjual.";
                    infoHarga.innerHTML =
                        "Catatan: Akan ada biaya tambahan pengiriman yang akan dikonfirmasi oleh penjual dan harus diselesaikan pembeli sebelum proses pengiriman dilakukan.";
                    break;
                case "ditanggung_bersama":
                    infoPengiriman.innerHTML =
                        "<strong>Ditanggung Bersama:</strong> Biaya pengiriman akan dibagi sesuai kesepakatan bersama antara pembeli dan penjual.";
                    infoHarga.innerHTML =
                        "Catatan: Besaran biaya ongkos kirim akan ditentukan berdasarkan hasil kesepakatan antara kedua belah pihak.";
                    break;
            }
        }

        selectPengiriman.addEventListener("change", updateKetentuan);
        updateKetentuan(); // tampilkan ketentuan default saat halaman dimuat
    }

    /** === INIT ALL === */
    document.addEventListener("DOMContentLoaded", () => {
        toggleScrolled();
        handleStickyHeader();
        initMobileNavToggle();
        removePreloader();
        setupScrollTopButton();
        initAOS();
        initLightbox();
        initSwiper();
        autoCarouselIndicators();
        initUniversalModal();
        initSummernote();
        initSidebarToggle();
        initChartKeuangan();
        initChartPanenTanaman();
        initPengirimanKetentuan();
    });

    document.addEventListener("scroll", toggleScrolled);
})();
