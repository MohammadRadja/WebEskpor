<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/admin/assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/admin/assets/demo/chart-bar-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#konten').summernote({
            height: 300,
        });
    });
    // Enhanced sidebar interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add click effects to nav links
        const navLinks = document.querySelectorAll('.sb-sidenav .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                navLinks.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
            });
        });

        // Add hover effects to dropdown items
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>
