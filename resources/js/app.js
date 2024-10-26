import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    // скрывать уведомления после небольшой задержки
    const elements = document.querySelectorAll(".hide_after_delay");

    setTimeout(() => {
        elements.forEach(element => {
            // Применяем стили для плавного исчезновения
            element.style.opacity = "0";
        });
    }, 2500); // Задержка перед исчезновением в 3 секунды
});

