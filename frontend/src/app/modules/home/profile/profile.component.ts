import { Component, OnInit } from '@angular/core';
import {User} from "../../../shared/models/user/User";
import {UserService} from "../../../core/services/auth/user/user.service";

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit {

  user ?: User;
  hasSub?: boolean ;

  constructor(
    private User: UserService,
  ) { }

  ngOnInit(): void {
    this.user = this.User.get();
    this.hasSub = this.user?.subscription != null
  }

}
