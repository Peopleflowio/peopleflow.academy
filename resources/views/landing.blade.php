<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peopleflow Academy — Workday HCM Training</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #050508; --bg2: #0c0c14; --bg3: #111120;
      --teal: #005edb; --teal2: #1a6fe8;
      --teal-glow: rgba(0,94,219,0.15); --teal-border: rgba(0,94,219,0.25);
      --white: #ffffff; --white2: rgba(255,255,255,0.7); --white3: rgba(255,255,255,0.4);
      --border: rgba(255,255,255,0.07); --card: rgba(255,255,255,0.03);
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--white); overflow-x: hidden; }
    nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; display: flex; align-items: center; justify-content: space-between; padding: 18px 56px; border-bottom: 1px solid var(--border); background: rgba(5,5,8,0.85); backdrop-filter: blur(16px); }
    .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .logo-mark { width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, var(--teal), #0099a0); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800; color: #000; font-family: 'Syne', sans-serif; }
    .logo-text { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--white); }
    .logo-text span { color: var(--teal); }
    .nav-links { display: flex; align-items: center; gap: 28px; }
    .nav-links a { font-size: 13px; color: var(--white3); text-decoration: none; transition: color 0.2s; }
    .nav-links a:hover { color: var(--white); }
    .nav-cta { background: var(--teal) !important; color: #000 !important; padding: 9px 20px; border-radius: 6px; font-weight: 600 !important; }
    .nav-cta:hover { background: var(--teal2) !important; }
    .hero { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 140px 56px 80px; position: relative; overflow: hidden; }
    .hero-glow { position: absolute; top: 20%; left: 50%; transform: translateX(-50%); width: 700px; height: 400px; border-radius: 50%; background: radial-gradient(ellipse, rgba(0,94,219,0.12) 0%, transparent 70%); pointer-events: none; }
    .hero-grid { position: absolute; inset: 0; opacity: 0.04; background-image: linear-gradient(var(--white) 1px, transparent 1px), linear-gradient(90deg, var(--white) 1px, transparent 1px); background-size: 60px 60px; }
    .hero-badge { display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--teal-border); background: var(--teal-glow); padding: 6px 16px; border-radius: 100px; margin-bottom: 28px; font-size: 11px; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; color: var(--teal); animation: fadeUp 0.7s ease both; }
    .hero-badge::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--teal); }
    h1 { font-family: 'Syne', sans-serif; font-size: clamp(44px, 7vw, 88px); font-weight: 800; line-height: 1.0; letter-spacing: -0.03em; color: var(--white); margin-bottom: 22px; animation: fadeUp 0.7s 0.1s ease both; }
    h1 .teal { color: var(--teal); }
    .hero-sub { font-size: 17px; font-weight: 300; color: var(--white2); max-width: 520px; line-height: 1.75; margin-bottom: 40px; animation: fadeUp 0.7s 0.2s ease both; }
    .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; animation: fadeUp 0.7s 0.3s ease both; }
    .btn-primary { background: var(--teal); color: #000; padding: 13px 28px; border-radius: 7px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .btn-primary:hover { background: var(--teal2); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,94,219,0.3); }
    .btn-ghost { border: 1px solid var(--border); color: var(--white2); padding: 13px 28px; border-radius: 7px; font-size: 14px; text-decoration: none; transition: all 0.2s; }
    .btn-ghost:hover { border-color: rgba(255,255,255,0.2); color: var(--white); }
    .hero-stats { display: flex; margin-top: 80px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: var(--card); animation: fadeUp 0.7s 0.4s ease both; }
    .stat { padding: 24px 40px; border-right: 1px solid var(--border); text-align: center; }
    .stat:last-child { border-right: none; }
    .stat-num { font-family: 'Syne', sans-serif; font-size: 32px; font-weight: 800; color: var(--teal); letter-spacing: -0.02em; }
    .stat-label { font-size: 12px; color: var(--white3); margin-top: 4px; }
    .section { padding: 100px 56px; max-width: 1200px; margin: 0 auto; }
    .divider { width: 100%; height: 1px; background: var(--border); }
    .section-tag { display: inline-flex; align-items: center; gap: 8px; font-size: 11px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--teal); margin-bottom: 18px; }
    .section-tag::before { content:''; width:16px; height:1px; background:var(--teal); }
    h2 { font-family: 'Syne', sans-serif; font-size: clamp(32px, 4vw, 52px); font-weight: 800; line-height: 1.05; letter-spacing: -0.03em; color: var(--white); margin-bottom: 16px; }
    h2 .teal { color: var(--teal); }
    .section-sub { font-size: 15px; color: var(--white3); max-width: 480px; line-height: 1.7; }
    .fw-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-top: 48px; }
    .fw-card { background: var(--bg2); padding: 36px; transition: background 0.2s; }
    .fw-card:hover { background: var(--bg3); }
    .fw-icon { font-size: 28px; margin-bottom: 16px; }
    .fw-title { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: var(--white); margin-bottom: 10px; }
    .fw-desc { font-size: 13px; color: var(--white3); line-height: 1.7; margin-bottom: 18px; }
    .fw-tags { display: flex; flex-wrap: wrap; gap: 6px; }
    .fw-tag { font-size: 11px; padding: 3px 10px; border: 1px solid var(--teal-border); color: var(--teal); border-radius: 100px; }
    .courses-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-top: 48px; }
    .course-card { background: var(--bg2); padding: 32px; position: relative; transition: background 0.2s; }
    .course-card:hover { background: var(--bg3); }
    .course-card.featured { grid-column: span 2; }
    .course-badge { position: absolute; top: 20px; right: 20px; background: var(--teal); color: #000; font-size: 10px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; padding: 4px 10px; border-radius: 100px; }
    .course-emoji { font-size: 26px; margin-bottom: 16px; }
    .course-label { font-size: 10px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--teal); margin-bottom: 8px; }
    .course-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; color: var(--white); margin-bottom: 10px; letter-spacing: -0.02em; line-height: 1.2; }
    .course-desc { font-size: 13px; color: var(--white3); line-height: 1.65; margin-bottom: 20px; }
    .course-meta { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; }
    .course-price { font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800; color: var(--white); letter-spacing: -0.03em; }
    .course-price span { font-size: 13px; color: var(--white3); font-family: 'Inter', sans-serif; font-weight: 400; }
    .course-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
    .course-pill { font-size: 11px; color: var(--white3); border: 1px solid var(--border); padding: 3px 10px; border-radius: 100px; }
    .btn-sm { background: var(--teal); color: #000; padding: 9px 18px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; white-space: nowrap; transition: background 0.2s; }
    .btn-sm:hover { background: var(--teal2); }
    .btn-sm-ghost { border: 1px solid var(--border); color: var(--white3); padding: 9px 18px; border-radius: 6px; font-size: 12px; text-decoration: none; white-space: nowrap; }
    .testimonials-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-top: 48px; }
    .testimonial { border: 1px solid var(--border); padding: 28px; background: var(--bg2); border-radius: 10px; transition: border-color 0.2s; }
    .testimonial:hover { border-color: var(--teal-border); }
    .stars { color: var(--teal); font-size: 13px; margin-bottom: 14px; letter-spacing: 2px; }
    .t-text { font-size: 14px; color: var(--white2); line-height: 1.7; margin-bottom: 20px; font-style: italic; }
    .t-author strong { display: block; font-size: 13px; font-weight: 600; color: var(--white); margin-bottom: 2px; }
    .t-author span { font-size: 12px; color: var(--white3); }
    .faq-list { margin-top: 48px; border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .faq-item { border-bottom: 1px solid var(--border); }
    .faq-item:last-child { border-bottom: none; }
    .faq-q { width: 100%; text-align: left; padding: 22px 28px; background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 20px; font-size: 14px; font-weight: 500; color: var(--white); font-family: 'Inter', sans-serif; transition: background 0.2s; }
    .faq-q:hover { background: var(--card); }
    .faq-icon { color: var(--teal); font-size: 18px; flex-shrink: 0; transition: transform 0.3s; }
    .faq-a { padding: 0 28px 20px; font-size: 13px; color: var(--white3); line-height: 1.75; display: none; }
    .faq-item.open .faq-a { display: block; }
    .faq-item.open .faq-icon { transform: rotate(45deg); }
    .cta-section { margin: 0 56px 100px; padding: 72px; border: 1px solid var(--teal-border); border-radius: 16px; background: linear-gradient(135deg, rgba(0,94,219,0.06), rgba(0,94,219,0.02)); display: flex; align-items: center; justify-content: space-between; gap: 40px; position: relative; overflow: hidden; }
    .cta-section::before { content: ''; position: absolute; right: -80px; top: -80px; width: 320px; height: 320px; border-radius: 50%; background: radial-gradient(circle, rgba(0,94,219,0.1), transparent 70%); }
    .cta-title { font-family: 'Syne', sans-serif; font-size: 38px; font-weight: 800; color: var(--white); line-height: 1.1; letter-spacing: -0.03em; }
    .cta-title .teal { color: var(--teal); }
    .cta-sub { font-size: 14px; color: var(--white3); margin-top: 10px; }
    .cta-actions { display: flex; gap: 12px; flex-shrink: 0; }
    footer { border-top: 1px solid var(--border); padding: 36px 56px; display: flex; align-items: center; justify-content: space-between; }
    .footer-logo-text { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--white); }
    .footer-logo-text span { color: var(--teal); }
    .footer-links { display: flex; gap: 24px; }
    .footer-links a { font-size: 12px; color: var(--white3); text-decoration: none; }
    .footer-copy { font-size: 12px; color: var(--white3); }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 768px) {
      nav { padding: 16px 24px; } .nav-links { display: none; }
      .hero { padding: 100px 24px 60px; } .section { padding: 60px 24px; }
      .fw-grid, .courses-grid, .testimonials-grid { grid-template-columns: 1fr; }
      .course-card.featured { grid-column: span 1; }
      .cta-section { margin: 0 24px 60px; padding: 36px 28px; flex-direction: column; }
      footer { flex-direction: column; gap: 16px; text-align: center; padding: 28px 24px; }
      .hero-stats { flex-direction: column; }
      .stat { border-right: none !important; border-bottom: 1px solid var(--border); }
      .stat:last-child { border-bottom: none; }
    }
  </style>
