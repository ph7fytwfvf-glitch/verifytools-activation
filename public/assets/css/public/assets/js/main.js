document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('activation-form');
  if (!form) return;
  form.addEventListener('submit', function(e) {
    const btn = document.getElementById('activate-btn');
    btn.disabled = true;
    btn.innerText = 'Activating...';
    setTimeout(()=>{ btn.disabled=false; btn.innerText='Activate'; }, 1200);
  });
});
