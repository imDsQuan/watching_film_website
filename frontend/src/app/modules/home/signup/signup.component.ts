import { Component, OnInit } from '@angular/core';
import {FormGroup} from "@angular/forms";
import {HttpClient} from "@angular/common/http";
import {ApiService} from "../../../core/services/auth/api/api.service";
import {TokenService} from "../../../core/services/auth/token/token.service";
import {Router} from "@angular/router";
import {UserService} from "../../../core/services/auth/user/user.service";

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.scss']
})
export class SignupComponent implements OnInit {

  public error = {
    full_name: null,
    email: null,
    username: null,
    password: null,
    password_confirmation: null,
  };

  public form = {
    full_name: null,
    email: null,
    username: null,
    password: null,
    password_confirmation: null,
  }

  constructor(
    private Api: ApiService,
    private Token: TokenService,
    private router: Router,
    private User: UserService,
  ) { }

  ngOnInit(): void {
  }

  onSubmit() {
    this.Api.signup(this.form).subscribe(
      data => this.handleResponse(data),
      error=> this.handleError(error),
    )
  }

  handleResponse(data: any) {
    this.Token.handle(data.access_token);
    this.router.navigateByUrl('');
    this.User.set(data.user);
  }

  private handleError(error: any) {
    this.error = error.error.errors;
  }
}
