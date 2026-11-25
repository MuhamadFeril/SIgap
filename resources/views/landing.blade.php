<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP — Sistem Izin Gerbang &amp; Absensi Pengamanan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600&family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
:root {
    /* Brand */
    --pine: #153f37;
    --pine-light: #1e5a4d;
    --pine-deep: #0e2f28;
    --pine-grad: linear-gradient(175deg, #1a4a41 0%, #123830 55%, #0e2f28 100%);
    --mint: #e4f0ea;
    --mint-soft: #f0f7f3;

    /* Accents */
    --amber: #c9821e;
    --amber-bg: #fbf0dd;
    --amber-soft: #e9a94e;
    --terracotta: #ae4e37;
    --terracotta-bg: #f8e7e2;
    --teal-bg: #dcefe6;
    --teal-text: #1b6e4f;

    /* Neutrals */
    --ink: #182421;
    --ink-soft: #4b5b56;
    --paper: #eef2f0;
    --surface: #ffffff;
    --line: #dce3df;
    --line-soft: #e9eeeb;

    /* Shape & elevation */
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 22px;
    --shadow-sm: 0 1px 2px rgba(16, 40, 34, 0.05);
    --shadow: 0 1px 3px rgba(16, 40, 34, 0.06), 0 10px 28px -18px rgba(16, 40, 34, 0.28);
    --shadow-lg: 0 2px 6px rgba(16, 40, 34, 0.07), 0 24px 48px -24px rgba(16, 40, 34, 0.3);

    /* Typography */
    --font-head: 'Space Grotesk', 'Inter', sans-serif;
    --font-body: 'Inter', system-ui, sans-serif;
    --font-mono: 'IBM Plex Mono', monospace;
}

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body.landing {
    font-family: var(--font-body);
    font-size: 15px;
    line-height: 1.55;
    background:
        radial-gradient(1100px 500px at 100% -8%, rgba(21, 63, 55, 0.07), transparent 60%),
        radial-gradient(900px 460px at -8% 110%, rgba(201, 130, 30, 0.06), transparent 55%),
        var(--paper);
    color: var(--ink);
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

.landing h1,
.landing h2,
.landing h3,
.landing h4,
.landing .display {
    font-family: var(--font-head);
    letter-spacing: -0.02em;
    margin: 0;
    color: var(--ink);
}

.landing a {
    color: inherit;
    text-decoration: none;
}

.landing :focus-visible {
    outline: 2px solid var(--pine);
    outline-offset: 2px;
}

.landing .lp-hero :focus-visible,
.landing .lp-cta-band :focus-visible,
.landing .lp-footer :focus-visible {
    outline-color: var(--amber-soft);
}

@media (prefers-reduced-motion: reduce) {
    .landing * {
        animation: none !important;
        transition: none !important;
    }
}

/* Reveal-on-scroll (base state defined early so hover states can win) */
.reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* Gate mark */
.gate-mark {
    width: 34px;
    height: 34px;
    position: relative;
    flex-shrink: 0;
}

.gate-mark .post {
    position: absolute;
    left: 2px;
    top: 4px;
    bottom: 4px;
    width: 4px;
    background: var(--pine);
    border-radius: 2px;
}

.gate-mark .arm {
    position: absolute;
    left: 6px;
    top: 5px;
    width: 24px;
    height: 4px;
    background: var(--amber);
    border-radius: 2px;
    transform-origin: 0% 50%;
    transform: rotate(0deg);
    transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.gate-mark.open .arm {
    transform: rotate(-58deg);
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.brand .wordmark {
    font-family: var(--font-head);
    font-weight: 700;
    font-size: 19px;
    letter-spacing: -0.02em;
    color: var(--pine);
}

.brand .tagline {
    font-size: 10.5px;
    color: var(--ink-soft);
    font-family: var(--font-mono);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-weight: 500;
}

/* Badges (mock card) */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 99px;
    font-family: var(--font-mono);
    white-space: nowrap;
}

.badge.approved {
    background: var(--teal-bg);
    color: var(--teal-text);
}

.badge.out {
    background: var(--amber-bg);
    color: var(--amber);
}

.badge.back {
    background: var(--teal-bg);
    color: var(--teal-text);
}

.badge .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* Nav */
.lp-nav {
    position: sticky;
    top: 0;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 13px clamp(18px, 6vw, 72px);
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--line);
}

.lp-nav-links {
    display: flex;
    align-items: center;
    gap: clamp(18px, 2.4vw, 30px);
}

.lp-nav-links a {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink-soft);
    transition: color 0.16s;
}

.lp-nav-links a:hover {
    color: var(--pine);
}

.lp-nav-cta {
    background: var(--pine);
    color: #fff;
    border: none;
    padding: 10px 21px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13.5px;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 8px 18px -12px rgba(21, 63, 55, 0.9);
    transition: background 0.16s, transform 0.16s;
    white-space: nowrap;
}

.lp-nav-cta:hover {
    background: var(--pine-light);
    color: #fff;
    transform: translateY(-1px);
}

/* Hero */
.lp-hero {
    position: relative;
    padding: clamp(56px, 7vw, 96px) clamp(18px, 6vw, 72px) clamp(56px, 6vw, 88px);
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap: clamp(32px, 4vw, 56px);
    align-items: center;
    overflow: hidden;
    color: #fff;
    background:
        radial-gradient(760px 430px at 88% 6%, rgba(201, 130, 30, 0.22), transparent 62%),
        radial-gradient(680px 460px at -5% 100%, rgba(46, 142, 120, 0.3), transparent 60%),
        var(--pine-grad);
}

.lp-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
    background-size: 56px 56px;
    -webkit-mask-image: radial-gradient(circle at 45% 45%, #000 10%, transparent 78%);
    mask-image: radial-gradient(circle at 45% 45%, #000 10%, transparent 78%);
    pointer-events: none;
}

.lp-hero > * {
    position: relative;
    z-index: 1;
}

.lp-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font-mono);
    font-size: 11px;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--amber);
    font-weight: 600;
    background: var(--amber-bg);
    padding: 6px 13px;
    border-radius: 99px;
    margin-bottom: 20px;
}

