import {Component, ElementRef, Input, OnInit, ViewChild} from '@angular/core';
import {Actor} from "../../../models/actor/actor";

@Component({
  selector: 'app-actor-item',
  templateUrl: './actor-item.component.html',
  styleUrls: ['./actor-item.component.scss']
})
export class ActorItemComponent implements OnInit {
  @Input() actor: Actor | undefined;

  constructor() { }

  ngOnInit(): void {
  }

}
