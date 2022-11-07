import {Component, ElementRef, OnInit, Renderer2, ViewChild} from '@angular/core';
import {Poster} from "../../../shared/models/poster/poster";
import {PosterService} from "../../../core/services/poster/poster.service";
import {Actor} from "../../../shared/models/actor/actor";
import {ActorService} from "../../../core/services/actor/actor.service";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {


  feature : Poster | undefined;
  lstPoster : Poster[] | undefined;
  lstActor : Actor[] | undefined;
  lstPosterAdventure: Poster[] | undefined;
  lstPosterAction: Poster[] | undefined;
  lstPosterHorror: Poster[] | undefined;
  lstPosterCrime: Poster[] | undefined;
  constructor(
    private posterService: PosterService,
    private actorService: ActorService,
  ) { }

  ngOnInit(): void {
    this.posterService.getFeature().subscribe(
      (value) => {
        this.feature = value
      }
    );
    this.posterService.getNewRelease().subscribe(
      (value => {
        this.lstPoster = value
      })
    );
    this.actorService.getPopular().subscribe(
      (value) => {
        this.lstActor = value
      }
    );
    this.posterService.getByGenre('Action').subscribe(
      (value) =>{
        this.lstPosterAction = value;
      }
    )
    this.posterService.getByGenre('Adventure').subscribe(
      (value) =>{
        this.lstPosterAdventure = value;
      }
    )
    this.posterService.getByGenre('Horror').subscribe(
      (value) =>{
        this.lstPosterHorror = value;
      }
    )
    this.posterService.getByGenre('Crime').subscribe(
      (value) =>{
        this.lstPosterCrime = value;
      }
    )
  }


}