.lp-hero .lp-eyebrow {
    background: rgba(201, 130, 30, 0.16);
    color: var(--amber-soft);
    border: 1px solid rgba(233, 169, 78, 0.35);
}

.lp-hero h1 {
    font-size: clamp(33px, 4.5vw, 54px);
    line-height: 1.07;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: #fff;
}

.lp-hero h1 .accent {
    color: var(--amber-soft);
}

.lp-hero p.lead {
    font-size: clamp(15px, 1.15vw, 16.5px);
    color: #c6d8d1;
    line-height: 1.65;
    margin-top: 18px;
    max-width: 520px;
    font-weight: 400;
}

.lp-cta-row {
    display: flex;
    gap: 12px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.lp-btn-primary,
.lp-btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 26px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    line-height: 1.2;
    font-family: inherit;
    cursor: pointer;
    text-decoration: none;
    border: 1.5px solid transparent;
    transition: background 0.17s, border-color 0.17s, color 0.17s, transform 0.17s, box-shadow 0.17s;
}

.lp-btn-primary {
    background: var(--pine);
    color: #fff;
    box-shadow: 0 10px 22px -14px rgba(21, 63, 55, 0.95);
}

.lp-btn-primary:hover {
    background: var(--pine-light);
    color: #fff;
    transform: translateY(-1px);
}

.lp-btn-primary:active {
    transform: translateY(0);
}

.lp-btn-secondary {
    background: var(--surface);
    color: var(--ink);
    border-color: var(--line);
}

.lp-btn-secondary:hover {
    border-color: var(--pine);
    color: var(--pine);
    background: var(--mint-soft);
}

