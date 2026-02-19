document.addEventListener('DOMContentLoaded', function () {
    const wrapper      = document.getElementById('opdScrollWrapper');
    const btnPrev      = document.getElementById('opdBtnPrev');
    const btnNext      = document.getElementById('opdBtnNext');
    const progressFill = document.getElementById('opdProgressFill');

    if (!wrapper) return;

    const getScrollAmount = () => {
        const card = wrapper.querySelector('.opd-card');
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
        }, 3000);
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