import { enableProdMode } from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';

import { AppModule } from './app/app.module';
import { environment } from './environments/environment';

if (environment.production) {
  enableProdMode();
}

platformBrowserDynamic().bootstrapModule(AppModule)
  .catch(err => console.error(err));

(window as any).fbAsyncInit = function () {
  FB.init({
    appId: '830560648045666',
    cookie: true,
    xfbml: true,
    version: 'v3.1'
  });
  FB.AppEvents.logPageView();
};
(function (d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {
    return;
  }
  js = d.createElement(s);
  js.id = id;
  // @ts-ignore
  js.src = "https://connect.facebook.net/en_US/sdk.js";
  // @ts-ignore
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

