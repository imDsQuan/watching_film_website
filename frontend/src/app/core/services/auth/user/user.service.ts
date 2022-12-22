import { Injectable } from '@angular/core';
import {BehaviorSubject, Subject} from "rxjs";
import {User} from "../../../../shared/models/user/User";
import {MyListService} from "../../myList/my-list.service";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  set(user: any) {
    localStorage.setItem('user', JSON.stringify(user));
  }

  get() {
    // @ts-ignore
    return JSON.parse(localStorage.getItem('user'));
  }

  remove() {
    localStorage.removeItem('user');
  }

  constructor(
    private MyList: MyListService,
  ) { }

}
