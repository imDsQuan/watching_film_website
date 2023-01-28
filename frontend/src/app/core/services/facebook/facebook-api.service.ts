import {Injectable} from '@angular/core';
import {ToastrService} from "ngx-toastr";
import {ApiService} from "../auth/api/api.service";
import {TokenService} from "../auth/token/token.service";
import {Router} from "@angular/router";
import {AuthService} from "../auth/auth.service";
import {UserService} from "../auth/user/user.service";


@Injectable({
  providedIn: 'root'
})


export class FacebookApiService {

  constructor(
    private toastr: ToastrService,
    private Api: ApiService,
    private Token: TokenService,
    private router: Router,
    private Auth: AuthService,
    private User: UserService,
  ) {
  }


  loginWithFacebook() {
    console.log("submit login to facebook");
    // FB.login();
    FB.login((response: any) => {
      console.log('submitLogin', response);
      if (response.authResponse) {
        console.log(response.authResponse.accessToken);
        // this.toastr.success('login successful', 'Success!');
        this.Api.loginWithFacebook(response.authResponse.accessToken).subscribe(
          data => {
            this.handleResponse(data);
          }
        )
      } else {
        console.log('User login failed');
      }
    });
  }

  handleResponse(data: any) {
    console.log(data);
    this.Token.handle(data.access_token);
    this.router.navigateByUrl('/');
    this.Auth.changeAuthStatus(true);
    this.User.set(data.user);
    window.location.reload();
  }

  facebookLogout() {

    // @ts-ignore
    // FBlogout();
  }
}
