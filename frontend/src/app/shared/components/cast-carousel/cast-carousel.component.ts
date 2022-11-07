import {Component, ElementRef, Input, OnInit, Renderer2, ViewChild} from '@angular/core';
import {Actor} from "../../models/actor/actor";
import {Cast} from "../../models/cast/cast";

@Component({
  selector: 'app-cast-carousel',
  templateUrl: './cast-carousel.component.html',
  styleUrls: ['./cast-carousel.component.scss']
})
export class CastCarouselComponent implements OnInit {

  @Input() lstCast: Cast[] | undefined;
  @Input() total: number | undefined;

  @ViewChild('castList') castList: ElementRef | undefined;

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
    if (this.lstCast!.length - (4 + this.clickCounter) + (4 - this.ratio) >= 0) {
      this.renderer.setStyle(this.castList?.nativeElement, 'transform', `translateX(${this.castList?.nativeElement.computedStyleMap().get("transform")[0].x.value - 190}px)`);
      this.activeLeft = true;
    } else {
      this.renderer.setStyle(this.castList?.nativeElement, 'transform', `translateX(0)`);
      this.clickCounter = 0;
      this.activeLeft = false;
    }
  }

  pre() {
    if (this.castList?.nativeElement.computedStyleMap().get("transform")[0].x.value  <= -190) {
      this.renderer.setStyle(this.castList?.nativeElement, 'transform', `translateX(${this.castList?.nativeElement.computedStyleMap().get("transform")[0].x.value + 190}px)`);
    }
    if (this.castList?.nativeElement.computedStyleMap().get("transform")[0].x.value  >= -190) {
      this.activeLeft = false;
    }

  }

}
