import {ElementRef, Injectable} from '@angular/core';
import {ApiService} from "../auth/api/api.service";
import {TokenService} from "../auth/token/token.service";
import {Router} from "@angular/router";
import {AuthService} from "../auth/auth.service";
import {UserService} from "../auth/user/user.service";

@Injectable({
  providedIn: 'root'
})
export class GoogleApiService {

  auth2: any;


  constructor(private Api: ApiService,
              private Token: TokenService,
              private router: Router,
              private Auth: AuthService,
              private User: UserService) {
  }

  googleInitialize(loginElement: ElementRef) {
    // @ts-ignore
    window['googleSDKLoaded'] = () => {
      // @ts-ignore
      window['gapi'].load('auth2', () => {
        // @ts-ignore
        this.auth2 = window['gapi'].auth2.init({
          client_id: '631867203803-gfnbuj33563dmuorhmfm6cv2prqasulq.apps.googleusercontent.com',
          cookie_policy: 'single_host_origin',
          scope: 'profile email'
        });
        this.prepareLogin(loginElement);
      });
    }
    (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      // @ts-ignore
      js.src = "https://apis.google.com/js/platform.js?onload=googleSDKLoaded";
      // @ts-ignore
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'google-jssdk'));
  }

  prepareLogin(loginElement: ElementRef) {
    this.auth2.attachClickHandler(loginElement.nativeElement, {},
      (googleUser: any) => {
        let profile = googleUser.getBasicProfile();
        console.log('Token || ' + googleUser.getAuthResponse().id_token);
        // this.show = true;
        // this.Name =  profile.getName();
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail());
        this.Api.loginWithGoogle(googleUser.getAuthResponse().id_token).subscribe(
          (data: any) => {
            this.Token.handle(data.access_token);
            this.router.navigateByUrl('/');
            this.Auth.changeAuthStatus(true);
            this.User.set(data.user);
            window.location.reload();
          }
        );
      }, (error: any) => {
        alert(JSON.stringify(error, undefined, 2));
      });
  }

  googleLogout() {
    // @ts-ignore
    window['googleSDKLoaded'] = () => {
      // @ts-ignore
      window['gapi'].load('auth2', () => {
        // @ts-ignore
        this.auth2 = window['gapi'].auth2.init({
          client_id: '631867203803-gfnbuj33563dmuorhmfm6cv2prqasulq.apps.googleusercontent.com',
          cookie_policy: 'single_host_origin',
          scope: 'profile email'
        });
        // @ts-ignore
        var au2 = window['gapi'].auth2.getAuthInstance();
        au2.signOut().then(function () {
          au2.disconnect();
        });
      });
    }
    // @ts-ignore



  }

}
