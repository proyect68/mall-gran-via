<style>
    body { font-family: 'Montserrat', sans-serif; background: #09b7b1; color: #1f1f4e; overflow-x: hidden; }
    .app-header { background: #cac9ff; color: #fff; padding: 18px 0; position: sticky; top: 0; z-index: 1030; }
    .app-header .search-box { background: #fff; border-radius: 999px; padding: 10px 18px; padding-right: 48px; border: none; width: 100%; }
    .app-header .search-box:focus { outline: none; box-shadow: 0 0 0 3px rgba(111,98,240,0.18); }
    
    .result-group { display: grid; grid-template-columns: repeat(7, 1fr); gap: 20px; }
    @media (max-width: 1400px) { .result-group { grid-template-columns: repeat(5, 1fr); } }
    @media (max-width: 1200px) { .result-group { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 992px) { .result-group { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .result-group { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .result-group { grid-template-columns: 1fr; } }
    
    .product-card { background: #cac9ff; border-radius: 22px; overflow: hidden; padding: 0; box-shadow: 0 20px 35px rgba(64,69,148,0.08); transition: transform 0.25s ease; display: flex; flex-direction: column; }
    .product-card:hover { transform: translateY(-8px); }
    .product-card img { width: 100%; height: 200px; object-fit: cover; }
    .product-card-body { padding: 18px; display: flex; flex-direction: column; height: 100%; }
    .product-card-title { font-weight: 700; margin-bottom: 8px; font-size: 1rem; color: #3735af; }
    .product-card-store { color: #3735af; font-size: 0.9rem; margin-bottom: 12px; }
    .product-card-prices { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
    .product-card-prices strong { font-size: 1.1rem; color: #3735af; font-weight: 700; }
    .product-card-prices del { color: #9ea0c4; font-size: 0.9rem; }
    .product-card-offer { display: inline-flex; align-items: center; justify-content: center; border-radius: 999px; padding: 7px 14px; font-size: 0.78rem; font-weight: 700; color: #fff; align-self: flex-start; }
    .offer-red { background: #e9524c; }
    .offer-blue { background: #2b8fe0; }
    .offer-purple { background: #7d5cff; }
    
    .pagination-container { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; margin-bottom: 40px; flex-wrap: wrap; }
    .pagination-btn { background: #3735af; color: #fff; border: 2px solid #3735af; border-radius: 4px; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
    .pagination-btn:hover { background: #2f2a9b; border-color: #2f2a9b; }
    .pagination-btn.active { background: #3735af; color: #fff; border-color: #3735af; }
    .pagination-btn.disabled { opacity: 0.5; cursor: not-allowed; background: #8a88c2; border-color: #8a88c2; }
    
    .footer-app { background: #17193a; color: #d8d8ff; padding: 60px 0; }
    .footer-app h5 { color: #fff; font-weight: 700; margin-bottom: 18px; }
    .footer-app a { color: #d2d4ff; text-decoration: none; }
    .footer-app a:hover { color: #fff; }
    
    .section-title { font-weight: 700; letter-spacing: 1px; margin-bottom: 12px; }
    .section-subtitle { color: #6c7190; margin-bottom: 24px; }
    
    .filter-field { margin-bottom: 22px; }
    .filter-panel .form-check-input::before { content: "✗"; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); color: white; font-size: 0.8em; }
    .filter-panel .form-check-input:checked::before { content: "✓"; }
    
    .stores-carousel { display: flex; gap: 16px; overflow-x: hidden; scroll-behavior: smooth; padding-bottom: 10px; }
    .store-card { flex: 0 0 320px; height: 360px; background: #cac9ff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.25s ease, box-shadow 0.25s ease; display: flex; flex-direction: column; }
    .store-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
    .store-card-image { width: 100%; height: 200px; background: linear-gradient(135deg, #cac9ff 0%, #a8a7d6 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0; position: relative; overflow: hidden; }
    .store-card-image::before { content: '🏪'; font-size: 4rem; opacity: 0.3; }
    .store-card-body { padding: 18px 18px 24px 18px; flex: 1; display: flex; flex-direction: column; }
    .store-card-name { font-weight: 700; margin-bottom: 12px; font-size: 1.05rem; color: #3735af; }
    .store-card-info { font-size: 0.95rem; color: #3735af; margin-bottom: 12px; font-weight: 500; }
    .store-card-status { display: inline-flex; align-items: center; gap: 5px; font-size: 0.78rem; font-weight: 600; padding: 6px 12px; border-radius: 999px; background: #e8f5e9; color: #2e7d32; align-self: flex-start; }
</style>
