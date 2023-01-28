import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {TvshowService} from "../../../core/services/tvshow/tvshow.service";
import {MovieService} from "../../../core/services/movie/movie.service";
import {ActorService} from "../../../core/services/actor/actor.service";
import {Actor} from "../../../shared/models/actor/actor";
import {Poster} from "../../../shared/models/poster/poster";

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.scss']
})
export class SearchComponent implements OnInit {
  lstActor: Actor[] = [] ;
  lstMovie: Poster[] = [];
  lstTvShow: Poster[] = [];

  keyword: string | null = '';

  constructor(
    private route: ActivatedRoute,
    private TV: TvshowService,
    private Movie : MovieService,
    private Actor: ActorService,
  ) {
  }

  ngOnInit(): void {
    this.keyword = this.route.snapshot.queryParamMap.get("keyword");

    this.TV.search(this.keyword).subscribe(
      data => this.lstTvShow = data,
    )

    this.Actor.search(this.keyword).subscribe(
      data => this.lstActor = data,
    )

    this.Movie.search(this.keyword).subscribe(
      data => this.lstMovie = data,
    )

  }

}
