(() => {
    const toggle = document.getElementById('navToggle');
    const closeBtn = document.getElementById('navClose');
    const mobileMenu = document.getElementById('mobileMenu');
    const userToggles = document.querySelectorAll('.user-toggle');
    const desktopDropdown = document.getElementById('desktopUserDropdown');
    const mobileDropdown = document.getElementById('mobileUserDropdown');
    const mobileNavGroups = document.querySelectorAll('.mobile-nav-group');
    const desktopNavDropdowns = document.querySelectorAll('.nav-dropdown');

    const openMenu = () => {
        if (!mobileMenu || !toggle) return;
        mobileMenu.classList.add('show');
        toggle.classList.add('open');
    };

    const closeMenu = () => {
        if (!mobileMenu || !toggle) return;
        mobileMenu.classList.remove('show');
        toggle.classList.remove('open');
    };

    if (toggle) {
        toggle.addEventListener('click', () => {
            mobileMenu.classList.contains('show') ? closeMenu() : openMenu();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeMenu);
    }

    // User dropdowns
    userToggles.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const target = btn.closest('.mobile-menu-header') ? mobileDropdown : desktopDropdown;
            if (target) {
                const isOpen = target.classList.contains('show');
                desktopDropdown?.classList.remove('show');
                mobileDropdown?.classList.remove('show');
                if (!isOpen) target.classList.add('show');
            }
        });
    });

    document.addEventListener('click', () => {
        desktopDropdown?.classList.remove('show');
        mobileDropdown?.classList.remove('show');
    });

    // Mobile nav dropdowns
    mobileNavGroups.forEach(group => {
        const trigger = group.querySelector('.mobile-nav-trigger');
        const arrow = group.querySelector('.arrow');
        if (!trigger) return;
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileNavGroups.forEach(g => {
                if (g !== group) {
                    g.classList.remove('open');
                    const gArrow = g.querySelector('.arrow');
                    if (gArrow) gArrow.classList.remove('up');
                }
            });
            group.classList.toggle('open');
            if (arrow) arrow.classList.toggle('up', group.classList.contains('open'));
        });
    });

    // Desktop nav dropdown (Konfigurasi)
    const updateDesktopArrow = (drop, isOpen) => {
        const arrow = drop.querySelector('.arrow');
        if (arrow) arrow.classList.toggle('up', isOpen);
    };

    const closeDesktopNavDropdowns = () => desktopNavDropdowns.forEach(d => {
        d.classList.remove('open');
        updateDesktopArrow(d, false);
    });

    desktopNavDropdowns.forEach(drop => {
        const trigger = drop.querySelector('.nav-item-trigger');
        if (!trigger) return;

        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = drop.classList.contains('open');
            closeDesktopNavDropdowns();
            if (!isOpen) {
                drop.classList.add('open');
                updateDesktopArrow(drop, true);
            }
        });
    });
})();
