    .ee-prop-card {
        background: #fff;
        border: 1px solid #ebe5d8;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .ee-prop-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(0,0,0,.09); }
    .ee-prop-media { position: relative; display: block; height: 250px; overflow: hidden; background: #1a1a1a; }
    .ee-prop-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .ee-prop-card:hover .ee-prop-media img { transform: scale(1.05); }
    .ee-prop-status, .ee-prop-verified {
        position: absolute;
        top: 14px;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .ee-prop-status { left: 14px; background: #111111; color: #bb9e5b; }
    .ee-prop-status.is-offplan { background: #bb9e5b; color: #fff; }
    .ee-prop-status.is-rent { background: #fff; color: #111111; }
    .ee-prop-verified { right: 14px; background: rgba(255,255,255,.92); color: #111111; }
    .ee-prop-verified i { color: #bb9e5b; margin-right: 4px; }
    .ee-prop-body { padding: 22px; display: flex; flex-direction: column; flex-grow: 1; }
    .ee-prop-price { font-family: Avenir-Heavy; font-size: 21px; color: #bb9e5b; }
    .ee-prop-price small { font-size: 13px; color: #6f6f6f; margin-left: 3px; font-family: myFirstFont; }
    .ee-prop-title { font-family: Avenir-Heavy; font-size: 17px; margin: 6px 0 6px; line-height: 1.35; }
    .ee-prop-title a { color: #111111; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .ee-prop-title a:hover { color: #bb9e5b; }
    .ee-prop-location { color: #6f6f6f; font-size: 14px; margin-bottom: 16px; }
    .ee-prop-location i { color: #bb9e5b; margin-right: 7px; }
    .ee-prop-specs {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        padding: 14px 0 0;
        margin: auto 0 0;
        border-top: 1px solid #ebe5d8;
        font-size: 13px;
        color: #444;
    }
    .ee-prop-specs i { color: #bb9e5b; margin-right: 6px; }
