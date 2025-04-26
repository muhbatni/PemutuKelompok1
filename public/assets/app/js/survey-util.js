document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("m_sortable_portlets");
    if (!container) {
        return null;
    }
    // Inisialisasi SortableJS
    const sortable = new Sortable(container, {
        animation: 150,
        handle: ".m-portlet__head",
        ghostClass: "sortable-ghost",
        onEnd: function () {
            updateOrder();
        },
    });

    // Fungsi untuk memperbarui urutan portlet
    function updateOrder() {
        const portlets = container.querySelectorAll(".portlet-template");
        portlets.forEach((portlet, index) => {
            const orderInput = portlet.querySelector(".portlet-order");
            if (orderInput) {
                orderInput.value = index + 1; // Urutan dimulai dari 1
            }
        });
    }

    // Panggil updateOrder saat halaman dimuat
    updateOrder();
});

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("m_sortable_portlets");
    if (!container) {
        return null;
    }
    // Tambahkan event listener untuk tab jenis pertanyaan
    container.addEventListener("click", function (event) {
        if (event.target.matches(".nav-link")) {
            const portlet = event.target.closest(".portlet-template");
            const jenisInput = portlet.querySelector('input[name="jenis[]"]');
            if (event.target.textContent.trim() === "Opsian") {
                jenisInput.value = 1; // Set jenis ke 1 untuk opsi
            } else if (event.target.textContent.trim() === "Isian") {
                jenisInput.value = 2; // Set jenis ke 2 untuk isian
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const addButton = document.querySelector("[data-repeater-create]");
    const container = document.getElementById("m_sortable_portlets");
    const template = document.querySelector(".portlet-template");
    if (!addButton || !container) {
        return null;
    }
    // Fungsi untuk menambahkan portlet baru
    addButton.addEventListener("click", function () {
        // Clone the template
        const newPortlet = template.cloneNode(true);

        // Clear any input fields in the cloned portlet
        const inputs = newPortlet.querySelectorAll("textarea, input");
        inputs.forEach(input => (input.value = ""));

        // Tambahkan animasi fade-in menggunakan JavaScript
        newPortlet.style.opacity = 0;
        newPortlet.style.transform = "scale(0.95)";
        container.appendChild(newPortlet);

        // Gunakan setTimeout untuk memberikan efek animasi
        setTimeout(() => {
            newPortlet.style.transition = "opacity 0.3s ease, transform 0.3s ease";
            newPortlet.style.opacity = 1;
            newPortlet.style.transform = "scale(1)";
        }, 10);

        // Tambahkan event listener untuk tombol delete di portlet baru
        const deleteButton = newPortlet.querySelector("[data-repeater-delete]");
        deleteButton.addEventListener("click", function () {
            // Tambahkan animasi fade-out menggunakan JavaScript
            newPortlet.style.transition = "opacity 0.3s ease, transform 0.3s ease";
            newPortlet.style.opacity = 0;
            newPortlet.style.transform = "scale(0.95)";
            setTimeout(() => {
                newPortlet.remove(); // Hapus portlet setelah animasi selesai
            }, 300); // Durasi animasi
        });
    });

    // Tambahkan event listener untuk tombol delete di portlet awal
    const initialDeleteButtons = document.querySelectorAll("[data-repeater-delete]");
    initialDeleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            const portlet = button.closest(".portlet-template");
            if (portlet) {
                // Tambahkan animasi fade-out menggunakan JavaScript
                portlet.style.transition = "opacity 0.3s ease, transform 0.3s ease";
                portlet.style.opacity = 0;
                portlet.style.transform = "scale(0.95)";
                setTimeout(() => {
                    portlet.remove(); // Hapus portlet setelah animasi selesai
                }, 300); // Durasi animasi
            }
        });
    });
});
