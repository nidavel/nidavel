import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// function removeNotice(id)
// {
//     let notice = document.querySelector(`#${id}`);
//     let container = notice.parentElement;

//     fetch(`/notices/remove/${id}`)
//     .then((res) => {
//         if (res.ok) {
//             return res;
//         }
//     })
//     .then((data) => {
//         container.removeChild(notice);
//     });
// }

// function showDashboardAlerts()
// {
//     let alertId = document.querySelector('#dashboard_alert_id');
//     alertId.innerHTML = parseDashboardAlerts();
//     alertId.classList.remove('hidden');
// }

// function emitDashboardAlert(title, message,type)
// {
//     const d = new Date();
//     d.setTime(d.getTime() + 15000);
//     document.cookie = `dashboard-alerts= ${title}|${message}|${type};expires=${d.toUTCString()};SameSite=Strict;secure;`;
// }

// // window.onload = () => emitDashboardAlert('Congratulations', 'Your application installed successfully', 'success');

// function parseDashboardAlerts()
// {
//     let html = '';
//     let alerts = [];
//     let alert = '';
//     let cname = 'dashboard-alerts';
//     let name = `${cname}=`;
//     let ca = decodeURIComponent(document.cookie);
//     let alertArr = ca.split(';');
//     for (let i = 0; i <alertArr.length; i++) {
//         let c = alertArr[i];
//         while (c.charAt(0) == ' ') {
//             c = c.substring(1);
//         }
//         if (c.indexOf(name) == 0) {
//             alert = c.substring(name.length, c.length);
//             break;
//         }
//     }

//     if (alert.length == 0) {
//         return [];
//     }

//     alerts = (alert.split('=')[0]).split('|');
//     // console.log(alerts);

//     let alertType = alerts[2] != undefined ? alerts[2] : 'info';
//     html += `<div class="alert alert-${alertType}">`;
//     html += `<div class="alert-title">${alerts[0]}</div>`;
//     html += `<div class="alert-msg">${alerts[1]}</div>`;
//     html += `</div>`;

//     return html;
// }

// var timer;
// function removeDashboardAlerts()
// {
//     let alertId = document.querySelector('#dashboard_alert_id');
//     alertId.classList.add('alert-fade');

//     timer = setTimeout(() => {
//         clearTimeout(timer);
//         alertId.classList.add('hidden');
//         // alertId.innerHTML = alertId.firstElementChild.outerHTML;
//     }, 15000);
// }

// setInterval(() => {
//     let alerts = parseDashboardAlerts();
//     console.log(`interval`);
//     if (alerts.length > 0) {
//         showDashboardAlerts();
//         removeDashboardAlerts();
//     }
// }, 5000);

// let alertBox = document.querySelector('#dashboard_alert_id');
// alertBox.onmouseover = () => {
//     clearTimeout(timer);
//     alertBox.classList.remove('alert-fade');
//     alertBox.style.display = 'block';
//     alertBox.classList.remove('hidden');
// }
// alertBox.onmouseout = () => {
//     alertBox.style.display = '';
//     alertBox.style.cssText = '';
//     removeDashboardAlerts();
// }
