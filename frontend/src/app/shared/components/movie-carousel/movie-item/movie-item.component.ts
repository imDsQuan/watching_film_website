import {Component, Input, OnInit, Renderer2} from '@angular/core';
import {Poster} from "../../../models/poster/poster";

@Component({
  selector: 'app-movie-item',
  templateUrl: './movie-item.component.html',
  styleUrls: ['./movie-item.component.scss']
})
export class MovieItemComponent implements OnInit {
  @Input() poster: Poster | undefined;

  constructor() { }

  ngOnInit(): void {
  }

}
