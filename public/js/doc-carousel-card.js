document.addEventListener('DOMContentLoaded', function () {
    const wrapper      = document.getElementById('docScrollWrapper');
    const btnPrev      = document.getElementById('docBtnPrev');
    const btnNext      = document.getElementById('docBtnNext');
    const progressFill = document.getElementById('docProgressFill');

    if (!wrapper) return;

    const getScrollAmount = () => {
        const card = wrapper.querySelector('.doc-card');
        return card ? card.offsetWidth + 20 : 280;
    };

    const updateProgress = () => {
        if (!progressFill) return;
        const maxScroll = wrapper.scrollWidth - wrapper.clientWidth;
        const pct = maxScroll > 0 ? (wrapper.scrollLeft / maxScroll) * 100 : 0;
        progressFill.style.width = pct + '%';
    };

    wrapper.addEventListener('scroll', updateProgress);
    updateProgress();

    let autoScrollInterval;

    const startAutoScroll = () => {
        autoScrollInterval = setInterval(() => {
            const maxScroll = wrapper.scrollWidth - wrapper.clientWidth;
            if (wrapper.scrollLeft >= maxScroll - 5) {
                wrapper.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                wrapper.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
            }
        }, 4000); // offset from OPD(3000) & Path(3500)
    };

    const resetAutoScroll = () => {
        clearInterval(autoScrollInterval);
        startAutoScroll();
    };

    btnNext?.addEventListener('click', () => {
        wrapper.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        resetAutoScroll();
    });

    btnPrev?.addEventListener('click', () => {
        wrapper.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        resetAutoScroll();
    });

    startAutoScroll();

    wrapper.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
    wrapper.addEventListener('mouseleave', startAutoScroll);
    wrapper.addEventListener('touchstart', () => clearInterval(autoScrollInterval), { passive: true });
    wrapper.addEventListener('touchend', startAutoScroll, { passive: true });
});