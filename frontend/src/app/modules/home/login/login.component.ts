import { Component, OnInit } from '@angular/core';
import {ApiService} from "../../../core/services/auth/api/api.service";
import {TokenService} from "../../../core/services/auth/token/token.service";
import {Router} from "@angular/router";
import {AuthService} from "../../../core/services/auth/auth.service";
import {UserService} from "../../../core/services/auth/user/user.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
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
  ) { }

  ngOnInit(): void {
  }

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
    this.error = error.error.error;
  }
}
