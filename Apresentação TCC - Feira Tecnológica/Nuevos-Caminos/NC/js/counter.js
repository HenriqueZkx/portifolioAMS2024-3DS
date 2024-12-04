function updateCounter() {
    const startDate = new Date('2024-02-08T00:00:00');
    const now = new Date();
    const elapsedTime = now - startDate;
    
    const days = Math.floor(elapsedTime / (1000 * 60 * 60 * 24));
    const hours = Math.floor((elapsedTime / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((elapsedTime / (1000 * 60)) % 60);
    const seconds = Math.floor((elapsedTime / 1000) % 60);

    document.getElementById('days').querySelector('.counter').textContent = days;
    document.getElementById('hours').querySelector('.counter').textContent = hours;
    document.getElementById('minutes').querySelector('.counter').textContent = minutes;
    document.getElementById('seconds').querySelector('.counter').textContent = seconds;
}

updateCounter();
setInterval(updateCounter, 1000); // Atualiza a cada segundo