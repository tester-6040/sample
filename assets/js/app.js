if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/assets/js/sw.js').catch(console.error);
}
if (window.cycleData && document.getElementById('cycleChart')) {
  const labels = window.cycleData.map(p => p.start_date);
  const durations = window.cycleData.map(p => {
    const start = new Date(p.start_date);
    const end = new Date(p.end_date);
    return Math.round((end - start) / 86400000) + 1;
  });
  new Chart(document.getElementById('cycleChart'), {
    type: 'line',
    data: { labels, datasets: [{ label: 'Period Duration', data: durations, borderColor: '#ec4899' }] }
  });
}
