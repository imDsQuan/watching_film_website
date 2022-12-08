import {Component, ElementRef, Inject, OnInit, Renderer2, ViewChild} from '@angular/core';
import {Source} from "../../../shared/models/source/source";
import {ActivatedRoute} from "@angular/router";
import {MAT_DIALOG_DATA} from "@angular/material/dialog";
import {MovieService} from "../../../core/services/movie/movie.service";

@Component({
  selector: 'app-movie-player',
  templateUrl: './movie-player.component.html',
  styleUrls: ['./movie-player.component.scss']
})
export class MoviePlayerComponent implements OnInit {

  @ViewChild('btnSource') btnSource: ElementRef | undefined;
  @ViewChild('lstSource') lstSource: ElementRef | undefined;


  slug: string | undefined | null;
  source!: Source;

  lstSources: Source[] = [];
  type: string | undefined | null;


  constructor(
    private renderer: Renderer2,
    private route: ActivatedRoute,
    private ms: MovieService,
  ) {
  }

  ngOnInit(): void {

    this.ms.getSource(this.route.snapshot.paramMap.get('slug')).subscribe(
      data => {
        this.lstSources = data;
        this.route.queryParams.subscribe(
          params => {
            this.slug = this.route.snapshot.paramMap.get('slug');
            this.type = params['type'];
            if (this.type) {
              for (let s of this.lstSources) {
                if (s.type == this.type) {
                  this.source = s;
                  break;
                }
              }
            } else {
              this.source = this.lstSources[0];
              this.type = this.lstSources[0].type;
            }
          }
        )
      }
    );


  }

  openListSource() {
    console.log(this.lstSource?.nativeElement.style.display);
    if (this.lstSource?.nativeElement.style.display == 'none') {
      this.renderer.setStyle(this.lstSource?.nativeElement, 'display', 'block');
    } else {
      this.renderer.setStyle(this.lstSource?.nativeElement, 'display', 'none');
    }
  }

}
