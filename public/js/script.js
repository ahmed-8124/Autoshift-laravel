// AutoShift - JavaScript

// Auto-hide flash messages
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.flash-msg').forEach(el => {
        setTimeout(() => { el.style.transition='opacity .5s'; el.style.opacity='0'; setTimeout(()=>el.remove(),500); }, 4000);
    });

    // Search tab toggle
    document.querySelectorAll('.search-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.search-tab').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('search-type').value = this.dataset.type;
        });
    });

    // Post-ad type toggle
    document.querySelectorAll('.type-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('ad-type').value = this.dataset.type;
        });
    });

    // Tab bar (my ads)
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(p => p.style.display='none');
            const target = document.getElementById(this.dataset.tab);
            if (target) target.style.display = 'block';
        });
    });
});

function confirmDelete(msg) {
    return confirm(msg || 'Are you sure?');
}

// Phone reveal
function revealPhone(btn, phone) {
    btn.textContent = phone;
    btn.href = 'tel:' + phone;
    btn.style.background = '#0f1923';
}