/* Buttons on dark surfaces: amber accent + ghost */
.lp-hero .lp-btn-primary,
.lp-cta-band .lp-btn-primary {
    background: var(--amber);
    border-color: var(--amber);
    color: #fff;
    box-shadow: 0 12px 26px -14px rgba(201, 130, 30, 0.95);
}

.lp-hero .lp-btn-primary:hover,
.lp-cta-band .lp-btn-primary:hover {
    background: #b0721a;
    border-color: #b0721a;
    color: #fff;
}

.lp-hero .lp-btn-secondary,
.lp-cta-band .lp-btn-secondary {
    background: rgba(255, 255, 255, 0.07);
    border-color: rgba(255, 255, 255, 0.35);
    color: #fff;
}

.lp-hero .lp-btn-secondary:hover,
.lp-cta-band .lp-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: #fff;
    color: #fff;
}

.lp-trust {
    display: flex;
    gap: clamp(18px, 2.6vw, 34px);
    margin-top: 40px;
    flex-wrap: wrap;
}

.lp-trust div {
    font-family: var(--font-mono);
}

.lp-trust > div + div {
    border-left: 1px solid rgba(255, 255, 255, 0.18);
    padding-left: clamp(16px, 2vw, 26px);
}

.lp-trust .n {
    font-size: clamp(21px, 2vw, 25px);
    font-weight: 700;
    color: #fff;
    line-height: 1.15;
}

.lp-trust .l {
    font-size: 10.5px;
    color: rgba(255, 255, 255, 0.58);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-top: 4px;
}

/* Hero visual */
.lp-hero-visual {
    position: relative;
    padding: 10px;
}

.lp-mock-card {
    background: var(--surface);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    padding: 24px;
    position: relative;
    z-index: 1;
    color: var(--ink);
}

.lp-mock-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.lp-mock-head .t {
    font-family: var(--font-head);
    font-size: 13.5px;
    font-weight: 700;
    letter-spacing: -0.01em;
}

.lp-mock-gate {
    width: 52px;
    height: 52px;
    position: relative;
    flex-shrink: 0;
}

.lp-mock-gate .post {
    position: absolute;
    left: 4px;
    top: 6px;
    bottom: 6px;
    width: 6px;
    background: var(--pine);
    border-radius: 3px;
}

.lp-mock-gate .arm {
    position: absolute;
    left: 10px;
    top: 8px;
    width: 36px;
    height: 6px;
    background: var(--amber);
    border-radius: 3px;
    transform-origin: 0% 50%;
    animation: gateSwing 3.2s ease-in-out infinite;
}

@keyframes gateSwing {
    0%,
    15% {
        transform: rotate(0deg);
    }
    45%,
    70% {
        transform: rotate(-62deg);
    }
    100% {
        transform: rotate(-62deg);
    }
}

.lp-mock-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-top: 1px solid var(--line-soft);
    font-size: 12.5px;
}

.lp-mock-row:first-of-type {
    border-top: none;
}

.lp-mock-row .nm {
    font-weight: 600;
    color: var(--ink);
}

.lp-mock-row .kl {
    color: var(--ink-soft);
    font-size: 11px;
    margin-top: 2px;
}

.lp-float-card {
    position: absolute;
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 12px 14px;
    font-size: 11.5px;
    font-weight: 600;
    z-index: 2;
    color: var(--ink);
    white-space: nowrap;
}

.lp-float-card.f1 {
    top: -8px;
    right: -6px;
    color: var(--teal-text);
    animation: floatY 4s ease-in-out infinite;
}

.lp-float-card.f2 {
    bottom: -10px;
    left: -10px;
    color: var(--amber);
    animation: floatY 4.6s ease-in-out infinite reverse;
}

@keyframes floatY {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-8px);
    }
}

/* Sections */
.lp-section {
    padding: clamp(56px, 7vw, 88px) clamp(18px, 6vw, 72px);
}

#lp-caranya {
    background: var(--surface);
    border-top: 1px solid var(--line-soft);
    border-bottom: 1px solid var(--line-soft);
}

