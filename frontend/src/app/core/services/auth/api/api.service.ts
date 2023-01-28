import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {TokenService} from "../token/token.service";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private baseUrl = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    private Token: TokenService,
  ) {}

  signup(data : any) {
    return this.http.post(`${this.baseUrl}/register`, data);
  }

  login(data : any) {
    return this.http.post(`${this.baseUrl}/login`, data);
  }

  sendPasswordResetLink(data : any) {
    return this.http.post(`${this.baseUrl}/sendPasswordResetLink`, data);
  }

  changePassword(data : any) {
    return this.http.post(`${this.baseUrl}/resetPassword`, data);
  }

  logout() {
    let header = new HttpHeaders().set("Authorization", 'Bearer ' + this.Token.get());
    return this.http.get(`${this.baseUrl}/logout`, {headers: header});
  }

  loginWithGoogle(token: any){
    return this.http.post(`${this.baseUrl}/login-with-google`, {'token' : token});
  }

  loginWithFacebook(token: any) {
    return this.http.post(`${this.baseUrl}/login-with-facebook`, {'token' : token});
  }
}
