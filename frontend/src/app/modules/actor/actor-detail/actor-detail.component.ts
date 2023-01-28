import { Component, OnInit } from '@angular/core';
import {Actor} from "../../../shared/models/actor/actor";
import {ActorService} from "../../../core/services/actor/actor.service";
import {ActivatedRoute} from "@angular/router";
import {Poster} from "../../../shared/models/poster/poster";
import {PosterService} from "../../../core/services/poster/poster.service";

@Component({
  selector: 'app-actor-detail',
  templateUrl: './actor-detail.component.html',
  styleUrls: ['./actor-detail.component.scss']
})
export class ActorDetailComponent implements OnInit {
  actor?: Actor;
  lstMovie: Poster[] | undefined;

  constructor(
    private Actor: ActorService,
    private route: ActivatedRoute,
    private Poster: PosterService,
  ) { }

  ngOnInit(): void {
    this.Actor.getActor(this.route.snapshot.paramMap.get('id')).subscribe(
      data => this.actor = data,
    )

    this.Poster.getByActor(this.route.snapshot.paramMap.get('id')).subscribe(
      data=> this.lstMovie = data,
    )
  }

}