</head>
<body>

<nav>
  <a href="https://www.peopleflow.io" class="nav-logo">
    <img src="/images/peopleflow-logo.avif" alt="Peopleflow" style="height:28px;width:auto;"> <span style="font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:#005edb;margin-left:4px">Academy</span>
  </a>
  <div class="nav-links">
    <a href="#courses">Courses</a>
    <a href="#for-who">Who It's For</a>
    <a href="#faq">FAQ</a>
    <a href="https://www.peopleflow.io">← Back to Peopleflow</a>
    <a href="{{ route('login') }}" class="nav-cta">Sign In</a>
  </div>
</nav>

<div class="hero">
  <div class="hero-glow"></div>
  <div class="hero-grid"></div>
  <div style="position:relative;z-index:1;width:100%;display:flex;flex-direction:column;align-items:center">
    <div class="hero-badge">Workday & SAP HCM Training</div>
    <h1>Master Workday.<br><span class="teal">Advance faster.</span></h1>
    <p class="hero-sub">Practical, process-led training for Workday and SAP consultants who want to go deeper — built by practitioners, for practitioners.</p>
    <div class="hero-actions">
      <a href="#courses" class="btn-primary">Explore Courses →</a>
      <a href="{{ route('login') }}" class="btn-ghost">Sign In</a>
    </div>
    <div class="hero-stats">
      <div class="stat"><div class="stat-num">4</div><div class="stat-label">Expert Courses</div></div>
      <div class="stat"><div class="stat-num">50+</div><div class="stat-label">Process Walkthroughs</div></div>
      <div class="stat"><div class="stat-num">100%</div><div class="stat-label">Practitioner-Built</div></div>
      <div class="stat"><div class="stat-num">∞</div><div class="stat-label">Lifetime Access</div></div>
    </div>
  </div>
