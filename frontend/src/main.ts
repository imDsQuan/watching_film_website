import { enableProdMode } from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';

import { AppModule } from './app/app.module';
import { environment } from './environments/environment';

if (environment.production) {
  enableProdMode();
}

platformBrowserDynamic().bootstrapModule(AppModule)
  .catch(err => console.error(err));


const arrowRights = document.querySelectorAll(".movie-list-wrapper .arrow-right");
const arrowLefts = document.querySelectorAll(".movie-list-wrapper .arrow-left");
const movieLists = document.querySelectorAll(".movie-list");

console.log(movieLists)

arrowRights.forEach((arrowRight, i) => {
  const itemNumber = movieLists[i].querySelectorAll('img').length;
  const ratio = Math.floor(window.innerWidth / 310);
  let clickCounter = 0;
  arrowRight.addEventListener("click", () => {
    console.log(123123);
    clickCounter++;
    console.log(itemNumber - (4 + clickCounter)  + (4 - ratio));
    if (itemNumber - (4 + clickCounter)  + (4 - ratio) >= 0) {
      movieLists[i].setAttribute("style", "transform: translateX(${\n" +
        "        movieLists[i].computedStyleMap().get(\"transform\")[0].x.value -310\n" +
        "      }px)`");
      arrowLefts[i].setAttribute("style", "display: block");
    } else {
      movieLists[i].setAttribute("style", "transform: translateX(0)");
      clickCounter = 0;
      arrowLefts[i].setAttribute("style", "display: none");
    }

  })
})

// arrowLefts.forEach((arrowLeft, i) => {
//   const itemNumber = movieLists[i].querySelectorAll('img').length;
//   arrowLeft.addEventListener("click", () => {
//     console.log(movieLists[i].computedStyleMap().get("transform")[0].x.value);
//     if (movieLists[i].computedStyleMap().get("transform")[0].x.value <= -310) {
//       movieLists[i].style.transform = `translateX(${
//         movieLists[i].computedStyleMap().get("transform")[0].x.value + 310
//       }px)`;
//     }
//     if(movieLists[i].computedStyleMap().get("transform")[0].x.value >= -310) {
//       arrowLeft.style.display = "none";
//     }
//
//   })
// })
//
//
// const arrowActorRights = document.querySelectorAll(".actor-list-wrapper .arrow-right");
// const arrowActorLefts = document.querySelectorAll(".actor-list-wrapper .arrow-left");
// const actorLists = document.querySelectorAll(".actor-list");
//
// console.log(actorLists)
//
// arrowActorRights.forEach((arrowRight, i) => {
//   const itemNumber = actorLists[i].querySelectorAll('img').length;
//   const ratio = Math.floor(window.innerWidth / 190);
//   let clickCounter = 0;
//   arrowRight.addEventListener("click", () => {
//     clickCounter++;
//     console.log(itemNumber - (4 + clickCounter)  + (4 - ratio));
//     if (itemNumber - (4 + clickCounter)  + (4 - ratio) >= 0) {
//       actorLists[i].style.transform = `translateX(${
//         actorLists[i].computedStyleMap().get("transform")[0].x.value -190
//       }px)`;
//       arrowActorLefts[i].style.display = "inline";
//     } else {
//       actorLists[i].style.transform = 'translateX(0)';
//       clickCounter = 0;
//       arrowActorLefts[i].style.display = "none";
//     }
//
//   })
// })
//
// arrowActorLefts.forEach((arrowLeft, i) => {
//   const itemNumber = actorLists[i].querySelectorAll('img').length;
//   arrowLeft.addEventListener("click", () => {
//     console.log(actorLists[i].computedStyleMap().get("transform")[0].x.value);
//     if (actorLists[i].computedStyleMap().get("transform")[0].x.value <= -190) {
//       actorLists[i].style.transform = `translateX(${
//         actorLists[i].computedStyleMap().get("transform")[0].x.value + 190
//       }px)`;
//     }
//     if(actorLists[i].computedStyleMap().get("transform")[0].x.value >= -190) {
//       arrowLeft.style.display = "none";
//     }
//
//   })
// })
//
// const btnToggleMenu = document.getElementById('btn-toggle-menu');
// const menuToggle = document.getElementById('menu-list-toggle');
//
// console.log(menuToggle);
//
// btnToggleMenu.onclick = function () {
//   menuToggle.classList.toggle('d-none');
// }
