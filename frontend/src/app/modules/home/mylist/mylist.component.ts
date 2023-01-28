import { Component, OnInit } from '@angular/core';
import {MyListService} from "../../../core/services/myList/my-list.service";
import {Poster} from "../../../shared/models/poster/poster";
import {UserService} from "../../../core/services/auth/user/user.service";
import {User} from "../../../shared/models/user/User";

@Component({
  selector: 'app-mylist',
  templateUrl: './mylist.component.html',
  styleUrls: ['./mylist.component.scss']
})
export class MylistComponent implements OnInit {
  lstMovie: Poster[] | undefined;

  user: User | undefined;

  constructor(
    private MyList: MyListService,
    private User : UserService,
  ) { }

  ngOnInit(): void {
    this.user = this.User.get();
    this.MyList.getAll(this.user).subscribe(
      data => {
        console.log(data);
        this.lstMovie = data
      },
    )
  }

  removeFromList(id: number | undefined) {
    this.MyList.removeFromList({'item_id': id}).subscribe(
      data => {
        this.MyList.getAll(this.user).subscribe(
          data => {
            console.log(data);
            this.lstMovie = data
          },
        )
      }
    )
  }
}
