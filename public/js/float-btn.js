(function () {
    const fab     = document.getElementById('gsOpenBtn');
    const overlay = document.getElementById('gsOverlay');
    const closeBtn = document.getElementById('gsCloseBtn');
    const input   = document.getElementById('gsInput');
    const chips   = document.querySelectorAll('.gs-chip');
    const quickTags = document.querySelectorAll('.gs-quick-tag');

    // Open
    function openModal() {
        overlay.classList.add('gs-open');
        setTimeout(() => input && input.focus(), 220);
        document.body.style.overflow = 'hidden';
    }

    // Close
    function closeModal() {
        overlay.classList.remove('gs-open');
        document.body.style.overflow = '';
    }

    fab.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);

    // Click outside modal
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal();
    });

    // ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });

    // Chip toggle (radio style)
    chips.forEach(chip => {
        chip.addEventListener('click', function () {
            chips.forEach(c => c.classList.remove('active-chip'));
            this.classList.add('active-chip');
        });
    });

    // Quick tag fills input
    quickTags.forEach(tag => {
        tag.addEventListener('click', function () {
            input.value = this.dataset.val;
            input.focus();
        });
    });
})();