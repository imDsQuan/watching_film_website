import {Component, Input, OnInit} from '@angular/core';
import {Cast} from "../../../models/cast/cast";

@Component({
  selector: 'app-cast-item',
  templateUrl: './cast-item.component.html',
  styleUrls: ['./cast-item.component.scss']
})
export class CastItemComponent implements OnInit {
  @Input() cast: Cast | undefined;

  constructor() { }

  ngOnInit(): void {
  }

}
