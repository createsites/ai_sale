import './bootstrap';
import { Marked } from 'marked';
import { markedHighlight } from "marked-highlight";
import hljs from 'highlight.js';
import 'highlight.js/styles/github.css';

document.addEventListener("DOMContentLoaded", function () {
    // скрывать уведомления после небольшой задержки
    const elements = document.querySelectorAll(".hide_after_delay");

    setTimeout(() => {
        elements.forEach(element => {
            // Применяем стили для плавного исчезновения
            element.style.opacity = "0";
        });
    }, 2500); // Задержка перед исчезновением в 3 секунды

    // подсвечивать синтаксис чата при первой загрузке страницы
    const chatHistory = document.getElementById('chat_history');
    if (chatHistory) {
        highlightResponse(chatHistory);
    }
});


// Прилепляем форму для вопроса ИИ сверху при прокрутке страницы
// величина скролла, при которой форма станет position: fixed
const SCROLL_POINT = 330;
const requestForm = document.getElementById('request_ai');

if (requestForm) {
    window.addEventListener('scroll', function () {
        if (window.scrollY >= SCROLL_POINT) {
            requestForm.classList.add('fixed');
        } else {
            requestForm.classList.remove('fixed');
        }
    });
}

// Оформление ответов чата
// Преобразование markdown в HTML
// Подсветка синтаксиса кода с помощью highlight.js

const marked = new Marked(
    markedHighlight({
        emptyLangClass: 'hljs',
        langPrefix: 'hljs language-',
        highlight(code, lang, info) {
            const language = hljs.getLanguage(lang) ? lang : 'plaintext';
            return hljs.highlight(code, { language }).value;
        }
    })
);

// подсветка синтаксиса
const highlightResponse = function(elem = document) {
    elem.querySelectorAll('.response_ai').forEach(function(elem) {
        // innerHTML заменяет символ > на &gt;
        // чтобы избежать этого, используем textContent
        // innerText тоже помогает, но он не сохраняет форматирование (отступы)
        elem.innerHTML = marked.parse(elem.textContent.trim());
    });
}

// ловим кастомный event из chat.blade.php
document.addEventListener('chat.updated', function(e) {
    // новый элемент чата приходит в событии
    const chatHistory = e.detail.elem;
    // подсвечиваем
    // без задержки не работает
    // querySelectorAll('.response_ai') не находит ничего
    setTimeout(() => {
        highlightResponse(chatHistory);
    }, 100)
});