.lp-section-head {
    max-width: 640px;
    margin-bottom: clamp(30px, 4vw, 44px);
}

.lp-section-head .lp-eyebrow {
    margin-bottom: 14px;
}

.lp-section-head h2 {
    font-size: clamp(25px, 3vw, 34px);
    line-height: 1.18;
    font-weight: 700;
    letter-spacing: -0.025em;
}

.lp-section-head p {
    color: var(--ink-soft);
    font-size: 15px;
    margin-top: 12px;
    line-height: 1.6;
    max-width: 58ch;
}

.lp-problem-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(16px, 2vw, 24px);
    max-width: 1180px;
}

.lp-problem-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-lg);
    padding: clamp(22px, 2.6vw, 32px);
    position: relative;
    box-shadow: var(--shadow-sm);
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    overflow: hidden;
}

.lp-problem-card::before {
    content: '';
    position: absolute;
    inset: 0 0 auto 0;
    height: 3px;
    background: linear-gradient(90deg, var(--terracotta), transparent 70%);
}

.lp-problem-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow);
    border-color: #cfdad4;
}

.lp-problem-card .tag {
    font-family: var(--font-mono);
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    font-weight: 600;
    color: var(--terracotta);
    background: var(--terracotta-bg);
    display: inline-block;
    padding: 4px 11px;
    border-radius: 99px;
    margin-bottom: 16px;
}

.lp-problem-card h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: -0.02em;
}

.lp-problem-card p {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.6;
    margin: 0;
}

.lp-problem-card blockquote {
    margin: 18px 0 0;
    padding: 13px 15px;
    background: var(--mint-soft);
    border-left: 3px solid var(--amber);
    border-radius: 0 10px 10px 0;
    font-size: 12.5px;
    color: var(--ink);
    font-style: italic;
    line-height: 1.55;
}

.lp-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    position: relative;
    max-width: 1180px;
}

.lp-step {
    padding: 0 22px 0 0;
    position: relative;
}

.lp-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 23px;
    right: 0;
    width: 100%;
    height: 1.5px;
    background: repeating-linear-gradient(90deg, var(--line) 0 6px, transparent 6px 12px);
    z-index: 0;
}

.lp-step-num {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: var(--pine-grad);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-head);
    font-weight: 700;
    font-size: 16px;
    letter-spacing: -0.02em;
    position: relative;
    z-index: 1;
    margin-bottom: 18px;
    box-shadow: 0 10px 20px -14px rgba(21, 63, 55, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.14);
}

.lp-step h4 {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 7px;
    letter-spacing: -0.015em;
}

.lp-step p {
    font-size: 12.5px;
    color: var(--ink-soft);
    line-height: 1.55;
    margin: 0;
}

.lp-role-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: clamp(14px, 1.6vw, 20px);
    max-width: 1180px;
}

.lp-role-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-lg);
    padding: clamp(20px, 2vw, 26px);
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
}

.lp-role-card::after {
    content: '';
    position: absolute;
    inset: 0 0 auto 0;
    height: 3px;
    background: linear-gradient(90deg, var(--pine), transparent 70%);
    opacity: 0;
    transition: opacity 0.2s;
}

.lp-role-card:hover {
    border-color: var(--pine);
    box-shadow: var(--shadow);
    transform: translateY(-3px);
}

.lp-role-card:hover::after {
    opacity: 1;
}

.lp-role-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: var(--mint);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

.lp-role-icon svg {
    width: 19px;
    height: 19px;
    stroke: var(--pine);
}

.lp-role-card h4 {
    font-size: 15.5px;
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: -0.015em;
}

.lp-role-card ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.lp-role-card li {
    font-size: 12.5px;
    color: var(--ink-soft);
    padding: 5px 0 5px 16px;
    position: relative;
    line-height: 1.45;
}

.lp-role-card li::before {
    content: '—';
    position: absolute;
    left: 0;
    color: var(--amber);
}