</div>

<div class="divider"></div>

<section class="section" id="for-who">
  <div class="section-tag">Who It's For</div>
  <h2>Built for people who<br><span class="teal">implement</span> Workday</h2>
  <p class="section-sub">Not theoretical. Not generic HR software training. Deeply practical — built around real Workday processes.</p>
  <div class="fw-grid">
    <div class="fw-card">
      <div class="fw-icon">🧑‍💼</div>
      <div class="fw-title">Independent Consultants</div>
      <div class="fw-desc">Freelance Workday consultants who want to deepen functional knowledge, expand into new modules, and command higher rates.</div>
      <div class="fw-tags"><span class="fw-tag">Core HCM</span><span class="fw-tag">Recruitment</span><span class="fw-tag">Compensation</span></div>
    </div>
    <div class="fw-card">
      <div class="fw-icon">🏢</div>
      <div class="fw-title">Consulting Firms</div>
      <div class="fw-desc">Boutique and large consulting firms upskilling their Workday teams — faster onboarding, consistent knowledge, better delivery.</div>
      <div class="fw-tags"><span class="fw-tag">Team Licenses</span><span class="fw-tag">Progress Tracking</span><span class="fw-tag">Bulk Access</span></div>
    </div>
    <div class="fw-card">
      <div class="fw-icon">🎓</div>
      <div class="fw-title">Career Switchers</div>
      <div class="fw-desc">HR professionals and IT specialists transitioning into Workday consulting — get the process knowledge that separates juniors from seniors.</div>
      <div class="fw-tags"><span class="fw-tag">Beginner Friendly</span><span class="fw-tag">Step-by-Step</span><span class="fw-tag">Real Scenarios</span></div>
    </div>
    <div class="fw-card">
      <div class="fw-icon">⚙️</div>
      <div class="fw-title">Workday Customers</div>
      <div class="fw-desc">HR teams at companies running Workday who want super-users and HR analysts to truly understand the system they manage daily.</div>
      <div class="fw-tags"><span class="fw-tag">Super Users</span><span class="fw-tag">HR Analysts</span><span class="fw-tag">System Admins</span></div>
    </div>
  </div>
