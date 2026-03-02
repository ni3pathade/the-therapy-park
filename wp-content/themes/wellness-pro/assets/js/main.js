/**
 * Wellness Pro — Main JS
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', init);

    function init() {
        stickyHeader();
        mobileMenu();
        benefitsCarousel();
        testimonialsCarousel();
        carousel('team-track', 'team-prev', 'team-next', 3);
        faqAccordion();
        blogFilter();
        loadMore();
        subscribeForm();
        smoothScroll();
    }

    /* ── Sticky header ─────────────────────────────────────── */
    function stickyHeader() {
        var h = document.getElementById('site-header');
        if (!h) return;
        window.addEventListener('scroll', function () {
            h.classList.toggle('scrolled', window.scrollY > 60);
        }, { passive: true });
    }

    /* ── Mobile menu ───────────────────────────────────────── */
    function mobileMenu() {
        var btn = document.getElementById('nav-toggle');
        var nav = document.getElementById('site-nav');
        if (!btn || !nav) return;
        btn.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            btn.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', function (e) {
            if (!btn.contains(e.target) && !nav.contains(e.target)) {
                nav.classList.remove('open');
                btn.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /* ── Benefits dot carousel ─────────────────────────────── */
    function benefitsCarousel() {
        var slides = document.querySelectorAll('.benefit-slide');
        var dots   = document.querySelectorAll('.carousel-dots .dot');
        if (!slides.length) return;
        var cur = 0;

        dots.forEach(function (d, i) {
            d.addEventListener('click', function () { go(i); });
        });

        var timer = setInterval(function () { go((cur + 1) % slides.length); }, 5000);

        function go(n) {
            slides[cur].classList.remove('active');
            dots[cur] && dots[cur].classList.remove('active');
            cur = n;
            slides[cur].classList.add('active');
            dots[cur] && dots[cur].classList.add('active');
        }
    }

    /* ── Testimonials carousel — center card stays purple ──── */
    function testimonialsCarousel() {
        var track   = document.getElementById('testimonials-track');
        var prevBtn = document.getElementById('test-prev');
        var nextBtn = document.getElementById('test-next');
        if (!track || !prevBtn || !nextBtn) return;

        var data = [];
        try { data = JSON.parse(track.dataset.testimonials || '[]'); } catch (e) {}
        if (!data.length) return;

        var cur = 0;

        function fill(quoteId, authorId, idx) {
            var t = data[(idx + data.length) % data.length];
            document.getElementById(quoteId).textContent  = '\u201c' + t.quote + '\u201d';
            document.getElementById(authorId).textContent = t.author;
        }

        function update() {
            fill('test-quote-prev',   'test-author-prev',   cur - 1);
            fill('test-quote-center', 'test-author-center', cur);
            fill('test-quote-next',   'test-author-next',   cur + 1);
        }

        prevBtn.addEventListener('click', function () {
            cur = (cur - 1 + data.length) % data.length;
            update();
        });
        nextBtn.addEventListener('click', function () {
            cur = (cur + 1) % data.length;
            update();
        });

        update();
    }

    /* ── Generic sliding carousel ──────────────────────────── */
    function carousel(trackId, prevId, nextId, visible) {
        var track = document.getElementById(trackId);
        var prev  = document.getElementById(prevId);
        var next  = document.getElementById(nextId);
        if (!track || !prev || !next) return;

        function cards() { return track.querySelectorAll('[class*="card"]'); }

        prev.addEventListener('click', function () {
            var c = cards();
            if (c.length) track.insertBefore(c[c.length - 1], c[0]);
        });
        next.addEventListener('click', function () {
            var c = cards();
            if (c.length) track.appendChild(c[0]);
        });
    }

    /* ── FAQ accordion ─────────────────────────────────────── */
    function faqAccordion() {
        document.querySelectorAll('.faq-item__btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = this.closest('.faq-item');
                var open = item.classList.toggle('open');
                this.setAttribute('aria-expanded', open);
            });
        });
    }

    /* ── Blog AJAX filter ──────────────────────────────────── */
    var activeCat = 'all';

    function blogFilter() {
        document.querySelectorAll('.filter-tag').forEach(function (tag) {
            tag.addEventListener('click', function () {
                document.querySelectorAll('.filter-tag').forEach(function (t) {
                    t.classList.remove('active');
                    t.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');
                activeCat = this.dataset.cat || 'all';
                fetchPosts(activeCat, 1, false);
            });
        });
    }

    function fetchPosts(cat, page, append) {
        if (typeof wellnessPro === 'undefined') return;
        var grid    = document.getElementById('blog-grid');
        var spinner = document.getElementById('posts-spinner');
        if (!grid) return;

        if (spinner) spinner.classList.add('show');

        var fd = new FormData();
        fd.append('action',   wellnessPro.filterAction);
        fd.append('nonce',    wellnessPro.nonce);
        fd.append('category', cat);
        fd.append('paged',    page);

        fetch(wellnessPro.ajaxUrl, { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (spinner) spinner.classList.remove('show');
                if (!res.success) return;
                if (append) grid.insertAdjacentHTML('beforeend', res.data.html);
                else        grid.innerHTML = res.data.html;

                var btn = document.getElementById('load-more');
                if (btn) {
                    btn.dataset.page = page + 1;
                    btn.dataset.cat  = cat;
                    var wrap = btn.parentNode;
                    if (page >= res.data.max_pages) wrap.style.display = 'none';
                    else                            wrap.style.display = 'block';
                }
            })
            .catch(function () {
                if (spinner) spinner.classList.remove('show');
            });
    }

    /* ── Load More ─────────────────────────────────────────── */
    function loadMore() {
        var btn = document.getElementById('load-more');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var page = parseInt(this.dataset.page, 10) || 2;
            var max  = parseInt(this.dataset.max,  10) || 1;
            var cat  = this.dataset.cat || 'all';
            if (page > max) return;
            fetchPosts(cat, page, true);
        });
    }

    /* ── Subscribe / Newsletter forms ─────────────────────── */
    function subscribeForm() {
        if (typeof wellnessPro === 'undefined') return;

        var forms = [
            document.getElementById('subscribe-form'),
            document.querySelector('.newsletter-input-row')
        ];

        forms.forEach(function (form) {
            if (!form) return;
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var emailInput = form.querySelector('input[type="email"]');
                var btn        = form.querySelector('button[type="submit"]');
                if (!emailInput || !emailInput.value) return;

                var origText = btn ? btn.textContent : '';
                if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

                var fd = new FormData();
                fd.append('action', wellnessPro.subscribeAction);
                fd.append('nonce',  wellnessPro.nonce);
                fd.append('email',  emailInput.value);

                fetch(wellnessPro.ajaxUrl, { method: 'POST', body: fd })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        if (btn) { btn.disabled = false; btn.textContent = origText; }
                        showSubscribeMsg(form, res.success, res.data ? res.data.message : '');
                        if (res.success) emailInput.value = '';
                    })
                    .catch(function () {
                        if (btn) { btn.disabled = false; btn.textContent = origText; }
                        showSubscribeMsg(form, false, 'Something went wrong. Please try again.');
                    });
            });
        });
    }

    function showSubscribeMsg(form, success, text) {
        var existing = form.parentNode.querySelector('.subscribe-msg');
        if (existing) existing.remove();
        var msg = document.createElement('p');
        msg.className = 'subscribe-msg';
        msg.textContent = text;
        msg.style.cssText = 'margin-top:.6rem;font-size:.85rem;font-weight:600;color:' + (success ? '#4caf50' : '#e57373') + ';';
        form.parentNode.insertBefore(msg, form.nextSibling);
        setTimeout(function () { msg.remove(); }, 5000);
    }

    /* ── Smooth scroll ─────────────────────────────────────── */
    function smoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                var id = this.getAttribute('href');
                if (id.length > 1 && document.querySelector(id)) {
                    e.preventDefault();
                    document.querySelector(id).scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    }

})();
