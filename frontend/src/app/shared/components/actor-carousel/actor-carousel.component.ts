import {Component, ElementRef, Input, OnInit, Renderer2, ViewChild} from '@angular/core';
import {Actor} from "../../models/actor/actor";

@Component({
  selector: 'app-actor-carousel',
  templateUrl: './actor-carousel.component.html',
  styleUrls: ['./actor-carousel.component.scss']
})
export class ActorCarouselComponent implements OnInit {
  @Input() lstActor: Actor[] | undefined;
  @ViewChild('actorList') actorList: ElementRef | undefined;

  clickCounter : number = 0;
  //Movie Item Width = 190px;
  ratio : number = Math.floor(window.innerWidth / 190);
  activeLeft: boolean = false;

  constructor(
    private renderer: Renderer2,
  ) { }

  ngOnInit(): void {
  }

  next() {
    this.clickCounter++;
    if (this.lstActor!.length - (4 + this.clickCounter) + (4 - this.ratio) >= 0) {
      this.renderer.setStyle(this.actorList?.nativeElement, 'transform', `translateX(${this.actorList?.nativeElement.computedStyleMap().get("transform")[0].x.value - 190}px)`);
      this.activeLeft = true;
    } else {
      this.renderer.setStyle(this.actorList?.nativeElement, 'transform', `translateX(0)`);
      this.clickCounter = 0;
      this.activeLeft = false;
    }
  }

  pre() {
    if (this.actorList?.nativeElement.computedStyleMap().get("transform")[0].x.value  <= -190) {
      this.renderer.setStyle(this.actorList?.nativeElement, 'transform', `translateX(${this.actorList?.nativeElement.computedStyleMap().get("transform")[0].x.value + 190}px)`);
    }
    if (this.actorList?.nativeElement.computedStyleMap().get("transform")[0].x.value  >= -190) {
      this.activeLeft = false;
    }

  }

}