</section>

<div class="divider"></div>

<section class="section" id="courses">
  <div class="section-tag">The Curriculum</div>
  <h2>Deep-dive courses.<br><span class="teal">Real process walkthroughs.</span></h2>
  <p class="section-sub">Every course follows actual Workday configuration and transaction flows — exactly how you'd use them with a client.</p>
  <div class="courses-grid">
    <div class="course-card featured">
      <div class="course-badge">Most Popular</div>
      <div class="course-emoji">🏛️</div>
      <div class="course-label">Foundation</div>
      <div class="course-title">Core HR Foundations</div>
      <div class="course-desc">The definitive guide to Workday's Core HCM — org structures, worker types, staffing actions, and every fundamental HR transaction a consultant needs to know.</div>
      <div class="course-pills">
        <span class="course-pill">6 Lessons</span><span class="course-pill">4+ Hours</span><span class="course-pill">Step-by-step walkthroughs</span><span class="course-pill">Lifetime access</span>
      </div>
      <div class="course-meta">
        <div class="course-price">$299 <span>/ seat</span></div>
        <a href="{{ auth()->check() ? route('academy.checkout', 'core-hr-foundations') : route('register') . '?intended=' . urlencode(route('academy.checkout', 'core-hr-foundations')) }}" class="btn-sm">Enroll Now →</a>
      </div>
    </div>
    <div class="course-card">
      <div class="course-emoji">🔍</div>
      <div class="course-label">Talent Acquisition</div>
      <div class="course-title">Recruitment Package</div>
      <div class="course-desc">End-to-end Workday Recruiting — job requisitions, candidate pipelines, offer management, and hire flows.</div>
      <div class="course-meta" style="flex-direction:column;align-items:flex-start;gap:14px">
        <div class="course-price">$99 <span>/ seat</span></div>
        <a href="{{ auth()->check() ? route('academy.checkout', 'recruitment-package') : route('register') . '?intended=' . urlencode(route('academy.checkout', 'recruitment-package')) }}" class="btn-sm">Enroll Now →</a>
      </div>
    </div>
    <div class="course-card">
      <div class="course-emoji">💰</div>
      <div class="course-label">Total Rewards</div>
      <div class="course-title">Compensation Package</div>
      <div class="course-desc">Workday Compensation config — salary plans, grades, eligibility rules, and compensation reviews end-to-end.</div>
      <div class="course-meta" style="flex-direction:column;align-items:flex-start;gap:14px">
        <div class="course-price">$99 <span>/ seat</span></div>
        <a href="{{ auth()->check() ? route('academy.checkout', 'compensation-package') : route('register') . '?intended=' . urlencode(route('academy.checkout', 'compensation-package')) }}" class="btn-sm">Enroll Now →</a>
      </div>
    </div>
    <div class="course-card">
      <div class="course-emoji">⚡</div>
      <div class="course-label">New Release</div>
      <div class="course-title">Workday 2026 R1 Feature Enablement</div>
      <div class="course-desc">What's new in Workday's 2026 R1 — new features, changed processes, and what to communicate to clients.</div>
      <div class="course-meta" style="flex-direction:column;align-items:flex-start;gap:14px">
        <div class="course-price">$100 <span>/ seat</span></div>
        <a href="{{ route('login') }}" class="btn-sm-ghost">Coming Soon</a>
      </div>
    </div>
  </div>
