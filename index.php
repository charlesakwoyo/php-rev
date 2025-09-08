<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ink & Ideas</title>
  <style>
    
    
    :root {
      --bg: #0b0d13;
      --card: #121622;
      --soft: #1a2030;
      --text: #e8ebf1;
      --muted: #a7b1c2;
      --brand: #7c9eff;
      --brand-2: #9bffd1;
      --ring: #2a3652;
      --shadow: 0 10px 30px rgba(0,0,0,.35);
      --radius: 18px;
      --radius-sm: 12px;
      --maxw: 1100px;
    }

    * { box-sizing: border-box; }
    html, body { height: 100%; }

    body {
      margin: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      background: radial-gradient(1200px 700px at 80% -10%, rgba(124,158,255,.25), transparent 60%),
                  radial-gradient(900px 600px at -10% 20%, rgba(155,255,209,.18), transparent 60%),
                  var(--bg);
      color: var(--text);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    a { color: inherit; text-decoration: none; }
    img { max-width: 100%; display: block; }

    .container { width: min(100% - 2rem, var(--maxw)); margin-inline: auto; }

    
    header {
      position: sticky; top: 0; z-index: 10;
      backdrop-filter: blur(8px);
      background: linear-gradient(180deg, rgba(11,13,19,.7), rgba(11,13,19,.35));
      border-bottom: 1px solid rgba(124,158,255,.15);
    }

    .nav {
      display: flex; align-items: center; justify-content: space-between;
      padding: .9rem 0;
    }

    .brand {
      display: inline-flex; gap: .6rem; align-items: center; font-weight: 700; letter-spacing:.3px;
    }
    .brand-badge {
      width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--brand), var(--brand-2));
      display: grid; place-items: center; color: #0b1020; font-weight: 900;
      box-shadow: 0 6px 18px rgba(124,158,255,.35);
    }

    .menu { display: flex; gap: 1.2rem; align-items: center; }
    .menu a { color: var(--muted); font-weight: 600; }
    .menu a:hover { color: var(--text); }

    .cta {
      padding: .65rem 1rem; border-radius: 999px; font-weight: 700; border: 1px solid var(--ring);
      background: linear-gradient(180deg, rgba(124,158,255,.18), rgba(124,158,255,.05));
      color: var(--text);
      box-shadow: inset 0 0 0 1px rgba(124,158,255,.15);
    }
    .cta:hover { box-shadow: inset 0 0 0 1px rgba(124,158,255,.35); }


    .hero { padding: 4.5rem 0 3rem; }

    .hero-grid {
      display: grid; grid-template-columns: 1.2fr .8fr; gap: 2rem; align-items: center;
    }

    .eyebrow { color: var(--brand-2); font-weight: 800; letter-spacing: .18em; text-transform: uppercase; font-size: .8rem; }

    .hero h1 {
      font-size: clamp(2rem, 2.2rem + 2vw, 3.4rem);
      line-height: 1.1; margin: .6rem 0 1rem;
      text-wrap: balance;
    }

    .lead { color: var(--muted); font-size: clamp(1rem, .95rem + .3vw, 1.15rem); }

    .hero-actions { display: flex; gap: .8rem; margin-top: 1.25rem; flex-wrap: wrap; }
    .btn {
      background: linear-gradient(135deg, var(--brand), #5f86ff);
      border: none; color: #0b0d13; font-weight: 900; padding: .8rem 1.1rem; border-radius: 12px; cursor: pointer;
      box-shadow: var(--shadow);
    }
    .btn.secondary { background: transparent; color: var(--text); border: 1px solid var(--ring); box-shadow: none; }

    .hero-card {
      border-radius: var(--radius);
      background: linear-gradient(180deg, rgba(26,32,48,.8), rgba(18,22,34,.95));
      border: 1px solid rgba(124,158,255,.18);
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .hero-media {
      aspect-ratio: 16/10; background:
        radial-gradient(1000px 400px at 0% 0%, rgba(124,158,255,.25), transparent 60%),
        linear-gradient(120deg, rgba(155,255,209,.25), rgba(124,158,255,.25));
      display: grid; place-items: center; color: #0b0d13; font-weight: 900; font-size: 1.1rem;
    }
    .hero-media span { background: #fff; padding: .35rem .6rem; border-radius: 8px; box-shadow: 0 8px 20px rgba(124,158,255,.35); }

    .hero-card footer { display: flex; gap: 1rem; align-items: center; padding: .9rem 1rem; border-top: 1px dashed rgba(124,158,255,.2); color: var(--muted); }
    .dot { width: 8px; height: 8px; border-radius: 999px; background: var(--brand); box-shadow: 0 0 0 6px rgba(124,158,255,.12); }

    
    section { padding: 2rem 0 3rem; }
    .section-head { display: flex; justify-content: space-between; align-items: end; gap: 1rem; margin-bottom: 1.2rem; }
    .section-head h2 { margin: 0; font-size: clamp(1.4rem, 1.2rem + .9vw, 2rem); }
    .section-head p { margin: 0; color: var(--muted); }

    .grid {
      display: grid; gap: 1rem;
      grid-template-columns: repeat(12, 1fr);
    }
    .card {
      grid-column: span 4;
      background: var(--card); border: 1px solid rgba(124,158,255,.15); border-radius: var(--radius);
      overflow: hidden; display: flex; flex-direction: column; min-height: 100%;
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .card:hover { transform: translateY(-4px); box-shadow: var(--shadow); border-color: rgba(124,158,255,.35); }

    .thumb { aspect-ratio: 16/9; background: linear-gradient(135deg, rgba(124,158,255,.45), rgba(155,255,209,.35)); }
    .content { padding: 1rem; display: grid; gap: .6rem; }
    .meta { color: var(--muted); font-size: .9rem; }
    .tags { display: flex; gap: .4rem; flex-wrap: wrap; }
    .tag { font-size: .75rem; padding: .25rem .55rem; border-radius: 999px; background: rgba(124,158,255,.12); border: 1px solid rgba(124,158,255,.22); color: var(--text); }

    .readmore { margin-top: auto; padding: 1rem; border-top: 1px dashed rgba(124,158,255,.18); color: var(--brand-2); font-weight: 700; }


    .newsletter { border: 1px solid rgba(124,158,255,.18); background: linear-gradient(180deg, rgba(18,22,34,.8), rgba(18,22,34,.95)); border-radius: var(--radius); padding: 1.2rem; display: grid; gap: .8rem; }
    .nl-grid { display: grid; gap: .8rem; grid-template-columns: 1.2fr .8fr; }

    .field {
      display: grid; grid-template-columns: 1fr auto; gap: .5rem; background: var(--soft); border: 1px solid rgba(124,158,255,.18); border-radius: 12px; padding: .35rem;
    }
    .field input { border: none; outline: none; background: transparent; padding: .75rem .8rem; color: var(--text); font: inherit; }
    .field button { border: none; padding: .65rem 1rem; border-radius: 10px; background: linear-gradient(135deg, var(--brand), #5f86ff); color: #0b0d13; font-weight: 800; cursor: pointer; }

    
    footer.site {
      padding: 2.5rem 0; color: var(--muted);
    }
    .foot-grid { display: grid; gap: 1rem; grid-template-columns: 1fr auto; align-items: center; }
    .foot-links { display: flex; gap: 1rem; flex-wrap: wrap; }
    .copyright { font-size: .9rem; }

    
    @media (max-width: 900px) {
      .hero-grid, .nl-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 720px) {
      .menu { display: none; }
      .card { grid-column: span 6; }
    }
    @media (max-width: 520px) {
      .card { grid-column: 1 / -1; }
      .hero { padding-top: 3.25rem; }
    }
  </style>
</head>
<body>
  
  <header>
    <div class="container nav" role="navigation" aria-label="Main">
      <a href="#" class="brand">
        <span class="brand-badge" aria-hidden="true">I&</span>
        <span>Ink & Ideas</span>
      </a>
      <nav class="menu">
        <a href="#featured">Featured</a>
        <a href="#topics">Topics</a>
        <a href="#newsletter">Newsletter</a>
        <a href="#login" class="btn-login">Login</a>
        <a href="#signup" class="btn-signup">Sign Up</a>
        <a class="cta" href="#latest">Read Latest</a>
      </nav>
    </div>
  </header>


  <section class="hero">
    <div class="container hero-grid">
      <div>
        <div class="eyebrow">Fresh takes, every week</div>
        <h1>Stories on design, code, and the creative process.</h1>
        <p class="lead">Practical tutorials, opinion pieces, and industry interviews — curated for makers. Zero fluff, just useful reads.</p>
        <div class="hero-actions">
          <a class="btn" href="#featured">Explore Articles</a>
          <a class="btn secondary" href="#newsletter">Subscribe</a>
        </div>
      </div>

      
    </div>
  </section>

  <section id="featured">
    <div class="container">
      <div class="section-head">
        <h2>Featured Posts</h2>
        <p>Hand-picked reads to get you started.</p>
      </div>

      <div class="grid">
        <article class="card">
          <div class="thumb" role="img" aria-label="Gradient thumbnail"></div>
          <div class="content">
            <div class="tags">
              <span class="tag">Design</span><span class="tag">Accessibility</span>
            </div>
            <h3>Color systems that scale across themes</h3>
            <p class="meta">7 min read · By Alex</p>
            <a class="readmore" href="#">Read article </a>
          </div>
        </article>

        <article class="card">
          <div class="thumb" role="img" aria-label="Gradient thumbnail"></div>
          <div class="content">
            <div class="tags">
              <span class="tag">Code</span><span class="tag">CSS</span>
            </div>
            <h3>Modern layouts with only CSS grid</h3>
            <p class="meta">6 min read · By Collins </p>
            <a class="readmore" href="#">Read article </a>
          </div>
        </article>

    
        <article class="card">
          <div class="thumb" role="img" aria-label="Gradient thumbnail"></div>
          <div class="content">
            <div class="tags">
              <span class="tag">Career</span><span class="tag">Interviews</span>
            </div>
            <h3>What hiring managers really look for</h3>
            <p class="meta">9 min read · By Eliana G.</p>
            <a class="readmore" href="#">Read article </a>
          </div>
        </article>

        
        <article class="card">
          <div class="thumb" role="img" aria-label="Gradient thumbnail"></div>
          <div class="content">
            <div class="tags">
              <span class="tag">Tutorial</span><span class="tag">HTML</span>
            </div>
            <h3>Semantic HTML that improves SEO</h3>
            <p class="meta">5 min read · By Akwoyo G.</p>
            <a class="readmore" href="#">Read article </a>
          </div>
        </article>

        
        <article class="card">
          <div class="thumb" role="img" aria-label="Gradient thumbnail"></div>
          <div class="content">
            <div class="tags">
              <span class="tag">Inspiration</span>
            </div>
            <h3>From idea to launch in 30 days</h3>
            <p class="meta">8 min read · By Charles A.</p>
            <a class="readmore" href="#">Read article </a>
          </div>
        </article>

        
        <article class="card">
          <div class="thumb" role="img" aria-label="Gradient thumbnail"></div>
          <div class="content">
            <div class="tags">
              <span class="tag">Process</span><span class="tag">Writing</span>
            </div>
            <h3>Outlining blog posts like a pro</h3>
            <p class="meta">4 min read · By Brian O.</p>
            <a class="readmore" href="#">Read article </a>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section id="newsletter">
    <div class="container newsletter">
      <div class="section-head">
        <h2>Join the newsletter</h2>
        <p>Get the latest posts in your inbox every Friday.</p>
      </div>

      <div class="nl-grid">
        <p class="lead">No spam, ever. Just hand-crafted articles on design, code, and product. Unsubscribe in one click.</p>
        <form class="field" action="#" method="post" onsubmit="return false" aria-label="Subscribe form">
          <label class="sr-only" for="email">Email</label>
          <input id="email" type="email" placeholder="you@example.com" required />
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
  </section>

  <footer class="site">
    <div class="container foot-grid">
      <div class="copyright">© <span id="year"></span> Ink & Ideas. All rights reserved.</div>
      <nav class="foot-links">
        <a href="#">About</a>
        <a href="#">Contact</a>
        <a href="#">Privacy</a>
        <a href="#">RSS</a>
      </nav>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
