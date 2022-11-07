import {Component, ElementRef, Input, OnInit, Renderer2, ViewChild} from '@angular/core';
import {Poster} from "../../models/poster/poster";

@Component({
  selector: 'app-movie-carousel',
  templateUrl: './movie-carousel.component.html',
  styleUrls: ['./movie-carousel.component.scss']
})
export class MovieCarouselComponent implements OnInit {
  @ViewChild('movieList') movieList: ElementRef | undefined;

  @Input() lstPoster: Poster[] | undefined;

  clickCounter : number = 0;
  //Movie Item Width = 310px;
  ratio : number = Math.floor(window.innerWidth / 310);
  activeLeft: boolean = false;

  constructor(
    private renderer: Renderer2,
  ) { }

  ngOnInit(): void {
  }

  next() {
    this.clickCounter++;
    if (this.lstPoster!.length - (4 + this.clickCounter) + (4 - this.ratio) >= 0) {
      this.renderer.setStyle(this.movieList?.nativeElement, 'transform', `translateX(${this.movieList?.nativeElement.computedStyleMap().get("transform")[0].x.value - 310}px)`);
      this.activeLeft = true;
    } else {
      this.renderer.setStyle(this.movieList?.nativeElement, 'transform', `translateX(0)`);
      this.clickCounter = 0;
      this.activeLeft = false;
    }
  }

  pre() {
    if (this.movieList?.nativeElement.computedStyleMap().get("transform")[0].x.value  <= -310) {
      this.renderer.setStyle(this.movieList?.nativeElement, 'transform', `translateX(${this.movieList?.nativeElement.computedStyleMap().get("transform")[0].x.value + 310}px)`);
    }
    if (this.movieList?.nativeElement.computedStyleMap().get("transform")[0].x.value  >= -310) {
      this.activeLeft = false;
    }

  }

}
