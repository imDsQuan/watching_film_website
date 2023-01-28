import {Component, OnInit} from '@angular/core';
import {User} from "../../../../shared/models/user/User";
import {UserService} from "../../../../core/services/auth/user/user.service";

@Component({
  selector: 'app-profile-edit',
  templateUrl: './profile-edit.component.html',
  styleUrls: ['./profile-edit.component.scss']
})
export class ProfileEditComponent implements OnInit {

  user ?: User;
  hasSub?: boolean;
  public form = {
    full_name: '',
    email: '',
    phone: '',
  };

  constructor(
    private User: UserService,
  ) {
  }

  ngOnInit(): void {
    this.user = this.User.get();
    this.hasSub = this.user?.subscription != null
  }


  onSubmit() {

  }
}
