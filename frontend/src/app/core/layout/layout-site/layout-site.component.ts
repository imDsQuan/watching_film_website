import { Component, OnInit } from '@angular/core';
import {TokenService} from "../../services/auth/token/token.service";
import {AuthService} from "../../services/auth/auth.service";
import {Router} from "@angular/router";
import {UserService} from "../../services/auth/user/user.service";
import {User} from "../../../shared/models/user/User";

@Component({
  selector: 'app-layout-site',
  templateUrl: './layout-site.component.html',
  styleUrls: ['./layout-site.component.scss']
})
export class LayoutSiteComponent implements OnInit {
  active: boolean = false;

  user: User | null | undefined;

  constructor(
    private Auth: AuthService,
    private router: Router,
    private Token: TokenService,
    private User: UserService,
  ) { }

  ngOnInit(): void {
    this.user = this.User.get();
  }

  showNav() {
    this.active = !this.active
  }

  logout(event: MouseEvent) {
    event.preventDefault();
    this.Token.remove();
    this.Auth.changeAuthStatus(false);
    this.router.navigateByUrl('/login');
    this.User.remove();
  }
}
