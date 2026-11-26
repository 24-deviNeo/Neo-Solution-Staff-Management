<!-- components/footer.php -->
<?php if (!isset($footer_included)): ?>
<?php $footer_included = true; ?>

<style>
    /* =========================================================
       PAGE FOOTER (NATURAL SCROLL FLOW AT PAGE BOTTOM)
       ========================================================= */
    .erp-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        margin-left: 260px;
        width: calc(100% - 260px);
        margin-top: auto !important;
        flex-shrink: 0 !important;
        min-height: 40px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #94a3b8;
        font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        z-index: 10;
        box-sizing: border-box;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    /* Keep page content clear of the viewport-pinned footer. */
    html:not(.app-view) body {
        padding-bottom: 40px !important;
    }

    body.admin-sidebar-hidden .erp-footer {
        margin-left: 0 !important;
        width: 100% !important;
    }

    body.employee-sidebar-hidden .erp-footer {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .erp-footer__left {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #cbd5e1;
    }

    .erp-footer__brand {
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.02em;
    }

    .erp-footer__right {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 12px;
    }

    .erp-footer__right span.neo-highlight {
        color: #60a5fa;
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    @media (max-width: 768px) {
        .erp-footer {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 12px 16px;
            font-size: 11px;
            flex-direction: column;
            justify-content: center;
            gap: 6px;
            text-align: center;
        }

        html:not(.app-view) body {
            padding-bottom: 64px !important;
        }
    }

    /* Keep the footer on mobile web; app view reserves space for its bottom navigation. */
    @media (max-width: 900px) {
        html.app-view body:has(.employee-bottom-nav) .erp-footer,
        html.app-view body:has(.admin-bottom-nav) .erp-footer {
            display: none !important;
        }
    }

    @media print {
        .erp-footer {
            display: none !important;
        }
    }
</style>

<!-- ================= PAGE FOOTER ================= -->
<footer class="erp-footer">
    <div class="erp-footer__left">
        <span class="erp-footer__brand">NEO Solution</span>
        <span>© <span id="currentYear"><?php echo date('Y'); ?></span> • All Rights Reserved</span>
    </div>
    <div class="erp-footer__right">
        Staff & HR Management System
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentYearSpan = document.getElementById('currentYear');
        if (currentYearSpan && !currentYearSpan.textContent.trim()) {
            currentYearSpan.textContent = new Date().getFullYear();
        }
    });
</script>
<?php endif; ?>
