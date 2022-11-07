import { Component, OnInit } from '@angular/core';
import {Title} from "@angular/platform-browser";

@Component({
  selector: 'app-actor',
  templateUrl: './actor.component.html',
  styleUrls: ['./actor.component.scss']
})
export class ActorComponent implements OnInit {

  constructor(
    private titleService: Title,
  ) {
    titleService.setTitle('ShineFlex - All Actor')
  }

  ngOnInit(): void {
  }

}