/* CTA band */
.lp-cta-band {
    margin: 0 clamp(18px, 6vw, 72px) clamp(48px, 6vw, 72px);
    background:
        radial-gradient(520px 320px at 12% 130%, rgba(46, 142, 120, 0.35), transparent 62%),
        linear-gradient(155deg, var(--pine) 0%, var(--pine-deep) 100%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--radius-xl);
    padding: clamp(42px, 5vw, 66px) clamp(24px, 5vw, 56px);
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.lp-cta-band::after {
    content: '';
    position: absolute;
    right: -80px;
    top: -80px;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201, 130, 30, 0.32), transparent 70%);
    pointer-events: none;
}

.lp-cta-band > * {
    position: relative;
    z-index: 1;
}

.lp-cta-band h2 {
    color: #fff;
    font-size: clamp(23px, 3vw, 33px);
    font-weight: 700;
    letter-spacing: -0.025em;
}

.lp-cta-band p {
    color: #c4d6cd;
    font-size: 14.5px;
    margin-top: 10px;
}

.lp-cta-band .lp-cta-row {
    justify-content: center;
    margin-top: 26px;
}

/* Footer */
.lp-footer {
    padding: 30px clamp(18px, 6vw, 72px);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    font-size: 12.5px;
    color: rgba(255, 255, 255, 0.62);
    flex-wrap: wrap;
    gap: 12px;
    background: var(--pine-deep);
}

.lp-footer .brand .wordmark {
    color: #fff;
}

.lp-footer .gate-mark .post {
    background: rgba(255, 255, 255, 0.88);
}

@media (max-width: 900px) {
    .lp-hero {
        grid-template-columns: 1fr;
        padding-top: clamp(44px, 8vw, 64px);
    }

    .lp-problem-grid {
        grid-template-columns: 1fr;
    }

    .lp-steps {
        grid-template-columns: 1fr 1fr;
        row-gap: 30px;
    }

    .lp-step:nth-child(2)::after {
        display: none;
    }

    .lp-role-grid {
        grid-template-columns: 1fr 1fr;
    }

    .lp-nav-links {
        display: none;
    }

    .lp-hero-visual {
        max-width: 560px;
    }
}

@media (max-width: 600px) {
    .lp-hero {
        padding: 36px clamp(18px, 6vw, 72px) 52px;
        text-align: center;
    }

    .lp-hero-visual {
        display: none;
    }

    .lp-hero p.lead {
        margin-left: auto;
        margin-right: auto;
    }

    .lp-eyebrow {
        margin-left: auto;
        margin-right: auto;
    }

    .lp-cta-row {
        justify-content: center;
    }

    .lp-trust {
        justify-content: center;
    }

    .lp-trust > div + div {
        border-left: none;
        padding-left: 0;
    }

    .lp-steps {
        grid-template-columns: 1fr;
    }

    .lp-step:not(:last-child)::after {
        display: none;
    }

    .lp-step {
        padding-right: 0;
    }

    .lp-role-grid {
        grid-template-columns: 1fr;
    }

    .lp-footer {
        flex-direction: column;
        text-align: center;
    }
}
    </style>
</head>
<body class="landing">

<nav class="lp-nav">
    <div class="brand">
        <div class="gate-mark open">
            <div class="post"></div>
            <div class="arm"></div>
        </div>
        <div>
            <div class="wordmark">SIGAP</div>
            <div class="tagline">GATE &amp; SHIFT SYSTEM</div>
        </div>
    </div>
    <div class="lp-nav-links">
        <a href="#lp-masalah">Masalah</a>
        <a href="#lp-caranya">Cara kerja</a>
        <a href="#lp-fitur">Fitur</a>
    </div>
    @auth
        @php
            $userRole = Auth::user()->role;
            $dashUrl = match($userRole) {
                'admin' => route('admin.dashboard'),
                'guru' => route('guru.dashboard'),
                'siswa' => route('siswa.dashboard'),
                'satpam' => route('satpam.dashboard'),
                'user' => route('user.dashboard'),
                default => route('landing'),
            };
        @endphp
        <a href="{{ $dashUrl }}" class="lp-nav-cta">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="lp-nav-cta">Masuk</a>
    @endauth