</section>

<div class="divider"></div>

<section class="section" id="testimonials">
  <div class="section-tag">Testimonials</div>
  <h2>Trusted by Workday<br><span class="teal">practitioners worldwide</span></h2>
  <div class="testimonials-grid">
    <div class="testimonial">
      <div class="stars">★★★★★</div>
      <div class="t-text">"Finally — training that actually mirrors how Workday works in real implementations. Not a demo environment, but real process walkthroughs."</div>
      <div class="t-author"><strong>Sarah M.</strong><span>Senior Workday HCM Consultant, London</span></div>
    </div>
    <div class="testimonial">
      <div class="stars">★★★★★</div>
      <div class="t-text">"I've done Workday Pro training and various courses — this is the first one that felt like it was built by someone who's actually been in the trenches."</div>
      <div class="t-author"><strong>James K.</strong><span>Independent Consultant, Dubai</span></div>
    </div>
    <div class="testimonial">
      <div class="stars">★★★★★</div>
      <div class="t-text">"We enrolled our entire practice team. The step-by-step walkthroughs cut our onboarding time in half. Worth every penny."</div>
      <div class="t-author"><strong>Priya R.</strong><span>Practice Lead, HCM Consulting Firm</span></div>
    </div>
  </div>
</section>

<div class="divider"></div>

<section class="section" id="faq">
  <div class="section-tag">FAQ</div>
  <h2>Everything you<br><span class="teal">need to know</span></h2>
  <div class="faq-list">
    <div class="faq-item">
      <button class="faq-q" onclick="toggleFaq(this)">Do I need a live Workday tenant to follow along?<span class="faq-icon">+</span></button>
      <div class="faq-a">No. All lessons include full screen recordings of real Workday transactions. You can follow along visually without needing your own tenant.</div>
    </div>
    <div class="faq-item">
      <button class="faq-q" onclick="toggleFaq(this)">Is this for beginners or experienced consultants?<span class="faq-icon">+</span></button>
      <div class="faq-a">Both. Core HR Foundations suits those new to Workday but comes at a pace experienced consultants won't find boring. Module-specific courses go deeper for those who know the basics.</div>
    </div>
    <div class="faq-item">
      <button class="faq-q" onclick="toggleFaq(this)">Can I buy seats for my whole team?<span class="faq-icon">+</span></button>
      <div class="faq-a">Yes. Contact us at hello@peopleflow.io for team pricing. We offer volume discounts for 5+ seats with a dedicated org account and progress tracking.</div>
    </div>
    <div class="faq-item">
      <button class="faq-q" onclick="toggleFaq(this)">How long do I have access after purchasing?<span class="faq-icon">+</span></button>
      <div class="faq-a">Lifetime access. Come back to it whenever you need — refreshing knowledge before a new project or revisiting a specific process.</div>
    </div>
    <div class="faq-item">
      <button class="faq-q" onclick="toggleFaq(this)">What's your refund policy?<span class="faq-icon">+</span></button>
      <div class="faq-a">Full refund within 7 days of purchase if you're not satisfied — no questions asked. Email hello@peopleflow.io.</div>
    </div>
  </div>
</section>

<div class="cta-section">
  <div>
    <div class="cta-title">Ready to go<br><span class="teal">deeper into Workday?</span></div>
    <div class="cta-sub">Join consultants who've made Peopleflow Academy their edge.</div>
  </div>
  <div class="cta-actions">
    <a href="#courses" class="btn-primary">Browse Courses →</a>
    <a href="{{ route('login') }}" class="btn-ghost">Sign In</a>
  </div>
</div>

<footer>
  <div class="footer-logo-text">Peopleflow <span>Academy</span></div>
  <div class="footer-links">
    <a href="https://www.peopleflow.io">peopleflow.io</a>
    <a href="{{ route('login') }}">Sign In</a>
    <a href="mailto:hello@peopleflow.io">Contact</a>
  </div>
  <div class="footer-copy">© 2026 Peopleflow. All rights reserved.</div>
</footer>

<script>
function toggleFaq(btn) { btn.parentElement.classList.toggle('open'); }
</script>
</body>
</html>
