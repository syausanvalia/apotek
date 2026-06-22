// Sidebar toggle
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });

    // Auto-hide alerts after 5 seconds
    $('.alert').not('.alert-permanent').delay(5000).fadeOut('slow');

    // Confirm delete actions
    $('.btn-delete').on('click', function (e) {
        if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            e.preventDefault();
        }
    });

    // Format currency input
    $('.currency-input').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Initialize popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Search functionality with debounce
    let searchTimeout;
    $('.search-input').on('input', function () {
        clearTimeout(searchTimeout);
        const $this = $(this);
        searchTimeout = setTimeout(function () {
            const query = $this.val();
            if (query.length >= 2) {
                // You can add AJAX search here
                console.log('Searching for:', query);
            }
        }, 500);
    });

    // Print functionality
    $('.btn-print').on('click', function () {
        window.print();
    });

    // Export to CSV
    $('.btn-export-csv').on('click', function () {
        const table = $(this).data('table');
        exportTableToCSV(table);
    });
});

// Export table to CSV function
function exportTableToCSV(tableId) {
    const csv = [];
    const rows = document.querySelectorAll(`${tableId} tr`);

    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');
        for (let j = 0; j < cols.length - 1; j++) {
            row.push(cols[j].innerText);
        }
        csv.push(row.join(','));
    }

    downloadCSV(csv.join('\n'), 'export.csv');
}

// Download CSV function
function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Number format helper
function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

// Currency format helper
function formatCurrency(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
}