</nav>

<section class="lp-hero">
    <div>
        <span class="lp-eyebrow">Dari riset lapangan bersama satpam sekolah</span>
        <h1>Satu gerbang,<br>satu <span class="accent">sumber kebenaran.</span></h1>
        <p class="lead">SIGAP mengganti izin keluar lisan dan jadwal jaga di kertas dengan satu sistem digital — supaya siswa tidak bisa berbohong soal alasan keluar, dan satpam tidak lagi kewalahan dengan jadwal yang bentrok.</p>
        <div class="lp-cta-row">
            @auth
                <a href="{{ $dashUrl }}" class="lp-btn-primary">Ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="lp-btn-primary">Coba demo SIGAP</a>
            @endauth
            <a href="#lp-masalah" class="lp-btn-secondary">Lihat masalahnya</a>
        </div>
        <div class="lp-trust">
            <div><div class="n">04</div><div class="l">Role pengguna</div></div>
            <div><div class="n">Real-time</div><div class="l">Status gerbang</div></div>
            <div><div class="n">100%</div><div class="l">Izin terverifikasi guru</div></div>
        </div>
    </div>
    <div class="lp-hero-visual">
        <div class="lp-float-card f1">📎 Bukti terlampir</div>
        <div class="lp-mock-card">
            <div class="lp-mock-head">
                <div class="t">Izin disetujui hari ini</div>
                <div class="lp-mock-gate">
                    <div class="post"></div>
                    <div class="arm"></div>
                </div>
            </div>
            <div class="lp-mock-row">
                <div>
                    <div class="nm">Ahmad Fauzan</div>
                    <div class="kl">XI RPL 2 · Dijemput orang tua</div>
                </div>
                <span class="badge approved"><span class="dot"></span>Disetujui</span>
            </div>
            <div class="lp-mock-row">
                <div>
                    <div class="nm">Siti Nurhaliza</div>
                    <div class="kl">X TKJ 1 · Sakit</div>
                </div>
                <span class="badge out"><span class="dot"></span>Sudah keluar</span>
            </div>
            <div class="lp-mock-row">
                <div>
                    <div class="nm">Nadia Ramadhani</div>
                    <div class="kl">XI RPL 2 · Dijemput</div>
                </div>
                <span class="badge back"><span class="dot"></span>Sudah kembali</span>
            </div>
        </div>
        <div class="lp-float-card f2">✓ Jadwal jaga tidak bentrok</div>
    </div>
</section>

<section class="lp-section" id="lp-masalah">
    <div class="lp-section-head reveal">
        <span class="lp-eyebrow">Temuan dari lapangan</span>
        <h2>Dua masalah nyata yang kami temukan langsung dari satpam sekolah</h2>
        <p>Bukan asumsi — ini hasil wawancara langsung dengan satpam yang bertugas setiap hari di gerbang.</p>
    </div>
    <div class="lp-problem-grid">
        <div class="lp-problem-card">
            <span class="tag">Masalah 01</span>
            <h3>Siswa bisa keluar dengan alasan bohong</h3>
            <p>Tidak ada sistem izin yang jelas — siswa cukup bilang lisan ke satpam, tanpa ada yang bisa diverifikasi.</p>
            <blockquote>"Tadi murid juga keluar, tapi bohong alasannya."</blockquote>
        </div>
        <div class="lp-problem-card">
            <span class="tag">Masalah 02</span>
            <h3>Jadwal jaga satpam tidak teratur</h3>
            <p>Pembagian shift masih manual, rawan bentrok, dan sulit dipantau siapa yang seharusnya bertugas hari itu.</p>
            <blockquote>Dicatat di kertas, sering tidak sinkron antar petugas.</blockquote>
        </div>
    </div>
