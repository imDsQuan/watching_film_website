import {Component, ElementRef, OnInit, Renderer2, ViewChild} from '@angular/core';
import {Source} from "../../../shared/models/source/source";
import {ActivatedRoute} from "@angular/router";
import {MovieService} from "../../../core/services/movie/movie.service";
import {TvshowService} from "../../../core/services/tvshow/tvshow.service";

@Component({
  selector: 'app-tvshow-player',
  templateUrl: './tvshow-player.component.html',
  styleUrls: ['./tvshow-player.component.scss']
})
export class TvshowPlayerComponent implements OnInit {
  @ViewChild('btnSource') btnSource: ElementRef | undefined;
  @ViewChild('lstSource') lstSource: ElementRef | undefined;

  slug: string | undefined | null;
  source!: Source;

  lstSources: Source[] = [];
  type: string | undefined | null;
  episodeId: string | undefined | null;

  constructor(
    private renderer: Renderer2,
    private route: ActivatedRoute,
    private ms: TvshowService,
  ) {
  }

  ngOnInit(): void {

    this.ms.getSource(this.route.snapshot.paramMap.get('slug'), this.route.snapshot.paramMap.get('episodeId')).subscribe(
      data => {
        this.lstSources = data;
        this.route.queryParams.subscribe(
          params => {
            this.slug = this.route.snapshot.paramMap.get('slug');
            this.type = params['type'];
            this.episodeId = this.route.snapshot.paramMap.get('episodeId');
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
