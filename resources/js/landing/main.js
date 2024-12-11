import { testWebP } from "./webp_detector.js";

// Определяет поддержку webp изображений и добавляет класс для body
testWebP((support) => {
    if (support === true) {
        document.querySelector('body').classList.add('webp');
    } else {
        document.querySelector('body').classList.add('no-webp');
    }
});

// Плавный скролл при клике на пункты меню
document.querySelectorAll('.nav a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Функционал для раскрывающихся FAQ
document.querySelectorAll('.faq-question').forEach((question) => {
    question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        const isOpen = answer.classList.toggle('open');
        question.classList.toggle('active', isOpen);
    });
});

// Эффект стелющегося дыма с градиентом
const canvas = document.createElement('canvas');
canvas.id = 'cursorCanvas';
document.body.appendChild(canvas);
const ctx = canvas.getContext('2d');

let particles = [];

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

// Создаем частицы дыма с направлением противоположным движению курсора
function createParticle(x, y, dx, dy) {
    const angle = Math.atan2(dy, dx) + (Math.random() * Math.PI - Math.PI / 2); // Увеличенный угол рассеивания
    const speed = Math.random() * 1 + 0.5; // Скорость частиц
    return {
        x: x,
        y: y,
        size: Math.random() * 20 + 15, // Уменьшенный начальный размер частиц для более компактного эффекта возле курсора
        speedX: -speed * Math.cos(angle), // Движение противоположное направлению курсора с учетом случайного угла
        speedY: -speed * Math.sin(angle),
        opacity: 0.2 + Math.random() * 0.3, // Более высокая начальная прозрачность
        life: 200 + Math.random() * 200 // Длительное время жизни частицы
    };
}

// Рендер частиц с градиентом
function renderParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((particle, index) => {
        particle.x += particle.speedX;
        particle.y += particle.speedY;
        particle.size += 0.3; // Медленное увеличение размера частицы
        particle.opacity -= 0.004; // Медленное затухание прозрачности

        if (particle.opacity <= 0) {
            particles.splice(index, 1);
        } else {
            ctx.beginPath();
            const gradient = ctx.createRadialGradient(
                particle.x,
                particle.y,
                0,
                particle.x,
                particle.y,
                particle.size
            );
            gradient.addColorStop(0, `rgba(148, 0, 211, ${particle.opacity})`); // Сиреневый центр
            gradient.addColorStop(1, `rgba(255, 20, 147, 0)`); // Прозрачный розовый край
            ctx.fillStyle = gradient;
            ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            ctx.fill();
        }
    });
}

// Добавление новых частиц при движении курсора
function updateParticles(e) {
    const dx = e.movementX; // Изменение положения курсора по X
    const dy = e.movementY; // Изменение положения курсора по Y

    for (let i = 0; i < 15; i++) {
        particles.push(createParticle(e.clientX, e.clientY, dx, dy));
    }
    renderParticles();
}

// Обработка движения курсора
window.addEventListener('mousemove', updateParticles);
window.addEventListener('touchmove', (e) => {
    if (e.touches.length > 0) {
        updateParticles(e.touches[0]);
    }
});

// Анимация частиц
function animate() {
    renderParticles();
    requestAnimationFrame(animate);
}

animate();



// прозрачность хедера при прокрутке

window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 50) {
        header.style.backgroundColor = 'rgba(29, 29, 29, 0.4)'; /* Больше прозрачности при прокрутке */
    } else {
        header.style.backgroundColor = 'rgba(29, 29, 29, 0.6)'; /* Меньше прозрачности, когда вверху */
    }
});

