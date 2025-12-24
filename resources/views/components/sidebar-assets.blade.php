<!-- Sidebar assets: font, shared sidebar CSS and JS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; }

  /* Icon button styles shared by Explore & Profile modals */
  .icon-btn { background:#f7f7f7; border:none; padding:4px; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:50%; }
  .icon-btn img { width:14px; height:14px; transition: transform 160ms ease, opacity 160ms ease; display:block; }
  .icon-btn:hover { background:#efefef; }
  .icon-animate { transform: scale(1.12); }

  /* Ensure main container has left padding so fixed sidebar doesn't cover content */
  /* Increased from 72px to 96px to provide breathing room for hero image */
  .container { padding-left: 96px !important; transition: padding-left 0.28s ease; }
  /* Make header account for the sidebar so navbar/logo aren't covered */
  header { margin-left: 96px; transition: margin-left 0.28s ease; z-index: 100; position: relative; }
  /* When sidebar opens, keep consistent offset +24px to leave breathing space */
  body.sidebar-open header { margin-left: 284px; }

  /* Sidebar CSS (kept minimal to avoid collisions) */
  .app-sidebar { position: fixed; left: 0; top: 0; height: 100vh; width: 72px; background: #000000ff; border-right: 1px solid #000000ff; box-shadow: 2px 0 10px rgba(0,0,0,0.03); transition: width 0.28s ease, box-shadow 0.28s ease; z-index: 9998; overflow: hidden; display: flex; flex-direction: column; align-items: flex-start; padding-top: 6px; padding-left: 8px; cursor: pointer; }
  .app-sidebar.open { width: 260px; box-shadow: 6px 0 30px rgba(255, 255, 255, 0.08); }
  .sidebar-brand { width: 100%; display: flex; align-items: center; gap: 10px; padding: 6px 10px 6px 6px; cursor: pointer; margin-bottom: 4px; box-sizing: border-box; }
  .sidebar-brand .brand-img { width: 40px; height: 40px; border-radius: 6px; overflow: hidden; display: inline-block; opacity: 1; transform: scale(.94) translateX(-2px); transition: opacity 0.22s cubic-bezier(.2,.9,.2,1), transform 0.22s cubic-bezier(.2,.9,.2,1), width 0.22s; }
  .sidebar-brand .brand-img img { width: 100%; height: 100%; object-fit: contain; display: block; }
  .brand-label { display: inline-flex; flex-direction: column; gap: 0; line-height: 1; font-size: 14px; color: #ffffffff; opacity: 0; transform: translateX(-6px); transition: opacity 0.25s cubic-bezier(.2,.9,.2,1), transform 0.25s cubic-bezier(.2,.9,.2,1); }
  .brand-line-1 { font-weight: 800; font-size:14px; }
  .brand-line-2 { font-weight: 800; font-size:14px; }
  .app-sidebar.open .brand-label { opacity: 1; transform: translateX(0); }
  .app-sidebar:not(.open) .brand-img { opacity: 1; transform: scale(.9); }
  .app-sidebar.open { align-items: flex-start; padding-left: 14px; }
  .app-sidebar.open .brand-img { width:48px; height:48px; opacity:1; transform: none; }
  .sidebar-list { list-style: none; padding: 0; margin: 0; width: 100%; }
  .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; cursor: pointer; color: #ffffffff; transition: background 0.18s, color 0.18s; }
  .sidebar-item:hover { background: #ffffffff; color: black; }
  .sidebar-icon { width: 40px; height: 40px; min-width: 40px; border-radius: 50%; background: #000000ff; display: inline-flex; align-items: center; justify-content: center; overflow: hidden; }
  .sidebar-icon:hover { background: #f0f0f0ff; }
  .sidebar-icon img { width: 100%; height: 100%; object-fit: cover; display: block; }
  .sidebar-label { white-space: nowrap; opacity: 0; transform: translateX(-6px); transition: opacity 0.2s, transform 0.2s; font-weight: 600; }
  .app-sidebar.open .sidebar-label { opacity: 1; transform: translateX(0); }
 
  /* Ensure container pushed when sidebar opens */
  .container.sidebar-open { padding-left: 284px !important; }
  @media (max-width:768px) { .container { padding-left: 16px !important; } .app-sidebar { left:-260px; width:260px; transition:left .28s ease; } .app-sidebar.open { left:0; } }

  /* Add breathing space for hero imagery next to sidebar to prevent being visually covered */
  .hero-image { margin-left: 8px; }

  /* Notification Panel */
  .notification-panel {
    position: fixed;
    right: -350px;
    top: 0;
    width: 350px;
    height: 100vh;
    background: white;
    border-left: 1px solid #eee;
    box-shadow: -4px 0 15px rgba(0,0,0,0.1);
    transition: right 0.3s ease;
    z-index: 9997;
    display: flex;
    flex-direction: column;
  }

  .notification-panel.show {
    right: 0;
  }

  .notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eee;
    background: #f9f9f9;
  }

  .notification-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #333;
  }

  .close-notification {
    font-size: 28px;
    cursor: pointer;
    color: #999;
    line-height: 1;
    transition: color 0.2s;
  }

  .close-notification:hover {
    color: #333;
  }

  .notification-list {
    flex: 1;
    overflow-y: auto;
    padding: 0;
  }

  .notification-item {
    display: flex;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background 0.2s;
  }

  .notification-item:hover {
    background: #f9f9f9;
  }

  .notif-avatar {
    width: 40px;
    height: 40px;
    min-width: 40px;
    border-radius: 50%;
    background: #efefef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .notif-content {
    flex: 1;
  }

  .notif-title {
    margin: 0 0 4px 0;
    font-weight: 600;
    font-size: 14px;
    color: #333;
  }

  .notif-message {
    margin: 0 0 6px 0;
    font-size: 13px;
    color: #666;
    line-height: 1.4;
  }

  .notif-time {
    font-size: 12px;
    color: #999;
  }

</style>

<script>
// Shared sidebar JS (works without visible toggle)
(function(){
  const sidebar = document.getElementById('appSidebar');
  const closeBtnSidebar = document.getElementById('sidebarClose');
  const containerEl = document.querySelector('.container');
  if (!sidebar || !containerEl) return;
  function isSmall(){return window.innerWidth<=768}
  function openSidebar(){
    sidebar.classList.add('open');
    if(!isSmall()) containerEl.classList.add('sidebar-open');
    document.body.classList.add('sidebar-open');
    sidebar.setAttribute('aria-hidden','false');
    if(closeBtnSidebar) closeBtnSidebar.style.display = isSmall() ? 'block' : 'none';
  }
  function closeSidebar(){
    sidebar.classList.remove('open');
    containerEl.classList.remove('sidebar-open');
    document.body.classList.remove('sidebar-open');
    sidebar.setAttribute('aria-hidden','true');
    if(closeBtnSidebar) closeBtnSidebar.style.display='none';
  }
  // click inside collapsed sidebar opens it
  sidebar.addEventListener('click', function(e){ if(!sidebar.classList.contains('open')){ const brandAnchor = e.target.closest('.brand-link'); if(brandAnchor) e.preventDefault(); openSidebar(); e.stopPropagation(); } });
  // close button mobile
  if(closeBtnSidebar) closeBtnSidebar.addEventListener('click', function(e){ e.stopPropagation(); closeSidebar(); });
  // click outside closes
  document.addEventListener('click', function(e){ const clickedInsideSidebar = sidebar.contains(e.target); if(!clickedInsideSidebar && sidebar.classList.contains('open')) closeSidebar(); });
  // esc to close
  document.addEventListener('keydown', function(e){ if(e.key==='Escape' && sidebar.classList.contains('open')) closeSidebar(); });
  window.addEventListener('resize', function(){ if(sidebar.classList.contains('open')){ if(!isSmall()) containerEl.classList.add('sidebar-open'); else containerEl.classList.remove('sidebar-open'); } });
  // sync body class on load
  if (containerEl.classList.contains('sidebar-open')) document.body.classList.add('sidebar-open');
})();

// Notification Panel JS
(function(){
  const notificationTrigger = document.querySelector('.notification-trigger');
  const notificationPanel = document.getElementById('notificationPanel');
  const closeNotification = document.getElementById('closeNotification');
  
  if (!notificationTrigger || !notificationPanel) return;
  
  // Open notification panel when clicking notification menu item
  notificationTrigger.addEventListener('click', function(e) {
    e.stopPropagation();
    notificationPanel.classList.add('show');
  });
  
  // Close notification panel
  closeNotification.addEventListener('click', function(e) {
    e.stopPropagation();
    notificationPanel.classList.remove('show');
  });
  
  // Close when clicking outside
  document.addEventListener('click', function(e) {
    if (!notificationPanel.contains(e.target) && !notificationTrigger.contains(e.target)) {
      notificationPanel.classList.remove('show');
    }
  });
  
  // Close with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      notificationPanel.classList.remove('show');
    }
  });
})();
</script>