</section>

<section class="lp-section" id="lp-caranya">
    <div class="lp-section-head reveal">
        <span class="lp-eyebrow">Cara kerja</span>
        <h2>Dari pengajuan sampai siswa keluar gerbang</h2>
        <p>Empat langkah, semua tercatat dan bisa dipantau real-time.</p>
    </div>
    <div class="lp-steps">
        <div class="lp-step">
            <div class="lp-step-num">01</div>
            <h4>Siswa ajukan izin</h4>
            <p>Isi alasan, kelas, dan jam keluar — bisa lampirkan bukti seperti pesan orang tua.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">02</div>
            <h4>Guru verifikasi</h4>
            <p>Guru piket meninjau lalu menyetujui atau menolak pengajuan.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">03</div>
            <h4>Satpam cek di gerbang</h4>
            <p>Nama yang disetujui otomatis muncul — tinggal dicocokkan, lalu ditandai keluar.</p>
        </div>
        <div class="lp-step">
            <div class="lp-step-num">04</div>
            <h4>Admin pantau semua</h4>
            <p>Rekap izin, kehadiran satpam, dan jadwal shift dalam satu dashboard.</p>
        </div>
    </div>
</section>

<section class="lp-section" id="lp-fitur">
    <div class="lp-section-head reveal">
        <span class="lp-eyebrow">Fitur per peran</span>
        <h2>Satu sistem, empat sudut pandang</h2>
        <p>Setiap peran cuma melihat yang relevan buat tugasnya.</p>
    </div>
    <div class="lp-role-grid">
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 1 8l11 5 9-4.09V15h2V8L12 3z"/><path d="M5 13.18v4L12 21l7-3.82v-4"/></svg>
            </div>
            <h4>Siswa</h4>
            <ul>
                <li>Ajukan izin keluar</li>
                <li>Lampirkan bukti</li>
                <li>Pantau riwayat izin</li>
            </ul>
        </div>
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <h4>Guru piket</h4>
            <ul>
                <li>Tinjau pengajuan masuk</li>
                <li>Setujui atau tolak</li>
                <li>Lihat riwayat keputusan</li>
            </ul>
        </div>
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5 3.4 8.4 8 11 4.6-2.6 8-6 8-11V5l-8-3z"/></svg>
            </div>
            <h4>Satpam</h4>
            <ul>
                <li>Daftar izin disetujui real-time</li>
                <li>Tandai keluar / kembali</li>
                <li>Ajukan tukar shift</li>
            </ul>
        </div>
        <div class="lp-role-card">
            <div class="lp-role-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
            </div>
            <h4>Admin sekolah</h4>
            <ul>
                <li>Kelola akun &amp; jadwal shift</li>
                <li>Setujui tukar shift</li>
                <li>Rekap &amp; laporan bulanan</li>
            </ul>
        </div>
    </div>
</section>

<div class="lp-cta-band reveal">
    <h2>Siap coba SIGAP?</h2>
    <p>Masuk ke demo dan jelajahi keempat dashboard-nya langsung.</p>
    <div class="lp-cta-row">
        <a href="{{ route('login') }}" class="lp-btn-primary">Coba demo SIGAP</a>
        <a href="{{ route('register') }}" class="lp-btn-secondary">Daftar akun</a>
    </div>
</div>

<footer class="lp-footer">
    <div class="brand">
        <div class="gate-mark">
            <div class="post"></div>
            <div class="arm"></div>
        </div>
        <span class="wordmark" style="font-size:14px;">SIGAP</span>
    </div>
    <div>Prototipe tugas sekolah — Sistem Izin Gerbang &amp; Absensi Pengamanan</div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal, .lp-problem-card, .lp-step, .lp-role-card').forEach((el) => {
            el.classList.add('reveal');
            observer.observe(el);
        });
    });
</script>

</body>
</html>
