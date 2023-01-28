import { Component, OnInit } from '@angular/core';
import {ApiService} from "../../../core/services/auth/api/api.service";
import {TokenService} from "../../../core/services/auth/token/token.service";
import {Router} from "@angular/router";
import {AuthService} from "../../../core/services/auth/auth.service";
import {UserService} from "../../../core/services/auth/user/user.service";
import {GoogleApiService} from "../../../core/services/google-api/google-api.service";
import {ToastrService} from "ngx-toastr";
import { ViewChild,ElementRef } from '@angular/core'
import {FacebookApiService} from "../../../core/services/facebook/facebook-api.service";


declare var FB: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  @ViewChild('loginRef', {static: true})
  loginElement!: ElementRef;

  auth2: any;

  public form = {
    username: null,
    password: null,
  }
  private error: any;


  constructor(
    private Api: ApiService,
    private Token: TokenService,
    private router: Router,
    private Auth: AuthService,
    private User: UserService,
    private toastr: ToastrService,
    private FB: FacebookApiService,
    private GG : GoogleApiService,
  ) { }


  onSubmit() {
    this.Api.login(this.form).subscribe(
      data=> this.handleResponse(data),
      error=> this.handleError(error)
    )
  }

  handleResponse(data: any) {
    this.Token.handle(data.access_token);
    this.router.navigateByUrl('');
    this.Auth.changeAuthStatus(true);
    this.User.set(data.user);
  }

  handleError(error : any) {
    this.error = error.error.message;
    this.toastr.error(this.error);
  }

  loggedIn: boolean | undefined;


  ngOnInit() {
    this.GG.googleInitialize(this.loginElement);
  }


  prepareLogin() {
    this.auth2.attachClickHandler(this.loginElement.nativeElement, {},
      (googleUser : any) => {
        let profile = googleUser.getBasicProfile();
        console.log('Token || ' + googleUser.getAuthResponse().id_token);
        // this.show = true;
        // this.Name =  profile.getName();
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail());
      }, (error : any) => {
        alert(JSON.stringify(error, undefined, 2));
      });
  }

  loginWithFacebook(){
    this.FB.loginWithFacebook();
  }
}
